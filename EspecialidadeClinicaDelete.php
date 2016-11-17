<!DOCTYPE html>
<HTML>
  <HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
		label.labelConfirma{
			float:left;
			width:40%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="EspecialidadeClinicaDelete.php">
    	<fieldset>
    		<legend>Excluindo Especialidades da Clinica</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Especialidades da Clinica - <?php echo $_REQUEST[NM_Plano] ?> ? </label><br><br>
    		<input type="hidden" name="SQ_Especialidade_Clinica" size="2" value="<?php echo $_REQUEST[SQ_Especialidade_Clinica] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="EspecialidadeClinicaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  
    <?php
        //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    //echo 'Antes--Post:'; print_r($_POST); echo '.'; var_dump( $_POST); echo '<br>';
    /*$arrpost = Array (SQ_Especialidade_Clinica => (string)$_REQUEST[SQ_Especialidade_Clinica] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 

    require "EspecialidadeClinicaClasse.php";
    require "comum.php";
    $ObjEspecialidade_Clinica = new EspecialidadeClinica();
     
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    if ($_REQUEST[Operacao] == "Excluir"){
	    $ObjEspecialidade_Clinica->SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
	    if (!$ObjEspecialidade_Clinica->Delete($MsgErro))
	       //MsgPopup('Erro na Exclus�o do Registro : ' . $MsgErro);
	        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
	    else 
	      // MsgPopup( $ObjEspecialidade_Clinica->MsgErro);
	       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
	      //header("Location: EspecialidadeClinicaLista.php?");
    }
	mysql_close($con);
    ?>
  </BODY>
</HTML>