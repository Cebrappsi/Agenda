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
    <form method="post" action="UFDelete.php">
    	<fieldset>
    		<legend>Excluindo Unidade da Federação</legend>
    		<label class="Labelconfirma">Confirma Exclusão de Unidade da Federação? (S/N) :</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="'.$_REQUEST[Confirma]. '">';
    		echo '<input type="hidden" name="CD_UF" size="10" value="' . $_REQUEST[CD_UF] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="UF.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
    
    <?php
    session_start();
    if ($_SESSION["CD_UF"] == null)
    	$_SESSION["CD_UF"] = $_POST[CD_UF];
    	
    if ($_REQUEST[CD_UF] <> NULL)
    	$_REQUEST[CD_UF] = $_SESSION["CD_UF"];
    
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (CD_UF => (string)$_REQUEST[CD_UF] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == "")
        die();
    	
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/UFDelete.php' );
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
    	header("Location: UF.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[CD_UF];
    //return;
    
    require "UFClasse.php";
    require "comum.php";
    $ObjUF = new UF();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjUF->CD_UF = $_REQUEST[CD_UF];
    if (!$ObjUF->Delete($MsgErro))
       //MsgPopup('Erro na Exclusão do Registro : ' . $ObjUF->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $ObjUF->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjUF->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: UF.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>
