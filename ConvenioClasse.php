<?php
class Convenio {
  
	public $Regs;
	public $SQ_Convenio;
	public $NM_Convenio;
	public $DT_Ativacao;
	public $DT_Desativacao;
	//echo date('Y-m-d', strtotime(date('Y/m/d')));
	private function Valida_Dados($MsgErro){ 
	  //  echo  '<br/>Validando dados Convenio: ' . 'Nome: ' . $this->NM_Convenio .
	  //            'Ativ:' . $this->DT_Ativacao .  'Desat:' . $this->DT_Desativacao;  
		if ($this->NM_Convenio == null){
			$this->MsgErro = 'Nome Convenio inválido';
			return FALSE;
		}
		
		if ($this->DT_Ativacao == '' || !checkdate(date('m',$this->DT_Ativacao), date('d',$this->DT_Ativacao), date('Y',$this->DT_Ativacao))){
		   $this->MsgErro = 'Data de Ativação do Convênio inválida';
		   return FALSE;
		}
        /* 
		echo 'desat:' . $this->DT_Desativacao . ':';
			
		if ($this->DT_Desativacao == '')
			echo 'vazio';
		else echo 'nao vazio';	
		
		if (!isset($this->DT_Desativacao))
			echo 'não setado';
		else echo 'setado';
		
		if (is_null($this->DT_Desativacao))
			echo 'nulo';
		else echo 'nao nulo';

		if (empty($this->DT_Desativacao))
			echo 'empty';
		else echo 'nao empty';
		*/		
		if ($this->DT_Desativacao <> '')
			if (!checkdate(date('m',$this->DT_Desativacao), date('d',$this->DT_Desativacao), date('Y',$this->DT_Desativacao))){
				$this->MsgErro = 'Data de Desativação do Convênio inválida';
				return FALSE;
			}
			elseif ($this->DT_Desativacao <= $this->DT_Ativacao){
				$this->MsgErro = 'Data de Desativação deve ser maior que ativação';
				return FALSE;
			}	
		
		return TRUE;
	}
	
	/* Retorna Falso se deu erro no Banco ou n�o existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro($MsgErro){
		//Valida se registro já existe
		//echo  "<br/>/Validando Consistencia do Registro";
		$query = 'Select SQ_Convenio FROM Convenio WHERE NM_Convenio = "' . $this->NM_Convenio . '"';
		$result = mysql_query($query);
		if (!$result){
			$this->MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($result,0,0);
		if (mysql_num_rows($result) == 0){
			$this->MsgErro = null;
			return FALSE;
		}
		return TRUE;
	}
	
	public function Insert($MsgErro){
		//echo  '<br/>Inserindo Convenio ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Convenio já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Convenio (NM_Convenio,DT_Ativacao,DT_Desativacao)
								values ("' . $this->NM_Convenio . '" , "' 
								           . $this->DT_Ativacao . '" , "'  
								           . $this->DT_Desativacao . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
		   
		//echo  "<br>Excluindo Convênio>";
						
		$query = 'DELETE FROM Convenio WHERE SQ_Convenio = ' . $this->SQ_Convenio;
		//echo $query;
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$this->MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
	//	else
	//		$this->MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
		  
	}
	
	public function GetReg($MsgErro){
		   
		//echo  "<br>Recuperando Convenio ";
						
		//echo 'Sq_Convenio:' . $this->SQ_Convenio;
		$query = 'Select * FROM Convenio WHERE SQ_Convenio = ' . $this->SQ_Convenio;
		//echo 'Query: ' . $query;
		$this->Regs = mysql_query($query);
		if (!$this->Regs){
			$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		
		//echo 'Achei: ' . mysql_result($this->Regs,0,1);
		if (mysql_num_rows($this->Regs) == 0){
			$this->MsgErro = 'Sequencial do Registro não encontrado';
			return FALSE;
		}
		
		return TRUE;
	}	
	
	public function Edit($MsgErro){
	   
		//echo  "<br>Alterando Convenio ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Convenio já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
		
		if (!(is_numeric($this->SQ_Convenio) ||(int)$this->SQ_Convenio < 1)){
			$this->MsgErro = 'Sequencial Convenio inválido';
			return FALSE;
		}
		
		$query = 'UPDATE Convenio set NM_Convenio = "' . $this->NM_Convenio . '",' .
									  'DT_Ativacao = "' . $this->DT_Ativacao . '",' .
									  'DT_Desativacao = "' . $this->DT_Desativacao . '"' .
				'where SQ_Convenio =' . $this->SQ_Convenio ;
		
		$result = mysql_query($query);
	//	echo $query . mysql_affected_rows() . mysql_error() . gettype($result) . '<br>Query: ' . $query;
		
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Registro não alterado: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		return TRUE;
	}
}
?>