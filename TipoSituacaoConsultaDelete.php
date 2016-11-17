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
    <form method="post" action="TipoSituacaoConsultaDelete.php">
    	<fieldset>
    		<legend>Excluindo Tipo de Situacao Consulta</legend><br>
    		<label class="Labelconfirma">Confirma Exclusão de Tipo de Situacao Consulta - <?php echo $_REQUEST[NM_Tipo_Situacao_Consulta] ?> ?</label><br><br>
    		<input type="hidden" name="TP_Situacao_Consulta" size="10" value="<?php echo $_REQUEST[TP_Situacao_Consulta]?>">
       	</fieldset>
    	<a class="linkVoltar" href="TipoSituacaoConsultaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao" value="Excluir">
    </form>
  </BODY>
</HTML>    
<?php
	if ($_REQUEST[Operacao] == "Excluir"){
	    require "TipoSituacaoConsultaClasse.php";
	    require "comum.php";
	    $ObjTipo_Situacao_Consulta = new TipoSituacaoConsulta();
	    
	    if (!$con  = conecta_BD($MsgErro)){
		    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
	    }
	    
	    $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = strtoupper($_REQUEST[TP_Situacao_Consulta]);
	    if (!$ObjTipo_Situacao_Consulta->Delete($MsgErro))
	       //MsgPopup('Erro na Exclusão do Registro : ' . $MsgErro);
	        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
	    else 
	      // MsgPopup( $ObjTipo_Situacao_Consulta->MsgErro);
	       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
	      //header("Location: TipoSituacaoConsultaLista.php");
	    mysql_close($con);
	}
?>