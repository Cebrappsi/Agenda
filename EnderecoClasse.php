<?php
class Endereco {
  
	public $Regs;
	public $SQ_Contato;
	public $TP_Endereco;
	public $Rua;
	public $Numero;
	public $Complemento;
	public $Bairro;
	public $Cidade;
	public $CD_UF;
	public $CEP;
    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados Endereco: " . $this->TP_Endereco;
	   
	    if ($this->TP_Endereco == null){
		   $MsgErro = 'Tipo de endereço inválido';
		   return FALSE;
		}
		
		if ($this->CEP == 0){
			$MsgErro = 'CEP inválido';
			return FALSE;
		}
		
		if ($this->Rua == null){
			$MsgErro = 'Rua invalida';
			return FALSE;
		}
		if ($this->Bairro == null){
			$MsgErro = 'Bairro inválido';
			return FALSE;
		}
		
		if ($this->Cidade == null){
			$MsgErro = 'Cidade invalida';
			return FALSE;
		}
		
		if ($this->CD_UF == null){
			$MsgErro = 'UF invalida';
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
		
		$query = 'Select SQ_Contato FROM Endereco WHERE SQ_Contato = '   . $this->SQ_Contato .
		                                         ' and TP_Endereco = "' . $this->TP_Endereco .  '"';
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
		//echo  '<br>Inserindo Endereco ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//Nao valida - pode have mais de uma pessoa com mesmo nome
		/*
		echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Endereco já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
		*/		
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Endereco (SQ_Contato,TP_Endereco,Rua,Numero,Complemento,Bairro,Cidade,CD_UF,CEP) ' .
								' values ('   . $this->SQ_Contato .
								       ', "'  . $this->TP_Endereco .
		                               '", "' . $this->Rua .
		                               '", "' . $this->Numero .
		                               '", "' . $this->Complemento .
		                               '", "' . $this->Bairro .
		                               '", "' . $this->Cidade .
		                               '", "' . $this->CD_UF .
									   '", '  . $this->CEP . ')';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error();
			return FALSE;
		}
		
		return TRUE;
	}

public function Delete(&$MsgErro){
	   
	//echo  "<br/>Excluindo Endereco ";
					
	$query = 'DELETE FROM Endereco WHERE SQ_Contato = ' . $this->SQ_Contato .
	                             ' and TP_Endereco = "' . $this->TP_Endereco .  '"';
	//echo $query;

	$result = mysql_query($query);
	if (!($result && (mysql_affected_rows() > 0)))
	{
		$MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error();
		return FALSE;
	}
	
	return TRUE;
	  
	}

public function GetReg(&$MsgErro){
	   
	//echo  "<br/>Recuperando Endereco ";
					
	//echo 'Sq_Endereco:' . $this->SQ_Endereco;
	$query = 'Select * FROM Endereco WHERE SQ_Contato = ' . $this->SQ_Contato .
	                                 ' and TP_Endereco = "' . $this->TP_Endereco .  '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Endereço não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Endereco ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Contato) ||(int)$this->SQ_Contato < 1)){
			$MsgErro = 'Sequencial Endereco inválido';
			return FALSE;
		}

		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		$query = 'UPDATE Endereco set CEP          = ' . $this->CEP .
		                           ', Rua          = "' . $this->Rua .
		                           '", Numero      = "' . $this->Numero .
		                           '", Complemento = "' . $this->Complemento .
		                           '", Bairro      = "' . $this->Bairro .
		                           '", Cidade      = "' . $this->Cidade .
		                           '", CD_UF       = "' . $this->CD_UF . 
				               '" where SQ_Contato  = ' . $this->SQ_Contato .
		                         ' and TP_Endereco = "' . $this->TP_Endereco . '"'; 
		
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		$result = mysql_query($query);
				
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Registro não alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>