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
    	<th>Nome</th>
    	<th>Tipo</th>
    	<th>Nascimento</th>
    	<th>Identificacao</th>
    	<th>Observações</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from Contato order by NM_Contato')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="ContatoInsert.php">Inserir Novo Contato</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	echo "<tr>";
    		echo '<td size="30">' . $dados[NM_Contato] . '</td>';
    		echo '<td>' . $dados[TP_Contato] . '</td>';
    		echo '<td>' . $dados[DT_Nascimento] . '</td>';
    		echo '<td size="14">' . $dados[Identificacao] . '</td>';
    		echo '<td>' . $dados[Observacoes] . '</td>';
    		echo '<td><a href=ContatoEdit.php?SQ_Contato=' . $dados[SQ_Contato] . '>Alterar</a></td>';
    		echo '<td><a href=ContatoDelete.php?SQ_Contato=' . $dados[SQ_Contato] .
    		                                     '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
