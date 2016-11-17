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
        session_start();
        //prepara consulta para montar a lista de relacoes
	 	require "comum.php";
	    		
	    if (!conecta_BD($con,$MsgErro)){
	    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	    	die();
	    }
	    		
	    if (!$SetTipoRelacao = mysql_query('SELECT * from Tipo_Relacionamento order by NM_Tipo_Relacao')){
	    	echo '<a class="MsgErro">Não foi possível efetuar consulta Relacionamento: ' . mysql_error() .'<br></a>';
	    	die();
	    }
	    //echo mysql_num_rows($SetTipoRelacao);
	?>

    <form method="post" action="ContatoInsert.php">
    	<fieldset>
    		<legend>Inserindo Contato</legend>
    		<label class="labelNormal">Nome: </label>
    		<?php
    		echo '<input class="Entrada" type="text" name="NM_Contato" size="50" autofocus value = ' .
    								 $_POST[NM_Contato] . '>&nbsp';
    		echo '<label>Relacão: </label>';
    		while ($dados = mysql_fetch_array($SetTipoRelacao))
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
    		echo '<textarea rows="2" cols="100" class="Entrada" name="Observacoes" size="100" >' . 
    								$_POST[Observacoes] . '</textarea><BR>';    		
    		?>
    		<a class="linkVoltar" href="Contato.php">Voltar</a>
    	    <input class="Envia" type="submit" value="Inserir Contato" name="Contato">
    	    --- *Insira primeiramente o Contato. Depois insira endereços, telefones e emails * ---
    	</fieldset>
    	
    	<?php
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
    		echo '<select name="TP_Endereco">';
    		while ($RegEndereco = mysql_fetch_array($SetTipoEndereco))
    			echo '<option value="' , $RegEndereco[TP_Endereco] . '">' . $RegEndereco[NM_Tipo_Endereco] . '</option>';
    		echo '</select>';
    		echo '<br>';
    		echo '<label class="labelNormal">Rua: </label>';
    		echo '<input class="Entrada" type="text" name="Rua" size="50" autofocus value = "' . $_POST[Rua] . '">&nbsp';
     		echo '<label class="LabelNormal">Numero: </label>';
    		echo '<input class="Entrada" type="text" name="Numero" size="10" value ="' . $_POST[Numero] . '"><br>';
    		echo '<label class="labelNormal">Complemento: </label>';
    		echo '<input class="Entrada" type="text" name="Complemento" size="50" value ="' . $_POST[Complemento] . '"><BR>';
    		echo '<label class="labelNormal">Bairro: </label>';
    		echo '<input class="Entrada" name="Bairro" size="50" value ="' . $_POST[Bairro] . '"><br>';
    		echo '<label class="labelNormal">Cidade: </label>';
    		echo '<input class="Entrada" name="Cidade" size="50" value = "' . $_POST[Cidade] . '">&nbsp';
    		echo '<label>UF: </label>';
    		echo '<select name="CD_UF">';
    		while ($RegUF = mysql_fetch_array($SetUF))
    			echo '<option value="' , $RegUF[CD_UF] . '">' . $RegUF[NM_UF] . '</option>';
    		echo '</select>';
    		echo '<label>&nbspCEP: </label>';
    		echo '<input name="CEP" size="10" pattern="\d{5}-?\d{3}" value = ' . $_POST[CEP] . '><br>';
    		?>
    		<a class="linkVoltar" href="Contato.php">Voltar</a>
    	    <input class="Envia" type="submit" value="Inserir Endereço" name="Endereco">
    	
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
    		echo '<input class="Entrada" type="text" name="NumeroFone" size="10" value ="' . $_POST[NumeroFone] . '"><br>';
    		?>
    		<a class="linkVoltar" href="Contato.php">Voltar</a>
    	    <input class="Envia" type="submit" value="Inserir Telefone" name="Telefone">
    	
    	</fieldset>
    	
    	<?php 
    	// Preparacao para Emails
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
    		<a class="linkVoltar" href="Contato.php">Voltar</a>
    	   <input class="Envia" type="submit" value="Inserir Email" name="Email">
    	</fieldset>
    
    </form>
    
    <?php	
    if (!isset($_REQUEST[SQ_Contato]) && !isset($_REQUEST[NM_Contato]))
        die();
    
    require "ContatoClasse.php";
    $ObjContato = new Contato();
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjContato->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    print_r($_REQUEST);
    print_r('<BR>SESSAO RECUPERADA' . $_SESSION[SQ_Contato]);
    //die();
    //Inserir Contato
    if ($_REQUEST[Contato] == 'Inserir Contato'){  
	    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
	    $ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
	    $ObjContato->Identificacao = $_REQUEST[Identificacao];
	    $ObjContato->Observacoes = $_REQUEST[Observacoes];
	    if (!$ObjContato->insert($Con,$MsgErro)){
	        echo '<a class="MsgErro">Erro na inserção: ' . $ObjContato->MsgErro .'<br></a>';
	        die();
	    }
	    else {
	       echo '<a class="MsgSucesso">Contato Incluido com sucesso!</a>';
	       $_SESSION[SQ_Contato] = $ObjContato->SQ_Contato;
	       print_r('<BR>SESSAO GUARDADA' . $_SESSION[SQ_Contato]);
	    }
	    
	    //inserindo Relacoes do contato
	    if ($_SESSION[SQ_Contato] > 0){
		    $artipo = $_REQUEST[TP_Relacao];
		    mysql_data_seek($SetTipoRelacao, 0);
		    while ($tipos = mysql_fetch_array($SetTipoRelacao)){
		    	//echo 'tipo='. $tipos[TP_Relacao] . '-'. $artipo[$tipos[TP_Relacao]] .'/';
		    	if  ($artipo[$tipos[TP_Relacao]] == "on"){
		    		$ObjContato->TP_Relacao = $tipos[TP_Relacao];
		    		//echo $tipos[TP_Relacao];
		    		if (!$ObjContato->insertRelacoes($Con,$MsgErro))
		    			echo '<a class="MsgErro">Erro na inserção: ' . $ObjContato->MsgErro .'<br></a>';
		    		else
		    			echo '<a class="MsgSucesso">Relação ' . $ObjContato->TP_Relacao . ' incluida com sucesso!</a>';
		    	}
		    }
	    }
    }

    //inserindo Endereço            Inserir Endereço 
    elseif ($_REQUEST[Endereco] == 'Inserir Endereço' && $_SESSION[SQ_Contato] > 0){
    	echo 'alterando endereço';
    	require "EnderecoClasse.php";
    	$ObjEndereco = new Endereco();
    	$ObjEndereco->SQ_Contato = $_SESSION[SQ_Contato];
    	$ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
    	$ObjEndereco->Rua = $_REQUEST[Rua];
    	$ObjEndereco->Numero = $_REQUEST[Numero];
    	$ObjEndereco->Complemento = $_REQUEST[Complemento];
    	$ObjEndereco->Bairro = $_REQUEST[Bairro];
    	$ObjEndereco->Cidade = $_REQUEST[Cidade];
    	$ObjEndereco->CD_UF = $_REQUEST[CD_UF];
    	$ObjEndereco->CEP = $_REQUEST[CEP];
    	if (!$ObjEndereco->insert($Con,$MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $ObjEndereco->MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Endereço Incluido com sucesso!</a>';
    	 
    }
    elseif ($_REQUEST[Telefone] == 'Inserir Telefone' && $_SESSION[SQ_Contato] > 0){
    	 
    }
    elseif ($_REQUEST[Email] == 'Inserir Email' && $_SESSION[SQ_Contato] > 0){
    	 
    }
    
    mysql_close($con);
    
    ?>
  </BODY>
</HTML>
