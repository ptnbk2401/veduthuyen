-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 23, 2018 lúc 07:36 PM
-- Phiên bản máy phục vụ: 10.1.32-MariaDB
-- Phiên bản PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `core`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `last_name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token` text COLLATE utf8mb4_unicode_ci,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `email`, `phone`, `password`, `access_token`, `address`, `avatar`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Phan Thanh', 'Nguyên', 'ptnbk2401@gmail.com', '0373099406', '$2y$10$nV6Ytq6qnsbSa8ZJkv7Fj.tZ3T.S3u10xXQcMM5M6c5QIZlkaIgmi', '', 'Hương Vân, Hương Trà, Thừa Thiên Huế', 'T46EyMfYEAWAQd2Gzda9SjLhLbyrr4UtO5FREIWQ.png', 1, 'Px7kd1Ctl4XQRX6w7edPS45AUVmhxtwuO2gzaeUz5xHLd21UDBklX1hdGblr', '2018-01-10 03:31:28', '2018-11-23 17:53:08'),
(71, 'nguyenpt', 'Phan', 'Thanh', 'ptnbk2401@outlook.com', '0373099406', '$2y$10$Z1EFcTVcDmvKhH53sue/Ju0u392mjrDe51heGcN6D15iEHjBG0Jmi', NULL, 'Đà Nẵng', 'g8rVaLDizwIjlIikmajbHbgfoPwsAaqymfRDLkYY.jpeg', 1, '', '2018-11-23 17:52:56', '2018-11-23 17:52:56');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_about`
--

CREATE TABLE `vne_about` (
  `about_id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_about`
--

INSERT INTO `vne_about` (`about_id`, `name`, `content`) VALUES
(1, 'Về chúng tôi', '<h2>Phan Thanh Nguyên</h2>');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_ads`
--

