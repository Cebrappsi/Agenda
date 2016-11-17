<?php
class tipo_relacao {
  
	public $Regs;
	public $TP_Relacao;
	public $NM_Tipo_Relacao;
    
	private function Valida_Dados($MsgErro){ 
	  //  echo  "<br/>Validando dados tipo_Relacao: " . $this->TP_Relacao . 'Nome: ' . $this->NM_Tipo_Relacao;
		if ($this->TP_Relacao == ""){
		   $this->MsgErro = 'Código tipo_Relacao inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Tipo_Relacao == ""){
		   $this->MsgErro = 'Nome tipo_Relacao inválido';
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
		$query = "Select TP_Relacao FROM tipo_Relacionamento WHERE TP_Relacao = '" . $this->TP_Relacao . "'";
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
	   
		//echo  "<br/>Inserindo tipo_Relacao ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_Relacao já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO tipo_Relacionamento (TP_Relacao,NM_Tipo_Relacao)
								values ("' . strtoupper($this->TP_Relacao) . '" , "' . $this->NM_Tipo_Relacao . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
	   
		//echo  "<br/>Excluindo tipo_Relacao ";
						
		$query = 'DELETE FROM tipo_Relacionamento WHERE TP_Relacao = "' . $this->TP_Relacao . '"';
	
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
	   
	//echo  "<br/>Recuperando tipo_Relacao ";
					
	//echo 'TP_Relacao:' . $this->TP_Relacao;
	$query = 'Select * FROM tipo_Relacionamento WHERE TP_Relacao = "' . $this->TP_Relacao . '"';
	//echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'tipo_Relacao não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando tipo_Relacao ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo Relacao já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE tipo_Relacionamento set TP_Relacao = '" . $this->TP_Relacao . "' , NM_Tipo_Relacao = '"
			 . $this->NM_Tipo_Relacao . "' where TP_Relacao = '" . $this->TP_Relacao . "'";
		
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