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
    require "PlanoClasse.php";
    $ObjPlano = new Plano();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjPlano->SQ_Plano = $_REQUEST[SQ_Plano];
    
    //Acesso o registro para preencher os campos
    if (!$ObjPlano->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
   // echo 'achei registro...' .  mysql_result($ObjPlano->Regs,0,SQ_Plano) . '...' . $ObjPlano->MsgErro ;
   // echo 'NM_Plano: ' . mysql_result($ObjPlano->Regs,0,NM_Plano);
	if (!$listaConv = mysql_query('SELECT * from Convenio order by NM_Convenio')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Convenio: ' . mysql_error() .'<br></a>';
		die();
	}
    ?>
	<form method="post" action="PlanoEdit.php">
    	<fieldset>
    	   <legend>Alteração de Plano</legend>
    	   <label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input type="hidden" name="SQ_Plano" value=' . mysql_result($ObjPlano->Regs,0,SQ_Plano). '>';
    		
    		echo '<input class="Entrada" type="text" name="NM_Plano" size="30" value=' . '"' . mysql_result($ObjPlano->Regs,0,NM_Plano) . '"><br><br>';
    		echo '<label class="labelNormal">Convênio: </label>';
    		echo '<select class="Entrada" name="SQ_Convenio">';
		    	while ($dadosConv = mysql_fetch_array($listaConv)) 
		    		if (mysql_result($ObjPlano->Regs,0,SQ_Convenio) ==  $dadosConv[SQ_Convenio])
		    			echo '<option value="' , $dadosConv[SQ_Convenio] . '"  selected>' . $dadosConv[NM_Convenio] . '</option>';
		    		else
		    			echo '<option value="' , $dadosConv[SQ_Convenio] . '">' . $dadosConv[NM_Convenio] . '</option>';
	    	echo '</select><br><br>';
    		echo '<label class="labelNormal">Data Ativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=' . mysql_result($ObjPlano->Regs,0,DT_Ativacao) . '><br><br>';
    		echo '<label class="labelNormal">Data Desativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=' . mysql_result($ObjPlano->Regs,0,DT_Desativacao) . '><br><br>';
    	    ?>
    	</fieldset>
    	<a class="linkVoltar" href="Plano.php">Voltar</a>
    	<input class="Envia" type="submit" name="submit" value="Alterar">
    </form>
    <br>
    <?php 
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjPlano->Regs);

    if(empty($_POST['submit']))
        //Primeira apresentacao da tela
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder alteração
    //echo ('Alterando');
    
    $ObjPlano->SQ_Plano = $_REQUEST[SQ_Plano];
    $ObjPlano->SQ_Convenio = $_REQUEST[SQ_Convenio];
    $ObjPlano->NM_Plano = $_REQUEST[NM_Plano];
    $ObjPlano->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjPlano->DT_Desativacao = $_REQUEST[DT_Desativacao];
    //print_r($ObjPlano);
    if (!$ObjPlano->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjPlano->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Plano.php
    
    mysql_close($con);
    //echo 'SQ_Plano = ' . mysql_result($ObjPlano->Regs,0,SQ_Plano);
    ?>
  </BODY>
</HTML>
