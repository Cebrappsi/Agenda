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
    <form method="post" action="OperadoraInsert.php">
    	<fieldset>
    		<legend>Inserindo Operadora de Telefonia</legend>
    		<label class="labelNormal">Código: </label>
    		<?php
    		echo '<input class="Entrada" type="text" name="CD_Operadora" size="2" value = ' .
    		     $_POST[CD_Operadora] . '><br>';
    		?>
    		<label class="labelNormal">Nome:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Operadora" size="30" value=' .
    		     $_POST[NM_Operadora] . '><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="Operadora.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[CD_Operadora]) && !isset($_REQUEST[NM_Operadora]))
        die();
    
    require "comum.php";
    require "OperadoraClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjOperadora->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjOperadora = new Operadora();
    $ObjOperadora->CD_Operadora = $_REQUEST[CD_Operadora];
    $ObjOperadora->NM_Operadora = $_REQUEST[NM_Operadora];
    if (!$ObjOperadora->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjOperadora->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
