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
    	<th>Tipo Uso</th>
    	<th>Nome do Tipo Uso</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from tipo_Uso order by TP_Uso')){
	    echo '<a class="MsgErro">Não foi possivel efetuar consulta tipo_Uso: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="TipoUsoForm.php">Inserir Novo Tipo de Uso do Telefone</a>';
    echo('<br><br>');
    
    while ($dados = mysql_fetch_array($consulta))
    {
      // print_r($dados);
    	echo "<tr>";
    		echo '<td>' . $dados[TP_Uso] . '</td>';
    		echo '<td>' . $dados[NM_Tipo_Uso] . '</td>';
    		echo '<td><a href=tipoUsoForm.php?TP_Uso=' . $dados[TP_Uso] . '>Alterar</a></td>';
    		echo '<td><a href=tipoUsoDelete.php?TP_Uso=' . $dados[TP_Uso].'&NM_Tipo_Uso=' . urlencode($dados[NM_Tipo_Uso]) . '>Excluir</a></td>';
    		echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>