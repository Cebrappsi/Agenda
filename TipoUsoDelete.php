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
    <form method="post" action="tipoUsoDelete.php">
    	<fieldset>
    		<legend>Excluindo Tipo de Uso do Telefone</legend>
    		<label class="Labelconfirma">Confirma Exclusão de Tipo de Uso? (S/N) :</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="'.$_REQUEST[Confirma]. '">';
    		echo '<input type="hidden" name="TP_Uso" size="10" value="' . $_REQUEST[TP_Uso] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="tipoUso.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
    
    <?php
    /*
    session_start();
    print_r($_SESSION);
    print_r('xxxxx');
    print_r($_REQUEST);
    
    if ($_SESSION["TP_Uso"] == null)
    	$_SESSION["TP_Uso"] = $_POST[TP_Uso];
    	
    if ($_REQUEST[TP_Uso] <> NULL)
    	$_REQUEST[TP_Uso] = $_SESSION[TP_Uso];
    */
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (TP_Uso => (string)$_REQUEST[TP_Uso] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == "")
        die();
    	
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/tipo_UsoDelete.php' );
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
    	header("Location: tipoUso.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[TP_Uso];
    //return;
    
    require "tipoUsoClasse.php";
    require "comum.php";
    $Objtipo_Uso = new tipo_Uso();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $Objtipo_Uso->TP_Uso = $_REQUEST[TP_Uso];
    if (!$Objtipo_Uso->Delete($MsgErro))
       //MsgPopup('Erro na Exclusão do Registro : ' . $Objtipo_Uso->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $Objtipo_Uso->MsgErro .'</a>';
    else 
      // MsgPopup( $Objtipo_Uso->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: tipo_Uso.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>