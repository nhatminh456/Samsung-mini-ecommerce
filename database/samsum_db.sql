CREATE DATABASE  IF NOT EXISTS `samsum_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `samsum_db`;
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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` int NOT NULL,
  `tenDM` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'S-Series'),(2,'A-Series'),(3,'M-Series'),(4,'Z-Series'),(5,'Phụ kiện'),(6,'Gia Dụng'),(7,'Màn Hình'),(8,'Đồng hồ');
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
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'2026_05_10_045231_create_sessions_table',2),(3,'2026_05_10_152559_alter_user_id_in_sessions_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `quantity` int NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_order_items_order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (4,'ORD20260510161654GDLS','1','Samsung Galaxy S24 Ultra',29990000.00,1,29990000.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `shipping_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shipping_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `idx_orders_user_id` (`user_id`),
  KEY `idx_orders_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES ('ORD20260510161654GDLS','USR1778428904GH5','cohue@gmail.com','2026-05-10 16:16:54',29990000.00,'pending','Trần Kim Huệ','0702390036','371, Nguyễn Kiệm, P. Hạnh Thông, Gò Vấp','COD',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` varchar(50) NOT NULL,
  `tenSP` varchar(255) NOT NULL,
  `gia` int NOT NULL,
  `categoryID` int DEFAULT NULL,
  `image` text,
  `mota` text,
  `namSX` int DEFAULT NULL,
  `thongso` text,
  `bestSeller` tinyint(1) DEFAULT '0',
  `stock_quantity` int DEFAULT '100',
  PRIMARY KEY (`id`),
  KEY `categoryID` (`categoryID`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES ('1','Samsung Galaxy S24 Ultra',29990000,1,'S24u.jpg','Flagship cao cấp nhất 2024',2024,'Snapdragon 8 Gen 3, 12GB RAM',1,100),('10','Samsung Galaxy S25 Plus',26990000,1,'S25plus.jpg','S25 màn hình lớn',2025,'Snapdragon 8 Gen 4, 12GB RAM',0,100),('11','Samsung Galaxy S25',21990000,1,'S25.jpg','Flagship nhỏ gọn 2025',2025,'Snapdragon 8 Gen 4, 8GB RAM',0,100),('12','Samsung Galaxy S23 Ultra',24990000,1,'S23u.jpg','Flagship 2023',2023,'Snapdragon 8 Gen 2, 12GB RAM',0,100),('13','Samsung Galaxy S23 Ultra Black',24990000,1,'S23u2.jpg','Màu đen huyền bí',2023,'Snapdragon 8 Gen 2, 12GB RAM',0,100),('14','Samsung Galaxy S23 Plus',20990000,1,'S23plus.jpg','S23 màn hình lớn',2023,'Snapdragon 8 Gen 2, 8GB RAM',0,100),('15','Samsung Galaxy S23',16990000,1,'S23.jpg','Flagship nhỏ gọn 2023',2023,'Snapdragon 8 Gen 2, 8GB RAM',0,100),('16','Samsung Galaxy A54',9490000,2,'sama54.jpg','Tầm trung nổi bật',2023,'Exynos 1380, 8GB RAM',0,100),('17','Samsung Galaxy A35',8490000,2,'samsuma35.jpg','Giá tốt, hiệu năng ổn',2024,'Exynos 1380, 6GB RAM',1,100),('18','Samsung Galaxy A25',6490000,2,'samsuma25.jpg','Phổ thông tốt',2024,'Exynos 1280, 6GB RAM',1,100),('19','Samsung Galaxy A34',7990000,2,'samsuma34.jpg','Cân bằng tốt',2023,'Dimensity 1080, 8GB RAM',0,100),('2','Samsung Galaxy A55',10990000,2,'A55.jpg','Tầm trung mạnh mẽ',2024,'Exynos 1480, 8GB RAM',1,100),('20','Samsung Galaxy A24',5990000,2,'samsuma24.jpg','Giá rẻ đáng mua',2023,'Helio G99, 6GB RAM',0,100),('21','Samsung Galaxy A14',3990000,2,'samsuma14.jpg','Giá tốt nhất',2023,'Helio G80, 4GB RAM',0,100),('22','Samsung Galaxy A05',2990000,2,'samsuma05.jpg','Phổ thông rẻ nhất',2023,'Helio G85, 4GB RAM',0,100),('23','Samsung Galaxy M35',8490000,3,'samsumm35.jpg','Pin khủng 6000mAh',2024,'Exynos 1380, 8GB RAM',1,100),('24','Samsung Galaxy M34',7490000,3,'samsumm34.jpg','Pin trâu 6000mAh',2023,'Exynos 1280, 6GB RAM',0,100),('25','Samsung Galaxy Z Fold 6',41990000,4,'zfold6.jpg','Gập cao cấp 2024',2024,'Snapdragon 8 Gen 3, 12GB RAM',0,100),('26','Samsung Galaxy Z Fold 5',36990000,4,'Zfold5.jpg','Gập thế hệ 5',2023,'Snapdragon 8 Gen 2, 12GB RAM',0,100),('27','Samsung Galaxy Z Flip 7',24990000,4,'zflip7.jpg','Gập vỏ sò 2025',2025,'Snapdragon 8 Gen 4, 8GB RAM',0,100),('28','Samsung Galaxy Z Flip 6',21990000,4,'zflip6.jpg','Gập vỏ sò mới',2024,'Snapdragon 8 Gen 3, 8GB RAM',0,100),('29','Samsung Galaxy Z Flip 5',18990000,4,'zflip5.jpg','Gập vỏ sò gen 5',2023,'Snapdragon 8 Gen 2, 8GB RAM',0,100),('3','Samsung Galaxy M55',9490000,3,'m55.jpg','Pin trâu, sạc nhanh',2024,'Snapdragon 7 Gen 1, 8GB RAM',1,100),('30','Samsung Galaxy Z Flip 4',15990000,4,'zflip4.jpg','Gập vỏ sò 2022',2022,'Snapdragon 8+ Gen 1, 8GB RAM',0,100),('31','Samsung W25',55990000,4,'w25.jpg','Gập siêu cao cấp Trung Quốc',2024,'Snapdragon 8 Gen 3, 16GB RAM',0,100),('32','SamsumGalaxy S26Ultra',30000000,1,'S26u.jpg','',2024,'',0,100),('33','Sạc Anker 511 Nano 3 30W - A2147',300000,5,'anker.jpg','Bằng cách thay silicon cho GaN, chúng tôi đã có thể lắp công suất 30W vào bộ sạc chỉ dày 1,12 inch và nhỏ hơn 70% so với bộ sạc 30W ban đầu.',2024,'Công suất tối đa: 30W (Sạc được MacBook Air)\r\nCổng kết nối 1 :cổng USB-C\r\n',0,100),('34','Cục sạc Ugreen',790000,5,'ugreen.jpg','',2024,'Dành cho: iPhone, iPad cơ bản, Samsung dòng thường.\r\n\r\nCông nghệ: GaN II hoặc Mini Si.\r\n\r\nCổng kết nối: Thường là 1 cổng USB-C.\r\n\r\nThông số chuẩn:\r\n\r\nInput: 100-240V ~ 50/60Hz (Dùng được toàn cầu).\r\n\r\nOutput: 5V/3A, 9V/2.22A, 12V/1.67A.\r\n\r\nGiao thức hỗ trợ: PD 3.0 (iPhone), QC 4.0 (Android), PPS (Samsung - rất quan trọng).\r\n\r\nĐặc điểm bán hàng: Kích thước cực nhỏ (chỉ bằng cục sạc 5W ngày xưa của Apple), chân cắm thường gập lại được.',0,100),('35','Cường lực ',480000,5,'Cuongluc.jpg','Cường lực dành cho S Series',2024,'',0,100),('36','Cường Lực Premium',490000,5,'cuonglucpremium.jpg','Cường lực cao cấp',2024,'',0,100),('37','Ốp lưng z ',2191200,5,'oplung.jpg','',2024,'',0,100),('38','Ốp lưng Casetify ',2000000,5,'opcasetify.jpg','',2024,'',0,100),('39','Tai nghe',3800000,5,'tainghe.jpg','',2024,'',0,100),('4','Samsung Galaxy Z Fold 7',44990000,4,'zfold7.jpg','Màn hình gập cao cấp',2025,'Snapdragon 8 Gen 3, 12GB RAM',1,100),('40','Bút S Pen',1000000,5,'spen.jpg','',2024,'',0,100),('41','Bespoke AI',89000000,6,'https://images.samsung.com/is/image/samsung/p6pim/vn/rf65db990012sv/gallery/vn-t-style-french-door-32inch-family-hub-rf65db990012sv-544292499?$1164_776_PNG$',NULL,NULL,NULL,0,0),('42','Bespoke Samsung Inverter',12500000,6,'https://cdn.tgdd.vn/Products/Images/1943/306554/samsung-inverter-382-lit-rt38cg6584b1sv-1-700x467.jpg',NULL,NULL,NULL,0,0),('43','Bespoke AI 615',16410000,6,'https://images.samsung.com/is/image/samsung/p6pim/vn/rs90f65d2fsv/gallery/vn-rs80f-9-inch-ai-home-rs90f65d2fsv-545198320?$1164_776_PNG$',NULL,NULL,NULL,0,0),('44','Dual Cook 76 L',34390000,6,'https://images.samsung.com/is/image/samsung/p6pim/vn/nv7b6675caa-sv/gallery/vn-nv7000b-nv7b6665iaa-nv7b6675caa-sv-539239244?$1164_776_PNG$',NULL,NULL,NULL,0,0),('45','Điều Hòa Bespoke AI',21990000,6,'https://images.samsung.com/is/image/samsung/p6pim/vn/f-ar60h24d1mw/gallery/vn-wall-mount-f-ar60h24d1mw--i-u-h-a-bespoke-ai-windfree---treo-t--ng-di-t-khu-n------------btu-h-tr-ng-551341860?$1164_776_PNG$',NULL,NULL,NULL,0,0),('46','Hút Bụi Jet Fit Siêu Nhẹ Lực Hút 180W',10990000,6,'https://images.samsung.com/is/image/samsung/p6pim/vn/vs70h18gzg-sv/gallery/vn-jet-fit-stick-vs70h18gzg-sv-550784676?$1164_776_PNG$',NULL,NULL,NULL,0,0),('47','27 Inch Odyssey G5 G50SF QHD 180Hz',13427000,7,'https://images.samsung.com/is/image/samsung/p6pim/vn/ls27fg502sexxv/gallery/vn-odyssey-oled-g5-27g50sf-ls27fg502sexxv-549340313?$1164_776_PNG$',NULL,NULL,NULL,0,0),('48','Galaxy Watch8 (Bluetooth, 44 mm)',9190000,8,'https://images.samsung.com/is/image/samsung/p6pim/vn/f2507/gallery/vn-galaxy-watch8-l330-sm-l330nzsaxxv-thumb-547653084?$Q90_330_330_F_PNG$',NULL,NULL,NULL,0,0),('49','27\" Odyssey G7 G70F 4K 180Hz',14601000,7,'https://images.samsung.com/is/image/samsung/p6pim/vn/ls27fg702eexxv/gallery/vn-odyssey-g7-27g70f-ls27fg702eexxv-548659249?$1164_776_PNG$',NULL,NULL,NULL,0,0),('5','Samsung Galaxy S24 Plus',24990000,1,'s24plus.jpg','Phiên bản S24 màn hình lớn',2024,'Snapdragon 8 Gen 3, 12GB RAM',0,100),('50','32 Inch Odyssey OLED G8 G80SH',35300000,1,'https://images.samsung.com/is/image/samsung/p6pim/vn/ls32hg802sexxv/gallery/vn-odyssey-oled-g8-g80sh-ls32hg802sexxv-552015266?$1164_776_PNG$',NULL,NULL,NULL,0,0),('51','Galaxy Watch8 Classic (LTE, 46 mm)',12990000,8,'https://images.samsung.com/is/image/samsung/p6pim/vn/f2507/gallery/vn-galaxy-watch8-classic-l505-sm-l505fzkaxxv-thumb-547652473?$Q90_330_330_F_PNG$',NULL,NULL,NULL,0,0),('52','Galaxy Watch Ultra (2025) (LTE, 47 mm)',15990000,8,'https://images.samsung.com/is/image/samsung/p6pim/vn/f2507/gallery/vn-galaxy-watch-ultra-2025-l705-sm-l705fzb1xxv-thumb-547647209?$Q90_330_330_F_PNG$',NULL,NULL,NULL,0,0),('53','37 Inch Màn Hình ViewFinity S8 S80UD 4K',13652000,7,'https://images.samsung.com/is/image/samsung/p6pim/vn/ls37d800uaexxv/gallery/vn-viewfinity-s8-37s80ud-560953-ls37d800uaexxv-thumb-548549010?$Q90_330_330_F_PNG$',NULL,NULL,NULL,0,0),('54','Màn Hình Thông Minh M7 M70F 4K',12049000,7,'https://images.samsung.com/is/image/samsung/p6pim/vn/ls43fm702uexxv/gallery/vn-smart-m7-43m70f-black-ls43fm702uexxv-thumb-546518002?$Q90_330_330_F_PNG$',NULL,NULL,NULL,0,0),('55','Galaxy Fit3',890000,8,'https://images.samsung.com/is/image/samsung/p6pim/vn/sm-r390nzaaxxv/gallery/vn-galaxy-fit3-r390-sm-r390nzaaxxv-thumb-539781173?$Q90_330_330_F_PNG$',NULL,NULL,NULL,0,0),('6','Samsung Galaxy S24',19990000,1,'S24.jpg','Flagship nhỏ gọn',2024,'Snapdragon 8 Gen 3, 8GB RAM',0,100),('7','Samsung Galaxy S24 Ultra Purple',29990000,1,'S24upurple.jpg','Phiên bản màu tím sang trọng',2024,'Snapdragon 8 Gen 3, 12GB RAM',0,100),('8','Samsung Galaxy S25 Ultra',32990000,1,'S25u.jpg','Flagship mới nhất 2025',2025,'Snapdragon 8 Gen 4, 16GB RAM',0,101),('9','Samsung Galaxy S25 Ultra Titan',34990000,1,'S25u2.jpg','Thiết kế \"thân thiện\" hơn: Máy vẫn giữ khung Titanium nhưng các góc không còn vuông sắc nhọn gây cấn tay nữa. Samsung đã bo cong nhẹ 4 góc và mặt lưng, giúp cầm nắm dễ chịu hơn hẳn. Viền màn hình cũng mỏng đi đáng kể.',2025,'Màn hình	\r\n6.9 inch, Dynamic AMOLED 2X, QHD+\r\nTần số quét 1-120Hz (LTPO)\r\nĐộ sáng tối đa: 3.000 nits (siêu sáng)\r\nKính bảo vệ: Gorilla Glass Armor 2 (chống chói cực tốt)\r\nVi xử lý (CPU)	\r\nSnapdragon 8 Elite for Galaxy (tiến trình 3nm)\r\n\r\n\r\nĐây là con chip mạnh nhất của Qualcomm năm 2025.\r\n\r\nRAM	12GB hoặc 16GB (LPDDR5X)\r\nBộ nhớ trong	256GB / 512GB / 1TB (UFS 4.0)\r\nCamera sau	\r\nChính: 200MP (OIS, khẩu độ f/1.7)\r\n\r\n\r\nGóc siêu rộng: 50MP (Nâng cấp lớn, Auto Focus)\r\n\r\n\r\nTele 1: 10MP (Zoom quang 3x)\r\n\r\n\r\nTele 2: 50MP (Zoom quang 5x, kính tiềm vọng)\r\n\r\nCamera trước	12MP (Dual Pixel AF)\r\nPin & Sạc	\r\n5.000 mAh\r\n\r\n\r\nSạc nhanh có dây 45W (0-65% trong 30 phút)\r\n\r\n\r\nSạc không dây 25W, Sạc ngược không dây\r\n\r\nKích thước	\r\nMỏng hơn bản cũ: ~8.2mm\r\n\r\n\r\nNhẹ hơn: ~219g (nhờ cấu trúc sườn máy mới)\r\n\r\nPhần mềm	\r\nAndroid 15 với giao diện One UI 7.0\r\n\r\n\r\nHỗ trợ cập nhật phần mềm 7 năm\r\n\r\nTính năng khác	\r\nBút S Pen tích hợp sẵn\r\n\r\n\r\nGalaxy AI thế hệ mới (xử lý video AI, dịch thuật thời gian thực không độ trễ)\r\n\r\n\r\nChuẩn kháng nước/bụi IP68',0,101);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `sessions` VALUES ('kRSG25TIDFb7Favwjxv585PfsVFuvyow4lih8j2k','USR1778429217FRU','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoicVRKblQ2dzBONXVVU0RONndKU0pqa0xtdHU5QXhQVFhuRzhOUnJXZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MTY6IlVTUjE3Nzg0MjkyMTdGUlUiO3M6NzoidXNlcl9pZCI7czoxNjoiVVNSMTc3ODQyOTIxN0ZSVSI7czoxMDoidXNlcl9lbWFpbCI7czoxNToiZXVnZW5AZ21haWwuY29tIjtzOjk6InVzZXJfcm9sZSI7czo1OiJhZG1pbiI7czo4OiJ1c2VybmFtZSI7czoxNToiZXVnZW5AZ21haWwuY29tIjt9',1778512995),('U9qJ0ZuxtMpJVQQZlfSUr163uKi84yKYDTidneJ4','USR1778429217FRU','127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36','YTo4OntzOjY6Il90b2tlbiI7czo0MDoiQ0taandlcG9CUXZpdTluMmd4Tk5tUVBudmJhbnFNUzd4RTNRRndNSyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO3M6MTY6IlVTUjE3Nzg0MjkyMTdGUlUiO3M6NzoidXNlcl9pZCI7czoxNjoiVVNSMTc3ODQyOTIxN0ZSVSI7czoxMDoidXNlcl9lbWFpbCI7czoxNToiZXVnZW5AZ21haWwuY29tIjtzOjk6InVzZXJfcm9sZSI7czo1OiJhZG1pbiI7czo4OiJ1c2VybmFtZSI7czoxNToiZXVnZW5AZ21haWwuY29tIjt9',1778485510);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('USR1778428904GH5','cohue@gmail.com','$2y$12$brxfkYDx5Mx4MeDv5HlVI.pJyz0QYWvCPFKVPcxOzX0U7T6TGm0Mq','user'),('USR1778429143P4O','tranminh29012005@gmail.com','$2y$12$HRt230S4m2Nl/G9qzDfI4.CvbNmwk2lnNm/4a.LboVhB9GMjas2fW','admin'),('USR1778429217FRU','eugen@gmail.com','$2y$12$iWX8klmNzbJjrqD.WpxwF.C78f3mz7E54m5qhQFGuX4dCl71nqQh.','admin');
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

-- Dump completed on 2026-05-11 22:33:55
