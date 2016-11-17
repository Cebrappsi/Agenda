<?php
class Telefone {
  
	public $Regs;
	public $SQ_Contato;
	public $NR_Telefone;
	public $TP_Mobilidade;
	public $TP_Uso;
	public $CD_DDD;
	public $SQ_Operadora;
    
	private function Valida_Dados($MsgErro){ 
	    //echo  "<br/>Validando dados Telefone: " . $this->NR_Telefone;
	   
	    if ($this->NR_Telefone == 0){
		   $this->MsgErro = 'Numero do Telefone inválido';
		   return FALSE;
		}
		
		if ($this->TP_Mobilidade == null){
			$this->MsgErro = 'Mobilidade invalida';
			return FALSE;
		}
		
		if ($this->TP_Uso == null){
			$this->MsgErro = 'Uso inválido';
			return FALSE;
		}
		
		if ($this->CD_DDD == 0){
			$this->MsgErro = 'DDD inválido';
			return FALSE;
		}
		
		if ($this->SQ_Operadora == 0){
			$this->MsgErro = 'Operadora invalida';
			return FALSE;
		}
		
		return TRUE;
	}

	
	/* Retorna Falso se deu erro no Banco ou não existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro($MsgErro){
		//Valida se registro já existe
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select SQ_Contato FROM Telefone WHERE SQ_Contato = '   . $this->SQ_Contato .
		                                         ' and NR_Telefone = ' . $this->NR_Telefone;
		$result = mysql_query($query);	if (!$result){
			$this->MsgErro = 'Erro bd ao acessar Telefone: ' . mysql_error();
			return FALSE;
		}
		//echo 'Achei: ' . mysql_result($result,0,0);
		if (mysql_num_rows($result) == 0){
			$this->MsgErro = null;
			return FALSE;
		}
		
		return TRUE;
	}
	
	public function Insert($MsgErro){
		//echo  '<br>Inserindo Telefone ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//Nao valida - pode have mais de uma pessoa com mesmo nome
		echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Telefone já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;

		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Telefone (SQ_Contato,NR_Telefone,TP_Mobilidade,TP_Uso,CD_DDD,SQ_Operadora) ' .
								' values ('   . $this->SQ_Contato .
								       ', '   . $this->NR_Telefone .
		                               ', "'  . $this->TP_Mobilidade .
		                               '", "' . $this->TP_Uso .
		                               '", '  . $this->CD_DDD .                             
									   '", '  . $this->SQ_Operadora . ')';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir o telefone: ' . mysql_error();
			return FALSE;
		}
		
		return TRUE;
	}

public function Delete($MsgErro){
	   
	//echo  "<br/>Excluindo Telefone ";
					
	$query = 'DELETE FROM Telefone WHERE SQ_Contato = ' . $this->SQ_Contato .
	                              ' and NR_Telefone = ' . $this->NR_Telefone;
	//echo $query;

	$result = mysql_query($query);
	if (!($result && (mysql_affected_rows() > 0)))
	{
		$this->MsgErro = 'Não foi possivel excluir o telefone: ' . mysql_error();
		return FALSE;
	}
	
	return TRUE;
	  
	}

public function GetReg($MsgErro){
	   
	//echo  "<br/>Recuperando Telefone ";
					
	//echo 'Sq_Telefone:' . $this->SQ_Telefone;
	$query = 'Select * FROM Telefone WHERE SQ_Contato = ' . $this->SQ_Contato .
	                                 ' and NR_Telefone = ' . $this->NR_Telefone;
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'Telefone não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando Telefone ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados(MsgErro))
	        return FALSE;
			
		if (!(is_numeric($this->SQ_Contato) ||(int)$this->SQ_Contato < 1)){
			$this->MsgErro = 'Sequencial Contato inválido';
			return FALSE;
		}

		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($this->MsgErro <> null)
				return FALSE;
		
		$query = 'UPDATE Telefone set SQ_Operadora  = ' . $this->SQ_Operadora .
		                           ', TP_Mobilidade = "' . $this->TP_Mobilidade .
		                           '", TP_Uso       = "' . $this->TP_Uso .
		                           '", CD_DDD       = ' . $this->CD_DDD .
 				               ' where SQ_Contato   = ' . $this->SQ_Contato .
		                         ' and NR_Telefone  = ' . $this->NR_Telefone; 
		
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		$result = mysql_query($query);
				
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Telefone não alterado: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}
}
?>
