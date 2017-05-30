SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `activations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

INSERT INTO `activations` (`id`, `user_id`, `code`, `completed`, `completed_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 46, '4etSQNqXt5SSmbX3VfUgrPfmbj6MwCz0', 1, '2016-06-20 19:51:50', '2016-06-20 19:51:50', '2016-06-20 19:51:50', NULL),
(2, 48, 'kDe4cSVHlsdZmxVHFjMJ99ZSEibimqcD', 1, '2016-06-20 19:54:24', '2016-06-20 19:54:24', '2016-06-20 19:54:24', NULL),
(3, 49, 'ABcpvQ4KRyPZLDIYjNTg3dOvUGSLoUl3', 1, '2016-06-20 19:56:58', '2016-06-20 19:56:58', '2016-06-20 19:56:58', NULL),
(4, 50, 'w0uRcpILn5sjjVATjqOwdc3GngrUKlHp', 1, '2016-06-20 19:59:37', '2016-06-20 19:59:37', '2016-06-20 19:59:37', NULL),
(5, 51, 'QS6uzbOfYO0V89sE2g8KeThUKF0JUCq1', 1, '2016-06-20 20:04:03', '2016-06-20 20:04:03', '2016-06-20 20:04:03', NULL),
(6, 52, 'luRhYJdpJxRbYpGeFxAhowyXCVlS4Bre', 1, '2016-06-20 20:08:26', '2016-06-20 20:08:26', '2016-06-20 20:08:26', NULL),
(7, 53, 'Mc7yKxUVJWP13rncwOQa648yDgYQmDhM', 1, '2016-06-20 20:10:56', '2016-06-20 20:10:56', '2016-06-20 20:10:56', NULL),
(8, 54, '4vywLMK9AxYaUKeRqPYRHrlolHNyUFtK', 1, '2016-06-20 21:00:33', '2016-06-20 21:00:33', '2016-06-20 21:00:33', NULL),
(9, 55, 'zvQHtu4CMbJOI1PvhplJzqPJrcKWQxZ7', 1, '2016-06-20 21:24:28', '2016-06-20 21:24:28', '2016-06-20 21:24:28', NULL);

