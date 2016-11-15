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
    <form method="post" action="tipocontatoInsert.php">
    	<fieldset>
    		<legend>Inserindo Tipo de Contato</legend>
    		<label class="labelNormal">Tipo Contato:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Contato" size="2" value = ' .
    		     $_POST[TP_Contato] . '><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Contato:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Tipo_Contato" size="30" value=' .
    		     $_POST[NM_Tipo_Contato] . '><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="tipocontato.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Contato]) && !isset($_REQUEST[NM_Tipo_Contato]))
        die();
    
    require "comum.php";
    require "tipocontatoClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $Objtipo_contato->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $Objtipo_contato = new tipo_contato();
    $Objtipo_contato->TP_Contato = $_REQUEST[TP_Contato];
    $Objtipo_contato->NM_Tipo_Contato = $_REQUEST[NM_Tipo_Contato];
    if (!$Objtipo_contato->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $Objtipo_contato->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
