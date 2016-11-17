  <?php 
        //session_start();
        //prepara consulta para montar a lista de Profissionais
 	require "comum.php";
 	require "EscalaClasse.php";
	    		
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
	    		
    if (!$SetProfissionais = mysql_query(
   		'Select distinct Profissional.SQ_Profissional, Contato.NM_Contato from Profissional ' .
    		              'inner join Contato ' . 
    		              'on Profissional.SQ_Profissional = Contato.SQ_Contato ' . 
	    		          'Order by NM_Contato')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Profissionais: ' . mysql_error() .'<br></a>';
    	die();
    }
	    //echo mysql_num_rows($SetTipoRelacao);
    
    $ObjEscala = new Escala();
    $REQ_SQ_Profissional = $_REQUEST[SQ_Profissional];
    
    if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Profissional)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	$ObjEscala->SQ_Profissional = $REQ_SQ_Profissional;
    	$ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
    	$ObjEscala->Dia_Semana = $_REQUEST[Dia_Semana];
    	if (!$ObjEscala->GetReg($MsgErro)) {
    		echo '<a class="MsgErro">' . 'Erro na busca da Escala : ' . $MsgErro .'</a>';
    		die();
    	}
    	if (!$SetContato = mysql_query('Select NM_Contato from Contato ' .
    			'Where SQ_Contato = ' . $REQ_SQ_Profissional)){
    			echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
    			die();
    	}
    	$_REQUEST[DT_Fim_Escala] = implode('/',array_reverse(explode('-',mysql_result($ObjEscala->Regs,0,Dt_Fim_Escala))));
    	$_REQUEST[Intervalo_Atendimento] = mysql_result($ObjEscala->Regs,0,Intervalo_Atendimento);
    	$_REQUEST[HR_Ini_Turno1] = date('H:i',strtotime(mysql_result($ObjEscala->Regs,0,HR_Ini_Turno1)));
    	$_REQUEST[HR_Fim_Turno1] = date('H:i',strtotime(mysql_result($ObjEscala->Regs,0,HR_Fim_Turno1)));
    	$_REQUEST[HR_Ini_Turno2] = date('H:i',strtotime(mysql_result($ObjEscala->Regs,0,HR_Ini_Turno2)));
    	$_REQUEST[HR_Fim_Turno2] = date('H:i',strtotime(mysql_result($ObjEscala->Regs,0,HR_Fim_Turno2)));
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
    	$ObjEscala->SQ_Profissional = $REQ_SQ_Profissional;
    	$ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
    	$ObjEscala->DT_Fim_Escala = $_REQUEST[Dt_Fim_Escala];
    	$ObjEscala->Intervalo_Atendimento = $_REQUEST[Intervalo_Atendimento];
    	$ObjEscala->Dia_Semana    = $_REQUEST[Dia_Semana];
    	$ObjEscala->HR_Ini_Turno1 = $_REQUEST[HR_Ini_Turno1];
    	$ObjEscala->HR_Fim_Turno1 = $_REQUEST[HR_Fim_Turno1];
    	$ObjEscala->HR_Ini_Turno2 = $_REQUEST[HR_Ini_Turno2];
    	$ObjEscala->HR_Fim_Turno2 = $_REQUEST[HR_Fim_Turno2];
    	print_r($ObjEscala); 
    	if (!$ObjEscala->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção da Escala: ' . $MsgErro .'<br></a>';
    	else {
    		echo '<a class="MsgSucesso">Escala Incluido com sucesso!</a>';
    		//$_SESSION[SQ_Contato] = $ObjContato->SQ_Contato;
    		//print_r('<BR>SESSAO GUARDADA' . $_SESSION[SQ_Contato]);
    	}
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
        $ObjEscala->SQ_Profissional = $REQ_SQ_Profissional;
		$ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
		$ObjEscala->DT_Fim_Escala = $_REQUEST[DT_Fim_Escala];
		$ObjEscala->Intervalo_Atendimento = $_REQUEST[Intervalo_Atendimento];
		$ObjEscala->Dia_Semana    = $_REQUEST[Dia_Semana];
		$ObjEscala->HR_Ini_Turno1 = $_REQUEST[HR_Ini_Turno1];
	    $ObjEscala->HR_Fim_Turno1 = $_REQUEST[HR_Fim_Turno1];
		$ObjEscala->HR_Ini_Turno2 = $_REQUEST[HR_Ini_Turno2];
	    $ObjEscala->HR_Fim_Turno2 = $_REQUEST[HR_Fim_Turno2];
	        
	    if (!$ObjEscala->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração Escala: ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Alteração Escala com sucesso!</a>';
	    }
    }
            
    mysql_close($con);
    
 ?>
