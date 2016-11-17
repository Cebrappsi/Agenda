<?php 
 	require "comum.php";
 	require "EspecialidadeClasse.php";
 	 
     if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
   	
    $ObjEspecialidade = new EspecialidadeClass();
    $REQ_SQ_Especialidade = $_REQUEST[SQ_Especialidade];
    
 	if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Especialidade)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela 
 		$ObjEspecialidade->SQ_Especialidade = $REQ_SQ_Especialidade;
 		if (!$ObjEspecialidade->GetReg($MsgErro))
 			echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
 		else {
 			// echo 'achei registro...' .  mysql_result($ObjEspecialidade->Regs,0,NM_Especialidade) . '...' . $MsgErro ;
 			// echo 'NM_Especialidade: ' . mysql_result($ObjPlano->Regs,0,NM_Especialidade);
 			// echo 'DT_Desat: ' . mysql_result($ObjPlano->Regs,0,DT_Desativacao);
 			$ConvPlan = mysql_result($ObjEspecialidade->Regs,0,SQ_Convenio) * 1000000 + mysql_result($ObjEspecialidade->Regs,0,SQ_Plano);
 			$_REQUEST[SQ_Convenio] =  mysql_result($ObjEspecialidade->Regs,0,SQ_Convenio);
 			$_REQUEST[SQ_Plano] =  mysql_result($ObjEspecialidade->Regs,0,SQ_Plano);
 			$_REQUEST[NM_Especialidade] =  mysql_result($ObjEspecialidade->Regs,0,NM_Especialidade);
 			$_REQUEST[NR_Consultas_Semana] = mysql_result($ObjEspecialidade->Regs,0,NR_Consultas_Semana);
 			$_REQUEST[DT_Ativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjEspecialidade->Regs,0,DT_Ativacao))));
 			$_REQUEST[DT_Desativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjEspecialidade->Regs,0,DT_Desativacao))));
 		}
 	}

 	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
 		$ObjEspecialidade->SQ_Convenio = floor($_REQUEST[ConvPlan] / 1000000);
 		$ObjEspecialidade->SQ_Plano = $_REQUEST[ConvPlan] % 1000000;
 		$ObjEspecialidade->NM_Especialidade = $_REQUEST[NM_Especialidade];
 		$ObjEspecialidade->NR_Consultas_Semana = $_REQUEST[NR_Consultas_Semana];
 		$ObjEspecialidade->DT_Ativacao = $_REQUEST[DT_Ativacao];
 		$ObjEspecialidade->DT_Desativacao = $_REQUEST[DT_Desativacao];
 		//print_r($ObjEspecialidade);
 		if (!$ObjEspecialidade->insert($MsgErro))
 			echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
 		else
 			echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
 	}
 	
 	if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
 		$ObjEspecialidade->SQ_Especialidade = $_REQUEST[SQ_Especialidade];
 		$ObjEspecialidade->SQ_Convenio = floor($_REQUEST[ConvPlan] / 1000000);
 		$ObjEspecialidade->SQ_Plano = $_REQUEST[ConvPlan] % 1000000;
 		$ObjEspecialidade->NM_Especialidade = $_REQUEST[NM_Especialidade];
 		$ObjEspecialidade->NR_Consultas_Semana = $_REQUEST[NR_Consultas_Semana];
 		$ObjEspecialidade->DT_Ativacao = $_REQUEST[DT_Ativacao];
 		$ObjEspecialidade->DT_Desativacao = $_REQUEST[DT_Desativacao];
 		//print_r($ObjEspecialidade);
 		if (!$ObjEspecialidade->Edit($MsgErro))
 			echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
 		else {
 			//mysql_query("commit");
 			echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
 		}
 	}
 	//prepaea consulta para montar a lista de convenios e planos
 	if (!$consultaPlano = mysql_query('SELECT plano.*, convenio.*
 			from Plano
 			inner join convenio
 			on plano.SQ_Convenio = convenio.SQ_Convenio
 			order by NM_Convenio, NM_Plano')){
 		echo '<a class="MsgErro">Não foi possível efetuar consulta Plano/convenio: ' . mysql_error() .'<br></a>';
 		die();
 	}
 	//echo mysql_num_rows($consultaPlano);
   
    mysql_close($con);
?>
		
<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
         label.labelNormal{
			float:left;
			width:10%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="">
    	<fieldset>
    		<legend> <?php if (!$REQ_SQ_Especialidade) echo "Inserindo "; else echo "Alterando ";?> Especialidade</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Especialidade" size="30" value="<?php echo $_REQUEST[NM_Especialidade]?>"><br><br>
    		<label class="labelNormal">Convênio: </label>
    		<select class="Entrada" name="ConvPlan">
    		   <?php 
		    		while ($dados = mysql_fetch_array($consultaPlano))
		    			if (mysql_result($ObjEspecialidade->Regs,0,SQ_Convenio) == $dados[SQ_Convenio] && mysql_result($ObjEspecialidade->Regs,0,SQ_Plano) ==  $dados[SQ_Plano])
		    				echo '<option value="' , ($dados[SQ_Convenio] * 1000000 + $dados[SQ_Plano]) . '"  selected>' . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '</option>';
		    			else
		    				echo '<option value="' , ($dados[SQ_Convenio] * 1000000 + $dados[SQ_Plano]) . '">' . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '</option>';
				    //while ($dados = mysql_fetch_array($consultaPlano))  //guardo o Convenio na posição acima de 1000000
		    	//	   echo '<option value="' . ($dados[SQ_Convenio] * 1000000 + $dados[SQ_Plano])  . '">' . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '</option>';
		       ?>
	    	</select><br><br>
	    	<label class="labelNormal">Qtd. Consultas por Semana: </label>
	    	<input class="Entrada" type="text" name="NR_Consultas_Semana" size="3" value="<?php echo $_REQUEST[NR_Consultas_Semana]?>"><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value="<?php echo $_REQUEST[DT_Ativacao]?>"><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value="<?php echo $_REQUEST[DT_Desativacao]?>"><br><br>
    	</fieldset>    
    	<a class="linkVoltar" href="EspecialidadeLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Especialidade) echo "Inserir"; else echo "Alterar";?> >
    </form>
  </BODY>
</HTML>