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
    <form method="post" action="tipoEnderecoInsert.php">
    	<fieldset>
    		<legend>Inserindo Tipo de Endereço</legend>
    		<label class="labelNormal">Tipo Endereço:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Endereco" size="2" value = ' .
    		     $_POST[TP_Endereco] . '><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Endereco:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Tipo_Endereco" size="30" value=' .
    		     $_POST[NM_Tipo_Endereco] . '><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="tipoEndereco.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Endereco]) && !isset($_REQUEST[NM_Tipo_Endereco]))
        die();
    
    require "comum.php";
    require "tipoEnderecoClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $Objtipo_Endereco->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $Objtipo_Endereco = new tipo_Endereco();
    $Objtipo_Endereco->TP_Endereco = $_REQUEST[TP_Endereco];
    $Objtipo_Endereco->NM_Tipo_Endereco = $_REQUEST[NM_Tipo_Endereco];
    if (!$Objtipo_Endereco->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $Objtipo_Endereco->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
