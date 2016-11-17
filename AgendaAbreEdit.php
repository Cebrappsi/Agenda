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
			width:15%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
   		label.MostraDados{
			float:left;
			width:30%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:left;
		 }
        </style>
  </HEAD>
  <BODY>
    <?php
    print_r($_REQUEST); //debu var recebidas
    
    require "comum.php";
    require "EscalaClasse.php";
    $ObjEscala = new Escala();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
	//Acesso o registro para preencher os campos
	$ObjEscala->SQ_Contato = $_REQUEST[SQ_Contato];
	$ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
	$ObjEscala->Dia_Semana = $_REQUEST[Dia_Semana];
    if (!$ObjEscala->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na busca da Escala : ' . $MsgErro .'</a>';
	   die();
	}
	if (!$SetContato = mysql_query('Select NM_Contato from Contato ' .
		                        	'Where SQ_Contato = ' . $_REQUEST[SQ_Contato])){
			echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
			die();
	}
	
    //echo 'achei registro...' .  mysql_num_rows($SetRelacoes);
    //echo 'SQ_Escala1: ' . mysql_result($ObjEscala->Regs,0,NM_Escala);
    echo '<form method="post" action="EscalaEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Escala</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . mysql_result($ObjEscala->Regs,0,SQ_Contato) . '>';
    	   echo '<input type="hidden" name="DT_Ini_Escala" value=' . mysql_result($ObjEscala->Regs,0,DT_Ini_Escala) . '>';
    	   echo '<input type="hidden" name="Dia_Semana" value=' . mysql_result($ObjEscala->Regs,0,Dia_Semana) . '>';
    	   echo '<label class="labelNormal">Profissional: </label>';
    	   echo '<label class="MostraDados">' . mysql_result($SetContato,0,NM_Contato) . '</label>';
    	   echo '<br><br>';
    	   echo '<label class="labelNormal">Dt Inicio Escala:</label>';
    	   echo '<label class="MostraDados">' . mysql_result($ObjEscala->Regs,0,DT_Ini_Escala) . '</label>';
    	   echo '<br><br>';
    	   echo '<label class="labelNormal">Dia da Semana:</label>';
    	   echo '<label class="MostraDados">' . mysql_result($ObjEscala->Regs,0,Dia_Semana) . '</label>';
    	   echo '<br><br>';
    	   echo '<label class="labelNormal">Dt Fim Escala:</label>';
    	   echo '<input class="Entrada" type="date" name="DT_Fim_Escala" size="10" value=' .
    	   		mysql_result($ObjEscala->Regs,0,DT_Fim_Escala) . '>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Intervalo Atend: </label>';
    	   echo '<input class="Entrada" type="number" name="Intervalo_Atendimento" min="0" max="15" step="5" value = ' .
    	   		mysql_result($ObjEscala->Regs,0,Intervalo_Atendimento) . '>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Hora Ini Turno1:</label>';
    	   echo '<input class="Entrada" type="time" name="HR_Ini_Turno1" size="5" value=' .
    	   		substr(mysql_result($ObjEscala->Regs,0,HR_Ini_Turno1),0,5) . '>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Hora Fim Turno1:</label>';
    	   echo '<input class="Entrada" type="time" name="HR_Fim_Turno1" size="5" value=' .
    	   		substr(mysql_result($ObjEscala->Regs,0,HR_Fim_Turno1),0,5) . '>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Hora Ini Turno2:</label>';
    	   echo '<input class="Entrada" type="time" name="HR_Ini_Turno2" size="5" value=' .
    	   		substr(mysql_result($ObjEscala->Regs,0,HR_Ini_Turno2),0,5) . '>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Hora Fim Turno2:</label>';
    	   echo '<input class="Entrada" type="time" name="HR_Fim_Turno2" size="5" value=' .
    	   		substr(mysql_result($ObjEscala->Regs,0,HR_Fim_Turno2),0,5) . '>';
    	   echo '<br>';       	   
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="Escala.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjEscala->Regs);
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))
    	die();//// S� apresenta os dados
    
    //Houve alteração - proceder altera��o
    //echo ('Alterando');
    
    $ObjEscala->SQ_Contato    = $_REQUEST[SQ_Contato];
	$ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
	$ObjEscala->DT_Fim_Escala = $_REQUEST[Dt_Fim_Escala];
	$ObjEscala->Intervalo_Atendimento = $_REQUEST[Intervalo_Atendimento];
	$ObjEscala->Dia_Semana    = $_REQUEST[Dia_Semana];
	$ObjEscala->HR_Ini_Turno1 = $_REQUEST[HR_Ini_Turno1];
    $ObjEscala->HR_Fim_Turno1 = $_REQUEST[HR_Fim_Turno1];
	$ObjEscala->HR_Ini_Turno2 = $_REQUEST[HR_Ini_Turno2];
    $ObjEscala->HR_Fim_Turno2 = $_REQUEST[HR_Fim_Turno2];
        
    if (!$ObjEscala->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração Escala: ' . $ObjEscala->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração Escala com sucesso!</a>';
    }
    
    mysql_close($con);
    //echo 'SQ_Escala = ' . mysql_result($ObjEscala->Regs,0,SQ_Escala);
    ?>
  </BODY>
</HTML>
