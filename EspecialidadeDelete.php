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
  
    <form method="post" action="EspecialidadeDelete.php">
    	<fieldset>
    		<legend>Excluindo Especialidade</legend>
    		<label class="labelConfirma">Confirma exclusão de Especialidade? (S/N) :</label>
    		<?php 
    		echo '<input type="hidden" name="SQ_Especialidade" size="2" value="' . $_REQUEST[SQ_Especialidade] . '">';
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="' . $_REQUEST[Confirma] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="Especialidade.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
  
  <?php 
/*
  //echo 'Antes--session:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    session_start();
    if ($_SESSION[SQ_Especialidade] < 1){
    	echo 'guardando' . $_REQUEST[SQ_Especialidade];
    	$_SESSION[SQ_Especialidade] = $_REQUEST[SQ_Especialidade];
    	echo 'guardado' . $_SESSION[SQ_Especialidade];
    }
    	
    if ($_REQUEST[SQ_Especialidade] < 1){
      		echo 'recuperando' . $_SESSION[SQ_Especialidade];
    	$_REQUEST[SQ_Especialidade] = $_SESSION[SQ_Especialidade];
    	echo 'recuperado' . $_REQUEST[SQ_Especialidade];
    }
    //echo 'Pos--session:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';   
*/
?>
    
    <?php
        //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    //echo 'Antes--Post:'; print_r($_POST); echo '.'; var_dump( $_POST); echo '<br>';
    /*$arrpost = Array (SQ_Especialidade => (string)$_REQUEST[SQ_Especialidade] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == ""){
    	//echo('Location: EspecialidadeDelete.php?SQ_Especialidade=' . $_REQUEST[SQ_Especialidade] . '&?Confirma=' . $_REQUEST[Confirma]);
        die();
    }
   // echo 'Depois if:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/EspecialidadeDelete.php' );
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
    	header("Location: Especialidade.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Especialidade];
    //return;
    
    require "EspecialidadeClasse.php";
    require "comum.php";
    $ObjEspecialidade = new Especialidade();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjEspecialidade->SQ_Especialidade = $_REQUEST[SQ_Especialidade];
    if (!$ObjEspecialidade->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjEspecialidade->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $ObjEspecialidade->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjEspecialidade->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Especialidade.php?");
    mysql_close($con);
    ?>
  </BODY>
</HTML>
