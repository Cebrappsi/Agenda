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
    <form method="post" action="tipoEmailInsert.php">
    	<fieldset>
    		<legend>Inserindo Tipo de Email</legend>
    		<label class="labelNormal">Tipo Email:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="TP_Email" size="2" value = ' .
    		     $_POST[TP_Email] . '><br>';
    		?>
    		<label class="labelNormal">Nome Tipo Email:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Tipo_Email" size="30" value=' .
    		     $_POST[NM_Tipo_Email] . '><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="tipoEmail.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[TP_Email]) && !isset($_REQUEST[NM_Tipo_Email]))
        die();
    
    require "comum.php";
    require "tipoEmailClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $Objtipo_Email->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $Objtipo_Email = new tipo_Email();
    $Objtipo_Email->TP_Email = $_REQUEST[TP_Email];
    $Objtipo_Email->NM_Tipo_Email = $_REQUEST[NM_Tipo_Email];
    if (!$Objtipo_Email->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $Objtipo_Email->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
