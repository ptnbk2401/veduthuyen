-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 04, 2018 lúc 06:59 PM
-- Phiên bản máy phục vụ: 10.1.30-MariaDB
-- Phiên bản PHP: 7.0.27

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
(1, 'admin', 'Trần Văn Sơn', '', 'sontv@vinaenter.com', '0909223155', '$2y$10$3vsUgBxjzMBInDjU4LfGpeOl4o7I.ZpxEoP45E9QHtdinNDE7NN.K', '', '154 Phạm Như Xương, Liên Chiểu, Đà Nẵng', '', 1, 'AO85x9mb6ZwRLSfQZRbt2C8yey1YRclX4dWnjkJXHpbGb5Bit5Io8NYXHDMS', '2018-01-10 03:31:28', '2018-06-22 03:24:49'),
(2, 'phut', 'Trần Phú', '', 'phut@vinaenter.com', '0909223153', '$2y$10$kDyEnYf6vWErboc0HE/jP.E0xDieznBaJUmOjMZzMck61ToFBl/jm', '', '154 Phạm Như Xương, Liên Chiểu, Đà Nẵng', '', 1, 'ilwzSal6VKOB4u3HmD9MiSoX4p1xQ1hqMwQKrtdPf76DVIvnJ3jSoZLxlneD', '2018-04-09 03:21:48', '2018-04-30 12:33:30'),
(63, 'longht', 'Hoàng Thanh Long', '', 'longht@vinaenter.com', '876543', '$2y$10$51RJtnD8evgDk.uU70ER9.b8cIQERs1TkdS2SazCyLAdXjKj7RsEO', '', '', '', 1, '7y7U8gQXxmujOwWY6ITfoUTrIW0LSlkYSgQCztFktG5HlzGIxz8GPxPHhoCz', '2018-04-09 03:22:59', '2018-04-30 11:24:42'),
(64, 'nghinv', 'Ninh Văn Nghĩa', '', 'nghinv@vinaenter.com', '7654', '$2y$10$og0tGkLND2wlzs72KMBxe.z4ADjlyHzXkH2ETiST5SoKaw3drm7oO', '', '76re', '', 1, '', '2018-04-09 03:24:40', '2018-04-09 03:24:40'),
(65, 'vutt', 'Trần Tấn Vũ', '', 'vutt@vinaenter.com', '0935987683', '$2y$10$ifTLem98rJYtQo3Phuoi7O1abooIKDJRlHSRiEIESAWUE.AZsmmou', 'EAAAAUaZA8jlABACNnZAz6yG55VfV41z1DkHSXaZBtoXk2j6ZBmCh82XUnCjCjIAvRWM0s08oCcKj1WuJs5V0PaXYJnsbUoTmOsnYjXKaAlh1NL3ylYaivo8iIaT4gD7vVrXXNPfkzB64zqmmRMEAyqB1kFt8lRZAEyASKlpWxkwkJ5oRQmsWG', '418 Nguyễn Duy Trinh, Đà Nẵng', '', 1, 'd570QbtZBs92Bt05fLvXe6uGjAdUKk3qATyB09cg877LEyorfDFuXvPZ8kyn', '2018-04-09 03:25:35', '2018-04-30 13:19:14'),
(66, 'thuyvt', 'Võ Thị Thúy', '', 'thuyvt@vinaenter.com', '01205935292', '$2y$10$fiW49LvnduoP8bhSsBLx2unlodAgSxghQMDNC6QubFlx99iid4Gfm', '', 'H08/04 K169 Phan Thanh, tp.Đà Nẵng', 'cg51DdE3E4b1z8bHXKT4KRGyqkuSJBwy2BNZ0V3J.jpeg', 1, 'AbmG5dqhgO4eo9lRCBfcEC4DJPizG2ee1ZTIBeT9PLbVQBpA1l7Qv6sS8cEe', '2018-04-09 03:26:36', '2018-06-14 09:09:35'),
(67, 'thuongtt', 'Trần Thị Thương', '', 'thuongtt@vinaenter.com', '01635510498', '$2y$10$T.RlkvZgnJdvEJD6k5BCru6fHO0WT/.JGAbyKnAVK23JJ9M5nIx2C', '', 'Đà Nẵng', 'LY2pLKnPDyykGA68TMIgrIJW0nZiUOkgnpgILjw7.jpeg', 1, 'BAqjtAn9uMGsOtbPCDZ09M8yzytsS4ExjxYZSx7q6SggVm7uDZfJk6ONfHmF', '2018-04-09 03:27:47', '2018-06-14 06:59:27'),
(68, 'thanhntk', 'Nguyễn Thị Kim Thanh', '', 'thanhntk@vinaenter.com', '0969032554', '$2y$10$qQoe/I.hzgxwSsrx4vvg1Op/h6NqnbG7jSlg2mJuNfOFt9xAVdhAO', 'EAACEdEose0cBALAYZB4ZBMmFhCEmBvSBJZCF88CduIEzTDGl1zeBmKpNR11wt80KIrLrsUH8diq4swsf1AU6QIpvZCCqHfWqka2YKhII90SlxO3R6pMXnAjgyZA06aNqYjp01Nhtpfz3ToqU9hAvZAE7X4FGxYZCQRoxv7KCK1aZBYWRde7KaKIPMpRmWEQuwEGvBsgkbttwOAZDZD', 'Nam Đông, Thừa Thiên Huế', '', 1, 'LDOjGwB3lGjCVW0Tt5Z3AtFYK6cRWM1m0dRDfR6SpDryebKmFQvDbuzqhb7Q', '2018-04-09 03:30:58', '2018-06-15 02:07:27'),
(69, 'tampt', 'Phạm Thị Tâm', '', 'tampt@vinaenter.com', '01695985081', '$2y$10$YOXD7mW/HL.v4H3NIHnBdOvv3ZFR3j4H27wZoUUGvj2VQbWr.c9Mu', 'EAACEdEose0cBADop1g400O8thUZA8snWl6EQowsMVacuDwZBPkRSCEdjp0UoeAleZAuSZBdxvG42ZClf4fmmWPBtPzyImzx5wnhbsGL0eC7jeeJrhppRWKnIovFmKWPagFFWtSxXTc5VoVsxOZCmZCOjOpxZCpkCPU9wLV9yZCZBjc66EALnsqyogKwodoJMWHCqA6hM5PPLafOAZDZD', 'Thạch Tân, Tam Thăng, TP.Tam Kỳ, Quảng Nam', '', 1, '569pER10ZA1wrPxSMuy5yWvz92a4copkDJzTZesgVUotmsyQin82YQX2DMYy', '2018-04-09 03:31:40', '2018-06-22 21:19:13'),
(70, 'hantt', 'hantt', 'hantt', 'hantt@vinaenter.com', '01264384964', '$2y$10$2gKuK559VbyBzhSFL/Zw1OfiYpHHS9Vt9/wetSIM6yne1KvlL4O5S', 'EAACEdEose0cBAMlgGjbZA8ppjdJ4tpaeAZCgtqCBCpXhpvWN3sjfwvhiyo5ZAUnl8X9zZC2goYPmBmTRPYuhzUP4bSmR7WGOtU23wddJfsCvvpZBgLQ2W6dZBCFYFgFlArhJGbauu131Ioxh4ZCrm6ZB6nevi8uI9DmFcHk6OofAPZA8wpDVsSp7lxZBBVvdvXqvjGzgCPoCYlVQZDZD', 'Thôn Trước Đông, xã Hòa Nhơn, Huyện Hòa Vang, Thành phố Đà Nẵng', '', 1, '', '2018-04-09 04:28:52', '2018-07-04 16:47:31');

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
(1, 'Về chúng tôi', '<h2>Lịch Sử Thành Lập VINAENTER EDU</h2>\r\n\r\n<h3>Khởi đầu năm 2007</h3>\r\n\r\n<p>Anh Trần Văn Sơn cùng nhóm bạn của mình nghiên cứu và phát triển dự án Bán Vé Xe Khách Qua Mạng được lập trình trên nền tảng ASP.net. Với sự đầu tư công nghệ và có chương trình Marketing Online, kế hoạch kinh doanh bài bản - Dự án đã đạt giải nhất cuộc thi <a href=\"http://dantri.com.vn/giao-duc-khuyen-hoc/son-liet-va-uoc-mo-vexekhachcom-1211582551.htm\" rel=\"nofollow\" target=\"_blank\" title=\"Trần Văn Sơn giải nhất ý tưởng kinh doanh sáng tạo\">Ý Tưởng Kinh Doanh Sáng Tạo 2007</a>.</p>\r\n<img alt=\"\" src=\"https://vinaenter.edu.vn/resources/assets/templates/edu/images_tmp/aboutus/y-tuong-kinh-doanh-sang-tao-2007.jpg\" />\r\n<h3>Bước ngoặc năm 2009</h3>\r\n\r\n<p>Trong 2 năm 2008 và 2009, sau khi tham gia nhiều sân chơi lập trình, marketing và kinh doanh, anh Trần Văn Sơn cùng team của mình đã tìm được nhà đâu tư tiềm năm, Công ty Cổ phần Phú Hải Sơn (tiền thân của Công ty TNHH Giải pháp Công nghệ VinaEnter bây giờ) với số vốn đầu tư ban đầu 450.000.000.</p>\r\n\r\n<p>Dịch vụ chính của công ty là phát triển các sản phẩm phần mềm như phần mềm quản lý nhà trọ, phòng trọ, phần mềm bán vé xe khách và sử dụng Marketing Online để quảng bá sản phẩm của mình đến khách hàng. Công ty đã hợp tác với nhiều hãng xe nổi tiếng tại Đà Nẵng như Hoàng Long, Mai Linh...Lúc đó anh Trần Văn Sơn vẫn đang còn là sinh viên năm 4 - Đại học bách khoa</p>\r\n\r\n<h3>Định hướng năm 2011</h3>\r\n\r\n<p>Nhận thấy dịch vụ Online chưa phù hợp vì internet lúc bấy giờ tại Đà Nẵng nói riêng và ở Việt Nam nói chung chưa phát triển, anh Trần Văn Sơn đã dừng dự án bán vé xe qua mạng và quyết định đi làm tại các doanh nghiệp để phát triển chuyên môn, học hỏi thêm kinh nghiệm.</p>\r\n\r\n<p>Trải qua nhiều vị trí khác nhau: Lập trình viên, trưởng phòng công nghệ, trưởng bộ phận marketing, chuyên viên phát triển các sản phẩm phần mềm Bitrix - Nga..., anh Trần Văn Sơn quyết định khởi động lại dự án công ty, lấy tên là: Công ty TNHH Giải pháp Công nghệ VinaEnter với sứ mệnh là công ty phát triển công nghệ, cung cấp giải pháp marketing online số 1 tại Việt Nam.</p>\r\n<img alt=\"\" src=\"https://vinaenter.edu.vn/resources/assets/templates/edu/images_tmp/aboutus/tran-van-son-truong-gia-binh.jpg\" />\r\n<p>Anh Trần Văn Sơn và Chủ tịch hội đồng quản trị FPT Trương Gia Bình tại lễ trao giải Cá nhân tiêu biểu.</p>\r\n\r\n<h3>VinaEnter Edu ra đời năm 2013</h3>\r\n\r\n<p>Khởi nghiệp từ khi còn là sinh viên, với nhiều kiến thức lập trình, marketing và am hiểu về kinh doanh, anh Trần Văn Sơn được nhiều trường học mời làm diễn giả 1 số chương trình dành cho sinh viên. Anh nhận thấy hầu hết sinh viên, nhất là sinh viên CNTT chưa có định hướng về tương lai ngành học của mình: \"Ra trường em sẽ làm gì? Chuyên môn của em là gì?\". Với trăn trở đó, anh cùng ban lãnh đạo công ty VinaEnter quyết định thành lập Trung tâm đào tạo VinaEnter Edu vào cuối năm 2013.</p>\r\n<img alt=\"\" src=\"https://vinaenter.edu.vn/resources/assets/templates/edu/images_tmp/aboutus/mot-buoi-hoc.jpg\" />\r\n<p>Một buổi học tại Trung tâm đào tạo VinaEnter Edu</p>\r\n\r\n<p>Từ năm 2013-2017, VinaEnter Edu đã dốc tâm huyết, nổ lực đào tạo cho hàng nghìn sinh viên học trực tiếp tại Đà Nẵng và Online trên toàn quốc:</p>\r\n\r\n<ul>\r\n	<li>610 học viên với 33 khóa Lập trình PHP từ A-Z đã khai giảng và tiếp tục</li>\r\n	<li>520 học viên với 17 khóa Lập trình JAVA từ A-Z đã khai giảng và tiếp tục</li>\r\n	<li>118 học viên với 11 khóa Marketing Online đã khai giảng và tiếp tục</li>\r\n	<li>VinaEnter Edu cũng đã chia sẻ kiến thức, công nghệ Marketing Online đến nhiều doanh nghiệp, giúp họ cải thiện thương hiệu của mình trên Internet.</li>\r\n</ul>\r\n\r\n<h3>Doanh nghiệp trẻ khởi nghiệp xuất sắc năm 2016</h3>\r\n\r\n<p>Với sự nổ lực của mình, VinaEnter được vinh danh là TOP 72 Doanh nghiệp trẻ khởi nghiệp xuất sắc trên toàn quốc.</p>\r\n<img alt=\"\" src=\"https://vinaenter.edu.vn/resources/assets/templates/edu/images_tmp/aboutus/pho-chu-tich-tham-vinaenter.jpg\" />\r\n<p>Phó chủ tịch UBND TP.Đà Nẵng - Võ Duy Khương ghé thăm Trung tâm đào tạo VinaEnter Edu</p>');

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
(1, 'Tôi là ai', 'toi-la-ai-jh', 63, 'vne-1530721403.jpg', 'Tôi là ai', 'Ch itieets nè', 1, 500, '2018-07-04 16:20:12', '2018-07-04 16:23:23', 1);

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
(62, 'Thời sự', 500, 1, 0, 'thoi-su'),
(63, 'Kinh doanh', 500, 1, 62, 'kinh-doanh'),
(64, 'test', 500, 0, 62, 'ssss');

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
(1, 'Phòng marketing online', 'pmo', 102),
(2, 'Phòng công nghệ', 'pcn', 200),
(3, 'Ban tư vấn tuyển sinh', 'bts', 400),
(4, 'Phòng hành chính kế toán', 'phckt', 300),
(7, 'Admin', 'admin', 500);

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
(39, 4),
(62, 2),
(63, 2),
(64, 2),
(67, 1),
(68, 1),
(69, 1),
(2, 2),
(66, 1),
(66, 4),
(66, 3),
(1, 7),
(65, 1),
(39, 4),
(62, 2),
(63, 2),
(64, 2),
(67, 1),
(68, 1),
(69, 1),
(2, 2),
(66, 1),
(66, 4),
(66, 3),
(1, 7),
(65, 1),
(70, 1);

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

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
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `vne_cat`
--
ALTER TABLE `vne_cat`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

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
  MODIFY `groupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `vne_recruitment`
--
ALTER TABLE `vne_recruitment`
  MODIFY `recuitment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
