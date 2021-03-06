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
    	<th>Profissional</th>
    	<th>Especialidade</th>
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
    
    if (!$listaProfissionais = mysql_query('SELECT  profissional.*, Contato.NM_Contato, Especialidade.NM_Especialidade ' .
								 'FROM Profissional ' .
								 'INNER JOIN Contato ' .
									'on Contato.SQ_Contato = Profissional.SQ_Profissional ' .
                                 'INNER JOIN Especialidade ' .
									'on Especialidade.SQ_Especialidade = Profissional.SQ_Especialidade ' .
								 'ORDER BY Contato.NM_Contato, Especialidade.NM_Especialidade')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Profissional: ' . mysql_error() .'<br></a>';
		die();
    }
    
    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="ProfissionalForm.php">Inserir Novo Profissional</a>';
    echo('<br><br>');
    while ($regProfissional = mysql_fetch_array($listaProfissionais))
    {
    	echo "<tr>";
    		echo '<td>' . $regProfissional[NM_Contato] . '</td>';
			echo '<td>' . $regProfissional[NM_Especialidade] . '</td>';
    		echo '<td>' . implode('/',array_reverse(explode('-',$regProfissional[DT_Ativacao]))) . '</td>';
    		echo '<td>' . implode('/',array_reverse(explode('-',$regProfissional[DT_Desativacao]))) . '</td>';
    		echo '<td><a href=ProfissionalForm.php?SQ_Profissional=' . $regProfissional[SQ_Profissional] . 
												 '&SQ_Especialidade='. $regProfissional[SQ_Especialidade] . 
 												 '&NM_Profissional=' . urlencode($regProfissional[NM_Contato]) . 
												 '&SQ_Especialidade='. $regProfissional[SQ_Especialidade] .
												 '&NM_Especialidade='. urlencode($regProfissional[NM_Especialidade]).
												 '>Alterar</a></td>';
    		echo '<td><a href=ProfissionalDelete.php?SQ_Profissional=' . $regProfissional[SQ_Profissional] . 
												   '&NM_Profissional=' . urlencode($regProfissional[NM_Contato]) . 
												   '&SQ_Especialidade='. $regProfissional[SQ_Especialidade] .
												   '&NM_Especialidade='. urlencode($regProfissional[NM_Especialidade]).
													'>Excluir</a></td>';
        echo '</tr>';
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
