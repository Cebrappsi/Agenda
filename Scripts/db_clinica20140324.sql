SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `db_clinica` DEFAULT CHARACTER SET utf8 ;
USE `db_clinica` ;

-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_situacao_consulta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_situacao_consulta` (
  `TP_Situacao_Consulta` VARCHAR(1) NOT NULL DEFAULT '' COMMENT 'Tipo de Situacao da Consulta',
  `NM_Tipo_Situacao_Consulta` VARCHAR(30) NOT NULL COMMENT 'Nome do Tipo da Situacao da Consulta',
  PRIMARY KEY (`TP_Situacao_Consulta`),
  INDEX `PrimaryKey` (`TP_Situacao_Consulta` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo da Situação da Consulta';


-- -----------------------------------------------------
-- Table `db_clinica`.`contato`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`contato` (
  `SQ_Contato` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Contato',
  `NM_Contato` VARCHAR(50) NOT NULL COMMENT 'Nome do Contato',
  `DT_Nascimento` DATE NULL DEFAULT NULL COMMENT 'Data de Nascimento',
  `Identificacao` VARCHAR(50) NULL DEFAULT NULL COMMENT 'CPF/CNPJ DO Contato',
  `Observacoes` VARCHAR(1000) NULL DEFAULT NULL COMMENT 'Observações importantes do contato',
  PRIMARY KEY (`SQ_Contato`),
  INDEX `PrimaryKey` (`SQ_Contato` ASC),
  INDEX `NOME` (`NM_Contato` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 43
DEFAULT CHARACTER SET = latin1
COMMENT = 'Contatos da Clinica';


-- -----------------------------------------------------
-- Table `db_clinica`.`convenio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`convenio` (
  `SQ_Convenio` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Convenio',
  `NM_Convenio` VARCHAR(30) NOT NULL COMMENT 'Nome do convenio',
  `DT_Ativacao` DATE NOT NULL COMMENT 'Data de Ativação do Convenio',
  `DT_Desativacao` DATE NULL DEFAULT NULL COMMENT 'Data de Desativaçao do convenio',
  PRIMARY KEY (`SQ_Convenio`),
  UNIQUE INDEX `NM_Convenio` (`NM_Convenio` ASC),
  INDEX `PrimaryKey` (`SQ_Convenio` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = latin1
COMMENT = 'Convênios Atendidos';


-- -----------------------------------------------------
-- Table `db_clinica`.`plano`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`plano` (
  `SQ_Plano` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial do Plano',
  `SQ_Convenio` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Convenio',
  `NM_Plano` VARCHAR(30) NOT NULL COMMENT 'Nome do Plano',
  `DT_Ativacao` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Ativacao do Plano',
  `DT_Desativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data de Desativacao do Plano',
  PRIMARY KEY (`SQ_Convenio`, `SQ_Plano`),
  UNIQUE INDEX `SQ_Plano` (`SQ_Plano` ASC),
  UNIQUE INDEX `SQ_Plano_2` (`SQ_Plano` ASC),
  INDEX `PLANOCOD` (`SQ_Plano` ASC),
  INDEX `PrimaryKey` (`SQ_Plano` ASC, `SQ_Convenio` ASC),
  INDEX `CONVENIOPLANO` (`SQ_Convenio` ASC),
  INDEX `SQ_Convenio` (`SQ_Convenio` ASC),
  CONSTRAINT `plano_ibfk_1`
    FOREIGN KEY (`SQ_Convenio`)
    REFERENCES `db_clinica`.`convenio` (`SQ_Convenio`))
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = latin1
COMMENT = 'Plano Atendido do Convenio';


-- -----------------------------------------------------
-- Table `db_clinica`.`especialidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`especialidade` (
  `SQ_Especialidade` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Especialidade',
  `SQ_Convenio` INT(11) NOT NULL COMMENT 'Sequencial da Especialidade no Convenio',
  `SQ_Plano` INT(11) NOT NULL COMMENT 'Sequencial do Plano no convenio',
  `NM_Especialidade` VARCHAR(30) NOT NULL COMMENT 'Nome da Especialidade no convenio',
  `NR_Consultas_Semana` INT(1) NOT NULL COMMENT 'Numero de consultas permitidas por semana',
  `DT_Ativacao` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de inicio da especialidade',
  `DT_Desativacao` DATE NULL DEFAULT NULL COMMENT 'Data de Fim de atend da especialidade',
  PRIMARY KEY (`SQ_Especialidade`),
  UNIQUE INDEX `PrimaryKey` (`SQ_Especialidade` ASC, `SQ_Plano` ASC, `SQ_Convenio` ASC),
  INDEX `especialidade_fk_3` (`SQ_Convenio` ASC, `SQ_Plano` ASC),
  INDEX `iEspConvPlan` (`SQ_Especialidade` ASC, `SQ_Convenio` ASC, `SQ_Plano` ASC),
  CONSTRAINT `especialidade_fk_3`
    FOREIGN KEY (`SQ_Convenio` , `SQ_Plano`)
    REFERENCES `db_clinica`.`plano` (`SQ_Convenio` , `SQ_Plano`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = latin1
COMMENT = 'Especialidade atendida no convenio';


-- -----------------------------------------------------
-- Table `db_clinica`.`profissional`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`profissional` (
  `SQ_Profissional` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Profissional',
  `SQ_Especialidade` INT(11) NOT NULL COMMENT 'Sequencial da Especialidade',
  `DT_Ativacao` DATE NOT NULL COMMENT 'Data de Ativação da Especialidade',
  `DT_Desativacao` DATE NULL DEFAULT NULL COMMENT 'Data de Desativação da Especialidade',
  PRIMARY KEY (`SQ_Profissional`),
  INDEX `PrimaryKey` (`SQ_Profissional` ASC),
  INDEX `CONTATOPROFISSIONAL` (`SQ_Profissional` ASC),
  INDEX `NOME` (`SQ_Especialidade` ASC),
  INDEX `SQ_Profissional` (`SQ_Profissional` ASC),
  INDEX `SQ_Profissional_2` (`SQ_Profissional` ASC),
  CONSTRAINT `profissional_ibfk_2`
    FOREIGN KEY (`SQ_Especialidade`)
    REFERENCES `db_clinica`.`especialidade` (`SQ_Especialidade`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `profissional_ibfk_3`
    FOREIGN KEY (`SQ_Profissional`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`))
ENGINE = InnoDB
COMMENT = 'Profissional da Clinica';


-- -----------------------------------------------------
-- Table `db_clinica`.`sala`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`sala` (
  `SQ_Sala` INT(2) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Sala de Atendimento',
  `NM_Sala` VARCHAR(30) NOT NULL COMMENT 'Nome da Sala de Atendimento',
  `DT_Ativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data de Inicio de funcionamento',
  `DT_Desativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data fim de func da Sala',
  PRIMARY KEY (`SQ_Sala`),
  INDEX `PrimaryKey` (`SQ_Sala` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = latin1
COMMENT = 'Salas de Atendimento';


-- -----------------------------------------------------
-- Table `db_clinica`.`consulta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`consulta` (
  `DT_Consulta` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data da Consulta',
  `HR_Consulta` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'Hora da Consulta',
  `SQ_Contato_Paciente` INT(11) NULL DEFAULT NULL COMMENT 'Sequencial do Contato do Paciente',
  `SQ_Contato_Profissional` INT(11) NULL DEFAULT NULL COMMENT 'Sequencial do Contato do Profissional',
  `SQ_Sala` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial da Sala',
  `TP_Situacao_Consulta` VARCHAR(1) NOT NULL COMMENT 'Situacão da Consulta',
  PRIMARY KEY (`DT_Consulta`, `HR_Consulta`, `SQ_Sala`),
  UNIQUE INDEX `DT_Consulta_3` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Contato_Paciente` ASC),
  UNIQUE INDEX `DT_Consulta_4` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Contato_Profissional` ASC),
  INDEX `PrimaryKey` (`HR_Consulta` ASC, `DT_Consulta` ASC),
  INDEX `COD_PROF` (`SQ_Contato_Profissional` ASC),
  INDEX `COD_SALA` (`SQ_Sala` ASC),
  INDEX `PACIENTECONSULTA` (`SQ_Contato_Paciente` ASC),
  INDEX `PROFISSIONALCONSULTA` (`SQ_Contato_Profissional` ASC),
  INDEX `SALACONSULTA` (`SQ_Sala` ASC),
  INDEX `SITUACAO_CONSULTACONSULTA` (`TP_Situacao_Consulta` ASC),
  INDEX `SQ_Contato_Paciente` (`SQ_Contato_Paciente` ASC),
  INDEX `SQ_Contato_Profissional` (`SQ_Contato_Profissional` ASC),
  INDEX `SQ_Sala` (`SQ_Sala` ASC),
  INDEX `DT_Consulta` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Contato_Paciente` ASC),
  INDEX `SQ_Contato_Paciente_2` (`SQ_Contato_Paciente` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC),
  INDEX `DT_Consulta_2` (`DT_Consulta` ASC, `HR_Consulta` ASC, `SQ_Contato_Profissional` ASC),
  INDEX `SQ_Contato_Profissional_2` (`SQ_Contato_Profissional` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC),
  INDEX `SQ_Sala_2` (`SQ_Sala` ASC, `DT_Consulta` ASC, `HR_Consulta` ASC),
  CONSTRAINT `Consulta_TP_Sit_Consulta`
    FOREIGN KEY (`TP_Situacao_Consulta`)
    REFERENCES `db_clinica`.`tipo_situacao_consulta` (`TP_Situacao_Consulta`),
  CONSTRAINT `consulta_ibfk_1`
    FOREIGN KEY (`SQ_Contato_Paciente`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `consulta_ibfk_2`
    FOREIGN KEY (`SQ_Contato_Profissional`)
    REFERENCES `db_clinica`.`profissional` (`SQ_Profissional`),
  CONSTRAINT `consulta_ibfk_3`
    FOREIGN KEY (`SQ_Sala`)
    REFERENCES `db_clinica`.`sala` (`SQ_Sala`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Informações sobre as consultas';


-- -----------------------------------------------------
-- Table `db_clinica`.`contato_plano`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`contato_plano` (
  `SQ_Contato` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Contato',
  `SQ_Convenio` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do convenio',
  `SQ_Plano` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Plano',
  `DT_Validade` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Validade do Plano',
  `NR_Inscricao` INT(11) NULL DEFAULT NULL COMMENT 'Numero de Inscrição do Paciente no Plnao',
  PRIMARY KEY (`DT_Validade`, `SQ_Plano`, `SQ_Convenio`, `SQ_Contato`),
  INDEX `CONTATO_PLANOSQ_Plano` (`SQ_Plano` ASC),
  INDEX `CONTATOCONTATO_PLANO` (`SQ_Contato` ASC),
  INDEX `SQ_Contato` (`SQ_Contato` ASC),
  INDEX `SQ_Convenio` (`SQ_Convenio` ASC),
  INDEX `PrimaryKey` (`DT_Validade` ASC, `SQ_Plano` ASC, `SQ_Convenio` ASC, `SQ_Contato` ASC),
  INDEX `PLANOCONTATO_PLANO` (`SQ_Convenio` ASC, `SQ_Plano` ASC),
  CONSTRAINT `contato_plano_ibfk_1`
    FOREIGN KEY (`SQ_Convenio`)
    REFERENCES `db_clinica`.`plano` (`SQ_Convenio`),
  CONSTRAINT `contato_plano_ibfk_2`
    FOREIGN KEY (`SQ_Plano`)
    REFERENCES `db_clinica`.`plano` (`SQ_Plano`),
  CONSTRAINT `contato_plano_ibfk_3`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Relacao entre Contato e Plano';


-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_email` (
  `TP_Email` VARCHAR(1) NOT NULL DEFAULT '' COMMENT 'Tipo de Email',
  `NM_Tipo_Email` VARCHAR(30) NOT NULL COMMENT 'Nome do tipo de email',
  PRIMARY KEY (`TP_Email`),
  INDEX `PrimaryKey` (`TP_Email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de email';


-- -----------------------------------------------------
-- Table `db_clinica`.`email`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`email` (
  `SQ_Contato` INT(11) NOT NULL DEFAULT '0' COMMENT 'Seuquencial do Contato',
  `TP_Email` VARCHAR(1) NOT NULL COMMENT 'Tipo de email',
  `Email` VARCHAR(50) NOT NULL COMMENT 'Endereço de Email',
  PRIMARY KEY (`SQ_Contato`, `TP_Email`),
  INDEX `CONTATOEMAIL` (`SQ_Contato` ASC),
  INDEX `SQ_CONTATO` (`SQ_Contato` ASC),
  INDEX `TIPO_EMAILEMAIL` (`TP_Email` ASC),
  CONSTRAINT `email_ibfk_1`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `email_ibfk_2`
    FOREIGN KEY (`TP_Email`)
    REFERENCES `db_clinica`.`tipo_email` (`TP_Email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Email do contato';


-- -----------------------------------------------------
-- Table `db_clinica`.`uf`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`uf` (
  `CD_UF` VARCHAR(2) NOT NULL COMMENT 'Sigla da UF',
  `NM_UF` VARCHAR(30) NOT NULL COMMENT 'Nome da UF',
  PRIMARY KEY (`CD_UF`),
  INDEX `PrimaryKey` (`CD_UF` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Unidades da Federação';


-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_endereco` (
  `TP_Endereco` VARCHAR(1) NOT NULL COMMENT 'Tipo do endereço',
  `NM_Tipo_Endereco` VARCHAR(30) NOT NULL COMMENT 'Nome do Tipo do endereço',
  PRIMARY KEY (`TP_Endereco`),
  INDEX `PrimaryKey` (`TP_Endereco` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de Endereço';


-- -----------------------------------------------------
-- Table `db_clinica`.`endereco`
-- -----------------------------------------------------
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
  INDEX `CONTATOENDERECO` (`SQ_Contato` ASC),
  INDEX `ESTADOENDERECO` (`CD_UF` ASC),
  INDEX `SQ_Contato` (`SQ_Contato` ASC),
  INDEX `TIPO_ENDERECOENDERECO` (`TP_Endereco` ASC),
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


-- -----------------------------------------------------
-- Table `db_clinica`.`escala`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`escala` (
  `SQ_Profissional` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Profissional',
  `DT_Ini_Escala` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data  Inicio da escala',
  `DT_Fim_Escala` DATE NULL DEFAULT NULL COMMENT 'Data Fim da escalaalho',
  `Dia_Semana` INT(1) NOT NULL COMMENT 'Dias de Trabalho(1a7)',
  `Duracao` INT(2) NOT NULL COMMENT 'Duração da Sessão',
  `Intervalo` INT(2) NOT NULL DEFAULT '0' COMMENT 'Intervalo entre os atendimentos(minutos)',
  `HR_Ini_Turno1` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'Horario Inicial do 1o turno',
  `HR_Fim_Turno1` TIME NOT NULL DEFAULT '00:00:00' COMMENT 'Horario Final do 1o turno',
  `HR_Ini_Turno2` TIME NULL DEFAULT '00:00:00' COMMENT 'Horario Inicial do 2o turno',
  `HR_Fim_Turno2` TIME NULL DEFAULT '00:00:00' COMMENT 'Horario Final do 2o turno',
  PRIMARY KEY (`SQ_Profissional`, `DT_Ini_Escala`, `Dia_Semana`),
  INDEX `PROFISSIONALHORARIO_TRABALHO_PROF` (`SQ_Profissional` ASC),
  INDEX `PrimaryKey` (`DT_Ini_Escala` ASC, `SQ_Profissional` ASC),
  CONSTRAINT `escala_ibfk_1`
    FOREIGN KEY (`SQ_Profissional`)
    REFERENCES `db_clinica`.`profissional` (`SQ_Profissional`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Escala de Trabalho do profissional';


-- -----------------------------------------------------
-- Table `db_clinica`.`zzespecialidade_clinica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`zzespecialidade_clinica` (
  `SQ_Especialidade_Clinica` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Especialidade',
  `NM_Especialidade_Clinica` VARCHAR(30) NOT NULL COMMENT 'Nome da Especialidade',
  `Tempo_Atendimento` INT(2) NOT NULL COMMENT 'Tempo de atendimento(duracao em minutos)',
  PRIMARY KEY (`SQ_Especialidade_Clinica`),
  UNIQUE INDEX `NM_Especialidade_Clinica` (`NM_Especialidade_Clinica` ASC),
  INDEX `PrimaryKey` (`SQ_Especialidade_Clinica` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 5
COMMENT = 'Especialidades atendidas pela Clinica';


-- -----------------------------------------------------
-- Table `db_clinica`.`operadora`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`operadora` (
  `SQ_Operadora` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Sequencial da Operadora',
  `CD_Operadora` TINYINT(2) UNSIGNED NOT NULL COMMENT 'Código da Operadora',
  `NM_Operadora` VARCHAR(30) NOT NULL DEFAULT '' COMMENT 'Nome da Operadora',
  PRIMARY KEY (`SQ_Operadora`),
  UNIQUE INDEX `CD_Operadora` (`CD_Operadora` ASC),
  UNIQUE INDEX `i_cd_operadora` (`CD_Operadora` ASC),
  INDEX `PrimaryKey` (`SQ_Operadora` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 45
DEFAULT CHARACTER SET = latin1
COMMENT = 'Operadora de Telefonia';


-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_relacionamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_relacionamento` (
  `TP_Relacao` VARCHAR(1) NOT NULL COMMENT 'Tipo do Relação com a Clinica',
  `NM_Tipo_Relacao` VARCHAR(30) NOT NULL COMMENT 'Nome do Tipo da  Relação',
  PRIMARY KEY (`TP_Relacao`),
  INDEX `PrimaryKey` (`TP_Relacao` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de Relacionamentno';


-- -----------------------------------------------------
-- Table `db_clinica`.`relacionamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`relacionamento` (
  `SQ_Contato` INT(11) NOT NULL COMMENT 'Sequencial do Contato',
  `TP_Relacao` VARCHAR(1) NOT NULL COMMENT 'Tipo do Relacionamento',
  PRIMARY KEY (`SQ_Contato`, `TP_Relacao`),
  INDEX `TP_Relacao` (`TP_Relacao` ASC),
  CONSTRAINT `relacionamento_ibfk_1`
    FOREIGN KEY (`SQ_Contato`)
    REFERENCES `db_clinica`.`contato` (`SQ_Contato`),
  CONSTRAINT `relacionamento_ibfk_2`
    FOREIGN KEY (`TP_Relacao`)
    REFERENCES `db_clinica`.`tipo_relacionamento` (`TP_Relacao`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Relacionamento do contato com  a clinica';


-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_uso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_uso` (
  `TP_Uso` VARCHAR(1) NOT NULL COMMENT 'Tipo de uso do telefone',
  `NM_Tipo_Uso` VARCHAR(30) NOT NULL COMMENT 'Nome do tipo de uso do telefone',
  PRIMARY KEY (`TP_Uso`),
  INDEX `PrimaryKey` (`TP_Uso` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de uso do telefone';


-- -----------------------------------------------------
-- Table `db_clinica`.`tipo_mobilidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`tipo_mobilidade` (
  `TP_Mobilidade` VARCHAR(1) NOT NULL COMMENT 'Tipo de Mobilidade do Telefone',
  `NM_Tipo_Mobilidade` VARCHAR(30) NOT NULL COMMENT 'Nome do tipo da mobilidade',
  PRIMARY KEY (`TP_Mobilidade`),
  INDEX `PrimaryKey` (`TP_Mobilidade` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tipo de mobilidade do Telefone';


-- -----------------------------------------------------
-- Table `db_clinica`.`telefone`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`telefone` (
  `SQ_Contato` INT(11) NOT NULL COMMENT 'Sequencial do Contato',
  `TP_Mobilidade` VARCHAR(1) NOT NULL COMMENT 'Tipo de Mobilidade (Fixo/Movel)',
  `TP_Uso` VARCHAR(1) NOT NULL COMMENT 'Tiopo de uso (Pessoal/Resid/Comercial/Parente)',
  `CD_DDD` INT(2) NULL DEFAULT '61' COMMENT 'Código DDD do telefone',
  `NR_Telefone` INT(11) NOT NULL DEFAULT '0' COMMENT 'Nro do Telefone(sem DDD)',
  `SQ_Operadora` INT(2) NOT NULL COMMENT 'Seq da Operadora de Telefonia',
  PRIMARY KEY (`SQ_Contato`, `NR_Telefone`),
  INDEX `CONTATOTELEFONE` (`SQ_Contato` ASC),
  INDEX `OPERADORATELEFONE` (`SQ_Operadora` ASC),
  INDEX `SQ_Contato` (`SQ_Contato` ASC),
  INDEX `TIPO_MOBILIDADETELEFONE` (`TP_Mobilidade` ASC),
  INDEX `TIPO_USOTELEFONE` (`TP_Uso` ASC),
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


-- -----------------------------------------------------
-- Table `db_clinica`.`valor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_clinica`.`valor` (
  `SQ_Valor` INT(11) NOT NULL AUTO_INCREMENT,
  `SQ_Convenio` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Convenio',
  `SQ_Plano` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial do Plano',
  `SQ_Especialidade` INT(11) NOT NULL DEFAULT '0' COMMENT 'Sequencial da Especialidade',
  `DT_Ativacao` DATE NOT NULL DEFAULT '0000-00-00' COMMENT 'Data de Ativaçao da Especialidade no Plano/Convenio',
  `DT_Desativacao` DATE NULL DEFAULT '0000-00-00' COMMENT 'Data de Desativacao da Especialidade no Convenio/plano',
  `VL_Consulta` DECIMAL(10,2) NULL DEFAULT NULL COMMENT 'Valor da Consulta',
  PRIMARY KEY (`SQ_Valor`),
  UNIQUE INDEX `SQ_Convenio` (`SQ_Convenio` ASC, `SQ_Plano` ASC, `SQ_Especialidade` ASC, `DT_Ativacao` ASC),
  INDEX `PrimaryKey` (`DT_Ativacao` ASC, `SQ_Especialidade` ASC, `SQ_Plano` ASC, `SQ_Convenio` ASC),
  CONSTRAINT `fk_ConvPlanEsp`
    FOREIGN KEY (`SQ_Convenio` , `SQ_Plano` , `SQ_Especialidade`)
    REFERENCES `db_clinica`.`especialidade` (`SQ_Convenio` , `SQ_Plano` , `SQ_Especialidade`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1
COMMENT = 'Valor Pago pelo Convenio';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
