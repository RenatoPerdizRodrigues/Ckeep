-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 07-Jun-2018 às 17:01
-- Versão do servidor: 10.1.25-MariaDB
-- PHP Version: 5.6.31

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
  `vencimento` date NOT NULL,
  `descricao` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `aviso`
--

INSERT INTO `aviso` (`ID`, `dataav`, `vencimento`, `descricao`) VALUES
(1, '2018-06-07', '2018-06-08', 'Ficaremos sem Ã¡gua no dia de hoje'),
(2, '2018-06-07', '2018-06-10', 'O portÃ£o estÃ¡ quebrado');

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
  `senha` varchar(60) DEFAULT NULL,
  `primeirasessao` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `condomino`
--

INSERT INTO `condomino` (`ID`, `nome`, `sobrenome`, `rg`, `cpf`, `idade`, `tel1`, `tel2`, `apartamento`, `titular`, `usuario`, `senha`, `primeirasessao`) VALUES
(1, 'Antonio', 'Pereira', '591584791', 2147483647, 27, 56987566, 0, 'A11', 1, 'antoniockeep@hotmail.com', '$2y$10$Ujj/HSWgyrNXDD.7o32J1uSOee9dQJoWSP06DVMt6yn1Soi0NMH/i', NULL),
(2, 'Junior', 'Almeida', '93409047', 2147483647, 20, 45549888, 0, 'A11', 0, 'alemeida@hotmail.com', NULL, NULL),
(3, 'Josiane', 'Clementina', '165298726', 2147483647, 23, 45829965, 21547566, 'A22', 1, 'josickeep@hotmail.com', 'xrJ8KafT4A', '$2y$10$VvQ1W24arFHfAAQpwVbRnuQa5AnvSZQ4jfiVNnlmhlLU3YRFZSnhG'),
(4, 'Roberta', 'Rodrigues', '265987456', 2147483647, 45, 55698745, 0, 'A33', 0, 'robertackeep@gmail.com', NULL, '$2y$10$MQ4ezrOKhhhJuaIR.hbczOJFMhBkgVq17FSSZ3rnzaQAWwpxzt4Pe'),
(5, 'Isabela', 'Santa', '598745698', 154889562, 22, 54896578, 0, 'A33', 1, 'isackeep@hotmail.com', 'Q3j6jt0Kmx', '$2y$10$4cWNnuDW1ihU/6dhz53WNup0t5BJXOfM2w4poY8VPqif.J7QkQgku'),
(6, 'Rafaela', 'Peixoto', '598745987', 2147483647, 25, 65988895, 65777747, 'A55', 1, 'rebsunderline@hotmail.coma', '$2y$10$3bzsi5rkgM4ab9OIprS.peoR6SeL15R6FBAV8gAnlq.lbUy30AmlW', NULL);

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
  `permissao` smallint(6) NOT NULL,
  `usuario` varchar(35) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `primeirasessao` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `funcionario`
--