<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
         label.labelNormal{
			float:left;
			width:20%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
		
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="">
    	<fieldset>
			<legend> <?php if (!$REQ_SQ_Profissional) echo "Inserindo "; else echo "Alterando ";?> Escala de Trabalho</legend>
    		<label class="labelNormal">Profissional: </label>
    		<select name="SQ_Profissional">
    		 <?php
    		 	while ($RegProfissional = mysql_fetch_array($SetProfissionais))
					if ($RegProfissional[SQ_Profissional] == $_REQUEST[SQ_Profissional])
						echo '<option selected value=' . $RegProfissional[SQ_Profissional] . '>' . $RegProfissional[NM_Contato] . '</option>';
    				else
						echo '<option value=' . $RegProfissional[SQ_Profissional] . '>' . $RegProfissional[NM_Contato] . '</option>';
    		?>
    		</select>
    		<br>
    		<label class="labelNormal">Dt Inicio Escala:</label>
    		<input class="Entrada" type="date" name="DT_Ini_Escala" size="10" value="<?php echo $_REQUEST[DT_Ini_Escala]?>"><br>
    		<label class="labelNormal">Dt Fim Escala:</label>
    		<input class="Entrada" type="date" name="DT_Fim_Escala" size="10" value="<?php echo $_REQUEST[DT_Fim_Escala]?>"><br>
    		<label class="labelNormal">Dia Semana(1-7 Dom-Sab):</label>
    		<input class="Entrada" type="number" name="Dia_Semana" size="1" min="1" max="7" value =<?php echo $_REQUEST[Dia_Semana]?>><br>
     		<label class="labelNormal">Interv Atend(5,10,15,20): </label>
    		<input class="Entrada" type="number" name="Intervalo_Atendimento" min="0" max="15" step="5" size="2" value =<?php echo $_REQUEST[Intervalo_Atendimento]?>><br>
     		<label class="labelNormal">Hora Ini Turno1:</label>
     		<input class="Entrada" type="time" name="HR_Ini_Turno1" size="5" value="<?php echo $_REQUEST[HR_Ini_Turno1]?>"><br>
     		<label class="labelNormal">Hora Fim Turno1:</label>
     		<input class="Entrada" type="time" name="HR_Fim_Turno1" size="5" value="<?php echo $_REQUEST[HR_Fim_Turno1]?>"><br>
     		<label class="labelNormal">Hora Ini Turno2:</label>
     		<input class="Entrada" type="time" name="HR_Ini_Turno2" size="5" value="<?php echo $_REQUEST[HR_Ini_Turno2]?>"><br>
     		<label class="labelNormal">Hora Fim Turno2:</label>
     		<input class="Entrada" type="time" name="HR_Fim_Turno2" size="5" value="<?php echo $_REQUEST[HR_Fim_Turno2]?>"><br>
    		<a class="linkVoltar" href="EscalaLista.php">Voltar</a>
    	    <input class="Envia" type="submit"  name="Operacao"  value= <?php if (!$REQ_SQ_Profissional) echo "Inserir"; else echo "Alterar";?> >
    	</fieldset>
    </form>	
    </BODY>
</HTML>
