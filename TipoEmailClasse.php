<?php
class tipo_Email {
  
	public $Regs;
	public $TP_Email;
	public $NM_Tipo_Email;
    
	private function Valida_Dados($MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_Email: " . $this->TP_Email . 'Nome: ' . $this->NM_Tipo_Email;
		if ($this->TP_Email == ""){
		   $this->MsgErro = 'CÓdigo tipo_Email inv�lido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Email == ""){
		   $this->MsgErro = 'Nome tipo_Email inv�lido';
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
		$query = "Select TP_Email FROM tipo_Email WHERE TP_Email = '" . $this->TP_Email . "'";
		$result = mysql_query($query);
		if (!$result){
			$this->MsgErro = 'Erro bd: ' . mysql_error();
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
	   
		//echo  "<br/>Inserindo tipo_Email ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_Email j� existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_Email (TP_Email,NM_Tipo_Email)
								values ("' . strtoupper($this->TP_Email) . '" , "' . $this->NM_Tipo_Email . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'N�o foi poss�vel incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
	   
		//echo  "<br/>Excluindo tipo_Email ";
						
		$query = 'DELETE FROM tipo_Email WHERE TP_Email = "' . $this->TP_Email . '"';
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$this->MsgErro = 'N�o foi possivel excluir o registro: ' . mysql_error();
			return FALSE;
		}
	//	else
	//		$this->MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
	  
	}

public function GetReg($MsgErro){
	   
	//echo  "<br/>Recuperando tipo_Email ";
					
	//echo 'TP_Email:' . $this->TP_Email;
	$query = 'Select * FROM tipo_Email WHERE TP_Email = "' . $this->TP_Email . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'tipo_Email n�o encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando tipo_Email ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_Email j� existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_Email set TP_Email = '" . $this->TP_Email . "' , NM_Tipo_Email = '"
			 . $this->NM_Tipo_Email . "' where TP_Email = '" . $this->TP_Email . "'";
		
		$result = mysql_query($query);
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Registro n�o alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>