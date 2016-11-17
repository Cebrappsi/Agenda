<?php
class Agenda {
  
	public $Regs;
	public $DT_Consulta;
	public $HR_Consulta;
	public $SQ_Contato_Profissional;
	public $SQ_Contato_Paciente;
	public $SQ_Plano;
	public $SQ_Sala;
	public $TP_Situacao_Consulta;
    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados Profissional: " . $this->SQ_Contato_Profissional ;
	    //print_r($this);
		if (!(is_numeric($this->SQ_Contato_Profissional) && (int)$this->SQ_Contato_Profissional > 0)){
			$MsgErro = 'Sequencial Profissional inválido';
			return FALSE;
		}
		if (!(is_numeric($this->SQ_Contato_Paciente) && (int)$this->SQ_Contato_Paciente > 0)){
			$MsgErro = 'Sequencial Paciente inválido';
			return FALSE;
		}
		if (!(is_numeric($this->SQ_Plano) && (int)$this->SQ_Plano > 0)){
			$MsgErro = 'Sequencial Paciente inválido';
			return FALSE;
		}
		
		$data = explode('/', $this->DT_Consulta);
		if ($this->DT_Consulta == '' || !checkdate($data[1], $data[0], $data[2])){
			$MsgErro = 'Data da Consulta inválida';
			return FALSE;
		}

		if (!(is_numeric($this->SQ_Sala) && (int)$this->SQ_Sala > 0)){
			$MsgErro = 'Sequencial Paciente inválido';
			return FALSE;
		}
		
		//echo $this->HR_Consulta;
		if (!isTime($this->HR_Consulta,true,false)){
			$MsgErro = 'Hora Consulta inválida';
			return FALSE;
		}
		
		return TRUE;
	}
	
	/* Retorna Falso se deu erro no Banco ou nao existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro(&$MsgErro){
		//Valida se registro já existe
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select SQ_Contato_Profissional' .
				 ' from Consulta ' .
				 ' Where DT_Consulta = "' . implode('-',  array_reverse(explode('/',$this->DT_Consulta))) . '"' .
				 ' and HR_Consulta =  "' . date('H:i',$this->HR_Consulta) . '"' . 
				 ' and SQ_Contato_Profissional = ' . $this->SQ_Contato_Profissional;
		
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
		//echo  '<br>Inserindo Profissional ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$MsgErro = 'Já há Consulta marcada para o profissional no horário';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;

		//echo '<br>Inserindo Registro';
		if ($this->DT_Consulta <> '' && $this->DT_Consulta <> '00/00/0000')
			$this->DT_Consulta = implode('-',  array_reverse(explode('/',$this->DT_Consulta)));
		
		$query = 'INSERT INTO Consulta (DT_Consulta,HR_Consulta,SQ_Contato_Profissional,SQ_Contato_Paciente,' .
		                               'SQ_Plano,SQ_Sala,TP_Situacao_Consulta) ' .
								' values ("' . $this->DT_Consulta . '" , ' .
		                                 '"' . $this->HR_Consulta . '" , ' .
		                                       $this->SQ_Contato_Profissional . ', ' .
		                                       $this->SQ_Contato_Paciente . ', ' .
											   $this->SQ_Plano . ', ' .
		                                       $this->SQ_Sala  . ' , ' .
										  '"'. $this->TP_Situacao_Consulta . '")';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir a Consulta: ' . mysql_error();
			return FALSE;
		}
				
		//echo $this->SQ_Contato_Profissional;
		return TRUE;
}

public function Delete(&$MsgErro){
	   
	//echo  "<br/>Excluindo Profissional ";
					
	$query = 'DELETE FROM Consulta WHERE DT_Consulta = "' . implode('-',  array_reverse(explode('/',$this->DT_Consulta))) .
	                              '" and HR_Consulta = "' . $this->HR_Consulta .
	                              '" and SQ_Contato_Profissional = ' . $this->SQ_Contato_Profissional; 
	//echo $query;

	$result = mysql_query($query);
	if (!($result && (mysql_affected_rows() > 0)))
	{
		$MsgErro = 'Não foi possivel excluir o Consulta: ' . mysql_error();
		return FALSE;
	}
//	else
//		$MsgErro = mysql_affected_rows() . ' registro(s) excluido(s) com sucesso';
	
	return TRUE;
	  
}

public function GetReg(&$MsgErro){
	   
	//echo  "<br/>Recuperando Consulta ";
					
	$query ='Select * FROM Consulta WHERE DT_Consulta = "' . implode('-',  array_reverse(explode('/',$this->DT_Consulta))) .
	                                '" and HR_Consulta = "' . $this->HR_Consulta .
	                                '" and SQ_Contato_Profissional = ' . $this->SQ_Contato_Profissional; 
	// 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados na busca da consulta:' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Consulta não encontrada';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Consulta ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		if ($this->DT_Consulta <> '' && $this->DT_Consulta <> '00/00/0000')
			$this->DT_Consulta = implode('-',  array_reverse(explode('/',$this->DT_Consulta)));
		
		$query = 'UPDATE Consulta set SQ_Contato_Paciente = ' . $this->SQ_Contato_Paciente . ',' . 
		                            ' SQ_Sala             = ' . $this->SQ_Sala . ',' .
		                            ' SQ_Plano            = ' . $this->SQ_Plano . ',' .
		                            ' TP_Situacao_Consulta= "' . $this->TP_Situacao_Consulta . '" ' .
				             	    ' where DT_Consulta       = "' . $this->DT_Consulta . '"' .  
				             	    ' and HR_Consulta        = "' . $this->HR_Consulta . '"' .
		                            ' and SQ_Contato_Profissional = '  . $this->SQ_Contato_Profissional;
		
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		$result = mysql_query($query);
				
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Consulta não alterada: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}		
}
?>