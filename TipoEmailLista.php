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
    	<th>Tipo Email</th>
    	<th>Nome do Tipo Email</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from tipo_Email order by TP_Email')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta tipo_Email: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="TipoEmailForm.php">Inserir Novo Tipo de Email</a>';
    echo('<br><br>');
    
    while ($dados = mysql_fetch_array($consulta))
    {
      // print_r($dados);
    	echo "<tr>";
    		echo '<td>' . $dados[TP_Email] . '</td>';
    		echo '<td>' . $dados[NM_Tipo_Email] . '</td>';
    		echo '<td><a href=tipoEmailForm.php?TP_Email=' . $dados[TP_Email] . '>Alterar</a></td>';
    		echo '<td><a href=tipoEmailDelete.php?TP_Email=' . $dados[TP_Email] .'&NM_Tipo_Email=' . urlencode($dados[NM_Tipo_Email]) . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>