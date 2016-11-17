<?php
class Email {
  
	public $Regs;
	public $SQ_Contato;
	public $TP_Email;
	public $Email;
    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados Email: " . $this->TP_Email;
	   
	    if ($this->TP_Email == null){
		   $MsgErro = 'Tipo de Email inválido';
		   return FALSE;
		}
		
		if ($this->Email == null){
			$MsgErro = 'Email invalido';
			return FALSE;
		}
		
		return TRUE;
	}

	
	/* Retorna Falso se deu erro no Banco ou não existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro(&$MsgErro){
		//Valida se registro já existe
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select SQ_Contato FROM Email WHERE SQ_Contato = '   . $this->SQ_Contato .
		                                         ' and TP_Email = "' . $this->TP_Email .  '"';
		$result = mysql_query($query);
		if (!$result){
			$MsgErro = 'Erro bd: ' . mysql_error();
			return FALSE;
		}
		//echo 'Achei: ' . mysql_result($result,0,0);
		if (mysql_num_rows($result) == 0){
			$MsgErro = null;
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function Insert(&$MsgErro){
		//echo  '<br>Inserindo Email ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Email (SQ_Contato,TP_Email,Email) ' .
								' values ('   . $this->SQ_Contato .
								       ', "'  . $this->TP_Email .
		                               '", "' . $this->Email . '")';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir o Email: ' . mysql_error();
			return FALSE;
		}
		
		return TRUE;
	}

public function Delete(&$MsgErro){
	   
	//echo  "<br/>Excluindo Email ";
					
	$query = 'DELETE FROM Email WHERE SQ_Contato = ' . $this->SQ_Contato .
	                             ' and TP_Email = "' . $this->TP_Email .  '"';
	//echo $query;

	$result = mysql_query($query);
	if (!($result && (mysql_affected_rows() > 0)))
	{
		$MsgErro = 'Não foi possivel excluir o Email: ' . mysql_error();
		return FALSE;
	}
	
	return TRUE;
	  
	}

public function GetReg(&$MsgErro){
	   
	//echo  "<br/>Recuperando Email ";
					
	//echo 'Sq_Email:' . $this->SQ_Email;
	$query = 'Select * FROM Email WHERE SQ_Contato = ' . $this->SQ_Contato .
	                                 ' and TP_Email = "' . $this->TP_Email .  '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Email não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Email ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Contato) ||(int)$this->SQ_Contato < 1)){
			$MsgErro = 'Sequencial Contato inválido';
			return FALSE;
		}

		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		$query = 'UPDATE Email set Email          = "' . $this->Email . 
				               '" where SQ_Contato  = ' . $this->SQ_Contato .
		                         ' and TP_Email = "' . $this->TP_Email . '"'; 
		
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		$result = mysql_query($query);
				
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Email não alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>
