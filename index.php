<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

$host = "localhost";
$user = "root";
$pass = "";
$db   = "surat_tanda";

mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$redirect_query = [];
if (isset($_POST['selected_search'])) {
    $redirect_query['search'] = $_POST['selected_search'];
}
if (isset($_POST['selected_sort'])) {
    $redirect_query['sort'] = $_POST['selected_sort'];
}
if (isset($_POST['selected_year'])) {
    $redirect_query['year'] = $_POST['selected_year'];
}
if (isset($_POST['selected_bulan'])) {
    $redirect_query['bulan'] = $_POST['selected_bulan'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if (!file_exists('images')) {
            mkdir('images', 0777, true);
        }

        $foto_surat_name = null;
        if (isset($_FILES['foto_surat']) && $_FILES['foto_surat']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto_surat']['name'], PATHINFO_EXTENSION);
            $foto_surat_name = 'surat_' . time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['foto_surat']['tmp_name'], 'images/' . $foto_surat_name);
        }

        $foto_penerima_name = null;
        if (isset($_FILES['foto_penerima']) && $_FILES['foto_penerima']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['foto_penerima']['name'], PATHINFO_EXTENSION);
            $foto_penerima_name = 'penerima_' . time() . '_' . uniqid() . '.' . $ext;
            move_uploaded_file($_FILES['foto_penerima']['tmp_name'], 'images/' . $foto_penerima_name);
        }

   if ($action == 'create') {
            $pesan_foto = "";
            $foto_name = null;
            
            if (!isset($_FILES['foto'])) {
                $pesan_foto = " (Peringatan: Atribut enctype='multipart/form-data' di form HTML Anda sepertinya hilang!)";
            } 
            elseif ($_FILES['foto']['name'] != '') {
                if ($_FILES['foto']['error'] === 0) {
                    if (!file_exists('images')) {
                        mkdir('images', 0777, true);
                    }
                    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    $foto_name = 'bukti_' . time() . '_' . uniqid() . '.' . $ext;
                    
                    if(!move_uploaded_file($_FILES['foto']['tmp_name'], 'images/' . $foto_name)){
                        $pesan_foto = " (Peringatan: Foto gagal dipindahkan! Cek izin folder 'images').";
                        $foto_name = null;
                    }
                } else {
                    $pesan_foto = " (Peringatan: Error kode upload " . $_FILES['foto']['error'] . ").";
                }
            }

            $tanggal_input = $conn->real_escape_string($_POST['tgl']);
            $nomor = $conn->real_escape_string($_POST['nomor']);
            $nama_pengirim = $conn->real_escape_string($_POST['nama_pengirim']);
            $keterangan = $conn->real_escape_string($_POST['keterangan']);
            $tujuan = $conn->real_escape_string($_POST['tujuan']);
            $nama_penerima = $conn->real_escape_string($_POST['nama_penerima']);
            $tanggal_waktu = $tanggal_input . ' ' . date('H:i:s');
            
           $sql = "INSERT INTO tanda_terima (nomor, nama_pengirim, keterangan, tujuan, nama_penerima, foto_surat, foto_penerima, tgl) 
                    VALUES ('$nomor', '$nama_pengirim', '$keterangan', '$tujuan', '$nama_penerima', '$foto_surat_name', '$foto_penerima_name', '$tanggal_waktu')";
            
            if ($conn->query($sql)) {
                $_SESSION['swal'] = ['type' => 'success', 'title' => 'Tersimpan!', 'text' => 'Data berhasil ditambahkan.' . $pesan_foto];
            } else {
                $_SESSION['swal'] = ['type' => 'error', 'title' => 'Gagal!', 'text' => 'Gagal menyimpan data: ' . $conn->error];
            }
        }

        elseif ($action == 'update') {
            $id = $conn->real_escape_string($_POST['id']);
            $tanggal_input = $conn->real_escape_string($_POST['tgl']);
            $nomor = $conn->real_escape_string($_POST['nomor']);
            $nama_pengirim = $conn->real_escape_string($_POST['nama_pengirim']);
            $keterangan = $conn->real_escape_string($_POST['keterangan']);
            $tujuan = $conn->real_escape_string($_POST['tujuan']);
            $nama_penerima = $conn->real_escape_string($_POST['nama_penerima']);
            
            $tanggal_waktu = $tanggal_input . ' ' . date('H:i:s');
            
            // ambil data foto lama
            $old = $conn->query("SELECT foto_surat, foto_penerima FROM tanda_terima WHERE id='$id'")->fetch_assoc();

            $final_foto_surat = $foto_surat_name ? $foto_surat_name : $old['foto_surat'];
            $final_foto_penerima = $foto_penerima_name ? $foto_penerima_name : $old['foto_penerima'];

            // hapus file fisik jika diganti foto baru
            if ($foto_surat_name && !empty($old['foto_surat']) && file_exists('images/' . $old['foto_surat'])) {
                unlink('images/' . $old['foto_surat']);
            }
            if ($foto_penerima_name && !empty($old['foto_penerima']) && file_exists('images/' . $old['foto_penerima'])) {
                unlink('images/' . $old['foto_penerima']);
            }

            $sql = "UPDATE tanda_terima SET 
                    nomor='$nomor', nama_pengirim='$nama_pengirim', keterangan='$keterangan', 
                    tujuan='$tujuan', nama_penerima='$nama_penerima', 
                    foto_surat='$final_foto_surat', foto_penerima='$final_foto_penerima', tgl='$tanggal_waktu' 
                    WHERE id='$id'";
            
            if ($conn->query($sql)) {
                $_SESSION['swal'] = ['type' => 'success', 'title' => 'Diperbarui!', 'text' => 'Data tanda terima berhasil diubah.'];
            }
        }

        elseif ($action == 'delete') {
            $id = $conn->real_escape_string($_POST['id']);
            
            $get_foto = $conn->query("SELECT foto_surat, foto_penerima FROM tanda_terima WHERE id='$id'")->fetch_assoc();
            if(!empty($get_foto['foto_surat']) && file_exists('images/'.$get_foto['foto_surat'])){
                unlink('images/'.$get_foto['foto_surat']);
            }
            if(!empty($get_foto['foto_penerima']) && file_exists('images/'.$get_foto['foto_penerima'])){
                unlink('images/'.$get_foto['foto_penerima']);
            }

            $sql = "DELETE FROM tanda_terima WHERE id = '$id'";
            if ($conn->query($sql)) {
                $_SESSION['swal'] = ['type' => 'success', 'title' => 'Dihapus!', 'text' => 'Data dan foto berhasil dihapus.'];
            }
        }

        // filter
        $url_search = isset($_POST['selected_search']) ? urlencode($_POST['selected_search']) : '';
        $url_sort = isset($_POST['selected_sort']) ? urlencode($_POST['selected_sort']) : 'desc';
        $url_year = isset($_POST['selected_year']) ? urlencode($_POST['selected_year']) : '';
        $url_bulan = isset($_POST['selected_bulan']) ? urlencode($_POST['selected_bulan']) : '';
        $url_limit = isset($_POST['selected_limit']) ? urlencode($_POST['selected_limit']) : '10';
        $url_page = isset($_POST['selected_page']) ? (int)$_POST['selected_page'] : 1;

        header("Location: index.php?search=$url_search&sort=$url_sort&year=$url_year&bulan=$url_bulan&limit=$url_limit&page=$url_page");
        }
}

