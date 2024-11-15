-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2024 at 04:45 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myhmsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `log_id` int(11) NOT NULL,
  `activity` varchar(800) NOT NULL,
  `pid` int(11) NOT NULL,
  `doc_id` int(11) NOT NULL,
  `activity_iv` varchar(800) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `admin` varchar(30) NOT NULL,
  `login` varchar(255) NOT NULL,
  `login_iv` varchar(255) NOT NULL,
  `logout` varchar(255) NOT NULL,
  `logout_iv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`log_id`, `activity`, `pid`, `doc_id`, `activity_iv`, `created_on`, `admin`, `login`, `login_iv`, `logout`, `logout_iv`) VALUES
(5, 'BQFZu1iT/PYHd6d95U3TcY+S7FpwWrh7mAJqs55tlUBaGPGXyOXa75gX2HR/jRPfzt3ag+0dCTlEARAkEY4Nxp0myXli5ir83gDwgFHkNL8=', 19, 11, '97AgJSbQBAnPGkQDyd/8mw==', '2024-11-11 21:48:47', '', '', '', '', ''),
(7, '9ThydHOyPpFclbn8eBmxuqSaN5HDRWuPYZgK+9wLnsshCGIB9mzBk+q+o4M5GI9yML1HzbmA4FthrsyzUujOJg==', 0, 0, 'PVD3a32qoxPzIro7MzFZSA==', '2024-11-11 22:07:20', 'admin', '', '', '', ''),
(9, 'YiBYVPreJymqHY6b40GH5WCeutK0byQbojDlTT3Q+/Cqa3cLr/hQxluPMkR4qL22qYf+Lx6WgUU/DKGyZyQvo9JRuKmsJ/su0JHF8m+K0jA=', 19, 11, 'W2durllrcRuFQb486iDMFQ==', '2024-11-11 22:18:13', '', '', '', '', ''),
(13, '8SeHn2kwWK18BxZVmWBS3g==', 0, 0, 'cHsMFyUOKV2Vn1rNrQhKmA==', '2024-11-11 22:58:25', 'admin', 'L28nM2tmK/4ZfaO19jN9Stc0mRAlcPcvOryl0VUWAZ4=', 'UnHf4xUsguGd3PJb3kzgVg==', '5XcZ86MaiD8O5fFiJEOtjwktvxX9SNM/I2P1KnPFjiM=', 'xes70KmbqyvKkzreQvz1/Q=='),
(14, 'AVMPzOLv4jN8fqQiQIxOAQ==', 0, 0, '9vJdyInW41H/yWadJc743Q==', '2024-11-11 23:03:52', 'admin', 'KrgAUz6LM31gRcaYWUjFRfGTORHv1PMC0UeoaKuukuU=', 'v3O2wHjfvyW7XUehHx+SuQ==', 'q1UaptZJztiCNRMl4KZ+Z/6NubYWgCCtknOFM03GX+o=', '3jzKynWuAwLBCSNp6BnCfQ=='),
(16, 'NGqHWqoh4CM9zFYXigZxEvxC5dTI3shw871aSgMkutI=', 19, 0, '6u43/y8YyxCQBQr8In89Aw==', '2024-11-11 23:05:15', '', 'lGcN/aRCvPZHo2Xx1SphsC0oomdEHyv8gQC/PAXPZ/s=', 'fQG9QUykG5/Qcc+KVQvXog==', '8nQkaSwgI9dvS0X1BoZc9f+pLH0go8E32y4hQqjcTbY=', 'Oj/RTsOxilCuOoi0nO/+3A=='),
(17, 'OAOcfSJDTi0Z84E4V0My0DAI3w0Py5sRHFCTrDHxcNw=', 19, 0, '4en4tkXPkosI5jRDRtaanQ==', '2024-11-11 23:05:36', '', 'Wwgb7id7eZEEhQ/Akh2GO09bwa9Deoq6IMLT6cWWWcY=', 'dV+H8Igknet6CXyMbCooUw==', 'KWfma5C+ZTcYiVj4klt2YmqnfkcfCVZ8kxDSUx+Jk3s=', 'k1dawNjzeP9tLU/BQL1BZQ=='),
(18, '7lR41+plbgCWymkBLHReZe/rpaEW+Q5je/y3Gn5R54s=', 0, 11, 'O5AnCX17kQXRY0DcylMwug==', '2024-11-11 23:05:51', '', 'kR5XCuoe7qMJYiDkNQY49Jts670OCz6Nv06fikkAs0c=', 'k0kKGaYGvFMRRScyWOSApQ==', 'P1yYbRgHvIIYyVs4PaV9/pVPz3eq4CKz3UAF6WLGJdU=', '10YPy1grDtYtqKz/t0JKjQ=='),
(19, 'HXeMaBZ0ygTSp0Zn9RxOoQ==', 0, 0, '3PEfBFplcQbbnx3fSflEbQ==', '2024-11-11 23:06:06', 'admin', '7wG23QNauzKdQG/VcM0KA3KwLS6dMyItQbPkSyyGVEM=', 'uDabNkRsF9F+D1J5eKaPbA==', '5Wkp0lW9PMdSpyB5peA8eKzPJJwUHbfpKt65sJJtLI0=', 'Y16YKOmqBPHa/EVGC9527A=='),
(20, 'WHx0nrYoytfRHmvsnGDKMw==', 0, 0, 'eIFYSuj8qTHBfqM6F4u0Mw==', '2024-11-11 23:16:58', 'admin', 'YENka7TEavh7Y1ez5xiYNHOQJQ6sdGJarGwd+E4/0E4=', 'foIeI1Lj1RbFsdIXg8xYNw==', 'oGcXhOIr6kLeku1B0urnA8qbnhcPMs0Gk30XaWzHBWs=', 'qnX8JxnCtlyTibLwSYMN5w=='),
(21, 'Uny7lOjhC6GpDC8/gc+n0PGeQjUamsNylPy14OH7K90=', 19, 0, 'h8rNTSp1q3Fc84Hjp6Ai0w==', '2024-11-11 23:19:54', '', 'p4ZCWlUCBcFqsyj6yjoDvKbCeXSK69jDIwuSBss/5Ns=', '6mdkuzeyMWjVHyPTZzkjgw==', 'HsZOjMjsiHz6NMkCZBRwNZ5m1kXxnfHK4ftJ2QHUyX0=', 'GXVc3hfamsWs3j5ZKqI+pA=='),
(22, 'BsUSuiE8v4tonM7ElCPVAw==', 0, 0, 'UOKJyhn2o4rR8mRM7nPjMw==', '2024-11-11 23:20:07', 'admin', 'yNj02PZUlcxAI0oaBV8H5m6C1o2DvMsD5Ed/Q5bfkZM=', 'ujZrRDbQTog0twENAZA7gQ==', '5Sabeu9tZNttqf9GwvDktAoIWrE9KSw0hNzrU0Frl2M=', '4kNGXiYtL9P2odrx/0SqkA=='),
(26, '6gBb6QoKYEqBi9exjSH5ww==', 0, 0, 'f1wZiKfWAzTiTJtcm5UJ6w==', '2024-11-12 17:03:59', 'admin', 'D52PgH+zPog7IYPxaBY6uB66VHenTjQFJWNHB3H0RkE=', '8JvzrCQAQGxEkQVduiKWCA==', '2QoZeF4SLlSW9vJ+bAZyjEGZhoEY2pJ5x+CGs/0LwMk=', 'o9sy1hVPPMoz5p0hWxrULA=='),
(27, '4HiqPE/yNsJWkdmBJyZmikq3DxXNAfLHUcQDpczo3u8=', 19, 0, 'EUHP6tK7R2JSihQVwYIVzw==', '2024-11-12 17:11:56', '', 'b9MefaD8oITpBE6KwwjeQd2kxBHSBhyJjGbA4BsqcpU=', 'HVhLOFaDvUJomp8OQwHBNg==', 'cq7aga6sfytoZ/DeO6dscSSohpO6Wp4HxnwoQx8HW0g=', 'UnpaXLnRvsKlGjpiTlN4YA=='),
(28, 'EYrWz0y0VhPBgsZsz3GvvA==', 0, 0, 'Fe9YVug3poJ57BUyHs4gXw==', '2024-11-12 17:12:13', 'admin', 's/r2Fo9fItUdbubPod/HbaCz2qdKUVRdQmuQ4vMxxNs=', 'nTw4sAxwch0f8jI9L7Zx7Q==', 'p43DVgxAHdy1cxvhA6Op2BAuK0w/0gf30JJJdI/z0eY=', 'llJvbklVqxTiJtujLS1nbQ=='),
(29, 'GJpInOcOfzJNpS1cGDBpmw==', 0, 0, '/FemlF5WclakpK4BKU9lYg==', '2024-11-12 17:33:51', 'admin', 'MBHKF1o93qACsdB8Bn2H9jUakC8QuIx9LPRiOcVqf40=', 'fBsFdwjTYgE7VMn31aOT4A==', 'aPi3eBZJMIAahTe+IvDfylorcWAlD7kM0HNajnHnlGM=', 'WqYqmStQgHdFmXRpMJdz9w=='),
(30, 'P/DtJoj3VFbCCLoBPHoZdA==', 0, 0, '2zlNSLzTQVfjo693mMlJwA==', '2024-11-12 17:40:31', 'admin', 'woFrK30bmWVRxslkIyJDoGOnhH9eVB0+SlRs7xcuVdA=', 'it4A8yRiywVR7+sLdfIGfA==', 'xd9AN9uaKaIAxLneFa4dooivgZQdnz9VE8YOO6MLGAw=', '9QWIUSCEKCHAm+CdZca8Jg=='),
(33, 'ZuK5EwzUyn6Db6hQJqxG2+t+ujiepr+GS4G7nRqA+aPWXXGyQ4t3w4TzvpFSsudIbx0XEoE67OSozbegTKrUph4YZWS0HA/l7YcK/6JlHRU=', 20, 10, 'lrX50lBImPQiNaarLAgYMg==', '2024-11-12 18:20:18', '', '', '', 'uxUxplnWojFdpAg2tpf24uh8TwnA6cfB+E3bVIhTuhY=', 'rxOHi7v0rstDmsji2/6rLA=='),
(34, 'uEy7HJh8Xy8KQSJDICHd2ZzDT4zD5yz8ASj/J/XZp38=', 19, 0, 'tZGf4eoE7UvfNCtnHf1SjQ==', '2024-11-12 18:27:46', '', 'U3VKKtfOvWOWF2GlX6Pih+gWheMjjkPU9rC6l2QkZi4=', 'SpiWjLq7STyCOHMqNAATKg==', '', ''),
(35, '87DDKXiXL2kGG4GsX/LrZ3Wz5rbnsp629nluBfzuHVWwEuQpnNTo4Kes0U8u1r4cDtklTtU7z3umJm0enUZM+dex+eMfWc+oL8+ujD0itPA=', 19, 12, 'n/ikDEOVEV+k19N66pKOUg==', '2024-11-12 18:28:22', '', '', '', 'dhJvPZZ7YQnV/Ac+D8XrMl9knw3BGHsRqJV+avCZ5A4=', 'cyXj/V0lY8j0z7Y8lGRvxQ=='),
(36, 'C6jnBVFCBRUvRi4XcOuaWIp0/1BC+hWVPDZK159Vk0o=', 19, 0, 'z3izxjwh69t80PJGAD9elw==', '2024-11-12 18:37:09', '', 'YH8d+CL0azQsiGn0KdZJ3/RbGMFKd9fCLTSnYoOrIfw=', 'S7PIs6pG+72wOgaYs8sudQ==', 'C6zmYTxWlM8b/aWuOM5Hj9sf/dp9v12f9wn69xCSK3w=', 'XihK3Iw6xRBOP+B5PrsCmQ=='),
(37, 'ULTfAQ11caAcg7qERidFmIXM7EHclohUlBEkmZuV0Zo=', 19, 0, 'oA+Fdc4w9A0BkiHPpQIQ5g==', '2024-11-12 18:38:26', '', 'y+m+Jf8zdiq+TeJWRhbJkTkCIweAsP1XPDEE7hcOU/Y=', 'U8qkxuuIIw55fsVgj7Uo1g==', 'jHAbIRo20yNd3xeBZskBUcJeeTb4Hc0ROXZWsghUy/s=', '82+5Ok3OyJC2dgeEJS6+Iw=='),
(38, 'Fzb7mGZQhhiHGhHPcLenP8onBcQEMR/LCYLGaI2p3+o=', 19, 0, 'k69jtdVqzePuyMdFNCGRog==', '2024-11-12 18:39:41', '', 'wtXFvXM4s5iTwnXnlj/qT2OG4QT6GQERV22oehMBnAg=', 'Wa3DRZMlEMDkUXfcl2btbA==', '', ''),
(39, 'miSCtNviwhBtniAYVj7SuVpe/ZWwp9xHz1h7B3udM+aGzrkWBCnks58EEw448qEvc97QAnumqdxVSyzsViV5J0LX6hHyjLk4OoNC0AHuVe0=', 19, 12, 'q98Jxe5WuB7mK1ZeIO1cHg==', '2024-11-12 18:39:49', '', '', '', 'dUSE8PzG73M3waRc1RDCkITkMFKo7f472s00gXIDEmk=', 'SogXXnmc2e38dymTVgepsA=='),
(40, 'hDPZWEDn+OZyGL1CNA5nIRo9Hs6QkUZJ8oVK7dPGRO4=', 19, 0, 'KbmUOixARGLqL/bKLdRzuA==', '2024-11-12 18:44:41', '', 'sTYTFHjDvfydV/JhMtC91Mk75vywZTG6085xhcwMCUI=', 'ik42lqqZVXiiAxozZIP4Gw==', '', ''),
(42, 'fljiwInZEbVcbvePgpD9gA==', 0, 0, 'a7wCblF1Ka4EhiwD0t6ubA==', '2024-11-12 18:48:54', 'admin', 'PrSOtgS0y9gse54kH8onpGg6OWoQb6xZzojqsGo8Pgs=', 'WcWWj7zMBmhkTEFEDZOwgA==', 'taVdqq2LO97tPD4IsOLoQvOANV2k4jIFx1udVtKnIJs=', 'MksZ/ShO6VBiKML/E1E/WA=='),
(43, 'R46fVzH43H9UeLMcNAjmEw==', 0, 0, 'sJ0wLAsEK53i7wPGQvJZzg==', '2024-11-12 19:19:35', 'admin', 'oPVQS3oxqedm6nUPVpKstbv0dtqu03s7OiFvb90N3RM=', 'jpvbK4baBEexvHUxRsx02w==', 'S4CSrDRyu7i6EAUl7l8U8hHbuL+k2Xbr9y1YLfwX9e4=', 'Mvc7DMI6roItLIs36QxQtA=='),
(44, 'VwiTbYTT4N7OfQD+bFxjhQ==', 0, 0, '00FlrTIDmAurPEjXLmszSQ==', '2024-11-12 20:17:30', 'admin', '0l5Hihxek6QON+Oj4smjE3leT7v5+p/OflsE17VkFgI=', 'oU/2h6/gf6k3hcrrUW831g==', 'akwYxuv4+rhFH+uY4xh+Qs3NyZKcxnbSRW07BtJPUQM=', '2f/CxxLc5TpUPUxBYoxU8A=='),
(45, 'QNLXVkTMRN/z+BoTInQkbg==', 0, 0, 'KbUiZsQW/ZDV8czsbtwnTQ==', '2024-11-12 20:25:20', 'admin', 'R6mYjv17F5aVr1XFZ030eBnVhPyb3FNfsgoZUm+Qpks=', 'PrFQs1PbZTnKyep+Qw+FkQ==', 'eKa1RPyMNIIFbhHMs7rInq5SHXxcXDC6fGug0CNajvM=', 'NfSlVqJjaI+vMhZxeJxKwg=='),
(46, '2laLx/VhTpOpD4tYIKDang==', 0, 0, '2pFvvaKpzj+rfYfB81EVTw==', '2024-11-12 20:27:32', 'admin', 'vU0sJThgddwRtWiPPLu7ft7ddNfEm+B3td7KQ0NDYqY=', 'k94IEZcz2M7l0trkHAG89g==', 'ls6MA7k5dIIIjZzgujjrq5b+1UeUh3OL+GWLtD+AnaU=', 'dVLUTwgtleA5FE32HEbHfw=='),
(47, 'jvqS7M2HSAzTH8f5Glbq+Q==', 0, 0, 'FJXLs0HIgxHxp2wnyjzuOQ==', '2024-11-12 20:31:01', 'admin', '2USBJcQ2eWO4Oh0B2ht3+kvewhzC+hCvh+rIXz4PUxY=', '08aQcYC/DTTrWcvLRSvmig==', 'YJpEBbyFJ2vclou8ZqJ2KKRoKy1RHLH1LwiwsfNJxnM=', 'm7jpbiK8nvT8NKzs28d0XA=='),
(48, 'T+pXVeC2e0/+KS/HyxWpG4Is4Q6tdAKACN5aQVvd6Qs=', 19, 0, 'SOncFmR6xnygSSIfni3sgg==', '2024-11-12 20:57:59', '', 'GUOhGUmsVHMoghlcz2CEbT2JBugRzC0sQ+sCXJT0fVs=', 'i1AXtubKaBZQEMETvvreCg==', '', ''),
(50, 'hYPV7r0MrHtMjGosgrKnXA==', 0, 0, '+0tg0tcUdwTUSiWtiy+kWA==', '2024-11-12 20:58:26', 'admin', 'OuNzpJiasjelAg/j0MDbl+JV9LojTI/pALa2xuVuXDQ=', 'd4Cvn6qajb7GD2fhzGSF4g==', 'wTQDkCPo4pbeSkOWeHLQoHoeMDyFO8P94QJfuXzxBTo=', 'z5e8gJyhIJxJapOWODn/lw=='),
(51, 'auprEtpoE+GUb9+iyPu3GA==', 0, 0, 'f+8Sa/ApAey57QgMaKrZ3A==', '2024-11-12 21:28:37', 'admin', 'PMgP/iwAcHbfISDIgbhASO8OOniJjP+xebruX6hSne0=', 'rd/fLxQHjDQBEuHG3bq1Aw==', 'n34FQSagLI02eXUZwrF6MgMDTF8WU2a2IXide95kyOY=', 'jyB8oXxT4HjTD34LUzFDXQ=='),
(52, 'cVlY4vFdI+N343QhWCIeHg==', 0, 0, 'yGl48wNQu2rZOHory9lLoA==', '2024-11-12 21:58:49', 'admin', '7dkoSfqNUflhoUCGOFRIk19Zjg7TbYM15YclUbIMm5A=', 'Rs9wgr/QURpnFtpQq5NEbQ==', '', ''),
(53, 'YFSRNH+viiwBU4FYXpwIIC7FcI+zMOaFT0ZO5p51CQI=', 0, 0, '4EaSvx6DZ8dJzJ0ppW2pew==', '2024-11-12 22:08:16', 'admin', '', '', '7/de8orQqm7PmRcgQ+yqAAbRynVQKS7EyUIGwN/WxZs=', '2d6QAlbF8PCu8OW75i+Cbg=='),
(54, '+RrVDPqVxK8VBMYyLUwn2A==', 0, 0, 'l3udcOI5szDDPTLXlVgTDg==', '2024-11-12 22:09:38', 'admin', 'T0SqqfgixnLtKL9s7H1t9UjyblhpegrnlZGFeaDYRTA=', 'ulIShlLLq3pdJ24SkyzWEA==', '0QPp8G3pkb/gR1oO7j0cqrBIFLxj/Iv9MmEvVTYaYPo=', '66UHtkYee14ituSZavMgBQ=='),
(55, 'fZvSHkDDjv1s+kxf7oroKA==', 0, 0, 'Sv2LLbWj6nqjJKx15rrvEg==', '2024-11-12 22:18:49', 'admin', 'jggdc31jrUYwynhoyMQowzsmj2ntvsO5fMOKFPsSsJc=', 'VCn3nHKnFhMjUHWvuhNzkA==', 'ZKpSOGCcCPBGDA4UyunmRKUYEr4JHP6UNDvM78qqNHs=', 'XejlUvQVFJFm4jPDu8/Xcw=='),
(56, '2II8JpmB9IV6wmv6fM03Jo2evtM4Z+lJLmQsw0hfTRk=', 19, 0, '9Rhm/zZC2diBOYOmRZ8WuQ==', '2024-11-12 22:21:02', '', 'E6cbQzL4Nwjn5htvpVVeXOqb6YEP+Y5Bv+Vdeif6GDw=', 'AcpLF7Bj8xeN6ElyQAGhGg==', 'QODkR+0qPVW4dOM5mBbhylL6Iug2wNOVXEqfxemHyYY=', 'bnM21a7EFs6vgcanLhtQfw=='),
(57, 'Kq12rP9B9HuALE4xVwYuFg==', 0, 0, 'DS20nihA2El8Tq9/1uEXAw==', '2024-11-12 23:29:57', 'admin', 'WifpOnAGA73t4cpBYB3blKrzzUw4RJjhtlqsNmTrEaU=', 'bQKOxYuZfoJFmWpzDgePrg==', '', ''),
(58, 'BmuX9JZ7NhhQDg4h7IGAT4ebRmuT238kPxg1AT0dpqQSBOa16+vpi5+L+FJ9zS+Hsn15auK7FlFt4eFBUllPKcqWnBddMdx9t7Agq3JckB0=', 0, 0, '+ILrERnWp8Zph8f9t+l/Tg==', '2024-11-12 23:33:45', 'admin', '', '', '', ''),
(59, 'rrcXM+J6DTmH+V58SbUEsDrdPDU6QnIQabSlialVtQyhjRwZvY2LFdP/kbNwX1AiaKSoqd5s6biml3Y8uHI/HNvXqAekZnrEP3m1BqZ3rYQ=', 0, 0, 'Vn7RJGsoyzOw5GgLf7DLeQ==', '2024-11-12 23:34:36', 'admin', '', '', '', ''),
(60, 'MBbQe1Y0pJa6rUdyaaNVJDMRJVjqvIH+N47XZh8m5PA=', 19, 0, 'hh1W5xcyENcRalFQbUqeww==', '2024-11-12 23:41:31', '', 'WKLkFvfYpWHkADVWYdVnZQUPeQYBbhWmuyyBQyWx8RE=', 'TquJrGanXj2HS4Kf6Jt4nw==', '', ''),
(63, 'uVK/3fyytXLIqc7k4phuuhob+aRNYSOx/dZPcjPZ7/8=', 0, 11, 'OjyN+95nuzmiMdYZFlMgxA==', '2024-11-12 23:50:43', '', 'GMH+T34IG6sj3t9RtinE2H3oCl6ODBlkW9AMGUw5Ps0=', 'o2Aj/VEAVdgkksK6HXyXkA==', '', ''),
(64, 'imvn6nB5r5i/LMZp9rtKAtqgn15O+IoPisZZZLiPc5khGf9tmyNjUJ617HervqrWpTPuAXKwPF2A+F5HuhvhYHrmhdyEKRBTkQ5/xlLrL1k=', 19, 11, 'eaTZQtCMgtITa1IqRQVfFQ==', '2024-11-12 23:51:32', '', '', '', '', ''),
(65, 'zqRnibxfGbvaCx5JgodWLYMA/HGWzvWjZm8tYr76onc=', 19, 0, 'xGOCXLXcEc8dEgL/Esh59A==', '2024-11-12 23:52:02', '', '/c5DuOesDYZkEdHRnbn1Rbx77QqS2gWEmGDG3lkGdeU=', 'CYTRbppBAa97S/EK/YPTFA==', '', ''),
(66, 'SUq9trG+fSuX5sZmj8bvPeR3i1NWfN594MCgRL2ofh4=', 19, 0, 'cqe38PXLV0i+61Zq/bpdmQ==', '2024-11-13 00:04:29', '', 'btJzq//IrllGCqs6WHLSZgWVcad/rH0/nLktOoOasTk=', '9kvpNaF8wCF1JIjd5Tb+Ow==', 'y9wwUcQEPwND3lJr/NMjglfbObTSiSchsUi2DBwyHZ0=', 'BSOBx1DcgZ5+l8Zlq5fJxw=='),
(67, 'OrF1tH7IrvSHGU+cUn2CUP1b7JO4uhwiEAIFmvntdmM=', 19, 0, '7TtWboji4sVM35UgumxMmw==', '2024-11-13 00:29:50', '', '+62McIB4OrltYBAxdrQun0az4FTYrO9vMLz7pGetpxY=', 'L6rHr5oZUQNuVyQwoIaYFQ==', '', ''),
(69, 'UfZnUUX4shVvooAhBIBIFDsZvEhr2GH1VMg8fSVGz/w=', 19, 0, 'IkuERrVenTtXK4B26z7YcQ==', '2024-11-13 00:30:36', '', 'huLKYNNCYdIPDXMYJ3crFzNmvC6jyAmgg7ItZMMYV7k=', 'QOUpRwxwal8UhytPm3NMKg==', '', ''),
(70, 'ns8tPfApB0m+nJ4bugXXAbRjDIY4unDtpVHUPHh4A91tFRGtgIvpgXducFgdJbb4UFv2+NxSRpOc4mI+bY0d3WZXRZAG/wULVonTedksCA4=', 19, 10, 'BJ+Z9G4aPxqB6xrIYfMhEA==', '2024-11-13 00:30:43', '', '', '', 'DydIrtsw1X8X+13eS1Gkq5xBLth+2Kwp6vW2jV8grf8=', 'sjhzFIMSDpLs9qWxD+ECYw=='),
(71, '2qk6GEjgetoOn3caS7Vt2Q==', 0, 0, 'uah70W/n75AXDyrqY3UglA==', '2024-11-13 00:31:06', 'admin', 'IdO9sj8zjTWcyU94p+L2y6HBw0e4tWOySzsZixDkla4=', 'n8mKUNJoFpQWbgrPsFrisg==', 'tBGrZIKIbV7q8UN34VEhQRp1dB+1CR+p1+ooF788pt8=', 'ywZ3S9o7imr8Munqiu7Z3g=='),
(72, 'luQPYli/APSgPjWD9ZBpG1hZhX6FycHtSt4a/sQL058=', 19, 0, '8a5e1RsyG/WHA/x8nnh8XQ==', '2024-11-13 01:02:30', '', 'nmDbQVxyKnqV4youq9eOvYBW/kLtwimhlqImjhr9kSk=', 'MTuMlQWWEfA2srUjPQYa5g==', 'qo4D2OLGJBDa+GaIEkR25gcdWxY2LsWV9TOttNB621E=', '7C5VCiEryh8XwClReXHsnw=='),
(73, 'KT8kc/ICQoONBG+Efmy7buaQj7M2Z8RbbiScGdX5Ze8=', 19, 0, 'bQy11q0H98ka43h2f5Nctg==', '2024-11-13 08:35:25', '', 'o4Srnp4n31dgxnjIX5xyFIrRBOQvYmaIM9Vk3mMjvmg=', 'G7dki1U2ENGZTkflEmKAyw==', '6ObiPn62vZuBJ/8u/VU0reD1rY6PxCgdfAzXxq7OUNQ=', 'szMLYV89l9NEDwVphhAKAQ=='),
(74, 'LSpIu2bfU76+6avHrlVuQ1dk9UWlFMWdfqpNOaeJAsE=', 19, 0, 'NVjoAsrEtH52K0LaOmdalA==', '2024-11-13 08:40:58', '', 'TN4CcTPqOuvmhofC3elsU3awqI3md0yzRBYkNbq2ipQ=', '6OYjZA91pQ4qP8qg3cCw1A==', 'ReT5d6u6oL1o6bkA0BPkFfIxyoN5QllUrmIn0gOv3dM=', 'Hs5aT5h4yYl4YwMAjy5UvA=='),
(75, 'LggWCVoSnXoYbFTojmQWNA==', 0, 0, 'pwQ36oLJ7pFCCo2Uc7ltjQ==', '2024-11-13 08:41:31', 'admin', 'szwQqqVM0MiP2aHUBYtitUh9nSGxp3IDKlay/GcRG2U=', 'sOzumVZ8UFqfbLyE7e/oPA==', 'MQYu7aSGIuprPW/DxDyi4XqWFOqPp924DoiIMxEUYFA=', '3DkAwyuGsN5ZJA0BnaOJtQ=='),
(76, '6WsvT2PC+9nT++s9CufC5g==', 0, 0, 'pSn0Kp00ktA6bafOG7IUnA==', '2024-11-13 08:43:10', 'admin', 'RDeEX0FPV74JTy7LXWck+pXi9gehFgWCpykaRoOW3PI=', 'I06CrugZ5XFbXNTrZS//OA==', 'H1fEVe63In4vbSsTPbsNYQy3oF6k7k1lBQhySfNbOrA=', 'dJYuF4NA5yTJfQdx1G9/vQ=='),
(77, 'f/n3isyW0KDlftuN5bfhO7K7/xT81p3Lxgk99C/Tnog=', 23, 0, '12xXRPrtuh+vlO7XZ8uVRA==', '2024-11-13 08:45:48', '', 'c0AreRx2uSEHLbApq4e/aMErN5Hr6e0/7xqjnYxTI7g=', 'ZNH8zC1JW3ehy+Tf8Yhh3Q==', '', ''),
(78, 'WgfBnamE1MyevY4Nzre0kFP87EP9qXOtejup8PuVoCJUMrgoixNHzxFWZyxfwcMZJY5xs1K0FQLA4mRi6V5H8eraWjXQxf72oismDOEB3XA=', 23, 10, '6jsMk7R8ah3qREHYxep44Q==', '2024-11-13 08:46:08', '', '', '', 'bT1vXsIDIjmDINKqUwZyVkcNUSbTB+3hOurRX/y2kIY=', 'h9BdwpFoD7eTMlQfl0GbNw=='),
(79, '3YwIHnkd2K9yJqRYVvCU6+tGAmXP6QfLc9mfHZEvKAk=', 0, 11, 'Iz2q1lIZaWCKbK+EfH9axA==', '2024-11-13 08:47:02', '', 'zolUcJS+TAeAFMvpCllFZTeR1jkv52vAEmSb/5z10PU=', 'aZczKijdPaZDGMLkzRLgHQ==', 'zcAlbKWYUAwi28O13jcr9kVn51gr7YqgzGiUm2h+w3c=', 's3vUVnv4xYLW5rpkOMvIKQ=='),
(80, '5ixzno2JQS2IRGm5Oxy3rIchFOIBXGvK2kCvVgLHkcc=', 23, 0, 'NgwnmIGtSU5aWDPK3IafPw==', '2024-11-13 08:47:26', '', '/cbYhJAk1XF43IHH9axO45n+6aJII40Q6CqHThru2wY=', 'eVwbpoFiEmEFUJ18XlS/bQ==', '4+LTspQyaKGarTFCXfAlQy12NY2kgZ/8hFP7BWSds+4=', 'z7/fN9CCNHi9TlJM1MAkBA=='),
(81, 'kvBzcxZck/8973uD/IHxoFjMM+8EFUV6FW6NUiHmu0o=', 0, 11, 'fW+0p2ku0Xpr24VLB8dhPg==', '2024-11-13 08:47:54', '', 'VVm19aqGAJKZusys4NlMVEOcdn7rj7y6kJjtwhC7aP4=', 'jTtUnUgNjYSSO8C9prLu9g==', 'pV5syOFgu0WYZycQ9xk77G3vzvTmpR0TbRiaAbxZ4d8=', 'qgJjStSu8nVm5/AJGhE0Aw=='),
(82, 'jscNXFEdowYUn3yE1W2WiGtpuIWkMDn7H6WVfcIobps=', 0, 10, 'xr0mqkm7XPQXubT4o25COQ==', '2024-11-13 08:48:27', '', 'UnPDhyHeQLVe62gy7bv/NxBhF6eUhOx+4xlfVXIleG8=', 'j1AUJNdSQed3vz9KvY74Cw==', '', ''),
(83, 'L5MVFJLJF+TLXvW3SffRQ9S5izFid8xvqAKGwPP2b4yfaoGV3Ep8apstpmmqEAKZFSffDZ/Ges5lKvFYKNuTRA==', 23, 10, 'BVtjSPPvZPrlEqraYLGFTA==', '2024-11-13 08:48:46', '', '', '', 'DzKDYWVNGxr4HrYjPg4lOaIqJ5Dn2UChrFMdi2TIL4o=', 'Yf1m5KNTRdhNrSQoxmTFdg=='),
(84, 's5eMnuc0UygdPynxvuC+dCwnV1Ldzsdv8oxHQgzm1pU=', 23, 0, 'gyrkEmsokTKhFBaT6ICB2g==', '2024-11-13 08:49:25', '', 'CIAGRq+rfbWGZUsRq8kS3c04yzQvcx2dbiDwzz7voa4=', 'dYygQ6ik2HnEs3cdp16KIQ==', 'y7uuPEPEn3vhhIdEear4pSKz8nWUSBLzJh2OzYE/mhI=', 'CAf7yDquY/O+PXrfixtzeA=='),
(85, 'qOVIHmhrp4rbgaajOqh2BBXzCGFJa64+vDlsaBXg520=', 29, 0, 'g86QVTZly37jr5/Pt5smcw==', '2024-11-13 09:23:34', '', 'DGuZR9+fJG27WSX+MfTmr4g/UfbMou9piZY4XLKGVGc=', 'nYk3zDjWvxE6xa41Hcl8lw==', 'HVhiIphin6YV9Ar+y8e+J74Bnd/wIpEbZCYvBAE1d4s=', 'xRTbsfoHR66ZqPTrrk0GSA=='),
(86, 'Vo4EZSunljp35xCbcVbCMkMbG258jnSuLrLjpKKy4NE=', 29, 0, 'hr/klLaSJrQqNoWeZBgqtw==', '2024-11-13 09:24:08', '', 'hwMFcsTaSR7aZVctOaP3sWffLh7xVDGUYyIMoL00xtM=', 'o+hJzTq6uf18+Z17Zm0Znw==', '', ''),
(87, 'h081Ln3BMjJVo3W++v3vQfpUDQurzViAf210YNLCVpa9jNPjdtQeWL3WVhnDH1yDUDB8U9P3R9nuM4CLm7hm/7vXAswZ9nw95WliE3HZ/tk=', 29, 10, 'pqT0EYwg2iPwitLdCc5Ziw==', '2024-11-13 09:24:19', '', '', '', '/Fa8tAiYMPTIJcPwKQmZ2O2hFh+9VVd6P5hCRqPicmo=', 'E2ARvPn+qgpi9zTGldPq1A=='),
(88, '+DJl3F5pH+68nUOBgpses85pPKd/2MvR/FndeuhZRbA=', 0, 10, 'st4UomMt1vtCUiT2xRgShw==', '2024-11-13 09:24:32', '', 'KZ/uAIKmo3i05EZYiOhIuyovWOkOxQ1hbpdGxLdC18E=', 'a6+R6ZqbX2xMCj73icTkxQ==', '', ''),
(89, 'e/Ma7BDbOlmD9WcDj/eViuOTVC+PV5w48/HIT9WMdGd50/F9J9d3RhA1VhNv1j1Z0jnkDfBXIt8k0pEIPbBXMQ==', 29, 10, 'TG8b0EQxo3MEIsKuQcyTVQ==', '2024-11-13 09:24:40', '', '', '', 'omtUJN9sU+DVLk9U9l7mpFlxrqOKz3bOtvtv72oOadE=', 'zMfAGHcd2qt3iLzKiwAewg=='),
(90, 'YUGNQ6GrY9OgMIuDqtm3YmO2fdDW0zSsP0IhGs1DaAE=', 29, 0, 'UHRGcVcl0tBc9ktu1U8aew==', '2024-11-13 09:25:14', '', 'inAEfPUHEziupuwKD9UPHMXOJV2ptwndw8jE3J23oZI=', 'Q+aMpps0PHgU5+oKgMz6hQ==', 'BjbJG8GF9o998CUcVQFJsArxWdKs/amv0D/oYxKZ2iY=', '18W1cUXakQHjyYM0B1JXtg=='),
(91, 'Qu1A8mNvvwo1OK9qh1zaxGT/7cOjAVeiJWwMNKsKeLM=', 29, 0, 'qz/JDuHHTsAuvEe7rlNUWg==', '2024-11-13 09:29:27', '', 'jhFDk5Fl6/mriRuy6Q7xkj7fagIDmHqKN6BbrwsfcXk=', '+UqHlSfyf0t/laDQGMmWZA==', 'oBf6SGKRkG8mwJq5IQAI3fb16LT6C/X8RU8RkO2KUJs=', '9G33h4Rf0MDMOlRqp6H8FQ=='),
(92, 'h/igYXN4jrYmG9TauZWHSlbDgNACj1dh17GZBiODOkw=', 19, 0, 'tj0dy7mKTUlrmQwYsdtcMQ==', '2024-11-13 09:47:10', '', 'bh1UqEQ/w7ErLrCIcxhInDayUEd/ddl/66oiybwBSRI=', 'IR71rHedJ8UfsgSCL7gwew==', 'njz/RCyZFhJ6npCVaK3rSMQY8ej+PcHMqqZSl8plgSc=', 'Oc0Bxh2MS36P6ktAsW2ZsQ=='),
(93, 'WTubTxKI2+LrY07UA2BGBGS5RgpUgb+V0l1/zISFniQ=', 19, 0, 'p0AmPV9+KGLICSmDnPodhg==', '2024-11-13 09:49:22', '', 'OnWAE6Zy1Gvqf+oM5XU+kNqx/1Z3CUvzYvzel2Z4PhU=', 'knSq5zjQPlKh57V7AZF3Vg==', 'ickTkMcRk/gUjHdxoWXvbe9dj/SqVPEV4qxJIduEU+k=', 'NUZ9Y4lTL/ABjG3b2XraiA=='),
(94, '/tnXkS8UXbdp5GZH/3xYmDzBuoZK2cxHtZkRSgM4HmY=', 29, 0, 'kZQBzqnOT9dK0N5TwBtRwA==', '2024-11-13 10:01:41', '', 'I/Q3Cska7hm1eeQyJZVbly9bo5q10he3F5G1xMpNcpA=', 'V3JTmf7+9lB7Husf8yFNJA==', '', ''),
(95, 'XWudreWy7OnfUNLQ1ebi6YX0RoEg+dq1Rtl7wYdvx9g=', 29, 0, '1lDorYw2YvlyBMquJWMAyQ==', '2024-11-13 10:02:25', '', 'QTrB1qtxDjtxU4IIovHvv487NNBrVl9MAHhLxm/cXRI=', 'ssISycxQdcT0yilaHYIErQ==', 'rWW0pmphJGg8RLCGI5ZeMXA0hpqIYNxni56U5NOV0tA=', 'cEM0bDS35oprgljONR6eaA=='),
(96, '7VtwlixlRoqLQOC39/HXpyANwi0dzCG7cPlsDqrxx1Rrp2rr7Hs1XkcY6MsFU/j5HKXgaMHGz4+uJb9a3iwdb4CzvUTy/u3apuM5Ziy/5aQ=', 30, 10, 'G9qnhuSwUYC7tOe+SYH2qA==', '2024-11-13 10:10:34', '', '', '', 'rtR6aDNGwZTkVTwiQjsAa3x020EsBVOc4VPi5KgkVKs=', 'ZNsdkTLEaSy530XAf7TG7g=='),
(97, 'U6ieeJp+OSNdCXpYvyXrdw==', 0, 0, '3/E/BKEfUMrsgPQ63kWmYw==', '2024-11-13 10:11:25', 'admin', '/rekjksitRJl1MFHUnXBBHwapi0xcHJuahyqVQIIG64=', '+43HaWA4aq5J21U2xA0wYg==', '', ''),
(98, 'Veww1gCJcZ4qonLLQHrMP5xqiZNovLhcz8Ml4GX2yfuVWpIHeSF5jNwftA62fDrMUgCEjFhIUDYpk8Bz23ObSw==', 0, 0, 'ekhmjPBfYZDX00PyhnjzJA==', '2024-11-13 10:11:44', 'admin', '', '', '', ''),
(99, 'u13hX8Rh2+rb9ZBgeBYwDBJwkjXgJLCqrQ8Rng4dix3byFUpzscvddxIQFXJoIgiPPbpd8YI8Nwtw1kWYf9szg==', 0, 0, 'PrWCSsH3wpsfYcJrbG8tBQ==', '2024-11-13 10:12:48', 'admin', '', '', '', ''),
(100, '/CqilLkMkchs3fAE2g5mxg==', 0, 0, 'WBTTPUx1Xb58tHzbxBrdcA==', '2024-11-13 10:17:04', 'admin', 'N4YYZw2/mNAbhLY3Rbe2IIUpzDUYObAVf++olmx53LA=', 'cpobjvLVRxaR5HawREwODw==', '', ''),
(101, 'wUP1XXIXxyAI37/KB0tnRJeW13onplF91PxirqkI5yBF2IcGOVRAeI2XcqD9HOMdQhYKgFIxzXR9Zy81GoEeTQ==', 0, 0, 'yrBb0SksgqDfL9N6/tI5fg==', '2024-11-13 10:17:55', 'admin', '', '', 'ThNQUcdLksFFWjaH7vfT9wdVcEenaxkOub8g7PryxQk=', 'LdO2jZKLBQfHXIocKcPjdw=='),
(102, 'tt5hNBljaBfXtsp5u/lB3zA6gJbSrR7Tl1D4tLHn3po=', 0, 19, '1brgjgq3r4vkfk3rPDwsug==', '2024-11-13 10:18:38', '', 'MYPn2/0wTA3EIl+IBLL/aM5+3eokQF9LSdOHGQK863M=', 'sylp2yfwk/JRD0jl7hKbCg==', 'NS8hEP0UQasWNQMu5P7RaUcsJfpAMF97FzzDuJ2oM8w=', 'XMeEEBOq25FUYWRylF3ekA=='),
(103, 'caZtgZGM3Z9vTLVa+wluYwA7WJ3XLiL0gWpF9pGZvkw=', 30, 0, 'ArMCLdGJeaCAlFyLj8oSBA==', '2024-11-13 10:19:09', '', '2NrsTAeNcrM6KOt1tTQLI0+IQi2p5/QJcifo5vmVRdc=', 'M68oUySWMzOsGi3X0VkIBA==', '', ''),
(104, 'ACI2KTme4KeqJ1Ri7cOCWV6BcQ105LC+YTuLYgDiBc2dNHZFEKrt1IV2aMpAVq7q8ej0erGyPbHVBFA98BDyoBDtpOZMv2EWlFpHe2qfKfM=', 30, 19, 'dcJRxvaLisA2nS0UQHLR4A==', '2024-11-13 10:19:31', '', '', '', 'ngehPJGnGC01h/LGmjg6PQ4WLcggrxC+xvRA1kb3O58=', 'cRkhayaq9JIveGwdO1eAiw=='),
(105, '75Owsansq1Y74G+m3v6zwEKViiJn2J+jUCK41MOnO0M=', 0, 19, 'NuZ6H1fXDUsTF/G8pBco4A==', '2024-11-13 10:19:46', '', 'hCA8VYwb89phrwB84Fw5lQEq1rVPpF1+SZb1Bnc5ZTY=', 'qywiJx9qg0755UxS04pjRA==', '', ''),
(106, 'ostUqqS6gyIl5/3qmQILI6ox+Sx9dEi//YXmscNus4ZkiQqGgwwDUkdzhyhLRiFsqIsyzl8EdSHBP5enOz0jMOTqDtrwmzo4babiy/+uJzM=', 30, 19, 'TJqw81y3uFY3DL/6XJwD4Q==', '2024-11-13 10:20:07', '', '', '', 'YQGE4POGDseaBG3yxA+BtawEoQ+bHfVqHGXvE//TAKA=', 'LC9cFt76y5rTtM5jfUKwgw=='),
(107, 'DsqSWTg6WvymGExCKAHJlw16glQrz6bebrsriLYRWkg=', 30, 0, '0Wb+17Vibghlr2e49Y9eow==', '2024-11-13 10:20:20', '', 'EduksLQZ3DOiaWhZCAPmLY+05rlMeIKo8TRTfJ1YAvo=', 'PLaZBPZpQUzk0/Z/aGfrcA==', 'Ih7h7nOO4tne8ODlYoqTlHV0hloXH58urc/SeqoQfA8=', '5BLxYZdj1tl2pbFebAdPVg=='),
(108, '2SjRpdqxKq/Tz45hSkFpwhK41dkWknNC8Ly2C1zjxXs=', 19, 0, 'Zm8gYIoxq2NUQlyKod1JyA==', '2024-11-13 12:14:43', '', 'bqBUedg6R6uX6YGWkBDsEn8eVmLbyUgYGpjKXyyPHd0=', '6/i28HRZ5RLNZ/QVleoxgw==', 'sdkN77nNroEFkV4mHdy8Zg9QhAGtHL5//FgG5uOGZYc=', '9RNJpz9aYdwQrj0u5TJ9Qg=='),
(109, 'yspskKKqRbzAv1/QVKUjGw==', 0, 0, '3tKTyBpC7U6r6TGs26/52A==', '2024-11-13 12:16:26', 'admin', '/qhgxQB3pg+/Xm6qDGXzcNLOmlWFlmE4w1YjoCs46sk=', 'dGAwFiZG3xpOpf7604RPHQ==', '', ''),
(110, '0WNJGfjNuLwIYTZCCVmZcXVu0FASzqWYXOJMfMUs1Gs=', 19, 0, 'e6I1yCFGZuTXmYmhOTQK1w==', '2024-11-13 12:34:07', '', 'dDU88O8Sz/vvVV0xPQkVLSEwm+I7mVbwWM6o1ODcr4E=', 'AZGSnhkNFhFf9IHgOVovYA==', 'EE4tMnwwSvGhTw/5yK+JFrjkIG/d+XqEPwP6YUegF0E=', 'w1Phv+nMIj8dUKZG/Hnqjg=='),
(111, 'yIRu6PvW8PScXvlIt4GC2Q==', 0, 0, 'dNlnEVGXcSXhSpTcDMueFg==', '2024-11-13 12:34:16', 'admin', 'n6Sf6xuKkuh0TUAIm5Tq8T7PREv9zZKC4KQiJ65imc8=', '4X597hXT9TI0VYTDzaCs+A==', '', ''),
(112, 'URdB1Hv2ERmRii2X9Ip3yYoHClhmG4uGcWpKoP28Cu6UZysf9WSUYaRRXc1I2I5OV1Ol+IayON4gFnwO2C9KCg==', 0, 0, '83RoTuNfiIXJXsQt0TZBVw==', '2024-11-13 12:35:03', 'admin', '', '', 'FSSXiRqli85Vee44J0kPZ9v8E9Yc6fXpThxGuKOWmug=', '97SAQoChRiXcqQt+CNXpog=='),
(113, 'fMQ4E30nFnG+4R2AbNPdJQ==', 0, 0, 'KTbfLfYpevD5+/Rgx7ybeQ==', '2024-11-13 12:37:28', 'admin', 'Av+hoqykLNcmTsvHrRNEufnLxhCc47wcG/uaKVSTxlo=', 'ciqHMh7agdusKeFVtbTTYw==', 'oDRvqz5w6XcVa+JUVZCbz+DzZsxRpE4GOzprFa9v20s=', 'nVRLKCvusKals62ggyCKiQ=='),
(114, 'VJzpCSoblzznQYz6/KF4oI1BM15XwzSAx8zisYeBjSE=', 0, 11, 'ICpa9dxaxlXrCSAZdmKzsg==', '2024-11-13 12:42:16', '', 'LeMURySECWkbNg0fAW/OOXFzey+Ozo0eqoHgD7puAbs=', 'MYjO0aDi6Tns+nsOG3NKlw==', '', ''),
(115, '1JhJrwgL80Nj9RC1Kt+epdIGHh4nqIqzUjiVUCvOy9w=', 0, 11, 'fCjP5JR/v/x+tAmo1g9lYA==', '2024-11-13 13:01:09', '', '4uRbpCrSIElC+ghOgxxqI9bViTVv7t6rcI1hqrW3Abo=', 'U88/rC0IDC4xpJ42aouNyg==', 'HVSfs0pktzTZGYXAvW4901QDWyxrC/lgE3pANU6qiC4=', 'hqE3DIN/ndauOrwm9AKVIw=='),
(116, 'so3TsdgPVowdDFRvRYnrOYmXAtYnka4DTobCMTps18o=', 0, 11, 'lJc4hZdDyf35oqWfl6qy0A==', '2024-11-13 13:13:07', '', '+agiLSy0uN1ip85uqtG4hRY8CKZv61GGe7tlgHXYcP4=', '4OqETvYYyylC9Dn2nJauiQ==', '', ''),
(117, 'rMGTRfaoSKxX6WyqpHTIYkX7igys/PIybmQ7dYCVc+g=', 0, 11, 'XLPJq3Y92rgZtMMdancn8w==', '2024-11-13 13:45:14', '', '47GNr2/CEX+aZXm70pfH2V+AjmpkZnE62By1pFysXLg=', 'b41LwaA1922LdPPXEo74gQ==', '', ''),
(118, 'BAlm/v5nnW/WmY7B8ZXoE+OKbSqR5ngvVbmaD4SJOUE=', 19, 0, 'yomS4QQwfh0eaIOoloA7Tw==', '2024-11-13 13:49:39', '', '32GCcoPupN4LqRIWpriSRT7oedpOxAKUdoHITKLq8Kw=', 'wD9MEoDd1X7CtrtPSxIeuQ==', 'zaaF9TcQWXM7CkHAlj4IkCTnaMsoJVpAiVy9MFTLz3g=', 'FhQAENy21JZaQ3JqM00nMw=='),
(119, '5y3Ye2T/qDMGZqXEvlm6qd+cRjXMUfbKVvGI79rOAZE=', 0, 11, '3NAbh4kWL2Vrh8aC7Pdn/Q==', '2024-11-13 14:01:20', '', 'fgGk4zEr79lzOIMEMZwEL3qK2+n/+80q7nm1gj0JJ3o=', '3Ry1IFxQRZS58l36/N7ACw==', '', ''),
(120, 'HjmuPu7iC7L1oXvqmXbpcm6foBeyvrpjRMc2HM6RL5o=', 19, 0, 'PLS3CDtW/3yFgNF8zkVBog==', '2024-11-13 14:12:27', '', 'WNyk1BG8Fkh8RPP5rovLBcHpMcrmCRpxR25W40EPpf4=', '4/j2TrEGiXkB5Jili7jWTg==', 'IFp6H71wHvp/BG+LNNK8j1+XtiG+kKoCS1hgtkRzSFM=', 'lcfWT26DRDc2NWt68hIv4Q=='),
(121, 'xOMmc87cI0MuaNft5wREoWeBFINS26wovuFRtcJ+bT0=', 0, 11, 'PuB9HbhTcTTwB3tWm6d8zg==', '2024-11-13 14:15:05', '', 'fACqTA6A10mer1xsSu9kV9Tjyc7ucksUw3mWF6D+fP4=', 'OfxM8gn1OxuXWgxHNZkqxQ==', '9g1JWodSXF49MGkP75qwe+X1OFIGkIfWTyLLyED52c4=', '6N0Yj9rhFLnPq9sPKJre2Q=='),
(122, 'MI5wg5BUe9WiLn5uXqaUq+1lhOvfHJY3MdmmWCPwQi0=', 0, 11, 'GFMyEbZ5NZ+z+yUnkdXrow==', '2024-11-13 14:18:48', '', 'HY/6k+E9wKru1fYFZCqYubrtTP52DVsgHitERYJdL50=', 'dAkcDs4fLZhoR/yz6mUpHw==', 'XqQQ/y1vjUtfycJ4E1rV9YRwd8+cuaxD6IliIu2tcqE=', 'ZyLofQywaxjwlMWevrcAaw=='),
(123, 'MUezmaPvlPZabVtQKj9KxePQX4mlK/ntvxMZATAbMWc=', 19, 0, 'lYtEy5iPmKzgCrQkvR6D3Q==', '2024-11-13 14:42:31', '', 'BJTvQBV7nUR4XSqRSJgR5NY2B21LAYHSZavTowj18nc=', 'IaSOkiWb/ut5Qf+32zOp5A==', 'T7dhOWZQtxE93SeK+4HhR24D8mFOCFdL/k0oNIssLv8=', 'f3pRQFQViCNWLfPTgdrpFQ=='),
(124, '1dyPaQVIaIHYclMs70gv7BzWiHp5oythuH5WhIkxv5Y=', 19, 0, 'aVNjL+Qy5SvE0/aJmsxo4Q==', '2024-11-13 15:06:42', '', 'O6+jA0oJ3waY8dmnm7uAgHpkkX2MHwG8Pp2O5UHqqr4=', 'cWUdAI41U7Wc6PZ212MXEw==', 'uHjJNdM5cS8rUdWse8YUOOIWTTnOQaiQKtsF1x1Y02g=', 'Ktla6zlgqjy/UAgRiUT+KA=='),
(125, 'pxUXbLpUJw6cxRa0IRI9KR9kVrm12R2rDCDh8hwd36k=', 19, 0, 'D17cocyZSOdPJRc6j/bQvg==', '2024-11-13 15:08:19', '', 'VnuGQVhvVoEqD7cbYSNxgr/9sqwvKbsGs0psEieV/YM=', 'Gb8XMRwSsZZI5cI0ehUvVQ==', 'YCVqXxA1T/KlXw/CEPwOcgceYY39U1trDDrmnd4T6SA=', 'Y7zbfwIwbqluIC8WsgFTHw=='),
(126, 'qZ0OrUmVE5M4hCnUwx9Qsg==', 0, 0, 'lEnLwiUabqw0szo+qzhoQA==', '2024-11-13 15:19:41', 'admin', 'x2hOs2y+4/xYuAWY28NUmFA/XC0d8/q1JYuP/lkwpHc=', 'k9U5hWV4hfppqKbr1OfOSg==', '8OH+nRMsMIscGFBsTCz0VIHkNQZF53qqIKS7YSnM1q8=', 'nLpQ7NFhpnrVJFmNS7CkPQ=='),
(127, 'iKyiEyHocncBUXVPgsYmQQ==', 0, 0, 'lNZFIP5wEu1blbmjFeD67w==', '2024-11-13 15:44:37', 'admin', '6Ojl5FvePfdds8ADfQ4yv6QQxdOoFGLtPXB0jUaVQY0=', '9qqYkS7O1AXNrMYumSSecg==', '', ''),
(130, 'G1xNLSNOYaP3ySCcnn3JsSiYhOiC/7/KUr31YvIiJjE=', 0, 0, 'cdgY5lfTl8kCB+BpZuqvWQ==', '2024-11-13 15:56:24', 'admin', '', '', '', ''),
(131, 'KtPZiheqNUVZ7srAvTKxjfvDcJcGa94rgO4s36Bwzp4=', 0, 0, 'tTi3+/e6/RWTvxHf6gaEcA==', '2024-11-13 15:58:25', 'admin', '', '', '0FyDyyoFo4UNUsWmjne89uAnSjcuEiB0zNj7p6M4My0=', 'bg+AXH2yJp4bvQp2jdc63A=='),
(132, 'QCnoPhEn/hHL7YM1lxP2rUBinZK01JMAlbApUh2lwX8=', 19, 0, 'Ie1XFTWw6TRu/mLAKmHQ5Q==', '2024-11-13 15:58:54', '', 'kow0AhlRM7uIROEFz+4FSMGX7UE8yFFrTi8vO+mFVj0=', 'xNzPmmnjw3YoZ1oAQzPXSw==', 'MSAanFZWe6UiwZbQUbvhLYqqx5Oz7LCGhjGhFrClTws=', 'zj+wxN2eqbV6AIoXU4gf9g=='),
(133, 'V0va/eI+L787HcrpZvukBQ==', 0, 0, 'Cx+PjcDR1NGBVPfA7uNgVA==', '2024-11-13 16:03:03', 'admin', 'K0q7IgeAiNr1Lm4qWPKu/2Tr0FUVvHVcmolCVBmPHs8=', '7GKfa4IRhsZUdL9abKOOmA==', '', ''),
(134, 'u38EmjCSwU+d0GGzrWFVwhmaXkMBrLLP/TfUCIn24gg=', 0, 0, 'pupy71BKwUmkFw0Nti++TQ==', '2024-11-13 16:03:48', 'admin', '', '', '', ''),
(135, 'QPCHtNFX2F4paoEulirB408uKK1rXKZ+5/ElbVVqVTM=', 0, 0, 'PljQN2H9Vh2jMFiN2AzrIw==', '2024-11-13 16:09:13', 'admin', '', '', 'pEpmMQxi/vs0xjz9K1cdPwETx7Xlyfk45bdQWVFjS18=', 'naskMHPPZX0+uD5eMQ03Jw=='),
(136, 'WSrZQ/m0B0NUBWjhYeP9Fw==', 0, 0, 'qT4lyi8Z9VaDzWG9A2Rnrg==', '2024-11-13 16:16:04', 'admin', 'cXOE7SWn2k3YNP89arEPlTt0yj/esbs9hrmysOspfjc=', 'EjuQHrqY+IYc+ocYwkrOEA==', '', ''),
(137, 'VT6VN0v7Qi+fS9LQV7F+apmMs/RYpg8szpeNL/hfpuk=', 0, 0, 'mWSK2XrGzjUHCQJ0FfFhXw==', '2024-11-13 16:23:25', 'admin', '', '', '', ''),
(138, 'kyFZPA2KNYQBJJcvWjJugt3xs6VimLozAJPFdbTc694=', 0, 0, 'Z9gJAHVY/sAdsh2yxAxp7A==', '2024-11-13 16:23:42', 'admin', '', '', 'w9QZtwgvKMu6X+Egi+8UTQpe1N8Mtw57sO6wyVs7bWI=', 'cqGn97wjpGVip7SIawi3Bw=='),
(139, 'YaPXezhZduPPRxIqIjJmMb9rfsCilhF9qKZd1ALveV8=', 0, 11, 'k5BDlOJoDmdpbDxps8IyMw==', '2024-11-13 16:24:05', '', 'weXZq5UDeCmKSE0oBTd3hTPg9fTwl/6jDWVjUQV/TeY=', '/9BNZpc2EiHzNSf3IAz8WA==', '68pFu/fiIv8fWuYHHBG0EHXw3vpaLCA0e9OC/S1wDt4=', 'jpXOLWttKU47/VJwZ38qxg=='),
(140, 'yZtYo4tM6cEZ8LH8sZTLJ1Q/SyoA6CZNxoSee7X5U8Y=', 0, 10, '+QLpKyBAhiDWZ3IN0zZAnQ==', '2024-11-13 16:25:01', '', 'PEeV01QPF+uxx4Hcyu/1C7c6DAcvGBW8y1qcSV9WjJo=', '/JrBzJ2d4HonzNo5RLjB8Q==', 'B37bdwEADxxZOk0lo2zAM7603lmSgGS3CTfpFcjFGmc=', 'NCRfPMijJSwQAKx0O0eM9Q=='),
(141, 'krnVDEebs6HssteroYvjs+ZnPZjjUpqRZ3kKawDhjEU=', 19, 0, 'yLEYB2BvhKLSQKUakfqUkg==', '2024-11-13 16:35:39', '', 'I1Z8HEkDDaYNtUnLvUofvFxNxN5DvmoGiYXkVUh0aX8=', 'SZFoEgP4n4d5ipgUrgKwXA==', 'S2EIK+q0huWHcgPOOD6DqfM0x5GYpLD0N2a2k8FfrM8=', 'UnSluxytVSMWgsC7pBJ2pw=='),
(142, 'e90aq9MKT60tUjSYN4yAYA==', 0, 0, 'ci89jaykUygZxKCjDp9OHg==', '2024-11-13 16:38:49', 'admin', 'o/x5EMa5tivmbL0V5jBf8xjkZxynaNeliLwlVWSWmIw=', 'osTTB9GRWnext4RXe1wwpw==', '', ''),
(143, 'Yke4oiJDb/FgEGuv1R1A4BCzlf1GtIQNBkAKkj8QuL9p7e1KdxeiThyAyZJh3YZFBhgW+In/IAa+8xCzOsacEA==', 0, 0, 'sJB88s+Sectc3j6ZS3X2Xw==', '2024-11-13 16:40:31', 'admin', '', '', '', ''),
(144, 'YJyoyC8WqZj8dIQhGmhAngpwb8d7DvdgHnXhnuIMF1Y=', 0, 0, 'jRTDEtvw6xQDnNZ2G3Ja9Q==', '2024-11-13 16:40:58', 'admin', '', '', 'k2h39qOC6loCVPyfUTmtDXmB2CZqsvgFG7i+/eK0NEI=', 'lcDqLCJCHrDQPz37lxD1dw=='),
(145, 'ZpJQ17ciSvkXnI4fY/epAytYhfhTNlkZx0bJf4Dfp1g=', 19, 0, 'VMzCFbjrm3orHl5jvLDyCQ==', '2024-11-13 19:25:00', '', '89PYdd5w5ddXn9Ppy9vt++LVKrsU/pY3C9jz84CSACo=', '2uktMBailG73e5uqMFATow==', '', ''),
(146, '8EoishAdZBgY3I9DGGL7NkJq4YlRr6tF48mUa8ZYPyE=', 19, 0, 'YLEXuN5VmVQnb2EDy/8Sqw==', '2024-11-13 19:35:24', '', 'OD+csdrs5qOSTplofY5jKUoJvDgtSe5WKuewnl+xZAc=', 'QbcomJ4lGe0Y4k9zHOJ/8A==', 'Ugo+r5YxEsMYlM4k8OiX/aMaK1FuLG7sFpPkbTlg1P4=', '90k+en7UomHEv3aqUnT33w=='),
(147, 'iKbNyZBEarpfj8Vs4qEujw==', 0, 0, 'xiduDffGGLa5kWJVfb0j7g==', '2024-11-13 19:35:41', 'admin', 'oG72pXn86ht6YiZh76JBBzBMYAdbmg0DuvXHar61xfU=', 'O95R9gg8ptd83Beq74TvQQ==', '', ''),
(148, 'AzPhYqn7h9n24xIsgO6B/SdkIJAIxBFVvhwmWQ3stMc=', 0, 0, '/Bnr0LzuvfKeZdcu2sCYvg==', '2024-11-13 19:36:25', 'admin', '', '', '', ''),
(149, 'ibFILI/Vr+Bub/pWIF81LMlpt7gkqOPmRNatjMG2PPI=', 0, 0, 'Ta4ibBj1F09zgEDUjnVQsA==', '2024-11-13 19:37:15', 'admin', '', '', 'nz6/cZe5mdwv9etn6rtpmsfLKt13Sp4qZJGrGZgiQUY=', 'su6t6U//gJKbgpiz8TkT0g=='),
(150, '2s6g8xYJgjhCHKseMWrXNJpsb78FhZFCfAcY/pB/IFk=', 19, 0, 'd001f5lfA8nz02iBEO+3nA==', '2024-11-13 19:45:15', '', 'ji+MfEXlTM657ho/xpTLd2iMBKa02XeXO4pNiPBQqhc=', 'so9eTDohmQEE+wRGp+RJuQ==', 'Kj7m8gB4FIn2uAQQughbO19k32XTCfS1joVrxyn7FaY=', 'fdw1mtZNF3cCV4GcFqC9Eg=='),
(151, 'H6OtYsHwdZdFmPthX5izgAJv4Oem8wPrmp9e4hxoPGg=', 19, 0, '9xO8Sq9TUQztwK6ckpQutQ==', '2024-11-13 20:09:58', '', '4tza+I5gPVvC8BXSEU4NUjtw5vqZKydPnaWJisolRQM=', '6/61GAevn6aaaxSimltq+g==', 'MHNihZCDsVr7s5m+OqbHUZeu+hkCjXQiHbQigCKjZJk=', 'Eipg+28/lSaLAHaSvrfT0w=='),
(152, 'IGT8M6JAnnDTEFUNABTV/Kljaj1Y9emfl+Oz6Melzuw=', 0, 11, 'ICFtXljPqIF/90zG7kEdng==', '2024-11-13 20:10:43', '', 'h1C8UlAo5i5DiqbgVUdNYcsvEFwiUsCRM4OHDoSZHTU=', 'b2Ve6bFIYW0HBvtKxT0J/w==', '', ''),
(153, 'TWEtMNJi8vzRH6yatM3wYb6+eBsrFbue6GTnMFRAHac=', 0, 11, 'SRUWhwIHiwNQnijLbVargg==', '2024-11-13 20:11:35', '', 'M74a0kyKO4NMOhJUktu6GwT6orRwLy0f6vbTllBmKTw=', 'gN2iNtP3IAmvg6Cb4u4Vcg==', 'CEgrXKG2LBc6kUhXvaMTS8ZcmUhTvC3Kr93jgSNHwZ0=', 'pJwiL1NSMxjNfDpxl67oJA=='),
(154, '1oYqh65gOyNu4P5q4UWmGHr4fEax+UkrlbXbgj/SvAA=', 0, 11, 'tL2FjcRVK1uEjSGkgYWM0g==', '2024-11-13 20:12:18', '', 'gEX6Zz1LVBsaJZQlCwVZQf+A9svneKL2c4HTofsrFYw=', 'XJADmQi0WqDaiGOZlwncew==', 'brArmdcIXwgNVjRMsDtlCnjlxTYjFUeOWkQ2SVQ375s=', 'WNrydLC0IPRquBEAXBr0dg=='),
(155, 'w5Bp/ywdbpcZIcW53VeA/IHB0MWpH/aIob3g7si0KmE=', 0, 11, '9Xt6Zp7TCddoYlCMkT4qLg==', '2024-11-13 20:12:28', '', 'ou8IAoYwBAsDOs3TJvnbmXgNmhMJbDw+tQbtZ61Lpsc=', 'B9FYpdMz7QIiydnWdKnlJQ==', '/XiIbKU5GlsKqNFB5tI4U3Ols3FpEIkVckFEEZjxSps=', 'cHBjvdp6dXvUOK5hvn07xQ=='),
(156, 'odqv2jvKiE6Ewigl6sr2hQ==', 0, 0, '3Lj4NnK4eI/G3KxQFOH6vA==', '2024-11-13 20:34:23', 'admin', '1BmNIE+IgFXFPXXvep0iJ+MS1kTJPR0RA3PahHEQRC8=', '9GgWIKKqTPxoWazwZlbMYw==', 'kssEgxAXWmhv7I69hVPlmP9PfrJmJFlPa9wD87D5leM=', 'ex57f1GIAUYaC75FA6g+5g=='),
(157, 'FOuNNWaVPki30xicgO5P5Q==', 0, 0, 'qLIo+TDEP7H/Qfs3xHO2jw==', '2024-11-13 20:49:42', 'admin', 'RGKvPrduGyLCb5l15oQZ7aeMGxSTjlomtV/itMe/PGM=', 'LH4R7GtLYrttr/OfyDeaqQ==', '+AtUI9F3IdR4qGfjHnXFfVl1plo11jBq1DlHFiwW0O8=', 'XkMGBmWTQd73rFuAWVIx5w=='),
(158, 'tf1H1KLoGlWNjIQ5NBqaqy65nQX1XDTVEGY0HvahPD4=', 19, 0, 'vy+btzUAjruG+XdDYC5i/w==', '2024-11-13 20:50:08', '', 't+PSmj8ZQmKUFiL628zPAZj3O+4T10Wu8Z24IR4NthQ=', 'peCI7f0nsz30zwhsSl1SKw==', 'f/kbyB4NV+uC5WXWUHdwa7rs3MUshpU+etF55jPsqi8=', '3Bv2WkzODHr90xOydkchcw=='),
(159, 'G9313JzYeYT+bUVM5c4bYiVOFY8wUZSx2hJRF8W6xJ0=', 0, 11, 't7pooaWsvWpahgo3wXhkbQ==', '2024-11-13 21:01:16', '', 'rryL/nptca5rCJER7PTbCzDIZYSbQysolsOAMO9sRHU=', 'EDfngoW3TpDhUCi6kshVog==', 'jzv0jHjfy+3EYw7/MngRvpT2ckRIwJLpZ0ppoRTKOZY=', 'Z3R+lQyqrwNOIbt/KCvPjA=='),
(160, 'SrXMeuNQ11WBRJ2eh3mKXhz/evVpKNZ5UhGZE9YHs74=', 19, 0, '7LGuygchhSiafC9tx9EL7A==', '2024-11-13 21:03:52', '', 'gmBoydABkQSxZM/NRYXY9PHRR4hL+MDJlGnMCfPP+0o=', 'LrsdqqthG8fuJA08z9EKuQ==', 'fL+1wEIRiGS6u83oq2tMf+b6Na5AKsjRNGQf3NCsDs0=', 'N/G+n35dSkFDbIPMbGtZNA=='),
(161, '9BKbSTcHXQctwOh1cerePB/jyLPVOwPZDsNqZ7VR/pc=', 0, 11, '6TbP9zeqrmYSr88QHwohEQ==', '2024-11-13 21:05:32', '', 'Es0EGHF2+/dbOU7l020cgE45M/9soiupAuOcbvnJdD8=', 'klrO9FV098ZpgU1YM3B/sw==', '', ''),
(162, '0edENTcU6lVgawNtvHEED0WUEv3CeungxJ2WvPdfYSo=', 19, 0, 'vssa4+QM1hT03SburPSdXg==', '2024-11-13 21:11:17', '', 'MET9OmOZjoOfjx/B9edK6JIgyfYIgQP0RF7Z+NWUxJQ=', 'aKnX6XOFBbOqOzIOuYkjOA==', '07AgJro34LyPV5nrd6rHBDBBvRBTESiNablCwtO3nQM=', '286hh/Kc4tv9B17CcU9dkw=='),
(163, 'RDcHWWVJz/JGJqa2qY5v5Q==', 0, 0, '7RxR72lKcVZ/7oB/E3/ZYw==', '2024-11-13 21:33:16', 'admin', 'mptC2o9pjx+DrZGAyknQ6OPKwZyK6G1KIL0x5Gy7DnQ=', 'HC30x2NcIkPqu435sVCAYg==', '', ''),
(164, 'XX+5IcHAFE9D4LxSvMPqMQ==', 0, 0, 'j/CUd49L970l4L+lwpQspg==', '2024-11-13 22:58:29', 'admin', 'CSuxGOO7CtOJW4u4rVVWqkcXSl03EkowxT8dcfoFJGA=', 'K2CUemjAMnjXrKiESLKfHQ==', '', ''),
(165, 'QiIzQ3nxEvZ1uKKep3owIRK0rbmMwxza+JxAvbRwd/U=', 0, 0, 'rA5ZXGauuN01BwLUWfv7MQ==', '2024-11-13 22:58:53', 'admin', '', '', '', ''),
(166, 'IYqVFlwoGuMSLMZGOM2lGO0yg2orcBFkFYYoSixdVHc=', 0, 0, 'O1cavA+Qmu3tXilfwd/o0g==', '2024-11-13 22:59:43', 'admin', '', '', '', ''),
(167, 'z39edcPc084mNxp7Rgma4OqcV5eBVXawcfiJvq0usDc=', 0, 0, 'm4X5k7q6zRmjU+N1mLMqcw==', '2024-11-13 23:00:09', 'admin', '', '', '', ''),
(168, 'hiACj1L/BvCJiCpbbJDjaiijrVdrWXy/pJFGGHNL/d8=', 0, 0, 'eI3Ca8EnJDLVBFJ3Foq79Q==', '2024-11-13 23:02:13', 'admin', '', '', '', ''),
(169, 'BB25rAPOxUpAw1/46ZzX7w==', 0, 0, 'j4zOyzrEr9tBwt/C9asrjQ==', '2024-11-13 23:40:44', 'admin', 'Y/tufXrTUtt+lWOMbHryi/asF3bk0mH/k7ioGdfiOII=', 'zMd3i0ZLNBZ6nudwTOk38w==', 'bLkiYxjBNGbiBit6Q5BNblb2CR61m+ODiFw3RH/tX8M=', 'nxfjvfjBhnDMiXcl0P64gQ=='),
(170, 'QKwyJESmFYq7HrbeD5ZCkQ==', 0, 0, 'ikMqvr9fODb5UJOq/j7oOQ==', '2024-11-14 21:12:17', 'admin', 'iNh0RMuYPrVYct4b2vq2kDKomQCKoC3Tt3N4aZ37KMo=', 'KYrNXaQKXCrfGBnEl9yElQ==', '', ''),
(171, 'Zx3EmnMVz2mt1lNnFdnicym9mdv+ojR2zA3+NE26Dak=', 0, 0, 'vNlaRvZkydv2IGpZsbeDMw==', '2024-11-14 21:12:26', 'admin', '', '', '', ''),
(172, 'zByVXAeWEMJL0Rx88UbUERWQ7WLLKxuRFSaqk+Zs57s=', 0, 0, 'nPl3kUjaLweRzmo/8MXARg==', '2024-11-14 21:12:30', 'admin', '', '', '', ''),
(173, 'KPAQWzdKcvyBjF3VNjoc393Yd0lWAwWs63kslQYJ1dg=', 0, 0, 'FfRU5+smARyqFUMqpFASjg==', '2024-11-14 21:13:11', 'admin', '', '', '', ''),
(174, '47GpxYZuh28VLQzXYT5npDlIovje77vouqjJko0xFCk=', 0, 0, '4aFfgPKzaRWemhjiRpoLCA==', '2024-11-14 21:13:49', 'admin', '', '', 'mqH3SrVe5OKrexkQbLZP4hjQuFw+BSc1iWjIGHaDVDA=', 'Uw5QDvVmSpS2ad/DpKkxPg=='),
(175, 'f8SiPJmQcuk8qqbdGQpkeA==', 0, 0, 'B5AO+ZN0hyiMGd/lB43CdQ==', '2024-11-14 21:14:40', 'admin', 'HTqRhq9NVW2Z8RhTzE94EwavPSqwp9qWAAAwg5wmlbQ=', 'UafbSF8LPrbItJ3hJoablA==', '', ''),
(176, 'dUMguHgL0PZwkzfLwHwGvt0yOrMzkcwPwP37BWDMk7E=', 0, 0, 'v/M1aM7tgb1IhwgmtkC3Vg==', '2024-11-14 21:14:49', 'admin', '', '', '', ''),
(177, 'jeDgtNIha3Hqemd8oqz9d9oFWnnOwJ+W4PZU0yQHZpQ=', 0, 0, 'LDVUQ7ADhKV1dQkKId5luw==', '2024-11-14 21:15:16', 'admin', '', '', '', ''),
(178, 'UvcrM9BnRF22Vu9C27pY+kr3TdHpG9Zbr9235GYQIvM=', 0, 0, 'IIW2nUGkqkP9vrzqUE1g4A==', '2024-11-14 21:15:31', 'admin', '', '', '', ''),
(179, '82zxZ4tJwPtPIgfOD8tXilslmi4Uj7ud3X8Uk7qpl7s=', 0, 0, '29k7zVQ1EmrrHS/K4AhQrQ==', '2024-11-14 21:16:43', 'admin', '', '', '', ''),
(180, '6Y37wm+b+BmvL0vr6LoDXnSBW1Kk9Og4+y8WDnLTdHU=', 0, 0, 'KO/zznO+cSOBkb7ZPZWSCA==', '2024-11-14 21:16:53', 'admin', '', '', '', ''),
(181, '6j3myPQq+tBtlJPhK2SQvv59fkkB90viuJAO8UdvRfc=', 0, 0, '1cFqBiU/Cz/GW5oZtAr49w==', '2024-11-14 21:17:55', 'admin', '', '', '', ''),
(182, 'DBA6KUnsCdn8EmboeHRtwCZpPZM7Num2+ulfRLb6h0o=', 0, 0, '+jytmenGEfkpEiJkcJcRLQ==', '2024-11-14 21:20:44', 'admin', '', '', '9PbcyqDJ/LnxsZ34TndVlyRuLXhNjIb+AlIu+MU+ixg=', 'z1HKF+6dKPb7Cmse9fiMvQ=='),
(183, 'dNMixLBqMHmAIkAIt5taSg==', 0, 0, 'G76L0rp3+BC71fBPRG0yZA==', '2024-11-14 22:40:09', 'admin', '25LpeB4ZqcVx0Sf2ygoGMvlI/rnN5DrwXI/2gac13EA=', 'GR6Q4HIoNmUcIB2yhEOrTw==', 'zRq6xOGjiYsMROgBI/axU2XkHbNkWSpjeGEVdgaU8aw=', 'cHEfI7fUzM3LKgvnchAPIw=='),
(184, '1/Dcmafgb1ZCcDf+5Kp8XKdZn855j5iV6lst9xdnM54=', 0, 11, '4QWCZtuBGklBGwclWLd01Q==', '2024-11-14 22:47:19', '', 'BiDAflgqF9tkZ30NJcE+t/f2r0won6ry1DRKLH2QvHU=', 'toQpqUEDeWMUtwgqeJ9lmw==', 'IO9dXQuG06xV1RxslcX3ZvT92vcWVwfyO+941zXPcNA=', 'eVeYJYLDXICqTc13RhDTFw=='),
(185, 'UK4bkcTvZy6oFKrfmCpxk2c08qVTDaOME8YyX7+CiRI=', 0, 11, 'bAbxOmOahlQzFr4f2YXsRA==', '2024-11-14 22:49:40', '', 'jVMAJohGV2+G4IcUrm8TH1EiVsUtDctq/l9AHUMUuDs=', '7ieTDBaAl3ErCElkal7stQ==', 'RNd8GSP5J7v91qwqsaGwSTlnVXkVsbo+GXAamkyCICU=', 'Nx0X2cKaUTi8yKk2hffPEQ=='),
(186, '6MvpFdWW3DQlD/aLBoO4mHY8pUi1EsK5xTx6AEsujgM=', 0, 11, 'hY8msR+MeaHJDzEXTqQMnA==', '2024-11-14 22:58:11', '', 'ETprJ7zHEV9Hv4EPxV8Gnyq0kNDjYGjsK2jFdTkR+84=', 'gz3Iq50Xpo0/ALQFgfIXfA==', 'kCzUH3os3q9cXvKBF8cq89xl4STILCqC5Qj+iKgVwZk=', '1rbxjCROm3B8LPvGu0xXug=='),
(187, 'yT3QWLxb5uOmHbgY3HcGVw==', 0, 0, 'LythPo7mYMC+IGaEXt2u/A==', '2024-11-14 23:00:38', 'admin', 'J19DMjuJDQ4sicxQsEQEsW1p3ydW3VnWNKaoj6bp4u0=', 'maDZOlX3fS/y1js0cOnQag==', '', ''),
(188, 'Dcxq3cvbL34jtL7ONRyEeppA0dDaSzXedfdhvFIGnxk=', 0, 0, '6qGXAl/bMQ0uZ/rVBvYRrQ==', '2024-11-14 23:10:04', 'admin', '', '', 'BjYiTXRazNGmIVVe5STfXUmrbOIykNdXboc7motnIK0=', 'Kz0H8Rku8Zq1ymdd9vkzig=='),
(189, 'pmT9Bg0atHH/s1vubm5kCa+F8v+FA2zewBblIvVqOjy7a6OiX1eRV1LvKwtU3ci+WXWHmbRSNjNEeWWOaHjC1w==', 0, 0, '2HKMJ+OJzcRQ3kOLcQHiRg==', '2024-11-14 23:11:51', 'admin', '', '', 'hxno8YUENk+NtQjKtJgXn+FYuSBSMUZfWvoKHSc6tSY=', 'Ww7zLNCEFx5UJrC4ttxGWA=='),
(190, 'IJjrg1Y0Ijl8eWml9HzFTeCuGkF1TyBo7afGOE5kG70=', 19, 0, 'uk0ijvOnoIF/8nbB1n6mHw==', '2024-11-14 23:14:04', '', 'N92yyHXF69hmlpzW25QHQl2/g+sJQJEjHPRV7ZNGWIs=', 'TM6azrUsswvFODpJ2cAsQQ==', '', ''),
(191, 'MdWuwcT3GkfmrDrgPvGFsFRYR2Dxj2ZV0EqSuOwD3IRETq5QrwLijhYk8kA9pbIPAP43wtztJN+HfEARmWaAixPLWFvtmkWpBePQCldc0XM=', 19, 11, 'KiuPp+iGPwyNctJvib/MUg==', '2024-11-14 23:14:29', '', '', '', 'FvmbK8GDVkiuHo9Ierz1WXuHd/O1XHiW+PMhmDv13LU=', 'qFfvpcJ7/do5uUxA1wYVDQ=='),
(192, '4juBrCNiXnlM+7gc2CBev+G9BPpMm7i53eQK0CPfBoU=', 19, 0, 'Rblr4yBIVFPmIl8AdfzI8w==', '2024-11-14 23:17:29', '', 'f607lq8CXJMjmM2DkW5G/moHHbr0gVzl7apxEw9UIZM=', 'xUkKxUufUiLe2x60CryGVA==', 'kIjvJ2IuPfaKosr3c63l89ZcIC/5ap3put+46q1+xLM=', 'qUWArF0N+fXYkBSjmJ5AGA=='),
(193, 'QWrjIdmll71K0b51NlmSgst/OvoCmjkXC76+qHlG5G0=', 0, 11, 'bAvQU9cRc+SjZ3tToXj8AQ==', '2024-11-14 23:18:31', '', 'ePibR0qJinT86gV+g0uRk61SsxCt21lJDSvgIlwVcV8=', 'Fn3ZOe3ipZic7of5xj+BGQ==', 'fxt0kgAF60T0VyGa8z+ATljOCRG9u5RzACTtCmlmu9M=', '0Cb003YTS//5dQBgj58KiQ=='),
(194, '+vsinVjrP3coq/ZG7hJL/g==', 0, 0, 'LJ9n1rh/eNlhDglVP9Iyxg==', '2024-11-14 23:19:07', 'admin', 'HyQItyfCWzhcSvDSoqEn6JgJ2keejrt7+4/h/CshhOU=', 'auCT5KN+YLkEvQPx+Tk7VA==', '1aRQxYO2vcQcXaIlwyqnSSueH7ntlsC+LPPGrLd0A4U=', 'ry9J9SEUw/fU/WaLjFKh7A=='),
(195, 'u8BToaqCpvkps17pMc6pjVRAl7NGtcpppcVja5i2YVc=', 19, 0, 'nXXimMILyou/QYPE2YXUBQ==', '2024-11-14 23:22:08', '', 'jvJcat7eY5QqDkWmUCg2wFpMTR5NcEiQdkeKwof6I9c=', 'VmRJazY+gkcBqJdZbKRZ1w==', '', ''),
(197, 'wGiKcZhTiVzyf8hl51E8Cw==', 0, 0, 'NHM/k2gdJJBCxEp8qXX7DQ==', '2024-11-14 23:22:48', 'admin', '9uTOdBDxA7c+1A+271OOiMXBTExtWneavm2hBlyEk/w=', 'lPqyW68gdQbtfjZMkfPvAg==', '/PBOhm2wX9CfHiaRDRUxyjUB/39eWxawRs41y3emaw4=', 'keNb6ZXiOFO6myhKxcj7SQ=='),
(198, 'QvX5FggIRp8PRpoSOKCN+xvw2wFkwcyNU20aEaqcJ5U=', 19, 0, 'pZIvpmcQqOHAkIx1F/vp+A==', '2024-11-14 23:26:38', '', '7saEXyAXKGJhG1Q3TTECom1NVyks3sBZ1X0J+Ti4jPQ=', 'NeEGgAnnIemrVm2HFKkTtg==', '', ''),
(201, 'ctx/HOx2SzWsBD+8mAbZbqgXfFy2E/GExeRUfbJ7Qfc=', 19, 0, 'b8mpDWIPWmsvywiih7kxKA==', '2024-11-14 23:28:31', '', 'jn6o0/4uOXKYZZ0VUvdSByKkoFrutUFvnsB09tjIYUY=', 'ew5bCnkJWOQ7LkX2Ji309w==', '', ''),
(202, 'nbRGYF1dsR/EpdWGkKXrbUhGB7T3LeRHx+kutkrOlq9CKTzXXFKDT3aL94n7yEyg4q/lrG995ww+8zxKjOuBxDkWU6mpUeQdcDm97622DOE=', 19, 22, 'Z5fauxSPfzVIZI1RW9CsBA==', '2024-11-14 23:28:40', '', '', '', '', ''),
(203, '7z6s0qYMypLaVSPcIp1jzg==', 0, 0, 'mb/jTFnuNXpdkJQDjdkHQA==', '2024-11-14 23:28:55', 'admin', 'SyhGsjtv0amkt42R4C7DX6wEPaChVV3LRUz6C8D2mto=', 'm43Ilvc4GeOaZOjCooeQfQ==', '', ''),
(204, 'QLQzzhyt7PyJShVuXsTV9S+Jrbh8Jnrka5I0b/zBgkE=', 19, 0, 'utWiIIJMdUDoOtRSsCZVZg==', '2024-11-14 23:53:41', '', 'IvUFxuq3dvgZytONAws11Sg2tEpqIFWpvdgMs5GRzNg=', 'IL6uzaIvNnv7C9hWC8s+5g==', '', ''),
(205, 'xhwq9YIghcgmczkUrAz3u0QBJexQgoFKUY63zLb+N1GO3MAhV3daNYLvc8j2Cu2WzfsyU6DEpM7UuTPXqh3TtA==', 19, 11, 'QGIBHvmfi8fyjDvFSrPWSg==', '2024-11-14 23:54:52', '', '', '', '', ''),
(206, 'oYpr34zzdzOrv1rZsYi4Hh+YRbDezh690lpDz1dW+jc=', 0, 11, 'kNFSKMc7pbrpeKof28l73w==', '2024-11-14 23:55:25', '', 'KeGt4GWFbmoqy1lEPhZg1oL0NdxzIWotMGDyWPFoquo=', 'yxd8U7mEq4wLSq3EEtrvhg==', '', ''),
(207, 'FG1IlXHfW0VXavMlUkznOQ==', 0, 0, 'jShfb6ih9QJTkZU60NOvlQ==', '2024-11-14 23:57:13', 'admin', '6MaoM8IMZhgbU6qxIHyYeNsMUAPe1sKLSQMBHleWSYg=', 'KXFbeA0UmJgzNzeULyZIWQ==', '', ''),
(208, 'XuzXdHe/2tykwD+8iPetTsVEq9yjU5wz9+m2QYexuRI=', 0, 0, 'hFvnQZMKcZcFjUHkfhnlxQ==', '2024-11-14 23:57:46', 'admin', '', '', '', ''),
(209, 'rm/70AOXftGFwgEzlNLojOeciITZHBArEWGyL8zDzIc=', 0, 0, 'j/IK+VKv2YHQZe2aPbYeEQ==', '2024-11-14 23:58:00', 'admin', '', '', '', ''),
(210, 'hdhgflPK484IZ+B5z7IfQ4y3v/2DN2CK8Imw8Rlto9o=', 0, 0, 'RyaG3CkKD4lUmdmhX6Vu0w==', '2024-11-14 23:59:33', 'admin', '', '', '', ''),
(211, 'bu3nD1HL3LTFaunDONc16g==', 0, 0, '+fdNIIKJfuabtKy6kHWrYw==', '2024-11-15 11:03:46', 'admin', 'OrKiLzYZsxMMoCDjd8pQ+6+3XU27KWnNlX2URRt6Ihc=', 'AP1dW8z/t/s9rLhBP3IFfg==', '0', '0'),
(212, 'UiKh6XHocbAvFEETfS7D3PuA8OiSuhLlMrMkoP20QHU=', 0, 0, '1oXRGrBdWqlYzfzwS49iyg==', '2024-11-15 11:05:38', 'admin', '', '', '', ''),
(213, 'FDLlZ3pWG6BPufrdhNrIZ7TD2N8ZfFcK+c0iikdUsS0=', 0, 0, 'iDWGDkWhUpmR339OsddVdA==', '2024-11-15 11:06:00', 'admin', '', '', '', ''),
(214, '9Tf29NqFkOlcbyCZBbB0tnaC3O19ykZI6gfNL6ghM9Q=', 0, 0, 'Zk/4vZWpViDCJ64IJDPveQ==', '2024-11-15 11:06:12', 'admin', '', '', '', ''),
(215, 'uMSjmQqEJlAMMKHjDLXaoEDerFzV+K4+PO4rTq9KW4k=', 19, 0, 'QvUZ/sn//7uWCt/IkCQUiQ==', '2024-11-15 11:07:46', '', 'lO/6MxfcLZ/CgJ5Gt7nLNtfYMgZ/9QX14+mmwFr0DUk=', 'ybtjiKLQ5gSrfelKe0Nlcg==', '', ''),
(216, 'Lwf5tLwGatwg1AqVn68S39xubTq186I2kB1UV19sLKj/oQ9s+K5Qk133cVsETl6maEm8ZaAfoB3S6cgPBd155g==', 19, 11, 'BXEDusGa20LHq8xgzZ100g==', '2024-11-15 11:09:42', '', '', '', '', ''),
(217, 'jyw0F/XXg3Ut/7sZzXUeV66IKbLq7xK8UaH6TlCGLaQ5WD0+IclNweMMYvQDFPo4YnHXqNdWYTlMr1cON/pEIg==', 19, 11, 'jNb9iFcnH0N7010pLkuukA==', '2024-11-15 11:10:07', '', '', '', '', ''),
(218, 'ow8q0bxU3gWPFG2c2yZrautsEzkWbOJB/jKRVX0TWvyWOOULteEq4oz9a+Nv7h0YT09PoBlomnQSIYddLLduAQ==', 19, 11, '4ORbrE0Orgu6RFSPd0YHqg==', '2024-11-15 11:10:44', '', '', '', '', ''),
(219, '9nIi3b8Y2xDsHyc8PIpSvpRalGN1YwjqyXxJ4opsptXhFI5Zp8QZ7xxQcWt3xpskEV+/gTqj2022xkU6hbNLcg==', 19, 11, 'ilOTm6/I+I8SuJuRmzvBPA==', '2024-11-15 11:10:55', '', '', '', '', ''),
(220, 'Z0Jfzud6ZS86qVMi6ck4SLTWBnbKhzjCdN01MyMXXGzxfEQAf2AvsNmbqcB/ptizT1rEhwpN3on/bf6f8m51a6ZH83lxO0blKjzuIeqUUB0=', 19, 10, 'Bjm5sVk2NHV63EO+b1Wt1g==', '2024-11-15 11:11:07', '', '', '', '', ''),
(221, 'nNaUCmDV3xe4vlUMUavPxOaGtsKZGtuSOpY2BxB+cVjL1uPrkWXBFuRgMv8M5cUHPgjHbdZLlKAu4D37DD2nOAAmkW5tQB6Vjy/HHI8YlTE=', 19, 12, 'n9mcNmY44XuVF+NJmJ74ow==', '2024-11-15 11:11:51', '', '', '', '', ''),
(222, 'sr3xIaIqFW5uaSbgeGMpsA==', 0, 0, 'A1wQXJ3Xj4Jp7OjH1O77mg==', '2024-11-15 11:12:21', 'admin', 'f9NOvGlsfeYdoam3we67h/pFyHfQ+3sJDUcYosG4+ks=', 'PB16yqODTnsi8v/dT5MVRg==', '0', '0'),
(223, '+QfmwVX+jJq9i3Rt+vSnPt2VefxeATVlUWfev2RDxZBuRIWyW6kuquW3cnST2uztHq/jRR508nrPCvjo85WAnmRz+OiGf5EiDgSaf0wzLDs=', 0, 0, 'LB7tCA7Qg/yweM9MXDCdyw==', '2024-11-15 11:13:53', 'admin', '', '', '', ''),
(224, 'GV/L3XlZe8ePLwgRJ56TG4fsC5c7pNRy0bNn54SxkME=', 0, 23, 'vG6becBBFmzYXrSM9DBd8g==', '2024-11-15 11:15:11', '', 'PQ0r8NdnmjzZVDdYiEKWv45xpbWRNquC530NNewa0f0=', 'JSy0In9W0m/1UuPBTixxJw==', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `admintb`
--

CREATE TABLE `admintb` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `csrf_token` varchar(64) DEFAULT NULL,
  `password_iv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admintb`
--

INSERT INTO `admintb` (`username`, `password`, `csrf_token`, `password_iv`) VALUES
('admin', 'DOAQTZCJOtlQf5PWa5O97Q==', '59d8c415ab192c6dc47909d3f92de5c83c20e94bd5ec7954c02b5c94040938a4', '3s4VOxbId2WbSmDusoKFQw==');

-- --------------------------------------------------------

--
-- Table structure for table `appointmenttb`
--

CREATE TABLE `appointmenttb` (
  `pid` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(500) NOT NULL,
  `contact` varchar(500) NOT NULL,
  `doctor` varchar(30) NOT NULL,
  `docFees` varchar(500) NOT NULL,
  `appdate` varchar(500) NOT NULL,
  `apptime` varchar(500) NOT NULL,
  `userStatus` int(5) NOT NULL,
  `doctorStatus` int(5) NOT NULL,
  `fname_iv` varchar(255) DEFAULT NULL,
  `lname_iv` varchar(255) DEFAULT NULL,
  `gender_iv` varchar(255) DEFAULT NULL,
  `email_iv` varchar(255) DEFAULT NULL,
  `contact_iv` varchar(255) DEFAULT NULL,
  `doctor_iv` varchar(255) DEFAULT NULL,
  `docFees_iv` varchar(255) DEFAULT NULL,
  `appdate_iv` varchar(255) DEFAULT NULL,
  `apptime_iv` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointmenttb`
