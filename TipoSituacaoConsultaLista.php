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
    	<th>Tipo Situacao Consulta</th>
    	<th>Nome da Situacao da Consulta</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from Tipo_Situacao_Consulta order by TP_Situacao_Consulta')){
	    echo '<a class="MsgErro">Não foi possivel efetuar consulta Tipo Situacao Consulta: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="TipoSituacaoConsultaForm.php">Inserir Novo Tipo de Situacao Consulta</a>';
    echo('<br><br>');
    
    while ($dados = mysql_fetch_array($consulta))
    {
      // print_r($dados);
    	echo "<tr>";
    		echo '<td>' . $dados[TP_Situacao_Consulta] . '</td>';
    		echo '<td>' . $dados[NM_Tipo_Situacao_Consulta] . '</td>';
    		echo '<td><a href=TipoSituacaoConsultaForm.php?TP_Situacao_Consulta=' . $dados[TP_Situacao_Consulta] . '>Alterar</a></td>';
    		echo '<td><a href=TipoSituacaoConsultaDelete.php?TP_Situacao_Consulta=' . $dados[TP_Situacao_Consulta] 
    		                                     .'&NM_Tipo_Situacao_Consulta=' . urlencode($dados[NM_Tipo_Situacao_Consulta]) . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
