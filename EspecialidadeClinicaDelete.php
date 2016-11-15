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
  
    <form method="post" action="EspecialidadeClinicaDelete.php">
    	<fieldset>
    		<legend>Excluindo Especialidades da Clinica</legend>
    		<label class="labelConfirma">Confirma exclusão de Especialidades da Clinica? (S/N) :</label>
    		<?php 
    		echo '<input type="hidden" name="SQ_Especialidade_Clinica" size="2" value="' . $_REQUEST[SQ_Especialidade_Clinica] . '">';
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="' . $_REQUEST[Confirma] . '">';
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="EspecialidadeClinica.php">Voltar</a>
    	<input class="Envia" type="submit" value="Excluir">
    </form>
  
    <?php
        //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    //echo 'Antes--Post:'; print_r($_POST); echo '.'; var_dump( $_POST); echo '<br>';
    /*$arrpost = Array (SQ_Especialidade_Clinica => (string)$_REQUEST[SQ_Especialidade_Clinica] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 

    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == ""){
    	//echo('Location: Especialidade_ClinicaDelete.php?SQ_Especialidade_Clinica=' . $_REQUEST[SQ_Especialidade_Clinica] . '&?Confirma=' . $_REQUEST[Confirma]);
        die();
    }
   // echo 'Depois if:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 /*$cURL = curl_init();
         curl_setopt( $cURL, CURLOPT_URL, 'http://localhost/clinica/Especialidade_ClinicaDelete.php' );
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
    	header("Location: EspecialidadeClinica.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Especialidade_Clinica];
    //return;
    
    require "EspecialidadeClinicaClasse.php";
    require "comum.php";
    $ObjEspecialidade_Clinica = new Especialidade_Clinica();
    
    $con = conecta_BD($MsgErro);
    if (!$con){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjEspecialidade_Clinica->SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
    if (!$ObjEspecialidade_Clinica->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjEspecialidade_Clinica->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $ObjEspecialidade_Clinica->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjEspecialidade_Clinica->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Especialidade_Clinica.php?");
    mysql_close($con);
    ?>
  </BODY>
</HTML>