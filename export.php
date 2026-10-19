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

$start_date = isset($_GET['start_date']) ? $conn->real_escape_string($_GET['start_date']) : date('Y-m-01');
$end_date = isset($_GET['end_date']) ? $conn->real_escape_string($_GET['end_date']) : date('Y-m-t');
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$sort = isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'ASC' : 'DESC';

$sql_data = "SELECT * FROM tanda_terima WHERE DATE(tgl) >= '$start_date' AND DATE(tgl) <= '$end_date' AND (nomor LIKE '%$search%' OR nama_pengirim LIKE '%$search%' OR tujuan LIKE '%$search%') ORDER BY tgl $sort";

$result = $conn->query($sql_data);

$filename = "Rekap_Tanda_Terima_" . $start_date . "_sd_" . $end_date . ".csv";
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$output = fopen('php://output', 'w');

fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

fputcsv($output, ['NO', 'TANGGAL WAKTU', 'NOMOR SURAT/RESI', 'PENGIRIM', 'KETERANGAN', 'TUJUAN', 'PENERIMA']);

if ($result->num_rows > 0) {
    $no = 1;
    while($row = $result->fetch_assoc()) {
        fputcsv($output, [
            $no++,
            $row['tgl'],
            $row['nomor'],
            $row['nama_pengirim'],
            $row['keterangan'],
            $row['tujuan'],
            $row['nama_penerima']
        ]);
    }
}

fclose($output);
exit();
?>