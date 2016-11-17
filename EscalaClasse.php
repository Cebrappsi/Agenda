<?php
class Escala {
  
	public $Regs;
	public $SQ_Profissional;
	public $DT_Ini_Escala;
	public $DT_Fim_Escala;
	public $Dia_Semana;
	public $Duracao;
	public $Intervalo;
	public $HR_Ini_Turno1;
	public $HR_Fim_Turno1;
	public $HR_Ini_Turno2;
	public $HR_Fim_Turno2;
    
	private function Valida_Dados(&$MsgErro){ 
	    //echo  "<br/>Validando dados Profissional: " . $this->SQ_Profissional ;
	    //print_r($this);
		if (!(is_numeric($this->SQ_Profissional) && (int)$this->SQ_Profissional > 0)){
			$MsgErro = 'Sequencial Profissional inválido';
			return FALSE;
		}
		
		$data = explode('/', $this->DT_Ini_Escala);
		if ($this->DT_Ini_Escala == '' || !checkdate($data[1], $data[0], $data[2])){
			$MsgErro = 'Data de Inicio da Escala inválida';
			return FALSE;
		}
		
		if ($this->DT_Fim_Escala <> '' && $this->DT_Fim_Escala <> '00/00/0000'){
			$data = explode('/', $this->DT_Fim_Escala);
			if (!checkdate($data[1], $data[0], $data[2])){
				$MsgErro = 'Data Final da Escala inválida';
				return FALSE;
			}
			elseif (strtotime(implode('-',  array_reverse(explode('/',$this->DT_Fim_Escala)))) <= 
					strtotime(implode('-',  array_reverse(explode('/',$this->DT_Ini_Escala))))){
				$MsgErro = 'Data de Fim deve ser maior que Inicio';
				return FALSE;
			}
		}	
			
		if (!(is_numeric($this->Dia_Semana) && (int)$this->Dia_Semana > 0 && (int)$this->Dia_Semana < 8 )){
			$MsgErro = 'Dia da Semana inválido';
		    return FALSE;
		}
		
		if (!(is_numeric($this->Intervalo) && (int)$this->Intervalo < 21)){
			$MsgErro = 'Intervalo Atendimento invalido - nao numerico ou muito grande - deve ser menor que 25 minutos';
		    return FALSE;
		}
		if (!(is_numeric($this->Duracao) && (int)$this->Duracao > 0 && (int)$this->Duracao < 120 )){
			$MsgErro = 'Duração da Sessão invalida';
			return FALSE;
		}
						
		//echo $this->HR_Ini_Turno1;
		if (!isTime($this->HR_Ini_Turno1,true,false)){
			$MsgErro = 'Hora Inicio Turno 1 inválida';
			return FALSE;
		}
		
		if (!isTime($this->HR_Fim_Turno1,true,false)){
			$MsgErro = 'Hora Fim Turno 1 inválida';
			return FALSE;
		}
		
		if ($this->HR_Fim_Turno1 <= $this->HR_Ini_Turno1){
			$MsgErro = 'Data de Fim deve ser maior que Inicio';
			return FALSE;
		}
		
/*		
		if (!isTime($this->HR_Ini_Turno2,true,false)){
			$MsgErro = 'Hora Inicio Turno 2 inválida';
			return FALSE;
		}
		
		if (!isTime($this->HR_Fim_Turno2,true,false)){
			$MsgErro = 'Hora Fim Turno 2 inválida';
			return FALSE;
		}
*/			
		if ($this->HR_Fim_Turno2 < $this->HR_Ini_Turno2){
			$MsgErro = 'Data de Fim turno 2 deve ser maior que Inicio';
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
		
		$query = 'Select SQ_Profissional FROM Escala ' .
		         'WHERE SQ_Profissional    =  ' . $this->SQ_Profissional    . ' and ' . 
		               'DT_Ini_Escala = "' . implode('-',  array_reverse(explode('/',$this->DT_Ini_Escala))) . '" and ' .
		               'Dia_Semana = ' . $this->Dia_Semana;
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
			$MsgErro = 'Escala já existe';
			return FALSE;
		}
		elseif ($MsgErro <> null)
			 	return FALSE;

		//echo '<br>Inserindo Registro';
		if ($this->DT_Ini_Escala <> '' && $this->DT_Ini_Escala <> '00/00/0000')
			$this->DT_Ini_Escala = implode('-',  array_reverse(explode('/',$this->DT_Ini_Escala)));
		if ($this->DT_Fim_Escala <> '' && $this->DT_Fim_Escala <> '00/00/0000')
			$this->DT_Fim_Escala = implode('-',  array_reverse(explode('/',$this->DT_Fim_Escala)));
		
		$query = 'INSERT INTO escala (SQ_Profissional,DT_Ini_Escala,DT_Fim_Escala,Dia_Semana,Intervalo,' .
		                             'Duracao,HR_Ini_Turno1,HR_Fim_Turno1,HR_Ini_Turno2,HR_Fim_Turno2) ' .
								' values (' . $this->SQ_Profissional . ' , ' .
		                                '"' . $this->DT_Ini_Escala . '", ' .
		                                '"' . $this->DT_Fim_Escala . '", ' . 
										      $this->Dia_Semana    . ' , ' .
										      $this->Intervalo . ' , ' .
										      $this->Duracao . ' , ' .
										'"' . $this->HR_Ini_Turno1 . '", ' . 
										'"' . $this->HR_Fim_Turno1 . '", ' . 
										'"' . $this->HR_Ini_Turno2 . '" , ' .
										'"' . $this->HR_Fim_Turno2 . '")';
		//die($query);
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$MsgErro = 'Não foi possivel incluir a escala: ' . mysql_error();
			return FALSE;
		}
				
