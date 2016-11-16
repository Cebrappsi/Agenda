<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
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
  
    <form method="post" action="ValorDelete.php">
    	<fieldset>
    		<legend>Excluindo Valor</legend>
    		<label class="labelConfirma">Confirma exclusão de Valor? (S/N) :</label>
    		<?php 
    		echo '<input type="hidden" name="SQ_Valor" size="2" value="' . $_REQUEST[SQ_Valor] . '">';
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="' . $_REQUEST[Confirma] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="Valor.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
  
    <?php
        //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    //echo 'Antes--Post:'; print_r($_POST); echo '.'; var_dump( $_POST); echo '<br>';
    /*$arrpost = Array (SQ_Valor => (string)$_REQUEST[SQ_Valor] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == ""){
    	//echo('Location: ValorDelete.php?SQ_Valor=' . $_REQUEST[SQ_Valor] . '&?Confirma=' . $_REQUEST[Confirma]);
        die();
    }
   // echo 'Depois if:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
    	 die();
    }
    
    if (strtoupper($_REQUEST[Confirma]) == 'N'){
    	header("Location: Valor.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Valor];
    //return;
    
    require "ValorClasse.php";
    require "comum.php";
    $ObjValor = new Valor();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjValor->SQ_Valor = $_REQUEST[SQ_Valor];
    if (!$ObjValor->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjValor->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $ObjValor->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjValor->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Valor.php?");
    mysql_close($con);
    ?>
  </BODY>
</HTML>
