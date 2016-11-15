SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

SHOW WARNINGS;
DROP SCHEMA IF EXISTS `db_clinica` ;
CREATE SCHEMA IF NOT EXISTS `db_clinica` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `db_clinica` ;

-- -----------------------------------------------------
-- Table `db_clinica`.`contato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`contato` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`contato` (
  `SQ_Contato` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Contato',
  `NM_Contato` VARCHAR(50) NOT NULL COMMENT 'Nome do Contato',
  `DT_Nascimento` DATE NULL DEFAULT NULL COMMENT 'Data de Nascimento',
  `Identificacao` VARCHAR(50) NULL DEFAULT NULL COMMENT 'CPF/CNPJ DO Contato',
  `Observacoes` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'Observações importantes do contato',
  PRIMARY KEY (`SQ_Contato`))
ENGINE = InnoDB
AUTO_INCREMENT = 19
DEFAULT CHARACTER SET = latin1
COMMENT = 'Contatos da Clinica';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`contato` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `NOME` ON `db_clinica`.`contato` (`NM_Contato` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`especialidade_clinica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`especialidade_clinica` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`especialidade_clinica` (
  `SQ_Especialidade_Clinica` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Especialidade',
  `NM_Especialidade_Clinica` VARCHAR(30) NOT NULL COMMENT 'Nome da Especialidade',
  `Tempo_Atendimento` INT(2) NOT NULL COMMENT 'Tempo de atendimento(duracao em minutos)',
  PRIMARY KEY (`SQ_Especialidade_Clinica`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1
COMMENT = 'Especialidades atendidas pela Clinica';

SHOW WARNINGS;
CREATE UNIQUE INDEX `NM_Especialidade_Clinica` ON `db_clinica`.`especialidade_clinica` (`NM_Especialidade_Clinica` ASC);

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`especialidade_clinica` (`SQ_Especialidade_Clinica` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`profissional`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`profissional` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`profissional` (
  `SQ_Profissional` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Profissional',
  `SQ_Especialidade_Clinica` INT(11) NOT NULL COMMENT 'Sequencial da Especialidade',
  `DT_Ativacao` DATE NOT NULL COMMENT 'Data de Ativação da Especialidade',
  `DT_Desativacao` DATE NULL DEFAULT NULL COMMENT 'Data de Desativação da Especialidade',
  PRIMARY KEY (`SQ_Profissional`),
  CONSTRAINT `profissional_ibfk_2`
    FOREIGN KEY (`SQ_Especialidade_Clinica`)
    REFERENCES `db_clinica`.`especialidade_clinica` (`SQ_Especialidade_Clinica`),
  CONSTRAINT `profissional_ibfk_3`
    FOREIGN KEY (`SQ_Profissional`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Profissional da Clinica';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`profissional` (`SQ_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `CONTATOPROFISSIONAL` ON `db_clinica`.`profissional` (`SQ_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `ESPECIALIDADE_CLINICAPROFISSIONAL` ON `db_clinica`.`profissional` (`SQ_Especialidade_Clinica` ASC);

SHOW WARNINGS;
CREATE INDEX `NOME` ON `db_clinica`.`profissional` (`SQ_Especialidade_Clinica` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Profissional` ON `db_clinica`.`profissional` (`SQ_Profissional` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`sala`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`sala` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`sala` (
  `SQ_Sala` INT(2) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Sala de Atendimento',
  `NM_Sala` VARCHAR(30) NOT NULL COMMENT 'Nome da Sala de Atendimento',
  `DT_Ativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data de Inicio de funcionamento',
  `DT_Desativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data fim de func da Sala',
  PRIMARY KEY (`SQ_Sala`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1
COMMENT = 'Salas de Atendimento';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`sala` (`SQ_Sala` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`situacao_consulta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`situacao_consulta` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`situacao_consulta` (
  `TP_Situacao_Consulta` VARCHAR(1) NOT NULL DEFAULT '' COMMENT 'Tipo de Situacao da Consulta',
  `NM_Situacao_Consulta` VARCHAR(30) NOT NULL COMMENT 'Nome da Situacao da Consulta',
  PRIMARY KEY (`TP_Situacao_Consulta`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Situação da Consulta';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`situacao_consulta` (`TP_Situacao_Consulta` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`consulta`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`consulta` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`consulta` (
  `DT_Consulta` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data da Consulta',
  `HR_Consulta` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'Hora da Consulta',
  `SQ_Contato_Paciente` INT(11) NULL DEFAULT NULL COMMENT 'Sequencial do Contato do Paciente',
  `SQ_Contato_Profissional` INT(11) NULL DEFAULT NULL COMMENT 'Sequencial do Contato do Profissional',
  `SQ_Sala` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial da Sala',
  `TP_Situcacao_Consulta` VARCHAR(1) NOT NULL COMMENT 'Situacão da Consulta',
  PRIMARY KEY (`DT_Consulta`, `HR_Consulta`, `SQ_Sala`),
  CONSTRAINT `consulta_ibfk_1`
    FOREIGN KEY (`SQ_Contato_Paciente`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `consulta_ibfk_2`
    FOREIGN KEY (`SQ_Contato_Profissional`)
    REFERENCES `db_clinica`.`profissional` (`SQ_Profissional`),
  CONSTRAINT `consulta_ibfk_3`
    FOREIGN KEY (`SQ_Sala`)
    REFERENCES `db_clinica`.`sala` (`SQ_Sala`),
  CONSTRAINT `consulta_ibfk_6`
    FOREIGN KEY (`TP_Situcacao_Consulta`)
    REFERENCES `db_clinica`.`situacao_consulta` (`TP_Situacao_Consulta`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Informações sobre as consultas';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`consulta` (`HR_Consulta` ASC, `DT_Consulta` ASC);

SHOW WARNINGS;
CREATE INDEX `COD_PAC` ON `db_clinica`.`consulta` (`SQ_Contato_Paciente` ASC);

SHOW WARNINGS;
CREATE INDEX `COD_PROF` ON `db_clinica`.`consulta` (`SQ_Contato_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `COD_SALA` ON `db_clinica`.`consulta` (`SQ_Sala` ASC);

SHOW WARNINGS;
CREATE INDEX `PACIENTECONSULTA` ON `db_clinica`.`consulta` (`SQ_Contato_Paciente` ASC);

SHOW WARNINGS;
CREATE INDEX `PROFISSIONALCONSULTA` ON `db_clinica`.`consulta` (`SQ_Contato_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `SALACONSULTA` ON `db_clinica`.`consulta` (`SQ_Sala` ASC);

SHOW WARNINGS;
CREATE INDEX `SITUACAO_CONSULTACONSULTA` ON `db_clinica`.`consulta` (`TP_Situcacao_Consulta` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato_Paciente` ON `db_clinica`.`consulta` (`SQ_Contato_Paciente` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato_Profissional` ON `db_clinica`.`consulta` (`SQ_Contato_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Sala` ON `db_clinica`.`consulta` (`SQ_Sala` ASC);

SHOW WARNINGS;
CREATE INDEX `DT_Consulta` ON `db_clinica`.`consulta` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Contato_Paciente` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato_Paciente_2` ON `db_clinica`.`consulta` (`SQ_Contato_Paciente` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC);

SHOW WARNINGS;
CREATE INDEX `DT_Consulta_2` ON `db_clinica`.`consulta` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Contato_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato_Profissional_2` ON `db_clinica`.`consulta` (`SQ_Contato_Profissional` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato_Profissional_3` ON `db_clinica`.`consulta` (`SQ_Contato_Profissional` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato_Profissional_4` ON `db_clinica`.`consulta` (`SQ_Contato_Profissional` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC);

SHOW WARNINGS;
CREATE INDEX `DT_Consulta_3` ON `db_clinica`.`consulta` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Sala` ASC);

SHOW WARNINGS;
CREATE INDEX `DT_Consulta_4` ON `db_clinica`.`consulta` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Sala` ASC);

SHOW WARNINGS;
CREATE INDEX `DT_Consulta_5` ON `db_clinica`.`consulta` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Sala` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Sala_2` ON `db_clinica`.`consulta` (`SQ_Sala` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`convenio`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`convenio` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`convenio` (
  `SQ_Convenio` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Convenio',
  `NM_Convenio` VARCHAR(30) NOT NULL COMMENT 'Nome do convenio',
  `DT_Ativacao` DATE NOT NULL COMMENT 'Data de Ativação do Convenio',
  `DT_Desativacao` DATE NULL DEFAULT NULL COMMENT 'Data de Desativaçao do convenio',
  PRIMARY KEY (`SQ_Convenio`))
ENGINE = InnoDB
AUTO_INCREMENT = 29
DEFAULT CHARACTER SET = latin1
COMMENT = 'Convênios Atendidos';

SHOW WARNINGS;
CREATE UNIQUE INDEX `NM_Convenio` ON `db_clinica`.`convenio` (`NM_Convenio` ASC);

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`convenio` (`SQ_Convenio` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`plano`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`plano` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`plano` (
  `SQ_Plano` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Plano',
  `SQ_Convenio` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Convenio',
  `NM_Plano` VARCHAR(30) NOT NULL COMMENT 'Nome do Plano',
  `DT_Ativacao` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Ativacao do Plano',
  `DT_Desativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data de Desativacao do Plano',
  PRIMARY KEY (`SQ_Convenio`, `SQ_Plano`),
  CONSTRAINT `plano_ibfk_1`
    FOREIGN KEY (`SQ_Convenio`)
    REFERENCES `db_clinica`.`convenio` (`SQ_Convenio`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1
COMMENT = 'Plano Atendido do Convenio';

SHOW WARNINGS;
CREATE UNIQUE INDEX `SQ_Plano` ON `db_clinica`.`plano` (`SQ_Plano` ASC);

SHOW WARNINGS;
CREATE UNIQUE INDEX `SQ_Plano_2` ON `db_clinica`.`plano` (`SQ_Plano` ASC);

SHOW WARNINGS;
CREATE INDEX `PLANOCOD` ON `db_clinica`.`plano` (`SQ_Plano` ASC);

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`plano` (`SQ_Plano` ASC, `SQ_Convenio` ASC);

SHOW WARNINGS;
CREATE INDEX `CONVENIOPLANO` ON `db_clinica`.`plano` (`SQ_Convenio` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Convenio` ON `db_clinica`.`plano` (`SQ_Convenio` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`contato_plano`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`contato_plano` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`contato_plano` (
  `SQ_Contato` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Contato',
  `DT_Validade` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Validade do Plano',
  `NR_Inscricao` INT(11) NULL DEFAULT NULL COMMENT 'Numero de Inscrição do Paciente no Plnao',
  `SQ_Plano` INT(11) NOT NULL,
  PRIMARY KEY (`DT_Validade`, `SQ_Contato`, `SQ_Plano`),
  CONSTRAINT `contato_plano_ibfk_3`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `SQ_Plano`
    FOREIGN KEY (`SQ_Plano`)
    REFERENCES `db_clinica`.`plano` (`SQ_Plano`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'Relacao entre Contato e Plano';

SHOW WARNINGS;
CREATE INDEX `CONTATOCONTATO_PLANO` ON `db_clinica`.`contato_plano` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato` ON `db_clinica`.`contato_plano` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`contato_plano` (`DT_Validade` ASC, `SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Plano_idx` ON `db_clinica`.`contato_plano` (`SQ_Plano` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`tipo_email` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_email` (
  `TP_Email` VARCHAR(1) NOT NULL DEFAULT '' COMMENT 'Tipo de Email',
  `NM_Tipo_Email` VARCHAR(30) NOT NULL COMMENT 'Nome do tipo de email',
  PRIMARY KEY (`TP_Email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de email';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`tipo_email` (`TP_Email` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`email`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`email` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`email` (
  `SQ_Contato` INT(11) NOT NULL DEFAULT '0' COMMENT 'Seuquencial do Contato',
  `TP_Email` VARCHAR(1) NOT NULL COMMENT 'Tipo de email',
  `Email` VARCHAR(50) NOT NULL COMMENT 'Endereço de Email',
  PRIMARY KEY (`SQ_Contato`, `TP_Email`),
  CONSTRAINT `email_ibfk_1`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `email_ibfk_2`
    FOREIGN KEY (`TP_Email`)
    REFERENCES `db_clinica`.`tipo_email` (`TP_Email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Email do contato';

SHOW WARNINGS;
CREATE INDEX `CONTATOEMAIL` ON `db_clinica`.`email` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_CONTATO` ON `db_clinica`.`email` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `TIPO_EMAILEMAIL` ON `db_clinica`.`email` (`TP_Email` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`uf`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`uf` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`uf` (
  `CD_UF` VARCHAR(2) NOT NULL COMMENT 'Sigla da UF',
  `NM_UF` VARCHAR(30) NOT NULL COMMENT 'Nome da UF',
  PRIMARY KEY (`CD_UF`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Unidades da Federação';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`uf` (`CD_UF` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_endereco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`tipo_endereco` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_endereco` (
  `TP_Endereco` VARCHAR(1) NOT NULL COMMENT 'Tipo do endereço',
  `NM_Tipo_Endereco` VARCHAR(30) NOT NULL COMMENT 'Nome do Tipo do endereço',
  PRIMARY KEY (`TP_Endereco`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de Endereço';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`tipo_endereco` (`TP_Endereco` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`endereco`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`endereco` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`endereco` (
  `SQ_Contato` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Contato',
  `TP_Endereco` VARCHAR(1) NOT NULL DEFAULT '' COMMENT 'Tipo do Endereço',
  `CEP` INT(8) NULL DEFAULT NULL COMMENT 'CEP do endereço',
  `Rua` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Nome da Rua',
  `Numero` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Numero do Endereço',
  `Complemento` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Complemento do Endereço',
  `Bairro` VARCHAR(30) NULL DEFAULT NULL COMMENT 'Bairro do Endereço',
  `Cidade` VARCHAR(30) NULL DEFAULT NULL COMMENT 'Cidade do Endereço',
  `CD_UF` VARCHAR(2) NULL DEFAULT NULL COMMENT 'Sigla da UF do Endereço',
  PRIMARY KEY (`SQ_Contato`, `TP_Endereco`),
  CONSTRAINT `endereco_ibfk_1`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `endereco_ibfk_3`
    FOREIGN KEY (`CD_UF`)
    REFERENCES `db_clinica`.`uf` (`CD_UF`),
  CONSTRAINT `endereco_ibfk_4`
    FOREIGN KEY (`TP_Endereco`)
    REFERENCES `db_clinica`.`tipo_endereco` (`TP_Endereco`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Endereço do contato';

SHOW WARNINGS;
CREATE INDEX `CONTATOENDERECO` ON `db_clinica`.`endereco` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `ESTADOENDERECO` ON `db_clinica`.`endereco` (`CD_UF` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato` ON `db_clinica`.`endereco` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `TIPO_ENDERECOENDERECO` ON `db_clinica`.`endereco` (`TP_Endereco` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`escala`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`escala` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`escala` (
  `SQ_Profissional` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Profissional',
  `DT_Ini_Escala` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data  Inicio da escala',
  `DT_Fim_Escala` DATE NULL DEFAULT NULL COMMENT 'Data Fim da escalaalho',
  `Dia_Semana` INT(1) NOT NULL COMMENT 'Dias de Trabalho(1a7)',
  `Intervalo_Atendimento` INT(2) NOT NULL DEFAULT '0' COMMENT 'Intervalo entre os atendimentos(minutos)',
  `HR_Ini_Turno1` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'Horario Inicial do 1o turno',
  `HR_Fim_Turno1` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'Horario Final do 1o turno',
  `HR_Ini_Turno2` TIME NULL DEFAULT '00:00:00' COMMENT 'Horario Inicial do 2o turno',
  `HR_Fim_Turno2` TIME NULL DEFAULT '00:00:00' COMMENT 'Horario Final do 2o turno',
  CONSTRAINT `escala_ibfk_1`
    FOREIGN KEY (`SQ_Profissional`)
    REFERENCES `db_clinica`.`profissional` (`SQ_Profissional`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB
COMMENT = 'Escala de Trabalho do profissional';

SHOW WARNINGS;
CREATE INDEX `PROFISSIONALHORARIO_TRABALHO_PROF` ON `db_clinica`.`escala` (`SQ_Profissional` ASC);

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`escala` (`DT_Ini_Escala` ASC, `SQ_Profissional` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`especialidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`especialidade` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`especialidade` (
  `SQ_Especialidade` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Especialidade',
  `SQ_Convenio` INT(11) NOT NULL COMMENT 'Sequencial da Especialidade no Convenio',
  `SQ_Plano` INT(11) NOT NULL COMMENT 'Sequencial do Plano no convenio',
  `NM_Especialidade` VARCHAR(30) NOT NULL COMMENT 'Nome da Especialidade no convenio',
  `NR_Consultas_Semana` INT(1) NOT NULL COMMENT 'Numero de consultas permitidas por semana',
  `DT_Ativacao` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de inicio da especialidade',
  `DT_Desativacao` DATE NULL DEFAULT NULL COMMENT 'Data de Fim de atend da especialidade',
  PRIMARY KEY (`SQ_Especialidade`),
  CONSTRAINT `especialidade_fk_3`
    FOREIGN KEY (`SQ_Convenio` , `SQ_Plano`)
    REFERENCES `db_clinica`.`plano` (`SQ_Convenio` , `SQ_Plano`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = latin1
COMMENT = 'Especialidade atendida no convenio';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`especialidade` (`SQ_Especialidade` ASC, `SQ_Plano` ASC, `SQ_Convenio` ASC);

SHOW WARNINGS;
CREATE INDEX `especialidade_fk_3` ON `db_clinica`.`especialidade` (`SQ_Convenio` ASC, `SQ_Plano` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`operadora`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`operadora` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`operadora` (
  `SQ_Operadora` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Operadora',
  `CD_Operadora` TINYINT(2) UNSIGNED NOT NULL COMMENT 'Código da Operadora',
  `NM_Operadora` VARCHAR(30) NOT NULL DEFAULT '' COMMENT 'Nome da Operadora',
  PRIMARY KEY (`SQ_Operadora`))
ENGINE = InnoDB
AUTO_INCREMENT = 47
DEFAULT CHARACTER SET = latin1
COMMENT = 'Operadora de Telefonia';

SHOW WARNINGS;
CREATE UNIQUE INDEX `CD_Operadora` ON `db_clinica`.`operadora` (`CD_Operadora` ASC);

SHOW WARNINGS;
CREATE UNIQUE INDEX `i_cd_operadora` ON `db_clinica`.`operadora` (`CD_Operadora` ASC);

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`operadora` (`SQ_Operadora` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_relacionamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`tipo_relacionamento` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_relacionamento` (
  `TP_Relacao` VARCHAR(1) NOT NULL COMMENT 'Tipo do Relação com a Clinica',
  `NM_Tipo_Relacao` VARCHAR(30) NOT NULL COMMENT 'Nome do Tipo da  Relação',
  PRIMARY KEY (`TP_Relacao`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de Relacionamentno';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`tipo_relacionamento` (`TP_Relacao` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`relacionamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`relacionamento` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`relacionamento` (
  `SQ_Contato` INT(11) NOT NULL COMMENT 'Sequencial do Contato',
  `TP_Relacao` VARCHAR(1) NOT NULL COMMENT 'Tipo do Relacionamento',
  PRIMARY KEY (`SQ_Contato`, `TP_Relacao`),
  CONSTRAINT `relacionamento_ibfk_1`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `relacionamento_ibfk_2`
    FOREIGN KEY (`TP_Relacao`)
    REFERENCES `db_clinica`.`tipo_relacionamento` (`TP_Relacao`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Relacionamento do contato com  a clinica';

SHOW WARNINGS;
CREATE INDEX `TP_Relacao` ON `db_clinica`.`relacionamento` (`TP_Relacao` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_uso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`tipo_uso` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_uso` (
  `TP_Uso` VARCHAR(1) NOT NULL COMMENT 'Tipo de uso do telefone',
  `NM_Tipo_Uso` VARCHAR(30) NOT NULL COMMENT 'Nome do tipo de uso do telefone',
  PRIMARY KEY (`TP_Uso`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de uso do telefone';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`tipo_uso` (`TP_Uso` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_mobilidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`tipo_mobilidade` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_mobilidade` (
  `TP_Mobilidade` VARCHAR(1) NOT NULL COMMENT 'Tipo de Mobilidade do Telefone',
  `NM_Tipo_Mobilidade` VARCHAR(30) NOT NULL COMMENT 'Nome do tipo da mobilidade',
  PRIMARY KEY (`TP_Mobilidade`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de mobilidade do Telefone';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`tipo_mobilidade` (`TP_Mobilidade` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`telefone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`telefone` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`telefone` (
  `SQ_Contato` INT(11) NOT NULL COMMENT 'Sequencial do Contato',
  `TP_Mobilidade` VARCHAR(1) NOT NULL COMMENT 'Tipo de Mobilidade (Fixo/Movel)',
  `TP_Uso` VARCHAR(1) NOT NULL COMMENT 'Tiopo de uso (Pessoal/Resid/Comercial/Parente)',
  `CD_DDD` INT(2) NULL DEFAULT '61' COMMENT 'Código DDD do telefone',
  `NR_Telefone` INT(11) NOT NULL DEFAULT '0' COMMENT 'Nro do Telefone(sem DDD)',
  `SQ_Operadora` INT(2) NOT NULL COMMENT 'Seq da Operadora de Telefonia',
  PRIMARY KEY (`SQ_Contato`, `NR_Telefone`),
  CONSTRAINT `telefone_ibfk_1`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `telefone_ibfk_2`
    FOREIGN KEY (`TP_Uso`)
    REFERENCES `db_clinica`.`tipo_uso` (`TP_Uso`),
  CONSTRAINT `telefone_ibfk_3`
    FOREIGN KEY (`SQ_Operadora`)
    REFERENCES `db_clinica`.`operadora` (`SQ_Operadora`),
  CONSTRAINT `telefone_ibfk_4`
    FOREIGN KEY (`TP_Mobilidade`)
    REFERENCES `db_clinica`.`tipo_mobilidade` (`TP_Mobilidade`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Telefones dos Contatos';

SHOW WARNINGS;
CREATE INDEX `CONTATOTELEFONE` ON `db_clinica`.`telefone` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `OPERADORATELEFONE` ON `db_clinica`.`telefone` (`SQ_Operadora` ASC);

SHOW WARNINGS;
CREATE INDEX `SQ_Contato` ON `db_clinica`.`telefone` (`SQ_Contato` ASC);

SHOW WARNINGS;
CREATE INDEX `TIPO_MOBILIDADETELEFONE` ON `db_clinica`.`telefone` (`TP_Mobilidade` ASC);

SHOW WARNINGS;
CREATE INDEX `TIPO_USOTELEFONE` ON `db_clinica`.`telefone` (`TP_Uso` ASC);

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `db_clinica`.`valor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `db_clinica`.`valor` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `db_clinica`.`valor` (
  `SQ_Valor` INT(11) NOT NULL AUTO_INCREMENT,
  `SQ_Convenio` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Convenio',
  `SQ_Plano` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Plano',
  `SQ_Especialidade` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial da Especialidade',
  `DT_Ativacao` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Ativaçao da Especialidade no Plano/Convenio',
  `DT_Desativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data de Desativacao da Especialidade no Convenio/plano',
  `VL_Consulta` DECIMAL(10,2) NULL DEFAULT NULL COMMENT 'Valor da Consulta',
  PRIMARY KEY (`SQ_Valor`),
  CONSTRAINT `fk_EspPlanConv`
    FOREIGN KEY (`SQ_Especialidade` , `SQ_Plano` , `SQ_Convenio`)
    REFERENCES `db_clinica`.`especialidade` (`SQ_Especialidade` , `SQ_Plano` , `SQ_Convenio`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
COMMENT = 'Valor Pago pelo Convenio';

SHOW WARNINGS;
CREATE INDEX `PrimaryKey` ON `db_clinica`.`valor` (`DT_Ativacao` ASC, `SQ_Especialidade` ASC, `SQ_Plano` ASC, `SQ_Convenio` ASC);

SHOW WARNINGS;
CREATE INDEX `CONVENIO_VALORESSQ_Plano` ON `db_clinica`.`valor` (`SQ_Plano` ASC);

SHOW WARNINGS;
CREATE INDEX `ESPECIALIDADECONVENIO_VALORES` ON `db_clinica`.`valor` (`SQ_Especialidade` ASC, `SQ_Plano` ASC, `SQ_Convenio` ASC);

SHOW WARNINGS;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
