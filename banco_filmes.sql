-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 20-Jul-2015 às 05:01
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `filmes`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `fil_categoria`
--

CREATE TABLE IF NOT EXISTS `fil_categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`categoria_id`),
  UNIQUE KEY `categoria_id` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `fil_categoria`
--

INSERT INTO `fil_categoria` (`categoria_id`, `categoria_nome`) VALUES
(2, 'Drama'),
(3, 'ComÃ©dia'),
(4, 'AÃ§Ã£o'),
(5, 'Romance');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fil_filmes`
--

CREATE TABLE IF NOT EXISTS `fil_filmes` (
  `filmes_id` int(11) NOT NULL AUTO_INCREMENT,
  `filmes_nome` varchar(255) DEFAULT NULL,
  `filmes_foto` varchar(255) DEFAULT NULL,
  `filmes_preco` float(9,2) DEFAULT NULL,
  `filmes_descricao` text,
  `filmes_status` tinyint(1) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`filmes_id`),
  UNIQUE KEY `filmes_id` (`filmes_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `fil_filmes`
--

INSERT INTO `fil_filmes` (`filmes_id`, `filmes_nome`, `filmes_foto`, `filmes_preco`, `filmes_descricao`, `filmes_status`, `categoria_id`) VALUES
(1, 'Arrow', 'search.jpg', 12.00, 'Arrow Ã© uma sÃ©rie de televisÃ£o estadunidense de AÃ§Ã£o, aventura, drama e fantasia baseada no personagem fictÃ­cio dos quadrinhos, o Arqueiro Verde.', 1, NULL),
(3, 'CSI', 'url.jpg', 12.00, 'CSI: Crime Scene Investigation Ã© uma popular e premiada sÃ©rie dramÃ¡tica americana exibida pelo canal CBS. A sÃ©rie Ã© centrada nas investigaÃ§Ãµes do grupo de cientistas forenses do departamento de criminalÃ­stica da polÃ­cia de Las Vegas, Nevada', 1, NULL),
(4, 'TED 2', 'imagesxx.jpg', 32.00, 'terste fvfdv dfvdcvdsv dcdscdv cvdscdscv', 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
