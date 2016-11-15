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
		//prepara consultas planos e convenios para montar a lista
	 	require "comum.php";
	    		
	    if (!conecta_BD($con,$MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	    	die();
	    }
	    		
	    if (!$consultaPlano = mysql_query('SELECT plano.*, convenio.* 
			    							  from Plano 
			    		                      inner join convenio 
			    							  on plano.SQ_Convenio = convenio.SQ_Convenio 
			    							  order by NM_Convenio, NM_Plano')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Plano/convenio: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($consultaPlano);
	?>		
	   
    <form method="post" action="EspecialidadeInsert.php">
    	<fieldset>
    		<legend>Inserindo Especialidade</legend>
    		<label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Especialidade" size="30" value=' . '"' . $_REQUEST[NM_Especialidade] . '"><br><br>';
    		echo '<label class="labelNormal">Convênio: </label>';
    		echo '<select class="Entrada" name="ConvPlan">';
		    	while ($dados = mysql_fetch_array($consultaPlano))  //guardo o Convenio na posição acima de 1000000
		    		   echo '<option value="' . ($dados[SQ_Convenio] * 1000000 + $dados[SQ_Plano])  . '">' . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '</option>';
		    echo '</select><br><br>';
	    	echo '<label class="labelNormal">Qtd. Consultas por Semana: </label>';
	    	echo '<input class="Entrada" type="text" name="NR_Consultas_Semana" size="3" value=' . '"' . $_REQUEST[NR_Consultas_Semana] . '"><br><br>';
    		echo '<label class="labelNormal">Data Ativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=' . $_REQUEST[DT_Ativacao] . '><br><br>';
    		echo '<label class="labelNormal">Data Desativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=' . $_REQUEST[DT_Desativacao] . '><br><br>';
    	    ?>
    	</fieldset>
    
    	<a class="linkVoltar" href="Especialidade.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php
    //print_r($_REQUEST);	
    if (!isset($_REQUEST[NM_Especialidade]) && !isset($_REQUEST[DT_Ativacao]) && !isset($_REQUEST[DT_Desativacao]))
    	//Tela sendo apresentada pela primeira vez
        die();
    
    require "EspecialidadeClasse.php";
    
    //ok - vamos incluir	
    $ObjEspecialidade = new Especialidade();
    $ObjEspecialidade->SQ_Convenio = floor($_REQUEST[ConvPlan] / 1000000);
    $ObjEspecialidade->SQ_Plano = $_REQUEST[ConvPlan] % 1000000;
    $ObjEspecialidade->NM_Especialidade = $_REQUEST[NM_Especialidade];
    $ObjEspecialidade->NR_Consultas_Semana = $_REQUEST[NR_Consultas_Semana];
    $ObjEspecialidade->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjEspecialidade->DT_Desativacao = $_REQUEST[DT_Desativacao];
    //print_r($ObjEspecialidade);
    if (!$ObjEspecialidade->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjEspecialidade->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>