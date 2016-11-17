<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    	<th>Tipo Relação</th>
    	<th>Nome do Tipo da Relação</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from tipo_relacionamento order by TP_Relacao')){
	    echo '<a class="MsgErro">Não foi possivel efetuar consulta tipo_Relacao: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="TipoRelacaoForm.php">Inserir Novo Tipo de Relacionamento</a>';
    echo('<br><br>');
    
    while ($dados = mysql_fetch_array($consulta))
    {
      // print_r($dados);
    	echo "<tr>";
    		echo '<td>' . $dados[TP_Relacao] . '</td>';
    		echo '<td>' . $dados[NM_Tipo_Relacao] . '</td>';
    		echo '<td><a href=tipoRelacaoForm.php?TP_Relacao=' . $dados[TP_Relacao] . '>Alterar</a></td>';
    		echo '<td><a href=tipoRelacaoDelete.php?TP_Relacao=' . $dados[TP_Relacao] . '&NM_Tipo_Relacao=' . urlencode($dados[NM_Tipo_Relacao]) . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
   ?>
   </table>
  </BODY>
</HTML>
