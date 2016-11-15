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
    <form method="post" action="tipoUsoInsert.php">
    	<fieldset>
    		<legend>Inserindo Tipo de Uso do Telefone</legend>
    		<label class="labelNormal">Tipo Uso:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Uso" size="2" value = ' .
    		     $_POST[TP_Uso] . '><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Uso:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Tipo_Uso" size="30" value="' .
    		     $_POST[NM_Tipo_Uso] . '"><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="tipoUso.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Uso]) && !isset($_REQUEST[NM_Tipo_Uso]))
        die();
    
    require "comum.php";
    require "tipoUsoClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $Objtipo_Uso->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $Objtipo_Uso = new tipo_Uso();
    $Objtipo_Uso->TP_Uso = $_REQUEST[TP_Uso];
    $Objtipo_Uso->NM_Tipo_Uso = $_REQUEST[NM_Tipo_Uso];
    if (!$Objtipo_Uso->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $Objtipo_Uso->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
