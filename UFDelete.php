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
    <form method="post" action="UFDelete.php">
    	<fieldset>
    		<legend>Excluindo Unidade da Federação</legend><br>
    		<label class="Labelconfirma">Confirma Exclusão de Unidade da Federação - <?php echo $_REQUEST[CD_UF] ?> ? </label><br><br>
    	    <input type="hidden" name="CD_UF" size="10" value="<?php echo $_REQUEST[CD_UF] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="UFLista.php">Voltar</a>
    	<input class="Envia" type="submit"  name="Operacao" value="Excluir">
    </form>
    
    <?php
    if ($_REQUEST[Operacao] == "Excluir"){
    	require "UFClasse.php";
    	require "comum.php";
    	$ObjUF = new UF();
    
    	if (!$con = conecta_BD($MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
    	}
        
    	$ObjUF->CD_UF = $_REQUEST[CD_UF];
    	if (!$ObjUF->Delete($MsgErro))
              echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
    	else 
            echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: UFLista.php");
    	mysql_close($con);
    }
    ?>
  </BODY>
</HTML>