<?php    
    if ($_REQUEST[Operacao] == "Excluir"){ 
	    require "ContatoClasse.php";
	    require "comum.php";
	    $ObjContato = new Contato();
	    
	    $con = conecta_BD($MsgErro);
	    if (!$con){
		    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
	    }
	    
	    $ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
	    if (!$ObjContato->Delete($MsgErro))
	       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjContato->MsgErro);
	        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
	    else 
	      // MsgPopup( $ObjContato->MsgErro);
	       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
	      //header("Location: Contato.php");
	    mysql_close($con);
	 }
?>
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
    <form method="post" action="ContatoDelete.php">
    	<fieldset>
    		<legend>Excluindo Contato</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Contato - <?php echo $_REQUEST[NM_Contato] ?> ? </label><br><br>
    		<input type="hidden" name="SQ_Contato" size="10" value="<?php echo $_REQUEST[SQ_Contato]?>">
    	</fieldset>
    	<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
   </BODY>
</HTML>