INSERT INTO `funcionario` (`ID`, `nome`, `sobrenome`, `rg`, `cpf`, `idade`, `tel1`, `tel2`, `carteiratrab`, `salario`, `cargo`, `permissao`, `usuario`, `senha`, `primeirasessao`) VALUES
(1, 'Renato', 'Rodrigues', '123', 123, 12, 123, 123, 123, 1000, 'rei', 1, 'admin', '$2y$10$JaEsCCazhU1AUg6Pq6./5uKIuWR97laMiXzSxU87QtuKi2gI42u1a', NULL),
(2, 'JosÃ©', 'Jesus', '9859874', 2147483647, 51, 59874562, 0, 15625687, 2500, 'Zelador', 0, 'josejesusckeep@hotmail.com', 'gbcmqrUCXw', '$2y$10$rsM6AXEWJ12tcgTVaQXawugvk3..6FUnS8mFjxYfYcVi5Gzu7Z6/u'),
(3, 'Gabriela', 'Rodrigues', '987845987', 2147483647, 20, 56984575, 0, 26598745, 2000, 'Porteira', 0, 'gabrielackeep@hotmail.com', '0cSuI0u1sH', '$2y$10$RkVWEUjV3fTEhPEZAN1a7uyakwVb4f3Es3eELO36ksY03jt6W/RpS'),
(6, 'Renato', 'Pereira', '132456489', 1516465, 22, 2147483647, 0, 2147483647, 3000, 'Administrador', 0, 'rebsrenatoyahoocombr@gmail.com', 'PFxocIcuMx', '$2y$10$Uq4l9XfnStBdwEK8/qfxAuEv6khT0Wv9wvebXLgWaOk4iUXgv67Yq');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gastos`
--

CREATE TABLE `gastos` (
  `ID` int(11) NOT NULL,
  `datag` date NOT NULL,
  `valor` int(11) NOT NULL,
  `tipo` varchar(15) NOT NULL,
  `descricao` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `gastos`
--

INSERT INTO `gastos` (`ID`, `datag`, `valor`, `tipo`, `descricao`) VALUES
(1, '2018-06-07', 800, 'Fixo', 'Eletricidade'),
(2, '2018-06-07', 2000, 'Fixo', 'Ãgua'),
(3, '2018-06-07', 650, 'Extraordinario', 'Conserto do portÃ£o'),
(4, '2018-06-07', 150, 'Extraordinario', 'Vazamento'),
(5, '2018-06-07', 600, 'Atividade', 'Pintura');

-- --------------------------------------------------------

--
-- Estrutura da tabela `gastosanteriores`
--

CREATE TABLE `gastosanteriores` (
  `ID` int(11) NOT NULL,
  `datag` date NOT NULL,
  `valor` int(11) NOT NULL,
  `tipo` varchar(8) NOT NULL,
  `descricao` varchar(240) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `previsao`
--

CREATE TABLE `previsao` (
  `ID` int(11) NOT NULL,
  `datap` date NOT NULL,
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
(1, 6, NULL, '2018-06-07', 'Vizinho estÃ¡ fazendo muito barulho', NULL, 1),
(2, 6, NULL, '2018-06-07', 'CrianÃ§as estÃ£o brincando na frente da minha porta', NULL, 1),
(4, 6, NULL, '2018-06-07', 'Portaria nÃ£o avisou da chegada das encomendas	', NULL, 0);

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
(1, 'A11', 0),
(3, 'A22', 1),
(5, 'A33', 1),
(6, 'A55', 0);

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
('$2y$10$U6h6jz43p1iyOpitGDDt1ebWeEOc0Oxr0am3s1oITyUDr3ePqK.nG', '::1', 2);

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
(1, 'Carro', 'Fiat', 'Up', 'JKH7894', 'Preto', 1);

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
  ADD UNIQUE KEY `primeirasessao` (`primeirasessao`),
  ADD KEY `apartamento` (`apartamento`);

--
-- Indexes for table `funcionario`
--
ALTER TABLE `funcionario`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD UNIQUE KEY `senha` (`senha`),
  ADD UNIQUE KEY `primeirasessao` (`primeirasessao`);

--
-- Indexes for table `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`ID`,`valor`);

--
-- Indexes for table `gastosanteriores`
--
ALTER TABLE `gastosanteriores`
  ADD PRIMARY KEY (`ID`,`valor`);

--
-- Indexes for table `previsao`
--
ALTER TABLE `previsao`
  ADD PRIMARY KEY (`ID`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `condomino`
--
ALTER TABLE `condomino`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `funcionario`
--
ALTER TABLE `funcionario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gastos`
--
ALTER TABLE `gastos`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gastosanteriores`
--
ALTER TABLE `gastosanteriores`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `previsao`
--
ALTER TABLE `previsao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `reclamacao`
--
ALTER TABLE `reclamacao`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
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
