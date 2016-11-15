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
  
    <form method="post" action="PlanoDelete.php">
    	<fieldset>
    		<legend>Excluindo Plano</legend>
    		<label class="labelConfirma">Confirma exclusão de Plano? (S/N) :</label>
    		<?php 
    		echo '<input type="hidden" name="SQ_Plano" size="2" value="' . $_REQUEST[SQ_Plano] . '">';
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="' . $_REQUEST[Confirma] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="Plano.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
  
  <?php 
/*
  //echo 'Antes--session:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    session_start();
    if ($_SESSION[SQ_Plano] < 1){
    	echo 'guardando' . $_REQUEST[SQ_Plano];
    	$_SESSION[SQ_Plano] = $_REQUEST[SQ_Plano];
    	echo 'guardado' . $_SESSION[SQ_Plano];
    }
    	
    if ($_REQUEST[SQ_Plano] < 1){
      		echo 'recuperando' . $_SESSION[SQ_Plano];
    	$_REQUEST[SQ_Plano] = $_SESSION[SQ_Plano];
    	echo 'recuperado' . $_REQUEST[SQ_Plano];
    }
    //echo 'Pos--session:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';   
*/
?>
    
    <?php
        //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    //echo 'Antes--Post:'; print_r($_POST); echo '.'; var_dump( $_POST); echo '<br>';
    /*$arrpost = Array (SQ_Plano => (string)$_REQUEST[SQ_Plano] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == ""){
    	//echo('Location: PlanoDelete.php?SQ_Plano=' . $_REQUEST[SQ_Plano] . '&?Confirma=' . $_REQUEST[Confirma]);
        die();
    }
   // echo 'Depois if:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/PlanoDelete.php' );
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
    	header("Location: Plano.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Plano];
    //return;
    
    require "PlanoClasse.php";
    require "comum.php";
    $ObjPlano = new Plano();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjPlano->SQ_Plano = $_REQUEST[SQ_Plano];
    if (!$ObjPlano->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjPlano->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $ObjPlano->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjPlano->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Plano.php?");
    mysql_close($con);
    ?>
  </BODY>
</HTML>
