-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2017 at 12:01 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.0.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_actions`
--

CREATE TABLE `admin_actions` (
  `id` bigint(64) NOT NULL,
  `description` varchar(100) DEFAULT NULL COMMENT 'Description of Admin Action.',
  `remark` varchar(500) DEFAULT NULL COMMENT 'Details Description of Admin Action.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_actions`
--

INSERT INTO `admin_actions` (`id`, `description`, `remark`) VALUES
(1, 'Login', 'Logged In User'),
(2, 'Logout', 'Logged Out User'),
(3, 'Update Profile', 'Update Profile'),
(4, 'Change Password', 'Change Password'),
(5, 'Add Admin Action', 'Add Admin Module'),
(6, 'Edit Admin Action', 'Edit Admin Module'),
(7, 'Delete Admin Action', 'Delete Admin Module'),
(8, 'Add User Action', 'Add Admin Action'),
(9, 'Edit User Action', 'Edit Admin Action'),
(10, 'Delete User Action', 'Delete Admin Action'),
(11, 'Add Admin Module Page', 'Add Module Page'),
(12, 'Edit Admin Module Page', 'Edit Module Page'),
(13, 'Delete Admin Module Page', 'Delete Module Page'),
(14, 'Update Rights', ''),
(15, 'Add Admin Modules', ''),
(16, 'Edit Admin Modules', ''),
(17, 'Delete Admin Modules', ''),
(18, 'Add Countries', 'Add Countries'),
(19, 'Edit Countries', 'Edit Countries'),
(20, 'Delete Countries', 'Delete Countries'),
(21, 'Add State', ''),
(22, 'Edit State', ''),
(23, 'Delete State', ''),
(24, 'Add City', ''),
(25, 'Edit City', ''),
(26, 'Delete City', ''),
(27, 'Add Admin Users', 'Add Admin Users'),
(28, 'Edit Admin Users', 'Edit Admin Users'),
(29, 'Delete Admin User', 'Delete Admin Users'),
(40, 'Add Protfolios', 'Add Protfolios'),
(41, 'Edit Protfolios', 'Edit Protfolios'),
(42, 'Delete  Protfolios', 'Delete  Protfolios'),
(43, 'Add Portfolio Category', ''),
(44, 'Edit Portfolio Category', ''),
(45, 'Delete Portfolio Category', ''),
(46, 'Add Packages Category', ''),
(47, 'Edit Packages Category', ''),
(48, 'Delete Packages Category', ''),
(49, 'Add Package', 'Add Package'),
(50, 'Edit Package', 'Edit Package'),
(51, 'Delete Package', 'Delete Package');

-- --------------------------------------------------------

--
-- Table structure for table `admin_groups`
--

