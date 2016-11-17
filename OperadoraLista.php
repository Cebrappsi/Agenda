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
    	<th>Código</th>
    	<th>Operadora de Telefonia</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from operadora order by CD_Operadora')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta operadora: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="OperadoraForm.php">Inserir Nova Operadora de Telefonia</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	echo "<tr>";
    		echo '<td>' . $dados[CD_Operadora] . '</td>';
    		echo '<td>' . $dados[NM_Operadora] . '</td>';
    		echo '<td><a href=OperadoraForm.php?SQ_Operadora=' . $dados[SQ_Operadora] . '>Alterar</a></td>';
    		echo '<td><a href=OperadoraDelete.php?SQ_Operadora=' . $dados[SQ_Operadora] . '&NM_Operadora=' . urlencode($dados[NM_Operadora]). '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
