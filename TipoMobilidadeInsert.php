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
			width:15%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="tipoMobilidadeInsert.php">
    	<fieldset>
    		<legend>Inserindo Tipo de Mobilidade do Telefone</legend>
    		<label class="labelNormal">Tipo Mobilidade:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Mobilidade" size="2" value = ' .
    		     $_POST[TP_Mobilidade] . '><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Mobilidade:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Tipo_Mobilidade" size="30" value="' .
    		     $_POST[NM_Tipo_Mobilidade] . '"><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="tipoMobilidade.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Mobilidade]) && !isset($_REQUEST[NM_Tipo_Mobilidade]))
        die();
    
    require "comum.php";
    require "tipoMobilidadeClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $Objtipo_Mobilidade->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $Objtipo_Mobilidade = new tipo_Mobilidade();
    $Objtipo_Mobilidade->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    $Objtipo_Mobilidade->NM_Tipo_Mobilidade = $_REQUEST[NM_Tipo_Mobilidade];
    if (!$Objtipo_Mobilidade->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $Objtipo_Mobilidade->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
