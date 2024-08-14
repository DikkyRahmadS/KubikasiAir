-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Jul 2024 pada 18.54
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kubikasi_air`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `meter_harian`
--

CREATE TABLE `meter_harian` (
  `id_meter_harian` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `meter_pemakaian` varchar(255) NOT NULL,
  `id_alat` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `meter_harian`
--

INSERT INTO `meter_harian` (`id_meter_harian`, `tanggal`, `meter_pemakaian`, `id_alat`, `status`) VALUES
(1, '2024-07-10 11:23:52', '220.870', 'f6fcda1a23e3abf1', 0),
(2, '2024-07-19 06:38:32', '223', 'f6fcda1a23e3abf1', 0);

--
-- Trigger `meter_harian`
--
DELIMITER $$
CREATE TRIGGER `prevent_tanggal_update` BEFORE UPDATE ON `meter_harian` FOR EACH ROW BEGIN
    IF NEW.status <> OLD.status THEN
        SET NEW.tanggal = OLD.tanggal;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tarif_dasar_air`
--

CREATE TABLE `tarif_dasar_air` (
  `id_tarif` int(11) NOT NULL,
  `nama_kelas` varchar(255) NOT NULL,
  `tarif_per_meter` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tarif_dasar_air`
--

INSERT INTO `tarif_dasar_air` (`id_tarif`, `nama_kelas`, `tarif_per_meter`) VALUES
(6, 'Industri', 3000),
(10, 'Sosial', 1000),
(11, 'Rumah Tangga', 500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_bayar`
--

CREATE TABLE `transaksi_bayar` (
  `id_transaksi` int(11) NOT NULL,
  `tgl_bayar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `meter_pemakaian` varchar(255) NOT NULL,
  `total_bayar` double NOT NULL,
  `alat_meter` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(255) NOT NULL,
  `telp` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_alat` varchar(255) NOT NULL,
  `id_tarif` int(11) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `alamat`, `kota`, `telp`, `email`, `password`, `id_alat`, `id_tarif`, `level`) VALUES
(1, 'Administrator', 'malang', '123123', '', 'admin@gmail.com', '$2y$10$60pLQUvKEQxy.8PIOm6Iy.rK9tvoNgJHi.FP5lcIy28JIHKkXsoqG', '', 10, 'admin'),
(2, 'dendi', 'malang', 'malang', '62895331108251', 'yayang@gmail.com', '$2y$10$S5BCyAUp1KdCSV1VMTMQY.9HKEBuElxboKMmjlxdzF3y/oD1ccZo6', 'f6fcda1a23e3abf1', 6, 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `meter_harian`
--
ALTER TABLE `meter_harian`
  ADD PRIMARY KEY (`id_meter_harian`),
  ADD KEY `id_alat` (`id_alat`);

--
-- Indeks untuk tabel `tarif_dasar_air`
--
ALTER TABLE `tarif_dasar_air`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indeks untuk tabel `transaksi_bayar`
--
ALTER TABLE `transaksi_bayar`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `meter_harian_id` (`alat_meter`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_alat` (`id_alat`),
  ADD KEY `id_tarif` (`id_tarif`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `meter_harian`
--
ALTER TABLE `meter_harian`
  MODIFY `id_meter_harian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tarif_dasar_air`
--
ALTER TABLE `tarif_dasar_air`
  MODIFY `id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `meter_harian`
--
ALTER TABLE `meter_harian`
  ADD CONSTRAINT `meter_harian_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `users` (`id_alat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_bayar`
--
ALTER TABLE `transaksi_bayar`
  ADD CONSTRAINT `transaksi_bayar_ibfk_1` FOREIGN KEY (`alat_meter`) REFERENCES `users` (`id_alat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_tarif`) REFERENCES `tarif_dasar_air` (`id_tarif`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
