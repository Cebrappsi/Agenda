<?php
class TipoMobilidadeClass {
  
	public $Regs;
	public $TP_Mobilidade;
	public $NM_Tipo_Mobilidade;
    
	private function Valida_Dados(&$MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_Mobilidade: " . $this->TP_Mobilidade . 'Nome: ' . $this->NM_Tipo_Mobilidade;
		if ($this->TP_Mobilidade == ""){
		   $MsgErro = 'Código tipo_Mobilidade inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Mobilidade == ""){
		   $MsgErro = 'Nome tipo Mobilidade inválido';
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
		$query = "Select TP_Mobilidade FROM tipo_Mobilidade WHERE TP_Mobilidade = '" . $this->TP_Mobilidade . "'";
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
	   
		//echo  "<br/>Inserindo tipo_Mobilidade ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Tipo_Mobilidade já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_Mobilidade (TP_Mobilidade,NM_Tipo_Mobilidade)
								values ("' . strtoupper($this->TP_Mobilidade) . '" , "' . $this->NM_Tipo_Mobilidade . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete(&$MsgErro){
	   
		//echo  "<br/>Excluindo tipo_Mobilidade ";
						
		$query = 'DELETE FROM tipo_Mobilidade WHERE TP_Mobilidade = "' . $this->TP_Mobilidade . '"';
	
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
	   
	//echo  "<br/>Recuperando tipo_Mobilidade ";
					
	//echo 'TP_Mobilidade:' . $this->TP_Mobilidade;
	$query = 'Select * FROM tipo_Mobilidade WHERE TP_Mobilidade = "' . $this->TP_Mobilidade . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'tipo_Mobilidade não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando tipo_Mobilidade ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Tipo_Mobilidade já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_Mobilidade set TP_Mobilidade = '" . $this->TP_Mobilidade . "' , NM_Tipo_Mobilidade = '"
			 . $this->NM_Tipo_Mobilidade . "' where TP_Mobilidade = '" . $this->TP_Mobilidade . "'";
		
		$result = mysql_query($query);
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Registro n�o alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>