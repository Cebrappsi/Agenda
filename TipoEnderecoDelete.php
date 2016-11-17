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
    <form method="post" action="tipoEnderecoDelete.php">
    	<fieldset>
    		<legend>Excluindo Tipo de Endereço</legend><br>
    		<label class="Labelconfirma">Confirma Exclusão de Tipo de Endereço - <?php echo $_REQUEST[NM_Tipo_Endereco] ?> ?</label><br><br>
    		<input type="hidden" name="TP_Endereco" size="10" value="<?php echo $_REQUEST[TP_Endereco] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="tipoEnderecoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao" value="Excluir">
    </form>
  </BODY>
</HTML>    

<?php
    if ($_REQUEST[Operacao] == "Excluir"){
	    require "tipoEnderecoClasse.php";
	    require "comum.php";
	    
	    $ObjTipo_Endereco = new TipoEnderecoClass();
	 
	    if (!$con = conecta_BD($MsgErro)){
		    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
	    }
	    
	    $ObjTipo_Endereco->TP_Endereco = $_REQUEST[TP_Endereco];
	    if (!$ObjTipo_Endereco->Delete($MsgErro))
	       //MsgPopup('Erro na Exclusão do Registro : ' . $MsgErro);
	        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
	    else 
	      // MsgPopup( $MsgErro);
	       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
	      //header("Location: TipoEnderecoLista.php");
	    mysql_close($con);
    }
?>