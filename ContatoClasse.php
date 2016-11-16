<?php
class Contato {
  
	public $Regs;
	public $SQ_Contato;
	public $NM_Contato;
	public $TP_Contato;
	public $DT_Nascimento;
	public $Identificacao;
	public $Observacoes;
    
	private function Valida_Dados($MsgErro){ 
	    //echo  "<br/>Validando dados Contato: " . $this->NM_Contato . 'Nome: ' . $this->TP_Contato;
	   
	    if ($this->NM_Contato == null){
		   $this->MsgErro = 'Nome Contato inválido';
		   return FALSE;
		}
		
		if ($this->DT_Nascimento <> '')
			if (!checkdate(date('m',$this->DT_Nascimento), date('d',$this->DT_Nascimento), date('Y',$this->DT_Nascimento))){
				$this->MsgErro = 'Data de Nascimento inválida';
				return FALSE;
			}
			elseif ($this->DT_Nascimento > date('Y-m-d')){
				$this->MsgErro = 'Data de Nascimento não pode ser maior que atual';
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
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select NM_Contato FROM Contato WHERE NM_Contato = ' . $this->NM_Contato;
		$result = mysql_query($query);
		if (!$result){
			$this->MsgErro = 'Erro bd: ' . mysql_error();
			return FALSE;
		}
		//echo 'Achei: ' . mysql_result($result,0,0);
		if (mysql_num_rows($result) == 0){
			$this->MsgErro = null;
			return FALSE;
		}
		die('true');
		return TRUE;
	}
	
	public function Insert($MsgErro){
		//echo  '<br>Inserindo Contato ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//Nao valida - pode have mais de uma pessoa com mesmo nome
		/*
		echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Contato já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
		*/		
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Contato (NM_Contato,TP_Contato,DT_Nascimento,Identificacao,Observacoes) ' .
								' values ("' . $this->NM_Contato . '" , "'  
									        . $this->TP_Contato  . '" , "' 
										    . $this->DT_Nascimento . '" , "' 
										    . $this->Identificacao . '" , "' 
										    . $this->Observacoes . '")';
	
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

public function Delete($MsgErro){
	   
	//echo  "<br/>Excluindo Contato ";
					
	$query = 'DELETE FROM Contato WHERE SQ_Contato = ' . $this->SQ_Contato;
	//echo $query;

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
	   
	//echo  "<br/>Recuperando Contato ";
					
	//echo 'Sq_Contato:' . $this->SQ_Contato;
	$query = 'Select * FROM Contato WHERE SQ_Contato = ' . $this->SQ_Contato;
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'Sequencial do Registro não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando Contato ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados(MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Contato) ||(int)$this->SQ_Contato < 1)){
			$this->MsgErro = 'Sequencial Contato inválido';
			return FALSE;
		}

		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Contato já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
		
		$query = 'UPDATE Contato set NM_Contato    = "' . $this->NM_Contato . '" , ' .
									'TP_Contato    = "' . $this->TP_Contato . '",' .
								    'DT_Nascimento = "' . $this->DT_Nascimento . '", ' .
									'Identificacao = "' . $this->Identificacao . '",' .
				            		'Observacoes   = "' . $this->Observacoes . '"'; 
		
		$result = mysql_query($query);
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Registro não alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>