--

INSERT INTO `appointmenttb` (`pid`, `ID`, `fname`, `lname`, `gender`, `email`, `contact`, `doctor`, `docFees`, `appdate`, `apptime`, `userStatus`, `doctorStatus`, `fname_iv`, `lname_iv`, `gender_iv`, `email_iv`, `contact_iv`, `doctor_iv`, `docFees_iv`, `appdate_iv`, `apptime_iv`) VALUES
(19, 25, 'HuiZhen', 'Chin', '/VMNXnZptsNIzYwhpSZpTw==', '/67BaKi5jzKmZaCMcTPKtbxvi/cxBXQMI5Jt7gppKD8=', 'WT2121cLRar6lR9e4MNMyg==', '11', 'egD2HOz4lTaWEvP9Ytop4g==', 'RyUwo6c/ytqehzqHFbFQig==', 'Y9FJKS/YdY7IEBxfBBVGKQ==', 0, 1, NULL, NULL, 'xZxp4GLhg0123n1kaf8HWA==', '0MHw7sJPJObNX7EcyHfXLg==', 'uNeQ6APsgRLCOYokqxsGnA==', NULL, 'ff0Lkm8XjUBQBbPgz23KWA==', 'jt3S5ZRBQB6jOqPuKTlhVw==', 'UpfojX4cHZ0hDlUfkCaIGQ=='),
(19, 26, 'HuiZhen', 'Chin', 'mU5Ckls7TKy79bjnPpfNCA==', 'ReLrhGyplEmLkDt46PFqlV7hUPb8BWKHGrGA1t9UtIQ=', 'Glw5hMRXyBCezAUPhhk9vQ==', '10', '4VizomfL/1N/O7KPpb6D1w==', 'yFzQHTLe7VAZLdFPKRh1Zw==', 'pghh9i8oeK5B9ewtO7i4qA==', 1, 1, NULL, NULL, 'o//YNzuNuS2MfmN3K1ZGeg==', 'MkzpGaa+6BSYAEmyLgVJvg==', 'CqXN70YNMBtKC12kOKJouA==', NULL, '6zvsn/G1i9/9NsxvSVK73Q==', 'IfNCQPDLm6pE/pT8UdLbsQ==', 'KMFTD2+wPynuWmtAfqEvaw=='),
(19, 27, 'HuiZhen', 'Chin', 'PTiE0dNIyRJdMqAcegop5g==', 'L7CZwXjE3L6ttFK+WgwR6Q35Cp2BdHcWmmaXrJDfMwo=', 'fdVwq8TU8JmnW60WV+YXYA==', '11', 'TNTtPtgutfX1iBP89iQ6gQ==', '00DDOrW10MXTXoyPpV5AQw==', 'S69qGwjyyW8gjN5+xRoO/g==', 0, 1, NULL, NULL, 'LS4zHH85MzmP59yo8ga40A==', 'xr/48tNJt5QND+9NfURFrA==', 'r49L3V3R+JNXOGFl2egdVg==', NULL, 'kzjocvrmhk0MK+La8mecuQ==', 'pEj0Kcfy1BqI3YqzSqSG0g==', 'R0ErFQtrQ0eprlwUEcJEZg=='),
(19, 28, 'HuiZhen', 'Chin', 'kwCcdFFB6se2NQD3kRU5lg==', 'n/XO0+Xx6FENevsM9APLmAceGPMJR07Z+FgbMavrRJ4=', '508z/QwHUmYde6I5ubDi0g==', '11', 'rwYMNGlvv4kD3Nmwql0BpQ==', 'oR2dxvIQU7r2rcdauX/JYQ==', 'djahVyhSxRkfBvGHfwJrIw==', 0, 1, NULL, NULL, 'oz7odweX3Mfs9whyrTE47g==', '/bwX4/qgxdN1CURODPI27Q==', 'YMWUNc28yeDtwXpfzZv4ow==', NULL, '01/pNXfqDpsEz2vIvX4W8w==', '/tHBw40jHTCaHbXM3Eupiw==', 'iw/OL/dVRAOF9JXOl5PF3w=='),
(19, 29, 'HuiZhen', 'Chin', 'eaguU3wvoXSPn6L4VRqjRg==', 'JqAGOL0P8GqviC7T/W6ZjzLb4Jb2jOzYIE9hMI9BBEo=', 'N1XiZUsSdZkCPmeL6fdA8g==', '12', 'Aind9MDnl6INWe8xeUrY2g==', 'ue9ndL7Vt1PSDIpaoZxGTw==', 'qYX7pgj9IN9trJE479essA==', 0, 1, NULL, NULL, 'XtSh+1wvI2cDeNXH6/jebQ==', 'XD40kx/pZqc41BgDM1h5UA==', 'sE5zjNYw1TUpWEiBwFIJzQ==', NULL, 'E/o2y35eAyjqDtS6VPGfjw==', '3Y/0bX/QwS1NFUWZlsQ5TA==', 'bKRPoOErEDAOD1fGlMuThQ=='),
(19, 30, 'HuiZhen', 'Chin', 'ozwMb82DkIvMGLOtHHaUwQ==', 'VbcM1bg9jVzelcrU+JJs+cls1hozZNApVJgvbes56uM=', '+BkchYVoc/kh0ckMN0eZUQ==', '11', 'jvaKLnbW9znoAtEQZmrBdw==', 'CP+5LJD304NM4Idqfiv+WQ==', 'RQqJUAITas4TlbBA2rdT8A==', 1, 1, NULL, NULL, 'TuI/Xkw27cds2aHSlfjNNQ==', 'sG4WkYU8ZoZNmyHQaZf18A==', 'vTBEo3TKiwnQf41nTcd3hQ==', NULL, 'TJCDS5w93Oz1TVk0b75W0Q==', 'SrKuhKOx1wpAJ0lblyCIIQ==', 'RvnXrsDVgsrddjD6U9f6zQ=='),
(20, 31, 'timmy', 'Chin', 'G79LwRSOaOZn9CaHvGG9hg==', 'YYBMDaQ/Nr2eg8IhZ9WBmyJHDHVJA+i6ccPlRmYcoXE=', '1TweWKyEGbuJ/EtuAFW5rA==', '10', 'ayjmmKSv2IyEi+xSUwQiew==', 'lxErRLoTr5NZQzE3+gmq3g==', 'xkZJpfFBHQn5EsER4o5O2A==', 1, 1, NULL, NULL, '+suCmTK+QCifVcYqM1ws6A==', '7O/5wIty1dp/X1kZ/an+gQ==', 'b62A5dqwXFj+PaIX+SdTIA==', NULL, '5bmkfvl9eu/UGmEjdfHaiA==', '9mcN6vz6bF6Hohey/5+MRA==', 's4nDK6A9uFOYRs2GVcEkzQ=='),
(19, 34, 'HuiZhen', 'Chin', 'JcNRYZPlKLaiZzYkhk0Gtg==', 'dWqOlZumPx8jL71wuJ5TQ0HlHWVVtfLhf/ZM7fVNYuU=', 'iK/e4o4qJD6Eh4TvzbhKFw==', '12', 'xzqvXk4h27E7xUJ1NwjP4A==', '4NRbD51PBCWVqwvFv8QU8A==', '3eI4A9hX3jmHvBHJ913eUQ==', 1, 1, NULL, NULL, 'DWdDEarPEYZ5JGv+EH4N1A==', '1pcwNwucnllWC41jb6n1CQ==', 'fpXl+Kx5mbA+c7aRfCtLlA==', NULL, 'FJUVDLWpQh0TsmAv6rhB8w==', 'yUd0RZje3Zc97bvXf7hc0Q==', 'yD/+Wg/NkxxM+hf43t0hPw=='),
(19, 35, 'HuiZhen', 'Chin', 'f/EbfjpzLCDQJvEqHK9cig==', 'UwPATeM6mB20K1qXKVB0JK37Gou1T+equ9BzEN+QoU0=', '+QxmDitTj5YfEEEwkueg6Q==', '12', 'ZluSVD/x00BeHeFU+Sd9dA==', 'JfaZkbGcb5Ny0oSXGeJAYg==', 'dgI0aLRoSdRkv1dVROkWDA==', 1, 1, NULL, NULL, 's2Tah4cwBUG9Gkz5aTuAGw==', 'uQJxbAB/jldrkhaoEBYceg==', 'ySUv7rLXLy44aX0vu3P9ig==', NULL, '0F+7n+52sT869zPYwUW7KQ==', 'DMSX1UsvNryGXOKEBMmSJQ==', 'IJeMJtLtvlaA4aeuw1XHJw=='),
(19, 36, 'HuiZhen', 'Chin', 'kzU2DPv0uhFPuWjT3/GRdA==', 'PLF/movWc7l12UL5GJYbkr6Vw9o/fjhkxqf0D3zCnBo=', '07qeyPlHj+G4jt9wRKwDHg==', '12', 'wLzVnhb+rBuFAPB7LwtsNw==', 'qByBkDB/JsLxMK6Xwnf7UA==', 'cCRJkrJDelSkYQen2Z4spw==', 1, 1, NULL, NULL, 'h7fcqQr159enKEOnjtGxzQ==', 'XdqfsfCblxe6aMMNr1xHUw==', 'sNoaNtLNe4+L0pmzVgFHiw==', NULL, 'YO8X3V1LB5N5Upda2mUqKQ==', '0SWGtz3yAE70PZijpOkG7A==', 'SJA1aOwMlAlR83ReTFpVbg=='),
(19, 37, 'HuiZhen', 'Chin', 'GCznGNywfPkgNxTgyOlAhQ==', '6aa8an9NI4nVBQNFJe9XTiZJ/gf2fKQZ89FT9kBiIc0=', '/PuaNfI/ZKzAD/7g9thc4w==', '11', 'ku7i9xUVf/FaS3lFZbuUDA==', 'SwwpKCiys8wZYK3/oQUBKw==', '3F7+pO3rTncpWrAbsOTIBQ==', 1, 1, NULL, NULL, 'Fii4g4dWZqNYkA1CdFBXAQ==', 'CZIQ8gK/5xFsWhvYmhBA4Q==', 'z05+ZKQRNJPMG90CauQIbQ==', NULL, 'pWrPodnXLaBcRiuDBcHp7Q==', 'Kok2C/G87RRa+B2YChgpEw==', 'YhXzOXz4pormvRSd63itxQ=='),
(19, 38, 'HuiZhen', 'Chin', 't4BC77Ih73k2e0u2hH7ccg==', 'aEjVJoRUpY/DjsDIhr0f34XuielJBdzeVNLtIrNrk2w=', 'jCnQ6nmMd3PmTJgPS3arxw==', '11', 'tjExV0f3xq8108kdCs5ZcA==', 'W83KMa0Do8OUiGynszWKLw==', 'MZsKUSWUj9PRV0ngVtEbWw==', 1, 1, NULL, NULL, 'wIB3xoK52fHDbMpwGcrK7w==', 'GWQFmfFmf5cdwi1BP/w5Tw==', 'zHsi+HKpXOafr1JPiv/SxA==', NULL, 'YFxG0m2jTJaF63kxL8DQvg==', 'Fl5G996Yw0sdNjBKaaNLhw==', '4cTTiojSvI0quL+JkS3CVg=='),
(19, 39, 'HuiZhen', 'Chin', 'q02oZkWkCsy+fhdMcl/ElA==', 'e/BBUNO+1ar4h3k0yMqXqgzfOOEvXJyoUvLXDOpIjKk=', 'tZgJ2Am59WlajWyQEaEWqw==', '10', 'abRfJ2Sb/6bW4fjBmvqqgQ==', '4qAz3X/4pDx3dJ6GZ4NRKg==', 'nyD8n0AvAgoUE+Z8FfbY2Q==', 1, 1, NULL, NULL, 'gKTQVrzwRRQJ2+m+RrXA3A==', '/3j4Dg7PlfZaBo8NNE0jLw==', 'YfbJ9uhDjyeaxZ9uilUXNw==', NULL, 'BdDZFBQlIate3snOVAzrNA==', 'BbyDu4PVl1Pb9TPUGeR5MQ==', '8i/U2jcItkhMjjGsfigmKQ=='),
(19, 40, 'HuiZhen', 'Chin', 'Z2ZUO7f0mbLOVGV/zIMXIQ==', 'LQNz/QFKDLkVPeku5iOKEYW5CHadti1bmduRHNiA4kg=', 'ZhsJR+PT5DFQxBjrETZRGQ==', '11', 'K/aWb8qb5N5kcIdbzrYgrA==', '53TPBL/O7dxAcPFnsA4cpg==', 'oA/8jMOGJAaZwV7jxIyu8g==', 1, 1, NULL, NULL, '00XP17QWg7tu8R4kYy7mjQ==', 'Ywd8JG6sr3iaRVjbMb9CEA==', 'uksT1KgeKepYtZi/vepnVw==', NULL, 'mBuSiZd7DmvzDHuhiKxTDg==', '2RxH7KOL1jtJeaxalmhyrQ==', 'l0oy7H8FHnUW0cFoHPp68A=='),
(19, 41, 'HuiZhen', 'Chin', 's2iDcDqa2GI0ZCIkZxrdrg==', '1qVZG/SAWl2Qfxsp3FZuRkad7/mvgirHzHgvpLB1Lq8=', 'U8CdNdhLkrbrkIz4hb42YA==', '10', 'sYyH2CT5v7P79C7YDfW7zQ==', 'eQAJEVSjTFRdgDNosJCByA==', 'eRL2h+7RcL96Kbm3ywgoRQ==', 1, 1, NULL, NULL, 'py2AurIliAT45rTv1Ihf/Q==', 'hJqcv8csHLM6EULA3S2JHw==', 'j5lvrmosAzdwyz/aYyaO1A==', NULL, 'j4dGehu8MZ9GqUzCKPQ+ww==', 'f2EVNt4Hzqngsk3X6MOV6Q==', 'bLTLX0bAWl/HYVv/GaLdWg=='),
(23, 42, 'Jolyn', 'Peh', 'Kv0FzGdIEdJxilJxP8FH1w==', '1W/jQTKhaCeI7mcxQnztqVIRtorXVoBfIf7agdzJI94=', 'r1aHZCl+O/BWGPUn+cHbaw==', '10', 'skLK4DSsNVOwGgyfg/nuJg==', 'cyrWY2+nDehSBbnVcEgLlw==', 'J7Yer8nMNWT5K6afgPn+Tg==', 1, 1, NULL, NULL, 'QMQo8Ol832biFsCbRvUq/g==', '412Nsiu9ZuN5AsY2EoxzBg==', 'GDcGgeu4m8lgctX2mWCm1Q==', NULL, 'tHI6CPvzpA9k0zeyv3AqAw==', 'zZcesnef5SAnY3NUci4IKw==', 'ecCkLSFXIl3BZNfhKdhVWw=='),
(29, 43, 'Jolyn', 'Peh', 'NPRZr2URfWGxjnNrZqwCjQ==', 'sVVh+vOrDWrxKmReELWXjMbRW3aTTRDQmoWHi3GUn0k=', 'SG1SVJROB7ARvqWJqHSeFA==', '10', 'hjr1jreo5RA8EumN/VR3Tg==', 'UNMIELuhHYAOccT2ss5wLw==', 'VwrT5Ft21nMnyFM0KDxwGg==', 1, 1, NULL, NULL, 'OHYqABZHpPm8IEPTUTmySw==', 'jhxtdqEuXeFDWdWRWN8cRg==', 'q7IXJZwg8wxD2s1BQX0oTg==', NULL, '+e9WoAJcYdeWRASoEpa49w==', 'SFL9eojN8JiivN3UJ8lv8A==', '2h1e1WmVVxyRstMJ1i7fKg=='),
(30, 44, 'Jolyn', 'Peh', '6H5Sz3hopLsSLWbksl0/3w==', '7bOfOAm4FQ8xaTenMgw/nr3ZRq8Txefeec5nbqtl4fQ=', 'X8CElAv84gL5kIAcApQzEw==', '10', '2yaQPrwtT0udMeKBb56byw==', '0g/c1Wc1Wjtug6zo4r1Piw==', 'Cxj45A7YTL0zXqPle8DMhQ==', 1, 1, NULL, NULL, 'IyYx7xmw4LC6Ze3bhKUl0Q==', 'uc2DecjOvONFZlaEDyLmCg==', 'vY5Qtxonyu7BT85Wv3HxHQ==', NULL, 'suVrskuDACVKMY7V2gXYlA==', 'QQvkFt3xBlW+pOz+2LkMQg==', 'CecU2N10gTamjcxJ260gbA=='),
(30, 45, 'Jolyn', 'Peh', 'FKqnYvORr7G4ZkMkMybl1Q==', 'rTrFxtzFDD4hHYHAyc5S1ulEJQSqqU9CgpwNule2vBg=', 'f0bkCyOgaRXF+yWN6nmhRA==', '19', 'mt3l4LvF6SvUwxPPsNekqg==', 'IrD1KLo96AvjeZHsi7TSWQ==', 'JQFmKvRP0b2M1K6DgEoa+Q==', 1, 1, NULL, NULL, 'WNNhiHlho/LJWx8mifbmbQ==', 'XDweNWya2aEUCbR5/TwEsQ==', '+jLbJj+HwW81k0drM7Hi9Q==', NULL, '0ocmzZiP4CJhf6GWf+s9+Q==', 'cKa9KWwbjPABrzpRC7BpXg==', 'JTZW0MFPcwdcKx/3ZgIa8w=='),
(19, 46, 'Huizhen', 'Chin', 'G6Ay5qeiv532xcZD4PBJUA==', 'tmxKqCHaOXmoUjc76INQQRwiQUkvs4oQ++0LUYPb+90=', 'V6EZmGVHnXBNaCngkYOGag==', '11', 'nGkzyABEKrPRu1ex/MzxXw==', 'aBOO1Lef4CKfAt+gfmWJwQ==', 'x8SEns4QMFDSFtIRp1+qrg==', 1, 1, NULL, NULL, 'lZXrJS9yuYfXbE7UebdKNw==', 'ucQ7lzPnV7M7SO++dBpmpg==', 'n3KU1YT+EV6sKMUER2fC/w==', NULL, 'aB3q/+Cpmn9kMFYuEz0LAg==', 'v8bJ1IZHhQeLfLPRVqykyQ==', 'Afwqi2tnToLdbYNxlQuGSA=='),
(19, 47, 'Huizhen', 'Chin', 'X7W6YNpc0O/YWjHdQkJJlg==', '2RyXvExtwq+zLZ0SVLJHh52MnX8CPgF5vVTra9XYbew=', 'wAc1tGszKxolOLXepI1egA==', '11', 'af9QIaBPMiqVslAXGlFiiA==', 'xTwxRJWj/pg1hPC2Iev9yw==', 'o8AfmzZHtfiTL28KE63+dg==', 1, 1, NULL, NULL, '0uLDzuSgVraonsjoGydHfA==', 'ewDg310xoHJR4dLHo4eNrg==', '09q48fmI2Xrerh66GIJC6A==', NULL, '4SwVVOZeAmEcr7cqpUJC1Q==', 'Mqm3npwUlR0H+hPIR+ih3A==', '9Dr5VcMHtTHKxD5UhzqnVQ=='),
(19, 48, 'Huizhen', 'Chin', 'DJrUD6FmzlyivnGbrJRUIw==', 'ttKhwwcXabaO6fTgGUFCsW4BBzYJd/BwPuigJ33Z2fI=', 'KJrZoUNdW4hTSDQk6Z4JTA==', '22', 'gFBaY5cE3lVwnDs+y0p7Kg==', '7CcstA7lQ0p7jD/Y6juoOA==', '8e3fqX1Nx2OXMh3cSaWWrg==', 1, 1, NULL, NULL, 'lFAVYoe+xEb1s7y4sGMEqw==', 'luiewAEm0oDlSqdEI4/mjQ==', '/b698PHafHo3uWwwkBzJig==', NULL, 'Xi1a/ELJscgbJhLzODA0AQ==', 'Be8OvuUnoZFle9++bwmkgA==', 'vrQlSrWubIwIh4MUcjppHA=='),
(19, 49, 'Huizhen', 'Chin', 'aC4bzPJYubzWjQTKDJ94mw==', '4XK2XyndcAS0HQXrBuD/RalL+SaVij1INzaW7THJNVQ=', 'p0U+RtIO6BmwFVyW33mIeQ==', '22', 'rFQ+4cD5qXXeUEAsUzLqJg==', 'GCv5034Hk2pgWlflzlFupw==', 'Usoli8Wx68Y60KhRqXEamg==', 1, 1, NULL, NULL, 'b3l+ouGVrbSdHaPDAwQq+Q==', 'r6E7l1DCw9YZKIy1/aUhCQ==', 'BGts4DOLCeVyjuQKpaWFJg==', NULL, 'KyjcbVfIeGnRXVRIELLBhw==', 'hAMUDBIvkc/UJKh84ziNAw==', 'TEKxpmDHQ8qxPf/v0rzQrA=='),
(19, 50, 'Huizhen', 'Chin', 'H0TK6O3xHVTMDSE3h8Ws4g==', 'Apm+tjsa9qrYlea2liCFBIisd+vXM/YWmLlvGFMhUuM=', 'afBbjklkj4n/ZPFiaz+8rA==', '10', 'jVJYqraVQYcNQiH5tS3YHA==', 'GP1KmioB1xK41cHTDB2Gew==', 'g2LNK0SnEZayOIQ1FEMQLw==', 1, 1, NULL, NULL, 'C6SVH8g7i8Tmhq4A+dSlVQ==', 'edbbAECKChvw2IrAARRaUw==', '/LHmeUelHFBfBMFBQz76nQ==', NULL, 'HQJiMUuWds6SCZXeMqoqoA==', 'sT2X1GozBLSwMdT1A69/xA==', 'oc6C4L+bvkG4QSA2aLfH8A=='),
(19, 51, 'Huizhen', 'Chin', 'Z8Gt0QFxTEiwnvAq6ZSKQw==', 'jiAn1BhFcPsq+4WSIzehC8eca1J72Pyt9Wiz+8NilH4=', 'YGNwuDe6UnUZGqqAvMfJZA==', '12', 'IPVsHfdgT9+E2LwTMTldjA==', 'DV/NQtWRw/2KoWqbhffRrw==', 'YqlMn9VFguUP7lbZp9rF7w==', 1, 1, NULL, NULL, 'CtO1fpX8ZwgOMrQ06u5wjw==', 'B/9VkbCW9fGUQZGcr9RIyA==', '50k470T7L52UBe4DovzjJQ==', NULL, 'U6oaUYNDVnKA7sz1WKbAXQ==', '/UBZIhDs7Kq+5uLySy4JLA==', 'aQOANU0/MpJJIOaXz2SUSQ==');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `name` varchar(30) NOT NULL,
  `email` varchar(800) NOT NULL,
  `contact` varchar(800) NOT NULL,
  `message` varchar(800) NOT NULL,
  `email_iv` varchar(255) NOT NULL,
  `contact_iv` varchar(255) NOT NULL,
  `message_iv` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`name`, `email`, `contact`, `message`, `email_iv`, `contact_iv`, `message_iv`) VALUES
