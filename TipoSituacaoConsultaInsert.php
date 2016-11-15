<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
        label.labelNormal{
			float:left;
			width:20%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="TipoSituacaoConsultaInsert.php">
    	<fieldset>
    		<legend>Inserindo Situacao da Consulta</legend>
    		<label class="labelNormal">Tipo Situacao da Consulta:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Situacao_Consulta" size="1" value = ' .
    		     $_POST[TP_Situacao_Consulta] . '><br><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Situacao Consulta:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Situacao_Consulta" size="30" value="' .
    		     $_POST[NM_Situacao_Consulta] . '"><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="TipoSituacaoConsulta.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Situacao_Consulta]) && !isset($_REQUEST[NM_Situacao_Consulta]))
        die();
    
    require "comum.php";
    require "TipoSituacaoConsultaClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjTipo_Situacao_Consulta->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjTipo_Situacao_Consulta = new Tipo_Situacao_Consulta();
    $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = strtoupper($_REQUEST[TP_Situacao_Consulta]);
    $ObjTipo_Situacao_Consulta->NM_Situacao_Consulta = $_REQUEST[NM_Situacao_Consulta];
    if (!$ObjTipo_Situacao_Consulta->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjTipo_Situacao_Consulta->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
