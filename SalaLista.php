<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    	<th>Nome da Sala</th>
    	<th>Data Ativação</th>
    	<th>Data Desativação</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from Sala order by NM_Sala')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Sala: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="SalaForm.php">Inserir Nova Sala</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	echo "<tr>";
    		echo '<td>' . $dados[NM_Sala] . '</td>';
    		echo '<td>' . implode('/',array_reverse(explode('-',$dados[DT_Ativacao]))) . '</td>';
    		echo '<td>' . implode('/',array_reverse(explode('-',$dados[DT_Desativacao]))) . '</td>';
    		echo '<td><a href=SalaForm.php?SQ_Sala=' . $dados[SQ_Sala] . '>Alterar</a></td>';
    		echo '<td><a href=SalaDelete.php?SQ_Sala=' . $dados[SQ_Sala] . '&NM_Sala=' . urlencode($dados[NM_Sala]) . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
