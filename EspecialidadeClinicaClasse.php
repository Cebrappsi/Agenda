<?php
class Especialidade_Clinica {
  
	public $Regs;
	public $SQ_Especialidade_Clinica;
	public $NM_Especialidade_Clinica;
	public $Tempo_Atendimento;

	private function Valida_Dados($MsgErro){ 
	  //  echo  '<br/>Validando dados Especialidade_Clinica: ' . 'Nome: ' . $this->NM_Especialidade_Clinica .
	  //             
		if ($this->NM_Especialidade_Clinica == null){
			$this->MsgErro = 'Nome Especialidade Clinica inválido';
			return FALSE;
		}

		if (!(is_numeric($this->Tempo_Atendimento) ||(int)$this->Tempo_Atendimento < 10)){
			$this->MsgErro = 'Tempo de atendimento inválido';
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
		$query = 'Select SQ_Especialidade_Clinica FROM Especialidade_Clinica WHERE NM_Especialidade_Clinica = "' . $this->NM_Especialidade_Clinica . '"';
		$result = mysql_query($query);
		if (!$result){
			$this->MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $query;
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
		//echo  '<br/>Inserindo Especialidade_Clinica ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Especialidade Clinica já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Especialidade_Clinica (NM_Especialidade_Clinica,Tempo_Atendimento)
								values ("' . $this->NM_Especialidade_Clinica . 
								      '",' . $this->Tempo_Atendimento .
		                               ')';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
		   
		//echo  "<br>Excluindo Especialidades da Clinica>";
						
		$query = 'DELETE FROM Especialidade_Clinica WHERE SQ_Especialidade_Clinica = ' . $this->SQ_Especialidade_Clinica;
		//echo $query;
	
		$result = mysql_query($query);
		if (!($result && (mysql_affected_rows() > 0)))
		{
			$this->MsgErro = 'Não foi possivel excluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
	//	else
	//		$this->MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
		
		return TRUE;
		  
	}
	
	public function GetReg($MsgErro){
		   
		//echo  "<br>Recuperando Especialidade_Clinica ";
						
		//echo 'Sq_Especialidade_Clinica:' . $this->SQ_Especialidade_Clinica;
		$query = 'Select * FROM Especialidade_Clinica WHERE SQ_Especialidade_Clinica = ' . $this->SQ_Especialidade_Clinica;
		//echo 'Query: ' . $query;
		$this->Regs = mysql_query($query);
		if (!$this->Regs){
			$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error() . '<br>Query: ' . $query;
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
	   
		//echo  "<br>Alterando Especialidade_Clinica ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		if (!(is_numeric($this->SQ_Especialidade_Clinica) ||(int)$this->SQ_Especialidade_Clinica < 1)){
			$this->MsgErro = 'Sequencial Especialidade_Clinica inválido';
			return FALSE;
		}
		
		/*
		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Especialidade Clinica já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
		*/
		
		$query = 'UPDATE Especialidade_Clinica 
		          set NM_Especialidade_Clinica = "' . $this->NM_Especialidade_Clinica . 
			    	 '", Tempo_Atendimento       = '  . $this->Tempo_Atendimento .
				     ' where SQ_Especialidade_Clinica = ' . $this->SQ_Especialidade_Clinica ;
		
		$result = mysql_query($query);
	//	echo $query . mysql_affected_rows() . mysql_error() . gettype($result) . '<br>Query: ' . $query;
		
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Registro não alterado: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		return TRUE;
	}
}
?>