('emily', 'OkAhbmcID/WD8Hz5Ch4sskRXkVxVd5ds0Zjg4EKA4CU=', 'NmiXrVoPxMgoQHF+4/wtzg==', '1XvK+NgrpZOJXb/sSG1ANg==', '7DQE09RttXPzzKatGH3UTQ==', 'qDUTQa/1Q/nWwvcLRUEX4Q==', '2FN9ghJ8XPBSqB4Vly2leA=='),
('HuiZhen Chin', 'oIq7yQAn6APcwEdc3KLDePihcTWQUdFTKgiU4eHH1EU=', 'cUtI01ZZX9lgR13xr3y0Vg==', 'm/EOxxYD/2VzYtjor4O66g==', '1+EdTRpyf2QaQLTBnsqXCw==', 'AbVhkkJP86orKap8XDHnOw==', 'LLm7ORA0t3lwxOpnEjUe1g=='),
('HuiZhen Chin', 'v6jKbv02bul1lejSah8/9hhREVA8fe9AyOh5NFENBK4=', 'T+WDVOtHA5CAsKljU9Ey7w==', '7xoy+RPR3ps3HH+ra1P6Qg==', 'p6k9TqOJUvJ5SvjUpXPdpw==', 'nYSAZIO4STGIx89U50lGZg==', '6wmqGwxK4Gjqk9FSzHy7xg=='),
('HuiZhen Chin', 'VKKNr4/MEYZTXtQnpOQQLPHZIXOmwJCOMCLRi6vtWi8=', '99C0a2ixHre5MTTC+pJNhA==', 'f1BYVWjRZDuEx4PY3P2BCA==', 'iEU/SETlDrbWsp1lKxZ8sQ==', 'RH3gF60r0pagoLtkxywM8A==', 'mLDK7bMyDh/0Z17GIZis3w=='),
('test', '1DydROIefnIKRnm+TMoDqCCjURUdcsz5e7VeSRUZmVQ=', 'RcJL1+huYYoYs+R0Eq1wJQ==', 'JyCsTbQCj46h/YMfXuKNew==', 'nVOP86R2iEF/VU56z5VfnQ==', '7slRPRCAwNMJNEYQUHWmSg==', 'yYW4T7tUruCwyoxrhKjPjg=='),
('HuiZhen Chin', 'SBrxy4QLMY036QQnj9kgPLSImJojAn/6E1fy6JnAjGg=', 'MFtymZNzQfCx3IyMI5AyAw==', 'tKIvYlJRkN6x9wgjl2iSuA==', 'ouPfJoBPebpekEm4o/aZ8w==', 'BtSHztbdwlTm3kGOamV2EA==', '//wJ24b/LzppRcdQUThoGQ==');

