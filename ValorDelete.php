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
  
    <form method="post" action="ValorDelete.php">
    	<fieldset>
    		<legend>Excluindo Valor da Consulta</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Valor da Consulta - <?php echo $_REQUEST[VL_Consulta] ?> ? </label><br><br>
    		<input type="hidden" name="SQ_Valor" size="2" value="<?php echo $_REQUEST[SQ_Valor]?>">
    	</fieldset>
    	<a class="linkVoltar" href="ValorLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  
    <?php
	    if ($_REQUEST[Operacao] == "Excluir"){
		    require "ValorClasse.php";
		    require "comum.php";
		    $ObjValor = new Valor();
		    
		    if (!$con = conecta_BD($MsgErro)){
			    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
				die();
		    }
		    
		    $ObjValor->SQ_Valor = $_REQUEST[SQ_Valor];
		    if (!$ObjValor->Delete($MsgErro))
		       //MsgPopup('Erro na Exclus�o do Registro : ' . $MsgErro);
		        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
		    else 
		      // MsgPopup( $ObjValor->MsgErro);
		       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
		      //header("Location: Valor.php?");
		    mysql_close($con);
	    }
    ?>
  </BODY>
</HTML>
