-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 12, 2026 lúc 07:21 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `solar_db`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `project_type` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Chưa đọc'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`id`, `fullname`, `phone`, `email`, `address`, `project_type`, `message`, `created_at`, `status`) VALUES
(8, 'Xuân Sáng Nguyễn', '0396005547', 'nguyenxuansang14012004@gmail.com', 'Khối Hòa Long ssssssss', 'Hộ gia đình', 'x', '2026-01-28 14:48:09', 'Đã đọc'),
(9, 'Xuân Sáng Nguyễn', '0396005547', 'nguyenxuansang14012004@gmail.com', 'Khối Hòa Long ssssssss', 'Hộ gia đình', 'x', '2026-01-28 14:54:17', 'Đã đọc'),
(10, 'Xuân Sáng Nguyễn', '0396005547', 'nguyenxuansang14012004@gmail.com', 'Khối Hòa Long ssssssss', 'Hộ gia đình', 'zz', '2026-01-28 14:55:40', 'Đã đọc'),
(11, 'Xuân Sáng Nguyễn', '0396005547', '2221050156@student.humg.edu.vn', 'Khối Hòa Long ssssssss', 'Hộ gia đình', '', '2026-01-28 14:56:26', 'Đã đọc'),
(12, 'Xuân Sáng Nguyễn', '0396005547', '2221050156@student.humg.edu.vn', 'Khối Hòa Long ssssssss', 'Hộ gia đình', '', '2026-01-28 14:56:44', 'Đã đọc'),
(13, 'Xuân Sáng Nguyễn', '0396005547', '2221050156@student.humg.edu.vn', 'Khối Hòa Long ssssssss', 'Nhà xưởng', 'x', '2026-01-28 15:02:25', 'Đã đọc'),
(14, 'Xuân Sáng Nguyễn', '0396005547', '2221050156@student.humg.edu.vn', 'Khối Hòa Long ssssssss', 'Nhà xưởng', 'x', '2026-01-28 15:10:05', 'Đã đọc'),
(15, 'Xuân Sáng Nguyễn', 'x', 'nguyenxuansang14012004@gmail.com', 'x', 'Hộ gia đình', 'x', '2026-01-28 15:10:45', 'Đã đọc'),
(16, 'Xuân Sáng Nguyễn', 'x', 'nguyenxuansang14012004@gmail.com', 'x', 'Hộ gia đình', '', '2026-01-28 15:12:30', 'Đã đọc'),
(17, 'Xuân Sáng Nguyễn', 'x', 'nguyenxuansang14012004@gmail.com', 'x', 'Hộ gia đình', '', '2026-01-28 15:13:20', 'Đã đọc'),
(18, 'Xuân Sáng Nguyễn', '0396005547', 'nguyenxuansang14012004@gmail.com', 'Khối Hòa Long', 'Hộ gia đình', '', '2026-01-28 15:13:47', 'Đã đọc'),
(19, 'NGuyễn VAn an', '0396005547', '4012004@gmail.com', 'Nghệ AN', 'Nhà xưởng', 'ssssssssssssssssssssssssssssscsscscccccccccccccc', '2026-01-28 16:29:00', 'Đã đọc'),
(20, 'NGuyễn VAn an', '0396005547', '4012004@gmail.com', 'Nghệ AN', 'Hộ gia đình', 'Hãy để chúng tôi giúp bạn bắt đầu hành trình sử dụng năng lượng sạch. Liên hệ ngay để được tư vấn miễn\r\n            phí.', '2026-01-28 16:29:47', 'Đã đọc'),
(21, 'NGuyễn VAn an', '0396005547', '4012004@gmail.com', 'Nghệ AN', 'Hộ gia đình', '', '2026-03-02 16:37:11', 'Đã đọc'),
(22, 'Xuân Sáng Nguyễn', '0396005547', '2221050156@student.humg.edu.vn', 'Khối Hòa Long', 'Hộ gia đình', '', '2026-05-12 16:51:29', 'Đã đọc');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `total_price` bigint(20) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `product_id`, `customer_name`, `phone`, `address`, `quantity`, `total_price`, `status`, `created_at`) VALUES
(1, 1, 'Xuân Sáng Nguyễn', '0396005547', 'Khối Hòa Long', 3, 10500000, 'delivered', '2026-05-12 17:41:45'),
(3, 1, 'Xuân Sáng Nguyễn2', '0396005547', '2', 4, 14000000, 'delivered', '2026-05-12 17:53:24'),
(4, 2, 'sangdepzai', '0396005547', 'Khối Hòa Long', 5, 14000000, 'delivered', '2026-05-12 17:54:35'),
(5, 8, 'sangdepzai', '0396005547', 'Khối Hòa Long', 1, 5200000, 'delivered', '2026-05-12 18:12:38');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `views` int(11) DEFAULT 0,
  `tags` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `description`, `content`, `image`, `category`, `author`, `is_featured`, `created_at`, `views`, `tags`) VALUES
