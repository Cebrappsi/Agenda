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
  
    <form method="post" action="SalaDelete.php">
    	<fieldset>
    		<legend>Excluindo Sala</legend>
    		<label class="labelConfirma">Confirma exclusão de Sala? (S/N) :</label>
    		<?php 
    		echo '<input type="hidden" name="SQ_Sala" size="2" value="' . $_REQUEST[SQ_Sala] . '">';
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" autofocus value="' . $_REQUEST[Confirma] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="Sala.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
  
  <?php 
/*
  //echo 'Antes--session:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    session_start();
    if ($_SESSION[SQ_Sala] < 1){
    	echo 'guardando' . $_REQUEST[SQ_Sala];
    	$_SESSION[SQ_Sala] = $_REQUEST[SQ_Sala];
    	echo 'guardado' . $_SESSION[SQ_Sala];
    }
    	
    if ($_REQUEST[SQ_Sala] < 1){
      		echo 'recuperando' . $_SESSION[SQ_Sala];
    	$_REQUEST[SQ_Sala] = $_SESSION[SQ_Sala];
    	echo 'recuperado' . $_REQUEST[SQ_Sala];
    }
    //echo 'Pos--session:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';   
*/
?>
    
    <?php
        //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    //echo 'Antes--Post:'; print_r($_POST); echo '.'; var_dump( $_POST); echo '<br>';
    /*$arrpost = Array (SQ_Sala => (string)$_REQUEST[SQ_Sala] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 

    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == ""){
    	//echo('Location: SalaDelete.php?SQ_Sala=' . $_REQUEST[SQ_Sala] . '&?Confirma=' . $_REQUEST[Confirma]);
        die();
    }
   // echo 'Depois if:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/SalaDelete.php' );
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
    	header("Location: Sala.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Sala];
    //return;
    
    require "SalaClasse.php";
    require "comum.php";
    $ObjSala = new Sala();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjSala->SQ_Sala = $_REQUEST[SQ_Sala];
    if (!$ObjSala->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjSala->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $ObjSala->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjSala->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Sala.php?");
    mysql_close($con);
    ?>
  </BODY>
</HTML>
