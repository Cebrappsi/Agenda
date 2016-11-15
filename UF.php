<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }        
        </style>
  </HEAD>
  <BODY>
    <table class="CabecalhoTabela" border="1">
    <tr>
    	<th>Sigla UF</th>
    	<th>Nome da Unidade da Federação</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from UF order by CD_UF')){
	    echo '<a class="MsgErro">Não foi possivel efetuar consulta UF: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="UFInsert.php">Inserir Nova UF</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	echo "<tr>";
    		echo '<td>' . $dados[CD_UF] . '</td>';
    		echo '<td>' . $dados[NM_UF] . '</td>';
    		echo '<td><a href=UFEdit.php?CD_UF=' . $dados[CD_UF] . '>Alterar</a></td>';
    		echo '<td><a href=UFDelete.php?CD_UF=' . $dados[CD_UF] .
    		                                     '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
