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
    	<th>Tipo Mobilidade</th>
    	<th>Nome do Tipo Mobilidade</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from tipo_Mobilidade order by TP_Mobilidade')){
	    echo '<a class="MsgErro">Não foi possivel efetuar consulta tipo_Mobilidade: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="tipoMobilidadeInsert.php">Inserir Novo Tipo de Mobilidade do Telefone</a>';
    echo('<br><br>');
    
    while ($dados = mysql_fetch_array($consulta))
    {
      // print_r($dados);
    	echo "<tr>";
    		echo '<td>' . $dados[TP_Mobilidade] . '</td>';
    		echo '<td>' . $dados[NM_Tipo_Mobilidade] . '</td>';
    		echo '<td><a href=tipoMobilidadeEdit.php?TP_Mobilidade=' . $dados[TP_Mobilidade] . '>Alterar</a></td>';
    		echo '<td><a href=tipoMobilidadeDelete.php?TP_Mobilidade=' . $dados[TP_Mobilidade] .
    		                                     '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
