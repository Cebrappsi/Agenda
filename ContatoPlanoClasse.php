<?php
class ContatoPlano {
  
	public $Regs;
	public $SQ_Contato;
	public $SQ_Convenio;
	public $SQ_Plano;
	public $DT_Validade;
	public $NR_Inscricao;

    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados dos planos do paciente " 
		if ($this->SQ_Convenio < 1){
			$MsgErro = 'Sequencial da Convênio inválido';
			return FALSE;
		}
		if ($this->SQ_Plano < 1){
			$MsgErro = 'Sequencial do Plano inválido';
			return FALSE;
		}
		
		$data = explode('/', $this->DT_Validade);
		// echo implode('-',  array_reverse(explode('/',$this->DT_Validade))) . date('Y-m-d');
		if ($this->DT_Validade <> '' && $this->DT_Validade <> '00/00/0000')
		    if (!checkdate($data[1], $data[0], $data[2])){
				$MsgErro = 'Data de Validade inválida';
				return FALSE;
			}elseif (implode('-',  array_reverse(explode('/',$this->DT_Validade))) < date('Y-m-d')){
					$MsgErro = 'Data de Validade não pode ser menor que atual';
					return FALSE;
				}
						
		//if ($this->NR_Inscricao == 0){
		//	$MsgErro = 'Numero Inscrição inválido';
		//	return FALSE;
		//}
		
		return TRUE;
	}

	
	/* Retorna Falso se deu erro no Banco ou não existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro(&$MsgErro){
		//Valida se registro já existe
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select SQ_Contato FROM Contato_Plano WHERE SQ_Contato = '   . $this->SQ_Contato .
		                                         ' and SQ_Convenio = ' . $this->SQ_Convenio . 
											  	 ' and SQ_Plano    = ' . $this->SQ_Plano;
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

		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Plano já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		if ($this->DT_Validade <> '' && $this->DT_Validade <> '00/00/0000')
			$this->DT_Validade = implode('-',  array_reverse(explode('/',$this->DT_Validade)));
		
		$query = 'INSERT INTO Contato_Plano (SQ_Contato,SQ_Convenio,SQ_Plano,DT_Validade,NR_Inscricao) ' .
								' values ('     . $this->SQ_Contato .
								          ', '  . $this->SQ_Convenio .
		                                  ', '  . $this->SQ_Plano .
		                                  ', "' . $this->DT_Validade .
		                                  '", ' . $this->NR_Inscricao . ')';
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
					
	$query = 'DELETE FROM Contato_plano WHERE SQ_Contato = ' . $this->SQ_Contato .
	                             ' and SQ_Convenio = ' . $this->SQ_Convenio .
								 ' and SQ_Plano    = ' . $this->SQ_Plano;
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
	$query = 'Select * FROM Contato_plano WHERE SQ_Contato = ' . $this->SQ_Contato .
	                             		 ' and SQ_Convenio = ' . $this->SQ_Convenio .
								 		 ' and SQ_Plano    = ' . $this->SQ_Plano;
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Convenio não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Contato Plano ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		$query = 'UPDATE Contato_Plano set DT_Validade = "' . $this->DT_Validade .
		                               '", NR_Inscricao= ' . $this->NR_Inscricao .
		                            ' WHERE SQ_Contato = ' . $this->SQ_Contato .
	                                 ' and SQ_Convenio = ' . $this->SQ_Convenio .
								     ' and SQ_Plano    = ' . $this->SQ_Plano;
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