<?php
class Sala {
  
	public $Regs;
	public $SQ_Sala;
	public $NM_Sala;
	public $DT_Ativacao;
	public $DT_Desativacao;
	//echo date('Y-m-d', strtotime(date('Y/m/d')));
	private function Valida_Dados($MsgErro){ 
	  //  echo  '<br/>Validando dados Sala: ' . 'Nome: ' . $this->NM_Sala .
	  //            'Ativ:' . $this->DT_Ativacao .  'Desat:' . $this->DT_Desativacao;  
		if ($this->NM_Sala == null){
			$this->MsgErro = 'Nome Sala inválido';
			return FALSE;
		}
		
		if ($this->DT_Ativacao == '' || !checkdate(date('m',$this->DT_Ativacao), date('d',$this->DT_Ativacao), date('Y',$this->DT_Ativacao))){
		   $this->MsgErro = 'Data de Ativação do Sala inválida';
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
				$this->MsgErro = 'Data de Desativação do Sala inválida';
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
		$query = 'Select SQ_Sala FROM Sala WHERE NM_Sala = "' . $this->NM_Sala . '"';
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
		//echo  '<br/>Inserindo Sala ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Sala já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Sala (NM_Sala,DT_Ativacao,DT_Desativacao)
								values ("' . $this->NM_Sala . '" , "' 
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
		   
		//echo  "<br>Excluindo Sala>";
						
		$query = 'DELETE FROM Sala WHERE SQ_Sala = ' . $this->SQ_Sala;
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
		   
		//echo  "<br>Recuperando Sala ";
						
		//echo 'Sq_Sala:' . $this->SQ_Sala;
		$query = 'Select * FROM Sala WHERE SQ_Sala = ' . $this->SQ_Sala;
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
	   
		//echo  "<br>Alterando Sala ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Sala já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
		
		if (!(is_numeric($this->SQ_Sala) ||(int)$this->SQ_Sala < 1)){
			$this->MsgErro = 'Sequencial Sala inválido';
			return FALSE;
		}
		
		$query = 'UPDATE Sala set NM_Sala = "' . $this->NM_Sala . '",' .
									  'DT_Ativacao = "' . $this->DT_Ativacao . '",' .
									  'DT_Desativacao = "' . $this->DT_Desativacao . '"' .
				'where SQ_Sala =' . $this->SQ_Sala ;
		
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