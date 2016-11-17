<?php
class TipoEnderecoClass {
  
	public $Regs;
	public $TP_Endereco;
	public $NM_Tipo_Endereco;
    
	private function Valida_Dados(&$MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_Endereco: " . $this->TP_Endereco . 'Nome: ' . $this->NM_Tipo_Endereco;
		if ($this->TP_Endereco == ""){
		   $MsgErro = 'Código tipo_Endereço inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Endereco == ""){
		   $MsgErro = 'Nome tipo Endereco inválido';
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
		$query = "Select TP_Endereco FROM tipo_Endereco WHERE TP_Endereco = '" . $this->TP_Endereco . "'";
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
	   
		//echo  "<br/>Inserindo tipo_Endereco ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Tipo_Endereco já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_Endereco (TP_Endereco,NM_Tipo_Endereco)
								values ("' . strtoupper($this->TP_Endereco) . '" , "' . $this->NM_Tipo_Endereco . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete(&$MsgErro){
	   
		//echo  "<br/>Excluindo tipo_Endereco ";
						
		$query = 'DELETE FROM tipo_Endereco WHERE TP_Endereco = "' . $this->TP_Endereco . '"';
	
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
	   
	//echo  "<br/>Recuperando tipo_Endereco ";
					
	//echo 'TP_Endereco:' . $this->TP_Endereco;
	$query = 'Select * FROM tipo_Endereco WHERE TP_Endereco = "' . $this->TP_Endereco . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'tipo_Endereco não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando tipo_Endereco ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Tipo_Endereco já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_Endereco set TP_Endereco = '" . $this->TP_Endereco . "' , NM_Tipo_Endereco = '"
			 . $this->NM_Tipo_Endereco . "' where TP_Endereco = '" . $this->TP_Endereco . "'";
		
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