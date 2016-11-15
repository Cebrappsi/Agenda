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
        </style>
  </HEAD>
  <BODY>
    <?php
    //print_r($_REQUEST); //debug var recebidas
    
    require "comum.php";
    require "EspecialidadeClasse.php";
    $ObjEspecialidade = new Especialidade();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjEspecialidade->SQ_Especialidade = $_REQUEST[SQ_Especialidade];
    
    //Acesso o registro para preencher os campos
    if (!$ObjEspecialidade->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
   // echo 'achei registro...' .  mysql_result($ObjEspecialidade->Regs,0,SQ_Especialidade) . '...' . $ObjEspecialidade->MsgErro ;
   // echo 'NM_Especialidade: ' . mysql_result($ObjEspecialidade->Regs,0,NM_Especialidade);
	//Lista de convenios
	if (!$ListaConvs = mysql_query('SELECT plano.*, convenio.* 
			    							  from Plano 
			    		                      inner join convenio 
			    							  on plano.SQ_Convenio = convenio.SQ_Convenio 
			    							  order by NM_Convenio, NM_Plano')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Convenio: ' . mysql_error() .'<br></a>';
		die();
	}

    ?>
	<form method="post" action="EspecialidadeEdit.php">
    	<fieldset>
    	   <legend>Alteração de Especialidade</legend>
    	   <label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input type="hidden" name="SQ_Especialidade" value=' . mysql_result($ObjEspecialidade->Regs,0,SQ_Especialidade). '>';
    		
    		echo '<input class="Entrada" type="text" name="NM_Especialidade" size="30" value=' . '"' . mysql_result($ObjEspecialidade->Regs,0,NM_Especialidade) . '"><br><br>';
    		echo '<label class="labelNormal">Convênio: </label>';
    		echo '<select class="Entrada" name="ConvPlan">';
		    	while ($dados = mysql_fetch_array($ListaConvs)) 
		    		if (mysql_result($ObjEspecialidade->Regs,0,SQ_Convenio) == $dados[SQ_Convenio] && mysql_result($ObjEspecialidade->Regs,0,SQ_Plano) ==  $dados[SQ_Plano])
		    			echo '<option value="' , ($dados[SQ_Convenio] * 1000000 + $dados[SQ_Plano]) . '"  selected>' . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '</option>';
		    		else
		    			echo '<option value="' , ($dados[SQ_Convenio] * 1000000 + $dados[SQ_Plano]) . '">' . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '</option>';
	    	echo '</select><br><br>';
	    	echo '<label class="labelNormal">Qtd. Consultas por Semana: </label>';
	    	echo '<input class="Entrada" type="text" name="NR_Consultas_Semana" size="3" value=' . '"' . mysql_result($ObjEspecialidade->Regs,0,NR_Consultas_Semana) . '"><br><br>';
    		echo '<label class="labelNormal">Data Ativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=' . mysql_result($ObjEspecialidade->Regs,0,DT_Ativacao) . '><br><br>';
    		echo '<label class="labelNormal">Data Desativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=' . mysql_result($ObjEspecialidade->Regs,0,DT_Desativacao) . '><br><br>';
    	    ?>
    	</fieldset>
    	<a class="linkVoltar" href="Especialidade.php">Voltar</a>
    	<input class="Envia" type="submit" name="submit" value="Alterar">
    </form>
    <br>
    <?php 
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjEspecialidade->Regs);

    if(empty($_POST['submit']))
        //Primeira apresentacao da tela
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder alteração
    //echo ('Alterando');
    
    $ObjEspecialidade->SQ_Especialidade = $_REQUEST[SQ_Especialidade];
    $ObjEspecialidade->SQ_Plano = $_REQUEST[SQ_Plano];
    $ObjEspecialidade->SQ_Convenio = $_REQUEST[SQ_Convenio];
    $ObjEspecialidade->NM_Especialidade = $_REQUEST[NM_Especialidade];
    $ObjEspecialidade->NR_Consultas_Semana = $_REQUEST[NR_Consultas_Semana];
    $ObjEspecialidade->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjEspecialidade->DT_Desativacao = $_REQUEST[DT_Desativacao];
    //print_r($ObjEspecialidade);
    if (!$ObjEspecialidade->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjEspecialidade->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Especialidade.php
    
    mysql_close($con);
    //echo 'SQ_Especialidade = ' . mysql_result($ObjEspecialidade->Regs,0,SQ_Especialidade);
    ?>
  </BODY>
</HTML>
