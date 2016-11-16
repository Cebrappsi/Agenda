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
			width:10%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
  <?php 
		//prepara consulta convenio para montar a lista
	 	require "comum.php";
	    		
	    if (!conecta_BD($con,$MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	    	die();
	    }
	    		
	    if (!$consulta = mysql_query('SELECT * from Tipo_Contato order by NM_Tipo_Contato')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Contato: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($consulta);
	?>

    <form method="post" action="ContatoInsert.php">
    	<fieldset>
    		<legend>Inserindo Contato</legend>
    		<label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Contato" size="50" autofocus value = ' . $_POST[NM_Contato] . '><BR><br>';
    		echo '<label class="labelNormal">Tipo Contato: </label>';
    		while ($dados = mysql_fetch_array($consulta))
    			echo '<input type="checkbox" class="Entrada" name="TP_Contato[' . $dados[TP_Contato] .  "]" . '">' . $dados[NM_Tipo_Contato] .'&nbsp&nbsp';
     		echo '<br><br>';
    		echo '<label class="labelNormal">Data de Nascimento:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Nascimento" size="10" value=' . $_POST[DT_Nascimento] . '><br><br>';
    		echo '<label class="labelNormal">Identificacao: </label>';
    		echo '<input class="Entrada" type="text" name="Identificacao" size="50" value = ' . $_POST[Identificacao] . '><BR><br>';
    		echo '<label class="labelNormal">Observacoes: </label>';
    		echo '<textarea rows="4" cols="100" class="Entrada" name="Observacoes" size="100" >' . $_POST[Observacoes] . '</textarea>';    		
    		?>
    	</fieldset>
    
    	<a class="linkVoltar" href="Contato.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[SQ_Contato]) && !isset($_REQUEST[NM_Contato]))
        die();
    
    require "ContatoClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjContato->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjContato = new Contato();
    //print_r($_REQUEST);
       
    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
    $artipo = $_REQUEST[TP_Contato];
    mysql_data_seek($consulta, 0);
    while ($tipos = mysql_fetch_array($consulta)){
    	//echo 'tipo='. $tipos[TP_Contato] . '-'. $artipo[$tipos[TP_Contato]] .'/';
    	if  ($artipo[$tipos[TP_Contato]] == "on"){
    		$ObjContato->TP_Contato = $tipos[TP_Contato];
    		//echo $tipos[TP_Contato];
    	}
    }
    $ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
    $ObjContato->Identificacao = $_REQUEST[Identificacao];
    $ObjContato->Observacoes = $_REQUEST[Observacoes];
    if (!$ObjContato->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjContato->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
