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
			width:10%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="tipoRelacaoInsert.php">
    	<fieldset>
    		<legend>Inserindo Tipo de Relacao</legend>
    		<label class="labelNormal">Tipo Relação:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Relacao" size="2" value = ' .
    		     $_POST[TP_Relacao] . '><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Relação:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Tipo_Relacao" size="30" value=' .
    		     $_POST[NM_Tipo_Relacao] . '><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="tipoRelacao.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Relacao]) && !isset($_REQUEST[NM_Tipo_Relacao]))
        die();
    
    require "comum.php";
    require "tipoRelacaoClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $Objtipo_Relacao->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $Objtipo_Relacao = new tipo_Relacao();
    $Objtipo_Relacao->TP_Relacao = $_REQUEST[TP_Relacao];
    $Objtipo_Relacao->NM_Tipo_Relacao = $_REQUEST[NM_Tipo_Relacao];
    if (!$Objtipo_Relacao->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inser��o: ' . $Objtipo_Relacao->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
