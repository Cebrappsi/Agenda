<?php
class Escala {
  
	public $Regs;
	public $SQ_Contato;
	public $DT_Ini_Escala;
	public $DT_Fim_Escala;
	public $Dia_Semana;
	public $Intervalo_Atendimento;
	public $HR_Ini_Turno1;
	public $HR_Fim_Turno1;
	public $HR_Ini_Turno2;
	public $HR_Fim_Turno2;
    
	private function Valida_Dados($MsgErro){ 
	    //echo  "<br/>Validando dados Contato: " . $this->SQ_Contato ;
	    print_r($this);
		if (!(is_numeric($this->SQ_Contato) ||(int)$this->SQ_Contato > 0)){
			$this->MsgErro = 'Sequencial Contato inválido';
			return FALSE;
		}
		
		if ($this->DT_Ini_Escala == '' || !checkdate(date('m',$this->DT_Ini_Escala), date('d',$this->DT_Ini_Escala), date('Y',$this->DT_Ini_Escala))){
			$this->MsgErro = 'Data de Inicio da Escala inválida';
			return FALSE;
		}
		
		if ($this->DT_Fim_Escala <> '')
			if (!checkdate(date('m',$this->DT_Fim_Escala), date('d',$this->DT_Fim_Escala), date('Y',$this->DT_Fim_Escala))){
				$this->MsgErro = 'Data Final da Escala inválida';
				return FALSE;
			}
			elseif ($this->DT_Fim_Escala < $this->DT_Ini_Escala){
				$this->MsgErro = 'Data de Fim deve ser maior que Inicio';
				return FALSE;
			}	
			
		if (!(is_numeric($this->Dia_Semana) ||(int)$this->dia_Semana > 0 ||(int)$this->dia_Semana < 8 )){
			$this->MsgErro = 'Dia da Semana inválido';
		    return FALSE;
		}
		
		if (!(is_numeric($this->Intervalo_Atendimento) ||(int)$this->Intervalo_Atendimento > 15)){
			$this->MsgErro = 'Intervalo Atendimento invalido - nao numerico ou muito grande - deve ser menor que 15 minutos';
		    return FALSE;
		}
						
		echo $this->HR_Ini_Turno1;
		if (!isTime($this->HR_Ini_Turno1,true,false)){
			$this->MsgErro = 'Hora Inicio Turno 1 inválida';
			return FALSE;
		}
		
		if (!isTime($this->HR_Fim_Turno1,true,false)){
			$this->MsgErro = 'Hora Fim Turno 1 inválida';
			return FALSE;
		}
		
		if ($this->HR_Fim_Turno1 <= $this->HR_Ini_Turno1){
			$this->MsgErro = 'Data de Fim deve ser maior que Inicio';
			return FALSE;
		}
		
/*		
		if (!isTime($this->HR_Ini_Turno2,true,false)){
			$this->MsgErro = 'Hora Inicio Turno 2 inválida';
			return FALSE;
		}
		
		if (!isTime($this->HR_Fim_Turno2,true,false)){
			$this->MsgErro = 'Hora Fim Turno 2 inválida';
			return FALSE;
		}
*/			
		if ($this->HR_Fim_Turno2 < $this->HR_Ini_Turno2){
			$this->MsgErro = 'Data de Fim turno 2 deve ser maior que Inicio';
			return FALSE;
		}
		
		
		return TRUE;
	}
	
	/* Retorna Falso se deu erro no Banco ou nao existe
	 * Retorna True se existe
	 * Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Existe_Registro($MsgErro){
		//Valida se registro já existe
		//echo  "<br>Validando Consistencia do Registro";
		
		$query = 'Select SQ_Contato FROM Escala ' .
		         'WHERE SQ_Contato    =  ' . $this->SQ_Contato    . ' and ' . 
		               'DT_Ini_Escala = "' . $this->DT_Ini_Escala . '" and ' .
		               'Dia_Semana = ' . $this->Dia_Semana;
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
		
		return TRUE;
	}
	
	public function Insert($MsgErro){
		//echo  '<br>Inserindo Contato ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;

		//echo '<br>Validando Consistencia BD';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Escla já existe';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;

		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO escala (SQ_Contato,DT_Ini_Escala,DT_Fim_Escala,Dia_Semana,Intervalo_Atendimento,' .
		                             'HR_Ini_Turno1,HR_Fim_Turno1,HR_Ini_Turno2,HR_Fim_Turno2) ' .
								' values (' . $this->SQ_Contato . ' , ' .
		                                '"' . $this->DT_Ini_Escala . '", ' .
		                                '"' . $this->DT_Fim_Escala . '", ' . 
										      $this->Dia_Semana    . ' , ' .
										     $this->Intervalo_Atendimento . ' , ' .
										'"' . $this->HR_Ini_Turno1 . '", ' . 
										'"' . $this->HR_Fim_Turno1 . '", ' . 
										'"' . $this->HR_Ini_Turno2 . '" , ' .
										'"' . $this->HR_Fim_Turno2 . '")';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir a escala: ' . mysql_error();
			return FALSE;
		}
				
		//echo $this->SQ_Contato;
		return TRUE;
}

public function Delete($MsgErro){
	   
	//echo  "<br/>Excluindo Contato ";
					
	$query = 'DELETE FROM Escala WHERE SQ_Contato     = ' . $this->SQ_Contato .
	                              ' and DT_Ini_Escala = "' . $this->DT_Ini_Escala .
	                              '" and Dia_Semana    = ' . $this->Dia_Semana; 
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
	$query = 'Select * FROM escala WHERE SQ_Contato = ' . $this->SQ_Contato .
	                           ' and DT_Ini_Escala = "' . $this->DT_Ini_Escala .
	                           '" and Dia_Semana    = ' . $this->Dia_Semana;
	// 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$this->MsgErro = 'Erro no Banco de Dados na busca da escala:' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$this->MsgErro = 'Escala não encontrada';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit($MsgErro){
	   
		//echo  "<br/>Alterando Escala ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados(MsgErro))
	        return FALSE;
			
		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($this->MsgErro <> null)
				return FALSE;
		
		$query = 'UPDATE escala set DT_Fim_Escala          = ' . '"' . $this->DT_Fim_Escala . '", ' . 
		                            ' Intervalo_Atendimento = ' .       $this->Intervalo_Atendimento . ' , ' .
		                            ' HR_Ini_Turno1         = ' . '"' . $this->HR_Ini_Turno1 . '", ' .
		                            ' HR_Fim_Turno1         = ' . '"' . $this->HR_Fim_Turno1 . '", ' .
		                            ' HR_Ini_Turno2         = ' . '"' . $this->HR_Ini_Turno2 . '" , ' .
		                            ' HR_Fim_Turno2         = ' . '"' . $this->HR_Fim_Turno2 . '"' .
				             	 'where SQ_Contato   =  ' . $this->SQ_Contato . 
				                 ' and DT_Ini_Escala = "' . $this->DT_Ini_Escala . '"' .
		                         ' and Dia_Semana    = '  . $this->Dia_Semana; ;
		
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		$result = mysql_query($query);
				
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Escala não alterada: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}		
}
?>