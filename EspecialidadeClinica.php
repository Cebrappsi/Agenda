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
    	<th>Especialidade da Clinica</th>
    	<th>Alterar?</th>
    	<th>Excluir?</th>
    </tr>
  

    <?php
    require "comum.php";
    
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
    
    if (!$consulta = mysql_query('SELECT * from Especialidade_Clinica order by NM_Especialidade_Clinica')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Especialidade Clinica: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="EspecialidadeClinicaInsert.php">Inserir Nova Especialidade da Clinica</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	echo "<tr>";
    		echo '<td>' . $dados[NM_Especialidade_Clinica] . '</td>';
    		echo '<td><a href=EspecialidadeClinicaEdit.php?SQ_Especialidade_Clinica=' . $dados[SQ_Especialidade_Clinica] . '>Alterar</a></td>';
    		echo '<td><a href=EspecialidadeClinicaDelete.php?SQ_Especialidade_Clinica=' . $dados[SQ_Especialidade_Clinica] .
    		                                     '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>