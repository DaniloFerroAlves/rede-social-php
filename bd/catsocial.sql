-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Dez-2022 às 03:46
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `catsocial`
--
CREATE DATABASE IF NOT EXISTS `catsocial` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `catsocial`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE `comentario` (
  `id_comentario` int(10) NOT NULL,
  `texto` varchar(255) DEFAULT NULL,
  `data_coment` datetime DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  `id_publicacao` int(10) DEFAULT NULL,
  `id_usuario` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `curtida`
--

CREATE TABLE `curtida` (
  `id_curtida` int(10) NOT NULL,
  `id_usuario` int(10) DEFAULT NULL,
  `id_publicacao` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `interacoes`
--

CREATE TABLE `interacoes` (
  `id_iteracoes` int(10) NOT NULL,
  `seguidor` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `publicacao`
--

CREATE TABLE `publicacao` (
  `id_publicacao` int(10) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `data_post` datetime DEFAULT NULL,
  `status` bit(1) DEFAULT NULL,
  `id_usuario` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `apelido` varchar(255) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `bio` varchar(255) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `data_cad` datetime DEFAULT NULL,
  `status` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario_interacoes`
--

CREATE TABLE `usuario_interacoes` (
  `id_iteracoes` int(10) DEFAULT NULL,
  `id_usuario` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_publicacao` (`id_publicacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `curtida`
--
ALTER TABLE `curtida`
  ADD PRIMARY KEY (`id_curtida`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_publicacao` (`id_publicacao`);

--
-- Índices para tabela `interacoes`
--
ALTER TABLE `interacoes`
  ADD PRIMARY KEY (`id_iteracoes`);

--
-- Índices para tabela `publicacao`
--
ALTER TABLE `publicacao`
  ADD PRIMARY KEY (`id_publicacao`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `usuario_interacoes`
--
ALTER TABLE `usuario_interacoes`
  ADD KEY `id_iteracoes` (`id_iteracoes`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id_comentario` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `curtida`
--
ALTER TABLE `curtida`
  MODIFY `id_curtida` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `interacoes`
--
ALTER TABLE `interacoes`
  MODIFY `id_iteracoes` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `publicacao`
--
ALTER TABLE `publicacao`
  MODIFY `id_publicacao` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`id_publicacao`) REFERENCES `publicacao` (`id_publicacao`),
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `curtida`
--
ALTER TABLE `curtida`
  ADD CONSTRAINT `curtida_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `curtida_ibfk_2` FOREIGN KEY (`id_publicacao`) REFERENCES `publicacao` (`id_publicacao`);

--
-- Limitadores para a tabela `publicacao`
--
ALTER TABLE `publicacao`
  ADD CONSTRAINT `publicacao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Limitadores para a tabela `usuario_interacoes`
--
ALTER TABLE `usuario_interacoes`
  ADD CONSTRAINT `usuario_interacoes_ibfk_1` FOREIGN KEY (`id_iteracoes`) REFERENCES `interacoes` (`id_iteracoes`),
  ADD CONSTRAINT `usuario_interacoes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
