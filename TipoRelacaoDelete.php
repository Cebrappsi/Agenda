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
    <form method="post" action="tipoRelacaoDelete.php">
    	<fieldset>
    		<legend>Excluindo Tipo de Relação</legend>
    		<label class="Labelconfirma">Confirma Exclusão de Tipo de Relação? (S/N) :</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="'.$_REQUEST[Confirma]. '">';
    		echo '<input type="hidden" name="TP_Relacao" size="10" value="' . $_REQUEST[TP_Relacao] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="tipoRelacao.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
    
    <?php
    /*
    session_start();
    print_r($_SESSION);
    print_r('xxxxx');
    print_r($_REQUEST);
    
    if ($_SESSION["TP_Relacao"] == null)
    	$_SESSION["TP_Relacao"] = $_POST[TP_Relacao];
    	
    if ($_REQUEST[TP_Relacao] <> NULL)
    	$_REQUEST[TP_Relacao] = $_SESSION[TP_Relacao];
    */
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (TP_Relacao => (string)$_REQUEST[TP_Relacao] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == "")
        die();
    	
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/tipo_RelacaoDelete.php' );
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
    	header("Location: tipoRelacao.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[TP_Relacao];
    //return;
    
    require "tipoRelacaoClasse.php";
    require "comum.php";
    $Objtipo_Relacao = new tipo_Relacao();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $Objtipo_Relacao->TP_Relacao = $_REQUEST[TP_Relacao];
    if (!$Objtipo_Relacao->Delete($MsgErro))
       //MsgPopup('Erro na Exclusão do Registro : ' . $Objtipo_Relacao->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclus�o do Registro : ' . $Objtipo_Relacao->MsgErro .'</a>';
    else 
      // MsgPopup( $Objtipo_Relacao->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: tipo_Relacao.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>
