<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
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
        //session_start();
        //prepara consulta para montar a lista de Profissionais
	 	require "comum.php";
	    		
	    if (!conecta_BD($con,$MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	    	die();
	    }
	    		
	    if (!$SetProfissionais = mysql_query(
	    		'Select distinct Relacionamento.SQ_Contato, Contato.* from Relacionamento ' .
    		              'inner join Contato ' . 
    		              'on Relacionamento.SQ_Contato = Contato.SQ_Contato ' . 
	    		          'Where Relacionamento.TP_Relacao = "R" order by NM_Contato')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Profissionais: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($SetTipoRelacao);
	?>

    <form method="post" action="EscalaInsert.php">
    	<fieldset>
    		<legend>Inserindo Escala</legend>
    		<?php
    		echo '<label class="labelNormal">Profissional: </label>';
    		echo '<select name="SQ_Contato">';
    		while ($RegProfissional = mysql_fetch_array($SetProfissionais))
    			echo '<option value="' , $RegProfissional[SQ_Contato] . '">' . $RegProfissional[NM_Contato] . '</option>';
    		echo '</select>';
    		echo '<br>';
    		echo '<label class="labelNormal">Dt Inicio Escala:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ini_Escala" size="10" value=' .
    				                $_POST[DT_Ini_Escala] . '>';
    		echo '<br>';
    		echo '<label class="labelNormal">Dt Fim Escala:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Fim_Escala" size="10" value=' .
    				                $_POST[DT_Fim_Escala] . '>';
    		echo '<br>';
    		echo '<label class="labelNormal">Dia da Semana:</label>';
    		echo '<input class="Entrada" type="number" name="Dia_Semana" size="1" min="1" max="7" value = ' .
    								 $_POST[Dia_Semana] . '>';
    		echo '<br>';
     		echo '<label class="labelNormal">Intervalo Atend: </label>';
    		echo '<input class="Entrada" type="number" name="Intervalo_Atendimento" min="0" max="15" step="5" value = ' . 
    		                        $_POST[Intervalo_Atendimento] . '>';
     		echo '<br>';
     		echo '<label class="labelNormal">Hora Ini Turno1:</label>';
     		echo '<input class="Entrada" type="time" name="HR_Ini_Turno1" size="5" value=' .
     			                	$_POST[HR_Ini_Turno1] . '>';
     		echo '<br>';
     		echo '<label class="labelNormal">Hora Fim Turno1:</label>';
     		echo '<input class="Entrada" type="time" name="HR_Fim_Turno1" size="5" value=' .
     			                	$_POST[HR_Fim_Turno1] . '>';
     		echo '<br>';
     		echo '<label class="labelNormal">Hora Ini Turno2:</label>';
     		echo '<input class="Entrada" type="time" name="HR_Ini_Turno2" size="5" value=' .
     	                			$_POST[HR_Ini_Turno2] . '>';
     		echo '<br>';
     		echo '<label class="labelNormal">Hora Fim Turno2:</label>';
     		echo '<input class="Entrada" type="time" name="HR_Fim_Turno2" size="5" value=' .
     		                		$_POST[HR_Fim_Turno2] . '>';
     		echo '<br>';
    		?>
    		<a class="linkVoltar" href="Escala.php">Voltar</a>
    	    <input class="Envia" type="submit" value="Inserir Escala" name="Contato">
    	</fieldset>
    </form>	
    	<?php
    
    if (!isset($_POST[SQ_Contato]))
        die();
    
    require "EscalaClasse.php";
    $ObjEscala = new Escala();
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjEscala->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    //print_r($_REQUEST);
    //print_r('<BR>SESSAO RECUPERADA' . $_SESSION[SQ_Contato]);
    //die();
    //Inserir Escala  
	$ObjEscala->SQ_Contato    = $_REQUEST[SQ_Contato];
	$ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
	$ObjEscala->DT_Fim_Escala = $_REQUEST[Dt_Fim_Escala];
	$ObjEscala->Intervalo_Atendimento = $_REQUEST[Intervalo_Atendimento];
	$ObjEscala->Dia_Semana    = $_REQUEST[Dia_Semana];
	$ObjEscala->HR_Ini_Turno1 = $_REQUEST[HR_Ini_Turno1];
    $ObjEscala->HR_Fim_Turno1 = $_REQUEST[HR_Fim_Turno1];
	$ObjEscala->HR_Ini_Turno2 = $_REQUEST[HR_Ini_Turno2];
    $ObjEscala->HR_Fim_Turno2 = $_REQUEST[HR_Fim_Turno2];
	    
	if (!$ObjEscala->insert($Con,$MsgErro)){
	    echo '<a class="MsgErro">Erro na inserção da Escala: ' . $ObjEscala->MsgErro .'<br></a>';
	    die();
	}
	else {
	   echo '<a class="MsgSucesso">Escala Incluido com sucesso!</a>';
	   //$_SESSION[SQ_Contato] = $ObjContato->SQ_Contato;
       //print_r('<BR>SESSAO GUARDADA' . $_SESSION[SQ_Contato]);
	}
	        
    mysql_close($con);
    
    ?>
  </BODY>
</HTML>
