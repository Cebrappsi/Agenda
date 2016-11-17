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
		label.labelConfirma{
			float:left;
			width:30%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="EscalaDelete.php">
    	<fieldset>
    		<legend>Excluindo Escala</legend>
    		<label class="labelConfirma">Confirma exclusão de Escala? (S/N) :</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="'.$_REQUEST[Confirma]. '">';
    		echo '<input type="hidden" name="SQ_Contato" size="10" value="' . $_REQUEST[SQ_Contato] . '">';
    		echo '<input type="hidden" name="DT_Ini_Escala" size="10" value="' . $_REQUEST[DT_Ini_Escala] . '">';
    		echo '<input type="hidden" name="Dia_Semana" size="10" value="' . $_REQUEST[Dia_Semana] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="Escala.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
    
    <?php 
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (SQ_Contato => (string)$_REQUEST[SQ_Contato] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == "")
        die();
    	
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 die();
    }
    
    if (strtoupper($_REQUEST[Confirma]) == 'N'){
    	header("Location: Escala.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Contato];
    //return;
    
    require "EscalaClasse.php";
    require "comum.php";
    $ObjEscala = new Escala();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjEscala->SQ_Contato = $_REQUEST[SQ_Contato];
    $ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
    $ObjEscala->Dia_Semana = $_REQUEST[Dia_Semana];
    if (!$ObjEscala->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjContato->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão da Escala : ' . $ObjEscala->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjContato->MsgErro);
       echo '<br><a class="MsgSucesso">Escala excluida com sucesso!</a>';
      //header("Location: Escala.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>