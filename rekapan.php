<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

$host = "localhost";
$user = "root";
$pass = "";
$db = "surat_tanda";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap Parameter Filter Rentang Waktu (Date Range)
$start_date = isset($_GET['start_date']) ? $conn->real_escape_string($_GET['start_date']) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $conn->real_escape_string($_GET['end_date']) : date('Y-m-t');
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'DESC' : 'ASC';

$sql_data = "SELECT * FROM tanda_terima WHERE DATE(tgl) >= '$start_date' AND DATE(tgl) <= '$end_date' AND (nomor LIKE '%$search%' OR nama_pengirim LIKE '%$search%' OR tujuan LIKE '%$search%') ORDER BY tgl $sort";

$result = $conn->query($sql_data);
$items = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
$total_data = count($items);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapan Tanda Terima</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css?v=3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body class="bg-[#f4f6f9] text-gray-800">

    <div class="flex min-h-screen">
        
        <!-- SIDEBAR -->
        <aside class="w-64 bg-white border-r border-gray-100 flex-shrink-0 fixed h-full z-10 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            <div class="p-6 pb-4 border-b border-gray-50">
                <h1 class="text-2xl font-extrabold text-[#0f172a] tracking-tight">uhm..<span class="text-blue-600">Surat</span></h1>
            </div>
            
            <nav class="p-4 flex flex-col gap-2">
                <a href="index.php" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-900 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Tanda Terima
                </a>
                
                <a href="rekapan.php" class="flex items-center gap-3 px-4 py-3 bg-blue-50 text-blue-700 rounded-xl font-semibold transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Rekapan Laporan
                </a>
            </nav>
        </aside>

        <main class="flex-1 ml-64 p-8">
            <header class="mb-6">
                <h1 class="text-3xl font-extrabold text-[#0f172a]">Rekapan Data</h1>

                    <?php if ($total_data > 0): ?>
                    <div class="mt-6 flex justify-end gap-3">
                        
                        <a href="export.php?start_date=<?= urlencode($start_date) ?>&end_date=<?= urlencode($end_date) ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-6 rounded-xl shadow-md flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Ekspor Excel (CSV)
                        </a>
                    </div>
                    <?php endif; ?>
            </header>
            

            <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 mb-8">
                <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wide border-b pb-2">Filter Periode</h3>
                
                <form action="rekapan.php" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div>
                        <label class="block text-[12px] font-semibold text-gray-500 mb-1.5">Dari Tanggal</label>
                        <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" required class="px-4 py-2 bg-gray-50 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 outline-none">
                    </div>
                    <div>
                        <label class="block text-[12px] font-semibold text-gray-500 mb-1.5">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" required class="px-4 py-2 bg-gray-50 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 outline-none">
                    </div>
                    <div class="flex-1">
                        <label class="block text-[12px] font-semibold text-gray-500 mb-1.5">Pencarian</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari nomor/pengirim..." class="w-full px-4 py-2 bg-gray-50 border rounded-lg text-sm outline-none">
                    </div>
                    <div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-md">Terapkan</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <h2 class="text-sm font-bold text-gray-800">
                        Hasil Filter: <?= date('d M Y', strtotime($start_date)) ?> s/d <?= date('d M Y', strtotime($end_date)) ?>
                    </h2>
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold"><?= $total_data ?> Data</span>
                </div>

                <?php if ($total_data == 0): ?>
                    <div class="p-12 text-center text-gray-500">Tidak ada data di rentang tanggal tersebut.</div>
                <?php else: ?>
                    <div class="overflow-x-auto table-scroll">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead>
                                <tr class="bg-white border-b border-gray-100">
                                    <th class="px-4 py-4 border-b border-gray-100 text-[11px] font-bold text-gray-400 uppercase tracking-wider">NO</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase">FOTO BARANG</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase">PENGIRIMAN</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase">KETERANGAN</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase">TUJUAN</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase">PENERIMA</th>
                                    <th class="px-4 py-3 text-[11px] font-bold text-gray-400 uppercase">FOTO PENERIMA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">

                                <?php $no = 1; foreach ($items as $item): ?>
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-4 py-4 text-sm text-gray-500 align-top pt-5"><?= $no++ ?></td>

                                        <td class="px-4 py-4 align-top">
                                            <?php if(!empty($item['foto_surat']) && file_exists('images/'.$item['foto_surat'])): ?>
                                                <a href="images/<?= $item['foto_surat'] ?>" target="_blank">
                                                    <img src="images/<?= $item['foto_surat'] ?>" class="w-12 h-12 object-cover rounded-lg border">
                                                </a>
                                            <?php else: ?>
                                                <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center border text-[10px] text-gray-40">
                                                    <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-4 align-top">
                                            <div class="text-sm font-bold text-gray-800"><?= htmlspecialchars($item['nomor']) ?></div>
                                            <div class="text-xs text-gray-500">Dari: <?= htmlspecialchars($item['nama_pengirim']) ?></div>
                                            <div class="inline-flex items-center px-2 py-1 mt-1 bg-slate-100 text-slate-600 text-[10px] font-semibold rounded-md border">
                                                <?= date('d M Y', strtotime($item['tgl'])) ?>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 align-top text-sm text-gray-600 max-w-[250px] whitespace-normal">
                                            <?= htmlspecialchars($item['keterangan']) ?>
                                        </td>
                                        
                                        <td class="px-4 py-4 align-top">
                                                <div class="text-sm font-medium text-gray-800 mb-0.5"><?= htmlspecialchars($item['tujuan']) ?></div>
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
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>