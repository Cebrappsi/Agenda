<?php
class TipoEmailClass {
  
	public $Regs;
	public $TP_Email;
	public $NM_Tipo_Email;
    
	private function Valida_Dados(&$MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_Email: " . $this->TP_Email . 'Nome: ' . $this->NM_Tipo_Email;
		if ($this->TP_Email == ""){
		   $MsgErro = 'CÓdigo tipo_Email inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Email == ""){
		   $MsgErro = 'Nome tipo_Email inválido';
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
		//echo  "<br/>/Validando Consistencia do Registro";
		$query = "Select TP_Email FROM tipo_Email WHERE TP_Email = '" . $this->TP_Email . "'";
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
	   
		//echo  "<br/>Inserindo tipo_Email ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Tipo_Email já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_Email (TP_Email,NM_Tipo_Email)
								values ("' . strtoupper($this->TP_Email) . '" , "' . $this->NM_Tipo_Email . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete(&$MsgErro){
	   
		//echo  "<br/>Excluindo tipo_Email ";
						
		$query = 'DELETE FROM tipo_Email WHERE TP_Email = "' . $this->TP_Email . '"';
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$MsgErro = 'Não foi possível excluir o registro: ' . mysql_error();
			return FALSE;
		}
	//	else
	//		$MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
	  
	}

public function GetReg(&$MsgErro){
	   
	//echo  "<br/>Recuperando tipo_Email ";
					
	//echo 'TP_Email:' . $this->TP_Email;
	$query = 'Select * FROM tipo_Email WHERE TP_Email = "' . $this->TP_Email . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'tipo_Email não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando tipo_Email ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Tipo_Email já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_Email set TP_Email = '" . $this->TP_Email . "' , NM_Tipo_Email = '"
			 . $this->NM_Tipo_Email . "' where TP_Email = '" . $this->TP_Email . "'";
		
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