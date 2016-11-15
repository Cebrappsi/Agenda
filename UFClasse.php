<?php
class UF {
  
	public $Regs;
	public $CD_UF;
	public $NM_UF;
    
	private function Valida_Dados($MsgErro){ 
	  //  echo  "<br/>Validando dados UF: " . $this->CD_UF . 'Nome: ' . $this->NM_UF;
		if ($this->CD_UF == ""){
		   $this->MsgErro = 'Código UF inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_UF == ""){
		   $this->MsgErro = 'Nome UF inv�lido';
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
		$query = "Select CD_UF FROM UF WHERE CD_UF = '" . $this->CD_UF . "'";
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
	   
		//echo  "<br/>Inserindo UF ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'UF já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO UF (CD_UF,NM_UF)
								values ("' . strtoupper($this->CD_UF) . '" , "' . $this->NM_UF . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
	   
		//echo  "<br/>Excluindo UF ";
						
		$query = 'DELETE FROM UF WHERE CD_UF = "' . $this->CD_UF . '"';
		//echo $query;
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$this->MsgErro = 'Nao foi possivel excluir o registro: ' . mysql_error();
			return FALSE;
		}
	//	else
	//		$this->MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
	  
	}

public function GetReg($MsgErro){
	   
	//echo  "<br/>Recuperando UF ";
					
	//echo 'CD_UF:' . $this->CD_UF;
	$query = 'Select * FROM UF WHERE CD_UF = "' . $this->CD_UF . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'UF não encontrada';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando UF ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'UF já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE UF set CD_UF = '" . $this->CD_UF . "' , NM_UF = '"
			 . $this->NM_UF . "' where CD_UF = '" . $this->CD_UF . "'";
		
		$result = mysql_query($query);
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Registro nao alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>
