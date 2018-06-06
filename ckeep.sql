-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06-Jun-2018 às 03:07
-- Versão do servidor: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ckeep`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `apartamentos`
--

CREATE TABLE `apartamentos` (
  `ID` int(11) NOT NULL,
  `apartamento` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `apartamentos`
--

INSERT INTO `apartamentos` (`ID`, `apartamento`) VALUES
(1, 'A11'),
(2, 'A22'),
(3, 'A33'),
(4, 'A44'),
(5, 'A55'),
(6, 'A66'),
(7, 'A77'),
(8, 'A88'),
(9, 'A99');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aviso`
--

CREATE TABLE `aviso` (
  `ID` int(11) NOT NULL,
  `dataav` date NOT NULL,
  `descricao` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `condomino`
--

CREATE TABLE `condomino` (
  `ID` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cpf` int(11) NOT NULL,
  `idade` int(11) NOT NULL,
  `tel1` int(11) NOT NULL,
  `tel2` int(11) NOT NULL,
  `apartamento` varchar(3) NOT NULL,
  `titular` smallint(6) NOT NULL,
  `usuario` varchar(35) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `condomino`
--

INSERT INTO `condomino` (`ID`, `nome`, `sobrenome`, `rg`, `cpf`, `idade`, `tel1`, `tel2`, `apartamento`, `titular`, `usuario`, `senha`) VALUES
(1, 'Renatoa', 'Rodrigues', '123', 123, 12, 2147483647, 0, 'A11', 0, 'admin', '$2y$10$gxAcwMHTrfZgpKrVMV3bWO43rSNFFhNKtoTBkZJyhAxgsxhmmG2jq'),
(3, 'Cristina', 'CristinaRodrigues', '123', 123, 12, 2147483647, 0, 'A22', 1, 'teste', 'teste'),
(4, 'Roberta', 'Rodrigues', '123', 123, 12, 1127099468, 0, 'A11', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcionario`
--

CREATE TABLE `funcionario` (
  `ID` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sobrenome` varchar(50) NOT NULL,
  `rg` varchar(15) NOT NULL,
  `cpf` int(11) NOT NULL,
  `idade` int(11) NOT NULL,
  `tel1` int(11) NOT NULL,
  `tel2` int(11) NOT NULL,
  `carteiratrab` int(11) NOT NULL,
  `salario` int(11) NOT NULL,
  `cargo` varchar(55) NOT NULL,
  `usuario` varchar(35) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `permissao` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`ID`, `nome`, `sobrenome`, `rg`, `cpf`, `idade`, `tel1`, `tel2`, `carteiratrab`, `salario`, `cargo`, `usuario`, `senha`, `permissao`) VALUES
(1, 'renato', 'rodrigues', '123', 123, 12, 123, 123, 123, 1000, 'rei', 'admin', '$2y$10$rJ95muQL6aiAGP3mqL8CHeB617dDyp6GjDlMqdeI/d5QSBFj4MBVK', 1),
(2, 'Isabela', 'Marin Frasson', '123', 123, 20, 123, 0, 123, 10000, 'Namorada', 'admin', '$2y$10$7QdGaasMxJS2HF4yyv29f.ysb.Q/J6DSi8EjTasyEzW3bRB1aQgNq', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `gastos`
--

CREATE TABLE `gastos` (
  `ID` int(11) NOT NULL,
  `datag` date NOT NULL,
  `valor` int(11) NOT NULL,
  `tipo` smallint(6) DEFAULT NULL,
  `descricao` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `gastos`
--

INSERT INTO `gastos` (`ID`, `datag`, `valor`, `tipo`, `descricao`) VALUES
(1, '2018-06-05', 130, 1, 'Testeie'),
(2, '2018-06-06', 10000, 2, 'Teste'),
(3, '2018-06-06', 12, 0, 'fdafaa'),
(4, '2018-06-06', 10, 2, 'Extra'),
(5, '2018-06-06', 10, 3, 'Ativ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `previsao`
--

CREATE TABLE `previsao` (
  `ID` int(11) NOT NULL,
  `gastosID` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reclamacao`
--

CREATE TABLE `reclamacao` (
  `ID` int(11) NOT NULL,
  `condominoID` int(11) DEFAULT NULL,
  `funcionarioID` int(11) DEFAULT NULL,
  `datar` date NOT NULL,
  `descricao` varchar(240) NOT NULL,
  `resposta` varchar(240) DEFAULT NULL,
  `aberto` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `reclamacao`
--

INSERT INTO `reclamacao` (`ID`, `condominoID`, `funcionarioID`, `datar`, `descricao`, `resposta`, `aberto`) VALUES
(1, 1, NULL, '2018-06-05', '1', NULL, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `responsavel_financeiro`
--

CREATE TABLE `responsavel_financeiro` (
  `ID` int(11) NOT NULL,
  `apartamento` varchar(3) NOT NULL,
  `statuspagamento` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `responsavel_financeiro`
--

INSERT INTO `responsavel_financeiro` (`ID`, `apartamento`, `statuspagamento`) VALUES
(3, 'A22', 1),
(4, 'A11', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessao`
--

CREATE TABLE `sessao` (
  `ID` varchar(60) NOT NULL,
  `ip` varchar(12) NOT NULL,
  `permissao` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `sessao`
--

INSERT INTO `sessao` (`ID`, `ip`, `permissao`) VALUES
('$2y$10$okjpAsXgcmrv9xKjZFwI.u1ReiQSzpQohFhJWDRx/3gd9RiGtE4y.', '::1', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo`
--

CREATE TABLE `veiculo` (
  `ID` int(11) NOT NULL,
  `tipo` varchar(5) NOT NULL,
  `marca` varchar(25) NOT NULL,
  `modelo` varchar(25) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `cor` varchar(15) NOT NULL,
  `condominoID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `veiculo`
--

INSERT INTO `veiculo` (`ID`, `tipo`, `marca`, `modelo`, `placa`, `cor`, `condominoID`) VALUES
(1, 'moto', 'Intruder', '123', '123', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartamentos`
--
ALTER TABLE `apartamentos`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `apartamento` (`apartamento`);

--
-- Indexes for table `aviso`
--
ALTER TABLE `aviso`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `condomino`
--
ALTER TABLE `condomino`
  ADD PRIMARY KEY (`ID`,`apartamento`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `senha` (`senha`),
  ADD KEY `apartamento` (`apartamento`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`ID`,`valor`);

--
-- Indexes for table `previsao`
--
ALTER TABLE `previsao`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `gastosID` (`gastosID`,`valor`);

--
-- Indexes for table `reclamacao`
--
ALTER TABLE `reclamacao`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `condominoID` (`condominoID`),
  ADD KEY `funcionarioID` (`funcionarioID`);

--
-- Indexes for table `responsavel_financeiro`
--
ALTER TABLE `responsavel_financeiro`
  ADD PRIMARY KEY (`ID`,`apartamento`),
  ADD KEY `apartamento` (`apartamento`);

--
-- Indexes for table `sessao`
--
ALTER TABLE `sessao`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `condominoID` (`condominoID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartamentos`
--
ALTER TABLE `apartamentos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `aviso`
--
ALTER TABLE `aviso`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `condomino`
--
ALTER TABLE `condomino`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gastos`
--
ALTER TABLE `gastos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `previsao`
--
ALTER TABLE `previsao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reclamacao`
--
ALTER TABLE `reclamacao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `condomino`
--
ALTER TABLE `condomino`
  ADD CONSTRAINT `condomino_ibfk_1` FOREIGN KEY (`apartamento`) REFERENCES `apartamentos` (`apartamento`);

--
-- Limitadores para a tabela `previsao`
--
ALTER TABLE `previsao`
  ADD CONSTRAINT `previsao_ibfk_1` FOREIGN KEY (`gastosID`,`valor`) REFERENCES `gastos` (`ID`, `valor`);

--
-- Limitadores para a tabela `reclamacao`
--
ALTER TABLE `reclamacao`
  ADD CONSTRAINT `reclamacao_ibfk_1` FOREIGN KEY (`condominoID`) REFERENCES `condomino` (`ID`),
  ADD CONSTRAINT `reclamacao_ibfk_2` FOREIGN KEY (`funcionarioID`) REFERENCES `funcionario` (`ID`);

--
-- Limitadores para a tabela `responsavel_financeiro`
--
ALTER TABLE `responsavel_financeiro`
  ADD CONSTRAINT `responsavel_financeiro_ibfk_1` FOREIGN KEY (`ID`,`apartamento`) REFERENCES `condomino` (`ID`, `apartamento`),
  ADD CONSTRAINT `responsavel_financeiro_ibfk_2` FOREIGN KEY (`apartamento`) REFERENCES `apartamentos` (`apartamento`);

--
-- Limitadores para a tabela `veiculo`
--
ALTER TABLE `veiculo`
  ADD CONSTRAINT `veiculo_ibfk_1` FOREIGN KEY (`condominoID`) REFERENCES `condomino` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