CREATE TABLE IF NOT EXISTS `applicants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) NOT NULL COMMENT 'This should be the career id applicant applied',
  `provider_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email',
  `profile_url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_home` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(214) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urban_district` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_urban` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(72) COLLATE utf8_unicode_ci DEFAULT NULL,
  `availability_date` date DEFAULT NULL,
  `gender` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` tinyint(3) unsigned DEFAULT NULL,
  `nationality` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `completed` tinyint(3) unsigned DEFAULT NULL,
  `logged_in` tinyint(3) unsigned DEFAULT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `join_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `participants_provider_id_unique` (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `applicants` (`id`, `attribute_id`, `provider_id`, `provider`, `profile_url`, `photo_url`, `name`, `username`, `email`, `birthdate`, `password`, `avatar`, `about`, `phone_number`, `phone_home`, `address`, `region`, `province`, `urban_district`, `sub_urban`, `zip_code`, `website`, `availability_date`, `gender`, `age`, `nationality`, `id_number`, `file_name`, `verify`, `completed`, `logged_in`, `last_login`, `session_id`, `join_date`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(5, 7, '', '', '', '', 'Defrian Yarfi', '', 'defrian.yarfi@gmail.com', NULL, '', '', 'Tes', '980808080', '', '', '', '', '', '', '', 'http://findingnemo.com', NULL, '', 0, '', '', '61989.zip', '', 0, 0, 0, '', '0000-00-00 00:00:00', 1, NULL, '2017-05-23 18:39:39', '2017-05-24 11:07:22', NULL);

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `division_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(84) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attributes` text COLLATE utf8_unicode_ci,
  `options` text COLLATE utf8_unicode_ci,
  `end_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

INSERT INTO `banners` (`id`, `division_id`, `name`, `slug`, `description`, `image`, `attributes`, `options`, `end_date`, `user_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Web Designer', 'web-designer', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.\r\n\r\n', '38080.jpg', NULL, NULL, '2016-06-30', 20, 1, '2016-06-10 14:21:04', '2016-06-23 15:44:46', NULL),
(2, 1, 'Web Developer', 'web-developer', 'Web Developer for Digital Agency. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '89270.jpg', NULL, NULL, '2016-06-30', 20, 1, '2016-06-10 14:21:04', '2016-06-23 15:44:46', NULL),
(3, 2, 'Creative Designer', 'creative-designer', 'Creative Designer of the Company. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '89434.jpg', NULL, NULL, '2016-06-30', NULL, 1, '2016-06-16 16:59:32', '2016-06-23 15:44:46', NULL),
(4, 2, 'Art Director', 'art-director', 'Art Director for the Company. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '97737.jpg', NULL, NULL, '2016-06-30', NULL, 0, '2016-06-22 13:57:48', '2017-03-14 18:05:14', NULL),
(5, 2, 'Copywriter', 'copywriter', 'Copywriter in the company. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n\r\nWhere does it come from?\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', NULL, NULL, NULL, '2016-06-30', NULL, 1, '2016-06-23 15:18:28', '2016-06-23 15:44:46', NULL),
(6, 3, 'Account Executive', 'account-executive', 'Account Executive for the company. Modern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. To avoid unintended and confusing output in screen readers (particularly when icons are used purely for decoration), we hide them with the aria-hidden="true" attribute.\r\n\r\nIf you''re using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.\r\n\r\nIf you''re creating controls with no other text (such as a <button> that only contains an icon), you should always provide alternative content to identify the purpose of the control, so that it will make sense to users of assistive technologies. In this case, you could add an aria-label attribute on the control itself.', NULL, NULL, NULL, '2016-07-09', NULL, 1, '2016-06-23 23:46:31', '2016-06-23 23:46:31', NULL),
(7, 1, 'Senior Frontend Developer', 'senior-frontend-developer', 'HTML, CSS and JS all framework ways', '50758.jpg', NULL, NULL, '2017-03-31', NULL, 1, '2017-03-06 16:20:34', '2017-03-14 17:53:05', NULL);

CREATE TABLE IF NOT EXISTS `careers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `division_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `requirement` text COLLATE utf8_unicode_ci,
  `responsibility` text COLLATE utf8_unicode_ci,
  `facility` text COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(84) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attributes` text COLLATE utf8_unicode_ci,
  `options` text COLLATE utf8_unicode_ci,
  `end_date` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

INSERT INTO `careers` (`id`, `division_id`, `name`, `slug`, `description`, `requirement`, `responsibility`, `facility`, `image`, `attributes`, `options`, `end_date`, `user_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Web Designer', 'web-designer', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.\r\n\r\n', NULL, NULL, '', '38080.jpg', NULL, NULL, '2016-06-30', 20, 1, '2016-06-10 14:21:04', '2016-06-23 15:44:46', NULL),
(2, 1, 'Web Developer', 'web-developer', 'Web Developer for Digital Agency. It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', NULL, NULL, '', '89270.jpg', NULL, NULL, '2016-06-30', 20, 1, '2016-06-10 14:21:04', '2016-06-23 15:44:46', NULL),
(3, 2, 'Creative Designer', 'creative-designer', 'Creative Designer of the Company. There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', NULL, NULL, '', '89434.jpg', NULL, NULL, '2016-06-30', NULL, 1, '2016-06-16 16:59:32', '2016-06-23 15:44:46', NULL),
(4, 2, 'Art Director', 'art-director', 'Art Director for the Company. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', NULL, NULL, '', '97737.jpg', NULL, NULL, '2016-06-30', NULL, 1, '2016-06-22 13:57:48', '2017-05-17 16:30:20', NULL),
(5, 2, 'Copywriter', 'copywriter', 'Copywriter in the company. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nWhy do we use it?\r\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).\r\n\r\n\r\nWhere does it come from?\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', NULL, NULL, '', NULL, NULL, NULL, '2016-06-30', NULL, 1, '2016-06-23 15:18:28', '2016-06-23 15:44:46', NULL),
(6, 3, 'Account Executive', 'account-executive', 'Account Executive for the company. Modern versions of assistive technologies will announce CSS generated content, as well as specific Unicode characters. To avoid unintended and confusing output in screen readers (particularly when icons are used purely for decoration), we hide them with the aria-hidden="true" attribute.\r\n\r\nIf you''re using an icon to convey meaning (rather than only as a decorative element), ensure that this meaning is also conveyed to assistive technologies – for instance, include additional content, visually hidden with the .sr-only class.\r\n\r\nIf you''re creating controls with no other text (such as a <button> that only contains an icon), you should always provide alternative content to identify the purpose of the control, so that it will make sense to users of assistive technologies. In this case, you could add an aria-label attribute on the control itself.', NULL, NULL, '', NULL, NULL, NULL, '2017-07-31', NULL, 1, '2016-06-23 23:46:31', '2017-05-17 16:27:33', NULL),
(7, 1, 'Senior Frontend Developer', 'senior-frontend-developer', 'HTML, CSS and JS all framework ways', '<ul class="iconlist iconlist-color nobottommargin">\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nDesign and build applications/ components using open source technology.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nTaking complete ownership of the deliveries assigned.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nCollaborate with cross-functional teams to define, design, and ship new features.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nWork with outside data sources and API''s.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nUnit-test code for robustness, including edge cases, usability, and general reliability.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nWork on bug fixing and improving application performance.\r\n</li>\r\n</ul>', '<ul class="iconlist iconlist-color nobottommargin">\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nDesign and build applications/ components using open source technology.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nTaking complete ownership of the deliveries assigned.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nCollaborate with cross-functional teams to define, design, and ship new features.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nWork with outside data sources and API''s.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nUnit-test code for robustness, including edge cases, usability, and general reliability.\r\n</li>\r\n<li>\r\n<i class="icon-plus-sign"></i>\r\nWork on bug fixing and improving application performance.\r\n</li>\r\n</ul>', 'You''ll be familiar with agile practices and have a highly technical background, comfortable discussing detailed technical aspects of system design and implementation, whilst remaining business driven. With 5+ years of systems analysis, technical analysis or business analysis experience, you''ll have an expansive toolkit of communication techniques to enable shared, deep understanding of financial and technical concepts by diverse stakeholders with varying backgrounds and needs. In addition, you will have exposure to financial systems or accounting knowledge.', '50758.jpg', NULL, NULL, '2017-03-31', NULL, 1, '2017-03-06 16:20:34', '2017-05-17 16:13:04', NULL),
(8, 1, 'Web Administrator', 'web-administrator', 'Your Job is a person responsible for maintaining one or many websites. The duties of the webmaster may include: ensuring that the web servers, hardware and software are operating correctly, designing the website, generating and revising web pages, A/B testing, replying to user comments, and examining traffic through the site. Webmasters of commercial websites may also need to be familiar with ecommerce software.', '<ul>\r\n	<li>Establishes Web system specifications by analyzing access, information, and security requirements; designing system infrastructure.</li>\r\n	<li>Establishes Web system by planning and executing the selection, installation, configuration, and testing of server hardware, software, and operating and system management systems; defining system and operational policies and procedures.</li>\r\n	<li>Maintains Web system performance by performing system monitoring and analysis, and performance tuning; troubleshooting system hardware, software, and operating and system management systems; designing and running system load/stress testing; escalating application problems to vendor.</li>\r\n	<li>Secures Web system by developing system access, monitoring, control, and evaluation; establishing and testing disaster recovery policies and procedures; completing back-ups; maintaining documentation.</li>\r\n	<li>Upgrades Web system by conferring with vendors and services; developing, testing, evaluating, and installing enhancements and new software.</li>\r\n	<li>Meets financial requirements by submitting information for budgets; monitoring expenses.</li>\r\n	<li>Updates job knowledge by tracking emerging Internet technologies; participating in educational opportunities; reading professional publications; maintaining personal networks; participating in professional organizations.</li>\r\n	<li>Accomplishes organization goals by accepting ownership for accomplishing new and different requests; exploring opportunities to add value to job accomplishments.</li>\r\n</ul>', '<ul><li>System Administration</li><li>Technical Understanding,</li><li>Technical Management</li><li>Learning on the Fly</li><li> Verbal Communication</li></ul>', 'Maintains Web environment by identifying system requirements; installing upgrades; monitoring system performance.', NULL, NULL, NULL, '2017-06-30', NULL, 1, '2017-05-17 16:18:35', '2017-05-17 16:18:48', NULL);

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `index` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

INSERT INTO `clients` (`id`, `name`, `slug`, `description`, `image`, `index`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Suzuki Indonesia', 'suzuki_indonesia', 'Suzuki Indonesia', 'client_16806.png', 1, 1, '2017-05-25 12:15:34', '2017-05-25 13:00:14', NULL),
(2, 'Lenovo Mobile', 'lenovo_mobile', 'Lenovo Mobile Indonesia', 'client_63814.png', 2, 1, '2017-05-25 12:25:55', '2017-05-26 15:35:29', NULL),
(3, 'Choco Pai', 'choco_pai', 'Choco Pai', 'client_99555.png', 3, 1, '2017-05-25 12:54:56', '2017-05-25 12:59:20', NULL),
(4, 'MamyPoko', 'mamypoko', 'Mamypoko Diapers Indonesia', 'client_52483.png', 4, 1, '2017-05-26 11:34:02', '2017-05-26 11:37:33', NULL),
(5, 'Kopiko', 'kopiko', 'Kopiko Indonesia', 'client_44217.png', 5, 1, '2017-05-26 11:35:57', '2017-05-26 11:35:57', NULL),
(6, 'Uniqlo Indonesia', 'uniqlo_indonesia', 'Uniqlo Indonesia', 'client_46943.png', 6, 1, '2017-05-26 16:26:25', '2017-05-26 16:26:25', NULL);

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `user_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `contacts` (`id`, `name`, `email`, `phone`, `subject`, `about`, `description`, `user_id`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Defrian Yarfi', 'defrian.yarfi@gmail.com', '90808080', 'TEst Subject', 'Web Development', 'Test Message', NULL, 1, '2017-05-24 16:27:24', '2017-05-24 20:03:37', NULL),
(5, 'Defrian Yarfi', 'defrian.yarfi@gmail.com', '90808080', 'TEst Subject Test', 'Business', 'Test', NULL, 1, '2017-05-24 16:49:25', '2017-05-24 16:49:25', NULL);

CREATE TABLE IF NOT EXISTS `divisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `divisions` (`id`, `name`, `slug`, `description`, `user_id`, `is_system`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Information Technology', 'information-technology', 'Information Technology Division', 20, 1, 1, NULL, '2016-06-29 00:00:00', '2016-06-23 15:45:44'),
(2, 'Creative Design', 'creative-design', 'Creative Design Division', 20, 1, 1, NULL, '2016-06-30 00:00:00', '2016-06-23 15:45:44'),
(3, 'Account', 'account', 'Account Division', 20, 1, 1, NULL, '2016-06-23 23:45:17', '2016-06-23 23:45:17');

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attribute` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

INSERT INTO `images` (`id`, `participant_id`, `type`, `url`, `title`, `file_name`, `attribute`, `count`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 20, 'fabric', NULL, NULL, '577510fc3c867.png', NULL, NULL, 1, NULL, '2016-06-30 19:30:52', '2016-06-30 19:30:52'),
(2, 23, 'fabric', NULL, NULL, '5775131d85d20.png', NULL, NULL, 1, NULL, '2016-06-30 19:39:57', '2016-06-30 19:39:57'),
(3, 22, 'fabric', NULL, NULL, '57751580614d1.png', NULL, NULL, 1, NULL, '2016-06-30 19:50:08', '2016-06-30 19:50:08'),
(4, 43, 'fabric', NULL, NULL, '577515f9db8db.png', NULL, NULL, 1, NULL, '2016-06-30 19:52:09', '2016-07-09 23:19:41'),
(5, 44, 'fabric', NULL, NULL, '5775167de1c5d.png', NULL, NULL, 1, NULL, '2016-06-30 19:54:21', '2016-06-30 19:54:21'),
(6, 20, 'fabric', NULL, NULL, '5775174c8c13b.png', NULL, NULL, 1, NULL, '2016-06-30 19:57:48', '2016-06-30 19:57:48'),
(7, 21, 'fabric', NULL, NULL, '577549a3c765c.png', NULL, NULL, 1, NULL, '2016-06-30 23:32:35', '2016-06-30 23:32:35'),
(8, 24, 'fabric', NULL, NULL, '57754d1e8479c.png', NULL, NULL, 1, NULL, '2016-06-30 23:47:26', '2016-06-30 23:47:26'),
(9, 43, 'fabric', NULL, NULL, '57754f7fa82ea.png', NULL, NULL, 1, NULL, '2016-06-30 23:57:35', '2016-06-30 23:57:35'),
(10, 55, 'fabric', NULL, NULL, '58e7603332257.png', NULL, NULL, 1, NULL, '2017-04-07 16:47:31', '2017-04-07 16:47:31');

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `index` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

INSERT INTO `menus` (`id`, `name`, `slug`, `description`, `image`, `index`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Home', 'home', 'Home page', '', 1, 1, '2016-04-16 00:00:00', '2017-05-23 11:00:30', NULL),
(2, 'About Us', 'about_us', 'About Us Page', '', 2, 1, '2016-04-16 00:00:00', '2017-05-23 11:00:22', NULL),
(3, 'Contact', 'contact', 'Contact us Page. Feel free to contact us with this contact page.', '', 7, 1, '2016-04-18 16:25:47', '2017-05-23 11:03:45', NULL),
(4, 'Services', 'services', ' We provide Amazing Solutions', '', 3, 1, '2016-04-20 19:41:37', '2017-05-23 13:42:26', NULL),
(5, 'Our Machine', 'our_machine', 'Our Machine', '', 0, 0, '2016-04-20 19:41:52', '2016-06-23 11:02:55', NULL),
(6, 'Client & Partners', 'client_&_partners', 'Client & partners description', '', 0, 0, '2016-04-20 19:42:13', '2016-06-23 11:02:55', NULL),
(7, 'Gallery', 'gallery', 'Gallery Menus Description', '', 0, 0, '2016-04-20 19:42:27', '2017-05-23 11:10:09', NULL),
(8, 'Career', 'career', 'Career Page', '54072_menu.jpg', 6, 1, '2016-06-10 13:23:39', '2017-05-24 20:32:59', NULL),
(9, 'Portfolio', 'portfolio', 'Showcase of Our Awesome Works', '', 4, 1, '2017-05-23 11:11:42', '2017-05-23 13:42:00', NULL),
(10, 'Blog', 'blog', 'Our Latest Blog from Insider', '', 5, 1, '2017-05-23 11:12:10', '2017-05-23 13:41:12', NULL);

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_100000_create_password_resets_table', 1),
('2014_07_02_230147_migration_cartalyst_sentinel', 4),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_10_09_194502_create_users_table', 1),
('2015_10_26_155821_create_tasks_table', 2),
('2015_10_28_165713_create_user_groups_table', 3),
('2014_07_02_230147_migration_cartalyst_sentinel', 4),
('2015_11_11_183239_create_settings', 5),
('2015_11_24_124648_migration_cartalyst_sentinel', 7),
('2015_11_24_142038_migration_cartalyst_sentinel', 8),
('2015_12_01_223306_create_pages_table', 9),
('2015_12_03_144553_create_participants_table', 10),
('2016_01_20_141221_create_careers_table', 11),
('2016_06_23_170633_create_contacts_table', 12),
('2016_06_28_122418_create_images_table', 13),
('2017_03_22_154850_create_session_table', 14),
('2014_10_29_202547_migration_cartalyst_tags_create_tables', 15);

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

INSERT INTO `pages` (`id`, `menu_id`, `name`, `slug`, `description`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, 'Terms of Service', 'terms-of-service', 'History page description', 1, '2016-04-16 00:00:00', '2016-06-23 15:38:09', NULL),
(2, 2, 'History', 'history', 'History page description', 1, '2016-04-16 00:00:00', '2017-05-23 11:07:13', NULL);

CREATE TABLE IF NOT EXISTS `participants` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `provider_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email',
  `profile_url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_url` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone_home` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(214) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `province` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `urban_district` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sub_urban` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(72) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` tinyint(3) unsigned DEFAULT NULL,
  `nationality` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_number` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verify` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `completed` tinyint(3) unsigned DEFAULT NULL,
  `logged_in` tinyint(3) unsigned DEFAULT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `session_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `join_date` timestamp NULL DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `participants_provider_id_unique` (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

INSERT INTO `participants` (`id`, `provider_id`, `provider`, `profile_url`, `photo_url`, `name`, `username`, `email`, `password`, `avatar`, `about`, `phone_number`, `phone_home`, `address`, `region`, `province`, `urban_district`, `sub_urban`, `zip_code`, `website`, `gender`, `age`, `nationality`, `id_number`, `file_name`, `verify`, `completed`, `logged_in`, `last_login`, `session_id`, `join_date`, `status`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '101905163943989356331', 'Google', 'https://plus.google.com/+DefrianYarfi', NULL, 'Defrian Yarfi', 'dyarfi', 'defrian.yarfi@gmail.com', NULL, NULL, 'Web Developer', '081807244697', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, NULL, NULL, NULL, '2015-12-31 00:00:00', 1, NULL, '2015-12-31 00:00:00', '2016-06-23 15:55:31', NULL),
(3, '101905163943989356332', 'Google', 'https://plus.google.com/+DefrianYarfi', NULL, 'Defrian Yarfi', 'dyarfi', 'defrian.yarfi@gmail.com', NULL, NULL, 'Senior Web Developer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', 1, NULL, NULL, NULL, '2015-12-31 00:00:00', 1, NULL, '2015-12-31 00:00:00', '2016-06-23 15:55:31', NULL);

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `persistences` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `persistences_code_unique` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=264 ;

INSERT INTO `persistences` (`id`, `user_id`, `code`, `deleted_at`, `created_at`, `updated_at`) VALUES
(6, 1, 'flRdcX3E2hHr8JKYm63WEBCApFCcCq6T', NULL, '2015-11-24 14:38:55', '2015-11-24 14:38:55'),
(7, 1, 'IvLSkYhxkpfRqaYKu70Z16tRixF6zERo', NULL, '2015-11-25 11:49:26', '2015-11-25 11:49:26'),
(10, 1, 'IHAscdrDlQDuNfw8CYtUYFS4C0QmGjWs', NULL, '2015-11-25 19:28:28', '2015-11-25 19:28:28'),
(11, 1, 'kman6Vdpn6WGBpPmnuj7jlERPumtm3z5', NULL, '2015-11-26 17:09:47', '2015-11-26 17:09:47'),
(16, 20, '4ax1VZuDHCYwV8StmYopOtU910HXq6Uo', NULL, '2015-11-27 16:38:19', '2015-11-27 16:38:19'),
(17, 20, 'pQc34wsW6XEOY7uMgPj5CuLE3lCvm32r', NULL, '2015-11-30 11:29:53', '2015-11-30 11:29:53'),
(24, 20, 'eBpn2rTE5eZHBJZNvJu32KIWOuQLd5P3', NULL, '2015-12-01 13:52:06', '2015-12-01 13:52:06'),
(25, 20, 'O009YLJtJF1byePOXUzrGFm1S19F8tkO', NULL, '2015-12-02 11:52:03', '2015-12-02 11:52:03'),
(26, 20, 'VOFXZMDpyUVpQ0tTF62RSYf28SsGstez', NULL, '2015-12-02 17:37:41', '2015-12-02 17:37:41'),
(27, 20, 'TteCPjQhASMS0dBBng2ltOL3q53tcH0L', NULL, '2015-12-03 13:44:17', '2015-12-03 13:44:17'),
(28, 20, 'qTN69itNvDGmyHDvXyyBUErOLWD2YhyF', NULL, '2015-12-03 16:22:14', '2015-12-03 16:22:14'),
(32, 20, '7B6JHlsofwQjiMGrbKKN4n4SiEfotJ1g', NULL, '2015-12-04 20:05:25', '2015-12-04 20:05:25'),
(33, 20, 'qKTpW50SCAI2SmKkIL1G5xWp9hDxINrP', NULL, '2015-12-07 12:32:54', '2015-12-07 12:32:54'),
(34, 20, 'WvkmHtEVMX3YVA0TO9BVG03lEXFp54Uj', NULL, '2015-12-08 12:26:50', '2015-12-08 12:26:50'),
(35, 20, 'Z78qiaBN6lIdLZtz8Dcx0jkTvTO3C92S', NULL, '2015-12-08 17:05:19', '2015-12-08 17:05:19'),
(36, 20, 'zVXPlUXPf0Jx2ySvOVrnDxRj7cjC8pUY', NULL, '2015-12-09 03:58:40', '2015-12-09 03:58:40'),
(37, 20, 'dik07ITENI5ZnKEdJS5DFCRHACYvRjOS', NULL, '2015-12-09 14:33:55', '2015-12-09 14:33:55'),
(38, 20, '84waxKwDPRvTGgbdaX7BrDnBi4441biS', NULL, '2015-12-10 15:46:44', '2015-12-10 15:46:44'),
(40, 20, 'y2lsFF1sfW4o14xXDjWXdmZGNJjchSsQ', NULL, '2015-12-10 21:09:46', '2015-12-10 21:09:46'),
(41, 20, 'r5QWBZTAJoLoFbgsPMn37iwZgQBQ4FLO', NULL, '2015-12-11 13:03:32', '2015-12-11 13:03:32'),
(42, 20, '94uns1ZCCZvBYiXzede3BDxSrASAL3xY', NULL, '2015-12-12 01:13:31', '2015-12-12 01:13:31'),
(43, 20, '1K6tdEYCLSGe1pEym7mZTRKfwIDtein7', NULL, '2015-12-15 16:45:55', '2015-12-15 16:45:55'),
(44, 20, 'AShJCcvLIERIAlHgdWg0HqUdUQvo6Qjm', NULL, '2015-12-15 16:58:32', '2015-12-15 16:58:32'),
(45, 20, 'LPkRWkpVUT3fl3Uu9ke7E7m4BTDyOx6p', NULL, '2015-12-15 23:35:13', '2015-12-15 23:35:13'),
(46, 20, 'Ex38oF7wXlQ63gW0rLFa0FT24jhT3jRS', NULL, '2015-12-16 14:28:41', '2015-12-16 14:28:41'),
(47, 20, 'sU8Dqw4SrHTdtU6lsFstsf5Zg4K9j9YR', NULL, '2015-12-16 17:12:26', '2015-12-16 17:12:26'),
(48, 20, 'cX76BvV59LOUQjN18X1xUKnIoew1XwG0', NULL, '2015-12-17 13:06:54', '2015-12-17 13:06:54'),
(49, 20, 'RGYOlurQOK5wQGJQd825elXJJC1rIl1Z', NULL, '2015-12-17 15:22:58', '2015-12-17 15:22:58'),
(50, 20, 'mbvbOLKytKVPWbf47TaIqa0FwqV8MkNo', NULL, '2015-12-17 16:12:21', '2015-12-17 16:12:21'),
(51, 20, 'O3JdvwmUKV63xyQ2MSvx8IIKsDp8lPtJ', NULL, '2015-12-18 15:13:50', '2015-12-18 15:13:50'),
(52, 20, 'xzF6y3mnHJ4TQWmfe9OsSlTVBUDimTkP', NULL, '2015-12-21 14:45:57', '2015-12-21 14:45:57'),
(53, 20, 'oXUF9TIpDMhCG07RDotHd6PuIUn44X8Q', NULL, '2015-12-21 21:20:43', '2015-12-21 21:20:43'),
(54, 20, 'WD0pJKdLFZ1SwVXCaqFBOMDctOW2aV4i', NULL, '2015-12-22 17:10:34', '2015-12-22 17:10:34'),
(55, 20, 'X2u4ej7tBwrY7P6ljxMc94ekawO9tXZ0', NULL, '2015-12-23 12:02:53', '2015-12-23 12:02:53'),
(56, 20, 'L7ajOuocMvZrZ5nnjBagkTvg4VZDlpQ2', NULL, '2015-12-23 21:49:53', '2015-12-23 21:49:53'),
(58, 21, '44CJ44Y3CgKVimNnGlyOeoz2n0GkZyB2', NULL, '2015-12-24 01:46:37', '2015-12-24 01:46:37'),
(60, 21, 'fVUeEXyrDqVFWFQNr9XIXZ3BNk6vNmcY', NULL, '2015-12-24 20:53:54', '2015-12-24 20:53:54'),
(63, 20, 'zgQ2uQl8J6sovqZ1UxFZafj1EhhWPIa5', NULL, '2015-12-25 23:45:53', '2015-12-25 23:45:53'),
(65, 20, '4Zba0sJnUuvZ2mJgDIpqZS3m1mo5eYZl', NULL, '2015-12-27 02:36:39', '2015-12-27 02:36:39'),
(67, 20, 'ER1XNoqN1jxMjOlIDofPrSQR2WhqhBjQ', NULL, '2015-12-28 00:56:29', '2015-12-28 00:56:29'),
(68, 20, 'UUzmm4CPPKhOrY6BfOaY0D4hTK4g2siu', NULL, '2015-12-31 17:33:45', '2015-12-31 17:33:45'),
(69, 20, 'CxBwtehhVuXzQn9RwbUFV7jbGSb1iXcQ', NULL, '2016-01-01 10:59:13', '2016-01-01 10:59:13'),
(70, 20, 'Yfv2M4dUKI7xYVqSjh7T4cTYxXpzJshu', NULL, '2016-01-04 12:14:12', '2016-01-04 12:14:12'),
(71, 20, 'YoyasOGny5vZJMF0I86AxWEf24U348UT', NULL, '2016-01-05 11:41:18', '2016-01-05 11:41:18'),
(72, 20, '9sOGioSiSOvuqgV12Ig5LdqXkVn7y4jv', NULL, '2016-01-05 15:55:55', '2016-01-05 15:55:55'),
(73, 20, 'M0Kqa6b3FFYfQoQkEHKhRs62eFJnv79u', NULL, '2016-01-06 10:34:31', '2016-01-06 10:34:31'),
(74, 20, 'JJWowR0gO5RlLbCEw4OWQoq5R7Mspw14', NULL, '2016-01-07 21:02:20', '2016-01-07 21:02:20'),
(75, 20, 'WJ77xIW8S8lGZArpBS1182dJiuetgJMA', NULL, '2016-01-08 14:24:42', '2016-01-08 14:24:42'),
(76, 20, 'Y3vorN7O3vkQSnGf4szSQaBdKDBFhUza', NULL, '2016-01-09 21:27:42', '2016-01-09 21:27:42'),
(77, 20, 'AZHbKOXd5L7EpmHfWOi4csMc7y6hC8Nt', NULL, '2016-01-11 16:16:27', '2016-01-11 16:16:27'),
(78, 20, 'y7souXCWwwj6gWA2AW6a6wVViQiIDrmm', NULL, '2016-01-12 16:29:03', '2016-01-12 16:29:03'),
(79, 20, 'KAEKIYiDpX9zNlgE9SwZ6mMTuqLAMOCu', NULL, '2016-01-19 11:05:40', '2016-01-19 11:05:40'),
(80, 20, 'Sk1retqoH7cAaahYgishMdghn0UaL2rC', NULL, '2016-01-19 17:40:58', '2016-01-19 17:40:58'),
(81, 20, 'OkEaOIr316Adc0iqgbnkV7CwzE9izGi2', NULL, '2016-01-19 17:54:43', '2016-01-19 17:54:43'),
(82, 20, '7VsOCOnfSsYYnaXOg5n36bp2g3aKT7Nf', NULL, '2016-01-20 14:21:00', '2016-01-20 14:21:00'),
(83, 20, '8JsqTTQjbpG6rjR3BeVnAakFBXrNpv34', NULL, '2016-01-21 17:30:52', '2016-01-21 17:30:52'),
(84, 20, 'x006a4dOawFDrpWMfw6NoltIQoD6dPcf', NULL, '2016-01-22 11:31:12', '2016-01-22 11:31:12'),
(85, 20, 'WboCFct3kgaQVQ96eSyuIQpVuz0DAAOe', NULL, '2016-01-23 15:20:53', '2016-01-23 15:20:53'),
(86, 20, 'hLp5KNyFlVRgeDSEkPMXslMLSMa7B6bF', NULL, '2016-01-24 21:56:57', '2016-01-24 21:56:57'),
(87, 20, 'J4oZII2UBd59IBgI7evvhyTdBSB8Jz3T', NULL, '2016-02-03 10:14:31', '2016-02-03 10:14:31'),
(88, 20, '7p2qt5YXH65KzdC0A8ImkXt3jxAmZ7gK', NULL, '2016-02-09 14:34:00', '2016-02-09 14:34:00'),
(89, 20, 'wcICl2Py2ND4JFDJLju5FXApwJ9VAMDP', NULL, '2016-02-10 11:31:09', '2016-02-10 11:31:09'),
(90, 20, '3butWJwQXmzZejtVmu0DcLEetGqvYq1L', NULL, '2016-02-10 14:56:13', '2016-02-10 14:56:13'),
(91, 20, 'OITnbL6tKZqtviWtYfoDY7PSjPYUnBBd', NULL, '2016-02-10 14:56:25', '2016-02-10 14:56:25'),
(92, 20, 'NLUqX7ADijnmkgFUzAEKAesHDiWb9L68', NULL, '2016-02-11 11:14:47', '2016-02-11 11:14:47'),
(93, 20, 'CvCzE3ICuOy0ymemziJlX6wKdPb1srIC', NULL, '2016-02-11 16:11:28', '2016-02-11 16:11:28'),
(94, 20, 'RuLJR2s2PAkW57MmiRDZ1oD6gM3BrsyX', NULL, '2016-03-02 17:38:39', '2016-03-02 17:38:39'),
(95, 20, 'Wt4kUvSsP9CE2SIZKp3GQb9WCMyItpTT', NULL, '2016-03-03 10:09:24', '2016-03-03 10:09:24'),
(96, 20, 'uME3MnkjAi8zQB4JDKhUCdOhSrd0iVZe', NULL, '2016-03-03 15:44:39', '2016-03-03 15:44:39'),
(97, 20, 'UzVDP1sYBOlCllOcejoBXQuqSclxDFb5', NULL, '2016-03-09 10:04:49', '2016-03-09 10:04:49'),
(98, 20, 'WmfbnLc4JavymVwMDnWqxM3dAgydYCuw', NULL, '2016-03-11 19:05:20', '2016-03-11 19:05:20'),
(99, 20, 'UAxK1kZjHfFVYF3NpVNbjZlPx6HtHcEt', NULL, '2016-03-22 19:34:37', '2016-03-22 19:34:37'),
(100, 20, 'YBcb2IJVYfU9u9ThCpbniPDVfMuCvSbC', NULL, '2016-03-22 23:12:49', '2016-03-22 23:12:49'),
(101, 20, 'aZ6EoylDAGPi96nKfihLXT5jG7JcOg8H', NULL, '2016-03-30 16:11:14', '2016-03-30 16:11:14'),
(102, 20, 'zi5n5Uae0AsJ2xlzzYWnophrEo3a157g', NULL, '2016-03-31 00:21:41', '2016-03-31 00:21:41'),
(103, 20, 'd59aDHkPPub2RXVuprkRrtr7uRNkM6Mg', NULL, '2016-04-05 16:48:15', '2016-04-05 16:48:15'),
(104, 20, 'PaVQaOHhjjoeBbmEXiwo83A2NfXDIHry', NULL, '2016-04-06 00:29:35', '2016-04-06 00:29:35'),
(105, 20, 'Yx70KOMvKPcRRiKJj7NrbUuUZ3jVkcp3', NULL, '2016-04-06 10:00:36', '2016-04-06 10:00:36'),
(106, 20, 'ziJdNB3rkPg0rJ2TcKHt0aSNeZuGJfwC', NULL, '2016-04-07 20:35:45', '2016-04-07 20:35:45'),
(107, 20, 'JZb0kSG8dbm38IVMq6hi9FTIJQW4rZLQ', NULL, '2016-04-08 10:28:03', '2016-04-08 10:28:03'),
(108, 20, 'lpjnrr3JMwL5Ez7cedIIMxj5spFX85Pt', NULL, '2016-04-11 14:39:35', '2016-04-11 14:39:35'),
(110, 20, 'uZk5jChv1VFp4cENVdF6si2Gw6G5ffBk', NULL, '2016-04-11 21:00:15', '2016-04-11 21:00:15'),
(111, 20, 'EKzxw0ljHwFFU84xnnbsv1xA8I5fwUh2', NULL, '2016-04-11 23:44:36', '2016-04-11 23:44:36'),
(112, 20, 'Oa9OnWPDj23YxHK5Es59WIfoegdmigtD', NULL, '2016-04-12 21:59:09', '2016-04-12 21:59:09'),
(119, 20, 'cLow0IV8QuvElgKEqMyBiBGLJ8AiHwNE', NULL, '2016-04-13 18:19:29', '2016-04-13 18:19:29'),
(124, 20, 'BBL3YIgEOpHZN2bSkUZIIyIeaPrSGKiy', NULL, '2016-04-14 00:37:59', '2016-04-14 00:37:59'),
(125, 20, 'x2Ogg8FsoHNWaiv2g3rFa87nEHRQRJdB', NULL, '2016-04-14 13:57:39', '2016-04-14 13:57:39'),
(126, 20, 'a4Oiw2XAG2Xl5NCwlMEiXnehtUrWcZtv', NULL, '2016-04-16 22:35:54', '2016-04-16 22:35:54'),
(127, 20, 'kDFz43itLauWyU6sIwJBcc3W1urNQqEw', NULL, '2016-04-17 19:00:24', '2016-04-17 19:00:24'),
(128, 20, 'cOC99MqATfEe0yQZvtOwKIAA1g91n0tr', NULL, '2016-04-18 13:41:42', '2016-04-18 13:41:42'),
(129, 20, 'LqIIY6pmsTLgJEXqdyYPMSBjmgTK2rFd', NULL, '2016-04-18 16:12:39', '2016-04-18 16:12:39'),
(130, 20, 'l2Pp6eC6vPPGNHKofV4BLXlgf355iA5k', NULL, '2016-04-20 15:46:41', '2016-04-20 15:46:41'),
(131, 20, 'krZwWPXM1iGBWjDdYNqeOdxl0BlzfLaD', NULL, '2016-04-20 19:40:54', '2016-04-20 19:40:54'),
(132, 20, 'SJEsPOsGxWfLqkEl9L7HO623jD47ASNM', NULL, '2016-04-21 12:14:06', '2016-04-21 12:14:06'),
(133, 20, 'x3lSNwf6OKJEqAeyQnlFRDLEGPx5J5Y6', NULL, '2016-06-02 12:15:59', '2016-06-02 12:15:59'),
(135, 20, 'AJRSPsimptWEeE4bZ7ieaZrWsSHBL3vc', NULL, '2016-06-10 13:22:40', '2016-06-10 13:22:40'),
(136, 20, 'e6OBcvrL29dHAeLCDl0nv6lkYDQUMjBC', NULL, '2016-06-15 10:43:28', '2016-06-15 10:43:28'),
(137, 20, 'wgXkzyLbyy9rsXuiiKDJWz35aeBIEeQ4', NULL, '2016-06-15 11:57:39', '2016-06-15 11:57:39'),
(138, 20, 'cnXeWoJzCxhYQ3DV1H03ET2DkNOy0vVR', NULL, '2016-06-15 15:02:36', '2016-06-15 15:02:36'),
(140, 20, 'xhtdg0h9k63oUDHyMcXiEKHQR3y3yasO', NULL, '2016-06-16 16:49:00', '2016-06-16 16:49:00'),
(142, 20, 'wM0WptVWuIlWeivMnLPZX1MGhMHWD4BA', NULL, '2016-06-16 23:11:24', '2016-06-16 23:11:24'),
(143, 20, 'qVtASXTv8OdNXr9CR3w1OqMIeqxNLviA', NULL, '2016-06-17 11:38:26', '2016-06-17 11:38:26'),
(144, 20, 'TjqC8bMahTNh28FIU0JqfgkwrYkyiIzd', NULL, '2016-06-20 11:32:45', '2016-06-20 11:32:45'),
(146, 20, 'Sg0eR18JXGkFiDFunGYyk649e49bFpU2', NULL, '2016-06-20 15:30:32', '2016-06-20 15:30:32'),
(147, 49, 'ANmv3Z9smaJEviQFz8T6Y2aAqfGgowbE', NULL, '2016-06-20 19:56:58', '2016-06-20 19:56:58'),
(148, 50, 'DMP1EckCBIy9tpDYBzfhthuIDqHkiRxh', NULL, '2016-06-20 19:59:37', '2016-06-20 19:59:37'),
(149, 52, 'uD0R8AWyFCFdGZbEuBrRDjrBtstGApgT', NULL, '2016-06-20 20:08:26', '2016-06-20 20:08:26'),
(150, 53, 'TviifzEwRldCkdw8i7bhf9k1qLYZUcvt', NULL, '2016-06-20 20:10:56', '2016-06-20 20:10:56'),
(165, 20, 'mD61jU2WSASF9IrvOFwFSxlWoX3wXA0d', NULL, '2016-06-21 09:09:33', '2016-06-21 09:09:33'),
(167, 20, 'BQVCbMqn6AxHpOXSbd3qBNLiPLimPR7M', NULL, '2016-06-21 10:38:12', '2016-06-21 10:38:12'),
(168, 20, 'SKXgo3qlZ9hN4Cl1H493o1N63CKQaGJN', NULL, '2016-06-21 21:33:38', '2016-06-21 21:33:38'),
(169, 20, 'jOvzfTOtOPbuD7jdg4df3HOsLoB5457o', NULL, '2016-06-22 09:15:22', '2016-06-22 09:15:22'),
(170, 20, 'aYDJFHvDVfQp58wclzc5h238fuytNGPU', NULL, '2016-06-22 12:01:50', '2016-06-22 12:01:50'),
(172, 20, 'v6ez5YM3lCpzn9pIE765fDBzhpd7H7k8', NULL, '2016-06-23 13:22:02', '2016-06-23 13:22:02'),
(174, 20, 'f9KHuLm3CblzkJTXtsu0tD5e2ECz9RZ9', NULL, '2016-06-23 22:56:03', '2016-06-23 22:56:03'),
(175, 20, 'd2WlAtFztDEqPNvGwXmQuxqxxQREoqEK', NULL, '2016-06-24 11:12:10', '2016-06-24 11:12:10'),
(176, 20, 'dIcolcXkUicIRgVltMr0Cgg0Y1qx3v0o', NULL, '2016-06-24 16:42:24', '2016-06-24 16:42:24'),
(177, 20, 'siDsN8qCSSieIqqZnvHI28oK951EpAi6', NULL, '2016-06-27 14:15:00', '2016-06-27 14:15:00'),
(178, 20, '4TkhOKKr9SPNkEmqBadgI7TfPg07UIAx', NULL, '2016-06-28 12:19:08', '2016-06-28 12:19:08'),
(179, 20, 'Tfwtxgi079iFj5VuwYhejwlnfHeICul9', NULL, '2016-06-29 09:43:43', '2016-06-29 09:43:43'),
(180, 20, 'iDQt8AD0q0OwVPhe3Qiv2y277RU81OHf', NULL, '2016-06-30 12:42:29', '2016-06-30 12:42:29'),
(181, 20, 'hqa7BhEktgWCRe0txVncbZd9b0GVktjd', NULL, '2016-06-30 16:34:27', '2016-06-30 16:34:27'),
(182, 20, 'IGRCRKdkdxEn48BKF4tHeQA1lErn2CVL', NULL, '2016-06-30 17:08:43', '2016-06-30 17:08:43'),
(183, 20, 'Ym1NleT4btErY9bnvRGwJ3ObzBPJwtXb', NULL, '2016-06-30 23:33:53', '2016-06-30 23:33:53'),
(184, 20, '3KyFwyJEKGKoitWIOQB4R183zc1KZKHe', NULL, '2016-07-01 10:22:03', '2016-07-01 10:22:03'),
(185, 20, 'ah5aHCEZUlXTrL4e9bURdjRmALLwPT2U', NULL, '2016-07-08 01:55:05', '2016-07-08 01:55:05'),
(186, 20, 'gwEUqxXBWENqHKgvE6xkNxlDcGu74QY6', NULL, '2016-07-09 22:55:55', '2016-07-09 22:55:55'),
(187, 20, 'zQmLkIkgJw2NpbsJzVtacekyfrxGig0m', NULL, '2016-07-12 00:30:22', '2016-07-12 00:30:22'),
(188, 20, '4BC8GNTXmYcqwR31n3EooBhGFKMJdbhJ', NULL, '2016-07-13 09:59:21', '2016-07-13 09:59:21'),
(190, 20, '5mHmXNxWWpIKXSXAciCOkd2ZlyHzdDpf', NULL, '2016-07-14 10:56:12', '2016-07-14 10:56:12'),
(191, 20, 'l18L6nFDNUzjBq3k5Bd1cR5gp9APEpDL', NULL, '2016-07-14 10:57:17', '2016-07-14 10:57:17'),
(192, 20, 'n9aKdPVHThqX8nsHYhEqj54yWIEnLwjE', NULL, '2016-07-14 10:57:40', '2016-07-14 10:57:40'),
(193, 20, '69rzzlezjv36LocR05g3A5HIqMxKk70r', NULL, '2016-07-14 10:57:54', '2016-07-14 10:57:54'),
(194, 20, '3fbIJSuyGZeT0cMj6Ys7lzCneULJejTi', NULL, '2016-07-14 10:58:04', '2016-07-14 10:58:04'),
(195, 20, 'wL7RhtepAOWVJr9SllGeMrpaB00UTYh3', NULL, '2016-07-14 10:58:10', '2016-07-14 10:58:10'),
(197, 20, 'ChAlSeotG1s3thYDCHeMNqONkZkVrxvu', NULL, '2016-07-14 11:00:01', '2016-07-14 11:00:01'),
(198, 20, 'I0DIcMoyOXKeoGBjMtye0Mxk2x1J68Vc', NULL, '2016-07-14 18:52:12', '2016-07-14 18:52:12'),
(200, 20, 'XWcbxJZlhrihL6GrBDESLMe2kdCeEuRE', NULL, '2016-07-15 11:11:09', '2016-07-15 11:11:09'),
(201, 20, 'mP7LE7AsGGTK3iLejCWlJ4ryRgO4V8mK', NULL, '2016-07-15 18:14:47', '2016-07-15 18:14:47'),
(202, 20, 'vgA3HzZ1qRqvIpY6e7GbJtMy1lPfueUB', NULL, '2016-07-18 13:34:38', '2016-07-18 13:34:38'),
(203, 20, 'fZR5fwF2s8HU258s7FCBiy3tB2Ba4H8D', NULL, '2016-07-19 11:03:13', '2016-07-19 11:03:13'),
(204, 20, 'M7KZyedJ0D2QtUOHiHitsmwjU5AzGBl7', NULL, '2016-07-19 16:17:24', '2016-07-19 16:17:24'),
(205, 20, 'GZ32dyjegbkrpjtSgPoS1XF8dNZvVqR5', NULL, '2016-07-20 09:18:19', '2016-07-20 09:18:19'),
(206, 20, 'KqMiNYqOUhBlrx76168kFGvXScZxFcsx', NULL, '2016-07-20 17:06:33', '2016-07-20 17:06:33'),
(208, 20, 'YB2T29UUD5CevihBUsLXZYMAXEEKrpM7', NULL, '2016-07-21 10:52:58', '2016-07-21 10:52:58'),
(210, 20, 'UZhgQW09dHOzU9XCqIuu0ig2yxfWxBih', NULL, '2016-07-21 17:25:48', '2016-07-21 17:25:48'),
(213, 20, 'YgoovidCghTqkplEPAUhZ5Ui06v347QB', NULL, '2016-07-22 13:46:33', '2016-07-22 13:46:33'),
(214, 20, 'E9xTyBxDWzzkdF9JqdOj6ipXWSNh3PLd', NULL, '2016-07-22 17:22:54', '2016-07-22 17:22:54'),
(219, 22, 'awjwsn8k9RAoCmG1svRGaTzLZ0rCI9a5', NULL, '2016-07-25 12:37:05', '2016-07-25 12:37:05'),
(227, 20, 'LTxtuyHIPmm4ADVhRmzngeiayAyKI5SS', NULL, '2016-07-26 17:18:03', '2016-07-26 17:18:03'),
(229, 22, 'IJKzgsdsT22pBsV4ZuuOCGXy5CQSBYha', NULL, '2016-08-01 11:38:08', '2016-08-01 11:38:08'),
(230, 20, 'BwYZOHAF0lOpEq0taXfOrH6rtFhhJXdK', NULL, '2016-08-23 18:06:11', '2016-08-23 18:06:11'),
(231, 20, 'wG7XYzjmmLT1j26xGJQd2kRGsJhCFbwj', NULL, '2016-10-12 16:31:35', '2016-10-12 16:31:35'),
(232, 20, 'T4Wfu3IP0UYNszrILJg58lXOnIzCTGwN', NULL, '2016-11-29 12:32:59', '2016-11-29 12:32:59'),
(233, 20, 'MO7pKE3ibmUvDTD2Pk7czUyK15danK4v', NULL, '2016-11-29 15:54:28', '2016-11-29 15:54:28'),
(234, 20, 'qeWjpx2xKXG9bdheZhguOzeHR1u6NYyf', NULL, '2016-12-09 11:25:33', '2016-12-09 11:25:33'),
(236, 20, '1antdDXFdZZwacWA4HtkqfVwSV2BUJGs', NULL, '2016-12-14 18:25:22', '2016-12-14 18:25:22'),
(238, 20, 'IQ9EtDEimP8HHN2JtPGynRMh4Y0p62ZG', NULL, '2016-12-20 11:22:32', '2016-12-20 11:22:32'),
(239, 20, 'ZWspfWLO8hepowxnZ9a31BpPaKsv9Cfd', NULL, '2017-01-06 10:41:09', '2017-01-06 10:41:09'),
(240, 20, 'uiBvhyNE2vcts7aA8vPFW3vAhA9FslYc', NULL, '2017-02-02 13:25:13', '2017-02-02 13:25:13'),
(241, 20, 'M4qUxP7cWcSHxSwEo1sFnboLXS1a4XgN', NULL, '2017-02-09 10:48:03', '2017-02-09 10:48:03'),
(242, 20, 'XUcDovZjyCBGtmB2dIFAHdOK2Elfxci0', NULL, '2017-02-22 17:21:44', '2017-02-22 17:21:44'),
(243, 20, 'Yj2uu57ct7TnfUjT8RK0encc1rSsZhot', NULL, '2017-02-23 11:34:17', '2017-02-23 11:34:17'),
(245, 20, 'wV3X03vBkm8ldhUYPpxhfp6jcUq0hSyV', NULL, '2017-03-07 12:28:52', '2017-03-07 12:28:52'),
(246, 20, 'ZCTmmK6kGWogLo63qC2udh3caBr35zoT', NULL, '2017-03-13 12:39:08', '2017-03-13 12:39:08'),
(247, 20, 'ZfJ7XDinzpgdTgrQjY3falJmNEjgzSUS', NULL, '2017-03-14 17:38:45', '2017-03-14 17:38:45'),
(248, 20, 'LcmJJS7qEII0k90V4OtgsdZ6k9Qdf6rx', NULL, '2017-03-21 10:50:52', '2017-03-21 10:50:52'),
(249, 20, 'MOzP7HwOSux0dK1yfjAxJ5IQxpfxCcjv', NULL, '2017-03-22 15:50:54', '2017-03-22 15:50:54'),
(250, 20, 'PUnjQwRFERwELlkG0K2xT8LcGeJbkILt', NULL, '2017-03-23 12:53:30', '2017-03-23 12:53:30'),
(251, 20, 'JI5VDrw2OcTBCnkhUDdVEirLnxbzCmkz', NULL, '2017-03-23 22:13:07', '2017-03-23 22:13:07'),
(252, 20, 'qEAFEQaoF601elntAJMIryucDKcDAQpf', NULL, '2017-03-24 14:34:35', '2017-03-24 14:34:35'),
(253, 20, 'H134XH8heEbIJqyjRl19T3xcRbjBgsxE', NULL, '2017-04-18 18:09:26', '2017-04-18 18:09:26'),
(254, 20, 'CJkhPEyKJpCI3I0QFD6Da97vuoCnzEUC', NULL, '2017-05-03 12:42:10', '2017-05-03 12:42:10'),
(255, 20, 'uTDW3w6cFPQwZagJaH9LdljzLFDHdNmK', NULL, '2017-05-16 15:13:42', '2017-05-16 15:13:42'),
(256, 20, '7udUyQYNmx9djsd5OjT2gJdxyaXkIIBQ', NULL, '2017-05-17 15:00:13', '2017-05-17 15:00:13'),
(257, 20, 'A0PwladLfA7SSkQWdl8jnCPOrdDUmLuv', NULL, '2017-05-23 10:42:28', '2017-05-23 10:42:28'),
(258, 20, 'cmTo22s79LWkHByRLslP4IWNyuHfCKPj', NULL, '2017-05-24 10:44:56', '2017-05-24 10:44:56'),
(259, 20, 'dYvCLT97qjS3GkJTq1FidHatkCCwPOhm', NULL, '2017-05-24 20:02:13', '2017-05-24 20:02:13'),
(260, 20, 'MKenfXMIhrguyw31jglaZussGQZP6MHr', NULL, '2017-05-25 11:43:36', '2017-05-25 11:43:36'),
(261, 20, 'u0taN1BMcHofqYqzZHBZdMMgkldEGWX9', NULL, '2017-05-26 10:54:33', '2017-05-26 10:54:33'),
(262, 20, '9RwO07WWATMVYjPFApgSozYjyyT0dTgL', NULL, '2017-05-29 13:58:53', '2017-05-29 13:58:53'),
(263, 20, 'X50Xy9K3d1P6MBwApF9hM81hg887pa4f', NULL, '2017-05-30 10:14:19', '2017-05-30 10:14:19');

CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `index` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

INSERT INTO `portfolios` (`id`, `client_id`, `project_id`, `name`, `slug`, `description`, `image`, `index`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Homepage Website Suzuki', 'homepage_website_suzuki', 'Homepage Website Suzuki Design', 'portfolio_29266.jpg', 1, 1, '2017-05-25 12:43:16', '2017-05-29 14:53:16', NULL),
(2, 2, 2, 'Lenovo Facebook Page', 'lenovo_facebook_page', 'Social Media Campaign', 'portfolio_18075.jpg', 2, 1, '2017-05-25 12:48:29', '2017-05-29 17:00:05', NULL),
(3, 3, 3, 'Choco Pai Portfolio', 'choco_pai_portfolio', 'Choco Pai ', 'portfolio_70157.jpg', 3, 1, '2017-05-25 12:56:21', '2017-05-29 17:00:25', NULL),
(4, 4, 4, 'Homepage', 'homepage', 'Homepage of mamypoko microsite', 'portfolio_38016.jpg', 4, 1, '2017-05-26 11:49:52', '2017-05-29 17:00:36', NULL),
(5, 4, 4, 'Detail Page Mamypoko', 'detail_page_mamypoko', 'Detail Page Mamypoko Description', 'portfolio_68216.jpg', 5, 1, '2017-05-26 12:11:45', '2017-05-29 17:06:45', NULL),
(6, 1, 1, 'Website Suzuki Contact Page', 'website_suzuki_contact_page', 'Website Suzuki Contact Page', 'portfolio_71535.jpg', 6, 1, '2017-05-26 14:38:16', '2017-05-29 17:07:00', NULL),
(7, 1, 1, 'Website Suzuki Service Page', 'website_suzuki_service_page', 'Website Suzuki Service Page Description', 'portfolio_14746.jpg', 7, 1, '2017-05-26 16:00:48', '2017-05-29 17:07:11', NULL),
(8, 1, 1, 'Website Suzuki Dealer Page', 'website_suzuki_dealer_page', 'Website Suzuki Dealer Page Description', 'portfolio_27608.jpg', 8, 1, '2017-05-26 16:03:40', '2017-05-29 17:07:22', NULL),
(9, 6, 5, 'Brochure Design Uniqlo', 'brochure_design_uniqlo', 'Brochure Design Uniqlo', 'portfolio_59220.jpg', 9, 1, '2017-05-26 16:33:10', '2017-05-29 17:07:32', NULL),
(10, 1, 1, 'Website Suzuki Epart Page', 'website_suzuki_epart_page', 'Website Suzuki Epart Page Design', 'portfolio_27528.jpg', 10, 1, '2017-05-29 14:00:21', '2017-05-29 17:07:42', NULL);

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `index` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

INSERT INTO `projects` (`id`, `client_id`, `name`, `slug`, `description`, `image`, `index`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'Website Suzuki', 'website-suzuki', 'Website Description', NULL, 0, 1, '2017-05-25 12:24:12', '2017-05-25 12:24:12', NULL),
(2, 2, 'Social Media', 'social-media', 'Social Media Campaign', NULL, 0, 1, '2017-05-25 12:35:16', '2017-05-25 12:35:16', NULL),
(3, 3, 'Choco Pai Facebook Page', 'choco-pai-facebook-page', 'Choco Pai Facebook Page', NULL, 0, 1, '2017-05-25 12:55:33', '2017-05-25 12:55:33', NULL),
(4, 4, 'Microsite Mamypoko', 'microsite-mamypoko', 'Microsite Mamypoko', NULL, 0, 1, '2017-05-26 11:42:38', '2017-05-26 11:42:38', NULL),
(5, 6, 'Brochure Design', 'brochure-design', 'Brochure Design Concept', NULL, 0, 1, '2017-05-26 16:29:04', '2017-05-26 16:29:04', NULL);

CREATE TABLE IF NOT EXISTS `reminders` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT '0',
  `completed_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

INSERT INTO `roles` (`id`, `slug`, `name`, `permissions`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin', '{"admin":true,"banner":true,"career":true,"contact":true,"page":true,"participant":true,"portfolio":true,"task":true}', NULL, '2015-11-24 14:30:56', '2017-05-25 11:44:12'),
(2, 'publisher', 'Publisher', '{"admin":true,"page":true}', NULL, '2015-11-24 14:59:15', '2016-01-01 11:19:09'),
(3, 'mechanic', 'Mechanic', '{"admin":true,"page":true}', NULL, '2015-11-25 19:22:27', '2016-01-04 13:52:41'),
(4, 'supervisor', 'Supervisor', '{"admin":false,"page":true,"participant":true,"task":true}', NULL, '2015-11-25 19:25:18', '2016-01-01 11:37:10'),
(6, 'country-admin', 'Country Admin', '{"admin":false}', NULL, '2015-11-27 17:56:06', '2015-12-24 22:49:09'),
(7, 'country-manager', 'Country Manager', '{"admin":false,"page":true,"participant":true,"task":true}', NULL, '2015-12-24 22:51:05', '2016-01-05 16:03:48');

CREATE TABLE IF NOT EXISTS `role_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`user_id`,`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `role_users` (`user_id`, `role_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(20, 1, '2015-11-27 16:34:56', '2015-11-27 16:34:56', NULL),
(21, 3, '2015-11-27 17:45:56', '2015-11-27 17:45:56', NULL),
(22, 3, '2015-12-01 16:08:03', '2015-12-01 16:08:03', NULL),
(23, 2, '2015-12-02 12:33:04', '2015-12-02 12:33:04', NULL),
(24, 4, '2015-12-02 12:32:54', '2015-12-02 12:32:54', NULL),
(41, 1, '2015-12-10 17:43:54', '2015-12-10 17:43:54', NULL),
(42, 1, '2015-12-10 17:50:56', '2015-12-10 17:50:56', NULL),
(43, 1, '2015-12-10 17:52:27', '2015-12-10 17:52:27', NULL);

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `sessions` (`id`, `payload`, `last_activity`) VALUES
('c386e7af7c47b270410e83816baf3c098199da8b', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiM3BrTVVkS1pzSnFIeGZIa2htQ2ZUbTFMbUJhSVNZT2xzUjdiaDdnRSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9kMy1hcHAuZGV2L2FwYW5lbC9wb3J0Zm9saW8iO31zOjU6ImZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MTg6ImNhcnRhbHlzdF9zZW50aW5lbCI7czozMjoiWDUwWHk5SzNkMVA2TUJ3QXBGOWhNODFoZzg4N3BhNGYiO3M6OToiX3NmMl9tZXRhIjthOjM6e3M6MToidSI7aToxNDk2MTE0MDY4O3M6MToiYyI7aToxNDk2MTEzMzYzO3M6MToibCI7czoxOiIwIjt9fQ==', 1496114069);

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `key` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `value` text COLLATE utf8_unicode_ci,
  `help_text` text COLLATE utf8_unicode_ci,
  `input_type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `weight` int(11) DEFAULT NULL,
  `attributes` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

INSERT INTO `settings` (`id`, `group`, `key`, `name`, `slug`, `description`, `value`, `help_text`, `input_type`, `editable`, `weight`, `attributes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'email', 'contact', 'Email Contact', 'email-contact', 'Official Email Contact for the Company', 'contact@apanel.app', 'This email must be a valid company contact', 'text', 1, NULL, NULL, 1, '2015-11-24 12:54:41', '2016-07-20 17:42:20', NULL),
(2, 'email', 'info', 'Email Info', 'email-info', 'Email for the company information', 'info@apanel.app', 'Valid Email for the company information', 'text', 1, NULL, NULL, 1, '2015-11-24 12:55:36', '2016-07-20 17:42:20', NULL),
(3, 'site', 'name', 'Site Name', 'site-name', 'Apanel', 'Apanel Apps', 'Apanel', 'text', 1, NULL, NULL, 1, '2015-11-24 13:12:18', '2016-07-20 17:42:20', NULL),
(4, 'site', 'maintenance', 'Maintenance Mode', 'maintenance-mode', 'Maintenance Mode', 'No', 'Maintenance Mode', 'text', 1, NULL, NULL, 1, '2015-11-24 22:14:19', '2016-07-20 17:42:20', NULL),
(5, 'site', 'locale', 'Site Locale', 'site-locale', 'Site Default Locale Language', 'en', 'Site Locale Language', 'text', 1, NULL, NULL, 1, '2015-11-25 19:26:44', '2016-07-20 17:42:20', NULL),
(6, 'email', 'administrator', 'Email Administrator', 'email-administrator', 'Default Email Administrator', 'administrator@apanel.app', 'This is used for contacting Email Administrator', 'text', 1, NULL, NULL, 1, '2015-12-02 12:30:14', '2016-07-20 17:42:20', NULL),
(7, 'socmed', 'facebook', 'Socmed Facebook', 'socmed-facebook', 'Social Media link for Facebook Company', 'https://facebook.com/apanel', 'This is the link for facebook page', 'text', 1, NULL, NULL, 1, '2015-12-07 12:57:37', '2016-07-20 17:42:20', NULL),
(8, 'socmed', 'twitter', 'Socmed Twitter', 'socmed-twitter', 'The Social media link for the Twitter account company', 'https://twitter.com/apanel', 'This is the link for Twitter account', 'text', 1, NULL, NULL, 1, '2015-12-07 12:58:46', '2016-07-20 17:42:20', NULL),
(9, 'email', 'smtp.server', 'SMTP Server', 'smtp-server', 'SMTP server setting for sending email from website server', '127.0.0.1', 'Default setting for SMTP', 'text', 1, NULL, NULL, 1, '2015-12-16 00:13:54', '2016-07-20 17:42:20', NULL),
(10, 'image', 'logo', 'Image Logo', 'image-logo', 'Image logo for the Company Profiling', 'logo-24475.png', NULL, 'file', 1, NULL, NULL, 1, '2015-12-28 01:33:23', '2016-07-20 17:41:50', NULL),
(11, 'meta', 'robots', 'Meta Robots', 'meta-robots', 'Meta Robots', 'index all, follow all', NULL, 'text', 1, NULL, NULL, 1, '2016-01-04 13:28:39', '2016-07-20 17:42:20', NULL),
(12, 'meta', 'keywords', 'Meta Keywords', 'meta-keywords', 'Meta keywords for the website', 'Website meta keywords', NULL, 'textarea', 1, NULL, NULL, 1, '2016-01-04 13:29:14', '2016-07-20 17:42:20', NULL),
(13, 'meta', 'description', 'Meta Description', 'meta-description', 'Meta Description for Website', 'Website meta keywords', NULL, 'textarea', 1, NULL, NULL, 1, '2016-01-04 13:30:02', '2016-07-20 17:42:20', NULL),
(14, 'meta', 'generator', 'Meta Generator', 'meta-generator', 'Meta Generator for the website', 'apanel 1.0', NULL, 'text', 1, NULL, NULL, 1, '2016-01-04 13:30:51', '2016-07-20 17:42:20', NULL),
(15, 'site', 'default.theme', 'Site Theme', 'site-theme', 'Site Theme default', 'default', NULL, 'text', 1, NULL, NULL, 1, '2016-01-04 13:34:27', '2016-07-20 17:42:20', NULL),
(16, 'site', 'admin.theme', 'Site Admin Theme', 'site-admin-theme', 'Site Admin Theme', 'ace-admin', NULL, 'text', 1, NULL, NULL, 1, '2016-01-04 13:34:59', '2016-07-20 17:42:20', NULL),
(17, 'site', 'tagline', 'Site Tagline', 'site-tagline', 'Site Tagline', 'Web Application for your needs', NULL, 'text', 1, NULL, NULL, 1, '2016-01-04 13:40:47', '2016-07-20 17:42:20', NULL),
(18, 'site', 'timezone', 'Site Timezone', 'site-timezone', 'Timezone for website, related with content publishing', 'Asia/Jakarta', 'Timezone for website, related with content publishing', 'text', 1, NULL, NULL, 1, '2016-01-05 15:57:33', '2016-07-20 17:42:20', NULL),
(19, 'site', 'country', 'Site Country', 'site-country', 'Website country', 'Indonesia', NULL, 'text', 1, NULL, NULL, 1, '2016-01-05 16:38:53', '2016-07-20 17:42:20', NULL),
(20, 'image', 'thumbnail_size', 'Thumbnail Size', 'thumbnail-size', 'Thumbnail Size for image website thumbnail', '380x420px', NULL, 'text', 1, NULL, NULL, 1, '2015-12-28 01:33:23', '2016-07-20 17:42:20', NULL),
(21, 'image', 'image_size', 'Image Size', 'image-size', 'Image Size for image website images', '600x740px', NULL, 'text', 1, NULL, NULL, 1, '2015-12-28 01:33:23', '2016-07-20 17:42:20', NULL);

CREATE TABLE IF NOT EXISTS `tagged` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taggable_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `taggable_id` int(10) unsigned NOT NULL,
  `tag_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagged_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `namespace` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=19 ;

INSERT INTO `tasks` (`id`, `user_id`, `title`, `slug`, `description`, `image`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 20, 'What is lorem ipsum ?', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '38080.jpg', 1, '2015-10-26 11:52:29', '2016-06-23 15:38:26', NULL),
(3, 20, 'Where does it come from ? Lorem Ipsum', NULL, 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.', '', 1, '2015-10-26 11:52:57', '2016-06-23 15:38:26', NULL),
(4, 20, 'Where can I get some ?', NULL, 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don''t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn''t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '', 1, '2015-10-26 11:53:25', '2016-06-23 15:38:26', NULL),
(5, 21, 'Why do we use it ?', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for ''lorem ipsum'' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '', 1, '2015-10-26 11:56:17', '2016-06-23 15:38:26', NULL),
(6, 21, 'Does anyone know how I can modify the data a form request object', NULL, 'Does anyone know how I can modify the data a form request object contains before it is used in any way? That is, before the request if validated and before the form request data is used in any way?\r\nAs an example scenario:\r\nI have a form where a user can update their date of birth, by changing 3 fields representing the day, month and year of birth. I have created an UpdateSettingsRequest class that extends App\\Http\\Requests to represent this request.\r\nBefore this data is validated and consumed, I need to modify my request object to contain a field date_of_birth by joining the year, month and day fields together with hyphen separators like yyyy-mm-dd.\r\nHaving a dig around I have found that I could override the all method on the form request class and place my logic there. But that doesn''t modify the object''s data.\r\nMy initial though was to provide my own constructor, but I''m not sure how I would go about doing this.\r\nAny help would be appreciated.', '', 1, '2015-10-27 04:02:17', '2016-03-31 00:27:05', '2016-03-31 00:27:05'),
(7, 21, 'I want to modify the input value of a form before it is passed', NULL, 'I want to modify the input value of a form before it is passed to the validator using the new Request validation in Laravel 5.\r\nSo the question is, where can I modify (for example trim the input or encode the input) before it is passed to the validator?\r\nIn L4 I would do this before passing the values to Validator::make(), but that step is Handled by a Request validator in L5', '', 1, '2015-10-27 04:12:03', '2016-06-23 15:38:26', NULL),
(8, 21, 'You must assign it to a variable and then you can perform operations on the variable', NULL, 'You must assign it to a variable and then you can perform operations on the variable. The function get of the single pattern Input accepts a string argument and then perform''s internal operations on the HTTP request to bring the data back to you, which is why you cannot treat it as a string. However, if you assign the value of that to a variable, then the variable can be manipulated thussly.', '', 1, '2015-10-27 04:13:01', '2016-06-23 15:38:26', NULL),
(14, 21, 'Laravel 5.0', NULL, 'Laravel 5.0 is coming out in November, and there are a lot of features that have folks excited. The New Directory structure is, in my mind, a lot more in line with how most developers work; Flysystem integration will make working with files endlessly more flexible and powerful; Contracts is a great step towards making Laravel-friendly packages that aren’t Laravel-dependent; and Socialite looks about 100x easier than Opauth. Also, Method Injection opens up a lot of really exciting opportunities.\r\n\r\nOne of the most valuable aspects of Laravel for me is that it allows for rapid app development. Laravel, and other frameworks like it, automate out the repetitive work that you have to do on every project. And a lot of newer features have been focusing on this. Cashier, and now Socialite and Form Requests.', '', 1, '2015-10-27 05:36:34', '2016-06-23 15:38:26', NULL),
(16, 20, 'Task One Two Three', 'task-one-two-three', 'Task One Two Three Description', '', 1, '2016-01-19 18:22:33', '2016-06-23 15:38:26', NULL),
(17, 20, 'The object returned by the file method is an instance of the', 'the-object-returned-by-the-file-method-is-an-instance-of-the', 'The object returned by the file method is an instance of the', '', 1, '2016-01-19 19:41:55', '2016-06-23 15:38:26', NULL),
(18, 20, 'Conveniently strategize distributed ideas', 'conveniently-strategize-distributed-ideas', 'Conveniently strategize distributed ideas and professional initiatives. Proactively enable dynamic benefits without installed base e-commerce. Collaboratively actualize client-focused mindshare with top-line web-readiness. Continually deploy open-source action items whereas resource-leveling applications. Rapidiously scale efficient strategic theme areas and highly efficient ideas.', '15350.jpg', 1, '2016-07-21 16:31:50', '2016-07-21 16:31:50', NULL);

CREATE TABLE IF NOT EXISTS `throttle` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `throttle_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permissions` text COLLATE utf8_unicode_ci,
  `last_login` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'email',
  `provider_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `about` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attributes` text COLLATE utf8_unicode_ci,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_provider_id_unique` (`provider_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=56 ;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permissions`, `last_login`, `first_name`, `last_name`, `avatar`, `image`, `provider`, `provider_id`, `about`, `attributes`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(20, 'dyarfi', 'defrian.yarfi@gmail.com', '$2y$10$MgLIFp.aln//QNCuWKA98.DghURQqOtBLgLQF22MEJemlfRz5e9iq', '{"users.index":true,"users.edit":true,"users.update":true,"users.change":true,"users.create":true,"users.trash":true,"users.delete":true,"users.restored":true,"users.store":true,"users.show":true,"users.export":true,"users.dashboard":true,"roles.index":true,"roles.edit":true,"roles.update":true,"roles.change":true,"roles.create":true,"roles.trash":true,"roles.delete":true,"roles.restored":true,"roles.store":true,"roles.show":true,"permissions.index":true,"permissions.edit":true,"permissions.create":true,"permissions.store":true,"permissions.change":true,"permissions.show":true,"settings.index":true,"settings.edit":true,"settings.update":true,"settings.create":true,"settings.store":true,"settings.trash":true,"settings.delete":true,"settings.restored":true,"settings.show":true,"settings.change":true,"logs.index":true,"logs.edit":true,"logs.create":true,"logs.store":true,"logs.show":true,"pages.index":true,"pages.edit":true,"pages.update":true,"pages.change":true,"pages.create":true,"pages.store":true,"pages.show":true,"menus.index":true,"menus.edit":true,"menus.update":true,"menus.change":true,"menus.create":true,"menus.store":true,"menus.show":true,"banners.index":true,"banners.edit":true,"banners.update":true,"banners.change":true,"banners.create":true,"banners.store":true,"banners.trash":true,"banners.delete":true,"banners.restored":true,"banners.show":true,"tasks.index":true,"tasks.edit":true,"tasks.update":true,"tasks.change":true,"tasks.create":true,"tasks.store":true,"tasks.trash":true,"tasks.delete":true,"tasks.restored":true,"tasks.show":true,"careers.index":true,"careers.edit":true,"careers.update":true,"careers.change":true,"careers.create":true,"careers.store":true,"careers.trash":true,"careers.delete":true,"careers.restored":true,"careers.show":true,"divisions.index":true,"divisions.edit":true,"divisions.update":true,"divisions.change":true,"divisions.create":true,"divisions.store":true,"divisions.trash":true,"divisions.delete":true,"divisions.restored":true,"divisions.show":true,"applicants.index":true,"applicants.edit":true,"applicants.update":true,"applicants.change":true,"applicants.create":true,"applicants.store":true,"applicants.trash":true,"applicants.delete":true,"applicants.restored":true,"applicants.show":true,"contacts.index":true,"contacts.edit":true,"contacts.update":true,"contacts.change":true,"contacts.create":true,"contacts.store":true,"contacts.trash":true,"contacts.delete":true,"contacts.restored":true,"contacts.show":true,"participants.index":true,"participants.edit":true,"participants.update":true,"participants.change":true,"participants.create":true,"participants.store":true,"participants.trash":true,"participants.delete":true,"participants.restored":true,"participants.show":true,"images.index":true,"images.edit":true,"images.update":true,"images.change":true,"images.create":true,"images.store":true,"images.trash":true,"images.delete":true,"images.restored":true,"images.show":true,"clients.index":true,"clients.edit":true,"clients.update":true,"clients.change":true,"clients.create":true,"clients.store":true,"clients.trash":true,"clients.delete":true,"clients.restored":true,"clients.show":true,"projects.index":true,"projects.edit":true,"projects.update":true,"projects.change":true,"projects.create":true,"projects.store":true,"projects.trash":true,"projects.delete":true,"projects.restored":true,"projects.show":true,"portfolios.index":true,"portfolios.edit":true,"portfolios.update":true,"portfolios.change":true,"portfolios.create":true,"portfolios.store":true,"portfolios.trash":true,"portfolios.delete":true,"portfolios.restored":true,"portfolios.show":true}', '2017-05-30 10:14:19', 'Defrian', 'Yarfi', 'http://gravatar.com/dyarfi', 'usr-92189.jpg', 'email', NULL, 'Web developer', '{"skins":"#438EB9","width":100,"height":100,"crop_x":"31","crop_y":"31","crop_w":"118","crop_h":"118"}', 'XwsYypDuj04TMHzcTHCci8z292uBBctpLGlwtUeXKlAFsjZgbCNgti9CdXu4', NULL, '2015-11-27 16:34:56', '2017-05-30 10:14:19'),
(21, 'dyarfi20', 'dyarfi20@gmail.com', '$2y$10$.J3cMG6RZbGEx/eoAEb6Se9X2mamcdxkSDqRzpOqVkOTgOON7MQgS', NULL, '2016-07-26 16:42:20', 'Nairfred', 'Ifray', 'https://lh3.googleusercontent.com/-XdUIqdMkCWA/AAAAAAAAAAI/AAAAAAAAAAA/4252rscbv5M/photo.jpg?sz=50', '', 'google', '114777686552144649876', 'Web Development and E-commerce and Application Programmer', '{"skins":"#438EB9"}', 'N2obQFeYALvqMaDAJiqie5vdarMM5nPh4K9HVyKxA1Qq5iPSYpWJsG2B0K8L', NULL, '2015-11-27 17:45:56', '2016-07-26 16:42:20'),
(22, 'Emer', 'defrian.yarfi@yahoo.com', '$2y$10$EwfWl7QpS9rM/eE/0ihc0OsH8l3DcXGuQjCzZeqU8KchlPqvQaBz2', NULL, '2016-08-01 11:38:08', 'Emeraldi', 'Octavian', NULL, 'usr-80594.jpg', 'email', NULL, 'Baby of the house', '{"skins":"#438EB9","crop_x":null,"crop_y":null,"width":100,"height":100,"crop_w":"180","crop_h":"180"}', 'SyprnvoUIHMUrkqpEh43w0AQIOG7Aeh7fsa2hmeXBsPKbX4Anot7reBd5Lx7', NULL, '2015-12-01 16:08:03', '2016-08-01 11:38:08'),
(23, 'zmael', 'deffsidefry@ymail.com', '$2y$10$zmSx2zI1lONqDAVMc8VXR.D3BAkVTlqbF3bkR2yA6DugqqclQC556', NULL, NULL, 'Zmael', 'Milajovic', NULL, '', 'email', NULL, 'Test Driven Application', NULL, 'Adb3SrELAh0wDtEx2b0icwT4W85GHz5gYygjoAw7dwSDYcIJzOmMymPoJgMP', NULL, '2015-12-02 12:32:20', '2016-06-30 19:43:36'),
(24, 'Defrian Dentsu', 'defrian.yarfi@d3.dentsu.co.id', '$2y$10$DGxOR9TQVX2RRxFXUK.LKON4iX3x4uYjLICnluVfNDIMoUTGTvO.W', NULL, '2016-12-20 11:22:21', 'Yudhay', 'Kendricks', NULL, '', 'email', NULL, 'Web Developer Senior defrian.yarfi@d3.dentsu.co.id', NULL, 'WhdvWGTRoJOsMKPY19J6o3ysWFTuUoa0N2z2K3ebrPhQdEiGt0bjSUfKGz9A', NULL, '2015-12-02 12:32:54', '2016-12-20 11:22:21'),
(43, 'Valents', 'defrian.yarfi@facebook.com', '$2y$10$Ky4GJjugVDkm5T8Oth//.Oc.DUrO7bWMR7xFH0mR3H.b677Nbqn8m', '{"users.index":true,"users.edit":true,"users.update":true,"users.create":true,"users.trash":true,"users.delete":true,"users.restored":true,"users.store":true,"users.show":true,"users.dashboard":true,"roles.index":true,"roles.edit":true,"roles.update":true,"roles.create":true,"roles.trash":true,"roles.delete":true,"roles.restored":true,"roles.store":true,"roles.show":true,"permissions.index":true,"permissions.edit":true,"permissions.create":true,"permissions.store":true,"permissions.change":true,"permissions.show":true,"settings.index":true,"settings.edit":true,"settings.update":true,"settings.create":true,"settings.store":true,"settings.trash":true,"settings.delete":true,"settings.restored":true,"settings.show":true,"settings.change":true,"logs.index":true,"logs.edit":true,"logs.create":true,"logs.store":true,"logs.show":true,"pages.index":true,"pages.edit":true,"pages.update":true,"pages.create":true,"pages.store":true,"pages.show":true,"menus.index":true,"menus.edit":true,"menus.update":true,"menus.create":true,"menus.store":true,"menus.show":true,"tasks.index":true,"tasks.edit":true,"tasks.update":true,"tasks.create":true,"tasks.store":true,"tasks.trash":true,"tasks.delete":true,"tasks.restored":true,"tasks.show":true,"careers.index":true,"careers.edit":true,"careers.update":true,"careers.create":true,"careers.store":true,"careers.trash":true,"careers.delete":true,"careers.restored":true,"careers.show":true,"divisions.index":true,"divisions.edit":true,"divisions.update":true,"divisions.create":true,"divisions.store":true,"divisions.trash":true,"divisions.delete":true,"divisions.restored":true,"divisions.show":true,"applicants.index":true,"applicants.edit":true,"applicants.update":true,"applicants.create":true,"applicants.store":true,"applicants.trash":true,"applicants.delete":true,"applicants.restored":true,"applicants.show":true,"participants.index":true,"participants.edit":true,"participants.update":true,"participants.create":true,"participants.store":true,"participants.trash":true,"participants.delete":true,"participants.restored":true,"participants.show":true}', '2016-07-26 12:53:50', 'Valent', 'Schemaichel', NULL, '', 'email', NULL, 'Speaker of the Computer', NULL, 'fQhcgNZyp3xdVvUdP7cRt8y44FYLAAqCInUSlTptS5HBkebZIgQzqG1rfEdC', NULL, '2015-12-10 17:52:27', '2016-07-26 12:53:50'),
(44, 'Defrian', 'admin@admin.com', '$2y$10$CNsYxdwKHVD3ijfCJv8yS.X/RI9Vcnw0Wg12mONbcEHPkEMHe.Ybq', NULL, NULL, NULL, NULL, NULL, '', 'email', NULL, 'Host of the House', NULL, 'xmzy19SuAbDW0OZ7q2FZKDRY2AkzJw0qrh6wbH6PuonX7lCKS1L57QMamGbz', NULL, '2015-12-30 22:19:23', '2016-06-30 19:56:45'),
(55, 'dyarfi', '-', '$2y$10$1sJUeCFz1ED/tojSjXXZcOh8RF4fUZLXvgCxIxmmZbIeWd2C6/gee', NULL, '2016-06-21 08:46:01', 'Defrian', 'Yarfi', 'http://pbs.twimg.com/profile_images/417721509696634880/tKSK06gY_normal.jpeg', '', 'twitter', '300187659', 'Web Developer', NULL, 'n0LkTJAZ2pXW6b0SxGPNXr3LKZt3XHNkQWtAezGK3f0TGJlY0z2mUFXE1BgU', NULL, '2016-06-20 21:24:28', '2017-04-07 16:54:27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