$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $conn->real_escape_string($_GET['edit_id']);
    $result_edit = $conn->query("SELECT * FROM tanda_terima WHERE id = '$edit_id'");
    if ($result_edit->num_rows > 0) {
        $edit_data = $result_edit->fetch_assoc();
    }
}


$bulan_indonesia = [
    'January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret',
    'April' => 'April', 'May' => 'Mei', 'June' => 'Juni',
    'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September',
    'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'
];

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'ASC' : 'DESC'; 
$selected_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';
$selected_year = isset($_GET['year']) ? $_GET['year'] : '';
$limit_val = isset($_GET['limit']) ? $_GET['limit'] : '10'; 

$sql_data = "SELECT *, DATE_FORMAT(tgl, '%Y-%m') as bulan_tahun, DATE_FORMAT(tgl, '%M %Y') as nama_bulan 
             FROM tanda_terima WHERE 
             (nomor LIKE '%$search%' 
             OR nama_pengirim LIKE '%$search%' 
             OR keterangan LIKE '%$search%' 
             OR tujuan LIKE '%$search%' 
             OR nama_penerima LIKE '%$search%'
             OR DATE(tgl) LIKE '%$search%' 
             OR DATE_FORMAT(tgl, '%d/%m/%Y') LIKE '%$search%')
             ORDER BY tgl $sort";

$result = $conn->query($sql_data);

$data_per_bulan = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $key_bulan = $row['bulan_tahun'];
        $data_per_bulan[$key_bulan][] = $row;
    }
}

