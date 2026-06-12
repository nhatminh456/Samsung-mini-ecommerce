-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: samsum_db
-- ------------------------------------------------------
-- Server version	8.0.44

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'S-Series','2026-05-19 07:33:30','2026-05-19 11:42:26'),(2,'A-Series','2026-05-19 07:33:30','2026-05-19 11:42:14'),(3,'M-Series','2026-05-19 07:33:30','2026-05-19 11:42:00'),(4,'Z-Series','2026-05-19 07:33:30','2026-05-19 11:41:49'),(5,'Phụ kiện','2026-05-19 07:33:30','2026-05-19 07:33:30'),(6,'Đồng hồ','2026-05-19 07:33:30','2026-05-19 07:33:30'),(7,'Màn Hình','2026-05-19 07:33:30','2026-05-19 11:56:14'),(8,'Gia Dụng','2026-05-19 07:33:30','2026-05-19 11:56:31');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'2026_05_10_045231_create_sessions_table',1),(3,'2026_05_10_152559_alter_user_id_in_sessions_table',1),(4,'2026_05_19_001415_create_product_variants_table',1),(5,'2026_05_19_001415_create_products_table',1),(6,'2026_05_19_001416_create_product_images_table',1),(7,'2026_05_19_140810_create_users_table',1),(12,'2026_05_19_185749_add_variant_id_to_product_images_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `variant_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_variant_id_foreign` (`variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (3,'ORD20260521191733AMUF',28,'Thử chuyển khoản (Mặc định - Mặc định)',10000.00,1,10000.00,NULL,NULL,64),(4,'ORD2026052119200012CF',28,'Thử chuyển khoản (Mặc định - Mặc định)',10000.00,1,10000.00,NULL,NULL,64),(5,'ORD20260521192316CVCQ',28,'Thử chuyển khoản (Mặc định - Mặc định)',10000.00,1,10000.00,NULL,NULL,64),(6,'ORD20260529231744IKJW',10,'Samsung Galaxy Z Flip 7 (Xanh dương - 256GB)',21490000.00,1,21490000.00,NULL,NULL,18),(9,'ORD20260609150559WZDQ',10,'Samsung Galaxy Z Flip 7 (Mint - 256GB)',21490000.00,1,21490000.00,NULL,NULL,17),(10,'ORD20260609150749HYCE',28,'Thử chuyển khoản (Mặc định - Mặc định)',10000.00,1,10000.00,NULL,NULL,64);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` enum('pending','processing','shipping','delivered','cancelled') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `payment_status` enum('unpaid','paid') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unpaid',
  `shipping_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('ORD20260521191733AMUF',3,'cohue@gmail.com',10000.00,'cancelled','unpaid','Minh Trần','0902578541','ádadadad','bank_transfer',NULL,NULL,NULL,'2026-05-21 12:17:33'),('ORD2026052119200012CF',3,'cohue@gmail.com',10000.00,'cancelled','unpaid','Minh Trần','0902578541','abc','bank_transfer',NULL,NULL,NULL,'2026-05-21 12:20:00'),('ORD20260521192316CVCQ',3,'cohue@gmail.com',10000.00,'shipping','paid','Minh Trần','0902578541','abc','bank_transfer',NULL,NULL,NULL,'2026-05-21 12:23:16'),('ORD20260529231744IKJW',3,'cohue@gmail.com',21490000.00,'pending','unpaid','Minh Trần','0902578541','abc','bank_transfer',NULL,NULL,NULL,'2026-05-29 16:17:44'),('ORD20260609150559WZDQ',8,'thaygia@gmail.com',21490000.00,'cancelled','unpaid','Minh Trần','0902578541','45/22 quang trung','bank_transfer',NULL,NULL,NULL,'2026-06-09 08:05:59'),('ORD20260609150749HYCE',8,'thaygia@gmail.com',10000.00,'pending','unpaid','Minh Trần','0902578541','45/22 quang trung','bank_transfer',NULL,NULL,NULL,'2026-06-09 08:07:49');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_images` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `variant_id` bigint unsigned DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`),
  KEY `product_images_variant_id_foreign` (`variant_id`),
  CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_images_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_images`
--

LOCK TABLES `product_images` WRITE;
/*!40000 ALTER TABLE `product_images` DISABLE KEYS */;
INSERT INTO `product_images` VALUES (10,'2026-05-19 12:41:59','2026-05-19 12:41:59',9,11,'https://www.didongmy.com/vnt_upload/product/05_2025/thumbs/600_600_samsung_galaxy_s25_ultra_5g_vang_hong_titan_didongmy_thumb_600x600_1.jpg'),(11,'2026-05-19 13:02:25','2026-05-19 13:02:25',9,12,'https://www.didongmy.com/vnt_upload/product/02_2025/thumbs/600_samsung_galaxy_s25_ultra_5g_xanh_ngoc_titan_didongmy_thumb_600x600.jpg'),(12,'2026-05-19 13:03:14','2026-05-19 13:03:14',9,13,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_ultra_5g_silver_didongmy_thumb_600x600_1.jpg'),(13,'2026-05-19 13:04:09','2026-05-19 13:04:09',9,14,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_ultra_5g_black_didongmy_thumb_600x600_1.jpg'),(14,'2026-05-19 13:22:24','2026-05-19 13:22:24',10,15,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_flip7_do_coral_didongmy_thumb_600x600.jpg'),(15,'2026-05-19 13:22:24','2026-05-19 13:22:24',10,16,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_flip7_black_didongmy_thumb_600x600jpg.jpg'),(16,'2026-05-19 13:22:24','2026-05-19 13:22:24',10,17,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_flip7_mint_didongmy_thumb_600x600_1.jpg'),(17,'2026-05-19 13:22:24','2026-05-19 13:22:24',10,18,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_flip7_blue_didongmy_thumb_600x600jpg.jpg'),(18,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,19,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_fold7_xam_didongmy_thumb_600x600_1.jpg'),(19,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,20,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_fold7_den_didongmy_thumb_600x600_1.jpg'),(20,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,21,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_fold7_xanh_bien_didongmy_thumb_600x600_1.jpg'),(21,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,22,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_fold7_mint_thumb_600x600_1.jpg'),(22,'2026-05-19 15:16:59','2026-05-19 15:16:59',12,23,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-ultra-silver-shadow-thumb-600x600-2.jpg'),(23,'2026-05-19 15:16:59','2026-05-19 15:16:59',12,24,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-ultra-black-thumb-600x600-2.jpg'),(24,'2026-05-19 15:16:59','2026-05-19 15:16:59',12,25,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-ultra-white-thumb-600x600-2.jpg'),(25,'2026-05-19 15:16:59','2026-05-19 15:16:59',12,26,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-ultra-violet-thumb-600x600-2.jpg'),(26,'2026-05-19 15:16:59','2026-05-19 15:16:59',12,27,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s6-ultra-sky-blue-thumb-600x600-2.jpg'),(27,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,28,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/(600x600)_samsung-galaxy-s26-plus-sky-blue-thumb-600x600.jpg'),(28,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,29,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-plus-violet-thumb-600x600.jpg'),(29,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,30,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-plus-white-thumb-600x600.jpg'),(30,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,31,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-plus-black-thumb-600x600.jpg'),(31,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,32,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-violet-thumb-600x600-1.jpg'),(32,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,33,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-black-thumb-600x600-1.jpg'),(33,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,34,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-white-thumb-600x600-1.jpg'),(34,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,35,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-sky-blue-thumb-600x600-1.jpg'),(35,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,36,'https://www.didongmy.com/vnt_upload/product/02_2026/thumbs/600_samsung-galaxy-s26-silver-shadow-thumb-600x600-1.jpg'),(36,'2026-05-19 15:27:49','2026-05-19 15:27:49',15,37,'https://www.didongmy.com/vnt_upload/product/05_2025/thumbs/600_samsung_galaxy_s25_edge_den_thumb_600x600.jpg'),(37,'2026-05-19 15:27:49','2026-05-19 15:27:49',15,38,'https://www.didongmy.com/vnt_upload/product/05_2025/thumbs/600_samsung_galaxy_s25_edge_xanh_thumb_600x600.jpg'),(38,'2026-05-19 15:27:49','2026-05-19 15:27:49',15,39,'https://www.didongmy.com/vnt_upload/product/05_2025/thumbs/600_samsung_galaxy_s25_edge_bac_thumb_600x600.jpg'),(39,'2026-05-19 15:31:00','2026-05-19 15:31:00',16,40,'https://www.didongmy.com/vnt_upload/product/03_2026/thumbs/600_samsung-galaxy-a57-tim.jpg'),(40,'2026-05-19 15:31:00','2026-05-19 15:31:00',16,41,'https://www.didongmy.com/vnt_upload/product/03_2026/thumbs/600_samsung-galaxy-a57-xam.jpg'),(41,'2026-05-19 15:31:00','2026-05-19 15:31:00',16,42,'https://www.didongmy.com/vnt_upload/product/03_2026/thumbs/600_samsung-galaxy-a57-xanh-nhat.jpg'),(42,'2026-05-19 15:35:43','2026-05-19 15:35:43',17,43,'https://www.didongmy.com/vnt_upload/product/03_2025/thumbs/600_samsung_galaxy_a56_5g_xam_thumb_600x600_2.png'),(43,'2026-05-19 15:35:43','2026-05-19 15:35:43',17,44,'https://www.didongmy.com/vnt_upload/product/03_2025/thumbs/600_samsung_galaxy_a56_5g_den_thumb_600x600_2.png'),(44,'2026-05-19 15:35:43','2026-05-19 15:35:43',17,45,'https://www.didongmy.com/vnt_upload/product/03_2025/thumbs/600_samsung_galaxy_a56_5g_xanh_thumb_600x600_2.png'),(45,'2026-05-19 15:39:46','2026-05-19 15:39:46',18,46,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/(600x600)_samsung_galaxy_z_flip7_fe_trang_didongmy_thumb_600x600_1.jpg'),(46,'2026-05-19 15:39:46','2026-05-19 15:39:46',18,47,'https://www.didongmy.com/vnt_upload/product/07_2025/thumbs/600_samsung_galaxy_z_flip7_fe_den_didongmy_thumb_600x600_1.jpg'),(47,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,48,'https://www.didongmy.com/vnt_upload/product/01_2024/thumbs/600_samsung_galaxy_s24_ultra_5g_xam_didongmy_thumb_600x600_1_3.jpg'),(48,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,49,'https://www.didongmy.com/vnt_upload/product/01_2024/thumbs/600_samsung_galaxy_s24_ultra_5g_tim_didongmy_thumb_600x600_1_3.jpg'),(49,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,50,'https://www.didongmy.com/vnt_upload/product/01_2024/thumbs/600_samsung_galaxy_s24_ultra_5g_den_didongmy_thumb_600x600_1_3.jpg'),(50,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,51,'https://www.didongmy.com/vnt_upload/product/01_2024/thumbs/600_samsung_galaxy_s24_ultra_5g_vang_didongmy_thumb_600x600_1_3.jpg'),(51,'2026-05-19 15:44:46','2026-05-19 15:44:46',20,52,'https://www.didongmy.com/vnt_upload/product/09_2024/thumbs/600_tai-nghe-samsung-galaxy-buds-3-pro.jpg'),(52,'2026-05-19 15:46:06','2026-05-19 15:46:06',21,53,'https://www.didongmy.com/vnt_upload/product/09_2024/thumbs/600_pin-du-phong-samsung-20000mah-sac-nhanh-pd-45-w-didongmy.jpg'),(53,'2026-05-19 15:47:50','2026-05-19 15:47:50',22,54,'https://www.didongmy.com/vnt_upload/product/09_2025/thumbs/600_usb-typec-lexar-256gb.jpg'),(54,'2026-05-19 15:50:42','2026-05-19 15:50:42',23,55,'https://cdn.tgdd.vn/Products/Images/7077/327692/samsung-galaxy-watch7-xanh-hc-1-750x500.jpg'),(55,'2026-05-19 15:53:13','2026-05-19 15:53:13',24,56,'https://images.samsung.com/is/image/samsung/p6pim/vn/ua75ue100fkxxv/gallery/vn-uhd-4k-tv-ua75ue100fkxxv-m-t-tr--c----en-548182376?$1164_776_PNG$'),(56,'2026-05-19 15:54:14','2026-05-19 15:54:14',25,57,'https://images.samsung.com/is/image/samsung/p6pim/vn/ua75ue100fkxxv/gallery/vn-uhd-4k-tv-ua75ue100fkxxv-m-t-tr--c----en-548182376?$1164_776_PNG$'),(57,'2026-05-20 05:10:21','2026-05-20 05:10:21',26,58,'https://www.didongmy.com/vnt_upload/product/08_2025/thumbs/600_samsung_galaxy_a17_5g_xam_khoi_thumb.jpg'),(58,'2026-05-20 05:10:21','2026-05-20 05:10:21',26,59,'https://www.didongmy.com/vnt_upload/product/08_2025/thumbs/600_samsung_galaxy_a17_5g_den_titan_thumb.jpg'),(59,'2026-05-20 05:10:21','2026-05-20 05:10:21',26,60,'https://www.didongmy.com/vnt_upload/product/08_2025/thumbs/600_samsung_galaxy_a17_5g_xanh_navy_thumb.jpg'),(60,'2026-05-20 05:12:40','2026-05-20 05:12:40',27,61,'https://www.didongmy.com/vnt_upload/product/06_2025/thumbs/(600x600)_samsung_galaxy_a16_5g_vang_thumb_600x600_1.jpg'),(61,'2026-05-20 05:12:40','2026-05-20 05:12:40',27,62,'https://www.didongmy.com/vnt_upload/product/06_2025/thumbs/600_samsung_galaxy_a16_5g_den_thumb_600x600_1.jpg'),(62,'2026-05-20 05:12:40','2026-05-20 05:12:40',27,63,'https://www.didongmy.com/vnt_upload/product/06_2025/thumbs/600_samsung_galaxy_a16_5g_xanh_thumb_600x600_1.jpg'),(63,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,65,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_plus_5g_silver_didongmy_thumb_600x600_1_1.jpg'),(64,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,66,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_plus_5g_xanh_la_nhat_didongmy_thumb_600x600_1_1.jpg'),(65,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,67,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_plus_5g_xanh_nhat_didongmy_thumb_600x600_1_1.jpg'),(66,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,68,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_plus_5g_xanh_duong_dam_navy_didongmy_thumb_600x600_1_1.jpg'),(67,'2026-05-21 15:28:27','2026-05-21 15:28:27',30,69,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_5g_bac_didongmy_thumb_600x600_1.jpg'),(68,'2026-05-21 15:28:27','2026-05-21 15:28:27',30,70,'https://www.didongmy.com/vnt_upload/product/01_2025/thumbs/600_samsung_galaxy_s25_5g_xanh_la_didongmy_thumb_600x600_1.jpg'),(69,'2026-05-21 15:37:20','2026-05-21 15:37:20',31,72,'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/d/i/dien-thoai-samsung-galaxy-m55_2.png'),(70,'2026-05-21 15:37:20','2026-05-21 15:37:20',31,73,'https://cdn2.cellphones.com.vn/358x/media/catalog/product/d/i/dien-thoai-samsung-galaxy-m55-5g-8gb-256gb.png'),(71,'2026-05-21 15:41:59','2026-05-21 15:41:59',32,74,'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/s/a/samsung-galaxy-m34-5g_1_2.png'),(72,'2026-05-21 15:41:59','2026-05-21 15:41:59',32,75,'https://cdn2.cellphones.com.vn/358x/media/catalog/product/7/d/7d86dab9-f942-4a90-a640-95ebcd0d9c70_1.jpg'),(73,'2026-05-21 15:41:59','2026-05-21 15:41:59',32,76,'https://cdn2.cellphones.com.vn/358x/media/catalog/product/c/3/c3845789-dda7-44d7-a9eb-bb8e775c9ffb_1.png'),(74,'2026-05-21 15:47:11','2026-05-21 15:47:11',33,77,'https://images.samsung.com/is/image/samsung/p6pim/vn/wd25db8995bzsv/gallery/vn-wd8000dk-wd25db8995bzsv-543263642?$1164_776_PNG$'),(75,'2026-05-21 15:48:55','2026-05-21 15:48:55',34,78,'https://images.samsung.com/is/image/samsung/p6pim/vn/rs90f65d2fsv/gallery/vn-rs80f-9-inch-ai-home-rs90f65d2fsv-545198320?$1164_776_PNG$'),(76,'2026-05-21 15:50:12','2026-05-21 15:50:12',35,79,'https://images.samsung.com/is/image/samsung/p6pim/vn/nv7b6675caa-sv/gallery/vn-nv7000b-nv7b6665iaa-nv7b6675caa-sv-539239244?$1164_776_PNG$'),(77,'2026-05-21 15:52:01','2026-05-21 15:52:01',36,80,'https://images.samsung.com/is/image/samsung/p6pim/vn/f-ar10cyfaa/gallery/vn-ar9500-wall-mount-ac-with-windfree-metal-cooling-wifi-1-f-ar10cyfaa-545439937?$1164_776_PNG$');
/*!40000 ALTER TABLE `product_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_variants`
--

DROP TABLE IF EXISTS `product_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `storage` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `stock_quantity` int NOT NULL DEFAULT '0',
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_variants`
--

LOCK TABLES `product_variants` WRITE;
/*!40000 ALTER TABLE `product_variants` DISABLE KEYS */;
INSERT INTO `product_variants` VALUES (11,'2026-05-19 12:41:59','2026-05-19 13:03:14',9,'Vàng Hồng','256GB',30690000.00,1,'SS-177919451939'),(12,'2026-05-19 13:02:25','2026-05-19 13:02:25',9,'Xanh Ngọc','256GB',25190000.00,3,'SS-177919574575'),(13,'2026-05-19 13:03:14','2026-05-19 13:03:14',9,'Bạc','256GB',24190000.00,4,'SS-177919579449'),(14,'2026-05-19 13:04:09','2026-05-19 13:04:09',9,'Đen','256GB',24190000.00,0,'SS-177919584944'),(15,'2026-05-19 13:22:24','2026-06-08 16:18:16',10,'Đỏ cam','256GB',21190000.00,10,'SS-177919694428'),(16,'2026-05-19 13:22:24','2026-05-19 13:22:24',10,'Đen','256GB',21490000.00,10,'SS-177919694475'),(17,'2026-05-19 13:22:24','2026-06-09 08:07:19',10,'Mint','256GB',21490000.00,10,'SS-177919694424'),(18,'2026-05-19 13:22:24','2026-05-29 16:17:44',10,'Xanh dương','256GB',21490000.00,9,'SS-177919694451'),(19,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,'Xám','256GB',37490000.00,10,'SS-177920357060'),(20,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,'Đen','256GB',37490000.00,4,'SS-177920357076'),(21,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,'Xanh Biển','256GB',37490000.00,10,'SS-177920357048'),(22,'2026-05-19 15:12:50','2026-05-19 15:12:50',11,'Mint','256GB',37490000.00,0,'SS-177920357051'),(23,'2026-05-19 15:16:59','2026-06-06 01:32:52',12,'Bạc','256GB',35000000.00,15,'SS-177920381979'),(24,'2026-05-19 15:16:59','2026-06-06 01:32:01',12,'Đen','256GB',30000000.00,6,'SS-177920381984'),(25,'2026-05-19 15:16:59','2026-06-08 15:32:45',12,'Trắng','256GB',35000000.00,7,'SS-177920381998'),(26,'2026-05-19 15:16:59','2026-06-06 01:32:52',12,'Tím','256GB',34999999.00,8,'SS-177920381958'),(27,'2026-05-19 15:16:59','2026-06-06 01:32:52',12,'Blue Sky','256GB',35000000.00,10,'SS-177920381923'),(28,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,'Blue Sky','256GB',24990000.00,10,'SS-177920398884'),(29,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,'Tím','256GB',24990000.00,10,'SS-177920398812'),(30,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,'Trắng','256GB',24990000.00,9,'SS-177920398812'),(31,'2026-05-19 15:19:48','2026-05-19 15:19:48',13,'Đen','256GB',24990000.00,6,'SS-177920398859'),(32,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,'Đen','256GB',24790000.00,10,'SS-177920430529'),(33,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,'Đen','256GB',24790000.00,10,'SS-177920430543'),(34,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,'Trắng','256GB',24790000.00,10,'SS-177920430561'),(35,'2026-05-19 15:25:05','2026-05-19 15:25:05',14,'Blue Sky','256GB',24790000.00,10,'SS-177920430532'),(36,'2026-05-19 15:25:05','2026-05-19 15:25:19',14,'Bạc','256GB',24790000.00,10,'SS-177920430513'),(37,'2026-05-19 15:27:49','2026-05-19 15:27:49',15,'Đen','256GB',18390000.00,10,'SS-177920446910'),(38,'2026-05-19 15:27:49','2026-05-19 15:27:49',15,'Xanh','256GB',18390000.00,10,'SS-177920446956'),(39,'2026-05-19 15:27:49','2026-05-19 15:27:49',15,'Bạc','256GB',18390000.00,10,'SS-177920446996'),(40,'2026-05-19 15:31:00','2026-05-19 15:31:00',16,'Tím','256GB',12390000.00,10,'SS-177920466054'),(41,'2026-05-19 15:31:00','2026-05-19 15:31:00',16,'Xám','256GB',12390000.00,10,'SS-177920466015'),(42,'2026-05-19 15:31:00','2026-05-19 15:31:00',16,'Xanh nhạt','256GB',12390000.00,10,'SS-177920466085'),(43,'2026-05-19 15:35:43','2026-05-19 15:35:43',17,'Xám','Mặc định',9690000.00,10,'SS-177920494376'),(44,'2026-05-19 15:35:43','2026-05-19 15:35:43',17,'Đen','256GB',9690000.00,10,'SS-177920494311'),(45,'2026-05-19 15:35:43','2026-05-19 15:35:43',17,'Xanh lá','256GB',9690000.00,0,'SS-177920494316'),(46,'2026-05-19 15:39:46','2026-05-19 15:39:46',18,'Trắng','256GB',21990000.00,10,'SS-177920518669'),(47,'2026-05-19 15:39:46','2026-05-19 15:39:46',18,'Đen','256GB',21990000.00,10,'SS-177920518629'),(48,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,'Xám','256GB',16989998.00,10,'SS-177920535855'),(49,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,'Tím','256GB',16990000.00,9,'SS-177920535825'),(50,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,'Đen','256GB',16990000.00,10,'SS-177920535869'),(51,'2026-05-19 15:42:38','2026-05-19 15:42:38',19,'Vàng','256GB',16990000.00,10,'SS-177920535831'),(52,'2026-05-19 15:44:46','2026-05-19 15:44:46',20,'Đen','0',3790000.00,10,'SS-177920548621'),(53,'2026-05-19 15:46:06','2026-05-19 15:46:13',21,'Xám','Mặc định',990000.00,10,'SS-177920556650'),(54,'2026-05-19 15:47:50','2026-05-19 15:47:50',22,'Xám','Mặc định',849000.00,0,'SS-177920567026'),(55,'2026-05-19 15:50:42','2026-05-19 15:50:42',23,'Mặc định','Mặc định',4990000.00,10,'SS-177920584218'),(56,'2026-05-19 15:53:13','2026-05-19 15:53:13',24,'Đen','Mặc định',19440000.00,0,'SS-177920599324'),(57,'2026-05-19 15:54:14','2026-05-19 15:54:14',25,'Đen','Mặc định',19439999.00,10,'SS-177920605437'),(58,'2026-05-20 05:10:21','2026-05-20 05:10:21',26,'Xám','256GB',6090000.00,10,'SS-177925382171'),(59,'2026-05-20 05:10:21','2026-05-20 05:10:21',26,'Đen','256GB',6090000.00,10,'SS-177925382118'),(60,'2026-05-20 05:10:21','2026-05-20 05:10:21',26,'Xanh','256GB',6090000.00,10,'SS-177925382161'),(61,'2026-05-20 05:12:40','2026-05-20 05:12:40',27,'Vàng','256GB',5290000.00,10,'SS-177925396098'),(62,'2026-05-20 05:12:40','2026-05-20 05:12:40',27,'Đen','256GB',5290000.00,10,'SS-177925396048'),(63,'2026-05-20 05:12:40','2026-05-20 05:12:40',27,'Xanh','256GB',5290000.00,9,'SS-177925396045'),(64,'2026-05-21 12:15:00','2026-06-09 08:07:49',28,'Mặc định','Mặc định',10000.00,98,'SS-177936570040'),(65,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,'Bạc','256GB',20990000.00,10,'SS-177937718676'),(66,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,'Xanh lá','256GB',20990000.00,10,'SS-177937718690'),(67,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,'Xanh nhạt','256GB',20990000.00,10,'SS-177937718636'),(68,'2026-05-21 15:26:26','2026-05-21 15:26:26',29,'Xanh đạm','256GB',20990000.00,10,'SS-177937718663'),(69,'2026-05-21 15:28:27','2026-05-21 15:28:27',30,'Bạc','256GB',16390000.00,10,'SS-177937730744'),(70,'2026-05-21 15:28:27','2026-05-21 15:28:27',30,'Xanh','256GB',16390000.00,10,'SS-177937730742'),(71,'2026-05-21 15:28:27','2026-05-21 15:28:27',30,'Xanh nhạt','256GB',16390000.00,0,'SS-177937730748'),(72,'2026-05-21 15:37:20','2026-05-21 15:37:20',31,'Xanh','256GB',6990000.00,10,'SS-177937784039'),(73,'2026-05-21 15:37:20','2026-05-21 15:37:20',31,'Đen','256GB',6990000.00,0,'SS-177937784096'),(74,'2026-05-21 15:41:59','2026-05-21 15:41:59',32,'Bạc','256GB',5890000.00,10,'SS-177937811984'),(75,'2026-05-21 15:41:59','2026-05-21 15:41:59',32,'Xanh nhạt','256GB',5890000.00,10,'SS-177937811979'),(76,'2026-05-21 15:41:59','2026-05-21 15:41:59',32,'Xanh đậm','256GB',5890000.00,0,'SS-177937811989'),(77,'2026-05-21 15:47:11','2026-05-21 15:47:11',33,'Đen','Mặc định',63890000.00,10,'SS-177937843111'),(78,'2026-05-21 15:48:55','2026-05-21 15:48:55',34,'Đen','Mặc định',41990000.00,0,'SS-177937853568'),(79,'2026-05-21 15:50:12','2026-05-21 15:50:12',35,'Nâu','Mặc định',34390000.00,10,'SS-177937861246'),(80,'2026-05-21 15:52:01','2026-05-21 15:52:01',36,'Mặc định','Mặc định',10910000.00,10,'SS-177937872184');
/*!40000 ALTER TABLE `product_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_bestseller` tinyint(1) NOT NULL DEFAULT '0',
  `category_id` bigint unsigned DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `specifications` text COLLATE utf8mb4_unicode_ci,
  `release_year` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (9,'Samsung Galaxy S25ultra','2026-05-19 12:41:59','2026-05-19 15:09:27',0,1,'Màn hình: Dynamic AMOLED, 6.9 inch, 2K+ (1440 x 3120 Pixels)\r\nCamera trước: 12 MP\r\nCamera sau: Chính 200 MP & Phụ 50 MP, 50 MP, 10 MP\r\nChipset: Qualcomm Snapdragon 8 Elite for Galaxy\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android (15)',NULL,NULL),(10,'Samsung Galaxy Z Flip 7','2026-05-19 13:22:24','2026-05-19 13:22:52',0,4,'Màn hình: Dynamic LTPO AMOLED 2X, 6.9 inches + 4.1 inches\r\nCamera trước: 10 MP, f/2.2, 23mm (wide)\r\nCamera sau: 50 MP, f/1.8, 23mm (wide) + 12 MP, f/2.2, 13mm, 123˚ (ultrawide)\r\nChipset:	Exynos 2500 (3 nm)\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 16, One UI 8',NULL,NULL),(11,'Samsung Galaxy Z Fold7','2026-05-19 15:12:50','2026-05-19 15:12:50',0,4,'Màn hình: Dynamic LTPO AMOLED 2X, 120Hz, 8.0 inches + 6.5 inches\r\nCamera trước: 10 MP, f/2.2, 18mm (ultrawide)\r\nCamera sau: 200 MP, f/1.7 + 10 MP, f/2.4 + 12 MP, f/2.2\r\nChipset: Qualcomm Snapdragon 8 Elite (3 nm)\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 16, One UI 8',NULL,NULL),(12,'Samsung Galaxy S26 Ultra','2026-05-19 15:16:59','2026-05-19 15:16:59',1,1,'Màn hình: Dynamic LTPO AMOLED 2X, 6.9 inches, 1440 x 3120 pixels\r\nCamera trước: 12 MP, f/2.2, 26mm (wide)\r\nCamera sau: 200 MP, f/1.4, 24mm (wide)\r\n10 MP, f/2.4, (telephoto)\r\n50 MP, f/2.9, 111mm (periscope telephoto)\r\n50 MP, f/1.9, 120˚ (ultrawide)\r\nChipset:	Qualcomm Snapdragon 8 Elite Gen 5 (3 nm)\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 16, 07 năm cập nhật phần mềm, One UI 8.5',NULL,NULL),(13,'Samsung Galaxy S26 Plus','2026-05-19 15:19:48','2026-05-19 15:20:09',0,1,'Màn hình: Dynamic LTPO AMOLED 2X, 6.7 inches, 1440 x 3120 pixels\r\nCamera trước: 12 MP, f/2.2, 26mm (wide)\r\nCamera sau:	50 MP, f/1.8, 24mm (wide)\r\n10 MP, f/2.4, 67mm (telephoto)\r\n12 MP, f/2.2, 13mm, 120˚ (ultrawide)\r\nChipset:	Exynos 2600 (2 nm)\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 16, 07 năm cập nhật phần mềm, One UI 8.5',NULL,NULL),(14,'Samsung Galaxy S26','2026-05-19 15:25:05','2026-05-19 15:25:19',0,1,'Màn hình: Dynamic LTPO AMOLED 2X, 6.3 inches, 1080 x 2340 pixels\r\nCamera trước: 12 MP, f/2.2, 26mm (wide)\r\nCamera sau: 50 MP, f/1.8, 24mm (wide)\r\n10 MP, f/2.4, 67mm (telephoto)\r\n12 MP, f/2.2, 13mm, 120˚ (ultrawide)\r\nChipset: Exynos 2600 (2 nm)\r\nRom: 512 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 16, 07 năm cập nhật phần mềm, One UI 8.5',NULL,NULL),(15,'Samsung Galaxy S25 Edge','2026-05-19 15:27:49','2026-05-19 15:27:49',0,1,'Màn hình:	Dynamic AMOLED, 6.7 inch, 1440 x 3120 pixels\r\nCamera trước: 12 MP\r\nCamera sau: 200 MP, f/1.7 + 12 MP, f/2.2\r\nChipset: Qualcomm Snapdragon 8 Elite for Galaxy\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 15, One UI 7',NULL,NULL),(16,'Samsung Galaxy A57','2026-05-19 15:31:00','2026-05-19 15:31:00',1,2,'Màn hình: Super AMOLED+, 120Hz, 6.7 inches, Full HD+ (1080 x 2340 pixels)\r\nCamera trước: 12 MP, f/2.2, (wide)\r\nCamera sau: 50 MP, f/1.8, (wide)\r\n12 MP, f/2.2, 123˚ (ultrawide)\r\n5 MP, f/2.4\r\nChipset:	Exynos 1680 (4 nm)\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 16, 6 năm cập nhật phần mềm, One UI 8.5',NULL,NULL),(17,'Samsung Galaxy A56','2026-05-19 15:35:43','2026-05-19 15:35:43',0,2,'Màn hình: Super AMOLED, 6.7 inch, 120 Hz, Full HD+ (1080 x 2340 Pixels)\r\nCamera trước: 12 MP\r\nCamera sau:	Chính 50 MP & Phụ 12 MP, 5 MP\r\nChipset:	Exynos 1580\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 15',NULL,NULL),(18,'Samsung Galaxy Z Flip7 FE','2026-05-19 15:39:46','2026-05-19 15:39:46',0,4,'Màn hình: Dynamic LTPO AMOLED 2X, 6.7 inches + 3.4 inches\r\nCamera trước: 10 MP, f/2.2, 23mm (wide)\r\nCamera sau: 50 MP, f/1.8, 23mm (wide) + 12 MP, f/2.2, 13mm, 123˚ (ultrawide)\r\nChipset:	Exynos 2400 (4 nm)\r\nRom: 256 GB\r\nRAM: 8 GB\r\nHệ điều hành:	Android 16, One UI 8',NULL,NULL),(19,'Samsung Galaxy S24ultra','2026-05-19 15:42:38','2026-05-19 15:42:38',0,1,'Màn hình: Dynamic LTPO AMOLED 2X, 6.8\'\', 1440 x 3088 pixels\r\nCamera trước: 12 MP, f/2.2\r\nCamera sau: 200 MP, f/1.7 + 50 MP PDAF, OIS + 10 MP, f/2.4 + 12 MP, f/2.2\r\nChipset: Qualcomm SM8650-AC Snapdragon 8 Gen 3 (4 nm)\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android 14, One UI 6.1',NULL,NULL),(20,'Tai nghe Bluetooth Samsung Galaxy Buds3','2026-05-19 15:44:46','2026-05-19 15:44:46',0,5,'Thời gian sử dụng tai nghe:7 giờ (Tắt ANC) / 6 giờ (Bật ANC)\r\nSản xuất tại	Việt Nam, Trung Quốc, Hàn Quốc\r\nTrọng lượng	Tai nghe: 5.4g\r\nHộp sạc: 46.5g\r\nPhím điều khiển: Cảm ứng chạm\r\nĐiều khiển: Cảm ứng chạm\r\nNhấn thanh bar\r\nKết nối cùng lúc: 1 thiết bị\r\nTiện ích	Tự động chuyển đổi kết nối giữa các thiết bị Galaxy\r\nPhiên dịch viên hỗ trợ nghe bản dịch trực tiếp\r\nTự động tinh chỉnh ANC\r\nThanh ánh sáng Blade Lights\r\nTương thích	Các thiết bị có hỗ trợ Bluetooth\r\nCông nghệ âm thanh	Chống ồn chủ động ANC\r\nÂm thanh Hi-Fi 24 bit\r\nÂm thanh vòm 360\r\nÂm thanh xung quanh\r\nHệ thống âm thanh kép\r\nHệ thống loa 2 chiều\r\nCổng sạc: USB-C\r\nThời gian sử dụng hộp sạc	30 giờ (Tắt ANC) / 26 giờ (Bật ANC)',NULL,NULL),(21,'Pin dự phòng Samsung 20.000mAh','2026-05-19 15:46:06','2026-05-19 15:46:06',0,5,NULL,NULL,NULL),(22,'USB 3.2 Gen 1 (Type-C) Lexar','2026-05-19 15:47:50','2026-05-19 15:47:50',0,5,NULL,NULL,NULL),(23,'Samsung Galaxy Watch7 40mm dây silicone','2026-05-19 15:50:42','2026-05-19 15:50:42',0,6,'Công nghệ màn hình:\r\nSuper AMOLED\r\nKích thước màn hình: 1.3 inch\r\nĐộ phân giải: 432 x 432 pixels\r\nKích thước mặt: 40 mm',NULL,NULL),(24,'Crystal UHD UE100F 4K Smart TV','2026-05-19 15:53:13','2026-05-19 15:53:13',0,7,NULL,NULL,NULL),(25,'Crystal UHD UE100F 4K Smart TV','2026-05-19 15:54:14','2026-05-19 15:54:14',0,7,NULL,NULL,NULL),(26,'Samsung Galaxy A17','2026-05-20 05:10:21','2026-05-20 05:10:21',0,2,'Màn hình:	Super AMOLED, 6.7 inch, Full HD+ (1080 x 2340 Pixels)\r\nCamera trước: 13 MP\r\nCamera sau: Chính 50 MP & Phụ 5 MP, 2 MP\r\nChipset: Exynos 1330\r\nRom: 256 GB\r\nRAM: 8 GB\r\nHệ điều hành:	Android 15',NULL,NULL),(27,'Samsung Galaxy A16','2026-05-20 05:12:40','2026-05-20 05:12:40',0,2,'Màn hình: Super AMOLED, 6.7 inches, 1080 x 2340 pixel\r\nCamera trước: 13 MP, f/2.0, (wide)\r\nCamera sau: 50 MP, f/1.8 + 5 MP, f/2.2 + 2 MP, f/2.4\r\nChipset: MediaTek Dimensity 6300\r\nRom: 256 GB\r\nRAM: 8 GB\r\nHệ điều hành:	Android 14 (6 bản cập nhật phần mềm)',NULL,NULL),(28,'Thử chuyển khoản','2026-05-21 12:15:00','2026-05-21 12:15:00',0,5,NULL,NULL,NULL),(29,'Samsung Galaxy S25 Plus','2026-05-21 15:26:26','2026-05-21 15:26:26',0,1,'Màn hình:	Dynamic AMOLED, 6.7 inch, 3088 x 1440 px, 509 PPI\r\nCamera trước: 12 MP\r\nCamera sau: 50 MP + 10 MP + 12 MP\r\nChipset: Qualcomm Snapdragon 8 Elite\r\nRom: 512 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android (15)',NULL,NULL),(30,'Samsung Galaxy S25','2026-05-21 15:28:27','2026-05-21 15:28:27',0,1,'Màn hình:	Dynamic AMOLED, 6.3 inch, 2340 x 1080 px, 409 PPI\r\nCamera trước: 12 MP\r\nCamera sau: 50 MP + 10 MP + 12 MP\r\nChipset: Qualcomm Snapdragon 8 Elite\r\nRom: 256 GB\r\nRAM: 12 GB\r\nHệ điều hành:	Android (15)',NULL,NULL),(31,'Samsung Galaxy M55','2026-05-21 15:37:20','2026-05-21 15:37:20',0,3,'Kích thước màn hình	\r\n6.7 inches\r\nCông nghệ màn hình	\r\nSuper AMOLED Plus\r\nCamera sau	\r\nCamera góc rộng: 50 MP, f/1.8, 1/1.56\", 1.0µm, PDAF, OIS\r\nCamera góc siêu rộng: 8 MP, f/2.2, 123˚\r\nCamera macro: 2 MP, f/2.4\r\n\r\nCamera trước	\r\nCamera góc rộng: 50 MP, f/2.4\r\n\r\nChipset	\r\nQualcomm Snapdragon 7 Gen 1 (4 nm)\r\nCông nghệ NFC	\r\nCó\r\nDung lượng RAM	\r\n8 GB\r\nBộ nhớ trong	\r\n256 GB\r\nPin	\r\n5000 mAh\r\nThẻ SIM	\r\n2 SIM (Nano-SIM)\r\nHệ điều hành	\r\nAndroid 14\r\nĐộ phân giải màn hình	\r\n1080 x 2400 pixels (FullHD+)\r\nTính năng màn hình	\r\nTần số quét 120Hz, 1000 nits\r\nLoại CPU	\r\n1x2.4 GHz Cortex-A710 & 3x2.36 GHz Cortex-A710 & 4x1.8 GHz Cortex-A510',NULL,NULL),(32,'Samsung Galaxy M34','2026-05-21 15:41:59','2026-05-21 15:41:59',0,3,'Kích thước màn hình: 6.5 inches\r\nCông nghệ màn hình :Super AMOLED\r\nCamera sau: 50 MP	\r\nCamera góc rộng: 50 MP, f/1.8, PDAF, OIS\r\nCamera góc siêu rộng:8 MP, f/2.2, 120˚\r\nCamera trước: 2 MP, f/2.4\r\nCamera góc rộng: 13 MP, f/2.2\r\nChipset: Exynos 1280 (5 nm)\r\nCông nghệ NFC: Có\r\nDung lượng RAM: 8 GB\r\nBộ nhớ trong: 128 GB\r\nPin: 6000 mAh\r\nThẻ SIM: 2 SIM (Nano-SIM)\r\nHệ điều hành: Android 13\r\nĐộ phân giải màn hình: 1080 x 2340 pixels (FullHD+)\r\nTính năng màn hình	\r\nTốc độ làm mới: 120Hz, 1000 nits\r\nLoại CPU: 2x2.4 GHz Cortex-A78 & 6x2.0 GHz Cortex-A55',NULL,NULL),(33,'Máy Giặt Sấy Bơm Nhiệt Giặt sấy 2-in-1','2026-05-21 15:47:11','2026-05-21 15:47:11',0,8,'Trang bị máy nén cao cấp liên tục tuần hoàn khí nóng để sấy khô áo quần nhanh chóng & tiết kiệm đến 75%* điện năng. Kết hợp AI liên tục cảm biến độ ẩm suốt quá trình sấy, tự động điều chỉnh nhiệt độ, thời gian & lưu lượng khí sấy phù hợp giúp áo quần khô đồng đều; duy trì nhiệt độ sấy tối ưu (dưới 60 độ C), giúp bảo vệ sợi vải, chống co rút.',NULL,NULL),(34,'Tủ Lạnh Side By Side Màn Hình AI Home 9','2026-05-21 15:48:55','2026-05-21 15:48:55',0,8,'Cảm biến được tích hợp ở hai bên cánh tủ, giúp bạn dễ dàng mở cửa* chỉ với một chạm ngay cả khi đang cầm nắm đầy tay. Đèn cảm biến giúp bạn xác định vị trí nhanh chóng, đồng thời tủ phát ra âm thanh thông báo khi cửa mở. Đặc biệt, thiết kế phẳng không tay nắm mang đến vẻ ngoài tinh tế và hiện đại.',NULL,NULL),(35,'Lò Nướng Nướng Linh Hoạt Dual Cook 76 L','2026-05-21 15:50:12','2026-05-21 15:50:12',0,8,'Công nghệ Dual Cook giúp bạn linh hoạt nướng đồng thời nhiều món ăn ở các mức nhiệt độ khác nhau. Khoang lò trên và dưới có thể được sử dụng độc lập hoặc kết hợp với nhau, mang đến sự linh hoạt, đồng thời tiết kiệm thời gian nấu nướng và điện năng tiêu thụ. Khi chia khoang lò, bạn có thể chỉ sử dụng một khoang lò trên hoặc dưới để nướng các món ăn nhỏ; hoặc sử dụng cả hai khoang lò với kiểm soát độc lập để nướng cùng lúc nhiều món ăn với thời gian và nhiệt độ riêng biệt. Hơn thế nữa, bạn có thể sử dụng toàn bộ lò nướng cho món ăn có kích thước lớn, ví dụ như một con gà tây.',NULL,NULL),(36,'Điều Hòa Bespoke AI Wind','2026-05-21 15:52:01','2026-05-21 15:52:01',0,8,'Công nghệ Digital Inverter Boost mới giúp tiết kiệm điện năng hiệu quả lên đến 73% và duy trì ổn định nhiệt độ mong muốn. Với nam châm Neodymium và bộ giảm âm kép Twin Tube Muffler, máy hoạt động yên tĩnh, êm ái và bền lâu.',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('4DdfXF88T0q76SFspXO7Af2Ll7MVOcaAtDlHt0SF','3','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiUWtvVmhRZFAxZjB1NEYwd2Q0bDZocFhTaVhTREV3ZlcxeUw2ZEdlNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjc6InVzZXJfaWQiO2k6MztzOjEwOiJ1c2VyX2VtYWlsIjtzOjE1OiJjb2h1ZUBnbWFpbC5jb20iO3M6OToidXNlcl9yb2xlIjtzOjQ6InVzZXIiO3M6ODoidXNlcm5hbWUiO3M6MTU6ImNvaHVlQGdtYWlsLmNvbSI7fQ==',1780935650),('aBRjm0NYqddiLwsgm8mcPfDh0uWbKvU0DPlJBbER','1','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoieFB4TDlVV1k2NjNWZnVVbTlPSmJWdWVVaUlzYXpkUHFUOEZCS2xQZiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjc6InVzZXJfaWQiO2k6MTtzOjEwOiJ1c2VyX2VtYWlsIjtzOjIxOiJuaGF0bWluaDQ1NkBnbWFpbC5jb20iO3M6OToidXNlcl9yb2xlIjtzOjU6ImFkbWluIjtzOjg6InVzZXJuYW1lIjtzOjIxOiJuaGF0bWluaDQ1NkBnbWFpbC5jb20iO30=',1780993142),('jquMr2bb9wDqmZMsAhLXlmfN1rC6rDZeNjEJAmqp',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmhBamZBQUxxVlhwS0FJa3RGRVN4WWlmcHd3a3k2c2taRFFEVDhtNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1781007029),('mJpWsox47wQ1EUxVxQK2xZlYfeO5Z4oRtxhbmV4h',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoibmQyZUFodUZ1U2hXRlY2NmQxVnNzRWRzV0VvS00wVFN0Sko5Q05OQyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fX0=',1780975021);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','nhatminh456@gmail.com','$2y$12$LVSkuxsmyynsbmSmpeFSIe6WWTBEDSsb8z24dJ9bjxF/Ol3QqrSJG','admin','2026-05-19 07:16:12','2026-05-19 07:16:12'),(2,'testuser','test@test.com','123456','user','2026-05-19 08:04:36','2026-05-19 08:04:36'),(3,'kimhue123','cohue@gmail.com','$2y$12$Uf03f3d011gM0sHzOsi.1OrV23BeaM3Nm9FZLIPS.PIAb73BhB45G','user','2026-05-19 08:12:28','2026-05-19 08:12:28'),(4,'nhatminh68','tranminh29012005@gmail.com','$2y$12$BIceWKPi.ZU4qNzZBiOi5uKfpB0YL4b8rO6P7LfOhZ/T6MdGrEnJi','user','2026-05-19 08:25:47','2026-05-19 08:25:47'),(8,'thaygia123','thaygia@gmail.com','$2y$12$4lcrHDTvodHg8MG47WyrROXAPXbppo281MvR9HZB218ndrKc./UEy','user','2026-06-09 07:57:00','2026-06-09 07:57:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-09 22:53:52
