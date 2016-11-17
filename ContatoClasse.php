<?php
class Contato {
  
	public $Regs;
	public $SQ_Contato;
	public $NM_Contato;
	///public $TP_Relacao;
	public $DT_Nascimento;
	public $Identificacao;
	public $Observacoes;
    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados Contato: " . $this->NM_Contato . 'Nome: ' . $this->TP_Relacao;
	   
	    if ($this->NM_Contato == null){
		   $MsgErro = 'Nome Contato inválido';
		   return FALSE;
		}
		
		//if ($this->TP_Relacao == null){
		//	$MsgErro = 'Informe pelo menos um dos tipos do contato';
		//	return FALSE;
	//	}
		
//		
		$data = explode('/', $this->DT_Nascimento);
		if ($this->DT_Nascimento == '' || !checkdate($data[1], $data[0], $data[2])){
			$MsgErro = 'Data de Nascimento inválida';
			return FALSE;
		} elseif (strtotime($data) > date('Y-m-d')){
				$MsgErro = 'Data de Nascimento não pode ser maior que atual';
				return FALSE;
				}
		
		return TRUE;
	}
	
	/* Retorna Falso se deu erro no Banco ou n?o existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro(&$MsgErro){
		//Valida se registro já existe
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select SQ_Contato FROM Contato WHERE SQ_Contato = ' . $this->SQ_Contato;
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
		//echo  '<br>Inserindo Contato ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//Nao valida - pode have mais de uma pessoa com mesmo nome
		/*
		echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Contato já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;
		*/		
		//echo '<br>Inserindo Registro';
		if ($this->DT_Nascimento <> '' && $this->DT_Nascimento <> '00/00/0000')
			$this->DT_Nascimento = implode('-',  array_reverse(explode('/',$this->DT_Nascimento)));
		$query = 'INSERT INTO Contato (NM_Contato,DT_Nascimento,Identificacao,Observacoes) ' .
								' values ("' . $this->NM_Contato . '" , "'  
									        . $this->DT_Nascimento . '" , "' 
										    . $this->Identificacao . '" , "' 
										    . $this->Observacoes . '")';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error();
			return FALSE;
		}
		$this->SQ_Contato = mysql_insert_id();
		
		if (!$this->SQ_Contato || $this->SQ_Contato == 0){
			$MsgErro = 'Erro na recuperacao do último contato inserido: ' . mysql_error();
			return FALSE;
		}
		
		//echo $this->SQ_Contato;
		return TRUE;
	}

public function Delete(&$MsgErro){
	   
	// Excluir Relações
	$query = 'Delete from Relacionamento where SQ_Contato = ' . $this->SQ_Contato;
		//die($query);
	$result = mysql_query($query);
	
	if (!$result) {
		$MsgErro = 'Não foi possivel excluir as Relacoes do contato: ' . mysql_error();
		return FALSE;
	}	//echo  "<br/>Excluindo Relações do Contato ";
	
	// Excluir o Contato
	$query = 'DELETE FROM Contato WHERE SQ_Contato = ' . $this->SQ_Contato;
	//echo $query;

	$result = mysql_query($query);
	if (!($result && (mysql_affected_rows() > 0)))
	{
		$MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error();
		return FALSE;
	}
//	else
//		$MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
	
	return TRUE;
	  
	}

public function GetReg(&$MsgErro){
	   
	//echo  "<br/>Recuperando Contato ";
					
	//echo 'Sq_Contato:' . $this->SQ_Contato;
	$query = 'Select * FROM Contato WHERE SQ_Contato = ' . $this->SQ_Contato;
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Sequencial do Registro não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Contato ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Contato) ||(int)$this->SQ_Contato < 1)){
			$MsgErro = 'Sequencial Contato inválido';
			return FALSE;
		}

		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		if ($this->DT_Nascimento <> '' && $this->DT_Nascimento <> '00/00/0000')
			$this->DT_Nascimento = implode('-',  array_reverse(explode('/',$this->DT_Nascimento)));
		$query = 'UPDATE Contato set NM_Contato    = "' . $this->NM_Contato    . '" , ' .
								    'DT_Nascimento = "' . $this->DT_Nascimento . '" , ' .
									'Identificacao = "' . $this->Identificacao . '" , ' .
				            		'Observacoes   = "' . $this->Observacoes   . '" ' .
				            	'where SQ_Contato = ' . $this->SQ_Contato; 
		
		$result = mysql_query($query);
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
				
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Contato não alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}

	public function InsertRelacoes(&$MsgErro){
		//echo  '<br>Inserindo Relações co Contato ';
	
		//  echo '<br>Contato deve existir BD';
		
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		$resConsRel = mysql_query('select * from Relacionamento where SQ_Contato = ' . $this->SQ_Contato .
				                     ' and TP_Relacao = "' . $this->TP_Relacao  . '"');
		if (!$resConsRel){
			$MsgErro = 'Erro bd: ' . mysql_error();
			return FALSE;
		}
		//echo 'Achei: ';
		if (mysql_num_rows($resConsRel) > 0){ //ja tem registro - ok
			$MsgErro = null;
			return TRUE;
		}		
		// ainda não tem registro - inserir novo
		$query = 'INSERT INTO Relacionamento (SQ_Contato,TP_Relacao) ' .
				' values (' . $this->SQ_Contato . ' , "'
			             	. $this->TP_Relacao  . '")';
		//die($query);
		$result = mysql_query($query);
	
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir as Relacoes: ' . mysql_error();
			return FALSE;
		}
	
		return TRUE;
	}
	
	public function DeleteRelacoes(&$MsgErro){
		//echo  '<br>Inserindo Relações co Contato ';
	
		//  echo '<br>Contato deve existir BD';
	
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
			return FALSE;
	
		$resConsRel = mysql_query('select * from Relacionamento where SQ_Contato = ' . $this->SQ_Contato .
				' and TP_Relacao = "' . $this->TP_Relacao  . '"');
		if (!$resConsRel){
			$MsgErro = 'Erro bd: ' . mysql_error();
			return FALSE;
		}
		//echo 'Achei: ';
		if (mysql_num_rows($resConsRel) < 1){
			$MsgErro = null;
			return TRUE;
		}
		// Já tem registro - excluir
		$query = 'Delete from Relacionamento where SQ_Contato = ' . $this->SQ_Contato . 
		                 ' and TP_Relacao = "' . $this->TP_Relacao  . '"';
		//die($query);
		$result = mysql_query($query);
	
		if (!($result || (mysql_affected_rows() < 1))) {
			$MsgErro = 'Não foi possivel excluir as Relacoes: ' . mysql_error();
			return FALSE;
		}
	
		return TRUE;
	}
		
}
?>
