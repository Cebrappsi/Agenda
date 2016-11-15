-- phpMyAdmin SQL Dump
-- version 4.1.5
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/02/2014 às 14:29
-- Versão do servidor: 5.5.27
-- Versão do PHP: 5.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Banco de dados: `db_clinica`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `consulta`
--

CREATE TABLE `consulta` (
  `DT_Consulta` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data da Consulta',
  `HR_Consulta` time NOT NULL DEFAULT '00:00:00' COMMENT 'Hora da Consulta',
  `SQ_Contato_Paciente` int(11) DEFAULT NULL COMMENT 'Sequencial do Contato do Paciente',
  `SQ_Contato_Profissional` int(11) DEFAULT NULL COMMENT 'Sequencial do Contato do Profissional',
  `SQ_Sala` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial da Sala',
  `TP_Situcacao_Consulta` varchar(1) NOT NULL COMMENT 'Situacão da Consulta',
  PRIMARY KEY (`DT_Consulta`,`HR_Consulta`,`SQ_Sala`),
  KEY `PrimaryKey` (`HR_Consulta`,`DT_Consulta`),
  KEY `COD_PAC` (`SQ_Contato_Paciente`),
  KEY `COD_PROF` (`SQ_Contato_Profissional`),
  KEY `COD_SALA` (`SQ_Sala`),
  KEY `PACIENTECONSULTA` (`SQ_Contato_Paciente`),
  KEY `PROFISSIONALCONSULTA` (`SQ_Contato_Profissional`),
  KEY `SALACONSULTA` (`SQ_Sala`),
  KEY `SITUACAO_CONSULTACONSULTA` (`TP_Situcacao_Consulta`),
  KEY `SQ_Contato_Paciente` (`SQ_Contato_Paciente`),
  KEY `SQ_Contato_Profissional` (`SQ_Contato_Profissional`),
  KEY `SQ_Sala` (`SQ_Sala`),
  KEY `DT_Consulta` (`DT_Consulta`,`HR_Consulta`,`SQ_Contato_Paciente`),
  KEY `SQ_Contato_Paciente_2` (`SQ_Contato_Paciente`,`DT_Consulta`,`HR_Consulta`),
  KEY `DT_Consulta_2` (`DT_Consulta`,`HR_Consulta`,`SQ_Contato_Profissional`),
  KEY `SQ_Contato_Profissional_2` (`SQ_Contato_Profissional`,`DT_Consulta`,`HR_Consulta`),
  KEY `SQ_Contato_Profissional_3` (`SQ_Contato_Profissional`,`DT_Consulta`,`HR_Consulta`),
  KEY `SQ_Contato_Profissional_4` (`SQ_Contato_Profissional`,`DT_Consulta`,`HR_Consulta`),
  KEY `DT_Consulta_3` (`DT_Consulta`,`HR_Consulta`,`SQ_Sala`),
  KEY `DT_Consulta_4` (`DT_Consulta`,`HR_Consulta`,`SQ_Sala`),
  KEY `DT_Consulta_5` (`DT_Consulta`,`HR_Consulta`,`SQ_Sala`),
  KEY `SQ_Sala_2` (`SQ_Sala`,`DT_Consulta`,`HR_Consulta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Informações sobre as consultas';

--
-- RELACIONAMENTOS PARA TABELAS `consulta`:
--   `SQ_Contato_Paciente`
--       `contato` -> `SQ_Contato`
--   `SQ_Contato_Profissional`
--       `profissional` -> `SQ_Profissional`
--   `SQ_Sala`
--       `sala` -> `SQ_Sala`
--   `TP_Situcacao_Consulta`
--       `situacao_consulta` -> `TP_Situacao_Consulta`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

CREATE TABLE `contato` (
  `SQ_Contato` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Contato',
  `NM_Contato` varchar(50) NOT NULL COMMENT 'Nome do Contato',
  `DT_Nascimento` date DEFAULT NULL COMMENT 'Data de Nascimento',
  `Identificacao` varchar(50) DEFAULT NULL COMMENT 'CPF/CNPJ DO Contato',
  `Observacoes` varchar(1000) DEFAULT NULL COMMENT 'Observações importantes do contato',
  PRIMARY KEY (`SQ_Contato`),
  KEY `PrimaryKey` (`SQ_Contato`),
  KEY `NOME` (`NM_Contato`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contatos da Clinica';

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato_plano`
--

CREATE TABLE `contato_plano` (
  `SQ_Contato` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Contato',
  `SQ_Convenio` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do convenio',
  `SQ_Plano` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Plano',
  `DT_Validade` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Validade do Plano',
  `NR_Inscricao` int(11) DEFAULT NULL COMMENT 'Numero de Inscrição do Paciente no Plnao',
  PRIMARY KEY (`DT_Validade`,`SQ_Plano`,`SQ_Convenio`,`SQ_Contato`),
  KEY `CONTATO_PLANOSQ_Plano` (`SQ_Plano`),
  KEY `CONTATOCONTATO_PLANO` (`SQ_Contato`),
  KEY `SQ_Contato` (`SQ_Contato`),
  KEY `SQ_Convenio` (`SQ_Convenio`),
  KEY `PrimaryKey` (`DT_Validade`,`SQ_Plano`,`SQ_Convenio`,`SQ_Contato`),
  KEY `PLANOCONTATO_PLANO` (`SQ_Convenio`,`SQ_Plano`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relacao entre Contato e Plano';

--
-- RELACIONAMENTOS PARA TABELAS `contato_plano`:
--   `SQ_Convenio`
--       `plano` -> `SQ_Convenio`
--   `SQ_Plano`
--       `plano` -> `SQ_Plano`
--   `SQ_Contato`
--       `contato` -> `SQ_Contato`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `convenio`
--

CREATE TABLE `convenio` (
  `SQ_Convenio` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Convenio',
  `NM_Convenio` varchar(30) NOT NULL COMMENT 'Nome do convenio',
  `DT_Ativacao` date NOT NULL COMMENT 'Data de Ativação do Convenio',
  `DT_Desativacao` date DEFAULT NULL COMMENT 'Data de Desativaçao do convenio',
  PRIMARY KEY (`SQ_Convenio`),
  UNIQUE KEY `NM_Convenio` (`NM_Convenio`),
  KEY `PrimaryKey` (`SQ_Convenio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Convênios Atendidos';

-- --------------------------------------------------------

--
-- Estrutura para tabela `email`
--

CREATE TABLE `email` (
  `SQ_Contato` int(11) NOT NULL DEFAULT '0' COMMENT 'Seuquencial do Contato',
  `TP_Email` varchar(1) NOT NULL COMMENT 'Tipo de email',
  `Email` varchar(50) NOT NULL COMMENT 'Endereço de Email',
  PRIMARY KEY (`SQ_Contato`,`TP_Email`),
  KEY `CONTATOEMAIL` (`SQ_Contato`),
  KEY `SQ_CONTATO` (`SQ_Contato`),
  KEY `TIPO_EMAILEMAIL` (`TP_Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Email do contato';

--
-- RELACIONAMENTOS PARA TABELAS `email`:
--   `SQ_CONTATO`
--       `contato` -> `SQ_Contato`
--   `TP_Email`
--       `tipo_email` -> `TP_Email`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `endereco`
--

CREATE TABLE `endereco` (
  `SQ_Contato` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Contato',
  `TP_Endereco` varchar(1) NOT NULL DEFAULT '' COMMENT 'Tipo do Endereço',
  `CEP` int(8) DEFAULT NULL COMMENT 'CEP do endereço',
  `Rua` varchar(50) DEFAULT NULL COMMENT 'Nome da Rua',
  `Numero` varchar(50) DEFAULT NULL COMMENT 'Numero do Endereço',
  `Complemento` varchar(50) DEFAULT NULL COMMENT 'Complemento do Endereço',
  `Bairro` varchar(30) DEFAULT NULL COMMENT 'Bairro do Endereço',
  `Cidade` varchar(30) DEFAULT NULL COMMENT 'Cidade do Endereço',
  `CD_UF` varchar(2) DEFAULT NULL COMMENT 'Sigla da UF do Endereço',
  PRIMARY KEY (`SQ_Contato`,`TP_Endereco`),
  KEY `CONTATOENDERECO` (`SQ_Contato`),
  KEY `ESTADOENDERECO` (`CD_UF`),
  KEY `SQ_Contato` (`SQ_Contato`),
  KEY `TIPO_ENDERECOENDERECO` (`TP_Endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Endereço do contato';

--
-- RELACIONAMENTOS PARA TABELAS `endereco`:
--   `SQ_Contato`
--       `contato` -> `SQ_Contato`
--   `CD_UF`
--       `uf` -> `CD_UF`
--   `TP_Endereco`
--       `tipo_endereco` -> `TP_Endereco`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `escala`
--

CREATE TABLE `escala` (
  `SQ_Profissional` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Profissional',
  `DT_Ini_Escala` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data  Inicio da escala',
  `DT_Fim_Escala` date DEFAULT NULL COMMENT 'Data Fim da escalaalho',
  `Dia_Semana` int(1) NOT NULL COMMENT 'Dias de Trabalho(1a7)',
  `Intervalo_Atendimento` int(2) NOT NULL DEFAULT '0' COMMENT 'Intervalo entre os atendimentos(minutos)',
  `HR_Ini_Turno1` time NOT NULL DEFAULT '00:00:00' COMMENT 'Horario Inicial do 1o turno',
  `HR_Fim_Turno1` time NOT NULL DEFAULT '00:00:00' COMMENT 'Horario Final do 1o turno',
  `HR_Ini_Turno2` time DEFAULT '00:00:00' COMMENT 'Horario Inicial do 2o turno',
  `HR_Fim_Turno2` time DEFAULT '00:00:00' COMMENT 'Horario Final do 2o turno',
  PRIMARY KEY (`SQ_Profissional`,`DT_Ini_Escala`,`Dia_Semana`),
  KEY `PROFISSIONALHORARIO_TRABALHO_PROF` (`SQ_Profissional`),
  KEY `PrimaryKey` (`DT_Ini_Escala`,`SQ_Profissional`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Escala de Trabalho do profissional';

--
-- RELACIONAMENTOS PARA TABELAS `escala`:
--   `SQ_Profissional`
--       `profissional` -> `SQ_Profissional`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `especialidade`
--

CREATE TABLE `especialidade` (
  `SQ_Especialidade` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Especialidade',
  `SQ_Convenio` int(11) NOT NULL COMMENT 'Sequencial da Especialidade no Convenio',
  `SQ_Plano` int(11) NOT NULL COMMENT 'Sequencial do Plano no convenio',
  `NM_Especialidade` varchar(30) NOT NULL COMMENT 'Nome da Especialidade no convenio',
  `NR_Consultas_Semana` int(1) NOT NULL COMMENT 'Numero de consultas permitidas por semana',
  `DT_Ativacao` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de inicio da especialidade',
  `DT_Desativacao` date DEFAULT NULL COMMENT 'Data de Fim de atend da especialidade',
  PRIMARY KEY (`SQ_Especialidade`),
  UNIQUE KEY `PrimaryKey` (`SQ_Especialidade`,`SQ_Plano`,`SQ_Convenio`),
  KEY `especialidade_fk_3` (`SQ_Convenio`,`SQ_Plano`),
  KEY `iEspConvPlan` (`SQ_Especialidade`,`SQ_Convenio`,`SQ_Plano`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Especialidade atendida no convenio';

-- --------------------------------------------------------

--
-- Estrutura para tabela `especialidade_clinica`
--

CREATE TABLE `especialidade_clinica` (
  `SQ_Especialidade_Clinica` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Especialidade',
  `NM_Especialidade_Clinica` varchar(30) NOT NULL COMMENT 'Nome da Especialidade',
  `Tempo_Atendimento` int(2) NOT NULL COMMENT 'Tempo de atendimento(duracao em minutos)',
  PRIMARY KEY (`SQ_Especialidade_Clinica`),
  UNIQUE KEY `NM_Especialidade_Clinica` (`NM_Especialidade_Clinica`),
  KEY `PrimaryKey` (`SQ_Especialidade_Clinica`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Especialidades atendidas pela Clinica';

-- --------------------------------------------------------

--
-- Estrutura para tabela `operadora`
--

CREATE TABLE `operadora` (
  `SQ_Operadora` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Operadora',
  `CD_Operadora` tinyint(2) unsigned NOT NULL COMMENT 'Código da Operadora',
  `NM_Operadora` varchar(30) NOT NULL DEFAULT '' COMMENT 'Nome da Operadora',
  PRIMARY KEY (`SQ_Operadora`),
  UNIQUE KEY `CD_Operadora` (`CD_Operadora`),
  UNIQUE KEY `i_cd_operadora` (`CD_Operadora`),
  KEY `PrimaryKey` (`SQ_Operadora`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Operadora de Telefonia';

-- --------------------------------------------------------

--
-- Estrutura para tabela `plano`
--

CREATE TABLE `plano` (
  `SQ_Plano` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Plano',
  `SQ_Convenio` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Convenio',
  `NM_Plano` varchar(30) NOT NULL COMMENT 'Nome do Plano',
  `DT_Ativacao` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Ativacao do Plano',
  `DT_Desativacao` date DEFAULT '0000-00-00' COMMENT 'Data de Desativacao do Plano',
  PRIMARY KEY (`SQ_Convenio`,`SQ_Plano`),
  UNIQUE KEY `SQ_Plano` (`SQ_Plano`),
  UNIQUE KEY `SQ_Plano_2` (`SQ_Plano`),
  KEY `PLANOCOD` (`SQ_Plano`),
  KEY `PrimaryKey` (`SQ_Plano`,`SQ_Convenio`),
  KEY `CONVENIOPLANO` (`SQ_Convenio`),
  KEY `SQ_Convenio` (`SQ_Convenio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Plano Atendido do Convenio';

--
-- RELACIONAMENTOS PARA TABELAS `plano`:
--   `SQ_Convenio`
--       `convenio` -> `SQ_Convenio`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `profissional`
--

CREATE TABLE `profissional` (
  `SQ_Profissional` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Profissional',
  `SQ_Especialidade_Clinica` int(11) NOT NULL COMMENT 'Sequencial da Especialidade',
  `DT_Ativacao` date NOT NULL COMMENT 'Data de Ativação da Especialidade',
  `DT_Desativacao` date DEFAULT NULL COMMENT 'Data de Desativação da Especialidade',
  PRIMARY KEY (`SQ_Profissional`),
  KEY `PrimaryKey` (`SQ_Profissional`),
  KEY `CONTATOPROFISSIONAL` (`SQ_Profissional`),
  KEY `ESPECIALIDADE_CLINICAPROFISSIONAL` (`SQ_Especialidade_Clinica`),
  KEY `NOME` (`SQ_Especialidade_Clinica`),
  KEY `SQ_Profissional` (`SQ_Profissional`),
  KEY `SQ_Profissional_2` (`SQ_Profissional`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Profissional da Clinica';

--
-- RELACIONAMENTOS PARA TABELAS `profissional`:
--   `SQ_Especialidade_Clinica`
--       `especialidade_clinica` -> `SQ_Especialidade_Clinica`
--   `SQ_Profissional`
--       `contato` -> `SQ_Contato`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `relacionamento`
--

CREATE TABLE `relacionamento` (
  `SQ_Contato` int(11) NOT NULL COMMENT 'Sequencial do Contato',
  `TP_Relacao` varchar(1) NOT NULL COMMENT 'Tipo do Relacionamento',
  PRIMARY KEY (`SQ_Contato`,`TP_Relacao`),
  KEY `TP_Relacao` (`TP_Relacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Relacionamento do contato com  a clinica';

--
-- RELACIONAMENTOS PARA TABELAS `relacionamento`:
--   `SQ_Contato`
--       `contato` -> `SQ_Contato`
--   `TP_Relacao`
--       `tipo_relacionamento` -> `TP_Relacao`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `sala`
--

CREATE TABLE `sala` (
  `SQ_Sala` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Sala de Atendimento',
  `NM_Sala` varchar(30) NOT NULL COMMENT 'Nome da Sala de Atendimento',
  `DT_Ativacao` date DEFAULT '0000-00-00' COMMENT 'Data de Inicio de funcionamento',
  `DT_Desativacao` date DEFAULT '0000-00-00' COMMENT 'Data fim de func da Sala',
  PRIMARY KEY (`SQ_Sala`),
  KEY `PrimaryKey` (`SQ_Sala`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Salas de Atendimento';

-- --------------------------------------------------------

--
-- Estrutura para tabela `situacao_consulta`
--

CREATE TABLE `situacao_consulta` (
  `TP_Situacao_Consulta` varchar(1) NOT NULL DEFAULT '' COMMENT 'Tipo de Situacao da Consulta',
  `NM_Situacao_Consulta` varchar(30) NOT NULL COMMENT 'Nome da Situacao da Consulta',
  PRIMARY KEY (`TP_Situacao_Consulta`),
  KEY `PrimaryKey` (`TP_Situacao_Consulta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Situação da Consulta';

-- --------------------------------------------------------

--
-- Estrutura para tabela `telefone`
--

CREATE TABLE `telefone` (
  `SQ_Contato` int(11) NOT NULL COMMENT 'Sequencial do Contato',
  `TP_Mobilidade` varchar(1) NOT NULL COMMENT 'Tipo de Mobilidade (Fixo/Movel)',
  `TP_Uso` varchar(1) NOT NULL COMMENT 'Tiopo de uso (Pessoal/Resid/Comercial/Parente)',
  `CD_DDD` int(2) DEFAULT '61' COMMENT 'Código DDD do telefone',
  `NR_Telefone` int(11) NOT NULL DEFAULT '0' COMMENT 'Nro do Telefone(sem DDD)',
  `SQ_Operadora` int(2) NOT NULL COMMENT 'Seq da Operadora de Telefonia',
  PRIMARY KEY (`SQ_Contato`,`NR_Telefone`),
  KEY `CONTATOTELEFONE` (`SQ_Contato`),
  KEY `OPERADORATELEFONE` (`SQ_Operadora`),
  KEY `SQ_Contato` (`SQ_Contato`),
  KEY `TIPO_MOBILIDADETELEFONE` (`TP_Mobilidade`),
  KEY `TIPO_USOTELEFONE` (`TP_Uso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Telefones dos Contatos';

--
-- RELACIONAMENTOS PARA TABELAS `telefone`:
--   `SQ_Contato`
--       `contato` -> `SQ_Contato`
--   `TP_Uso`
--       `tipo_uso` -> `TP_Uso`
--   `SQ_Operadora`
--       `operadora` -> `SQ_Operadora`
--   `TP_Mobilidade`
--       `tipo_mobilidade` -> `TP_Mobilidade`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_email`
--

CREATE TABLE `tipo_email` (
  `TP_Email` varchar(1) NOT NULL DEFAULT '' COMMENT 'Tipo de Email',
  `NM_Tipo_Email` varchar(30) NOT NULL COMMENT 'Nome do tipo de email',
  PRIMARY KEY (`TP_Email`),
  KEY `PrimaryKey` (`TP_Email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tipo de email';

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_endereco`
--

CREATE TABLE `tipo_endereco` (
  `TP_Endereco` varchar(1) NOT NULL COMMENT 'Tipo do endereço',
  `NM_Tipo_Endereco` varchar(30) NOT NULL COMMENT 'Nome do Tipo do endereço',
  PRIMARY KEY (`TP_Endereco`),
  KEY `PrimaryKey` (`TP_Endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tipo de Endereço';

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_mobilidade`
--

CREATE TABLE `tipo_mobilidade` (
  `TP_Mobilidade` varchar(1) NOT NULL COMMENT 'Tipo de Mobilidade do Telefone',
  `NM_Tipo_Mobilidade` varchar(30) NOT NULL COMMENT 'Nome do tipo da mobilidade',
  PRIMARY KEY (`TP_Mobilidade`),
  KEY `PrimaryKey` (`TP_Mobilidade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tipo de mobilidade do Telefone';

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_relacionamento`
--

CREATE TABLE `tipo_relacionamento` (
  `TP_Relacao` varchar(1) NOT NULL COMMENT 'Tipo do Relação com a Clinica',
  `NM_Tipo_Relacao` varchar(30) NOT NULL COMMENT 'Nome do Tipo da  Relação',
  PRIMARY KEY (`TP_Relacao`),
  KEY `PrimaryKey` (`TP_Relacao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tipo de Relacionamentno';

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_uso`
--

CREATE TABLE `tipo_uso` (
  `TP_Uso` varchar(1) NOT NULL COMMENT 'Tipo de uso do telefone',
  `NM_Tipo_Uso` varchar(30) NOT NULL COMMENT 'Nome do tipo de uso do telefone',
  PRIMARY KEY (`TP_Uso`),
  KEY `PrimaryKey` (`TP_Uso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tipo de uso do telefone';

-- --------------------------------------------------------

--
-- Estrutura para tabela `uf`
--

CREATE TABLE `uf` (
  `CD_UF` varchar(2) NOT NULL COMMENT 'Sigla da UF',
  `NM_UF` varchar(30) NOT NULL COMMENT 'Nome da UF',
  PRIMARY KEY (`CD_UF`),
  KEY `PrimaryKey` (`CD_UF`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Unidades da Federação';

-- --------------------------------------------------------

--
-- Estrutura para tabela `valor`
--

CREATE TABLE `valor` (
  `SQ_Valor` int(11) NOT NULL AUTO_INCREMENT,
  `SQ_Convenio` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Convenio',
  `SQ_Plano` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Plano',
  `SQ_Especialidade` int(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial da Especialidade',
  `DT_Ativacao` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Ativaçao da Especialidade no Plano/Convenio',
  `DT_Desativacao` date DEFAULT '0000-00-00' COMMENT 'Data de Desativacao da Especialidade no Convenio/plano',
  `VL_Consulta` decimal(10,2) DEFAULT NULL COMMENT 'Valor da Consulta',
  PRIMARY KEY (`SQ_Valor`),
  UNIQUE KEY `SQ_Convenio` (`SQ_Convenio`,`SQ_Plano`,`SQ_Especialidade`,`DT_Ativacao`),
  KEY `PrimaryKey` (`DT_Ativacao`,`SQ_Especialidade`,`SQ_Plano`,`SQ_Convenio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Valor Pago pelo Convenio';

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `consulta`
--
ALTER TABLE `consulta`
  ADD CONSTRAINT `consulta_ibfk_1` FOREIGN KEY (`SQ_Contato_Paciente`) REFERENCES `contato` (`SQ_Contato`),
  ADD CONSTRAINT `consulta_ibfk_2` FOREIGN KEY (`SQ_Contato_Profissional`) REFERENCES `profissional` (`SQ_Profissional`),
  ADD CONSTRAINT `consulta_ibfk_3` FOREIGN KEY (`SQ_Sala`) REFERENCES `sala` (`SQ_Sala`),
  ADD CONSTRAINT `consulta_ibfk_6` FOREIGN KEY (`TP_Situcacao_Consulta`) REFERENCES `situacao_consulta` (`TP_Situacao_Consulta`);

--
-- Restrições para tabelas `contato_plano`
--
ALTER TABLE `contato_plano`
  ADD CONSTRAINT `contato_plano_ibfk_1` FOREIGN KEY (`SQ_Convenio`) REFERENCES `plano` (`SQ_Convenio`),
  ADD CONSTRAINT `contato_plano_ibfk_2` FOREIGN KEY (`SQ_Plano`) REFERENCES `plano` (`SQ_Plano`),
  ADD CONSTRAINT `contato_plano_ibfk_3` FOREIGN KEY (`SQ_Contato`) REFERENCES `contato` (`SQ_Contato`);

--
-- Restrições para tabelas `email`
--
ALTER TABLE `email`
  ADD CONSTRAINT `email_ibfk_1` FOREIGN KEY (`SQ_CONTATO`) REFERENCES `contato` (`SQ_Contato`),
  ADD CONSTRAINT `email_ibfk_2` FOREIGN KEY (`TP_Email`) REFERENCES `tipo_email` (`TP_Email`);

--
-- Restrições para tabelas `endereco`
--
ALTER TABLE `endereco`
  ADD CONSTRAINT `endereco_ibfk_1` FOREIGN KEY (`SQ_Contato`) REFERENCES `contato` (`SQ_Contato`),
  ADD CONSTRAINT `endereco_ibfk_3` FOREIGN KEY (`CD_UF`) REFERENCES `uf` (`CD_UF`),
  ADD CONSTRAINT `endereco_ibfk_4` FOREIGN KEY (`TP_Endereco`) REFERENCES `tipo_endereco` (`TP_Endereco`);

--
-- Restrições para tabelas `escala`
--
ALTER TABLE `escala`
  ADD CONSTRAINT `escala_ibfk_1` FOREIGN KEY (`SQ_Profissional`) REFERENCES `profissional` (`SQ_Profissional`);

--
-- Restrições para tabelas `especialidade`
--
ALTER TABLE `especialidade`
  ADD CONSTRAINT `especialidade_fk_3` FOREIGN KEY (`SQ_Convenio`, `SQ_Plano`) REFERENCES `plano` (`SQ_Convenio`, `SQ_Plano`);

--
-- Restrições para tabelas `plano`
--
ALTER TABLE `plano`
  ADD CONSTRAINT `plano_ibfk_1` FOREIGN KEY (`SQ_Convenio`) REFERENCES `convenio` (`SQ_Convenio`);

--
-- Restrições para tabelas `profissional`
--
ALTER TABLE `profissional`
  ADD CONSTRAINT `profissional_ibfk_2` FOREIGN KEY (`SQ_Especialidade_Clinica`) REFERENCES `especialidade_clinica` (`SQ_Especialidade_Clinica`),
  ADD CONSTRAINT `profissional_ibfk_3` FOREIGN KEY (`SQ_Profissional`) REFERENCES `contato` (`SQ_Contato`);

--
-- Restrições para tabelas `relacionamento`
--
ALTER TABLE `relacionamento`
  ADD CONSTRAINT `relacionamento_ibfk_1` FOREIGN KEY (`SQ_Contato`) REFERENCES `contato` (`SQ_Contato`),
  ADD CONSTRAINT `relacionamento_ibfk_2` FOREIGN KEY (`TP_Relacao`) REFERENCES `tipo_relacionamento` (`TP_Relacao`);

--
-- Restrições para tabelas `telefone`
--
ALTER TABLE `telefone`
  ADD CONSTRAINT `telefone_ibfk_1` FOREIGN KEY (`SQ_Contato`) REFERENCES `contato` (`SQ_Contato`),
  ADD CONSTRAINT `telefone_ibfk_2` FOREIGN KEY (`TP_Uso`) REFERENCES `tipo_uso` (`TP_Uso`),
  ADD CONSTRAINT `telefone_ibfk_3` FOREIGN KEY (`SQ_Operadora`) REFERENCES `operadora` (`SQ_Operadora`),
  ADD CONSTRAINT `telefone_ibfk_4` FOREIGN KEY (`TP_Mobilidade`) REFERENCES `tipo_mobilidade` (`TP_Mobilidade`);

--
-- Restrições para tabelas `valor`
--
ALTER TABLE `valor`
  ADD CONSTRAINT `fk_ConvPlanEsp` FOREIGN KEY (`SQ_Convenio`, `SQ_Plano`, `SQ_Especialidade`) REFERENCES `especialidade` (`SQ_Convenio`, `SQ_Plano`, `SQ_Especialidade`);
