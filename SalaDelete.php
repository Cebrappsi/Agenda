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
  
    <form method="post" action="SalaDelete.php">
    	<fieldset>
    		<legend>Excluindo Sala</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Sala - <?php echo $_REQUEST[NM_Sala] ?> ? </label><br><br>
    		<input type="hidden" name="SQ_Sala" size="2" value="<?php echo $_REQUEST[SQ_Sala]?>">
    	</fieldset>
    	<a class="linkVoltar" href="SalaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  <?php
  if ($_REQUEST[Operacao] == "Excluir"){
    require "SalaClasse.php";
    require "comum.php";
    $ObjSala = new Sala();
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    $ObjSala->SQ_Sala = $_REQUEST[SQ_Sala];
    if (!$ObjSala->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
    else 
      // MsgPopup( $ObjSala->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Sala.php?");
    mysql_close($con);
  }
    ?>
  </BODY>
</HTML>