$bulan_urut = array_keys($data_per_bulan);
sort($bulan_urut);
$years = array_values(array_unique(array_map(fn($bulan) => substr($bulan, 0, 4), $bulan_urut)));
rsort($years);

if (empty($bulan_urut)) {
    $selected_bulan = '';
    $selected_year = '';
} else {
    $selected_year = $selected_year && in_array($selected_year, $years, true) ? $selected_year : $years[0];

    $bulan_di_tahun = array_values(array_filter($bulan_urut, fn($bulan) => substr($bulan, 0, 4) == $selected_year));
    sort($bulan_di_tahun);

    if (!$selected_bulan || !isset($data_per_bulan[$selected_bulan]) || substr($selected_bulan, 0, 4) != $selected_year) {
        $selected_bulan = end($bulan_di_tahun);
    }

    $selected_index = array_search($selected_bulan, $bulan_di_tahun);
    $prev_bulan = $selected_index > 0 ? $bulan_di_tahun[$selected_index - 1] : null;
    $next_bulan = $selected_index !== false && $selected_index < count($bulan_di_tahun) - 1 ? $bulan_di_tahun[$selected_index + 1] : null;
}


$query_total = $conn->query("SELECT COUNT(*) AS total FROM tanda_terima");
$total_data = $query_total->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css?v=3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
       
    </style>
