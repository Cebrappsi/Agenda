<?php
class Valor {
  
	public $Regs;
	public $SQ_Valor;
	public $SQ_Especialidade;
	public $SQ_Plano;
	public $SQ_Convenio;
	public $VL_Consulta;
	public $DT_Ativacao;
	public $DT_Desativacao;

	public function GetReg($MsgErro){
		 
		//echo  "<br>Recuperando Valor ";
	
		//echo 'Sq_Valor:' . $this->SQ_Valor;
		$query = 'Select * FROM Valor WHERE SQ_Valor = ' . $this->SQ_Valor;
		                             
		//echo 'Query: ' . $query;
		$this->Regs = mysql_query($query);
		if (!$this->Regs){
			$this->MsgErro = 'Erro no Banco de Dados: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
	
		//echo 'Achei: ' . mysql_result($this->Regs,0,1);
		if (mysql_num_rows($this->Regs) == 0){
			$this->MsgErro = 'Registro de valor não encontrado';
			return FALSE;
		}
	
		return TRUE;
	}
		
	private function Valida_Dados($MsgErro){ 
	  //  echo  '<br/>Validando dados Valor: ' . 'Nome: ' . $this->Valor .
	  //            'Ativ:' . $this->DT_Ativacao .  'Desat:' . $this->DT_Desativacao;  
		if ($this->VL_Consulta == null){
			$this->MsgErro = 'Valor da Consulta inválido';
			return FALSE;
		}

		if ($this->SQ_Especialidade < 1){
			$this->MsgErro = 'Sequencial da Especialidade do Valor';
			return FALSE;
		}
		
		if ($this->SQ_Plano < 1){
			$this->MsgErro = 'Sequencial do Plano inválido';
			return FALSE;
		}
		
		if ($this->SQ_Convenio < 1){
			$this->MsgErro = 'Sequencial da Convênio inválido';
			return FALSE;
		}
		
		if ($this->VL_Consulta < 0){
			$this->MsgErro = 'Valor da consulta inválido';
			return FALSE;
		}
		if ($this->DT_Ativacao == '' || !checkdate(date('m',$this->DT_Ativacao), date('d',$this->DT_Ativacao), date('Y',$this->DT_Ativacao))){
		   $this->MsgErro = 'Data de Ativação do Valor inválida';
		   return FALSE;
		}
		
		if ($this->DT_Desativacao <> '')
			if (!checkdate(date('m',$this->DT_Desativacao), date('d',$this->DT_Desativacao), date('Y',$this->DT_Desativacao))){
				$this->MsgErro = 'Data de Desativação do Valor inválida';
				return FALSE;
			}
			elseif ($this->DT_Desativacao <= $this->DT_Ativacao){
				$this->MsgErro = 'Data de Desativação deve ser maior que ativação';
				return FALSE;
			}	
		
		return TRUE;
	}

	/* Retorna Falso se deu erro no Banco ou há alguma consistencia cruzada violada
	 * Retorna True se existe
	* Testar se deu erro de banco em MsgErro quando receber Falso
	*/
	private function Valida_Cruzada($MsgErro){
		//Validando Consistencia contra a tabela pai(Especialidade)
		//echo  "<br/>/Validando Consistencia contra a tabela pai(Especialiade)";
		$query = 'Select * FROM Especialidade
		WHERE SQ_Especialidade = ' . $this->SQ_Especialidade;
		$resultEspecialidade = mysql_query($query);
		if (!$resultEspecialidade){
			$this->MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($resultConvenio,0,0);
		if (mysql_num_rows($resultEspecialidade) == 0){
			$this->MsgErro = 'Especialidade não localizada';
			return FALSE;
		}
	
		$dadosEspecialidade = mysql_fetch_array($resultEspecialidade);
		if ($dadosEspecialidade[DT_Desativacao] > 0){
			$this->MsgErro = 'Especialidade desativada';
			return FALSE;
		}
		echo $dadosEspecialidade[SQ_Convenio] . '.' . $dadosEspecialidade[NM_Convenio] . '.' . $dadosEspecialidade[DT_Ativacao] . '.' . $dadosEspecialidade[DT_Desativacao];
		echo '<br>';
		echo $this->SQ_Convenio . '.' . $this->NM_Especialidade . '.' . $this->DT_Ativacao . '.' . $this->DT_Desativacao;
		if ($this->DT_Ativacao < $dadosEspecialidade[DT_Ativacao]){
			$this->MsgErro = 'Data ativacao do Valor não pode ser menor que ativaçao da Especialidade';
			return FALSE;
		}
		if ($dadosEspecialidade[DT_Desativacao] <> '0000-00-00' && $this->DT_Desativacao > $dadosEspecialidade[DT_Desativacao]){
			$this->MsgErro = 'Data Desativacao do Valor não pode ser maior que desativaçao da Especialidade';
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
		$queryValor = 'Select SQ_Especialidade, SQ_Plano, SQ_Convenio, DT_Ativacao ' .
		              'FROM Valor ' . 
   		              'WHERE SQ_Convenio = ' . $this->SQ_Convenio . 
		               ' and SQ_Plano = ' . $this->SQ_Plano . 
		               ' and SQ_Especialidade = ' . $this->SQ_Especialidade .
		               ' and DT_Ativacao >= "' . $this->DT_Ativacao . '"';
		$resultValor = mysql_query($queryValor);
		if (!$resultValor){
			$this->MsgErro = 'Erro bd: ' . mysql_error() . '<br>Query: ' . $queryEspecialidade;
			return FALSE;
		}
		//echo 'Achei: ' .mysql_result($resultEspecialidade,0,0);
		if (mysql_num_rows($resultValor) == 0){
			$this->MsgErro = null;
			return FALSE;
		}
		return TRUE;
	}
	
	public function Insert($MsgErro){
		//echo  '<br/>Inserindo Especialidade ';
				
		//echo '<br>Validando Dados';
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia Tabela Local';
    	if ($this->Existe_Registro($MsgErro)){
			$this->MsgErro = 'Já existe Valor cadastrado para a data';
			return FALSE;
		}
		elseif ($this->MsgErro <> null)
			 	return FALSE;

		//echo '<br>Validação cruzada';
		if (!$this->Valida_Cruzada($MsgErro))
			return false;
		elseif ($this->MsgErro <> null)
		    return FALSE;
				
		//echo '<br>Inserindo Registro';
		
		$query = 'INSERT INTO Valor (SQ_Convenio,SQ_Plano,SQ_Especialidade,VL_Consulta,DT_Ativacao,DT_Desativacao)
								values ("' . $this->SQ_Convenio . '" , "'
										   . $this->SQ_Plano . '" , "'	
								           . $this->SQ_Especialidade . '" , "'
								           . $this->VL_Consulta . '" , "' 
								           . $this->DT_Ativacao . '" , "'  
								           . $this->DT_Desativacao . '")';
		//echo $query;
		$result = mysql_query($query);
        
		if (!($result && (mysql_affected_rows() > 0))) {
			$this->MsgErro = 'Não foi possivel incluir o registro: ' . mysql_error() . '<br>Query: ' . $query;
			return FALSE;
		}

		return TRUE;
	}
	
	public function Delete($MsgErro){
		   
		//echo  "<br>Excluindo Valor>";
						
		$query = 'DELETE FROM Valor '. 
		         'WHERE SQ_Valor = ' . $this->SQ_Valor;
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
	
	public function Edit($MsgErro){
	   
		//echo  "<br>Alterando Valor ";
				
		//echo '<br>Validando Dados';
		//print_r($this);
		if (!$this->Valida_Dados($MsgErro))
	        return FALSE;
		
		//echo '<br>Validando Consistencia Tabela Local';
		if (!$this->Existe_Registro($MsgErro))
			if ($this->MsgErro <> null)
     		  return FALSE;
					
		//echo '<br>Validação cruzada';
		if (!$this->Valida_Cruzada($MsgErro))
			return false;
		elseif ($this->MsgErro <> null)
			return FALSE;
		//die ('atuaizando');
		
		$query = 'UPDATE valor set  SQ_Convenio = ' . $this->SQ_Convenio . ' , ' .
								   'SQ_Plano = '  . $this->SQ_Plano            . ' , ' .
								   'SQ_Especialidade = '  . $this->SQ_Especialidade    . ' , ' .
								   'VL_Consulta = "'  . $this->VL_Consulta   . '" , ' .
								   'DT_Ativacao = "' . $this->DT_Ativacao . '" , ' .
								   'DT_Desativacao = "' . $this->DT_Desativacao . '"' .
				'where SQ_Valor = ' . $this->SQ_Valor; 
		
		$result = mysql_query($query);
	//	echo $query . mysql_affected_rows() . mysql_error() . gettype($result) . '<br>Query: ' . $query;
		
		if (!$result || mysql_affected_rows() == 0){
			$this->MsgErro = 'Registro não alterado: ' . mysql_error() . '<br>Query: ' . $query;
			echo $query . mysql_affected_rows() . mysql_error() . gettype($result) . '<br>Query: ' . $query;
			return FALSE;
		}
		return TRUE;
	}
}
?>