<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css"/>
    <style>body {
        background-color:#D8D8D8; font-family:Verdana; font-size:10pt;
        }
        </style>
  </HEAD>
  <BODY>
    <table class="CabecalhoTabela" border="1">
    <tr>
    	<th>Nome do Convenio</th>
    	<th>Nome do Plano</th>
    	<th>Nome da Especialidade</th>
    	<th>Valor Consulta</th>
    	<th>Data Ativação</th>
    	<th>Data Desativação</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>

    <?php
    require "comum.php";
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    //prepara para carregar lista de especialidades
    if (!$consulta = mysql_query('SELECT Valor.*, Especialidade.NM_Especialidade,Plano.NM_Plano, Convenio.NM_Convenio 
									from Valor
    								inner join Especialidade
									on Valor.SQ_Especialidade = Especialidade.SQ_Especialidade
									inner join plano
									on Valor.SQ_Plano = Plano.SQ_Plano
									inner join Convenio
									on Valor.SQ_Convenio = Convenio.SQ_Convenio
									order by NM_Convenio,NM_Plano,NM_Especialidade')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Especialidade: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="ValorInsert.php">Inserir Novo Valor</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {   
    	echo "<tr>";
    	    echo '<td>' . $dados[NM_Convenio] . '</td>';
    	    echo '<td>' . $dados[NM_Plano] . '</td>';
    		echo '<td>' . $dados[NM_Especialidade] . '</td>';
    		echo '<td>' . $dados[VL_Consulta] . '</td>';
    		echo '<td>' . $dados[DT_Ativacao] . '</td>';
    		echo '<td>' . $dados[DT_Desativacao] . '</td>';
    		echo '<td><a href=ValorEdit.php?SQ_Valor=' . $dados[SQ_Valor] . '>Alterar</a></td>';
    		echo '<td><a href=ValorDelete.php?SQ_Valor=' . $dados[SQ_Valor] . '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>