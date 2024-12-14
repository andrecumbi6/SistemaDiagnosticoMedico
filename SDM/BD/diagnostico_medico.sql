-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 14/12/2024 às 09:39
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `diagnostico_medico`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `doencas`
--

DROP TABLE IF EXISTS `doencas`;
CREATE TABLE IF NOT EXISTS `doencas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `descricao` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `doencas`
--

INSERT INTO `doencas` (`id`, `nome`, `descricao`) VALUES
(1, 'Gripe', 'Infecção viral comum que afeta o sistema respiratório.'),
(2, 'Diabetes Tipo 2', 'Condição crônica que afeta a maneira como o corpo processa o açúcar no sangue.'),
(3, 'Hipertensão', 'Pressão arterial elevada de forma persistente.'),
(4, 'Asma', 'Doença inflamatória crônica das vias aéreas.'),
(5, 'Dengue', 'Doença transmitida por mosquitos, causada pelo vírus da dengue.'),
(6, 'Bronquite', 'Inflamação das vias aéreas nos pulmões.'),
(7, 'Anemia', 'Condição onde há uma diminuição no número de glóbulos vermelhos no sangue.'),
(8, 'COVID-19', 'Doença respiratória causada pelo coronavírus SARS-CoV-2.'),
(9, 'Gastrite', 'Inflamação do revestimento do estômago.'),
(13, 'Malária 2', 'A malária é uma doença infecciosa causada por protozoários do gênero Plasmodium. É transmitida para humanos através da picada de mosquitos fêmeas infectados do gênero Anopheles. A doença é prevalente em áreas tropicais e subtropicais e pode ser grave se não tratada adequadamente.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `doencas_sintomas`
--

DROP TABLE IF EXISTS `doencas_sintomas`;
CREATE TABLE IF NOT EXISTS `doencas_sintomas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doenca_id` int NOT NULL,
  `sintoma_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `doenca_id` (`doenca_id`),
  KEY `sintoma_id` (`sintoma_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `doencas_sintomas`
--

INSERT INTO `doencas_sintomas` (`id`, `doenca_id`, `sintoma_id`) VALUES
(23, 1, 4),
(22, 1, 2),
(21, 1, 1),
(4, 2, 4),
(5, 2, 10),
(6, 3, 4),
(7, 3, 3),
(8, 4, 2),
(9, 4, 5),
(10, 5, 1),
(11, 5, 6),
(12, 6, 2),
(13, 6, 5),
(14, 7, 10),
(15, 8, 1),
(16, 8, 5),
(17, 9, 8),
(18, 9, 9),
(19, 9, 7),
(20, 10, 3),
(24, 11, 11),
(25, 11, 12),
(29, 12, 12),
(28, 12, 11),
(39, 13, 16),
(38, 13, 15),
(37, 13, 13),
(36, 13, 14),
(35, 13, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sintomas`
--

DROP TABLE IF EXISTS `sintomas`;
CREATE TABLE IF NOT EXISTS `sintomas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `sintomas`
--

INSERT INTO `sintomas` (`id`, `nome`) VALUES
(1, 'Febre'),
(2, 'Tosse'),
(3, 'Dor de cabeça'),
(4, 'Cansaço'),
(5, 'Falta de ar'),
(6, 'Dor no corpo'),
(7, 'Náusea'),
(8, 'Vômito'),
(9, 'Dor abdominal'),
(10, 'Fadiga'),
(14, 'Calafrios e suores intensos'),
(13, 'Febre alta'),
(15, 'Náuseas e vômitos'),
(16, 'Dor muscular');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tratamentos`
--

DROP TABLE IF EXISTS `tratamentos`;
CREATE TABLE IF NOT EXISTS `tratamentos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doenca_id` int NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `doenca_id` (`doenca_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `tratamentos`
--

INSERT INTO `tratamentos` (`id`, `doenca_id`, `descricao`) VALUES
(1, 1, 'Repouso, ingestão de líquidos e medicamentos para aliviar os sintomas.'),
(2, 2, 'Mudança no estilo de vida, dieta e medicamentos para controlar o açúcar no sangue.'),
(3, 3, 'Mudanças no estilo de vida, dieta e medicamentos anti-hipertensivos.'),
(4, 4, 'Uso de broncodilatadores e corticosteroides para controlar os sintomas.'),
(5, 5, 'Hidratação, repouso e medicamentos para controlar os sintomas.'),
(6, 6, 'Repouso, hidratação e medicamentos expectorantes.'),
(7, 7, 'Dieta rica em ferro e, em casos mais graves, suplementos de ferro ou transfusões.'),
(8, 8, 'Isolamento, controle de sintomas e, em casos graves, suporte respiratório.'),
(9, 9, 'Mudanças na dieta, antiácidos e medicamentos específicos.'),
(13, 13, 'Cloroquina - usada para tratar Plasmodium vivax e Plasmodium malariae em áreas onde não há resistência.\r\nPrimaquina - utilizada para eliminar formas latentes do parasita (hipnozoítos) no fígado, prevenindo recaídas.');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'acumbi', '$2y$10$oDcVoRzNGiqH50oTpUFLPedTYnY49NTcERLDGqN4NX2e.O2RbORyu', '2024-12-12 11:26:39'),
(2, 'admin', '$2y$10$oDcVoRzNGiqH50oTpUFLPedTYnY49NTcERLDGqN4NX2e.O2RbORyu', '2024-12-12 13:07:02');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
