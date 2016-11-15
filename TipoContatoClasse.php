<?php
class tipo_contato {
  
	public $Regs;
	public $TP_Contato;
	public $NM_Tipo_Contato;
    
	private function Valida_Dados($MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_contato: " . $this->TP_Contato . 'Nome: ' . $this->NM_Tipo_Contato;
		if ($this->TP_Contato == ""){
		   $this->MsgErro = 'Código tipo_contato inv�lido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Contato == ""){
		   $this->MsgErro = 'Nome tipo_contato inv�lido';
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
		$query = "Select TP_Contato FROM tipo_contato WHERE TP_Contato = '" . $this->TP_Contato . "'";
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
	   
		//echo  "<br/>Inserindo tipo_contato ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_contato já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_contato (TP_Contato,NM_Tipo_Contato)
								values ("' . strtoupper($this->TP_Contato) . '" , "' . $this->NM_Tipo_Contato . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
	   
		//echo  "<br/>Excluindo tipo_contato ";
						
		$query = 'DELETE FROM tipo_contato WHERE TP_Contato = "' . $this->TP_Contato . '"';
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$this->MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error();
			return FALSE;
		}
	//	else
	//		$this->MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
	  
	}

public function GetReg($MsgErro){
	   
	//echo  "<br/>Recuperando tipo_contato ";
					
	//echo 'TP_Contato:' . $this->TP_Contato;
	$query = 'Select * FROM tipo_contato WHERE TP_Contato = "' . $this->TP_Contato . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'tipo_contato n�o encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando tipo_contato ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo contato já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_contato set TP_Contato = '" . $this->TP_Contato . "' , NM_Tipo_Contato = '"
			 . $this->NM_Tipo_Contato . "' where TP_Contato = '" . $this->TP_Contato . "'";
		
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