CREATE TABLE `admin_groups` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `order_index` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_groups`
--

INSERT INTO `admin_groups` (`id`, `parent_id`, `title`, `order_index`) VALUES
(1, NULL, 'Admin Users', 0),
(2, NULL, 'User Permissions', 10),
(3, NULL, 'Frontend Users', 2),
(4, NULL, 'Masters', 9),
(5, NULL, 'Blog', 3),
(6, NULL, 'Portfolio', 3),
(7, NULL, 'Packages', 4);

-- --------------------------------------------------------

--
-- Table structure for table `admin_group_pages`
--

CREATE TABLE `admin_group_pages` (
  `id` int(11) NOT NULL,
  `admin_group_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `menu_title` varchar(128) NOT NULL,
  `menu_order` int(11) NOT NULL,
  `description` text NOT NULL,
  `is_sub_menu` char(1) NOT NULL DEFAULT 'Y',
  `url` varchar(512) NOT NULL DEFAULT '',
  `show_in_menu` char(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_group_pages`
--

INSERT INTO `admin_group_pages` (`id`, `admin_group_id`, `name`, `menu_title`, `menu_order`, `description`, `is_sub_menu`, `url`, `show_in_menu`) VALUES
(1, 4, 'List Admin Actions', 'List Admin Actions', 1, '', 'Y', '/admin/admin-actions', 'Y'),
(2, 4, 'Add Admin Log Actions', 'Add Admin Log Actions', 2, '', 'Y', '/admin/admin-actions', 'N'),
(3, 4, 'Edit Admin Log Actions', 'Edit Admin Log Actions', 3, '', 'Y', '/admin/admin-actions', 'N'),
(4, 4, 'Delete Admin Log Actions', 'Delete Admin Log Actions', 4, '', 'Y', '/admin/admin-actions', 'N'),
(5, 2, 'List Admin Module', 'List Admin Module', 0, '', 'Y', '/admin/modules', 'Y'),
(6, 2, 'Add Admin Modules', 'Add Admin Modules', 4, '', 'Y', '/admin/modules', 'N'),
(7, 2, 'Edit Admin  Modules', 'Edit Admin  Modules', 5, '', 'Y', '/admin/modules', 'N'),
(8, 2, 'Delete Admin Modules', 'Delete Admin Modules', 6, '', 'Y', '/admin/modules', 'N'),
(9, 2, 'List  Admin Module Pages', 'List  Admin Module Pages', 1, '', 'Y', '/admin/module-pages', 'Y'),
(10, 2, 'Add Admin Modules Pages', 'Add Admin Modules Pages', 7, '', 'Y', '/admin/module-pages', 'N'),
(11, 2, 'Edit Admin Modules Pages', 'Edit Admin Modules Pages', 8, '', 'Y', '/admin/module-pages', 'N'),
(12, 2, 'Delete Admin Modules Pages', 'Delete Admin Modules Pages', 9, '', 'Y', '/admin/module-pages', 'N'),
(13, 3, 'List Users', 'List Users', 1, '', 'Y', '/admin/users', 'Y'),
(14, 3, 'Add Users', 'Add Users', 2, 'Update Rights', 'Y', '/admin/users', 'N'),
(15, 3, 'Edit Users', 'Edit Users', 3, '', 'Y', '/admin/users', 'N'),
(16, 3, 'Delete Users', 'Delete Users', 4, '', 'Y', '/admin/users', 'N'),
(17, 4, 'List User Actions', 'List User Actions', 5, '', 'Y', '/admin/user-actions', 'Y'),
(18, 4, 'Add Users Actions', 'Add Users Actions', 6, '', 'Y', '/admin/user-actions', 'N'),
(19, 4, 'Edit Users Actions', 'Edit Users Actions', 7, '', 'Y', '/admin/user-actions', 'N'),
(20, 4, 'Delete Users Actions', 'Delete Users Actions', 8, '', 'Y', '/admin/user-actions', 'N'),
(21, 1, 'Admin User Logs', 'Admin User Logs', 1, '', 'Y', '/admin/admin-userlogs', 'Y'),
(22, 2, 'Assign Rights', 'Assign Rights', 2, '', 'Y', '/admin/user-type-rights', 'Y'),
(23, 4, 'List Countries', 'List Countries', 9, '', 'Y', '/admin/countries', 'Y'),
(24, 4, 'Add Countries', 'Add Countries', 12, '', 'Y', '/admin/countries', 'N'),
(25, 4, 'Edit Countries', 'Edit Countries', 13, '', 'Y', '/admin/countries', 'N'),
(26, 4, 'Delete Countries', 'Delete Countries', 14, '', 'Y', '/admin/countries', 'N'),
(27, 4, 'List States', 'List States', 10, '', 'Y', '/admin/states', 'Y'),
(28, 4, 'Add States', 'Add States', 15, '', 'Y', '/admin/states', 'N'),
(29, 4, 'Edit States', 'Edit States', 16, '', 'Y', '/admin/states', 'N'),
(30, 4, 'Delete Stales', 'Delete Stales', 17, '', 'Y', '/admin/states', 'N'),
(31, 4, 'List Cities', 'List Cities', 11, '', 'Y', '/admin/cities', 'Y'),
(32, 4, 'Add City', 'Add City', 18, '', 'Y', '', 'N'),
(33, 4, 'Edit City', 'Edit City', 19, '', 'Y', '', 'N'),
(34, 4, 'Delete City', 'Delete City', 20, '', 'Y', '', 'N'),
(35, 1, 'List Admin Users', 'List Admin Users', 2, '', 'Y', '/admin/admin-users', 'Y'),
(36, 1, 'Add Admin Users', 'Add Admin Users', 3, '', 'Y', '/admin/admin-users', 'N'),
(37, 1, 'Edit Admin Users', 'Edit Admin Users', 4, '', 'Y', '', 'N'),
(38, 1, 'Delete Admin Users', 'Delete Admin Users', 5, '', 'Y', '', 'N'),
(53, 6, 'List Portfolio', 'List Portfolio', 1, '', 'Y', '/admin/portfolio', 'Y'),
(54, 6, 'Add Portfolio', 'Add Portfolio', 2, '', 'Y', '', 'N'),
(55, 6, 'Edit Portfolio', 'Edit Portfolio', 3, '', 'Y', '', 'N'),
(56, 6, 'Delete Portfolio', 'Delete Portfolio', 4, '', 'Y', '', 'N'),
(57, 6, 'List Portfolio Category', 'List Portfolio Category', 5, '', 'Y', '/admin/portfoliocategory', 'Y'),
(58, 6, 'Add Portfolio Category', 'Add Portfolio Category', 6, '', 'Y', '', 'N'),
(59, 6, 'Edit Portfolio Category', 'Edit Portfolio Category', 7, '', 'Y', '', 'N'),
(60, 6, 'Delete Portfolio Category', 'Delete Portfolio Category', 8, '', 'Y', '', 'N'),
(61, 7, 'List Packages Category', 'List Packages Category', 1, '', 'Y', '/admin/package-category', 'Y'),
(62, 7, 'Add Packages Category', 'Add Packages Category', 2, '', 'Y', '', 'N'),
(63, 7, 'Edit Packages Category', 'Edit Packages Category', 3, '', 'Y', '', 'N'),
(64, 7, 'Delete Packages Category', 'Delete Packages Category', 4, '', 'Y', '', 'N'),
(65, 7, 'List Packages', 'List Packages', 5, '', 'Y', '/admin/package', 'Y'),
(66, 7, 'Add Package', 'Add Package', 6, '', 'Y', '', 'N'),
(67, 7, 'Edit Package', 'Edit Package', 7, '', 'Y', '', 'N'),
(68, 7, 'Delete Package', 'Delete Package', 8, '', 'Y', '', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(64) NOT NULL,
  `adminuserid` bigint(64) NOT NULL DEFAULT '0',
  `actionid` bigint(64) NOT NULL DEFAULT '0',
  `actionvalue` varchar(30) DEFAULT NULL,
  `remark` longtext,
  `ipaddress` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `adminuserid`, `actionid`, `actionvalue`, `remark`, `ipaddress`, `created_at`, `updated_at`) VALUES
(459, 1, 1, '1', 'Login Admin User', '::1', '2017-09-16 08:15:45', '2017-09-16 08:15:45'),
(460, 1, 14, '1', 'Update Rights ::1', '::1', '2017-09-16 08:16:40', '2017-09-16 08:16:40'),
(461, 1, 15, '5', 'Add Admin Module::5', '::1', '2017-09-16 08:21:16', '2017-09-16 08:21:16'),
(462, 1, 16, '5', 'Edit Admin Module::5', '::1', '2017-09-16 08:21:46', '2017-09-16 08:21:46'),
(463, 1, 15, '6', 'Add Admin Module::6', '::1', '2017-09-16 08:22:06', '2017-09-16 08:22:06'),
(464, 1, 17, '6', 'Delete Admin Module::6', '::1', '2017-09-16 08:22:14', '2017-09-16 08:22:14'),
(465, 1, 8, '11', 'Add User Action::11', '::1', '2017-09-16 08:27:13', '2017-09-16 08:27:13'),
(466, 1, 10, '11', 'Delete User Action::11', '::1', '2017-09-16 08:28:36', '2017-09-16 08:28:36'),
(467, 1, 10, '10', 'Delete User Action::10', '::1', '2017-09-16 08:28:42', '2017-09-16 08:28:42'),
(468, 1, 9, '8', 'Edit User Action::8', '::1', '2017-09-16 08:28:57', '2017-09-16 08:28:57'),
(469, 1, 12, '13', 'Edit Admin Module Page::13', '::1', '2017-09-16 08:35:19', '2017-09-16 08:35:19'),
(470, 1, 12, '31', 'Edit Admin Module Page::31', '::1', '2017-09-16 08:36:38', '2017-09-16 08:36:38'),
(471, 1, 12, '27', 'Edit Admin Module Page::27', '::1', '2017-09-16 08:37:02', '2017-09-16 08:37:02'),
(472, 1, 12, '23', 'Edit Admin Module Page::23', '::1', '2017-09-16 08:37:45', '2017-09-16 08:37:45'),
(473, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-16 08:38:19', '2017-09-16 08:38:19'),
(474, 1, 1, '1', 'Login Admin User', '::1', '2017-09-16 08:38:22', '2017-09-16 08:38:22'),
(475, 1, 12, '1', 'Edit Admin Module Page::1', '::1', '2017-09-16 08:44:25', '2017-09-16 08:44:25'),
(476, 1, 12, '17', 'Edit Admin Module Page::17', '::1', '2017-09-16 08:45:11', '2017-09-16 08:45:11'),
(477, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-16 08:45:26', '2017-09-16 08:45:26'),
(478, 1, 1, '1', 'Login Admin User', '::1', '2017-09-16 08:45:34', '2017-09-16 08:45:34'),
(479, 1, 5, '27', 'Add Admin Action::27', '::1', '2017-09-16 08:46:22', '2017-09-16 08:46:22'),
(480, 1, 6, '27', 'Edit Admin Action::27', '::1', '2017-09-16 08:46:29', '2017-09-16 08:46:29'),
(481, 1, 7, '27', 'Delete Admin Action::27', '::1', '2017-09-16 08:46:34', '2017-09-16 08:46:34'),
(482, 1, 18, '1', 'Add Country::1', '::1', '2017-09-16 08:47:07', '2017-09-16 08:47:07'),
(483, 1, 18, '2', 'Add Country::2', '::1', '2017-09-16 08:47:16', '2017-09-16 08:47:16'),
(484, 1, 19, '1', 'Edit Country::1', '::1', '2017-09-16 08:47:39', '2017-09-16 08:47:39'),
(485, 1, 19, '1', 'Edit Country::1', '::1', '2017-09-16 08:47:47', '2017-09-16 08:47:47'),
(486, 1, 21, '27', 'Add State::27', '::1', '2017-09-16 08:50:23', '2017-09-16 08:50:23'),
(487, 1, 21, '28', 'Add State::28', '::1', '2017-09-16 08:50:44', '2017-09-16 08:50:44'),
(488, 1, 22, '28', 'Edit State::28', '::1', '2017-09-16 08:50:54', '2017-09-16 08:50:54'),
(489, 1, 22, '28', 'Edit State::28', '::1', '2017-09-16 08:53:11', '2017-09-16 08:53:11'),
(490, 1, 21, '29', 'Add State::29', '::1', '2017-09-16 08:53:40', '2017-09-16 08:53:40'),
(491, 1, 21, '30', 'Add State::30', '::1', '2017-09-16 08:55:33', '2017-09-16 08:55:33'),
(492, 1, 23, '30', 'Delete State::30', '::1', '2017-09-16 08:55:39', '2017-09-16 08:55:39'),
(493, 1, 1, '1', 'Login Admin User', '::1', '2017-09-16 13:35:48', '2017-09-16 13:35:48'),
(494, 1, 14, '1', 'Update Rights ::1', '::1', '2017-09-16 13:37:07', '2017-09-16 13:37:07'),
(495, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-16 13:37:14', '2017-09-16 13:37:14'),
(496, 1, 1, '1', 'Login Admin User', '::1', '2017-09-16 13:37:16', '2017-09-16 13:37:16'),
(497, 1, 1, '1', 'Login Admin User', '::1', '2017-09-17 13:53:49', '2017-09-17 13:53:49'),
(498, 1, 8, '2', 'Add User Action::2', '::1', '2017-09-18 06:02:40', '2017-09-18 06:02:40'),
(499, 1, 9, '2', 'Edit User Action::2', '::1', '2017-09-18 06:02:50', '2017-09-18 06:02:50'),
(500, 1, 10, '2', 'Delete User Action::2', '::1', '2017-09-18 06:02:54', '2017-09-18 06:02:54'),
(501, 1, 1, '1', 'Login Admin User', '::1', '2017-09-18 12:53:22', '2017-09-18 12:53:22'),
(502, 1, 1, '1', 'Login Admin User', '::1', '2017-09-19 04:22:01', '2017-09-19 04:22:01'),
(503, 1, 24, '2', 'Add City::2', '::1', '2017-09-19 05:25:55', '2017-09-19 05:25:55'),
(504, 1, 24, '3', 'Add City::3', '::1', '2017-09-19 05:26:55', '2017-09-19 05:26:55'),
(505, 1, 26, '2', 'Delete City::2', '::1', '2017-09-19 05:32:44', '2017-09-19 05:32:44'),
(506, 1, 11, '35', 'Add Admin Models Page ::35', '::1', '2017-09-19 06:03:47', '2017-09-19 06:03:47'),
(507, 1, 14, '1', 'Update Rights ::1', '::1', '2017-09-19 06:04:10', '2017-09-19 06:04:10'),
(508, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-19 06:04:21', '2017-09-19 06:04:21'),
(509, 1, 1, '1', 'Login Admin User', '::1', '2017-09-19 06:04:24', '2017-09-19 06:04:24'),
(510, 1, 11, '36', 'Add Admin Models Page ::36', '::1', '2017-09-19 06:43:52', '2017-09-19 06:43:52'),
(511, 1, 11, '37', 'Add Admin Models Page ::37', '::1', '2017-09-19 06:44:22', '2017-09-19 06:44:22'),
(512, 1, 11, '38', 'Add Admin Models Page ::38', '::1', '2017-09-19 06:44:50', '2017-09-19 06:44:50'),
(513, 1, 14, '1', 'Update Rights ::1', '::1', '2017-09-19 06:45:15', '2017-09-19 06:45:15'),
(514, 1, 14, '1', 'Update Rights ::1', '::1', '2017-09-19 06:45:22', '2017-09-19 06:45:22'),
(515, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-19 06:45:25', '2017-09-19 06:45:25'),
(516, 1, 1, '1', 'Login Admin User', '::1', '2017-09-19 06:45:30', '2017-09-19 06:45:30'),
(517, 1, 6, '29', 'Edit Admin Action::29', '::1', '2017-09-19 10:31:26', '2017-09-19 10:31:26'),
(518, 1, 27, '15', 'Add Admin Users::15', '::1', '2017-09-19 10:31:33', '2017-09-19 10:31:33'),
(519, 1, 27, '16', 'Add Admin Users::16', '::1', '2017-09-19 11:26:12', '2017-09-19 11:26:12'),
(520, 1, 27, '17', 'Add Admin Users::17', '::1', '2017-09-19 11:29:42', '2017-09-19 11:29:42'),
(521, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-19 11:44:14', '2017-09-19 11:44:14'),
(522, 1, 1, '1', 'Login Admin User', '::1', '2017-09-19 11:44:19', '2017-09-19 11:44:19'),
(523, 1, 27, '18', 'Add Admin Users::18', '::1', '2017-09-19 12:03:07', '2017-09-19 12:03:07'),
(524, 1, 27, '19', 'Add Admin Users::19', '::1', '2017-09-19 12:03:50', '2017-09-19 12:03:50'),
(525, 1, 27, '20', 'Add Admin Users::20', '::1', '2017-09-19 12:04:19', '2017-09-19 12:04:19'),
(526, 1, 27, '21', 'Add Admin User::21', '::1', '2017-09-19 12:27:27', '2017-09-19 12:27:27'),
(527, 1, 14, '1', 'Update Rights ::1', '::1', '2017-09-19 12:28:12', '2017-09-19 12:28:12'),
(528, 1, 2, '1', 'Logout Admin User', '::1', '2017-09-19 12:28:15', '2017-09-19 12:28:15'),
(529, 1, 1, '1', 'Login Admin User', '::1', '2017-09-19 12:28:19', '2017-09-19 12:28:19'),
(530, 1, 28, '20', 'Edit Admin User::20', '::1', '2017-09-19 12:30:26', '2017-09-19 12:30:26'),
(531, 1, 29, '21', 'Delete Admin User::21', '::1', '2017-09-19 12:30:33', '2017-09-19 12:30:33'),
(532, 1, 6, '29', 'Edit Admin Action::29', '::1', '2017-09-19 12:39:36', '2017-09-19 12:39:36'),
(533, 1, 6, '29', 'Edit Admin Action::29', '::1', '2017-09-19 12:39:55', '2017-09-19 12:39:55'),
(534, 1, 9, '1', 'Edit User Action::1', '::1', '2017-09-19 12:47:59', '2017-09-19 12:47:59'),
(535, 1, 18, '3', 'Add Country::3', '::1', '2017-09-19 12:49:13', '2017-09-19 12:49:13'),
(536, 1, 19, '3', 'Edit Country::3', '::1', '2017-09-19 12:51:40', '2017-09-19 12:51:40'),
(537, 1, 22, '29', 'Edit State::29', '::1', '2017-09-19 12:56:09', '2017-09-19 12:56:09'),
(538, 1, 25, '3', 'Edit City::3', '::1', '2017-09-19 13:03:39', '2017-09-19 13:03:39'),
(539, 1, 24, '4', 'Add City::4', '::1', '2017-09-19 13:04:18', '2017-09-19 13:04:18'),
(540, 1, 26, '4', 'Delete City::4', '::1', '2017-09-19 13:04:29', '2017-09-19 13:04:29'),
(541, 1, 15, '6', 'Add Admin Module::6', '::1', '2017-09-19 13:05:43', '2017-09-19 13:05:43'),
(542, 1, 16, '6', 'Edit Admin Module::6', '::1', '2017-09-19 13:05:58', '2017-09-19 13:05:58'),
(543, 1, 17, '6', 'Delete Admin Module::6', '::1', '2017-09-19 13:06:12', '2017-09-19 13:06:12'),
(544, 1, 1, '1', 'Login Admin User', '::1', '2017-09-20 04:08:46', '2017-09-20 04:08:46'),
(545, 1, 1, '1', 'Login Admin User', '::1', '2017-09-20 05:02:42', '2017-09-20 05:02:42'),
(546, 1, 1, '1', 'Login Admin User', '::1', '2017-09-20 05:33:22', '2017-09-20 05:33:22'),
(547, 1, 1, '1', 'Login Admin User', '::1', '2017-09-20 09:44:58', '2017-09-20 09:44:58'),
(548, 1, 27, '21', 'Add Admin User::21', '::1', '2017-09-20 09:45:39', '2017-09-20 09:45:39'),
(549, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 10:29:55', '2017-10-13 10:29:55'),
(550, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 10:31:11', '2017-10-13 10:31:11'),
(551, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 10:34:24', '2017-10-13 10:34:24'),
(552, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 10:39:05', '2017-10-13 10:39:05'),
(553, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 11:08:12', '2017-10-13 11:08:12'),
(554, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 11:20:15', '2017-10-13 11:20:15'),
(555, 1, 1, '1', 'Login Admin User', '::1', '2017-10-13 12:41:34', '2017-10-13 12:41:34'),
(556, 1, 5, '30', 'Add Admin Action::30', '::1', '2017-10-13 13:02:48', '2017-10-13 13:02:48'),
(557, 1, 6, '30', 'Edit Admin Action::30', '::1', '2017-10-13 13:02:58', '2017-10-13 13:02:58'),
(558, 1, 1, '1', 'Login Admin User', '::1', '2017-10-16 06:55:09', '2017-10-16 06:55:09'),
(559, 1, 20, '2', 'Delete Country::2', '::1', '2017-10-16 11:34:03', '2017-10-16 11:34:03'),
(560, 1, 1, '1', 'Login Admin User', '::1', '2017-10-17 07:00:32', '2017-10-17 07:00:32'),
(561, 1, 1, '1', 'Login Admin User', '::1', '2017-10-27 07:21:47', '2017-10-27 07:21:47'),
(562, 1, 1, '1', 'Login Admin User', '::1', '2017-10-27 07:28:52', '2017-10-27 07:28:52'),
(563, 1, 15, '6', 'Add Admin Module::6', '::1', '2017-10-27 07:42:37', '2017-10-27 07:42:37'),
(564, 1, 11, '39', 'Add Admin Models Page ::39', '::1', '2017-10-27 07:44:03', '2017-10-27 07:44:03'),
(565, 1, 12, '39', 'Edit Admin Module Page::39', '::1', '2017-10-27 07:45:26', '2017-10-27 07:45:26'),
(566, 1, 11, '40', 'Add Admin Models Page ::40', '::1', '2017-10-27 07:45:56', '2017-10-27 07:45:56'),
(567, 1, 12, '40', 'Edit Admin Module Page::40', '::1', '2017-10-27 07:46:07', '2017-10-27 07:46:07'),
(568, 1, 11, '41', 'Add Admin Models Page ::41', '::1', '2017-10-27 07:46:26', '2017-10-27 07:46:26'),
(569, 1, 12, '41', 'Edit Admin Module Page::41', '::1', '2017-10-27 07:46:35', '2017-10-27 07:46:35'),
(570, 1, 11, '42', 'Add Admin Models Page ::42', '::1', '2017-10-27 07:46:53', '2017-10-27 07:46:53'),
(571, 1, 12, '42', 'Edit Admin Module Page::42', '::1', '2017-10-27 07:47:02', '2017-10-27 07:47:02'),
(572, 1, 5, '41', 'Add Admin Action::41', '::1', '2017-10-27 07:48:37', '2017-10-27 07:48:37'),
(573, 1, 5, '42', 'Add Admin Action::42', '::1', '2017-10-27 07:48:55', '2017-10-27 07:48:55'),
(574, 1, 14, '1', 'Update Rights ::1', '::1', '2017-10-27 07:50:51', '2017-10-27 07:50:51'),
(575, 1, 2, '1', 'Logout Admin User', '::1', '2017-10-27 07:51:02', '2017-10-27 07:51:02'),
(576, 1, 1, '1', 'Login Admin User', '::1', '2017-10-27 07:51:08', '2017-10-27 07:51:08'),
(577, 1, 40, '10', 'Add Country::10', '::1', '2017-10-27 07:55:37', '2017-10-27 07:55:37'),
(578, 1, 40, '11', 'Add Portfolio::11', '::1', '2017-10-27 07:56:01', '2017-10-27 07:56:01'),
(579, 1, 40, '8', 'Add Portfolio::8', '::1', '2017-10-27 07:57:18', '2017-10-27 07:57:18'),
(580, 1, 40, '8', 'Edit Portfolio::8', '::1', '2017-10-27 07:57:42', '2017-10-27 07:57:42'),
(581, 1, 41, '8', 'Edit Portfolio::8', '::1', '2017-10-27 07:58:09', '2017-10-27 07:58:09'),
(582, 1, 42, '4', 'Delete Country::4', '::1', '2017-10-27 08:00:55', '2017-10-27 08:00:55'),
(583, 1, 40, '12', 'Add Portfolio::12', '::1', '2017-10-27 08:01:39', '2017-10-27 08:01:39'),
(584, 1, 42, '12', 'Delete Portfolio::12', '::1', '2017-10-27 08:01:43', '2017-10-27 08:01:43'),
(585, 1, 1, '1', 'Login Admin User', '::1', '2017-10-28 03:46:44', '2017-10-28 03:46:44'),
(586, 1, 11, '57', 'Add Admin Models Page ::57', '::1', '2017-10-28 03:53:23', '2017-10-28 03:53:23'),
(587, 1, 11, '58', 'Add Admin Models Page ::58', '::1', '2017-10-28 03:54:32', '2017-10-28 03:54:32'),
(588, 1, 11, '59', 'Add Admin Models Page ::59', '::1', '2017-10-28 03:55:05', '2017-10-28 03:55:05'),
(589, 1, 11, '60', 'Add Admin Models Page ::60', '::1', '2017-10-28 03:56:00', '2017-10-28 03:56:00'),
(590, 1, 14, '1', 'Update Rights ::1', '::1', '2017-10-28 03:56:53', '2017-10-28 03:56:53'),
(591, 1, 5, '43', 'Add Admin Action::43', '::1', '2017-10-28 03:57:45', '2017-10-28 03:57:45'),
(592, 1, 5, '44', 'Add Admin Action::44', '::1', '2017-10-28 03:58:15', '2017-10-28 03:58:15'),
(593, 1, 5, '45', 'Add Admin Action::45', '::1', '2017-10-28 03:58:41', '2017-10-28 03:58:41'),
(594, 1, 2, '1', 'Logout Admin User', '::1', '2017-10-28 04:05:53', '2017-10-28 04:05:53'),
(595, 1, 1, '1', 'Login Admin User', '::1', '2017-10-28 04:05:59', '2017-10-28 04:05:59'),
(596, 1, 44, '7', 'Edit Portfolio Categories::7', '::1', '2017-10-28 04:15:14', '2017-10-28 04:15:14'),
(597, 1, 44, '7', 'Edit Portfolio Categories::7', '::1', '2017-10-28 04:15:26', '2017-10-28 04:15:26'),
(598, 1, 44, '7', 'Edit Portfolio Categories::7', '::1', '2017-10-28 04:15:31', '2017-10-28 04:15:31'),
(599, 1, 43, '8', 'Add Portfolio Categories::8', '::1', '2017-10-28 04:16:58', '2017-10-28 04:16:58'),
(600, 1, 45, '8', 'Delete Portfolio Categories::8', '::1', '2017-10-28 04:17:15', '2017-10-28 04:17:15'),
(601, 1, 43, '9', 'Add Portfolio Categories::9', '::1', '2017-10-28 04:17:26', '2017-10-28 04:17:26'),
(602, 1, 1, '1', 'Login Admin User', '::1', '2017-10-28 10:15:34', '2017-10-28 10:15:34'),
(603, 1, 43, '1', 'Add Portfolio Categories::1', '::1', '2017-10-28 10:57:41', '2017-10-28 10:57:41'),
(604, 1, 44, '1', 'Edit Package Category::1', '::1', '2017-10-28 10:58:57', '2017-10-28 10:58:57'),
(605, 1, 15, '7', 'Add Admin Module::7', '::1', '2017-10-28 11:03:45', '2017-10-28 11:03:45'),
(606, 1, 11, '61', 'Add Admin Models Page ::61', '::1', '2017-10-28 11:05:07', '2017-10-28 11:05:07'),
(607, 1, 11, '62', 'Add Admin Models Page ::62', '::1', '2017-10-28 11:06:44', '2017-10-28 11:06:44'),
(608, 1, 11, '63', 'Add Admin Models Page ::63', '::1', '2017-10-28 11:07:09', '2017-10-28 11:07:09'),
(609, 1, 11, '64', 'Add Admin Models Page ::64', '::1', '2017-10-28 11:07:30', '2017-10-28 11:07:30'),
(610, 1, 1, '1', 'Login Admin User', '::1', '2017-10-28 11:09:36', '2017-10-28 11:09:36'),
(611, 1, 5, '46', 'Add Admin Action::46', '::1', '2017-10-28 11:10:09', '2017-10-28 11:10:09'),
(612, 1, 5, '47', 'Add Admin Action::47', '::1', '2017-10-28 11:10:19', '2017-10-28 11:10:19'),
(613, 1, 5, '48', 'Add Admin Action::48', '::1', '2017-10-28 11:10:35', '2017-10-28 11:10:35'),
(614, 1, 14, '1', 'Update Rights ::1', '::1', '2017-10-28 11:11:01', '2017-10-28 11:11:01'),
(615, 1, 2, '1', 'Logout Admin User', '::1', '2017-10-28 11:11:09', '2017-10-28 11:11:09'),
(616, 1, 1, '1', 'Login Admin User', '::1', '2017-10-28 11:11:14', '2017-10-28 11:11:14'),
(617, 1, 46, '2', 'Add Package Category::2', '::1', '2017-10-28 11:13:04', '2017-10-28 11:13:04'),
(618, 1, 47, '2', 'Edit Package Category::2', '::1', '2017-10-28 11:13:34', '2017-10-28 11:13:34'),
(619, 1, 48, '2', 'Delete Package Category::2', '::1', '2017-10-28 11:14:00', '2017-10-28 11:14:00'),
(620, 1, 46, '3', 'Add Package Category::3', '::1', '2017-10-28 11:14:06', '2017-10-28 11:14:06'),
(621, 1, 48, '1', 'Delete Package Category::1', '::1', '2017-10-28 11:14:19', '2017-10-28 11:14:19'),
(622, 1, 46, '4', 'Add Package Category::4', '::1', '2017-10-28 11:14:27', '2017-10-28 11:14:27'),
(623, 1, 1, '1', 'Login Admin User', '::1', '2017-10-30 04:09:35', '2017-10-30 04:09:35'),
(624, 1, 1, '1', 'Login Admin User', '::1', '2017-10-30 12:54:07', '2017-10-30 12:54:07'),
(625, 1, 1, '1', 'Login Admin User', '::1', '2017-11-16 09:20:34', '2017-11-16 09:20:34'),
(626, 1, 46, '5', 'Add Package Category::5', '::1', '2017-11-16 09:27:47', '2017-11-16 09:27:47'),
(627, 1, 47, '5', 'Edit Package Category::5', '::1', '2017-11-16 09:27:54', '2017-11-16 09:27:54'),
(628, 1, 48, '5', 'Delete Package Category::5', '::1', '2017-11-16 09:27:58', '2017-11-16 09:27:58'),
(629, 1, 11, '65', 'Add Admin Models Page ::65', '::1', '2017-11-16 09:34:04', '2017-11-16 09:34:04'),
(630, 1, 14, '1', 'Update Rights ::1', '::1', '2017-11-16 09:34:21', '2017-11-16 09:34:21'),
(631, 1, 2, '1', 'Logout Admin User', '::1', '2017-11-16 09:34:27', '2017-11-16 09:34:27'),
(632, 1, 1, '1', 'Login Admin User', '::1', '2017-11-16 09:34:33', '2017-11-16 09:34:33'),
(633, 1, 41, '1', 'Edit Package::1', '::1', '2017-11-16 10:17:27', '2017-11-16 10:17:27'),
(634, 1, 41, '1', 'Edit Package::1', '::1', '2017-11-16 10:18:05', '2017-11-16 10:18:05'),
(635, 1, 5, '49', 'Add Admin Action::49', '::1', '2017-11-16 10:25:30', '2017-11-16 10:25:30'),
(636, 1, 5, '50', 'Add Admin Action::50', '::1', '2017-11-16 10:25:49', '2017-11-16 10:25:49'),
(637, 1, 5, '51', 'Add Admin Action::51', '::1', '2017-11-16 10:25:50', '2017-11-16 10:25:50'),
(638, 1, 6, '51', 'Edit Admin Action::51', '::1', '2017-11-16 10:26:08', '2017-11-16 10:26:08'),
(639, 1, 11, '66', 'Add Admin Models Page ::66', '::1', '2017-11-16 10:29:11', '2017-11-16 10:29:11'),
(640, 1, 11, '67', 'Add Admin Models Page ::67', '::1', '2017-11-16 10:29:50', '2017-11-16 10:29:50'),
(641, 1, 11, '68', 'Add Admin Models Page ::68', '::1', '2017-11-16 10:30:13', '2017-11-16 10:30:13'),
(642, 1, 14, '1', 'Update Rights ::1', '::1', '2017-11-16 10:30:29', '2017-11-16 10:30:29'),
(643, 1, 2, '1', 'Logout Admin User', '::1', '2017-11-16 10:30:40', '2017-11-16 10:30:40'),
(644, 1, 1, '1', 'Login Admin User', '::1', '2017-11-16 10:30:45', '2017-11-16 10:30:45'),
(645, 1, 49, '2', 'Add Package::2', '::1', '2017-11-16 10:37:03', '2017-11-16 10:37:03'),
(646, 1, 50, '2', 'Edit Package::2', '::1', '2017-11-16 10:37:14', '2017-11-16 10:37:14'),
(647, 1, 49, '3', 'Add Package::3', '::1', '2017-11-16 10:44:50', '2017-11-16 10:44:50'),
(648, 1, 50, '3', 'Edit Package::3', '::1', '2017-11-16 10:45:33', '2017-11-16 10:45:33'),
(649, 1, 50, '3', 'Edit Package::3', '::1', '2017-11-16 11:01:04', '2017-11-16 11:01:04'),
(650, 1, 50, '3', 'Edit Package::3', '::1', '2017-11-16 11:01:24', '2017-11-16 11:01:24');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `user_type_id`, `name`, `email`, `password`, `status`, `last_login_at`, `remember_token`, `slug`, `created_at`, `updated_at`, `phone`) VALUES
(1, 1, 'Admin', 'admin@gmail.com', '$2y$10$8HiNGIdnO18q7KVAsx6vCONxj4e9WCiNdGg0xwVIxZaQa3C9VbxfK', 1, '2017-11-16 05:00:45', 'OzT3aUYAFMQgH2wFiEFAW7674unaV0hUetOEX3A8xk03KrUdR6sFNnFOW8VI', NULL, '2016-12-11 10:31:25', '2017-11-16 05:00:45', '1234567890'),
(21, 1, 'Test', 'test@gmail.com', '$2y$10$xxcoNZUD43/cpJ6XyRS8O.2jwPexfKHEUTdYqtdJwDZvursCBdWfW', 1, '2017-09-20 09:45:39', NULL, NULL, '2017-09-20 04:15:38', '2017-09-20 04:15:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_rights`
--

CREATE TABLE `admin_user_rights` (
  `user_type_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_user_rights`
--

INSERT INTO `admin_user_rights` (`user_type_id`, `page_id`) VALUES
(1, 21),
(1, 35),
(1, 36),
(1, 37),
(1, 38),
(1, 53),
(1, 54),
(1, 55),
(1, 56),
(1, 57),
(1, 58),
(1, 59),
(1, 60),
(1, 61),
(1, 62),
(1, 63),
(1, 64),
(1, 65),
(1, 66),
(1, 67),
(1, 68),
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 23),
(1, 27),
(1, 31),
(1, 24),
(1, 25),
(1, 26),
(1, 28),
(1, 29),
(1, 30),
(1, 32),
(1, 33),
(1, 34),
(1, 5),
(1, 9),
(1, 22),
(1, 6),
(1, 7),
(1, 8),
(1, 10),
(1, 11),
(1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_types`
--

CREATE TABLE `admin_user_types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user_types`
--

INSERT INTO `admin_user_types` (`id`, `title`) VALUES
(1, 'Super Admin'),
(2, 'Admin'),
(3, 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(10) UNSIGNED NOT NULL,
  `state_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `title`, `created_at`, `updated_at`) VALUES
(1, 27, 'Rajkot', '2017-09-17 18:30:00', '2017-09-17 18:30:00'),
(3, 27, 'ahmedabad', '2017-09-18 23:56:55', '2017-09-19 07:33:39');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'India', '2017-09-16 03:17:07', '2017-09-16 03:17:45'),
(2, 'USA', '2017-09-16 03:17:16', '2017-09-16 03:17:16'),
(3, 'Pakistan', '2017-09-19 07:19:13', '2017-09-19 07:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `email_sent_logs`
--

CREATE TABLE `email_sent_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cc_emails` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bcc_emails` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `from_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_subject` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_body` text COLLATE utf8_unicode_ci,
  `mail_response` text COLLATE utf8_unicode_ci,
  `status` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'sent' COMMENT '0 = fail 1 = success 2 = pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `email_sent_logs`
--

INSERT INTO `email_sent_logs` (`id`, `to_email`, `cc_emails`, `bcc_emails`, `from_email`, `email_subject`, `email_body`, `mail_response`, `status`, `created_at`, `updated_at`) VALUES
(1, 'phpdots1@gmail.com', NULL, NULL, 'rinkal.shiroya@phpdots.com', 'Hiiiiii', '<p>Hi, All</p>\r\n', NULL, 'sent', '2017-10-16 02:00:24', '2017-10-16 02:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2017_08_20_115043_create_admin_actions_table', 1),
(7, '2017_08_20_115043_create_admin_group_pages_table', 1),
(8, '2017_08_20_115043_create_admin_groups_table', 1),
(9, '2017_08_20_115043_create_admin_logs_table', 1),
(10, '2017_08_20_115043_create_admin_user_rights_table', 1),
(11, '2017_08_20_115043_create_admin_user_types_table', 1),
(12, '2017_08_20_115043_create_admin_users_table', 1),
(13, '2017_08_20_115043_create_password_resets_table', 1),
(14, '2017_08_20_115043_create_users_table', 1),
(15, '2017_08_20_115046_add_foreign_keys_to_admin_group_pages_table', 1),
(16, '2017_08_20_115046_add_foreign_keys_to_admin_groups_table', 1),
(17, '2017_08_20_115046_add_foreign_keys_to_admin_user_rights_table', 1),
(18, '2017_08_20_125645_alter_admin_users', 2),
(19, '2017_09_14_102319_Create_Countries_table', 3),
(20, '2017_09_14_102358_Create_States_table', 3),
(21, '2017_09_14_102513_Create_Cities_table', 3),
(22, '2017_09_14_102916_add_foreign_key_to__Cities_table', 3),
(23, '2017_09_14_102939_add_foreign_key_to__States_table', 3),
(24, '2017_09_28_061603_Create_user_types_table', 4),
(25, '2017_09_28_072935_Create_vendor_categories_table', 4),
(26, '2017_09_28_091457_Create_vendors_table', 4),
(27, '2017_09_28_100142_Alert_vendors_table', 4),
(32, '2017_10_16_063508_create_email_sent_log_table', 6),
(35, '2017_10_16_094505_create_portfolios_table', 7),
(36, '2017_10_16_094546_create_portfolio_categories_table', 7),
(37, '2017_10_16_094836_alert_portfolios_table', 8),
(38, '2017_10_28_104130_create_package_categories_tabl', 9),
(39, '2017_10_28_112134_create_packages_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) UNSIGNED NOT NULL,
  `packages_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `packages_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(2, 4, 'Mehndi', '1e6ae4ada992769567b71815f124fac5.jpg', '2017-11-16 05:07:03', '2017-11-16 05:07:14'),
(3, 3, 'Photographers', '5c642ec854a6a92a56d7ebf0b9648eea.jpg', '2017-11-16 05:14:50', '2017-11-16 05:31:24');

-- --------------------------------------------------------

--
-- Table structure for table `package_categories`
--

CREATE TABLE `package_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `package_categories`
--

INSERT INTO `package_categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(3, 'Photographers Package', '2017-10-28 05:44:06', '2017-10-28 05:44:06'),
(4, 'Mehndi Artists', '2017-10-28 05:44:27', '2017-10-28 05:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE `portfolios` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `category_id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(3, 1, 'Mehndi', '6f031b3c11385681373acec2e7994669.jpg', '2017-10-16 05:20:30', '2017-10-16 06:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `portfolio_categories`
--

CREATE TABLE `portfolio_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `portfolio_categories`
--

INSERT INTO `portfolio_categories` (`id`, `title`, `created_at`, `updated_at`) VALUES
(1, 'Wedding Venues', '2017-10-15 18:30:00', '2017-10-15 18:30:00'),
(2, 'Mehndi Artists', '2017-10-15 18:30:00', '2017-10-15 18:30:00'),
(3, 'Bridal Designers', '2017-10-16 06:26:31', '2017-10-16 06:26:31'),
(4, 'Invitations', '2017-10-16 06:26:57', '2017-10-16 06:29:43'),
(6, 'Decorators', '2017-10-16 06:32:50', '2017-10-16 06:32:50'),
(7, 'Photographers', '2017-10-27 22:38:27', '2017-10-27 22:45:31'),
(9, 'Bridal Makeup Artists', '2017-10-27 22:47:26', '2017-10-27 22:47:26');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` int(10) UNSIGNED NOT NULL,
  `country_id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `title`, `created_at`, `updated_at`) VALUES
(27, 1, 'Gujarat', '2017-09-16 03:20:23', '2017-09-16 03:20:23'),
(28, 1, 'Rajasthan', '2017-09-16 03:20:43', '2017-09-16 03:20:43'),
(29, 2, 'Alaska', '2017-09-16 03:23:40', '2017-09-16 03:23:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'pending',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `firstname`, `lastname`, `address`, `city`, `state`, `country`, `zipcode`, `mobile`, `last_login_at`, `status`, `email`, `password`, `remember_token`, `slug`, `created_at`, `updated_at`) VALUES
(1, NULL, 'admin11', 'admin2', NULL, NULL, NULL, NULL, NULL, NULL, '2017-09-20 08:50:42', 'pending', 'admin@gmail.com', '$2y$10$gvyJDAfTZSIdLYDbfD0TPOnqnmC8RXRwx.I0Y2LwBlfZznz/xOr/y', NULL, 'admin-admin', '2017-09-20 00:51:50', '2017-09-20 03:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `user_actions`
--

CREATE TABLE `user_actions` (
  `id` bigint(64) NOT NULL,
  `description` varchar(100) NOT NULL,
  `remark` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_actions`
--

INSERT INTO `user_actions` (`id`, `description`, `remark`) VALUES
(1, 'Login', 'Frontend User Login');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type_id` int(10) UNSIGNED DEFAULT NULL,
  `vendor_category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city_id` int(10) UNSIGNED DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendor_categories`
--

CREATE TABLE `vendor_categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_actions`
--
ALTER TABLE `admin_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_groups`
--
ALTER TABLE `admin_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `admin_group_pages`
--
ALTER TABLE `admin_group_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_group_id` (`admin_group_id`);

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_email_unique` (`email`),
  ADD KEY `admin_user_type_fk_1` (`user_type_id`);

--
-- Indexes for table `admin_user_rights`
--
ALTER TABLE `admin_user_rights`
  ADD KEY `page_id` (`page_id`),
  ADD KEY `user_type_id` (`user_type_id`);

--
-- Indexes for table `admin_user_types`
--
ALTER TABLE `admin_user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_sent_logs`
--
ALTER TABLE `email_sent_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_categories`
--
ALTER TABLE `package_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `portfolios_category_id_foreign` (`category_id`);

--
-- Indexes for table `portfolio_categories`
--
ALTER TABLE `portfolio_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_actions`
--
ALTER TABLE `user_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendors_user_type_id_foreign` (`user_type_id`),
  ADD KEY `vendors_vendor_category_id_foreign` (`vendor_category_id`);

--
-- Indexes for table `vendor_categories`
--
ALTER TABLE `vendor_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_actions`
--
ALTER TABLE `admin_actions`
  MODIFY `id` bigint(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `admin_groups`
--
ALTER TABLE `admin_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_group_pages`
--
ALTER TABLE `admin_group_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=651;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `admin_user_types`
--
ALTER TABLE `admin_user_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `email_sent_logs`
--
ALTER TABLE `email_sent_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package_categories`
--
ALTER TABLE `package_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `portfolios`
--
ALTER TABLE `portfolios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `portfolio_categories`
--
ALTER TABLE `portfolio_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_actions`
--
ALTER TABLE `user_actions`
  MODIFY `id` bigint(64) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendor_categories`
--
ALTER TABLE `vendor_categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_groups`
--
ALTER TABLE `admin_groups`
  ADD CONSTRAINT `admin_groups_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `admin_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_group_pages`
--
ALTER TABLE `admin_group_pages`
  ADD CONSTRAINT `admin_group_pages_ibfk_1` FOREIGN KEY (`admin_group_id`) REFERENCES `admin_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `admin_user_type_fk_1` FOREIGN KEY (`user_type_id`) REFERENCES `admin_user_types` (`id`);

--
-- Constraints for table `admin_user_rights`
--
ALTER TABLE `admin_user_rights`
  ADD CONSTRAINT `admin_user_rights_ibfk_1` FOREIGN KEY (`page_id`) REFERENCES `admin_group_pages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `admin_user_rights_ibfk_2` FOREIGN KEY (`user_type_id`) REFERENCES `admin_user_types` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `portfolio_categories` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);

--
-- Constraints for table `vendors`
--
ALTER TABLE `vendors`
  ADD CONSTRAINT `vendors_user_type_id_foreign` FOREIGN KEY (`user_type_id`) REFERENCES `user_types` (`id`),
  ADD CONSTRAINT `vendors_vendor_category_id_foreign` FOREIGN KEY (`vendor_category_id`) REFERENCES `vendor_categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
