<?php
class PlanoClass {
  
	public $Regs;
	public $SQ_Plano;
	public $SQ_Convenio;
	public $NM_Plano;
	public $DT_Ativacao;
	public $DT_Desativacao;

	public function GetReg(&$MsgErro){
		 
		//echo  "<br>Recuperando Plano ";
	
		//echo 'Sq_Plano:' . $this->SQ_Plano;
		$query = 'Select * FROM Plano WHERE SQ_Plano = ' . $this->SQ_Plano;
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
	  //  echo  '<br/>Validando dados Plano: ' . 'Nome: ' . $this->NM_Plano .
	  //            'Ativ:' . $this->DT_Ativacao .  'Desat:' . $this->DT_Desativacao;  
		if ($this->NM_Plano == null){
			$MsgErro = 'Nome Plano inválido';
			return FALSE;
		}

		if ($this->SQ_Convenio < 1){
			$MsgErro = 'Sequencial do Plano inválido';
			return FALSE;
		}
		
		$data = explode('/', $this->DT_Ativacao);
		if ($this->DT_Ativacao == '' || !checkdate($data[1], $data[0], $data[2])){
		   $MsgErro = 'Data de Ativação do Plano inválida';
		   return FALSE;
		}
		
		if ($this->DT_Desativacao <> '' && $this->DT_Desativacao <> '00/00/0000'){
			$data = explode('/', $this->DT_Desativacao);
			if (!checkdate($data[1], $data[0], $data[2])){
				$MsgErro = 'Data de Desativação do Plano inválida';
				return FALSE;
			}
			elseif (strtotime(implode('-',  array_reverse(explode('/',$this->DT_Desativacao)))) <= 
					strtotime(implode('-',  array_reverse(explode('/',$this->DT_Ativacao))))){
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
		//Validando Consistencia contra a tabela pai(Convenio)
		//echo  "<br/>/Validando Consistencia contra a tabela pai(Convenio)";
		$query = 'Select * FROM Convenio
		WHERE SQ_Convenio = ' . $this->SQ_Convenio;
		$resultConvenio = mysql_query($query);
		if (!$resultConvenio){
			$MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($resultConvenio,0,0);
		if (mysql_num_rows($resultConvenio) == 0){
			$MsgErro = 'Convênio não localizado';
			return FALSE;
		}
	
		$dadosConvenio = mysql_fetch_array($resultConvenio);
		if ($dadosConvenio[DT_Desativacao] > 0){
			$MsgErro = 'Convenio Desativado';
			return FALSE;
		}
	
		//echo $dadosConvenio[SQ_Convenio] . '.' . $dadosConvenio[NM_Convenio] . '.' . $dadosConvenio[DT_Ativacao] . '.' . $dadosConvenio[DT_Desativacao];
		//echo '<br>';
		//echo $this->SQ_Convenio . '.' . $this->NM_Plano . '.' . $this->DT_Ativacao . '.' . $this->DT_Desativacao;

		if (implode('-',  array_reverse(explode('/',$this->DT_Ativacao))) < $dadosConvenio[DT_Ativacao]){
			$MsgErro = 'Data ativacao do Plano não pode ser menor que ativaçao do Convenio';
			return FALSE;
		}
		if ($dadosConvenio[DT_Desativacao] <> '0000-00-00' && 
			implode('-',  array_reverse(explode('/',$this->DT_Desativacao))) > $dadosConvenio[DT_Desativacao]){
			$MsgErro = 'Data Desativacao do Plano não pode ser maior que desativaçao do Convenio';
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
		$queryPlano = 'Select SQ_Plano, SQ_Convenio FROM Plano 
		          WHERE SQ_Convenio = ' . $this->SQ_Convenio . ' and NM_Plano = "' . $this->NM_Plano . '"';
		$resultPlano = mysql_query($queryPlano);
		if (!$resultPlano){
			$MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $queryPlano;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($resultPlano,0,0);
		if (mysql_num_rows($resultPlano) == 0){
			$MsgErro = null;
			return FALSE;
		}
		return TRUE;
	}
	
	public function Insert(&$MsgErro){
		//echo  '<br/>Inserindo Plano ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia Tabela Local';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Plano já existe';
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
		
		$query = 'INSERT INTO Plano (SQ_Convenio,NM_Plano,DT_Ativacao,DT_Desativacao)
								values ("' . $this->SQ_Convenio . '" , "'
								           . $this->NM_Plano    . '" , "' 
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
		   
		//echo  "<br>Excluindo Plano>";
						
		$query = 'DELETE FROM Plano WHERE SQ_Plano = ' . $this->SQ_Plano;
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
	   
		//echo  "<br>Alterando Plano ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Plano) ||(int)$this->SQ_Plano < 1)){
			$MsgErro = 'Sequencial Plano inválido';
			return FALSE;
		}
		
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
		
		$query = 'UPDATE Plano set SQ_Convenio = ' . $this->SQ_Convenio . ',' .
								   'NM_Plano = "'  . $this->NM_Plano    . '",' .
								   'DT_Ativacao = "' . $this->DT_Ativacao . '",' .
								   'DT_Desativacao = "' . $this->DT_Desativacao . '"' .
				'where SQ_Plano =' . $this->SQ_Plano ;
		
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