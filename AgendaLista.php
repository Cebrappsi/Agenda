    <?php
    require "comum.php";
    //print_r($_REQUEST); //debug var recebidas
    
    if (!conecta_BD($con,$MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }

    if (!$SetProfissionais = mysql_query('Select distinct Profissional.SQ_Profissional, Contato.NM_Contato from Profissional ' .
	    								 'inner join Contato ' .
	    								 'on Profissional.SQ_Profissional = Contato.SQ_Contato ' .
	    								 'Order by NM_Contato')){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Profissionais: ' . mysql_error() .'<br></a>';
	    die();
	}

	// Busca e imprime uma consulta marcada
	function buscaImmprimeConsulta($hora,$dtConsulta,$Profissional){
		$qryConsulta = 'Select consulta.*, Contato.NM_Contato, Plano.NM_Plano,sala.NM_Sala, tipo_situacao_Consulta.NM_Tipo_Situacao_Consulta ' .
				' from Consulta ' .
				' inner join Contato ' .
				' on Consulta.SQ_Contato_Paciente = Contato.SQ_Contato ' .
				' inner join plano ' .
				' on Consulta.SQ_Plano = Plano.SQ_Plano ' .
				' inner join sala ' .
				' on Consulta.SQ_Sala = Sala.SQ_Sala ' .
				' inner join Tipo_Situacao_Consulta ' .
				' on Consulta.TP_Situacao_Consulta = Tipo_Situacao_Consulta.TP_Situacao_Consulta' .
				' Where DT_Consulta = "' . date_format($dtConsulta,"Y-m-d") . '"' .
				' and HR_Consulta =  "' . date('H:i',$hora) . '"' .
				' and SQ_Contato_Profissional = ' . $Profissional;
		//ECHO $qryConsulta;
		 
		if (!$SetConsulta = mysql_query($qryConsulta)){
			echo '<a class="MsgErro">Não foi possível efetuar consulta Escala de Trabalho Profissional: ' . mysql_error() .'<br></a>';
			die();
		}
		echo "<tr>";
		if (mysql_num_rows($SetConsulta) > 0){
			$regConsulta = mysql_fetch_array($SetConsulta);
			echo '<td> <a href="AgendaForm.php?Operacao=Mostrar&SQ_Contato_Profissional=' . $Profissional .
															  '&NM_Profissional=' . urlencode($regConsulta['NM_Contato']) .
			                                                  '&SQ_Contato_Paciente=' . $regConsulta['SQ_Contato_Paciente'] .
			                                                  '&DT_Consulta=' . urlencode($regConsulta['DT_Consulta']) . 
			                                                  '&HR_Consulta=' . urlencode(date('H:i',$hora)) . 
															  '">' . date('H:i',$hora) . '</a></td>';
			echo '<td align="center">' . $regConsulta['NM_Contato'] . '</td>';
			echo '<td align="center">' . $regConsulta['NM_Plano'] . '</td>';
			echo '<td align="center">' . $regConsulta['NM_Tipo_Situacao_Consulta'] . '</td>';
			echo '<td align="center">' . $regConsulta['NM_Sala'] . '</td>';
		} else{
			echo '<td> <a href="AgendaForm.php?Operacao=Mostrar&SQ_Contato_Profissional=' . $Profissional .
															  '&DT_Consulta=' . urlencode(date_format($dtConsulta,"Y-m-d")) .
															  '&HR_Consulta=' . urlencode(date('H:i',$hora)) .
															  '">' . date('H:i',$hora) . '</a></td>';
			echo '<td align="center">' . '-------' . '</td>';
			echo '<td align="center">' . '-------' . '</td>';
			echo '<td align="center">' . '-------' . '</td>';
			echo '<td align="center">' . '-------' . '</td>';
		}
		echo "</tr>";
	}
	
//    mysql_close($con);
?>
<!DOCTYPE html>
  <HTML>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    div #superior{
		 margin: 0;
		 padding: 0;
		 background-color:#00D8D8;
    }
    div #ladoaladox{
		 float:left;
		 width:auto;
		 background-color:#00D800;
		 overflow:auto;
    }
    .CabecalhoTabela TH
		{
		font-family:Verdana;
		font-size:10pt;
		color:green;
		background-color:#33CC66;
		}

	
	  
		tr:nth-child(even) {font-family:Verdana; font-size:10pt; background:#FFF}
		tr:nth-child(odd)  {font-family:Verdana; font-size:10pt; background:#EEE}
      
    </style>
    <script type="text/javascript">
			function tamanho(){
				var divs = document.getElementById("tabelas").getElementsByTagName("div");
				var total = 300 * divs.length; // 180 é o tamanho de largura mais a margem
				//alert(total);
				document.getElementById("tabelas").style.width = total+"px";
			}
		</script>
    
    </HEAD>
    <BODY onload="tamanho();">
    	<form method="post" action="">
    	   <div id='superior'>
		        <?php 
		          	echo '<input type="radio" name="DT_Ini_Agenda" value="' .
		        				date_format(date_sub(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P1M')),"Y-m-d") . '"><-1Mês</a>';
		         
			      	echo '<input type="radio" name="DT_Ini_Agenda" value="' . 
			      	   			date_format(date_sub(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P7D')),"Y-m-d") . '"><-1Semana </a>';
			      
					for ($i = 0; $i <= 30; $i=$i+3) {
						if ($i==0)
				      	   echo '<input type="radio" name="DT_Ini_Agenda" checked value="';
						else
				      	   echo '<input type="radio" name="DT_Ini_Agenda" value="';
				      	echo date_format(date_add(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P' . $i .'D')),"Y-m-d") . '">' .
				      	   	 date_format(date_add(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P' . $i .'D')),"d/m") . ' </a>';
				      }
				    echo '<input type="radio" name="DT_Ini_Agenda" value="' .   
				      	   			date_format(date_add(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P7D')),"Y-m-d") . '">+1Semana></a>';
				    echo '<input type="radio" name="DT_Ini_Agenda" value="' .
				    		date_format(date_add(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P1M')),"Y-m-d") . '">+1Mês></a>';
				 ?> 
			    
			    <br><br>
			 	<label class="labelNormal">Profissional: </label>
	    		<select name="SQ_Profissional">
	    		 <?php
	    		 	while ($RegProfissional = mysql_fetch_array($SetProfissionais))
						if ($RegProfissional[SQ_Profissional] == $_REQUEST[SQ_Profissional])
							echo '<option selected value=' . $RegProfissional[SQ_Profissional] . '>' . $RegProfissional[NM_Contato] . '</option>';
	    				else
							echo '<option value=' . $RegProfissional[SQ_Profissional] . '>' . $RegProfissional[NM_Contato] . '</option>';
	    		?>
	    		</select>
	    		<br><br>
	 		 	<label>Escolha a data inicial e o profissional para ver sua agenda </label>
	            <br><br>
	    		<input class="Envia" type="submit"  name="Operacao"  value= "Consultar">
            </div>
		    <?php 
		    echo '<div id="tabelas" style="float:left; overflow:auto;">';
				if ($_REQUEST[SQ_Profissional]){
					for ($i = 0; $i < 15; $i++) { // Apresento agenda para duas semanas
						$dataAtu = date_add(new DateTime($_REQUEST[DT_Ini_Agenda]),new DateInterval('P' . $i .'D'));
						echo '<div id="ladoalado" style="float:left;  overflow:auto;">';
							// Primeira Linha do cabecalho
							echo '<table class="CabecalhoTabela" border="1">';
								echo '<tr>';
									echo '<th colspan=5>' . date_format($dataAtu,"d/m") 
								                  . ' - ' . diaSemana($dataAtu) . '</th>';
				    		
				    			echo '</tr>';
				    		// Segunda Linha do cabecalho
				    			echo '<tr>';
					    			echo '<th>Hora</th>';
				      	   			echo '<th>Paciente</th>';
				      	   			echo '<th>Plano</th>';
				      	   			echo '<th>Situação</th>';
				      	   			echo '<th>Sala</th>';
				      	   		echo '</tr>';
			      	   			//Monta as linhas conforme o dia da semana
					      		$qryEscala = 'Select escala.*  ' .
					      				' FROM ESCALA ' .
					      				' where SQ_Profissional = ' . $_REQUEST[SQ_Profissional] .
					      				' and DT_Ini_Escala <= "' . $_REQUEST[DT_Ini_Agenda] . '"'.
					      				' and Dia_Semana = ' . ((int)date_format($dataAtu,"w") + 1) .
					      				' and DT_Fim_Escala = "0000-00-00" ';
					      		//echo date_format($dataAtu,"Y-m-d") . '-' . $qryEscala . '<br>';
					      		if (!$SetEscala = mysql_query($qryEscala)){ 
					      			echo '<a class="MsgErro">Não foi possível efetuar consulta Escala de Trabalho Profissional: ' . mysql_error() .'<br></a>';
					      			die();
					      		}
					      		if (mysql_num_rows($SetEscala) > 0){ //Deve haver apenas um registro por dia
							        $RegEscala = mysql_fetch_array($SetEscala);
							   	    //print_r('P' . $RegEscalauracao] . 'i' . '-' . strtotime($RegEscala[HR_Ini_Turno1]) . '-' . date($RegEscala[HR_Ini_Turno1]));
							        $hora = strtotime($RegEscala[HR_Ini_Turno1]);
							        while ($hora < strtotime($RegEscala[HR_Fim_Turno1])) {
										buscaImmprimeConsulta($hora,$dataAtu,$_REQUEST[SQ_Profissional]);	
							        	$hora = strtotime('+'. ($RegEscala[Duracao]+$RegEscala[Intervalo]) . ' minute', $hora);
							   	    }
							   	    $hora = strtotime($RegEscala[HR_Ini_Turno2]);
							   	    while ($hora < strtotime($RegEscala[HR_Fim_Turno2])) {
							   	    	buscaImmprimeConsulta($hora,$dataAtu,$_REQUEST[SQ_Profissional]);
							   	    	$hora = strtotime('+'. ($RegEscala[Duracao]+$RegEscala[Intervalo]) . ' minute', $hora);
							   	    }
					      		}
						   	echo '</table>';
						echo '</div>';
					}//do for
			    }//do if
			echo '</div>';
			 ?>    	
	    </table> 	  
   	</form>
  </BODY>
</HTML>