-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Host: sql6.freesqldatabase.com
-- Generation Time: 14 Okt 2022 pada 18.11
-- Versi Server: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.0.33-0ubuntu0.16.04.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sql6524842`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `profile_id` char(6) NOT NULL DEFAULT '',
  `time` datetime DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `commentlikes`
--

CREATE TABLE `commentlikes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL DEFAULT '0',
  `profile_id` char(6) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `passreset_temp`
--

CREATE TABLE `passreset_temp` (
  `email` varchar(256) NOT NULL,
  `hidden` varchar(256) NOT NULL,
  `expDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `passreset_temp`
--

INSERT INTO `passreset_temp` (`email`, `hidden`, `expDate`) VALUES
('stefanus.andrian@student.umn.ac.id\r\n', '$2y$10$.TzJhWgUBCqdXRPzJQK1v.hZV5oCej2abi.P4WUexKxPGmkP0Mjjy', '2022-10-15 07:31:17'),
('misc.potato24@gmail.com', '$2y$10$AEc1ZH2N3wi2SFlMCIcMTeCU9HUGel1LlWD8PejFz6Eshvmyp1v2i', '2022-10-15 07:17:14'),
('unused.potato24@gmail.com\r\n\r\n', '$2y$10$ErLvTWpWEkTFhX4HB35CseiZkt./swrsCLK6QJkuu9d237Xq2zCVe', '2022-10-15 07:33:19'),
('unused.potato24@gmail.com\r\n\r\n', '$2y$10$FsAVPNPKvCU21IxgGqC23e0Lnu9iPkBh5ty0wGtGlw7lkvF7Qyg6m', '2022-10-15 07:32:14'),
('unused.potato24@gmail.com\r\n\r\n', '$2y$10$gXlehws8bv0CP3unwGTJUOj.Hg//8/xUlozJJXBiIb0OqFF7eHt7W', '2022-10-15 07:32:38'),
('unused.potato24@gmail.com\r\n\r\n', '$2y$10$Hik5mSnWqh0Z7DEhaxDoluWiH/19NjTuVlKFxhR3lx4QZTJuZGjGa', '2022-10-15 07:34:22'),
('unused.potato24@gmail.com\r\n\r\n', '$2y$10$HWpo6AQ5WoytDUve0Bt.3O7pLyDn3c4xivMGHDbzFMLvk4P5GG0Bi', '2022-10-15 07:32:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `profile_id` char(6) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `category` varchar(15) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` varchar(1500) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `comments` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `postlikes`
--

CREATE TABLE `postlikes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL DEFAULT '0',
  `profile_id` char(6) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile`
--

CREATE TABLE `profile` (
  `id` char(6) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `photo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `first_name`, `last_name`, `photo`) VALUES
('63F4E1', 12, 'carl', 'johnson', 'src/uploads/__blaze_ace_combat_and_2_more_drawn_by_skylerand'),
('7B5FF0', 13, 'Stefanus', 'Andrian', 'src/uploads/onimai.png'),
('8DEE77', 16, 'gre', 'kur', 'src/default.jpg'),
('A758AA', 14, 'Mike', 'Hunt', 'src/uploads/3cdx2yrmyei61.webp'),
('B51226', 15, 'Melvin', 'Tungadi', 'src/default.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `access` varchar(15) NOT NULL,
  `state` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `access`, `state`) VALUES
(2, 'unused.potato24@gmail.com\r\n', 'himeko', '$2y$10$jolpkPdRLzzOy40jtF5MeONdF3U34bE8xNioUGsEAVh3rxclpdeuW', 'admin', 'safe'),
(12, 'stevenind99@gmail.com', 'hughjazz', '$2y$10$6szR3uL8IUkTiCw3vvSfaOGNMdUVkVK.k18h62gHxbDSXFE.pqnwG', 'member', 'safe'),
(13, 'misc.potato24@gmail.com', 'nishikigi_inoue', '$2y$10$tobandwxd9ihyVOKalq7Q.uwsGaeQxCY7LHOqkr4y79neX3i7yjs.', 'admin', 'safe'),
(14, 'johndoe@gmail.com', 'mikehunt', '$2y$10$oviSQVofBBH5uuAwv8MOsOS8qyTHBzejcdZ403nPZOUIofCmWLce.', 'member', 'safe'),
(15, 'tungadi.melvin@gmail.com', 'deydonnow', '$2y$10$i/7hJ0Yl0P0yw6Tm./0JjO5UqQKaOBfxa7tKKMTtor1PH5KEuxJWS', 'admin', 'safe'),
(16, 'gre@gmail.com', 'greg', '$2y$10$NgLpY4RGTOou.GRvWfU1tuKvNwsBh/jv42mBO7fl1EmXutYLWJzCy', 'member', 'safe');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`,`post_id`,`profile_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `commentlikes`
--
ALTER TABLE `commentlikes`
  ADD PRIMARY KEY (`id`,`comment_id`,`profile_id`),
  ADD KEY `comment_id` (`comment_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `passreset_temp`
--
ALTER TABLE `passreset_temp`
  ADD UNIQUE KEY `hidden` (`hidden`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `postlikes`
--
ALTER TABLE `postlikes`
  ADD PRIMARY KEY (`id`,`post_id`,`profile_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `profile_id` (`profile_id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `commentlikes`
--
ALTER TABLE `commentlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `postlikes`
--
ALTER TABLE `postlikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_3` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Ketidakleluasaan untuk tabel `commentlikes`
--
ALTER TABLE `commentlikes`
  ADD CONSTRAINT `commentlikes_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`),
  ADD CONSTRAINT `commentlikes_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Ketidakleluasaan untuk tabel `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Ketidakleluasaan untuk tabel `postlikes`
--
ALTER TABLE `postlikes`
  ADD CONSTRAINT `postlikes_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`),
  ADD CONSTRAINT `postlikes_ibfk_2` FOREIGN KEY (`profile_id`) REFERENCES `profile` (`id`);

--
-- Ketidakleluasaan untuk tabel `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
