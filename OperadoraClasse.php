<?php
class Operadora {
  
	public $Regs;
	public $SQ_Operadora;
	public $CD_Operadora;
	public $NM_Operadora;
    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados Operadora: " . $this->CD_Operadora . 'Nome: ' . $this->NM_Operadora;
		if (!is_numeric($this->CD_Operadora) || (int)$this->CD_Operadora < 1){
		   $MsgErro = 'Código Operadora inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Operadora == null){
		   $MsgErro = 'Nome Operadora inválido';
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
		$query = "Select CD_Operadora FROM operadora WHERE CD_Operadora = " . $this->CD_Operadora;
		$result = mysql_query($query);
		if (!$result){
			$MsgErro = 'Erro bd: ' . mysql_error();
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($result,0,0);
		if (mysql_num_rows($result) == 0){
			$MsgErro = null;
			return FALSE;
		}
		return TRUE;
	}
	
	public function Insert(&$MsgErro){
		//echo  "<br/>Inserindo Operadora ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Operadora já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO operadora (CD_Operadora,NM_Operadora)
								values (' . $this->CD_Operadora . ',"' . $this->NM_Operadora . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

public function Delete(&$MsgErro){
	   
	//echo  "<br/>Excluindo Operadora ";
					
	$query = 'DELETE FROM operadora WHERE SQ_Operadora = ' . $this->SQ_Operadora;
	//echo $query;

	$result = mysql_query($query);
	if (!($result && (mysql_affected_rows() > 0)))
	{
		$MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error();
		return FALSE;
	}
//	else
//		$MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
	
	return TRUE;
	  
	}

public function GetReg(&$MsgErro){
	   
	//echo  "<br/>Recuperando Operadora ";
					
	//echo 'Sq_operadora:' . $this->SQ_Operadora;
	$query = 'Select * FROM operadora WHERE SQ_Operadora = ' . $this->SQ_Operadora;
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Sequencial do Registro não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Operadora ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Operadora) ||(int)$this->SQ_Operadora < 1)){
			$MsgErro = 'Sequencial Operadora inválido';
			return FALSE;
		}

		//echo '<br>Validando Consistencia BD';
		//if ($this->Existe_Registro($MsgErro)){
		//	$MsgErro = 'Operadora já existe';
		//	return FALSE;
		//}
		//elseif ($MsgErro <> null)
		//	return FALSE;
		
		$query = "UPDATE operadora set CD_Operadora = $this->CD_Operadora ,NM_Operadora = '"
			 . $this->NM_Operadora . "' where SQ_Operadora = " . $this->SQ_Operadora ;
		
		$result = mysql_query($query);
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Registro não alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>