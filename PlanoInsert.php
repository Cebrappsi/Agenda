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
	<?php 
		//prepara consulta convenio para montar a lista
	 	require "comum.php";
	    		
	    if (!conecta_BD($con,$MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	    	die();
	    }
	    		
	    if (!$consulta = mysql_query('SELECT * from Convenio order by NM_Convenio')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Convenio: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($consulta);
	?>		
	   
    <form method="post" action="PlanoInsert.php">
    	<fieldset>
    		<legend>Inserindo Plano</legend>
    		<label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Plano" size="30" value=' . '"' . $_REQUEST[NM_Plano] . '"><br><br>';
    		echo '<label class="labelNormal">Convênio: </label>';
    		echo '<select class="Entrada" name="SQ_Convenio">';
		    	while ($dados = mysql_fetch_array($consulta)) 
		    		   echo '<option value="' , $dados[SQ_Convenio] . '">' . $dados[NM_Convenio] . '</option>';
	    	echo '</select><br><br>';
    		echo '<label class="labelNormal">Data Ativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=' . $_REQUEST[DT_Ativacao] . '><br><br>';
    		echo '<label class="labelNormal">Data Desativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=' . $_REQUEST[DT_Desativacao] . '><br><br>';
    	    ?>
    	</fieldset>
    
    	<a class="linkVoltar" href="Plano.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php
    //print_r($_REQUEST);	
    if (!isset($_REQUEST[NM_Plano]) && !isset($_REQUEST[DT_Ativacao]) && !isset($_REQUEST[DT_Desativacao]))
    	//Tela sendo apresentada pela primeira vez
        die();
    
    require "PlanoClasse.php";
    
    //ok - vamos incluir	
    $ObjPlano = new Plano();
    $ObjPlano->SQ_Convenio = $_REQUEST[SQ_Convenio];
    $ObjPlano->NM_Plano = $_REQUEST[NM_Plano];
    $ObjPlano->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjPlano->DT_Desativacao = $_REQUEST[DT_Desativacao];
    //print_r($ObjPlano);
    if (!$ObjPlano->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjPlano->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>