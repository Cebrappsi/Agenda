<?php
class tipo_Uso {
  
	public $Regs;
	public $TP_Uso;
	public $NM_Tipo_Uso;
    
	private function Valida_Dados($MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_Uso: " . $this->TP_Uso . 'Nome: ' . $this->NM_Tipo_Uso;
		if ($this->TP_Uso == ""){
		   $this->MsgErro = 'Código tipo_Uso inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Uso == ""){
		   $this->MsgErro = 'Nome tipo Uso inválido';
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
		$query = "Select TP_Uso FROM tipo_Uso WHERE TP_Uso = '" . $this->TP_Uso . "'";
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
	   
		//echo  "<br/>Inserindo tipo_Uso ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_Uso já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_Uso (TP_Uso,NM_Tipo_Uso)
								values ("' . strtoupper($this->TP_Uso) . '" , "' . $this->NM_Tipo_Uso . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
	   
		//echo  "<br/>Excluindo tipo_Uso ";
						
		$query = 'DELETE FROM tipo_Uso WHERE TP_Uso = "' . $this->TP_Uso . '"';
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$this->MsgErro = 'Não foi possível excluir o registro: ' . mysql_error();
			return FALSE;
		}
	//	else
	//		$this->MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
	  
	}

public function GetReg($MsgErro){
	   
	//echo  "<br/>Recuperando tipo_Uso ";
					
	//echo 'TP_Uso:' . $this->TP_Uso;
	$query = 'Select * FROM tipo_Uso WHERE TP_Uso = "' . $this->TP_Uso . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'tipo_Uso não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando tipo_Uso ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_Uso já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_Uso set TP_Uso = '" . $this->TP_Uso . "' , NM_Tipo_Uso = '"
			 . $this->NM_Tipo_Uso . "' where TP_Uso = '" . $this->TP_Uso . "'";
		
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