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
  
    <form method="post" action="ConvenioDelete.php">
    	<fieldset>
    		<legend>Excluindo Convênio</legend><br>
    		<label class="label">Confirma exclusão do Convênio - <?php echo $_REQUEST[NM_Convenio] ?> ? </label><br><br>
    		<input type="hidden" name="SQ_Convenio" size="2" value= <?php echo $_REQUEST[SQ_Convenio] ?> >
    	</fieldset>
    	<a class="linkVoltar" href="ConvenioLista.php">Voltar</a>	
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  
    <?php
    //echo $_REQUEST[Operacao];
    if ($_REQUEST[Operacao] == "Excluir"){ 
    	require "ConvenioClasse.php";
    	require "comum.php";
    	$ObjConvenio = new Convenio();
    
    	if (!$con = conecta_BD($MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
    	}
    
    	$ObjConvenio->SQ_Convenio = $_REQUEST[SQ_Convenio];
    	if (!$ObjConvenio->Delete($MsgErro))
       		//MsgPopup('Erro na Exclus�o do Registro : ' . $MsgErro);
        	echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
    	else 
      		// MsgPopup( $MsgErro);
       		echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      	//header("Location: ConvenioLista.php?");
        mysql_close($con);
    }
    ?>
  </BODY>
</HTML>