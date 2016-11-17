<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
         label.labelNormal{
			float:left;
			width:10%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
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
    <form method="post" action="OperadoraDelete.php">
    	<fieldset>
    		<legend>Excluindo Operadora de Telefonia</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Operadora de Telefonia - <?php echo $_REQUEST[NM_Operadora] ?> ? </label><br><br>
    		<input type="hidden" name="SQ_Operadora" size="10" value="<?php echo $_REQUEST[SQ_Operadora]?>">
    	</fieldset>
    	<a class="linkVoltar" href="OperadoraLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
    
    <?php  
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (SQ_Operadora => (string)$_REQUEST[SQ_Operadora] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if ($_REQUEST[Operacao] == "Excluir"){
    	require "OperadoraClasse.php";
    	require "comum.php";
    	$ObjOperadora = new Operadora();
    
    	if (!$con = conecta_BD($MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
    	}
    
    	$ObjOperadora->SQ_Operadora = $_REQUEST[SQ_Operadora];
    	if (!$ObjOperadora->Delete($MsgErro))
       		//MsgPopup('Erro na Exclus�o do Registro : ' . $sgErro);
        	echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
    	else 
      		// MsgPopup( $MsgErro);
       		echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      		//header("Location: OperadoraLista.php");
    	mysql_close($con);
    }
    ?>
  </BODY>
</HTML>