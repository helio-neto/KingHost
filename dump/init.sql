-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 30-Out-2017 às 02:18
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kinghost`
--
CREATE DATABASE IF NOT EXISTS `kinghost` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `kinghost`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva_salas`
--

DROP TABLE IF EXISTS `reserva_salas`;
CREATE TABLE IF NOT EXISTS `reserva_salas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sala_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `inicio_reserva` datetime DEFAULT NULL,
  `fim_reserva` datetime NOT NULL,
  `info` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `reserva_salas_FKIndex1` (`usuario_id`),
  KEY `reserva_salas_FKIndex2` (`sala_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Extraindo dados da tabela `reserva_salas`
--

INSERT INTO `reserva_salas` (`id`, `sala_id`, `usuario_id`, `inicio_reserva`, `fim_reserva`, `info`) VALUES
(1, 1, 1, '2017-10-28 07:00:00', '2017-10-28 08:00:00', 'asdasdadaaaaaaaaaaaaa'),
(2, 1, 2, '2017-10-28 10:00:00', '2017-10-28 11:00:00', 'asdasdasd asdasdasdasd asdasdasdasd'),
(3, 1, 3, '2017-10-29 12:45:53', '2017-10-29 13:45:53', 'zzzzzzzzzzzzxc asd asd asd asd asd asd '),
(4, 2, 1, '2017-10-29 12:51:20', '2017-10-29 13:51:20', 'asdasdas dasd asd asd as dasdasd'),
(5, 3, 1, '2017-10-29 13:37:35', '2017-10-29 14:37:35', ' asd asd asd as dasdas dasd'),
(6, 1, 1, '2017-10-29 13:56:17', '2017-10-29 14:56:17', 'f asda sd asd asd asd asda sd asd'),
(8, 2, 1, '2017-10-31 13:05:31', '2017-10-31 14:05:31', 'ReuniÃ£o casual, daily meeting.'),
(11, 1, 3, '2017-10-29 17:37:44', '2017-10-29 18:37:44', '\\xzas\\zxcz\\xc'),
(12, 1, 3, '2017-10-29 18:15:27', '2017-10-29 19:15:27', 'asdasdasdasdasd'),
(13, 1, 3, '2017-10-29 20:49:18', '2017-10-29 21:49:18', 'asdasdasdasd'),
(14, 2, 3, '2017-10-29 20:55:58', '2017-10-29 21:55:58', 'aaaaaaaaaaaaaaaa'),
(15, 2, 3, '2017-10-31 08:00:06', '2017-10-31 09:00:06', 'sadsdasdasdasd'),
(16, 1, 3, '2017-10-28 10:00:39', '2017-10-28 11:00:39', 'aaaaaaa'),
(17, 2, 3, '2017-10-31 09:00:28', '2017-10-31 10:00:28', 'nao'),
(18, 2, 3, '2017-10-31 10:00:33', '2017-10-31 11:00:33', 'asdasdasdasd'),
(19, 3, 5, '2017-11-02 09:00:23', '2017-11-02 10:00:23', 'Minha primeira reuniao');

-- --------------------------------------------------------

--
-- Estrutura da tabela `sala`
--

DROP TABLE IF EXISTS `sala`;
CREATE TABLE IF NOT EXISTS `sala` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) DEFAULT NULL,
  `capacidade` int(10) unsigned DEFAULT NULL,
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `sala`
--

INSERT INTO `sala` (`id`, `nome`, `capacidade`, `info`) VALUES
(1, 'sala 1', 10, '1º andar'),
(2, 'sala2', 20, '2º andar'),
(3, 'sala 3', 30, '3º andar');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `senha` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Jose Silva', 'ipa@gmail.com', '$2y$10$FL35uaV2BLUCKXNqNG8GWOnHI58MzH.p.7aUxa20/GzVzdIXEhciO'),
(2, 'Pedro Siqueira', 'ipa2@gmail.com', '$2y$10$FL35uaV2BLUCKXNqNG8GWOnHI58MzH.p.7aUxa20/GzVzdIXEhciO'),
(3, 'Julia Moreira', 'cascasc@email.com', '$2y$10$FL35uaV2BLUCKXNqNG8GWOnHI58MzH.p.7aUxa20/GzVzdIXEhciO'),
(4, 'Maicon silva', 'maicon@gmail.com', '$2y$10$FL35uaV2BLUCKXNqNG8GWOnHI58MzH.p.7aUxa20/GzVzdIXEhciO'),
(5, 'Juliano', 'juliano@email.com', '$2y$10$LF0Bc1rPSOAnwk4rFi7dg.BjsqoKAXBJnlwDszuOJBT1eVQBcCq4i');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `reserva_salas`
--
ALTER TABLE `reserva_salas`
  ADD CONSTRAINT `reserva_salas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `reserva_salas_ibfk_2` FOREIGN KEY (`sala_id`) REFERENCES `sala` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
