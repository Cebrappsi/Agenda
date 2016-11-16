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
    require "SalaClasse.php";
    $ObjSala = new Sala();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjSala->SQ_Sala = $_REQUEST[SQ_Sala];
    
    //Acesso o registro para preencher os campos
    if (!$ObjSala->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
   // echo 'achei registro...' .  mysql_result($ObjSala->Regs,0,SQ_Sala) . '...' . $ObjSala->MsgErro ;
   // echo 'NM_Sala: ' . mysql_result($ObjSala->Regs,0,NM_Sala);
    ?>
	<form method="post" action="SalaEdit.php">
    	<fieldset>
    	   <legend>Alteração de Sala</legend>
    	   <input type="hidden" name="SQ_Sala" value= 
    	   		  <?php echo mysql_result($ObjSala->Regs,0,SQ_Sala) ?> >
    	   <label class="labelNormal">Nome:</label>
    	   <input class="Entrada" type="text" name="NM_Sala" size="30" autofocus value=
    	   		  <?php echo '"'. mysql_result($ObjSala->Regs,0,NM_Sala) . '"' ?>  ><br><br>
    	   	<label class="labelNormal">Data Ativação:</label>
   	       	<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=
    	    	  <?php echo mysql_result($ObjSala->Regs,0,DT_Ativacao) ?> ><br><br>
    	    <label class="labelNormal">Data Desativação:</label>
    	    <input class="Entrada" type="date" name="DT_Desativacao" size="10" value=
    	    	   <?php echo mysql_result($ObjSala->Regs,0,DT_Desativacao) ?> ><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="Sala.php">Voltar</a>
    	<input class="Envia" type="submit" name="submit" value="Alterar">
    </form>
    <br>
    <?php 
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjSala->Regs);

    if(empty($_POST['submit']))
        //Primeira apresentacao da tela
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder alteração
    //echo ('Alterando');
    
    $ObjSala->SQ_Sala = $_REQUEST[SQ_Sala];
    $ObjSala->NM_Sala = $_REQUEST[NM_Sala];
    $ObjSala->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjSala->DT_Desativacao = $_REQUEST[DT_Desativacao];
    
    if (!$ObjSala->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjSala->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Sala.php
    
    mysql_close($con);
    //echo 'SQ_Sala = ' . mysql_result($ObjSala->Regs,0,SQ_Sala);
    ?>
  </BODY>
</HTML>
