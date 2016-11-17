<?php
class EspecialidadeClass {
  
	public $Regs;
	public $SQ_Especialidade;
	public $SQ_Plano;
	public $SQ_Convenio;
	public $NM_Especialidade;
	public $NR_Consultas_Semana;
	public $DT_Ativacao;
	public $DT_Desativacao;

	public function GetReg(&$MsgErro){
		 
		//echo  "<br>Recuperando Especialidade ";
	
		//echo 'Sq_Especialidade:' . $this->SQ_Especialidade;
		$query = 'Select * FROM Especialidade WHERE SQ_Especialidade = ' . $this->SQ_Especialidade;
		//echo 'Query: ' . $query;
		$this->Regs = mysql_query($query);
		if (!$this->Regs){
			$MsgErro = 'Erro no Banco de Dados: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
	
		//echo 'Achei: ' . mysql_result($this->Regs,0,1);
		if (mysql_num_rows($this->Regs) == 0){
			$MsgErro = 'Sequencial do Registro não encontrado';
			return FALSE;
		}
	
		return TRUE;
	}
		
	private function Valida_Dados(&$MsgErro){ 
	  //  echo  '<br/>Validando dados Especialidade: ' . 'Nome: ' . $this->NM_Especialidade .
	  //            'Ativ:' . $this->DT_Ativacao .  'Desat:' . $this->DT_Desativacao;  
		if ($this->NM_Especialidade == null){
			$MsgErro = 'Nome Especialidade inválido';
			return FALSE;
		}

		if ($this->SQ_Plano < 1){
			$MsgErro = 'Sequencial do Plano inválido';
			return FALSE;
		}
		
		if ($this->SQ_Convenio < 1){
			$MsgErro = 'Sequencial da Convênio inválido';
			return FALSE;
		}
		
		if ($this->NR_Consultas_Semana < 0){
			$MsgErro = 'Número de consultas semanais inválido';
			return FALSE;
		}
		
		$data = explode('/', $this->DT_Ativacao);
		if ($this->DT_Ativacao == '' || !checkdate($data[1], $data[0], $data[2])){
		   $MsgErro = 'Data de Ativação do Especialidade inválida';
		   return FALSE;
		}
		
		if ($this->DT_Desativacao <> '' && $this->DT_Desativacao <> '00/00/0000'){
				$data = explode('/', $this->DT_Desativacao);
			if (!checkdate($data[1], $data[0], $data[2])){
				$MsgErro = 'Data de Desativação do Especialidade inválida';
				return FALSE;
			}
			elseif ($this->DT_Desativacao <= $this->DT_Ativacao){
				$MsgErro = 'Data de Desativação deve ser maior que ativação';
				return FALSE;
			}	
		}
		return TRUE;
	}

	/* Retorna Falso se deu erro no Banco ou há alguma consistencia cruzada violada
	 * Retorna True se existe
	* Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Valida_Cruzada(&$MsgErro){
	
		//echo  "<br/>/Validando Consistencia contra a tabela pai(Plano)";
		$query = 'Select * FROM Plano WHERE SQ_Plano = ' . $this->SQ_Plano;
		$resultPlano = mysql_query($query);
		if (!$resultPlano){
			$MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($resultConvenio,0,0);
		if (mysql_num_rows($resultPlano) == 0){
			$MsgErro = 'Plano não localizado';
			return FALSE;
		}
		
		$dadosPlano = mysql_fetch_array($resultPlano);
		if ($dadosPlano[DT_Desativacao] > 0){
			$MsgErro = 'Plano desativado';
			return FALSE;
		}
		//echo $dadosConvenio[SQ_Convenio] . '.' . $dadosConvenio[NM_Convenio] . '.' . $dadosConvenio[DT_Ativacao] . '.' . $dadosConvenio[DT_Desativacao];
		//echo '<br>';
		//echo $this->SQ_Convenio . '.' . $this->NM_Especialidade . '.' . $this->DT_Ativacao . '.' . $this->DT_Desativacao;
		
		if (implode('-',  array_reverse(explode('/',$this->DT_Ativacao))) < $dadosPlano[DT_Ativacao]){
			$MsgErro = 'Data ativacao da Especialidade não pode ser menor que ativaçao do Plano';
			return FALSE;
		}
		if ($dadosPlano[DT_Desativacao] <> '0000-00-00' && implode('-',  array_reverse(explode('/',$this->DT_Desativacao))) > $dadosPlano[DT_Desativacao]){
			$MsgErro = 'Data Desativacao da Especialidade não pode ser maior que desativaçao do Plano';
			return FALSE;
		}
		return TRUE;
	}
	
	/* Retorna Falso se deu erro no Banco ou n�o existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro(&$MsgErro){
		//Valida se registro já existe
		//echo  "<br/>/Validando Consistencia do Registro";
		$queryEspecialidade = 'Select SQ_Especialidade, SQ_Plano, SQ_Convenio FROM Especialidade 
		          WHERE SQ_Convenio = ' . $this->SQ_Convenio . ' and SQ_Plano = ' . $this->SQ_Plano . ' and NM_Especialidade = "' . $this->NM_Especialidade . '"';
		$resultEspecialidade = mysql_query($queryEspecialidade);
		if (!$resultEspecialidade){
			$MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $queryEspecialidade;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($resultEspecialidade,0,0);
		if (mysql_num_rows($resultEspecialidade) == 0){
			$MsgErro = null;
			return FALSE;
		}
		return TRUE;
	}
	
	public function Insert(&$MsgErro){
		//echo  '<br/>Inserindo Especialidade ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia Tabela Local';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Especialidade já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;

		//echo '<br>Validação cruzada';
		if (!$this->Valida_Cruzada($MsgErro))
			return false;
		elseif ($MsgErro <> null)
		    return FALSE;
				
		//echo '<br>Inserindo Registro';
		//Converte datas para formato mysql
		if ($this->DT_Ativacao <> '' && $this->DT_Ativacao <> '00/00/0000')
			$this->DT_Ativacao = implode('-',  array_reverse(explode('/',$this->DT_Ativacao)));
		if ($this->DT_Desativacao <> '' && $this->DT_Desativacao <> '00/00/0000')
			$this->DT_Desativacao = implode('-',  array_reverse(explode('/',$this->DT_Desativacao)));
		
		$query = 'INSERT INTO Especialidade (SQ_Convenio,SQ_Plano,NM_Especialidade,NR_Consultas_Semana,DT_Ativacao,DT_Desativacao)
								values ("' . $this->SQ_Convenio . '" , "'
										   . $this->SQ_Plano . '" , "'	
								           . $this->NM_Especialidade . '" , "'
								           . $this->NR_Consultas_Semana . '" , "' 
								           . $this->DT_Ativacao . '" , "'  
								           . $this->DT_Desativacao . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}

		return TRUE;
	}

	public function Delete(&$MsgErro){
		   
		//echo  "<br>Excluindo Especialidade>";
						
		$query = 'DELETE FROM Especialidade WHERE SQ_Especialidade = ' . $this->SQ_Especialidade;
		//echo $query;
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
	//	else
	//		$MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
		  
	}
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br>Alterando Especialidade ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Especialidade) ||(int)$this->SQ_Especialidade < 1)){
			$MsgErro = 'Sequencial Especialidade inválido';
			return FALSE;
		}
		
		//echo '<br>Validando Consistencia Tabela Local';
		if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Especialidade já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			return FALSE;
		
		//echo '<br>Validação cruzada';
		if (!$this->Valida_Cruzada($MsgErro))
			return false;
		elseif ($MsgErro <> null)
			return FALSE;
		
		//Converte datas para formato mysql
		if ($this->DT_Ativacao <> '' && $this->DT_Ativacao <> '00/00/0000')
			$this->DT_Ativacao = implode('-',  array_reverse(explode('/',$this->DT_Ativacao)));
		if ($this->DT_Desativacao <> '' && $this->DT_Desativacao <> '00/00/0000')
			$this->DT_Desativacao = implode('-',  array_reverse(explode('/',$this->DT_Desativacao)));
		
		$query = 'UPDATE Especialidade set SQ_Convenio = ' . $this->SQ_Convenio . ',' .
								   'SQ_Plano = "'  . $this->SQ_Plano            . '",' .
								   'NM_Especialidade = "'  . $this->NM_Especialidade    . '",' .
								   'NR_Consultas_Semana = "'  . $this->NR_Consultas_Semana   . '",' .
								   'DT_Ativacao = "' . $this->DT_Ativacao . '",' .
								   'DT_Desativacao = "' . $this->DT_Desativacao . '"' .
				'where SQ_Especialidade =' . $this->SQ_Especialidade ;
		
		$result = mysql_query($query);
	//	echo $query . mysql_affected_rows() . mysql_error() . gettype($result) . '<br>Query: ' . $query;
		
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Registro não alterado: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		return TRUE;
	}
}
?>