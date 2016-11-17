<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8; font-family:Verdana; font-size:10pt;
        }
        label.labelNormal{
			float:left;
			width:15%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
		
    </style>
  </HEAD>
  <BODY>    
    <?php
    require "comum.php";
    
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }

   	$Query =  'Select escala.*,  Contato.NM_Contato from escala ' .
    		          'inner join Contato ' . 
    		          'on escala.SQ_Contato = Contato.SQ_Contato ' .
    		          'where escala.DT_Fim_Escala = "0000-00-00" ' .
    		          'or escala.DT_Fim_Escala > "' .  date('Y-m-d') . '"' .
    		          'order by Contato.NM_Contato, ' .
    		                   'escala.DT_Ini_Escala, ' .
   	                           'escala.Dia_Semana';
    
    //echo $_REQUEST[Tipo] .  	$Query;
    if (!$SetEscala = mysql_query($Query)){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Escala de Trabalho Profissional: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    
    print_r($_REQUEST); //debug var recebidas
    echo '<form method="post" action="AgendaAbreInsert.php?DT_Ini_Agenda="' . DT_Ini_Agenda .
                                                         '&DT_Fim_Agenda='  . DT_Fim_Agenda .
                                                         '&Selecionado  ='  . Selecionado . '>';
	    echo '<fieldset>';
		    echo '<legend>Abrindo Agenda</legend>';
		    echo '<label class="labelNormal">Dt Inicio Agenda:</label>';
		    echo '<input class="Entrada" type="date" name="DT_Ini_Agenda" size="10" value=' .
		    		$_POST[DT_Ini_Agenda] . '>';
		    echo '<br>';
		    echo '<input class="Envia" type="submit" name="submit" value="Criar Agenda" style = "position: absolute; left: 35%;top: 10%">';
		    echo '<label class="labelNormal">Dt Fim Agenda:</label>';
		    echo '<input class="Entrada" type="date" name="DT_Fim_Agenda" size="10" value=' .
		    		$_POST[DT_Fim_Agenda] . '>';
		    echo '<br><br>';
		    echo 'Selecione os profissionais para abrir agenda no período definido:';
		    echo('<br><br>');
		    echo '<table class="CabecalhoTabela" border="1">';
			    echo '<tr>';
			        echo '<th>Seleção</th>';
				    echo '<th>Profissional</th>';
				    echo '<th>Data Ini Escala</th>';
				    echo '<th>Data Fim Escala</th>';
				    echo '<th>Dia Semana</th>';
				    echo '<th>Interv Atend</th>';
				    echo '<th>Hora Ini-1Turno</th>';
				    echo '<th>Hora Fim-1Turno</th>';
				    echo '<th>Hora Ini-2Turno</th>';
				    echo '<th>Hora Fim-2Turno</th>'; 	
		    	echo '</tr>';
			    while ($RegEscala = mysql_fetch_array($SetEscala))
			    {
			   	    echo "<tr>";
			   	        echo '<td size="5" align="center">';
				   	    echo '<input type="checkbox" class="Entrada" checked name="Selecionado[' 
				   	                     . ($RegEscala[SQ_Contato] * 1000000 + $RegEscala[Dia_Semana]) . ']">';
				   	    echo '</td>';
				    	echo '<td size="50">'      . $RegEscala[NM_Contato] . '</td>';
				    	echo '<td align="center">' . $RegEscala[DT_Ini_Escala] . '</td>';
				    	echo '<td align="center">' . $RegEscala[DT_Fim_Escala] . '</td>';
				    	echo '<td align="center">' . $RegEscala[Dia_Semana] . '</td>';
				    	echo '<td align="center">' . $RegEscala[Intervalo_Atendimento] . '</td>';
				    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Ini_Turno1])) . '</td>';
				    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Fim_Turno1])) . '</td>';
				    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Ini_Turno2])) . '</td>';
				    	echo '<td align="center">' . date('H:i',strtotime($RegEscala[HR_Fim_Turno2])) . '</td>';
			        echo '</tr>';
			            	 
			    }
	    echo '</table>';
	  
	    if(empty($_POST['submit']))
	    	die('vazio');//// S� apresenta os dados
	    	  
    mysql_close($con);
  ?>
  		</fieldset>
   	</form>
  </BODY>
</HTML>
