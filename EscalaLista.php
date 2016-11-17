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
    
    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }

   	$Query =  'Select escala.*,  Contato.NM_Contato from escala ' .
    		          'inner join Contato ' . 
    		          'on escala.SQ_Profissional = Contato.SQ_Contato ' .
    		          'order by Contato.NM_Contato, ' .
    		                   'escala.DT_Ini_Escala, ' .
   	                           'escala.Dia_Semana';
    
    //echo $_REQUEST[Tipo] .  	$Query;
    if (!$SetEscala = mysql_query($Query)){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Escala de Trabalho Profissional: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="EscalaForm.php">Inserir Nova Escala</a>';
    echo('<br><br>');
    echo '<tr>';
	    echo '<th>Profissional</th>';
	    echo '<th>Dt Inicio</th>';
	    echo '<th>Dt Fim</th>';
	    echo '<th>Dia Semana</th>';
	    echo '<th>Interv Atend</th>';
	    echo '<th>Duração</th>';
	    echo '<th>Hora Ini-1Turno</th>';
	    echo '<th>Hora Fim-1Turno</th>';
	    echo '<th>Hora Ini-2Turno</th>';
	    echo '<th>Hora Fim-2Turno</th>';
	    echo '<th>Alterar?</th>';
	    echo '<th>Excluir?</th>'; 	
    echo '</tr>';
    while ($RegEscala = mysql_fetch_array($SetEscala))
    {
   	    echo "<tr>";
    	echo '<td size="50">'      . $RegEscala[NM_Contato] . '</td>';
      	echo '<td align="center">' . implode('/',array_reverse(explode('-',$RegEscala[DT_Ini_Escala]))) . '</td>';
    	echo '<td align="center">' . implode('/',array_reverse(explode('-',$RegEscala[DT_Fim_Escala])))	. '</td>';
    	echo '<td align="center">' . $RegEscala[Dia_Semana] . '</td>';
    	echo '<td align="center">' . $RegEscala[Intervalo] . '</td>';
    	echo '<td align="center">' . $RegEscala[Duracao] . '</td>';
    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Ini_Turno1])) . '</td>';
    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Fim_Turno1])) . '</td>';
    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Ini_Turno2])) . '</td>';
    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Fim_Turno2])) . '</td>';
    	echo '<td><a href=EscalaForm.php?SQ_Profissional='    . $RegEscala[SQ_Profissional] . 
    	                               '&DT_Ini_Escala=' . implode('/',array_reverse(explode('-',$RegEscala[DT_Ini_Escala]))) .
    								   '&Dia_Semana=' . $RegEscala[Dia_Semana] .	 '>Alterar</a></td>';
    	echo '<td><a href=EscalaDelete.php?SQ_Profissional=' . $RegEscala[SQ_Profissional] . '&NM_Contato=' . urlencode($RegEscala[NM_Contato]) .
    	                                  '&DT_Ini_Escala=' . implode('/',array_reverse(explode('-',$RegEscala[DT_Ini_Escala]))) . 
    	                                  '&Dia_Semana=' . $RegEscala[Dia_Semana] . '>Excluir</a></td>';
        echo '</tr>';
            	 
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
