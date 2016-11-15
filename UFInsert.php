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
    <form method="post" action="UFInsert.php">
    	<fieldset>
    		<legend>Inserindo Unidade da Federação</legend>
    		<label class="labelNormal">Sigla:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="CD_UF" size="2" value = ' .
    		     $_POST[CD_UF] . '><br>';
    		?>
    		<label class="labelNormal">Nome:</label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_UF" size="30" value=' .
    		     $_POST[NM_UF] . '><br><br>';
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="UF.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[CD_UF]) && !isset($_REQUEST[NM_UF]))
        die();
    
    require "comum.php";
    require "UFClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjUF->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjUF = new UF();
    $ObjUF->CD_UF = $_REQUEST[CD_UF];
    $ObjUF->NM_UF = $_REQUEST[NM_UF];
    if (!$ObjUF->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjUF->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