		//echo $this->SQ_Profissional;
		return TRUE;
}

public function Delete(&$MsgErro){
	   
	//echo  "<br/>Excluindo Profissional ";
					
	$query = 'DELETE FROM Escala WHERE SQ_Profissional = ' . $this->SQ_Profissional .
	                              '  and DT_Ini_Escala = "' . implode('-',  array_reverse(explode('/',$this->DT_Ini_Escala))) .
	                              '" and Dia_Semana    = ' . $this->Dia_Semana; 
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
	   
	//echo  "<br/>Recuperando Profissional ";
					
	//echo 'Sq_Profissional:' . $this->SQ_Profissional;
	$query = 'Select * FROM escala WHERE SQ_Profissional = ' . $this->SQ_Profissional .
	                           ' and DT_Ini_Escala = "' . implode('-',  array_reverse(explode('/',$this->DT_Ini_Escala))) .
	                           '" and Dia_Semana    = ' . $this->Dia_Semana;
	// 'Query: ' . $query;
	$this->Regs = mysql_query($query);
	if (!$this->Regs){
		$MsgErro = 'Erro no Banco de Dados na busca da escala:' . mysql_error();
		return FALSE;
	}
	
	//echo 'Achei: ' . mysql_result($this->Regs,0,1);
	if (mysql_num_rows($this->Regs) == 0){
		$MsgErro = 'Escala não encontrada';
		return FALSE;
	}
	
	return TRUE;
	}	
	
	public function Edit(&$MsgErro){
	   
		//echo  "<br/>Alterando Escala ";
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
			
		//  echo '<br>Validando Consistencia BD';
		if (!$this->Existe_Registro($MsgErro))
			if ($MsgErro <> null)
				return FALSE;
		
		if ($this->DT_Ini_Escala <> '' && $this->DT_Ini_Escala <> '00/00/0000')
			$this->DT_Ini_Escala = implode('-',  array_reverse(explode('/',$this->DT_Ini_Escala)));
		if ($this->DT_Fim_Escala <> '' && $this->DT_Fim_Escala <> '00/00/0000')
			$this->DT_Fim_Escala = implode('-',  array_reverse(explode('/',$this->DT_Fim_Escala)));
		
		$query = 'UPDATE escala set DT_Fim_Escala          = ' . '"' . $this->DT_Fim_Escala . '", ' . 
		                            ' Intervalo            = ' .        $this->Intervalo . ' , ' .
		                            ' Duracao               = ' .       $this->Duracao . ' , ' .
		                            ' HR_Ini_Turno1         = ' . '"' . $this->HR_Ini_Turno1 . '", ' .
		                            ' HR_Fim_Turno1         = ' . '"' . $this->HR_Fim_Turno1 . '", ' .
		                            ' HR_Ini_Turno2         = ' . '"' . $this->HR_Ini_Turno2 . '" , ' .
		                            ' HR_Fim_Turno2         = ' . '"' . $this->HR_Fim_Turno2 . '"' .
				             	 'where SQ_Profissional   =  ' . $this->SQ_Profissional . 
				                 ' and DT_Ini_Escala = "' . $this->DT_Ini_Escala . '"' .
		                         ' and Dia_Semana    = '  . $this->Dia_Semana; ;
		
		//echo $query . mysql_affected_rows() . mysql_error() . gettype($result);
		$result = mysql_query($query);
				
		if (!$result || mysql_affected_rows() == 0){
			$MsgErro = 'Escala não alterada: ' . mysql_error();
			return FALSE;
		}
		return TRUE;
	}		
}
?>