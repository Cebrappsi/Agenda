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
			width:20%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
	<?php 
		//prepara consultas Especialidades, planos e convenios para montar a lista
	 	require "comum.php";
	    		
	    if (!conecta_BD($con,$MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	    	die();
	    }
	    		
	    if (!$consultaValor = mysql_query('SELECT Especialidade.*, plano.*, convenio.* 
			    							  from Especialidade 
			    		                      inner join convenio 
			    							  on Especialidade.SQ_Convenio = Convenio.SQ_Convenio
	    									  inner join Plano 
			    							  on Especialidade.SQ_Plano = Plano.SQ_Plano 
			    							  order by NM_Convenio, NM_Plano, NM_Especialidade')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Plano/convenio/Especialidade: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($consultaValor);
	?>		
	   
    <form method="post" action="ValorInsert.php">
    	<fieldset>
    		<legend>Inserindo Valor</legend>
    		<?php
    		echo '<label class="labelNormal">Convênio/Plano/Especialidade: </label>';
    		echo '<select class="Entrada" name="ConvPlanEspec">';
     	    	while ($dados = mysql_fetch_array($consultaValor))  //guardo info a cada 4 posicoes - Conv-plan-Espec
	    		   echo '<option value="' . ($dados[SQ_Convenio] * 100000000 + ($dados[SQ_Plano] * 10000) + $dados[SQ_Especialidade])  . '">' 
	    	            . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '->' . $dados[NM_Especialidade] . '</option>';
		    echo '</select><br><br>';
	    	echo '<label class="labelNormal">Valor Consulta: </label>';
	    	echo '<input class="Entrada" type="text" name="VL_Consulta" size="12" value=' . '"' . $_REQUEST[VL_Consulta] . '"><br><br>';
    		echo '<label class="labelNormal">Data Ativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=' . $_REQUEST[DT_Ativacao] . '><br><br>';
    		echo '<label class="labelNormal">Data Desativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=' . $_REQUEST[DT_Desativacao] . '><br><br>';
    	    ?>
    	</fieldset>
    
    	<a class="linkVoltar" href="Valor.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php
     if (!isset($_REQUEST[VL_Consulta]) && !isset($_REQUEST[DT_Ativacao]) && !isset($_REQUEST[DT_Desativacao]))
         	//Tela sendo apresentada pela primeira vez
        die();
    
    require "ValorClasse.php";
    
    //ok - vamos incluir	
    $ObjValor = new Valor();
    $ObjValor->SQ_Convenio = floor($_REQUEST[ConvPlanEspec] / 100000000);
    $ObjValor->SQ_Plano = floor($_REQUEST[ConvPlanEspec] / 10000) % 10000;
    $ObjValor->SQ_Especialidade = $_REQUEST[ConvPlanEspec] % 10000;
    $ObjValor->VL_Consulta = $_REQUEST[VL_Consulta];
    $ObjValor->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjValor->DT_Desativacao = $_REQUEST[DT_Desativacao];
    //print_r($_REQUEST[ConvPlanEspec]);
    //print_r($ObjValor);
    if (!$ObjValor->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjValor->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>