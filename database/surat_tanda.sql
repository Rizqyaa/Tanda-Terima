-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Okt 2026 pada 00.19
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat_tanda`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tanda_terima`
--

CREATE TABLE `tanda_terima` (
  `id` int NOT NULL,
  `nomor` varchar(50) NOT NULL,
  `nama_pengirim` varchar(100) NOT NULL,
  `keterangan` text NOT NULL,
  `tujuan` varchar(100) NOT NULL,
  `nama_penerima` varchar(100) NOT NULL,
  `foto_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `foto_penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `tanda_terima`
--

INSERT INTO `tanda_terima` (`id`, `nomor`, `nama_pengirim`, `keterangan`, `tujuan`, `nama_penerima`, `foto_surat`, `foto_penerima`, `tgl`) VALUES
(1, 'SR-101/2026', 'JNE Express', 'Paket Dokumen', 'HRD', 'Nisa', NULL, '', '2026-10-15 01:05:00'),
(2, 'SR-102/2026', 'PT Maju Bersama siapa?', 'Invoice Pembelian ATK', 'Keuangan', 'Siti Aminah', 'surat_1792138092_6ad1db6c6f381.png', 'penerima_1792138092_6ad1db6c6fea5.jpg', '2026-10-15 08:08:12'),
(3, 'SR-103/2026', 'Budi (Kurir)', 'Paket Sampel', 'Marketing', 'Dina', NULL, '', '2026-10-15 01:18:00'),
(4, 'SR-104/2026', 'Kantor Pos', 'Surat Edaran', 'Direksi', 'Maya', NULL, '', '2026-10-15 01:25:00'),
(5, 'SR-105/2026', 'CV Karya Indah', 'Dokumen Kontrak', 'Legal', 'Rina Marlina', NULL, '', '2026-10-15 01:31:00'),
(6, 'SR-106/2026', 'Grab Express', 'Kue Rapat', 'Sekretaris', 'Maya', NULL, '', '2026-10-15 01:40:00'),
(7, 'SR-107/2026', 'PT Sentosa Abadi', 'Katalog Produk', 'Pengadaan', 'Joko Susilo', NULL, '', '2026-10-15 01:45:00'),
(8, 'SR-108/2026', 'Gojek (Gosend)', 'Dokumen Tender', 'Marketing', 'Andi Wijaya', NULL, '', '2026-10-15 01:52:00'),
(9, 'SR-109/2026', 'Bank BCA', 'Buku Rekening Baru', 'Keuangan', 'Siti Aminah', NULL, '', '2026-10-15 01:58:00'),
(10, 'SR-110/2026', 'Tiki Express', 'Seragam Karyawan', 'HRD', 'Nisa', NULL, '', '2026-10-15 02:05:00'),
(11, 'SR-111/2026', 'Wahana Express', 'Paket Buku', 'Perpustakaan', 'Sinta', NULL, '', '2026-10-15 02:12:00'),
(12, 'SR-112/2026', 'PT Indo Global', 'Sampel B', 'R&D', 'Faisal', NULL, '', '2026-10-15 02:18:00'),
(13, 'SR-001/2025', 'PT Maju Bersama', 'Invoice Pembelian ATK', 'Keuangan', 'Siti Aminah', NULL, '', '2025-11-10 02:15:00'),
(14, 'SR-002/2025', 'Budi Prakoso', 'Paket Barang Sampel', 'Marketing', 'Andi Wijaya', NULL, '', '2025-11-12 07:20:00'),
(15, 'SR-003/2025', 'CV Karya Indah', 'Dokumen Kontrak Kerjasama', 'Legal', 'Rina Marlina', NULL, '', '2025-12-05 03:00:00'),
(16, 'SR-004/2025', 'Dinas Pendapatan', 'Surat Pemberitahuan Pajak', 'Direksi', 'Bapak Direktur', NULL, '', '2025-12-15 04:30:00'),
(17, 'SR-005/2025', 'PT Sentosa Abadi', 'Katalog Produk Terbaru', 'Pengadaan', 'Joko Susilo', NULL, '', '2025-12-20 08:45:00'),
(18, 'SR-001/2026', 'JNE Express', 'Paket Karyawan', 'HRD', 'Nisa', NULL, '', '2026-01-05 06:00:00'),
(19, 'SR-002/2026', 'PT Citra Nusa', 'Tagihan Internet', 'Keuangan', 'Siti Aminah', NULL, '', '2026-01-10 02:00:00'),
(20, 'SR-003/2026', 'Bank BCA', 'Buku Rekening Perusahaan', 'Keuangan', 'Siti Aminah', NULL, '', '2026-01-15 03:15:00'),
(21, 'SR-004/2026', 'Budi (Kurir)', 'Dokumen Penawaran', 'Marketing', 'Dina', NULL, '', '2026-02-02 04:00:00'),
(22, 'SR-005/2026', 'PT Indo Global', 'Sampel Produk A', 'R&D', 'Faisal', NULL, '', '2026-02-14 07:30:00'),
(23, 'SR-006/2026', 'Kantor Pajak', 'Surat Edaran', 'Pajak', 'Rini', NULL, '', '2026-02-20 01:45:00'),
(24, 'TJMI/INV/2026/X/0586', 'PT TJM Internasional', 'Invoice', 'Akuntansi Verifikator', 'Mira', NULL, '', '2026-10-15 03:33:12'),
(33, 'da', 'dlsa', 'fhoua', 'fnja', 'salkjd', 'bukti_1792050117_6ad083c56d621.webp', '', '2026-10-15 07:41:57'),
(45, 'dsa', 'dw', 'dw', 'fea', 'hudw', 'bukti_1792124353_6ad1a5c14ced0.png', '', '2026-10-16 04:19:13'),
(46, 's', 'cdsa', 'fsa', 'fsa', 'sa', 'surat_1792380648_6ad58ee8ad9e6.jpg', 'penerima_1792372118_6ad56d96ad874.jpg', '2026-10-16 03:30:48'),
(47, 'k', 'j', 'j', 'h', 'k', 'surat_1792137444_6ad1d8e475883.webp', 'penerima_1792137444_6ad1d8e4770ab.png', '2026-10-16 07:57:24'),
(49, 'dsksladjo', 'd', 'dw\r\n', '', 'dw', 'surat_1792369614_6ad563ce311bd.png', 'penerima_1792369614_6ad563ce31e2b.jpg', '2026-10-19 01:01:29'),
(50, 'SR-101/2026', 'JNE Express', 'Paket Dokumen', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 01:05:00'),
(51, 'SR-102/2026', 'PT Maju Bersama', 'Invoice Pembelian ATK', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 01:12:00'),
(52, 'SR-103/2026', 'Budi (Kurir)', 'Paket Sampel', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 01:18:00'),
(53, 'SR-104/2026', 'Kantor Pos', 'Surat Edaran', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 01:25:00'),
(54, 'SR-105/2026', 'CV Karya Indah', 'Dokumen Kontrak', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 01:31:00'),
(55, 'SR-106/2026', 'Grab Express', 'Kue Rapat', 'Sekretaris', 'Maya', NULL, NULL, '2026-10-15 01:40:00'),
(56, 'SR-107/2026', 'PT Sentosa Abadi', 'Katalog Produk', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-10-15 01:45:00'),
(57, 'SR-108/2026', 'Gojek (Gosend)', 'Dokumen Tender', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-10-15 01:52:00'),
(58, 'SR-109/2026', 'Bank BCA', 'Buku Rekening Baru', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 01:58:00'),
(59, 'SR-110/2026', 'Tiki Express', 'Seragam Karyawan', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 02:05:00'),
(60, 'SR-111/2026', 'Wahana Express', 'Paket Buku', 'Perpustakaan', 'Sinta', NULL, NULL, '2026-10-15 02:12:00'),
(61, 'SR-112/2026', 'PT Indo Global', 'Sampel B', 'R&D', 'Faisal', NULL, NULL, '2026-10-15 02:18:00'),
(62, 'SR-113/2026', 'Kantor Pajak', 'Surat Pemberitahuan', 'Pajak', 'Rini', NULL, NULL, '2026-10-15 02:25:00'),
(63, 'SR-114/2026', 'CV Sukses Makmur', 'Invoice No. 5678', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 02:32:00'),
(64, 'SR-115/2026', 'Telkomsel', 'Tagihan Halo', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 02:38:00'),
(65, 'SR-116/2026', 'PT Bangun Persada', 'Draft Kontrak Vendor', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 02:45:00'),
(66, 'SR-117/2026', 'Universitas Terbuka', 'Surat Undangan', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 02:52:00'),
(67, 'SR-118/2026', 'PT Sejahtera', 'Klaim Asuransi', 'HRD', 'Bambang', NULL, NULL, '2026-10-15 02:58:00'),
(68, 'SR-119/2026', 'PT Aneka Tambang', 'Laporan Bulanan', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 03:05:00'),
(69, 'SR-120/2026', 'CV Bintang Terang', 'Katalog Sparepart', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-10-15 03:12:00'),
(70, 'SR-121/2026', 'J&T Express', 'Paket Hadiah', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 03:18:00'),
(71, 'SR-122/2026', 'BPJS Kesehatan', 'Tagihan Bulanan', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 03:25:00'),
(72, 'SR-123/2026', 'BPJS Ketenagakerjaan', 'Sertifikat', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 03:32:00'),
(73, 'SR-124/2026', 'PT Bumi Karsa', 'Dokumen Proyek', 'Proyek', 'Eko', NULL, NULL, '2026-10-15 03:38:00'),
(74, 'SR-125/2026', 'Shopee Express', 'Perlengkapan Event', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 03:45:00'),
(75, 'SR-126/2026', 'PT Media Nusantara', 'Majalah Bisnis', 'Lobby', 'Resepsionis', NULL, NULL, '2026-10-15 03:52:00'),
(76, 'SR-127/2026', 'Kementerian Perdagangan', 'Surat Izin', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 03:58:00'),
(77, 'SR-128/2026', 'CV Cipta Pesona', 'Brosur Promosi', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-10-15 04:05:00'),
(78, 'SR-129/2026', 'Anteraja', 'Paket Dokumen', 'IT', 'Reza', NULL, NULL, '2026-10-15 04:12:00'),
(79, 'SR-101/2026', 'JNE Express', 'Paket Dokumen', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 01:05:00'),
(80, 'SR-102/2026', 'PT Maju Bersama', 'Invoice Pembelian ATK', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 01:12:00'),
(81, 'SR-103/2026', 'Budi (Kurir)', 'Paket Sampel', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 01:18:00'),
(82, 'SR-104/2026', 'Kantor Pos', 'Surat Edaran', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 01:25:00'),
(83, 'SR-105/2026', 'CV Karya Indah', 'Dokumen Kontrak', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 01:31:00'),
(84, 'SR-106/2026', 'Grab Express', 'Kue Rapat', 'Sekretaris', 'Maya', NULL, NULL, '2026-10-15 01:40:00'),
(85, 'SR-101/2026', 'JNE Express', 'Paket Dokumen', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 01:05:00'),
(86, 'SR-102/2026', 'PT Maju Bersama', 'Invoice Pembelian ATK', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 01:12:00'),
(87, 'SR-103/2026', 'Budi (Kurir)', 'Paket Sampel', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 01:18:00'),
(88, 'SR-104/2026', 'Kantor Pos', 'Surat Edaran', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 01:25:00'),
(89, 'SR-105/2026', 'CV Karya Indah', 'Dokumen Kontrak', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 01:31:00'),
(90, 'SR-106/2026', 'Grab Express', 'Kue Rapat', 'Sekretaris', 'Maya', NULL, NULL, '2026-10-15 01:40:00'),
(91, 'SR-107/2026', 'PT Sentosa Abadi', 'Katalog Produk', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-10-15 01:45:00'),
(92, 'SR-108/2026', 'Gojek (Gosend)', 'Dokumen Tender', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-10-15 01:52:00'),
(93, 'SR-109/2026', 'Bank BCA', 'Buku Rekening Baru', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 01:58:00'),
(94, 'SR-110/2026', 'Tiki Express', 'Seragam Karyawan', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 02:05:00'),
(95, 'SR-111/2026', 'Wahana Express', 'Paket Buku', 'Perpustakaan', 'Sinta', NULL, NULL, '2026-10-15 02:12:00'),
(96, 'SR-112/2026', 'PT Indo Global', 'Sampel B', 'R&D', 'Faisal', NULL, NULL, '2026-10-15 02:18:00'),
(97, 'SR-113/2026', 'Kantor Pajak', 'Surat Pemberitahuan', 'Pajak', 'Rini', NULL, NULL, '2026-10-15 02:25:00'),
(98, 'SR-114/2026', 'CV Sukses Makmur', 'Invoice No. 5678', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 02:32:00'),
(99, 'SR-115/2026', 'Telkomsel', 'Tagihan Halo', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 02:38:00'),
(100, 'SR-116/2026', 'PT Bangun Persada', 'Draft Kontrak Vendor', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 02:45:00'),
(101, 'SR-117/2026', 'Universitas Terbuka', 'Surat Undangan', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 02:52:00'),
(102, 'SR-118/2026', 'PT Sejahtera', 'Klaim Asuransi', 'HRD', 'Bambang', NULL, NULL, '2026-10-15 02:58:00'),
(103, 'SR-119/2026', 'PT Aneka Tambang', 'Laporan Bulanan', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 03:05:00'),
(104, 'SR-120/2026', 'CV Bintang Terang', 'Katalog Sparepart', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-10-15 03:12:00'),
(105, 'SR-121/2026', 'J&T Express', 'Paket Hadiah', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 03:18:00'),
(106, 'SR-122/2026', 'BPJS Kesehatan', 'Tagihan Bulanan', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 03:25:00'),
(107, 'SR-123/2026', 'BPJS Ketenagakerjaan', 'Sertifikat', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 03:32:00'),
(108, 'SR-124/2026', 'PT Bumi Karsa', 'Dokumen Proyek', 'Proyek', 'Eko', NULL, NULL, '2026-10-15 03:38:00'),
(109, 'SR-125/2026', 'Shopee Express', 'Perlengkapan Event', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 03:45:00'),
(110, 'SR-126/2026', 'PT Media Nusantara', 'Majalah Bisnis', 'Lobby', 'Resepsionis', NULL, NULL, '2026-10-15 03:52:00'),
(111, 'SR-127/2026', 'Kementerian Perdagangan', 'Surat Izin', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 03:58:00'),
(112, 'SR-128/2026', 'CV Cipta Pesona', 'Brosur Promosi', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-10-15 04:05:00'),
(113, 'SR-129/2026', 'Anteraja', 'Paket Dokumen', 'IT', 'Reza', NULL, NULL, '2026-10-15 04:12:00'),
(114, 'SR-130/2026', 'PT Lenovo Indonesia', 'Laptop Karyawan', 'IT', 'Reza', NULL, NULL, '2026-10-15 04:18:00'),
(115, 'SR-131/2026', 'Telkom', 'Tagihan Telepon', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 04:25:00'),
(116, 'SR-132/2026', 'PT Indofood', 'Parcel Klien', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 04:32:00'),
(117, 'SR-133/2026', 'Bank Mandiri', 'Kartu Kredit Corp', 'Direktur Keuangan', 'Bapak Rio', NULL, NULL, '2026-10-15 04:38:00'),
(118, 'SR-134/2026', 'Paxel', 'Frozen Food', 'GA', 'Hendra', NULL, NULL, '2026-10-15 04:45:00'),
(119, 'SR-135/2026', 'Kantor Pos', 'Surat Somasi', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 04:52:00'),
(120, 'SR-136/2026', 'CV Tiga Sekawan', 'Invoice ATK', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 04:58:00'),
(121, 'SR-137/2026', 'PT Astra Motor', 'STNK Kendaraan', 'GA', 'Hendra', NULL, NULL, '2026-10-15 05:05:00'),
(122, 'SR-138/2026', 'Ninja Express', 'Paket Retur', 'Logistik', 'Wahyu', NULL, NULL, '2026-10-15 05:12:00'),
(123, 'SR-139/2026', 'PT Garuda Indonesia', 'Tiket Dinas', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 05:18:00'),
(124, 'SR-140/2026', 'KAI', 'Tiket Kereta', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 05:25:00'),
(125, 'SR-141/2026', 'PT Samsung', 'Monitor PC', 'IT', 'Reza', NULL, NULL, '2026-10-15 05:32:00'),
(126, 'SR-142/2026', 'Sicepat', 'Paket Modem', 'IT', 'Reza', NULL, NULL, '2026-10-15 05:38:00'),
(127, 'SR-143/2026', 'Dinas Tata Kota', 'Surat Peringatan', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 05:45:00'),
(128, 'SR-144/2026', 'JNE Express', 'Undangan Klien', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 05:52:00'),
(129, 'SR-145/2026', 'PT BFI Finance', 'Dokumen BPKB', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 05:58:00'),
(130, 'SR-146/2026', 'RS Mitra Keluarga', 'Kwitansi MCU', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 06:05:00'),
(131, 'SR-147/2026', 'Lalamove', 'Kardus', 'GA', 'Hendra', NULL, NULL, '2026-10-15 06:12:00'),
(132, 'SR-148/2026', 'CV Global Print', 'Hasil Cetak Banner', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 06:18:00'),
(133, 'SR-149/2026', 'PT Kertas Nusantara', 'Kertas HVS', 'GA', 'Hendra', NULL, NULL, '2026-10-15 06:25:00'),
(134, 'SR-150/2026', 'Badan Pusat Statistik', 'Buku Laporan', 'R&D', 'Faisal', NULL, NULL, '2026-10-15 06:32:00'),
(135, 'SR-151/2026', 'Tiki Express', 'Hardisk', 'IT', 'Reza', NULL, NULL, '2026-10-15 06:38:00'),
(136, 'SR-152/2026', 'PT Gudang Garam', 'Sponsorship', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-10-15 06:45:00'),
(137, 'SR-153/2026', 'Bank BRI', 'Bilyet Giro', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 06:52:00'),
(138, 'SR-154/2026', 'J&T Cargo', 'Mesin Foto Copy', 'GA', 'Hendra', NULL, NULL, '2026-10-15 06:58:00'),
(139, 'SR-155/2026', 'PT Indocement', 'Katalog Harga', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-10-15 07:05:00'),
(140, 'SR-156/2026', 'Hotel Aston', 'Voucher Menginap', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 07:12:00'),
(141, 'SR-157/2026', 'Kantor Pos', 'Surat Dinas', 'Direksi', 'Maya', NULL, NULL, '2026-10-15 07:18:00'),
(142, 'SR-158/2026', 'DHL Express', 'Dokumen Ekspor', 'Logistik', 'Wahyu', NULL, NULL, '2026-10-15 07:25:00'),
(143, 'SR-159/2026', 'PT Surveyor Indonesia', 'Sertifikat ISO', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 07:32:00'),
(144, 'SR-160/2026', 'Pertamina', 'Voucher BBM', 'GA', 'Hendra', NULL, NULL, '2026-10-15 07:38:00'),
(145, 'SR-161/2026', 'BCA Multi Finance', 'Perjanjian Kredit', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 07:45:00'),
(146, 'SR-162/2026', 'Universitas Indonesia', 'Undangan Campus Hiring', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 07:52:00'),
(147, 'SR-163/2026', 'PT Data Solusindo', 'Server Rack', 'IT', 'Reza', NULL, NULL, '2026-10-15 07:58:00'),
(148, 'SR-164/2026', 'PLN', 'Tagihan Listrik', 'GA', 'Hendra', NULL, NULL, '2026-10-15 08:05:00'),
(149, 'SR-165/2026', 'PDAM', 'Tagihan Air', 'GA', 'Hendra', NULL, NULL, '2026-10-15 08:12:00'),
(150, 'SR-166/2026', 'Gojek (Gosend)', 'Dokumen Cito', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 08:18:00'),
(151, 'SR-167/2026', 'Kemenkumham', 'Pengesahan Akta', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 08:25:00'),
(152, 'SR-168/2026', 'CV Maju Jaya', 'Nota Penjualan', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 08:32:00'),
(153, 'SR-169/2026', 'Telkomsel', 'Kartu Perdana', 'GA', 'Hendra', NULL, NULL, '2026-10-15 08:38:00'),
(154, 'SR-170/2026', 'Grab Express', 'Makan Siang', 'Sekretaris', 'Maya', NULL, NULL, '2026-10-15 08:45:00'),
(155, 'SR-171/2026', 'JNE Express', 'Kacamata Safety', 'HSE', 'Dodi', NULL, NULL, '2026-10-15 08:52:00'),
(156, 'SR-172/2026', 'PT Sinar Mas', 'Polis Asuransi', 'GA', 'Hendra', NULL, NULL, '2026-10-15 08:58:00'),
(157, 'SR-173/2026', 'Wahana Express', 'Paket Banner', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 09:05:00'),
(158, 'SR-174/2026', 'PT Gramedia', 'Buku Referensi', 'Perpustakaan', 'Sinta', NULL, NULL, '2026-10-15 09:12:00'),
(159, 'SR-175/2026', 'Dinas Tenaga Kerja', 'Peraturan Baru', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 09:18:00'),
(160, 'SR-176/2026', 'CV Mitra Bersama', 'Invoice Seragam', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 09:25:00'),
(161, 'SR-177/2026', 'Tiki Express', 'Mouse Logitech', 'IT', 'Reza', NULL, NULL, '2026-10-15 09:32:00'),
(162, 'SR-178/2026', 'PT Cisco', 'Router Baru', 'IT', 'Reza', NULL, NULL, '2026-10-15 09:38:00'),
(163, 'SR-179/2026', 'Anteraja', 'Sample Kain', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-10-15 09:45:00'),
(164, 'SR-180/2026', 'J&T Express', 'Souvenir Kantor', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-10-15 09:52:00'),
(165, 'SR-181/2026', 'PT Kalbe Farma', 'Obat P3K', 'HSE', 'Dodi', NULL, NULL, '2026-10-15 09:58:00'),
(166, 'SR-182/2026', 'DHL Express', 'Suku Cadang Mesin', 'Logistik', 'Wahyu', NULL, NULL, '2026-10-15 10:05:00'),
(167, 'SR-183/2026', 'Bank BNI', 'Pemberitahuan Bunga', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 10:12:00'),
(168, 'SR-184/2026', 'Kantor Pos', 'Surat Tilang', 'GA', 'Hendra', NULL, NULL, '2026-10-15 10:18:00'),
(169, 'SR-185/2026', 'Shopee Express', 'Kopi Pantry', 'GA', 'Hendra', NULL, NULL, '2026-10-15 10:25:00'),
(170, 'SR-186/2026', 'PT Astra International', 'Proposal Bisnis', 'Direksi', 'Bapak Direktur', NULL, NULL, '2026-10-15 10:32:00'),
(171, 'SR-187/2026', 'Lalamove', 'Kursi Kantor', 'GA', 'Hendra', NULL, NULL, '2026-10-15 10:38:00'),
(172, 'SR-188/2026', 'CV Cipta Karya', 'Stempel Perusahaan', 'Sekretaris', 'Maya', NULL, NULL, '2026-10-15 10:45:00'),
(173, 'SR-189/2026', 'PT Indosat', 'Tagihan Matrix', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 10:52:00'),
(174, 'SR-190/2026', 'Gojek (Gosend)', 'Kunci Cadangan', 'GA', 'Hendra', NULL, NULL, '2026-10-15 10:58:00'),
(175, 'SR-191/2026', 'PT Erlangga', 'Kalender Tahunan', 'Marketing', 'Dina', NULL, NULL, '2026-10-15 11:05:00'),
(176, 'SR-192/2026', 'Ninja Express', 'Dokumen Retur', 'QC', 'Rahmat', NULL, NULL, '2026-10-15 11:12:00'),
(177, 'SR-193/2026', 'Paxel', 'Cake Perayaan', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 11:18:00'),
(178, 'SR-194/2026', 'Kemenkeu', 'Sertifikat Pajak', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 11:25:00'),
(179, 'SR-195/2026', 'Sicepat', 'Modem Orbit', 'IT', 'Reza', NULL, NULL, '2026-10-15 11:32:00'),
(180, 'SR-196/2026', 'PT BCA Syariah', 'Dokumen Pembiayaan', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 11:38:00'),
(181, 'SR-197/2026', 'J&T Express', 'Seragam Baru', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 11:45:00'),
(182, 'SR-198/2026', 'Kantor Pos', 'Surat Pemberitahuan', 'Legal', 'Rina Marlina', NULL, NULL, '2026-10-15 11:52:00'),
(183, 'SR-199/2026', 'PT Makmur Jaya', 'Invoice Sewa', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-15 11:58:00'),
(184, 'SR-200/2026', 'Grab Express', 'Makan Malam Tamu', 'Sekretaris', 'Maya', NULL, NULL, '2026-10-15 12:05:00'),
(185, 'SR-201/2026', 'DHL Express', 'Dokumen Impor', 'Logistik', 'Wahyu', NULL, NULL, '2026-10-15 12:12:00'),
(186, 'SR-202/2026', 'KAI Commuter', 'Kartu Multi Trip', 'GA', 'Hendra', NULL, NULL, '2026-10-15 12:18:00'),
(187, 'SR-203/2026', 'PT TransJakarta', 'Kartu JakLingko', 'GA', 'Hendra', NULL, NULL, '2026-10-15 12:25:00'),
(188, 'SR-204/2026', 'Dinas Kebersihan', 'Surat Retribusi', 'GA', 'Hendra', NULL, NULL, '2026-10-15 12:32:00'),
(189, 'SR-205/2026', 'Kurir Internal', 'Dokumen Antar Divisi', 'HRD', 'Nisa', NULL, NULL, '2026-10-15 12:38:00'),
(190, 'SR-001/2025', 'PT Maju Bersama', 'Invoice Pembelian ATK', 'Keuangan', 'Siti Aminah', NULL, NULL, '2025-11-10 02:15:00'),
(191, 'SR-002/2025', 'Budi Prakoso', 'Paket Barang Sampel', 'Marketing', 'Andi Wijaya', NULL, NULL, '2025-11-12 07:20:00'),
(192, 'SR-003/2025', 'CV Karya Indah', 'Dokumen Kontrak Kerjasama', 'Legal', 'Rina Marlina', NULL, NULL, '2025-12-05 03:00:00'),
(193, 'SR-004/2025', 'Dinas Pendapatan', 'Surat Pemberitahuan Pajak', 'Direksi', 'Bapak Direktur', NULL, NULL, '2025-12-15 04:30:00'),
(194, 'SR-005/2025', 'PT Sentosa Abadi', 'Katalog Produk Terbaru', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2025-12-20 08:45:00'),
(195, 'SR-001/2026', 'JNE Express', 'Paket Karyawan', 'HRD', 'Nisa', NULL, NULL, '2026-01-05 06:00:00'),
(196, 'SR-002/2026', 'PT Citra Nusa', 'Tagihan Internet', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-01-10 02:00:00'),
(197, 'SR-003/2026', 'Bank BCA', 'Buku Rekening Perusahaan', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-01-15 03:15:00'),
(198, 'SR-004/2026', 'Budi (Kurir)', 'Dokumen Penawaran', 'Marketing', 'Dina', NULL, NULL, '2026-02-02 04:00:00'),
(199, 'SR-005/2026', 'PT Indo Global', 'Sampel Produk A', 'R&D', 'Faisal', NULL, NULL, '2026-02-14 07:30:00'),
(200, 'SR-006/2026', 'Kantor Pajak', 'Surat Edaran', 'Pajak', 'Rini', NULL, NULL, '2026-02-20 01:45:00'),
(201, 'SR-007/2026', 'CV Sukses Makmur', 'Invoice No. 1234', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-03-01 03:00:00'),
(202, 'SR-008/2026', 'Telkomsel', 'Tagihan Halo', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-03-05 06:20:00'),
(203, 'SR-009/2026', 'Wahana Express', 'Paket Buku', 'Perpustakaan', 'Sinta', NULL, NULL, '2026-03-10 08:00:00'),
(204, 'SR-010/2026', 'PT Bangun Persada', 'Draft Kontrak Vendor', 'Legal', 'Rina Marlina', NULL, NULL, '2026-03-15 02:30:00'),
(205, 'SR-011/2026', 'Universitas Terbuka', 'Surat Undangan Seminar', 'HRD', 'Nisa', NULL, NULL, '2026-04-02 04:15:00'),
(206, 'SR-012/2026', 'Tiki Express', 'Seragam Karyawan', 'HRD', 'Nisa', NULL, NULL, '2026-04-10 07:00:00'),
(207, 'SR-013/2026', 'PT Sejahtera', 'Klaim Asuransi', 'HRD', 'Bambang', NULL, NULL, '2026-04-18 03:45:00'),
(208, 'SR-014/2026', 'Gojek (Gosend)', 'Kue Ulang Tahun Direktur', 'Sekretaris', 'Maya', NULL, NULL, '2026-04-25 05:00:00'),
(209, 'SR-015/2026', 'Grab Express', 'Dokumen Tender Mendesak', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-05-02 01:30:00'),
(210, 'SR-016/2026', 'PT Aneka Tambang', 'Laporan Tahunan', 'Direksi', 'Maya', NULL, NULL, '2026-05-08 06:10:00'),
(211, 'SR-017/2026', 'CV Bintang Terang', 'Katalog Lampu', 'Pengadaan', 'Joko Susilo', NULL, NULL, '2026-05-12 03:25:00'),
(212, 'SR-018/2026', 'J&T Express', 'Paket Hadiah Klien', 'Marketing', 'Dina', NULL, NULL, '2026-05-14 08:30:00'),
(213, 'SR-019/2026', 'BPJS Kesehatan', 'Tagihan Bulanan', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-05-20 02:00:00'),
(214, 'SR-020/2026', 'BPJS Ketenagakerjaan', 'Sertifikat Baru', 'HRD', 'Nisa', NULL, NULL, '2026-05-25 04:45:00'),
(215, 'SR-021/2026', 'PT Bumi Karsa', 'Dokumen Andal', 'Proyek', 'Eko', NULL, NULL, '2026-06-01 07:15:00'),
(216, 'SR-022/2026', 'Shopee Express', 'Perlengkapan Event', 'Marketing', 'Dina', NULL, NULL, '2026-06-05 03:30:00'),
(217, 'SR-023/2026', 'PT Media Nusantara', 'Majalah Bisnis', 'Lobby', 'Resepsionis', NULL, NULL, '2026-06-10 01:00:00'),
(218, 'SR-024/2026', 'Kementerian Perdagangan', 'Surat Izin Usaha', 'Legal', 'Rina Marlina', NULL, NULL, '2026-06-15 06:50:00'),
(219, 'SR-025/2026', 'CV Cipta Pesona', 'Brosur Promosi', 'Marketing', 'Andi Wijaya', NULL, NULL, '2026-06-20 08:20:00'),
(220, 'SR-026/2026', 'Anteraja', 'Paket Dokumen', 'IT', 'Reza', NULL, NULL, '2026-07-02 02:10:00'),
(221, 'SR-027/2026', 'PT Lenovo Indonesia', 'Laptop Karyawan Baru', 'IT', 'Reza', NULL, NULL, '2026-07-08 04:00:00'),
(222, 'SR-028/2026', 'Telkom', 'Tagihan Telepon', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-07-15 07:30:00'),
(223, 'SR-029/2026', 'PT Indofood', 'Parcel Lebaran', 'Direksi', 'Maya', NULL, NULL, '2026-07-20 03:15:00'),
(224, 'SR-030/2026', 'Bank Mandiri', 'Kartu Kredit Corporate', 'Direktur Keuangan', 'Bapak Rio', NULL, NULL, '2026-07-25 02:45:00'),
(225, 'SR-031/2026', 'Paxel', 'Frozen Food Event', 'GA', 'Hendra', NULL, NULL, '2026-08-01 01:20:00'),
(226, 'SR-032/2026', 'Kantor Pos', 'Surat Somasi', 'Legal', 'Rina Marlina', NULL, NULL, '2026-08-05 06:40:00'),
(227, 'SR-033/2026', 'CV Tiga Sekawan', 'Invoice ATK', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-08-10 08:05:00'),
(228, 'SR-034/2026', 'PT Astra Motor', 'STNK Kendaraan Operasional', 'GA', 'Hendra', NULL, NULL, '2026-08-15 03:30:00'),
(229, 'SR-035/2026', 'Ninja Express', 'Paket Pengembalian', 'Logistik', 'Wahyu', NULL, NULL, '2026-08-20 04:50:00'),
(230, 'SR-036/2026', 'PT Garuda Indonesia', 'Tiket Dinas Luar Kota', 'HRD', 'Nisa', NULL, NULL, '2026-09-02 02:00:00'),
(231, 'SR-037/2026', 'KAI', 'Tiket Kereta', 'HRD', 'Nisa', NULL, NULL, '2026-09-05 07:15:00'),
(232, 'SR-038/2026', 'PT Samsung', 'Monitor PC', 'IT', 'Reza', NULL, NULL, '2026-09-10 03:20:00'),
(233, 'SR-039/2026', 'Sicepat', 'Paket Modem', 'IT', 'Reza', NULL, NULL, '2026-09-15 06:10:00'),
(234, 'SR-040/2026', 'Dinas Tata Kota', 'Surat Peringatan', 'Legal', 'Rina Marlina', NULL, NULL, '2026-09-20 08:30:00'),
(235, 'SR-041/2026', 'JNE Express', 'Undangan Pernikahan Klien', 'Marketing', 'Dina', NULL, NULL, '2026-10-01 02:45:00'),
(236, 'SR-042/2026', 'PT BFI Finance', 'Dokumen BPKB', 'Keuangan', 'Siti Aminah', NULL, NULL, '2026-10-05 04:20:00'),
(237, 'SR-043/2026', 'RS Mitra Keluarga', 'Kwitansi Medical Check Up', 'HRD', 'Nisa', NULL, NULL, '2026-10-10 07:40:00'),
(238, 'SR-044/2026', 'Lalamove', 'Kardus Pindahan', 'GA', 'Hendra', NULL, NULL, '2026-10-12 03:00:00'),
(239, 'SR-045/2026', 'CV Global Print', 'Hasil Cetak Banner', 'Marketing', 'Dina', NULL, NULL, '2026-10-14 06:27:00'),
(240, 'SR-046/2026', 'PT Kertas Nusantara', 'Kertas HVS 100 Rim', 'GA', 'Hendra', 'surat_1792375470_6ad57aae1fe56.jpg', 'penerima_1792375470_6ad57aae2b8b8.jpg', '2026-10-20 02:04:30'),
(295, '', 'fjia', 'csacowa', '', 'fjwaoi', 'surat_1792376012_6ad57ccccedac.jpg', 'penerima_1792394075_6ad5c35bf0c80.jpg', '2026-10-19 07:14:36'),
(297, '', 'lorem', 'ipsum', '', 'dolor', 'surat_1792383013_6ad5982504aa3.gif', 'penerima_1792383140_6ad598a44712d.webp', '2026-10-19 04:12:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tanda_terima`
--
ALTER TABLE `tanda_terima`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tanda_terima`
--
ALTER TABLE `tanda_terima`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=298;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
