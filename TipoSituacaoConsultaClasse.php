<?php
class Tipo_Situacao_Consulta {
  
	public $Regs;
	public $TP_Situacao_Consulta;
	public $NM_Situacao_Consulta;
    
	private function Valida_Dados($MsgErro){ 
	  //  echo  "<br/>Validando dados Tipo_Situacao_Consulta: " . $this->TP_Situacao_Consulta . 'Nome: ' . $this->NM_Situacao_Consulta;
		if ($this->TP_Situacao_Consulta == ""){
		   $this->MsgErro = 'Tipo Situacao Consulta inválido';
		   return FALSE;
		}
	   
	    if ($this->NM_Situacao_Consulta == ""){
		   $this->MsgErro = 'Nome Tipo Situacao Consulta inválido';
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
		$query = "Select TP_Situacao_Consulta FROM Situacao_Consulta WHERE TP_Situacao_Consulta = '" . $this->TP_Situacao_Consulta . "'";
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
	   
		//echo  "<br/>Inserindo Tipo_SituacaoConsulta ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo_Situacao_Consulta já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Situacao_Consulta (TP_Situacao_Consulta,NM_Situacao_Consulta)
								values ("' . strtoupper($this->TP_Situacao_Consulta) . '" , "' . $this->NM_Situacao_Consulta . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possível incluir o registro: ' . mysql_error();
			return FALSE;
		}

		return TRUE;
	}

	public function Delete($MsgErro){
	   
		//echo  "<br/>Excluindo Tipo_SituacaoConsulta ";
						
		$query = 'DELETE FROM Situacao_Consulta WHERE TP_Situacao_Consulta = "' . $this->TP_Situacao_Consulta . '"';
	
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
	   
	//echo  "<br/>Recuperando Tipo_SituacaoConsulta ";
					
	//echo 'TP_Situacao_Consulta:' . $this->TP_Situacao_Consulta;
	$query = 'Select * FROM Situacao_Consulta WHERE TP_Situacao_Consulta = "' . $this->TP_Situacao_Consulta . '"';
//	echo 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'Tipo Situacao Consulta não encontrado';
		return FALSE;
	}
	
	return TRUE;
	}	
	
public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando Tipo Situacao Consulta ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
/*		//echo '<br>Validando Consistencia BD';
		if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Tipo Situacao Consulta já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			return FALSE;
*/		
		$query = "UPDATE Situacao_Consulta set TP_Situacao_Consulta = '" . $this->TP_Situacao_Consulta . "' , NM_Situacao_Consulta = '"
			 . $this->NM_Situacao_Consulta . "' where TP_Situacao_Consulta = '" . $this->TP_Situacao_Consulta . "'";
		
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