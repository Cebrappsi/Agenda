<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    		<legend>Excluindo Tipo de Email</legend><br>
    		<label class="Labelconfirma">Confirma Exclusão de Tipo de Email - <?php echo $_REQUEST[NM_Tipo_Email] ?> ?</label><br><br>
    		<input type="hidden" name="TP_Email" size="10" value="<?php echo $_REQUEST[TP_Email] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="tipoEmailLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao" value="Excluir">
    </form>
    
    <?php
    if ($_REQUEST[Operacao] == "Excluir"){
    	require "TipoEmailClasse.php";
    	require "comum.php";
    	$ObjTipo_Email = new TipoEmailClass();
    
    	if (!$con = conecta_BD($MsgErro)){
	   	 	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
    	}
    
    	$ObjTipo_Email->TP_Email = $_REQUEST[TP_Email];
    	if (!$ObjTipo_Email->Delete($MsgErro))
       		//MsgPopup('Erro na Exclusão do Registro : ' . $MsgErro);
        	echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
    	else 
      		// MsgPopup( $MsgErro);
       		echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: tipoEmailLista.php");
    	mysql_close($con);
    }
    ?>
  </BODY>
</HTML>