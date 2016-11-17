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
    <form method="post" action="tipoMobilidadeDelete.php">
    	<fieldset>
    		<legend>Excluindo Tipo de Mobilidade do Telefone</legend><br>
    		<label class="Labelconfirma">Confirma Exclusão de Tipo de Mobilidade - <?php echo $_REQUEST[NM_Tipo_Mobilidade] ?> ?</label><br><br>
    		<input type="hidden" name="TP_Mobilidade" size="10" value="<?php echo $_REQUEST[TP_Mobilidade] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="TipoMobilidadeLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao" value="Excluir">
    </form>
    
    <?php
	    if ($_REQUEST[Operacao] == "Excluir"){
		    require "TipoMobilidadeClasse.php";
		    require "comum.php";
		    $ObjTipo_Mobilidade = new TipoMobilidadeClass();
		    
		    if (!$con = conecta_BD($MsgErro)){
			    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
				die();
		    }
		    
		    $ObjTipo_Mobilidade->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
		    if (!$ObjTipo_Mobilidade->Delete($MsgErro))
		       //MsgPopup('Erro na Exclusão do Registro : ' . $MsgErro);
		        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
		    else 
		      // MsgPopup( $MsgErro);
		       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
		      //header("Location: TipoMobilidadeLista.php");
		    mysql_close($con);
	    }
	?>
  </BODY>
</HTML>