</head>
<body class="text-gray-800">


    <div class="flex min-h-screen">
        
        <!-- sidebar -->
        <aside class="w-64 bg-white border-r border-gray-100 flex-shrink-0 fixed h-full z-10 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <div class="p-6 pb-4 border-b border-gray-50">
                <h1 class="text-2xl font-extrabold text-[#0f172a] tracking-tight">uhm..<span class="text-blue-600">Surat</span></h1>
            </div>
            
            <nav class="p-4 flex flex-col gap-2">
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Tanda Terima
                </a>
                
                <a href="rekapan.php" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Rekapan Laporan
                </a>
            </nav>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <header class="mb-6">
                <h1 class="text-3xl font-extrabold text-[#0f172a]">Tanda Terima</h1>
            </header>
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 item-start">

            <!-- KOLOM KIRI -->
            <section class="lg:col-span-4 xl:col-span-3 mb-auto bg-white rounded-[24px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100/50">
                <div class="mb-6 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">
                        <?= $edit_data ? 'Edit Tanda Terima' : 'Tambah Tanda Terima' ?>
                    </h2>
                    <?php if($edit_data): ?>
                        <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= urlencode($selected_year) ?>&bulan=<?= urlencode($selected_bulan) ?>&limit=<?= urlencode($limit_val) ?>" class="text-xs font-semibold text-red-500 hover:underline">Batal Edit</a>
                    <?php endif; ?>
                </div>
                
                <form id="form-crud" action="index.php" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4" <?= $edit_data ? 'onsubmit="event.preventDefault(); confirmAction(\'update\');"' : '' ?>>
                    <input type="hidden" name="selected_page" value="<?= $page ?>">
                    <input type="hidden" name="action" value="<?= $edit_data ? 'update' : 'create' ?>">
                    <input type="hidden" name="selected_search" value="<?= htmlspecialchars($search ?? '') ?>">
                    <input type="hidden" name="selected_sort" value="<?= htmlspecialchars($sort ?? 'desc') ?>">
                    <input type="hidden" name="selected_year" value="<?= htmlspecialchars($selected_year ?? '') ?>">
                    <input type="hidden" name="selected_bulan" value="<?= htmlspecialchars($selected_bulan ?? '') ?>">
                    <input type="hidden" name="selected_limit" value="<?= htmlspecialchars($limit_val ?? '10') ?>">

                    <?php if($edit_data): ?>
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <?php endif; ?>
                    
                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Tanggal</label>
                        <input type="date" name="tgl" value="<?= $edit_data ? date('Y-m-d', strtotime($edit_data['tgl'])) : date('Y-m-d') ?>" required class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Nomor Surat/Resi</label>
                        <input type="text" name="nomor" maxlength="50" value="<?= htmlspecialchars($edit_data['nomor'] ?? '') ?>" placeholder="Contoh: SR-001/2026" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 outline-none">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Nama Pengirim</label>
                        <input type="text" name="nama_pengirim" value="<?= htmlspecialchars($edit_data['nama_pengirim'] ?? '') ?>" placeholder="Nama pengirim/instansi" required class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none">
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Keterangan Surat/Barang</label>
                        <textarea name="keterangan" rows="2" required class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none resize-none"><?= htmlspecialchars($edit_data['keterangan'] ?? '') ?></textarea>
                    </div>

                    <div>
                        <label class="block text-[13px] font-medium text-gray-600 mb-1.5">Tujuan & Penerima</label>
                        <div class="flex gap-2">
                            <input type="text" name="tujuan" value="<?= htmlspecialchars($edit_data['tujuan'] ?? '') ?>" placeholder="Divisi/Dept"  class="w-1/2 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none">
                            <input type="text" name="nama_penerima" value="<?= htmlspecialchars($edit_data['nama_penerima'] ?? '') ?>" placeholder="Nama Penerima" required class="w-1/2 px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none">
                        </div>
                    </div>

                    <!-- up foto -->
                                        
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-1">
        
                        <div class="bg-white text-slate-600 rounded-xl border border-slate-200 p-3 flex flex-col items-center justify-between text-center relative">
                            <span class="text-[11px] font-bold text-gray-600 mb-2">📄 Foto Surat / Barang</span>
                            
                            <div id="preview-surat" class="w-full h-24 bg-gray-50 rounded-lg flex flex-col items-center justify-center border border-dashed border-gray-300 overflow-hidden mb-2">
                                <?php if(!empty($edit_data['foto_surat']) && file_exists('images/'.$edit_data['foto_surat'])): ?>
                                    <img src="images/<?= $edit_data['foto_surat'] ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] text-gray-400">Belum ada foto</span>
                                <?php endif; ?>
                            </div>

                            <label for="fotoSurat" class="w-full py-1.5 px-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 rounded-lg text-xs font-semibold cursor-pointer transition-colors">
                                Pilih Foto Surat
                                <input type="file" name="foto_surat" id="fotoSurat" accept="image/*" class="sr-only" <?= ($edit_data && !empty($edit_data['foto_surat'])) ? '' : 'required' ?> />
                            </label>
                        </div>

                        <div class="bg-white text-slate-600 rounded-xl border border-slate-200 p-3 flex flex-col items-center justify-between text-center relative">
                            <span class="text-[11px] font-bold text-gray-600 mb-2">👤 Foto Penerima</span>
                            
                            <div id="preview-penerima" class="w-full h-24 bg-gray-50 rounded-lg flex flex-col items-center justify-center border border-dashed border-gray-300 overflow-hidden mb-2">
                                <?php if(!empty($edit_data['foto_penerima']) && file_exists('images/'.$edit_data['foto_penerima'])): ?>
                                    <img src="images/<?= $edit_data['foto_penerima'] ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    <span class="text-[10px] text-gray-400">Belum ada foto</span>
                                <?php endif; ?>
                            </div>

                            <label for="fotoPenerima" class="w-full py-1.5 px-2 bg-blue-50 hover:bg-blue-100 text-blue-600 border border-blue-200 rounded-lg text-xs font-semibold cursor-pointer transition-colors">
                                Pilih Foto Penerima
                                <input type="file" name="foto_penerima" id="fotoPenerima" accept="image/*" class="sr-only" <?= ($edit_data && !empty($edit_data['foto_penerima'])) ? '' : '' ?> />
                            </label>
                        </div>

                    </div>

                    <div class="mt-2">
                        <button type="submit" class="w-full bg-[#2563eb] hover:bg-[#1d4ed8] text-white font-semibold py-3 px-6 rounded-xl transition-all shadow-[0_4px_12px_rgba(37,99,235,0.3)] active:scale-[0.98]">
                            <?= $edit_data ? 'Update Data' : 'Simpan Data' ?>
                        </button>
                    </div>
                </form>
            </section>

            <!-- kolom kanan :tabel & filter -->
            <section class="lg:col-span-8 xl:col-span-9 flex flex-col gap-6">

                <div class="bg-white p-5 rounded-[20px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100/50">
                    
                    <div class="flex items-center justify-between mb-5 pb-4 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800">Cari & Filter Data</h2>
                        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-bold tracking-wide">
                            <?= number_format($total_data ?? 0, 0, ',', '.') ?> Data 
                        </span>
                    </div>

                    <form action="index.php" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                        <input type="hidden" name="page" value="1">
                        <input type="hidden" name="year" value="<?= htmlspecialchars($selected_year ?? '') ?>">
                        <input type="hidden" name="bulan" value="<?= htmlspecialchars($selected_bulan ?? '') ?>">
                        
                        <div class="flex-1 w-full">
                            <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Pencarian</label>
                            <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Cari nomor surat, nama..." class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                        </div>
                        <div class="w-full md:w-48">
                            <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Urutkan</label>
                            <select name="sort" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                                <option value="desc" <?= (isset($sort) && $sort == 'DESC') ? 'selected' : '' ?>>Terbaru</option>
                                <option value="asc" <?= (isset($sort) && $sort == 'ASC') ? 'selected' : '' ?>>Terlama</option>
                            </select>
                        </div>
                        <div class="w-full md:w-32">
                            <label class="block text-xs font-semibold uppercase tracking-wide text-gray-500 mb-1.5">Tampilkan</label>
                            <select name="limit" class="block w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none">
                                <option value="10" <?= $limit_val == '10' ? 'selected' : '' ?>>10 Baris</option>
                                <option value="20" <?= $limit_val == '20' ? 'selected' : '' ?>>20 Baris</option>
                                <option value="50" <?= $limit_val == '50' ? 'selected' : '' ?>>50 Baris</option>
                                <option value="100" <?= $limit_val == '100' ? 'selected' : '' ?>>100 Baris</option>
                                <option value="all" <?= $limit_val == 'all' ? 'selected' : '' ?>>Semua</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2.5 px-6 rounded-xl transition-colors shadow-sm">Filter</button>
                            <?php if(!empty($search)): ?>
                                <a href="index.php?year=<?= urlencode($selected_year) ?>&bulan=<?= urlencode($selected_bulan) ?>&limit=<?= urlencode($limit_val) ?>" class="px-4 py-2.5 text-sm font-medium text-blue-600 hover:bg-blue-50 rounded-xl transition-colors">Reset</a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <!-- filter bulan/tahun -->
                    <?php if (!empty($years) && !empty($data_per_bulan)): ?>
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">Tahun:</span>
                                <?php foreach ($years as $year): ?>
                                    <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= urlencode($year) ?>&limit=<?= urlencode($limit_val) ?>"
                                       class="px-3 py-1 text-[13px] font-medium rounded-lg transition-all <?= (isset($selected_year) && $selected_year == $year) ? 'bg-gray-800 text-white shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">
                                        <?= $year ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold uppercase tracking-wide text-gray-400">Bulan:</span>
                                <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-lg">
                                    <?php if (isset($prev_bulan)): ?>
                                        <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= substr($prev_bulan, 0, 4) ?>&bulan=<?= $prev_bulan ?>&limit=<?= urlencode($limit_val) ?>" class="px-2 py-1 text-xs font-medium text-gray-600 hover:bg-white hover:shadow-sm rounded transition-all">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/>Previous</svg>
                                        </a>
                                    <?php endif; ?>
                                    <span class="px-3 py-1 text-[13px] font-semibold text-gray-800 bg-white shadow-sm rounded">
                                        <?= $bulan_indonesia[date('F', strtotime($selected_bulan . '-01'))] ?? 'Bulan' ?>
                                    </span>
                                    <?php if (isset($next_bulan)): ?>
                                        <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= substr($next_bulan, 0, 4) ?>&bulan=<?= $next_bulan ?>&limit=<?= urlencode($limit_val) ?>" class="px-2 py-1 text-xs font-medium text-gray-600 hover:bg-white hover:shadow-sm rounded transition-all">
                                            <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/>Next</svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- card tabel -->
                <?php if (empty($data_per_bulan) || !isset($selected_bulan) || empty($data_per_bulan[$selected_bulan])): ?>
                    <div class="bg-white rounded-[24px] p-12 text-center shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100/50 flex flex-col items-center justify-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <p class="text-gray-500 font-medium">Tidak ada data tanda terima yang ditemukan.</p>
                    </div>
                <?php else: ?>
                    <div class="bg-white rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100/50 overflow-hidden">
                        
                        <?php 
                            $items = $data_per_bulan[$selected_bulan] ?? []; 
                            $total_items_bulan = count($items);

                            $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

                            if ($limit_val === 'all') {
                                $per_page = $total_items_bulan > 0 ? $total_items_bulan : 1;
                                $total_pages = 1;
                                $page = 1;
                                $offset = 0;
                                $items_to_display = $items;
                                $start_no = 1;
                            } else {
                                $per_page = (int)$limit_val;
                                $total_pages = max(1, (int)ceil($total_items_bulan / $per_page));
                                if ($page > $total_pages) $page = $total_pages;

                                $offset = ($page - 1) * $per_page;
                                $items_to_display = array_slice($items, $offset, $per_page);
                                
                                $start_no = $offset + 1;
                            }

                            $end_no = min($offset + count($items_to_display), $total_items_bulan);
                        ?>
                        
                        <!-- header -->
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-lg font-bold text-gray-800">Daftar Tanda Terima</h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold">
                                Menampilkan <?= count($items_to_display) ?> dari <?= count($items) ?>
                            </span>
                        </div>

                        <!-- tabel -->
                        <div class="overflow-x-auto table-scroll px-2">
                            <table class="w-full text-left border-collapse whitespace-nowrap">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">NO</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-center">FOTO</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">DETAIL PENGIRIMAN</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">KETERANGAN</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">TUJUAN</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">PENERIMA</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">FOTO PENERIMA</th>
                                        <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider text-center">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = $start_no; foreach ($items_to_display as $item): ?>
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-4 py-4 text-sm text-gray-500 align-top pt-5"><?= $no++ ?></td>
                                            
                                            <td class="px-4 py-4 align-top text-center pt-5">
                                                <?php if(!empty($item['foto_surat']) && file_exists('images/'.$item['foto_surat'])): ?>
                                                    <a href="images/<?= $item['foto_surat'] ?>" target="_blank" title="Klik untuk memperbesar">
                                                        <img src="images/<?= $item['foto_surat'] ?>" class="w-14 h-14 object-cover rounded-lg border border-gray-200 mx-auto hover:scale-105 transition-transform shadow-sm">
                                                    </a>
                                                <?php else: ?>
                                                    <div class="w-14 h-14 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200 mx-auto">
                                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <td class="px-4 py-4 align-top">
                                                <div class="text-sm font-bold text-gray-800 mb-0.5">
                                                    <?= !empty(trim($item['nomor'] ?? '')) ? htmlspecialchars($item['nomor']) : '- -' ?>
                                                </div>
                                                <div class="text-xs text-gray-500">Dari: <?= htmlspecialchars($item['nama_pengirim']) ?></div>
                                                <div class="inline-flex items-center px-2 py-1 mt-2 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded-md border border-slate-200">
                                                    <svg class="w-3 h-3 mr-1 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    <?= date('d M Y', strtotime($item['tgl'])) ?>
                                                </div>                                     
                                            </td>

                                            <td class="px-4 py-4 align-top max-w-[200px] truncate text-sm text-gray-600 pt-5">
                                                <?= htmlspecialchars($item['keterangan']) ?>
                                            </td>

                                            <td class="px-4 py-4 align-top">
                                                <div class="text-sm font-medium text-gray-800 mb-0.5">
                                                    <?= !empty(trim($item['tujuan'] ?? '')) ? htmlspecialchars($item['tujuan']) : '- -' ?>
                                                </div>
                                            </td>

                                            <td class="px-4 py-4 align-top">
                                                <div class="text-xs text-gray-500"><?= htmlspecialchars($item['nama_penerima']) ?></div>
                                            </td>

                                            <td class="px-4 py-4 align-top text-center pt-5">
                                                <?php if(!empty($item['foto_penerima']) && file_exists('images/'.$item['foto_penerima'])): ?>
                                                    <a href="images/<?= $item['foto_penerima'] ?>" target="_blank" title="Klik untuk memperbesar">
                                                        <img src="images/<?= $item['foto_penerima'] ?>" class="w-14 h-14 object-cover rounded-lg border border-gray-200 mx-auto hover:scale-105 transition-transform shadow-sm">
                                                    </a>
                                                <?php else: ?>
                                                    <div class="w-14 h-14 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200 mx-auto">
                                                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                            <td class="px-4 py-4 align-top text-right pr-6 pt-4">
                                                <div class="flex items-center justify gap-2">
                                                    <a href="index.php?edit_id=<?= $item['id'] ?>&search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= urlencode($selected_year) ?>&bulan=<?= urlencode($selected_bulan) ?>&limit=<?= urlencode($limit_val) ?>" class="inline-flex items-center justify-center w-8 h-8 rounded bg-blue-50 text-blue-500 hover:bg-blue-100 transition-colors" title="Edit Data">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    
                                                    <form id="delete-form-<?= $item['id'] ?>" action="index.php" method="POST" class="hidden">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                        <input type="hidden" name="selected_search" value="<?= htmlspecialchars($search ?? '') ?>">
                                                        <input type="hidden" name="selected_sort" value="<?= strtolower($sort ?? 'desc') ?>">
                                                        <input type="hidden" name="selected_year" value="<?= htmlspecialchars($selected_year ?? '') ?>">
                                                        <input type="hidden" name="selected_bulan" value="<?= htmlspecialchars($selected_bulan ?? '') ?>">
                                                        <input type="hidden" name="selected_limit" value="<?= htmlspecialchars($limit_val ?? '10') ?>">
                                                    </form>

                                                    <button type="button" onclick="confirmAction('delete', <?= $item['id'] ?>)" class="inline-flex items-center justify-center w-8 h-8 rounded bg-red-50 text-red-500 hover:bg-red-100 transition-colors" title="Hapus">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>

                                                </div>
                                            </td>
                                        </tr>
                                        
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- footer tabel -->
                        <?php if ($total_pages > 1 || $limit_val !== 'all'): ?>
                        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                            
                            <div class="text-xs text-gray-500 font-medium">
                                Menampilkan <span class="font-bold text-gray-800"><?= $total_items_bulan > 0 ? $start_no : 0 ?></span> - <span class="font-bold text-gray-800"><?= $end_no ?></span> dari <span class="font-bold text-gray-800"><?= $total_items_bulan ?></span> data
                            </div>

                            <?php if ($total_pages > 1): ?>
                            <div class="flex items-center gap-1">
                                
                                <!-- prev page -->
                                <?php if ($page > 1): ?>
                                    <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= urlencode($selected_year) ?>&bulan=<?= urlencode($selected_bulan) ?>&limit=<?= urlencode($limit_val) ?>&page=<?= $page - 1 ?>" 
                                       class="px-3 py-1.5 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition-all flex items-center gap-1 shadow-sm">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                <?php else: ?>
                                    <span class="px-3 py-1.5 text-xs font-semibold text-gray-300 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed flex items-center gap-1">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                    </span>
                                <?php endif; ?>

                                <div class="flex items-center gap-1 px-1">
                                    <?php
                                    $start_page = max(1, $page - 2);
                                    $end_page = min($total_pages, $page + 2);

                                    if ($start_page > 1) {
                                        echo '<a href="index.php?search='.urlencode($search).'&sort='.strtolower($sort).'&year='.urlencode($selected_year).'&bulan='.urlencode($selected_bulan).'&limit='.urlencode($limit_val).'&page=1" class="w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">1</a>';
                                        if ($start_page > 2) echo '<span class="text-xs text-gray-400 px-1">...</span>';
                                    }

                                    for ($p = $start_page; $p <= $end_page; $p++):
                                    ?>
                                        <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= urlencode($selected_year) ?>&bulan=<?= urlencode($selected_bulan) ?>&limit=<?= urlencode($limit_val) ?>&page=<?= $p ?>" 
                                           class="w-8 h-8 flex items-center justify-center text-xs font-bold rounded-full transition-all <?= $p == $page ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-100' ?>">
                                            <?= $p ?>
                                        </a>
                                    <?php endfor; ?>

                                    <?php
                                    if ($end_page < $total_pages) {
                                        if ($end_page < $total_pages - 1) echo '<span class="text-xs text-gray-400 px-1">...</span>';
                                        echo '<a href="index.php?search='.urlencode($search).'&sort='.strtolower($sort).'&year='.urlencode($selected_year).'&bulan='.urlencode($selected_bulan).'&limit='.urlencode($limit_val).'&page='.$total_pages.'" class="w-8 h-8 flex items-center justify-center text-xs font-semibold rounded-full bg-white border border-gray-200 text-gray-600 hover:bg-gray-100">'.$total_pages.'</a>';
                                    }
                                    ?>
                                </div>

                                <!-- next page -->
                                <?php if ($page < $total_pages): ?>
                                    <a href="index.php?search=<?= urlencode($search) ?>&sort=<?= strtolower($sort) ?>&year=<?= urlencode($selected_year) ?>&bulan=<?= urlencode($selected_bulan) ?>&limit=<?= urlencode($limit_val) ?>&page=<?= $page + 1 ?>" 
                                       class="px-3 py-1.5 text-xs font-semibold text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition-all flex items-center gap-1 shadow-sm">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                    </a>
                                <?php else: ?>
                                    <span class="px-3 py-1.5 text-xs font-semibold text-gray-300 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed flex items-center gap-1">
                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                    </span>
                                <?php endif; ?>

                                <div class="flex items-center gap-1.5 pl-2 ml-1 border-l border-gray-200">
                                    <span class="text-xs text-gray-500 font-medium">Ke:</span>
                                    <input type="number" id="goto-page-input" min="1" max="<?= $total_pages ?>" value="<?= $page ?>" onkeydown="if(event.key==='Enter') jumpToPage()" class="w-14 px-2 py-1 text-xs font-bold text-center bg-white border border-gray-200 rounded-lg outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 shadow-sm">
                                    <button type="button" onclick="jumpToPage()" class="px-2.5 py-1 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200/60 rounded-lg transition-colors">
                                        Go
                                    </button>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                </div>
                
            </section>
        </main>
    </div>

    <!-- SweetAlert konfirmasi -->
    <script>
        function confirmAction(type, id = null) {
            let title = type === 'delete' ? 'Yakin Hapus Data?' : 'Simpan Perubahan?';
            let text = type === 'delete' ? 'Data ini tidak dapat dikembalikan!' : 'Pastikan data sudah benar.';
            let icon = type === 'delete' ? 'warning' : 'question';
            let btnText = type === 'delete' ? 'Ya, Hapus!' : 'Ya, Update!';
            let btnColor = type === 'delete' ? '#ef4444' : '#2563eb';

            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: btnColor,
                cancelButtonColor: '#64748b',
                confirmButtonText: btnText,
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-2xl' }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (type === 'delete') {
                        document.getElementById('delete-form-' + id).submit();
                    } else {
                        document.getElementById('form-crud').submit();
                    }
                }
            });
        }
    </script>

    <!-- feedback -->
    <?php if (isset($_SESSION['swal'])): ?>
        <script>
            Swal.fire({
                icon: '<?= $_SESSION['swal']['type'] ?>',
                title: '<?= $_SESSION['swal']['title'] ?>',
                text: '<?= $_SESSION['swal']['text'] ?>',
                timer: 3000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-2xl'
                }
            });
        </script>
        <?php unset($_SESSION['swal']); ?>
    <?php endif; ?>

    <!-- live preview gambar -->
    <script>
        document.getElementById('uploadFile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const defaultContent = document.getElementById('default-upload-content');
            const previewContainer = document.getElementById('preview-container');
            const oldPhoto = document.getElementById('old-photo-container');

            if (file) {
                // 1. Sembunyikan ikon awan dan form lama
                defaultContent.classList.add('hidden');
                if (oldPhoto) oldPhoto.classList.add('hidden');
                
                // 2. Tampilkan area preview
                previewContainer.classList.remove('hidden');
                
                // 3. Render gambar dan detail file
                const fileURL = URL.createObjectURL(file);
                const fileSize = (file.size / 1024).toFixed(1); // Ukuran ke KB
                
                previewContainer.innerHTML = `
                    <div class="relative w-full flex flex-col items-center animate-pulse-short">
                        <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-[10px] font-bold mb-3 border border-emerald-200">✓ Siap Diupload</span>
                        <img src="${fileURL}" class="h-28 w-auto object-cover rounded-lg border border-slate-200 shadow-sm mb-2" />
                        <p class="text-[11px] font-bold text-slate-700 truncate w-full text-center px-4">${file.name}</p>
                        <p class="text-[10px] text-slate-500 mb-3">${fileSize} KB</p>
                        
                        <label for="uploadFile" class="py-1.5 px-4 bg-white border border-slate-300 text-slate-600 rounded-md text-xs font-semibold cursor-pointer hover:bg-slate-50 shadow-sm transition-all">
                            Ganti File
                        </label>
                    </div>
                `;
            } else {
                defaultContent.classList.remove('hidden');
                previewContainer.classList.add('hidden');
                if (oldPhoto) oldPhoto.classList.remove('hidden');
            }
        });
    </script>

    <script>
    function setupPreview(inputId, previewContainerId) {
        document.getElementById(inputId).addEventListener('change', function(e) {
            const file = e.target.files[0];
            const container = document.getElementById(previewContainerId);
            
            if (file) {
                const url = URL.createObjectURL(file);
                container.innerHTML = `<img src="${url}" class="w-full h-full object-cover animate-fade-in">`;
            }
        });
    }

    setupPreview('fotoSurat', 'preview-surat');
    setupPreview('fotoPenerima', 'preview-penerima');
</script>

<script>
    function jumpToPage() {
        const input = document.getElementById('goto-page-input');
        let targetPage = parseInt(input.value);
        const maxPages = <?= $total_pages ?>;

        if (isNaN(targetPage) || targetPage < 1) {
            targetPage = 1;
        } else if (targetPage > maxPages) {
            targetPage = maxPages;
        }

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('page', targetPage);
        
        window.location.search = urlParams.toString();
    }
</script>
</body>
</html>