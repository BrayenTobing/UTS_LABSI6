-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2022 pada 23.11
-- Versi server: 10.4.17-MariaDB
-- Versi PHP: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sewa_alatcamping`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_alat`
--

CREATE TABLE `tbl_alat` (
  `id_alat` int(11) NOT NULL,
  `alat_id` varchar(255) NOT NULL,
  `nama_alat` varchar(255) NOT NULL,
  `brand` int(11) NOT NULL,
  `id_rak` int(11) NOT NULL,
  `sampul` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `barang` varchar(255) DEFAULT NULL,
  `lampiran` varchar(255) DEFAULT NULL,
  `thn_alat` varchar(255) DEFAULT NULL,
  `isi` text NOT NULL,
  `jmlh` int(11) DEFAULT NULL,
  `tgl_masuk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_alat`
--

INSERT INTO `tbl_alat` (`id_alat`, `alat_id`, `nama_alat`, `brand`, `id_rak`, `sampul`, `id_kategori`, `barang`, `lampiran`, `thn_alat`, `isi`, `jmlh`, `tgl_masuk`) VALUES
(1, 'BB009', 'Tenda Arei 4/5', 0, 1, '43eeb12bebd0fb552e6c3dc5683f07c6.jpg', 1, '0', '0', '2021', '<table class=\"table table-bordered\" style=\"background-color: rgb(255, 255, 255); width: 653px; color: rgb(51, 51, 51);\"><tbody><tr><td style=\"padding: 8px; line-height: 1.42857; border-color: rgb(244, 244, 244);\">Tipe Tenda</td><td style=\"padding: 8px; line-height: 1.42857; border-color: rgb(244, 244, 244);\">Buatan</td></tr><tr><td style=\"padding: 8px; line-height: 1.42857; border-color: rgb(244, 244, 244);\">Besar</td><td style=\"padding: 8px; line-height: 1.42857; border-color: rgb(244, 244, 244);\">Indonesia</td></tr></tbody></table>', 9, '2022-05-29 04:00:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_biaya_denda`
--

CREATE TABLE `tbl_biaya_denda` (
  `id_biaya_denda` int(11) NOT NULL,
  `harga_denda` varchar(255) NOT NULL,
  `stat` varchar(255) NOT NULL,
  `tgl_tetap` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_biaya_denda`
--

INSERT INTO `tbl_biaya_denda` (`id_biaya_denda`, `harga_denda`, `stat`, `tgl_tetap`) VALUES
(1, '40000', 'aktif ', '2021-03-24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_denda`
--

CREATE TABLE `tbl_denda` (
  `id_denda` int(11) NOT NULL,
  `sewa_id` varchar(255) NOT NULL,
  `denda` varchar(255) NOT NULL,
  `lama_waktu` int(11) NOT NULL,
  `tgl_denda` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_denda`
--

INSERT INTO `tbl_denda` (`id_denda`, `sewa_id`, `denda`, `lama_waktu`, `tgl_denda`) VALUES
(3, 'CS009', '0', 0, '2021-03-22'),
(5, 'CS009', '0', 0, '2021-03-22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Tenda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_login`
--

CREATE TABLE `tbl_login` (
  `id_login` int(11) NOT NULL,
  `anggota_id` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tgl_lahir` varchar(255) NOT NULL,
  `jenkel` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telpon` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tgl_bergabung` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_login`
--

INSERT INTO `tbl_login` (`id_login`, `anggota_id`, `user`, `pass`, `level`, `nama`, `tempat_lahir`, `tgl_lahir`, `jenkel`, `alamat`, `telpon`, `email`, `tgl_bergabung`, `foto`) VALUES
(1, 'BA001', 'admin', '202cb962ac59075b964b07152d234b70', 'Petugas', 'Admin', 'Jakarta', '2001-09-20', 'Laki-Laki', 'Jakarta', '0888888888', 'admin@kicep.com', '2021-10-01', 'user_1630303496.png'),
(2, 'BA002', 'bara', 'bcbe3365e6ac95ea2c0343a2395834dd', 'Petugas', 'Brayen Tobing', 'Pematangsiantar', '2002-10-17', 'Laki-Laki', 'Pematangsiantar', '081278998274', 'brayentobing8@gmail.com', '2021-10-01', 'user_1630303496.png'),
(3, 'BA003', 'aldo', '310dcbbf4cce62f762a2aaa148d556bd', 'Anggota', 'Aldo Panjaitan', 'Pematangsiantar', '2002-05-16', 'Laki-Laki', 'Pematangsiantar', '082275663991', 'oneheartstr16@gmail.com', '2022-01-01', 'user_1630303496.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_rak`
--

CREATE TABLE `tbl_rak` (
  `id_rak` int(11) NOT NULL,
  `nama_rak` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_rak`
--

INSERT INTO `tbl_rak` (`id_rak`, `nama_rak`) VALUES
(1, 'Rak Tenda');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_sewa`
--

CREATE TABLE `tbl_sewa` (
  `id_sewa` int(11) NOT NULL,
  `sewa_id` varchar(255) NOT NULL,
  `anggota_id` varchar(255) NOT NULL,
  `alat_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tgl_sewa` varchar(255) NOT NULL,
  `lama_sewa` int(11) NOT NULL,
  `tgl_balik` varchar(255) NOT NULL,
  `tgl_kembali` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tbl_sewa`
--

INSERT INTO `tbl_sewa` (`id_sewa`, `sewa_id`, `anggota_id`, `alat_id`, `status`, `tgl_sewa`, `lama_sewa`, `tgl_balik`, `tgl_kembali`) VALUES
(1, 'CS009', 'BA001', 'BB009', 'Di Kembalikan', '2022-03-21', 1, '2022-03-22', '2022-03-22');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tbl_alat`
--
ALTER TABLE `tbl_alat`
  ADD PRIMARY KEY (`id_alat`);

--
-- Indeks untuk tabel `tbl_biaya_denda`
--
ALTER TABLE `tbl_biaya_denda`
  ADD PRIMARY KEY (`id_biaya_denda`);

--
-- Indeks untuk tabel `tbl_denda`
--
ALTER TABLE `tbl_denda`
  ADD PRIMARY KEY (`id_denda`);

--
-- Indeks untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `tbl_rak`
--
ALTER TABLE `tbl_rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indeks untuk tabel `tbl_sewa`
--
ALTER TABLE `tbl_sewa`
  ADD PRIMARY KEY (`id_sewa`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_alat`
--
ALTER TABLE `tbl_alat`
  MODIFY `id_alat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_biaya_denda`
--
ALTER TABLE `tbl_biaya_denda`
  MODIFY `id_biaya_denda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_denda`
--
ALTER TABLE `tbl_denda`
  MODIFY `id_denda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_login`
--
ALTER TABLE `tbl_login`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_rak`
--
ALTER TABLE `tbl_rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_sewa`
--
ALTER TABLE `tbl_sewa`
  MODIFY `id_sewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
