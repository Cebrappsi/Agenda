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
    <form method="post" action="tipoEmailDelete.php">
    	<fieldset>
    		<legend>Excluindo Tipo de Email</legend>
    		<label class="Labelconfirma">Confirma Exclus�o de Tipo de Email? (S/N) :</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="'.$_REQUEST[Confirma]. '">';
    		echo '<input type="hidden" name="TP_Email" size="10" value="' . $_REQUEST[TP_Email] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="tipoEmail.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
    
    <?php
    /*
    session_start();
    print_r($_SESSION);
    print_r('xxxxx');
    print_r($_REQUEST);
    
    if ($_SESSION["TP_Email"] == null)
    	$_SESSION["TP_Email"] = $_POST[TP_Email];
    	
    if ($_REQUEST[TP_Email] <> NULL)
    	$_REQUEST[TP_Email] = $_SESSION[TP_Email];
    */
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (TP_Email => (string)$_REQUEST[TP_Email] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == "")
        die();
    	
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/tipo_EmailDelete.php' );
         curl_setopt( $cURL, CURLOPT_POST, true );
         curl_setopt( $cURL, CURLOPT_POSTFIELDS, $Arrpost);
         curl_setopt( $cURL, CURLOPT_RETURNTRANSFER, true );
         echo curl_exec( $cURL ); 
    	 echo curl_close($cUrl);
    	 */
/*
    	?>
    kkk	<script language="Javascript">
lk;lk   	alert('Um erro qualquer!');
    ,,	history.back();
..	</script>
*/
    	 die();
    }
    
    if (strtoupper($_REQUEST[Confirma]) == 'N'){
    	header("Location: tipoEmail.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[TP_Email];
    //return;
    
    require "tipoEmailClasse.php";
    require "comum.php";
    $Objtipo_Email = new tipo_Email();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $Objtipo_Email->TP_Email = $_REQUEST[TP_Email];
    if (!$Objtipo_Email->Delete($MsgErro))
       //MsgPopup('Erro na Exclusão do Registro : ' . $Objtipo_Email->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclus�o do Registro : ' . $Objtipo_Email->MsgErro .'</a>';
    else 
      // MsgPopup( $Objtipo_Email->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: tipo_Email.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>