CREATE TABLE `vne_ads` (
  `ads_id` int(11) NOT NULL,
  `aname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_adsense` text COLLATE utf8mb4_unicode_ci,
  `banner` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `begin_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_ads`
--

INSERT INTO `vne_ads` (`ads_id`, `aname`, `code_adsense`, `banner`, `position_id`, `url`, `created_at`, `begin_at`, `end_at`) VALUES
(1, 'Quảng cáo 1', '', 'vne-1529636793.png', 1, '', '2018-06-17 17:00:00', '2018-06-25 17:00:00', '2018-06-29 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_ads_position`
--

CREATE TABLE `vne_ads_position` (
  `position_id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_ads_position`
--

INSERT INTO `vne_ads_position` (`position_id`, `name`, `code`, `note`) VALUES
(1, 'quảng cáo bên trái', 'quang-cao-ben-trai', 'Quảng cáo ads google nằm ở bên phía tay trái'),
(2, 'quảng cáo đầu trang', 'quang-cao-dau-trang', 'Quảng cáo phía đầu trang chủ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_article`
--

CREATE TABLE `vne_article` (
  `article_id` int(11) NOT NULL,
  `aname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int(11) NOT NULL,
  `picture` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preview_text` text COLLATE utf8mb4_unicode_ci,
  `detail_text` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `sort` int(5) NOT NULL DEFAULT '500',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_article`
--

INSERT INTO `vne_article` (`article_id`, `aname`, `code`, `cat_id`, `picture`, `preview_text`, `detail_text`, `active`, `sort`, `created_at`, `updated_at`, `user_id`) VALUES
(3, 'nhà có nhiều cửa sổ 2', 'nha-co-nhieu-cua-so-2', 63, 'vne-1542996327.jpg', 'aaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaa', 1, 500, '2018-11-23 18:05:27', '2018-11-23 18:05:46', 71);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_cat`
--

CREATE TABLE `vne_cat` (
  `cat_id` int(11) NOT NULL,
  `cname` text COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `parent_id` int(11) DEFAULT NULL,
  `code` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_cat`
--

INSERT INTO `vne_cat` (`cat_id`, `cname`, `sort`, `active`, `parent_id`, `code`) VALUES
(63, 'Kinh doanh', 500, 1, 0, 'kinh-doanh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_comment`
--

CREATE TABLE `vne_comment` (
  `fcomment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `article_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_contact`
--

CREATE TABLE `vne_contact` (
  `contact_id` int(11) NOT NULL,
  `fullname` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_contact`
--

INSERT INTO `vne_contact` (`contact_id`, `fullname`, `email`, `phone`, `subject`, `content`) VALUES
(3, 'Trần Phú', 'itphutran.com@gmail.com', '0905927548', 'Tôi cần liên hệ', '610 học viên với 33 khóa Lập trình PHP từ A-Z đã khai giảng và tiếp tục\r\n520 học viên với 17 khóa Lập trình JAVA từ A-Z đã khai giảng và tiếp tục\r\n118 học viên với 11 khóa Marketing Online đã khai giảng và tiếp tục\r\nVinaEnter Edu cũng đã chia sẻ kiến thức, công nghệ Marketing Online đến nhiều doanh nghiệp, giúp họ cải thiện thương hiệu của mình trên Internet.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_groups`
--

CREATE TABLE `vne_groups` (
  `groupId` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sort` int(11) NOT NULL DEFAULT '500'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_groups`
--

INSERT INTO `vne_groups` (`groupId`, `name`, `code`, `sort`) VALUES
(7, 'Admin', 'admin', 500),
(8, 'Nhân viên', 'mod', 500);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_recruitment`
--

CREATE TABLE `vne_recruitment` (
  `recuitment_id` int(11) NOT NULL,
  `name` varchar(155) COLLATE utf8mb4_unicode_ci NOT NULL,
  `preview_text` text COLLATE utf8mb4_unicode_ci,
  `detail_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `begin_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_recruitment`
--

INSERT INTO `vne_recruitment` (`recuitment_id`, `name`, `preview_text`, `detail_text`, `begin_at`, `end_at`) VALUES
(1, '1 URGENT] Tuyển Dụng Android Developer tại Đà Nẵng', '', 'Kinh Nghiệm : 1-3 Năm Lương : Thỏa thuận Số lượng : 2 Công Việc : Nhân viên chính thức. Thời gian làm việc : T2-T6, Sáng : 8h-12h Chiều 1h-5h Phúc lợi : + Bảo hiểm theo quy định (đóng full theo lương chính thức) + Du Lịch + Thưởng + Đào tạo + Tăng lương + Chế độ nghỉ phép Mô tả Công việc : + Phát triển ứng dụng Android cho module trên hệ thống ERP + Được đào tạo và hướng dẫn phát triển hệ thống trên một ngôn ngữ mới. + Xây dựng và phát triển hệ thống quản trị doanh nghiệp (ERP) đang được sử dụng bởi hàng trăm công ty tại các thị trường như Singapore, Malaysia, Hong Kong, Nhật Bản, Việt Nam. + Phối hợp với bộ phận quản lý, bộ phận consultant để triển khai áp dụng hệ thống ERP theo yêu cầu nghiệp vụ của khách hàng. + Nghiên cứu hệ thống, chia sẻ kiến thức với đồng nghiệp. Yêu Cầu Công Việc : + Thái độ học hỏi, có sự cầu tiến trong công việc. + Có đam mê với công việc lập trình. + Kinh nghiệm Android Dev trên 1 năm. + Có kinh nghiệm làm việc với ít nhất 01 hệ quản trị cơ sở dữ liệu (SQL Server, MySQL, Oracle, PostgreSQL,…) + Có khả năng phân tích yêu cầu của khách hàng và thiết kế giải pháp. Quyền lợi : + Mức lương cạnh tranh, theo năng lực và đóng góp cho công ty. + Xét tăng lương tới 02 lần / năm cho nhân viên xuất sắc vào tháng 1 và tháng 7. + Cơ hội trải nghiệm công việc tại Singapore, Malaysia, Hong Kong… + Cơ hội học hỏi nghiệp vụ của khách hàng và cách giải quyết các vấn đề mà khách hàng gặp phải. + Được tham gia bảo hiểm xã hội đầy đủ. Môi trường làm việc : + Kinh nghiệm làm việc không phải là tất cả, tố chất và sự nhiệt tình mới là yếu tố quyết định. + Môi trường làm việc trẻ trung, thân thiện và gắn bó. + Làm hết sức, chơi hết mình. + Có thời gian dành riêng để nghiên cứu về hệ thống cũng như những ngôn ngữ, công nghệ mà bạn đam mê. Thông tin khác : + Bằng cấp: Không giới hạn + Độ tuổi: 20-28 + Hình thức: Nhân viên chính thức Liên Hệ : Mr. Quán + Email : nguyen.ngocquan@globe3.com', '2018-06-14 17:00:00', '2018-06-29 17:00:00'),
(2, 'URGENT] Tuyển Dụng Android Developer tại Đà Nẵng', '', 'Kinh Nghiệm : 1-3 Năm Lương : Thỏa thuận Số lượng : 2 Công Việc : Nhân viên chính thức. Thời gian làm việc : T2-T6, Sáng : 8h-12h Chiều 1h-5h Phúc lợi : + Bảo hiểm theo quy định (đóng full theo lương chính thức) + Du Lịch + Thưởng + Đào tạo + Tăng lương + Chế độ nghỉ phép Mô tả Công việc : + Phát triển ứng dụng Android cho module trên hệ thống ERP + Được đào tạo và hướng dẫn phát triển hệ thống trên một ngôn ngữ mới. + Xây dựng và phát triển hệ thống quản trị doanh nghiệp (ERP) đang được sử dụng bởi hàng trăm công ty tại các thị trường như Singapore, Malaysia, Hong Kong, Nhật Bản, Việt Nam. + Phối hợp với bộ phận quản lý, bộ phận consultant để triển khai áp dụng hệ thống ERP theo yêu cầu nghiệp vụ của khách hàng. + Nghiên cứu hệ thống, chia sẻ kiến thức với đồng nghiệp. Yêu Cầu Công Việc : + Thái độ học hỏi, có sự cầu tiến trong công việc. + Có đam mê với công việc lập trình. + Kinh nghiệm Android Dev trên 1 năm. + Có kinh nghiệm làm việc với ít nhất 01 hệ quản trị cơ sở dữ liệu (SQL Server, MySQL, Oracle, PostgreSQL,…) + Có khả năng phân tích yêu cầu của khách hàng và thiết kế giải pháp. Quyền lợi : + Mức lương cạnh tranh, theo năng lực và đóng góp cho công ty. + Xét tăng lương tới 02 lần / năm cho nhân viên xuất sắc vào tháng 1 và tháng 7. + Cơ hội trải nghiệm công việc tại Singapore, Malaysia, Hong Kong… + Cơ hội học hỏi nghiệp vụ của khách hàng và cách giải quyết các vấn đề mà khách hàng gặp phải. + Được tham gia bảo hiểm xã hội đầy đủ. Môi trường làm việc : + Kinh nghiệm làm việc không phải là tất cả, tố chất và sự nhiệt tình mới là yếu tố quyết định. + Môi trường làm việc trẻ trung, thân thiện và gắn bó. + Làm hết sức, chơi hết mình. + Có thời gian dành riêng để nghiên cứu về hệ thống cũng như những ngôn ngữ, công nghệ mà bạn đam mê. Thông tin khác : + Bằng cấp: Không giới hạn + Độ tuổi: 20-28 + Hình thức: Nhân viên chính thức Liên Hệ : Mr. Quán + Email : nguyen.ngocquan@globe3.com', '2018-06-14 17:00:00', '2018-07-29 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `vne_user_group`
--

CREATE TABLE `vne_user_group` (
  `userId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `vne_user_group`
--

INSERT INTO `vne_user_group` (`userId`, `groupId`) VALUES
(39, 0),
(62, 0),
(39, 0),
(62, 0),
(1, 7),
(71, 8);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Chỉ mục cho bảng `vne_about`
--
ALTER TABLE `vne_about`
  ADD PRIMARY KEY (`about_id`);

--
-- Chỉ mục cho bảng `vne_ads`
--
ALTER TABLE `vne_ads`
  ADD PRIMARY KEY (`ads_id`);

--
-- Chỉ mục cho bảng `vne_ads_position`
--
ALTER TABLE `vne_ads_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Chỉ mục cho bảng `vne_article`
--
ALTER TABLE `vne_article`
  ADD PRIMARY KEY (`article_id`);

--
-- Chỉ mục cho bảng `vne_cat`
--
ALTER TABLE `vne_cat`
  ADD PRIMARY KEY (`cat_id`);

--
-- Chỉ mục cho bảng `vne_comment`
--
ALTER TABLE `vne_comment`
  ADD PRIMARY KEY (`fcomment_id`);

--
-- Chỉ mục cho bảng `vne_contact`
--
ALTER TABLE `vne_contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Chỉ mục cho bảng `vne_groups`
--
ALTER TABLE `vne_groups`
  ADD PRIMARY KEY (`groupId`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `vne_recruitment`
--
ALTER TABLE `vne_recruitment`
  ADD PRIMARY KEY (`recuitment_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT cho bảng `vne_about`
--
ALTER TABLE `vne_about`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `vne_ads`
--
ALTER TABLE `vne_ads`
  MODIFY `ads_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `vne_ads_position`
--
ALTER TABLE `vne_ads_position`
  MODIFY `position_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `vne_article`
--
ALTER TABLE `vne_article`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `vne_cat`
--
ALTER TABLE `vne_cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT cho bảng `vne_comment`
--
ALTER TABLE `vne_comment`
  MODIFY `fcomment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `vne_contact`
--
ALTER TABLE `vne_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `vne_groups`
--
ALTER TABLE `vne_groups`
  MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `vne_recruitment`
--
ALTER TABLE `vne_recruitment`
  MODIFY `recuitment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