-- --------------------------------------------------------

--
-- Table structure for table `doctb`
--

CREATE TABLE `doctb` (
  `doc_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(800) NOT NULL,
  `email` varchar(800) NOT NULL,
  `spec` varchar(500) NOT NULL,
  `docFees` varchar(500) NOT NULL,
  `email_iv` varchar(255) NOT NULL,
  `spec_iv` varchar(255) NOT NULL,
  `doc_Fees_iv` varchar(255) NOT NULL,
  `csrf_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctb`
--

INSERT INTO `doctb` (`doc_id`, `username`, `password`, `email`, `spec`, `docFees`, `email_iv`, `spec_iv`, `doc_Fees_iv`, `csrf_token`) VALUES
(10, 'john', '$2y$10$8dEdjMB4IWSOxwJ.jUmWWObMyhKnXtByJc6EUVHiw3EUXAF9eiZ16', '/5t3Gvo5Q5VxsS51n4hF/pi1hKo9uHAPdIUierCJmKk=', 'H6XMpc0M0xGI7waXW/SBIw==', 'cVsixmc7CdvUJoZwFbLVsA==', 'RGj0iCwwFyTRXlx/xhBLhw==', 'Mds6gbt/T8pQRUfyNRkHoA==', 'jPKFEC572y3B010rrmOqDg==', '2e0c41c0307471cd78be0ce9140884e5b007788b28f1fee5bb5aa0254e598b2d'),
(11, 'johnlim', '$2y$10$tlSuOTouqaOvCKWkyhoASOJBwSmbi7l1kKftOUHUusAUZ5Vyy/ANi', 'QbBU1668s1d1wiw2jWmbFFACkNhu/qJXFM3SzZnrxxHLMD342VlK+/nGXJq6bY9y', 'dSSd2FQzz9RZNCGTi5CnOA==', 'on7gHuBoNhnZzEbSdW109A==', 'aE/E8aPOEhC+pGwEAVq5VA==', 'RzHnww+tnNhaDBPnp/ASLA==', 'Pm6hYUUtI3lQEt03/X4FTg==', 'bc0e195a9612cc3cd98110cc2e094adfaf6a0b59c2d5058433de59ff6f58c109'),
(12, 'emily', '$2y$10$qMZCrKAAzGVO7P/tpVbxyOZb7Fm2wWYXnLSqosIjC78KBfcKtNg/O', '0JUeJSjJdpxyfwk61+97Oieo0+BwKYEbgs7ZSr9UC94=', 'DVd4++O0aVek1omg8/J3HA==', 'AVsh3LDbPydepLWZAk0q/g==', 'EMIXP9URoBDd++gouL/SaA==', 'AM7Sebt20N8C2zhRJ+0Rsw==', 'B6IuT9TzdsAX3HJXbps8QQ==', NULL),
(22, 'TAN YI XING', '$2y$10$20ZcjVzWl5qoUosAEwgMteNXkaYyQ7t5qQXWJwjJbEKvupTsDdY8G', 'aRsk/T0wOeqGpKSHdX+6ADhXKFeIrZNabGXSXHV0kmc=', 'FeYVY1DJC/Kerm4EEzYhbQ==', '/DY3br76MXYkprd69f/Glg==', 'qA7bZjJPdRCZZ5OSoKVFsQ==', 'qN7ms+9TvKvVKCKp/F2lmA==', 'AATVGaCPPs2VhkqRwkrseA==', NULL),
(23, 'LIM CHEE HING', '$2y$10$736eiBPVWtr5PF69YqUKdebUV1A2haJ6ATWBpWCPkqFBAWcA2INN6', 'qwvWa1XQBz5MMV3x9lQSDiVR3BSJ1N8AIiteD02LfaQ8HqqbbGhqSnxBEdIPFR7k', 'RXaKbolWRL/qSNuQ8c3K7A==', 'B9amViaQHbS2lWRH7SMI7w==', 'fTvI7jJ0I3+47DysY3qEqA==', 'MAwGt+lgTB2gZwbbpfCo2g==', 'UHsrXHthhSNy8Cy95lSKHw==', '988fb2d45ac782f285a57cb7163da04747b10a13992f0cef18b3e6830a105f0b');

-- --------------------------------------------------------

--
-- Table structure for table `patreg`
--

CREATE TABLE `patreg` (
  `pid` int(11) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(800) NOT NULL,
  `contact` varchar(500) NOT NULL,
  `password` varchar(800) NOT NULL,
  `gender_iv` varchar(255) DEFAULT NULL,
  `email_iv` varchar(255) DEFAULT NULL,
  `contact_iv` varchar(255) DEFAULT NULL,
  `csrf_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `patreg`
--

INSERT INTO `patreg` (`pid`, `fname`, `lname`, `gender`, `email`, `contact`, `password`, `gender_iv`, `email_iv`, `contact_iv`, `csrf_token`) VALUES
(19, 'Huizhen', 'Chin', 'reuBuFIRrWTD/YbXvmkRzg==', '1LrQJEgtU8dpAI+mAZjTSC3/YHTH9n6GeJM/JC6uNBY=', 'KN8QEBvaPRpIPNC8Wzi0kg==', '$2y$10$xlEA0phy61M8SkbCzURhYuLpiuo6j3qp9Id7fCCgIgoAs.CwF88uK', 'EnWjfenGpt7HYGckhktt8g==', 'cI8no5pid3YZH4iaPTufMg==', 'VcO87A7cLlnp4Hk/ckQ9wA==', '7aad8fc1ec281d7da6d2a5e194e969ba8e8f54e40826f2cde30c934814b7b1ae'),
(22, 'timmy', 'Chin', '+PoZB8FinA+lX5Nrf8YDPw==', '7ozk8oPswuofW48CCdGiKwoCeGck3z+DR6rSNf92aHpvDEZvwK/8OZ3zwjXZL3Cg', 'jbxgQTYvcRN7S+h9IERnOQ==', '$2y$10$j59FRAAv1wFVN7TdBQb21OsCJR8FEQT2c3bqeHHX6Kqv22BERIHvG', 'BTnVU3CvpKPtwu54HLvjNg==', '9KTtn+CGqa3rMiH39PPrtg==', '+yo4yrdTaudH6zkW69bWVQ==', NULL),
(30, 'Jolyn', 'PehJX', 'ynY2hDvDqJeDfwMfT8MfZA==', 'T3TjpLUsD/0F5VuYG3Q5k3FZ0aYlfdz9BUeaRCz2rp4=', 'JI7vVcq+P6kQrEqekgRIMQ==', '$2y$10$9RqxWSBYKqGMsosKV8G8heZTAklBfDIsBHKc.hQeN7q3Rc1DAE2me', 'BfxCb7Us4sEB1gwdNBuHgw==', 'sCRLLb4QvZ/qu+UFNYYGDQ==', '+1wvCckMGvjAC6rNYQL6gw==', '8bb06b1a4f59ad4bf0f01033f23ffef4bb11f521615916d4516b304debaffaf6');

-- --------------------------------------------------------

--
-- Table structure for table `prestb`
--

CREATE TABLE `prestb` (
  `pres_id` int(11) NOT NULL,
  `doctor` varchar(50) NOT NULL,
  `pid` int(11) NOT NULL,
  `ID` int(11) NOT NULL,
  `fname` varchar(500) NOT NULL,
  `lname` varchar(500) NOT NULL,
  `appdate` varchar(500) NOT NULL,
  `apptime` varchar(500) NOT NULL,
  `disease` varchar(800) NOT NULL,
  `allergy` varchar(800) NOT NULL,
  `prescription` varchar(1000) NOT NULL,
  `disease_iv` varchar(800) NOT NULL,
  `allergy_iv` varchar(800) NOT NULL,
  `prescription_iv` varchar(800) NOT NULL,
  `fname_iv` varchar(800) NOT NULL,
  `lname_iv` varchar(800) NOT NULL,
  `appdate_iv` varchar(500) NOT NULL,
  `apptime_iv` varchar(500) NOT NULL,
  `status` varchar(10) DEFAULT 'Not Paid'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `prestb`
--

INSERT INTO `prestb` (`pres_id`, `doctor`, `pid`, `ID`, `fname`, `lname`, `appdate`, `apptime`, `disease`, `allergy`, `prescription`, `disease_iv`, `allergy_iv`, `prescription_iv`, `fname_iv`, `lname_iv`, `appdate_iv`, `apptime_iv`, `status`) VALUES
(5, 'john', 19, 25, 'Nv17HRPj283sMNXhREiagw==', 'r+d6Aj6EG7G7CKa2YpOy2A==', 'ozPLbDkTTTXS5t6UY4NeTW9Ch9LPNkB1uVnSJ7b8d44=', '+b2k4cMx71ocoXEKX+E12dtrWxmEep5KBCBk4X9574g=', 'VkiL+UBTH6yOnLbDWJBpgA==', 'JaZ6wbcRYivy0DHceeNLww==', 'UGcUauzRBjlD28URntxzAGZ3/CIVrqZCh5R2nTyvYo4=', 'ECX8dm/k5jMdAaJDjmPT4Q==', '3EIFMksZNA6/Ypu3mjtAQg==', '4GIyBaYGwp6x6q1RUyMsuQ==', 'b2a1L+WIt7vTUdks9YPGQw==', 'oQ+wyRA4rNiJYqnaFcCTSw==', '0xCzWLfV0m4vEM0/BEOFIA==', '1vByqPv1Fw8YDrhTHHJOwg==', 'Paid'),
(6, 'john', 19, 27, 'SmUwnGyol+su6jpXgPntpA==', 'TTHrU9E7LM0HssGpJ4oF4Q==', '00DDOrW10MXTXoyPpV5AQw==', 'S69qGwjyyW8gjN5 xRoO/g==', 'aCRLuwv++7n+VWljCcmHWg==', 'rFAu2Dm52M0faWfoTsJxEw==', 'TPAFoKuokgSxu3pG4iwjTw==', 'bCj0hbiZBjFoXpKxgBdCTw==', '2CIob179zEFBEokzPS3WAw==', 'B34mq31otgatA0ROSxvAZQ==', 'Y/EcjsDggEnx1JnY/ZuQpg==', 'TpcYE08MsiwUdYiWl55E3w==', '', '', 'Not Paid'),
(7, 'john', 19, 30, 'oNhfmS+Ebz7/5mM97cD7+w==', 'hS15/5h61DYpdKABUT21mQ==', 'CP 5LJD304NM4Idqfiv WQ==', 'RQqJUAITas4TlbBA2rdT8A==', 'jPmsBrFyEGRNTL872AkFiQ==', 'UzsXQr1zBu4INZ6qwo/Mmw==', 'vZ1kwwlb86cSlBKUDSWl/g==', 'RUzPxvQAkc9syuBZa2QO7g==', 'VcW1srNXSe8P88zUNNa1pw==', 'RJhU3g+rbs+69ZwjWOtLHQ==', 'fkhy3JutfgCX0CVqs5IGnA==', '0HlNeHHnVKRSmvb7TLiAUQ==', '', '', 'Not Paid'),
(8, 'john', 23, 42, 'ECLghToaLLTzdMaXhyrjAw==', '/j19rwlyYFki32PTEKMmHw==', 'cyrWY2 nDehSBbnVcEgLlw==', 'J7Yer8nMNWT5K6afgPn Tg==', 'EOFq9l0qBrOHIEtv/GBcHA==', 'NPUmTGxvsNBsk8hhK4HOlw==', 'iQpga4jFTxSQvt1TZooALg==', 'RXWQj7YUbI5zqWpDTJKLVw==', 'J1PEbA5c+vHluFGBFgNykw==', '5qk/1kZkyCMKMaKqXSNp0A==', 'jnTsQOXrguqNEL4BKdydNg==', 'r+0XjuTvMTqu7GhYDcTwQg==', '', '', 'Not Paid'),
(9, 'john', 29, 43, 'iCzDSF9R9jFQGv2a5BOd1g==', 'kWWKrMLEP/axS6SX/Wu5XQ==', 'UNMIELuhHYAOccT2ss5wLw==', 'VwrT5Ft21nMnyFM0KDxwGg==', 'dkIAH+9UsvZcFDP1aX1lDg==', 'G+7MqHQn2qlXD1vdEUYTgQ==', '/Bf1I6Pe0eRcCcYioVk+NA==', '8uGahpv/87idw91+TOC1jg==', 'iHHEK2cjGBxJoJj2GaZluw==', 'Fjx2L6pUbUUYDnbO+iunPw==', '9VTqu+jgKoabz9WaIEhGkw==', 'vzCL2HZ6pOL6cYMhjjj6JA==', '', '', 'Not Paid'),
(10, 'Jaclyn', 30, 45, 'oX5meZn70Lx50cdlA3vrng==', 'i1Pnpl8zZOgtoClE71sAnw==', 'IrD1KLo96AvjeZHsi7TSWQ==', 'JQFmKvRP0b2M1K6DgEoa Q==', 'Qw11hn0/Ff2qsVya3aX6WA==', 'R5a9z1anpa9ojGBXXmSfFg==', 'wk8ZTt4fE3zQBRNP+tH3mg==', 'ENNQy0lg+NUm3MEYTwUmlg==', '0rR0qxCnGdECM0nr8htBKw==', 'UwoGvOr+PTCzBOuLC94e0g==', '65MOExyOZb6gDv8ntFQHUA==', 'ftMKf1zCnt0IpzU3AueoOg==', '', '', 'Not Paid');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `appointmenttb`
--
ALTER TABLE `appointmenttb`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `doctb`
--
ALTER TABLE `doctb`
  ADD PRIMARY KEY (`doc_id`);

--
-- Indexes for table `patreg`
--
ALTER TABLE `patreg`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `prestb`
--
ALTER TABLE `prestb`
  ADD PRIMARY KEY (`pres_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `appointmenttb`
--
ALTER TABLE `appointmenttb`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `doctb`
--
ALTER TABLE `doctb`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `patreg`
--
ALTER TABLE `patreg`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `prestb`
--
ALTER TABLE `prestb`
  MODIFY `pres_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
