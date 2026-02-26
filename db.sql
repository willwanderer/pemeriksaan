-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: pemeriksaan
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_log`
--

DROP TABLE IF EXISTS `activity_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_log` (
  `id_log` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `module` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `record_id` int DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `idx_module` (`module`),
  KEY `idx_action` (`action`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `addendum`
--

DROP TABLE IF EXISTS `addendum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `addendum` (
  `id_addendum` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `nomor_addendum` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_addendum` date DEFAULT NULL,
  `uraian_perubahan` text COLLATE utf8mb4_unicode_ci,
  `nilai_addendum` decimal(20,2) DEFAULT '0.00',
  `tanggal_mulai_baru` date DEFAULT NULL,
  `tanggal_selesai_baru` date DEFAULT NULL,
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_addendum`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_nomor_addendum` (`nomor_addendum`),
  CONSTRAINT `addendum_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `akun_belanja`
--

DROP TABLE IF EXISTS `akun_belanja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `akun_belanja` (
  `id_akun_belanja` int NOT NULL AUTO_INCREMENT,
  `nama_akun` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inisial` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_akun_belanja`),
  UNIQUE KEY `uk_inisial` (`inisial`),
  KEY `idx_nama_akun` (`nama_akun`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `denda_keterlambatan`
--

DROP TABLE IF EXISTS `denda_keterlambatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `denda_keterlambatan` (
  `id_denda` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `besaran_denda` decimal(10,4) DEFAULT '0.0010' COMMENT 'Denda rate (default 1/1000 = 0.001)',
  `dasar_pengenaan` decimal(20,2) DEFAULT '0.00' COMMENT 'Base value for penalty calculation',
  `persentase` decimal(5,2) DEFAULT '100.00' COMMENT 'Percentage of base value',
  `jumlah_hari_keterlambatan` int DEFAULT '0',
  `nilai_denda` decimal(20,2) DEFAULT '0.00' COMMENT 'Calculated penalty amount',
  `sk_denda_ditetapkan` tinyint(1) DEFAULT '0' COMMENT 'Whether SK Denda has been established',
  `kertas_kerja_path` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path to uploaded working paper',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_denda`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_sk_denda_ditetapkan` (`sk_denda_ditetapkan`),
  CONSTRAINT `denda_keterlambatan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dokumen`
--

DROP TABLE IF EXISTS `dokumen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dokumen` (
  `id_dokumen` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `doc_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_dokumen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_dokumen_asli` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_dokumen` enum('umum','tanah','addendum','pembayaran','serah_terima','lainnya') COLLATE utf8mb4_unicode_ci DEFAULT 'umum',
  `kategori_dokumen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('belum_upload','sudah_upload') COLLATE utf8mb4_unicode_ci DEFAULT 'belum_upload',
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_size` bigint DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT NULL,
  `tipe_dokumen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` tinyint(1) DEFAULT '1',
  `is_checked` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dokumen`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_jenis_dokumen` (`jenis_dokumen`),
  KEY `idx_status` (`status`),
  KEY `idx_nama_dokumen` (`nama_dokumen`),
  CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entitas`
--

DROP TABLE IF EXISTS `entitas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entitas` (
  `id_entitas` int NOT NULL AUTO_INCREMENT,
  `nama_entitas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` enum('provinsi','kabupaten','kecamatan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `daerah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `telepon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` longblob,
  `folder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_entitas`),
  KEY `idx_nama_entitas` (`nama_entitas`),
  KEY `idx_level` (`level`),
  KEY `idx_daerah` (`daerah`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item_pekerjaan`
--

DROP TABLE IF EXISTS `item_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_pekerjaan` (
  `id_item_pekerjaan` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `kode_item` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nama_item` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori_bm` enum('JIJ','BG','PM','TL','ATL','AL') COLLATE utf8mb4_unicode_ci DEFAULT 'JIJ',
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `satuan` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` decimal(15,3) DEFAULT '0.000',
  `harga_satuan` decimal(20,2) DEFAULT '0.00',
  `jumlah_harga` decimal(20,2) DEFAULT '0.00',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_item_pekerjaan`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_kode_item` (`kode_item`),
  KEY `idx_nama_item` (`nama_item`),
  CONSTRAINT `item_pekerjaan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kontak`
--

DROP TABLE IF EXISTS `kontak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kontak` (
  `id_kontak` int NOT NULL AUTO_INCREMENT,
  `id_entitas` int NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `posisi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `whatsapp` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id_kontak`),
  KEY `idx_id_entitas` (`id_entitas`),
  KEY `idx_nama` (`nama`),
  KEY `idx_posisi` (`posisi`),
  CONSTRAINT `kontak_ibfk_1` FOREIGN KEY (`id_entitas`) REFERENCES `entitas` (`id_entitas`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pekerjaan`
--

DROP TABLE IF EXISTS `pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int NOT NULL AUTO_INCREMENT,
  `id_entitas` int NOT NULL,
  `id_akun_belanja` int NOT NULL,
  `id_penyedia` int NOT NULL,
  `nama_pekerjaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skpd` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_kontrak` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nilai_kontrak` decimal(20,2) DEFAULT '0.00',
  `tanggal_kontrak` date DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `lokasi` text COLLATE utf8mb4_unicode_ci,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `folder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inisial_akun_belanja` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inisial_penyedia` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('planning','ongoing','completed','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'planning',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `progress_percentage` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pekerjaan`),
  KEY `id_akun_belanja` (`id_akun_belanja`),
  KEY `id_penyedia` (`id_penyedia`),
  KEY `idx_nama_pekerjaan` (`nama_pekerjaan`),
  KEY `idx_nomor_kontrak` (`nomor_kontrak`),
  KEY `idx_status` (`status`),
  KEY `idx_folder_name` (`folder_name`),
  KEY `idx_id_entitas` (`id_entitas`),
  CONSTRAINT `pekerjaan_ibfk_1` FOREIGN KEY (`id_entitas`) REFERENCES `entitas` (`id_entitas`) ON DELETE CASCADE,
  CONSTRAINT `pekerjaan_ibfk_2` FOREIGN KEY (`id_akun_belanja`) REFERENCES `akun_belanja` (`id_akun_belanja`) ON DELETE RESTRICT,
  CONSTRAINT `pekerjaan_ibfk_3` FOREIGN KEY (`id_penyedia`) REFERENCES `penyedia` (`id_penyedia`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pembayaran`
--

DROP TABLE IF EXISTS `pembayaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `nomor_pembayaran` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `termin` int DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `jumlah_pembayaran` decimal(20,2) DEFAULT '0.00',
  `persentase_pekerjaan` decimal(5,2) DEFAULT '0.00',
  `status_pembayaran` enum('pending','verified','paid') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `nilai_sebelumnya` decimal(20,2) DEFAULT '0.00',
  `nilai_terakhir` decimal(20,2) DEFAULT '0.00',
  `file_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pembayaran`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_nomor_pembayaran` (`nomor_pembayaran`),
  KEY `idx_status_pembayaran` (`status_pembayaran`),
  KEY `idx_tanggal_pembayaran` (`tanggal_pembayaran`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pemeriksaan_pekerjaan`
--

DROP TABLE IF EXISTS `pemeriksaan_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pemeriksaan_pekerjaan` (
  `id_pemeriksaan` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `dokumen_terupload` int DEFAULT '0',
  `dokumen_total` int DEFAULT '0',
  `dokumen_status` enum('belum_lengkap','lengkap','sudah_cek') COLLATE utf8mb4_unicode_ci DEFAULT 'belum_lengkap',
  `dokumen_catatan` text COLLATE utf8mb4_unicode_ci,
  `pekerjaan_selesai_periode` tinyint(1) DEFAULT NULL,
  `pekerjaan_periode_tanggal` date DEFAULT NULL,
  `pekerjaan_periode_catatan` text COLLATE utf8mb4_unicode_ci,
  `belanja_periode_tepat` tinyint(1) DEFAULT NULL,
  `belanja_periode_tanggal` date DEFAULT NULL,
  `belanja_periode_catatan` text COLLATE utf8mb4_unicode_ci,
  `klasifikasi_akun_sesuai` tinyint(1) DEFAULT NULL,
  `klasifikasi_akun_tanggal` date DEFAULT NULL,
  `klasifikasi_akun_catatan` text COLLATE utf8mb4_unicode_ci,
  `retensi_ada_bank_garansi` tinyint(1) DEFAULT NULL,
  `retensi_nilai` decimal(20,2) DEFAULT '0.00',
  `retensi_file_path` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retensi_tanggal` date DEFAULT NULL,
  `retensi_catatan` text COLLATE utf8mb4_unicode_ci,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `status_pemeriksaan` enum('belum_cek','sedang_cek','selesai_cek') COLLATE utf8mb4_unicode_ci DEFAULT 'belum_cek',
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pemeriksaan`),
  UNIQUE KEY `uk_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_status_pemeriksaan` (`status_pemeriksaan`),
  CONSTRAINT `pemeriksaan_pekerjaan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `penyedia`
--

DROP TABLE IF EXISTS `penyedia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `penyedia` (
  `id_penyedia` int NOT NULL AUTO_INCREMENT,
  `nama_penyedia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `inisial` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `kontak_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telepon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_penyedia`),
  UNIQUE KEY `uk_inisial` (`inisial`),
  KEY `idx_nama_penyedia` (`nama_penyedia`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `perbandingan_item_pemeriksaan`
--

DROP TABLE IF EXISTS `perbandingan_item_pemeriksaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `perbandingan_item_pemeriksaan` (
  `id_perbandingan` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `id_item_pekerjaan` int DEFAULT NULL,
  `id_rekapan_jalan` int DEFAULT NULL,
  `id_rekapan_gedung` int DEFAULT NULL,
  `id_rekapan_peralatan` int DEFAULT NULL,
  `id_rekapan_tanah` int DEFAULT NULL,
  `id_rekapan_aset_lain` int DEFAULT NULL,
  `volume_rencana` decimal(15,3) DEFAULT NULL,
  `satuan_rencana` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_satuan_rencana` decimal(20,2) DEFAULT NULL,
  `jumlah_rencana` decimal(20,2) DEFAULT NULL,
  `volume_actual` decimal(15,3) DEFAULT NULL,
  `satuan_actual` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_satuan_actual` decimal(20,2) DEFAULT NULL,
  `jumlah_actual` decimal(20,2) DEFAULT NULL,
  `selisih_volume` decimal(15,3) DEFAULT NULL,
  `selisih_harga` decimal(20,2) DEFAULT NULL,
  `prosentase_selisih` decimal(8,2) DEFAULT NULL,
  `status_kesesuaian` enum('sesuai','lebih','kurang','tidak_terpasang') COLLATE utf8mb4_unicode_ci DEFAULT 'sesuai',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_perbandingan`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_id_item_pekerjaan` (`id_item_pekerjaan`),
  KEY `idx_status_kesesuaian` (`status_kesesuaian`),
  CONSTRAINT `perbandingan_item_pemeriksaan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE,
  CONSTRAINT `perbandingan_item_pemeriksaan_ibfk_2` FOREIGN KEY (`id_item_pekerjaan`) REFERENCES `item_pekerjaan` (`id_item_pekerjaan`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rekapan_pemeriksaan_aset_lain`
--

DROP TABLE IF EXISTS `rekapan_pemeriksaan_aset_lain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekapan_pemeriksaan_aset_lain` (
  `id_rekapan_aset_lain` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `id_sub_pekerjaan` int DEFAULT NULL,
  `nama_aset` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_aset` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `merk` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_seri` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_perolehan` year DEFAULT NULL,
  `jenis_aset` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Type: Furniture, Vehicle, IT Equipment, dll',
  `kategori_aset` enum('bergerak','tidak_bergerak','berbahaya') COLLATE utf8mb4_unicode_ci DEFAULT 'bergerak',
  `spesifikasi_terencana` text COLLATE utf8mb4_unicode_ci,
  `warna` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `material` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensi_panjang` decimal(10,2) DEFAULT NULL,
  `dimensi_lebar` decimal(10,2) DEFAULT NULL,
  `dimensi_tinggi` decimal(10,2) DEFAULT NULL,
  `berat` decimal(10,2) DEFAULT NULL,
  `kondisi_umum` enum('baik','rusak_ringan','rusak_sedang','rusak_berat','hilang') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_fisik` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_fungsi` enum('berfungsi','tidak_berfungsi','sebagian_fungsi') COLLATE utf8mb4_unicode_ci DEFAULT 'berfungsi',
  `kelengkapan` enum('lengkap','tidak_lengkap') COLLATE utf8mb4_unicode_ci DEFAULT 'lengkap',
  `kelengkapan_aksesoris` text COLLATE utf8mb4_unicode_ci,
  `kelengkapan_dokumen` text COLLATE utf8mb4_unicode_ci,
  `foto_depan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_detail` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_nameplate` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lain` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `selisih_spesifikasi` text COLLATE utf8mb4_unicode_ci,
  `status_kesesuaian` enum('sesuai','tidak_sesuai','perlu_perbaikan') COLLATE utf8mb4_unicode_ci DEFAULT 'sesuai',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekapan_aset_lain`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_nama_aset` (`nama_aset`),
  KEY `idx_jenis_aset` (`jenis_aset`),
  KEY `idx_tanggal_pemeriksaan` (`tanggal_pemeriksaan`),
  KEY `idx_status_verifikasi` (`status_verifikasi`),
  KEY `idx_id_sub_pekerjaan` (`id_sub_pekerjaan`),
  CONSTRAINT `rekapan_pemeriksaan_aset_lain_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rekapan_pemeriksaan_gedung`
--

DROP TABLE IF EXISTS `rekapan_pemeriksaan_gedung`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekapan_pemeriksaan_gedung` (
  `id_rekapan_gedung` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `id_sub_pekerjaan` int DEFAULT NULL,
  `nama_bangunan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lokasi_bangunan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Specific location within project',
  `lantai` int DEFAULT NULL COMMENT 'Floor number (0=ground)',
  `nama_ruangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_ruangan` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `panjang_bangunan` decimal(10,2) DEFAULT NULL,
  `lebar_bangunan` decimal(10,2) DEFAULT NULL,
  `tinggi_bangunan` decimal(8,2) DEFAULT NULL,
  `luas_bangunan` decimal(12,2) DEFAULT NULL,
  `kondisi_struktur` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `dimensi_struktur` decimal(8,2) DEFAULT NULL COMMENT 'Column/beam dimensions in cm',
  `tebal_dinding` decimal(6,2) DEFAULT NULL COMMENT 'Wall thickness in cm',
  `jenis_atap` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_atap` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `jenis_lantai` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_lantai` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `tebal_lantai` decimal(6,2) DEFAULT NULL,
  `jenis_dinding` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kondisi_dinding` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_plafond` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_cat` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_listrik` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_plumbing` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `foto_struktur` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_atap` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lantai` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_dinding` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_finishing` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lain` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `selisih_luas` decimal(10,2) DEFAULT NULL COMMENT 'Difference from planning in m2',
  `status_kesesuaian` enum('sesuai','tidak_sesuai','perlu_perbaikan') COLLATE utf8mb4_unicode_ci DEFAULT 'sesuai',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekapan_gedung`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_nama_bangunan` (`nama_bangunan`),
  KEY `idx_lantai` (`lantai`),
  KEY `idx_tanggal_pemeriksaan` (`tanggal_pemeriksaan`),
  KEY `idx_status_verifikasi` (`status_verifikasi`),
  KEY `idx_id_sub_pekerjaan` (`id_sub_pekerjaan`),
  CONSTRAINT `rekapan_pemeriksaan_gedung_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rekapan_pemeriksaan_jalan`
--

DROP TABLE IF EXISTS `rekapan_pemeriksaan_jalan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekapan_pemeriksaan_jalan` (
  `id_rekapan_jalan` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `id_sub_pekerjaan` int DEFAULT NULL,
  `sta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `STA_type` enum('STA','KM') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'STA',
  `longitude` decimal(11,8) DEFAULT NULL,
  `latitude` decimal(11,8) DEFAULT NULL,
  `jenis_jalan` enum('AC-WC','AC-BC','LPA','Arteri','Kolektor','Lokal','Lingkungan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'AC-WC',
  `posisi_jalan` enum('Kiri','Tengah','Kanan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Tengah' COMMENT 'Position of road relative to lane',
  `tebal_1` decimal(8,2) DEFAULT NULL,
  `tebal_2` decimal(8,2) DEFAULT NULL,
  `tebal_3` decimal(8,2) DEFAULT NULL,
  `tebal_4` decimal(8,2) DEFAULT NULL,
  `tebal_existing` decimal(8,2) DEFAULT NULL,
  `tebal_rencana` decimal(8,2) DEFAULT NULL,
  `tebal_actual` decimal(8,2) DEFAULT NULL COMMENT 'Actual measured thickness',
  `lebar_jalan` decimal(8,2) DEFAULT NULL,
  `lebar_bahu_kiri` decimal(8,2) DEFAULT NULL,
  `lebar_bahu_kanan` decimal(8,2) DEFAULT NULL,
  `tebal_bahu_kiri` decimal(8,2) DEFAULT NULL,
  `tebal_bahu_kanan` decimal(8,2) DEFAULT NULL,
  `panjang` decimal(10,2) DEFAULT NULL COMMENT 'Length in meters',
  `kipas` decimal(8,2) DEFAULT NULL,
  `sloop` decimal(8,2) DEFAULT NULL,
  `foto_sta` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_bahu` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_bendauji` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lain` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `selisih_tebal` decimal(8,2) DEFAULT NULL COMMENT 'Difference from planning',
  `selisih_lebar` decimal(8,2) DEFAULT NULL COMMENT 'Difference from planning',
  `status_kesesuaian` enum('sesuai','tidak_sesuai','perlu_perbaikan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sesuai',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekapan_jalan`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_sta` (`sta`),
  KEY `idx_tanggal_pemeriksaan` (`tanggal_pemeriksaan`),
  KEY `idx_status_verifikasi` (`status_verifikasi`),
  KEY `idx_id_sub_pekerjaan` (`id_sub_pekerjaan`),
  CONSTRAINT `rekapan_pemeriksaan_jalan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rekapan_pemeriksaan_peralatan`
--

DROP TABLE IF EXISTS `rekapan_pemeriksaan_peralatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekapan_pemeriksaan_peralatan` (
  `id_rekapan_peralatan` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `id_sub_pekerjaan` int DEFAULT NULL,
  `nama_peralatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_seri` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tahun_pembuatan` year DEFAULT NULL,
  `jenis_peralatan` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Type: Excavator, Truck, dll',
  `kategori_peralatan` enum('berat','sedang','ringan','laboratorium','office') COLLATE utf8mb4_unicode_ci DEFAULT 'berat',
  `kapasitas_terencana` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `daya_listrik_terencana` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dimensi_panjang` decimal(10,2) DEFAULT NULL,
  `dimensi_lebar` decimal(10,2) DEFAULT NULL,
  `dimensi_tinggi` decimal(10,2) DEFAULT NULL,
  `berat` decimal(10,2) DEFAULT NULL COMMENT 'Weight in kg',
  `kondisi_umum` enum('baik','rusak_ringan','rusak_sedang','rusak_berat','tidak_fungsi') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_mesin` enum('baik','rusak_ringan','rusak_sedang','rusak_berat','tidak_fungsi') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_body` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_elektrik` enum('baik','rusak_ringan','rusak_sedang','rusak_berat','tidak_fungsi') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `kondisi_hydraulic` enum('baik','rusak_ringan','rusak_sedang','rusak_berat','tidak_fungsi') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `hasil_test_run` enum('berfungsi','tidak_berfungsi','sebagian_fungsi') COLLATE utf8mb4_unicode_ci DEFAULT 'berfungsi',
  `catatan_test_run` text COLLATE utf8mb4_unicode_ci,
  `kelengkapan_dokumen` enum('lengkap','tidak_lengkap') COLLATE utf8mb4_unicode_ci DEFAULT 'lengkap',
  `kelengkapan_aksesoris` enum('lengkap','tidak_lengkap') COLLATE utf8mb4_unicode_ci DEFAULT 'lengkap',
  `daftar_aksesoris` text COLLATE utf8mb4_unicode_ci,
  `foto_depan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_samping` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_mesin` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_nameplate` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lain` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `selisih_spesifikasi` text COLLATE utf8mb4_unicode_ci COMMENT 'Differences from planned specifications',
  `status_kesesuaian` enum('sesuai','tidak_sesuai','perlu_perbaikan') COLLATE utf8mb4_unicode_ci DEFAULT 'sesuai',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekapan_peralatan`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_nama_peralatan` (`nama_peralatan`),
  KEY `idx_jenis_peralatan` (`jenis_peralatan`),
  KEY `idx_tanggal_pemeriksaan` (`tanggal_pemeriksaan`),
  KEY `idx_status_verifikasi` (`status_verifikasi`),
  KEY `idx_id_sub_pekerjaan` (`id_sub_pekerjaan`),
  CONSTRAINT `rekapan_pemeriksaan_peralatan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rekapan_pemeriksaan_tanah`
--

DROP TABLE IF EXISTS `rekapan_pemeriksaan_tanah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rekapan_pemeriksaan_tanah` (
  `id_rekapan_tanah` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `id_sub_pekerjaan` int DEFAULT NULL,
  `lokasi_tanah` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `blok` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_petak` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_sertifikat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `luas_sertifikat` decimal(12,2) DEFAULT NULL COMMENT 'Land area from certificate (m2)',
  `atas_nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Certificate holder',
  `luas_terukur` decimal(12,2) DEFAULT NULL COMMENT 'Measured land area (m2)',
  `panjang_terukur` decimal(10,2) DEFAULT NULL,
  `lebar_terukur` decimal(10,2) DEFAULT NULL,
  `patok_tersedia` enum('ada','tidak_ada','sebagian') COLLATE utf8mb4_unicode_ci DEFAULT 'ada',
  `kondisi_patok` enum('baik','rusak','tidak_terlihat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `description_patok` text COLLATE utf8mb4_unicode_ci,
  `kondisi_tanah` enum('baik','rusak_ringan','rusak_sedang','rusak_berat') COLLATE utf8mb4_unicode_ci DEFAULT 'baik',
  `jenis_tanah` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Soil type: liat, pasirlan dll',
  `topografi` enum('datar','bergerombol','miring','berbukit') COLLATE utf8mb4_unicode_ci DEFAULT 'datar',
  `penggunaan_saat_ini` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bangunan_diatas` enum('ada','tidak_ada') COLLATE utf8mb4_unicode_ci DEFAULT 'tidak_ada',
  `description_bangunan` text COLLATE utf8mb4_unicode_ci,
  `nilai_appraisal` decimal(15,2) DEFAULT NULL COMMENT 'Appraisal value from apraisal',
  `nilai_transaksi` decimal(15,2) DEFAULT NULL COMMENT 'Transaction value',
  `foto_panorama` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_batas_timur` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_batas_barat` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_batas_utara` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_batas_selatan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_bangunan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_sertifikat` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `foto_lain` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_verifikasi` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `tanggal_pemeriksaan` date DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `selisih_luas` decimal(12,2) DEFAULT NULL COMMENT 'Difference from planned area (m2)',
  `selisih_nilai` decimal(15,2) DEFAULT NULL COMMENT 'Difference from planned value',
  `status_kesesuaian` enum('sesuai','tidak_sesuai','perlu_perbaikan') COLLATE utf8mb4_unicode_ci DEFAULT 'sesuai',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_rekapan_tanah`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_lokasi_tanah` (`lokasi_tanah`),
  KEY `idx_nomor_sertifikat` (`nomor_sertifikat`),
  KEY `idx_tanggal_pemeriksaan` (`tanggal_pemeriksaan`),
  KEY `idx_status_verifikasi` (`status_verifikasi`),
  KEY `idx_id_sub_pekerjaan` (`id_sub_pekerjaan`),
  CONSTRAINT `rekapan_pemeriksaan_tanah_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `serah_terima`
--

DROP TABLE IF EXISTS `serah_terima`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `serah_terima` (
  `id_serah_terima` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `nomor_berita_acara` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_serah_terima` date DEFAULT NULL,
  `jenis_serah_terima` enum('PHO','FHO','partial') COLLATE utf8mb4_unicode_ci DEFAULT 'PHO',
  `status_serah_terima` enum('pending','ongoing','completed') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `masa_pemeliharaan` int DEFAULT NULL COMMENT 'Maintenance period in months',
  `tanggal_akhir_pemeliharaan` date DEFAULT NULL,
  `nilai_garansi_bank` decimal(20,2) DEFAULT '0.00',
  `nilai_garansi_jaminan` decimal(20,2) DEFAULT '0.00',
  `file_berita_acara` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_garansi_bank` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_garansi_jaminan` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_serah_terima`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  KEY `idx_nomor_berita_acara` (`nomor_berita_acara`),
  KEY `idx_jenis_serah_terima` (`jenis_serah_terima`),
  CONSTRAINT `serah_terima_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sub_pekerjaan`
--

DROP TABLE IF EXISTS `sub_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_pekerjaan` (
  `id_sub_pekerjaan` int NOT NULL AUTO_INCREMENT,
  `id_pekerjaan` int NOT NULL,
  `nama_sub_pekerjaan` varchar(255) NOT NULL,
  `catatan` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_sub_pekerjaan`),
  KEY `idx_id_pekerjaan` (`id_pekerjaan`),
  CONSTRAINT `sub_pekerjaan_ibfk_1` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_settings` (
  `id_setting` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_setting`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping routines for database 'pemeriksaan'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-26 20:15:26
