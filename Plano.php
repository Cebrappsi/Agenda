<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
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
    
    if (!$consulta = mysql_query('SELECT plano.*, convenio.NM_Convenio 
    							  from Plano 
    		                      inner join convenio 
    							  on plano.SQ_Convenio = convenio.SQ_Convenio 
    							  order by NM_Convenio, NM_Plano')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Plano: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="PlanoInsert.php">Inserir Novo Plano</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	echo "<tr>";
    	    echo '<td>' . $dados[NM_Convenio] . '</td>';
    		echo '<td>' . $dados[NM_Plano] . '</td>';
    		echo '<td>' . $dados[DT_Ativacao] . '</td>';
    		echo '<td>' . $dados[DT_Desativacao] . '</td>';
    		echo '<td><a href=PlanoEdit.php?SQ_Plano=' . $dados[SQ_Plano] . '>Alterar</a></td>';
    		echo '<td><a href=PlanoDelete.php?SQ_Plano=' . $dados[SQ_Plano] .
    		                                     '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