(28, 'Hướng dẫn lắp điện mặt trời gia đình 2025', 'h-ng-d-n-l-p-i-n-m-t-tr-i-gia-nh-2025', 'Lắp điện mặt trời cho nhà ở cần bao nhiêu tiền? Hoàn vốn bao lâu?', '<p>Nội dung chi tiết bài viết ở đây...</p>', '1772467152.jpg', 'Kiến thức', 'Kỹ sư Minh', 0, '2026-01-30 21:50:17', 2, NULL),
(29, 'Hướng dẫn lắp điện mặt trời gia đình 2025', 'h-ng-d-n-l-p-i-n-m-t-tr-i-gia-nh-2025', 'Lắp điện mặt trời cho nhà ở cần bao nhiêu tiền? Hoàn vốn bao lâu?', '<p>Nội dung chi tiết bài viết ở đây...</p>', '1772467140.jpg', 'Chính sách', 'Kỹ sư Minh', 0, '2026-01-30 21:50:24', 1, NULL),
(30, 'Hướng dẫn lắp điện mặt trời gia đình 2025', 'h-ng-d-n-l-p-i-n-m-t-tr-i-gia-nh-2025', 'Lắp điện mặt trời cho nhà ở cần bao nhiêu tiền? Hoàn vốn bao lâu?', '<p>Nội dung chi tiết bài viết ở đây...</p>', '1772467130.jpg', 'Doanh nghiệp', 'Kỹ sư Minh', 0, '2026-01-30 21:50:32', 2, NULL),
(34, 'Các bước lắp đặt điện mặt trời cho hộ gia đình', 'c-c-b-c-l-p-t-i-n-m-t-tr-i-cho-h-gia-nh', 'Quy trình khảo sát – thiết kế – thi công – nghiệm thu hệ thống điện mặt trời.', '<p>Bước 1: Khảo sát mái...</p>', '1772467113.jpg', 'Hướng dẫn', 'Kỹ sư Linh', 0, '2026-01-30 21:51:52', 3, NULL),
(35, 'So sánh hệ thống On-grid, Off-grid và Hybrid', 'so-s-nh-h-th-ng-on-grid-off-grid-v-hybrid', 'Phân tích ưu nhược điểm của từng hệ thống điện mặt trời.', '<p>On-grid là hệ thống...</p>', '1772467108.jpg', 'Doanh nghiệp', 'Kỹ sư Minh', 0, '2026-01-30 21:52:15', 5, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` enum('home','business') DEFAULT NULL,
  `tag` varchar(100) DEFAULT NULL,
  `power` varchar(50) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `panel` varchar(255) DEFAULT NULL,
  `inverter` varchar(255) DEFAULT NULL,
  `saving` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `image`, `title`, `category`, `tag`, `power`, `location`, `description`, `panel`, `inverter`, `saving`) VALUES
(1, '1772464224.jpg', 'Solar Quốc Oai', 'home', 'Hộ gia đình', '8.5 kWp', 'Tây Hồ, Hà Nội', 'Hệ thống điện mặt trời hòa lưới cho biệt thự 3 tầng, giảm 65% hóa đơn điện', '20 tấm x 425W', 'Growatt 8kW', '8–10 triệu/năm'),
(2, '1772464280.jpg', 'Trường mầm non Dream', 'business', 'Thương mại', '150 kWp', 'Từ Sơn, Bắc Ninh', 'Hệ thống quy mô lớn cho nhà máy', '330 tấm x 455W', '3 × Huawei 50kW', '180–220 triệu/năm'),
(3, '1772464305.jpg', 'Biệt thự Tây Hồ', 'home', 'Hộ gia đình', '8.5 kWp', 'Tây Hồ, Hà Nội', 'Hệ thống điện mặt trời hòa lưới cho biệt thự 3 tầng, giúp giảm khoảng 65% hóa đơn điện sinh hoạt.', '20 tấm x 425W', 'Growatt 8kW', '8–10 triệu/năm'),
(4, '1772464316.jpg', 'Nhà phố Hoài Đức', 'home', 'Hộ gia đình', '6.5 kWp', 'Hoài Đức, Hà Nội', 'Giải pháp điện mặt trời hòa lưới cho nhà phố 4 tầng, tối ưu chi phí điện sinh hoạt.', '15 tấm x 435W', 'Growatt 6kW', '6–8 triệu/năm'),
(5, '1772464369.jpg', 'Nhà máy may Bắc Ninh', 'business', 'Thương mại', '150 kWp', 'Từ Sơn, Bắc Ninh', 'Hệ thống điện mặt trời công suất lớn cho nhà máy may, tiết kiệm hàng trăm triệu đồng mỗi năm.', '330 tấm x 455W', '3 × Huawei 50kW', '180–220 triệu/năm'),
(6, '1772464380.jpg', 'Văn phòng Long Biên', 'business', 'Thương mại', '25 kWp', 'Long Biên, Hà Nội', 'Giải pháp điện mặt trời cho tòa nhà văn phòng 5 tầng, vận hành ổn định và hiệu quả.', '56 tấm x 445W', 'SMA 25kW', '30–35 triệu/năm'),
(7, '1772466125.jpg', 'Kho logistics Gia Lâm', 'business', 'Thương mại', '80 kWp', 'Gia Lâm, Hà Nội', 'Hệ thống điện mặt trời giúp kho logistics giảm chi phí vận hành và tăng tính bền vững.', '180 tấm x 445W', '2 × Huawei 40kW', '90–110 triệu/năm'),
(8, '1772466135.jpg', 'Trường học tư thục Bắc Giang', 'business', 'Thương mại', '30 kWp', 'TP. Bắc Giang', 'Hệ thống điện mặt trời cho trường học, vừa tiết kiệm chi phí vừa giáo dục ý thức năng lượng xanh.', '68 tấm x 445W', 'SMA 30kW', '35–40 triệu/năm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `stars` int(11) DEFAULT 5,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `location`, `content`, `stars`, `created_at`) VALUES
(1, 'Tuấn Anh', 'Cầu Giấy', 'Lắp đặt 6 tháng, hóa đơn giảm 60%', 5, '2026-01-28 15:19:42'),
(2, 'Chị Hương', 'Tây Hồ', 'Hệ thống ổn định, tư vấn rất tốt', 5, '2026-01-28 15:19:42'),
(3, 'Công ty ABC', 'Bắc Ninh', '150kWp cho nhà máy hoạt động hiệu quả', 5, '2026-01-28 15:19:42');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `services`
--

INSERT INTO `services` (`id`, `icon`, `title`, `description`) VALUES
(1, '🏠', 'Điện mặt trời gia đình', 'Giải pháp tiết kiệm điện năng cho hộ gia đình'),
(2, '🏭', 'Điện mặt trời doanh nghiệp', 'Hệ thống công suất lớn cho nhà máy'),
(3, '⚡', 'Hệ thống Hybrid', 'Kết hợp pin lưu trữ và điện lưới'),
(4, '🔧', 'Bảo trì & Giám sát', 'Theo dõi và bảo trì hệ thống từ xa');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `solar_panels`
--

CREATE TABLE `solar_panels` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `power` varchar(50) DEFAULT NULL,
  `technology` varchar(100) DEFAULT NULL,
  `efficiency` varchar(50) DEFAULT NULL,
  `warranty` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `price` bigint(20) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `solar_panels`
--

INSERT INTO `solar_panels` (`id`, `name`, `image`, `brand`, `power`, `technology`, `efficiency`, `warranty`, `size`, `price`, `category`, `description`, `created_at`) VALUES
(1, 'Pin năng lượng mặt trời Jinko 550W', '1772464316.jpg', 'Jinko Solar', '550W', 'Mono Half-cell', '21.3%', '12 năm', '2279 x 1134 mm', 3500000, 'mono', 'Tấm pin hiệu suất cao phù hợp cho hộ gia đình và doanh nghiệp', '2026-05-12 17:19:38'),
(2, 'Pin Canadian Solar 450W', '1778608736.png', 'Canadian Solar', '450W', 'Poly', '19.8%', '10 năm', '2100 x 1048 mm', 2800000, 'poly', 'Giải pháp tiết kiệm chi phí cho hệ thống điện mặt trời', '2026-05-12 17:19:38'),
(3, 'Pin Longi Hi-MO X6 600W', '1778608750.jpg', 'LONGi', '600W', 'Mono Premium', '22.5%', '15 năm', '2384 x 1303 mm', 5200000, 'premium', 'Dòng pin cao cấp hiệu suất cực cao dành cho dự án lớn', '2026-05-12 17:19:38'),
(5, 'ssss', '1778609090.png', 'â', '600W', 'Mono Premium', '22.5%', '15 năm', '2384 x 1303 mm', 5200000, 'mono', 'aaaaaa', '2026-05-12 18:02:25'),
(7, 'â', '1778609102.png', 'â', '600W', 'Mono Premium', '22.5%', '15 năm', '2384 x 1303 mm', 5200000, 'mono', '', '2026-05-12 18:05:02'),
(8, 'u', '1778609476.jpg', 'â', '600W', 'Mono Premium', '22.5%', '15 năm', '2384 x 1303 mm', 5200000, 'mono', '', '2026-05-12 18:08:46'),
(10, 'wwwwwwww', '1778609526.jpg', 'â', '600W', 'Mono Premium', '22.5%', '15 năm', '2384 x 1303 mm', 5200000, 'mono', 'wwwwwwww', '2026-05-12 18:12:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin', '2026-05-12 18:31:55'),
(3, 'User', 'user@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-05-12 18:42:43'),
(4, 'Nguyễn Xuân Sáng', '123@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', '2026-05-12 19:17:19');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `solar_panels`
--
ALTER TABLE `solar_panels`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `solar_panels`
--
ALTER TABLE `solar_panels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
