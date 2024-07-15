/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
REPLACE INTO `master_pedagang` (`id`, `pedagang`, `layanan_id`, `lantai`, `blok`, `nomor`, `npwd`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Fitria', 1, 'A', 'A', '1', NULL, 'Aktif', 3, '2024-07-04 07:00:39', '2024-07-04 07:00:39'),
	(2, 'Fitria', 1, 'A', 'A', '2', NULL, 'Aktif', 3, '2024-07-04 07:00:39', '2024-07-04 07:00:39'),
	(3, 'Fitria', 1, 'A', 'A', '3', NULL, 'Aktif', 3, '2024-07-04 07:00:39', '2024-07-04 07:00:39'),
	(4, 'Fitria', 1, 'LA', 'LA', '148', NULL, 'Aktif', 3, '2024-07-04 07:01:33', '2024-07-04 07:01:33'),
	(5, 'Fitria', 1, 'LA', 'LA', '156', NULL, 'Aktif', 3, '2024-07-04 07:01:33', '2024-07-04 07:01:33'),
	(6, 'Andi Muhammad Mirza', 1, 'E', 'E', '1', NULL, 'Aktif', 3, '2024-07-04 07:02:38', '2024-07-04 07:02:38'),
	(7, 'Andi Muhammad Mirza', 1, 'BT', 'BT', '6', NULL, 'Aktif', 3, '2024-07-04 07:02:52', '2024-07-04 07:02:52'),
	(8, 'Dewi Levita', 1, 'G', 'G', '11', NULL, 'Aktif', 3, '2024-07-04 07:03:38', '2024-07-04 07:03:38'),
	(9, 'Dewi Levita', 1, 'G', 'G', '12', NULL, 'Aktif', 3, '2024-07-04 07:03:38', '2024-07-04 07:03:38'),
	(10, 'Imelda', 1, 'Auning', 'Auning', '5', NULL, 'Aktif', 3, '2024-07-04 07:04:23', '2024-07-04 07:04:23'),
	(11, 'Iskandar', 1, 'LA', 'LA', '153', NULL, 'Aktif', 3, '2024-07-04 07:41:49', '2024-07-04 07:41:49'),
	(12, 'Iskandar', 1, 'LA', 'LA', '154', NULL, 'Aktif', 3, '2024-07-04 07:41:49', '2024-07-04 07:41:49');
	
REPLACE INTO `laporan_harian` (`id`, `pedagang_id`, `bayar`, `keterangan`, `foto`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Ya', '-', '20240704nav_switch_sharp.jpg', '0', 2, '2024-07-04 07:18:18', '2024-07-04 07:18:18'),
	(2, 2, 'Ya', '-', '20240704nav_switch_sharp.jpg', '0', 2, '2024-07-04 07:18:18', '2024-07-04 07:18:18'),
	(3, 3, 'Ya', '-', '20240704nav_switch_sharp.jpg', '0', 2, '2024-07-04 07:18:18', '2024-07-04 07:18:18'),
	(4, 11, 'Ya', '-', '20240704contoh-tabel.jpg', '0', 2, '2024-07-04 07:42:51', '2024-07-04 07:42:51'),
	(5, 12, 'Ya', '-', '20240704contoh-tabel.jpg', '0', 2, '2024-07-04 07:42:51', '2024-07-04 07:42:51'),
	(6, 6, 'Tidak', 'tutup', '20240704e20cfbd6-91d7-4b10-8a42-3cb946c7a909.jpg', '0', 2, '2024-07-02 07:53:51', '2024-07-02 07:53:51'),
	(7, 7, 'Tidak', 'tutup', '20240704e20cfbd6-91d7-4b10-8a42-3cb946c7a909.jpg', '0', 2, '2024-07-02 07:53:52', '2024-07-02 08:10:58'),
	(8, 6, 'Ya', '-', '20240704icon user.png', '0', 2, '2024-07-04 08:27:14', '2024-07-04 08:27:14'),
	(9, 7, 'Ya', '-', '20240704icon user.png', '0', 2, '2024-07-04 08:27:14', '2024-07-04 08:27:14');



/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
