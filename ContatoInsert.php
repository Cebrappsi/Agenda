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
	    		
	    if (!$SetTipoContado = mysql_query('SELECT * from Tipo_Relacionamento order by NM_Tipo_Relacao')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Contato: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($SetTipoContado);
	?>

    <form method="post" action="ContatoInsert.php">
    	<fieldset>
    		<legend>Inserindo Contato</legend>
    		<label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Contato" size="50" autofocus value = ' .
    								 $_POST[NM_Contato] . '>';
    		echo '<label>Tipo Contato: </label>';
    		while ($dados = mysql_fetch_array($SetTipoContado))
    			echo '<input type="checkbox" class="Entrada" name="TP_Relacao[' . $dados[TP_Relacao] .  "]" .'">' . 
    								$dados[NM_Tipo_Relacao] .'&nbsp&nbsp';
     		echo '<br>';
    		echo '<label class="labelNormal">Nascimento:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Nascimento" size="10" value=' . 
    								$_POST[DT_Nascimento] . '>';
    		echo '<br>';
    		echo '<label class="labelNormal">Identificacao: </label>';
    		echo '<input class="Entrada" type="text" name="Identificacao" size="50" value = ' . 
    								$_POST[Identificacao] . '><BR>';
    		echo '<label class="labelNormal">Observacoes: </label>';
    		echo '<textarea rows="3" cols="100" class="Entrada" name="Observacoes" size="100" >' . 
    								$_POST[Observacoes] . '</textarea>';    		
    		?>
    	</fieldset>
    	<a class="linkVoltar" href="Contato.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    	<?php
    	if (!$SetEndereco = mysql_query('SELECT * from Tipo_Endereco order by NM_Tipo_Endereco')){
    		echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Endereço: ' . mysql_error() .'<br></a>';
    		die();
    	}
    	
    	// Preparacao para Área para Endereço
    	if (!$SetTipoEndereco = mysql_query('SELECT * from Tipo_Endereco order by NM_Tipo_Endereco')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Endereço: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    if (!$SetUF = mysql_query('SELECT * from UF order by CD_UF')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta UF: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    ?>
    	<fieldset>
    		<legend>Inserindo Endereço</legend>
    		<?php 
    		echo '<label class="labelNormal">Tipo Endereço: </label>';
    		while ($dados = mysql_fetch_array($SetTipoEndereco))
    			echo '<input type="checkbox" class="Entrada" name="TP_Endereco[' . $dados[TP_Endereco] .  "]" . '">' . 
    								$dados[NM_Tipo_Endereco] .'&nbsp&nbsp';
    		
    		echo '<br>';
    		echo '<label class="labelNormal">Rua: </label>';
    		echo '<input class="Entrada" type="text" name="Rua" size="50" autofocus value = "' . $_POST[Rua] . '">';
     		echo '<label class="LabelNormal">Numero: </label>';
    		echo '<input class="Entrada" type="text" name="Numero" size="10" value ="' . $_POST[Numero] . '"><br>';
    		echo '<label class="labelNormal">Complemento: </label>';
    		echo '<input class="Entrada" type="text" name="Complemento" size="50" value ="' . $_POST[Complemento] . '"><BR>';
    		echo '<label class="labelNormal">Bairro: </label>';
    		echo '<input class="Entrada" name="Bairro" size="50" value ="' . $_POST[Bairro] . '"><br>';
    		echo '<label class="labelNormal">Cidade: </label>';
    		echo '<input class="Entrada" name="Cidade" size="50" value = "' . $_POST[Cidade] . '"><br>';
    		echo '<label class="labelNormal">UF: </label>';
    		echo '<select class="Entrada" name="CD_UF">';
    		while ($RegUF = mysql_fetch_array($SetUF))
    			echo '<option value="' , $RegUF[CD_UF] . '">' . $RegUF[NM_UF] . '</option>';
    		echo '</select>';
    		echo '<label>CEP: </label>';
    		echo '<input class="Entrada" name="CEP" size="10" value = ' . $_POST[CEP] . '><br>';
    		?>
    	</fieldset>
    	<?php 
    	// Preparacao para Área para Telefone/tipo uso, Operadora
    	if (!$SetTipoMobilidade = mysql_query('SELECT * from Tipo_Mobilidade order by NM_Tipo_Mobilidade')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Mobilidade: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    if (!$SetTipoUso = mysql_query('SELECT * from Tipo_uso order by NM_Tipo_Uso')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Uso: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    if (!$SetOperadora = mysql_query('SELECT * from Operadora order by NM_Operadora')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Operadora: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    ?>
    	<fieldset>
    		<legend>Inserindo Telefone</legend>
    		<?php 
    		echo '<label class="labelNormal">Operadora: </label>';
    		echo '<select name="SQ_Operadora">';
    		while ($RegOperadora = mysql_fetch_array($SetOperadora))
    			echo '<option value="' , $RegOperadora[SQ_Operadora] . '">' . $RegOperadora[NM_Operadora] . '</option>';
    		echo '</select>';
    		
    		echo '<label>Tipo Mobilidade: </label>';
    		echo '<select name="TP_Mobilidade">';
    		while ($RegTipoMobilidade = mysql_fetch_array($SetTipoMobilidade))
    			echo '<option value="' , $RegTipoMobilidade[TP_Mobilidade] . '">' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    		echo '</select>';
    		
    		echo '<label>Tipo Uso: </label>';
    		echo '<select name="TP_Uso">';
    		while ($RegTipoUso = mysql_fetch_array($SetTipoUso))
    			echo '<option value="' , $RegTipoUso[TP_Uso] . '">' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    		echo '</select><br>';
    		
    		echo '<label class="labelNormal">DDD: </label>';
    		echo '<input class="Entrada" type="text" name="DDD" size="02" autofocus value = "' . $_POST[DDD] . '">';
     		echo '<label>Numero: </label>';
    		echo '<input class="Entrada" type="text" name="Numero" size="10" value ="' . $_POST[Numero] . '"><br>';
    		?>
    	</fieldset>
    	
    	<?php 
    	// Preparacao para Área para Emaila
    	if (!$SetTipoEmail = mysql_query('SELECT * from Tipo_Email order by NM_Tipo_Email')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Email: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    
	    ?>
    	<fieldset>
    		<legend>Inserindo Email</legend>
    		<?php 
    		echo '<label class="labelNormal">Tipo Email: </label>';
    		echo '<select class="Entrada" name="TP_Email">';
    		while ($RegTipoEmail = mysql_fetch_array($SetTipoEmail))
    			echo '<option value="' , $RegTipoEmail[TP_Email] . '">' . $RegTipoEmail[NM_Tipo_Email] . '</option>';
    		echo '</select>';
    		echo '<label>Email: </label>';
    		echo '<input type="text" name="Email" size="50" autofocus value = "' . $_POST[Email] . '"><br>';
    		?>
    	</fieldset>
    
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
    /*
    //print_r($_REQUEST);
    $artipo = $_REQUEST[TP_Relacao];
    mysql_data_seek($SetTipoContato, 0);
    while ($tipos = mysql_fetch_array($SetTipoContato)){
    	//echo 'tipo='. $tipos[TP_Relacao] . '-'. $artipo[$tipos[TP_Relacao]] .'/';
    	if  ($artipo[$tipos[TP_Relacao]] == "on"){
    		$ObjContato->TP_Relacao = $tipos[TP_Relacao];
    		//echo $tipos[TP_Relacao];
    	}
    } 
    */  
    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
    $ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
    $ObjContato->Identificacao = $_REQUEST[Identificacao];
    $ObjContato->Observacoes = $_REQUEST[Observacoes];
    if (!$ObjContato->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjContato->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Contato Incluido com sucesso!</a>';
    
    //inserindo Papeis do contato
    $artipo = $_REQUEST[TP_Relacao];
    mysql_data_seek($SetTipoContado, 0);
    while ($tipos = mysql_fetch_array($SetTipoContado)){
    	//echo 'tipo='. $tipos[TP_Relacao] . '-'. $artipo[$tipos[TP_Relacao]] .'/';
    	if  ($artipo[$tipos[TP_Relacao]] == "on"){
    		$ObjContato->TP_Relacao = $tipos[TP_Relacao];
    		//echo $tipos[TP_Relacao];
    		if (!$ObjContato->insertPapel($Con,$MsgErro))
    			echo '<a class="MsgErro">Erro na inserção: ' . $ObjContato->MsgErro .'<br></a>';
    		else
    			echo '<a class="MsgSucesso">Contato Incluido com sucesso!</a>';
    	}
    }
    
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>
