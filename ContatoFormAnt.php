<?php 
   //prepara consulta para montar a lista de relacoes
   require "comum.php";
   //echo 'In-'. $_REQUEST[Operacao];
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
	// preparacao das listas a serem apresentadas    		
    if (!$SetTipoRelacao = mysql_query('SELECT * from Tipo_Relacionamento order by NM_Tipo_Relacao')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Relacionamento: ' . mysql_error() .'<br></a>';
    	die();
    }
	/*    //echo mysql_num_rows($SetTipoRelacao);
    if (!$SetTipoEndereco = mysql_query('SELECT * from Tipo_Endereco order by NM_Tipo_Endereco')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Endereço: ' . mysql_error() .'<br></a>';
    	die();
    }
    if (!$SetUF = mysql_query('SELECT * from UF order by CD_UF')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta UF: ' . mysql_error() .'<br></a>';
    	die();
    }
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
    // Preparacao para Emails
    if (!$SetTipoEmail = mysql_query('SELECT * from Tipo_Email order by NM_Tipo_Email')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Email: ' . mysql_error() .'<br></a>';
    	die();
    }
    */
    
    require "ContatoClasse.php";
    $ObjContato = new Contato();
    $arrRelacoes = $_REQUEST['TP_Relacao'];
    $REQ_SQ_Contato = $_REQUEST[SQ_Contato];
    
    // Alterar Contato
    if ($_REQUEST[Operacao] == "Mostrar Contato" and $REQ_SQ_Contato) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	//echo 'Altera';
    	$ObjContato->SQ_Contato = $REQ_SQ_Contato;
    	if (!$ObjContato->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
    	else {
    		// echo 'achei registro...' .  mysql_result($ObjConvenio->Regs,0,NM_Convenio) . '...' . $MsgErro ;
    		 
    		$_REQUEST[NM_Contato] =  mysql_result($ObjContato->Regs,0,NM_Contato);
    		$_REQUEST[DT_Nascimento] = implode('/',array_reverse(explode('-',mysql_result($ObjContato->Regs,0,DT_Nascimento))));
    		$_REQUEST[Identificacao] = mysql_result($ObjContato->Regs,0,Identificacao);
    		$_REQUEST[Observacoes] = mysql_result($ObjContato->Regs,0,Observacoes);
    		//recupera relacoes
    		if (!$SetRelacoes = mysql_query('SELECT * ' .
    				' from Relacionamento ' .
    				' where SQ_Contato = ' . $REQ_SQ_Contato )){
    				echo '<a class="MsgErro">Não foi possível efetuar consulta aos Relacionamento: ' .
    						mysql_error() .'<br></a>';
    				//die();
    		}else
    			//Monta array com as relacoes do contato para apresentar na checkbox
    			while ($RegRelacoes = mysql_fetch_array($SetRelacoes))
    				$arrRelacoes[$RegRelacoes['TP_Relacao']] = "on";
    		
    		//echo 'Relações';
    		//foreach ($arrRelacoes as $i => $value) 
    			//print_r('/' . $arrRelacoes[$i] . $i);
    	}
    }
    
    // Inserir Contato
    if ($_REQUEST[Operacao] == "Inserir Contato"){  // Clicou botao inserir - insere
	    //Inserir Contato  
		$ObjContato->NM_Contato = $_REQUEST[NM_Contato];
		$ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
		$ObjContato->Identificacao = $_REQUEST[Identificacao];
		$ObjContato->Observacoes = $_REQUEST[Observacoes];
		if (!$ObjContato->insert($MsgErro)){
		    echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
		 //   die();
		}
		else {
		   echo '<a class="MsgSucesso">Contato Incluido com sucesso!</a>';
    
			$_REQUEST[SQ_Contato] = $ObjContato->SQ_Contato;
			//inserindo Relacoes do contato
			mysql_data_seek($SetTipoRelacao, 0);	
			while ($tipos = mysql_fetch_array($SetTipoRelacao))
		   		if  ($arrRelacoes[$tipos['TP_Relacao']] == "on"){
		   			$ObjContato->TP_Relacao = $tipos['TP_Relacao'];
		   			if (!$ObjContato->insertRelacoes($MsgErro))
		   				echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
		   			else
		   				echo '<a class="MsgSucesso">Relação ' . $ObjContato->TP_Relacao . ' incluida com sucesso!</a>';
		   		}
		}
   	}
    
   	// Alterando Contao
    if ($_REQUEST['Operacao'] == "Alterar Contato"){ // Clicou botao alterar - alterar
    	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
	    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
	    $ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
	    $ObjContato->Identificacao = $_REQUEST[Identificacao];
	    $ObjContato->Observacoes = $_REQUEST[Observacoes];
	    //echo 'j' .$ObjContato->Identificacao . $ObjContato->Observacoes . $ObjContato->NM_Contato;
	    if (!$ObjContato->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração Contato: ' . $MsgErro .'</a>';
	    else {
	       	echo '<a class="MsgSucesso">Alteração Contato com sucesso!</a>';
	    	//Alterando Relacionamentos
	    	mysql_data_seek($SetTipoRelacao, 0);
	    	while ($TiposRel = mysql_fetch_array($SetTipoRelacao)){
	    		//echo 'tipo='. $TiposRel[TP_Relacao] . '-'. $arrRelacoes[$TiposRel[TP_Relacao]] .'/';
	    		$ObjContato->TP_Relacao = $TiposRel[TP_Relacao];
	    		if  ($arrRelacoes[$TiposRel[TP_Relacao]] == "on"){
	    			if (!$ObjContato->insertRelacoes($MsgErro))
	    				echo '<a class="MsgErro">Erro na inserção de Relacionamento: ' . $TiposRel[NM_Relacao] . ' ' . $MsgErro .'<br></a>';
	    			else
	    				echo '<a class="MsgSucesso">Relacao Incluida com sucesso!' . $TiposRel[NM_Relacao] . '<br></a>';
	    			//echo 'i-' . $TiposRel[TP_Relacao];
	    		}
	    		else{
	    			if (!$ObjContato->DeleteRelacoes($MsgErro))
	    				echo '<a class="MsgErro">Erro na exclusão de relacionamento: ' . $TiposRel[NM_Relacao] . ' '. $MsgErro .'<br></a>';
	    			else
	    				echo '<a class="MsgSucesso">Relacao Excluida com sucesso!'. $TiposRel[NM_Relacao] . '<br></a>';
	    		//echo 'd-' . $TiposRel[TP_Relacao];
	    		}
	    	}
	    }
	}
    
    /*
    
    if ($_REQUEST[Operacao] == 'Inserir Telefone' && $_SESSION[SQ_Contato] > 0){
   		echo 'Inserindo Telefone';
   		require "TelefoneClasse.php";
   		$ObjTelefone = new Telefone();
   		$ObjTelefone->SQ_Contato    = $_SESSION[SQ_Contato];
	    $ObjTelefone->NR_Telefone   = $_REQUEST[NR_Telefone];
	    $ObjTelefone->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
	    $ObjTelefone->TP_Uso        = $_REQUEST[TP_Uso];
	    $ObjTelefone->CD_DDD        = $_REQUEST[CD_DDD];
	    $ObjTelefone->SQ_Operadora  = $_REQUEST[SQ_Operadora];

	    echo 't' . $ObjTelefone->NR_Telefone;
	    if (!$ObjTelefone->Insert($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na Inserçao do Telefone: ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Telefone incluido Telefone com sucesso!</a>';
	    }		
    		 
    }
   */
    /* 
    if ($_REQUEST[Operacao] == 'Inserir Email' && $_SESSION[SQ_Contato] > 0){
    	echo 'Inserindo Email';
    	require "EmailClasse.php";
    	$ObjEmail = new Email();
    	$ObjEmail->SQ_Contato  = $_SESSION[SQ_Contato];
    	$ObjEmail->TP_Email    = $_REQUEST[TP_Email];
    	$ObjEmail->Email       = $_REQUEST[Email];
    	
    	if (!$ObjEmail->Insert($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na Inserção do Email: ' . $MsgErro .'</a>';
    	else {
    		//mysql_query("commit");
    		echo '<a class="MsgSucesso">Email inserido com sucesso!</a>';
    	}    	 
    }
    */
        
?>
<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
    <form method="post" action="">
    	<fieldset>
       		<legend> <?php if (!$REQ_SQ_Contato) echo "Inserindo "; else echo "Alterando ";?> Contato</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Contato" size="50" autofocus value ="<?php echo $_REQUEST[NM_Contato]?>">&nbsp
    		<label>Relacão: </label>
    		<?php
	    		while ($RegTiposRel = mysql_fetch_array($SetTipoRelacao)){ //Apresenta todos os TiposRel
	    			echo '<input type="checkbox" class="Entrada" name="TP_Relacao[' . $RegTiposRel[TP_Relacao] . ']"';
	    			if ($arrRelacoes[$RegTiposRel['TP_Relacao']] == 'on') 
	    				echo 'checked';
	    			echo  '>' . $RegTiposRel[NM_Tipo_Relacao] . '&nbsp&nbsp';	
	    		}	
     		?>
     		<br>
    		<label class="labelNormal">Nascimento:</label>
    		<input class="Entrada" type="date" name="DT_Nascimento" size="10" value="<?php echo $_REQUEST[DT_Nascimento]?>"><br>
    		<label class="labelNormal">Identificação: </label>
    		<input class="Entrada" type="text" name="Identificacao" size="50" value ="<?php echo $_REQUEST[Identificacao]?>"><BR>
    		<label class="labelNormal">Observações: </label>
    		<textarea rows="3" cols="100" class="Entrada" name="Observacoes" size="100" ><?php echo $_REQUEST[Observacoes]?></textarea><BR>    		
    		<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    		<!--  <INPUT class="linkVoltar" type="button" VALUE="Voltar" onClick="history.go(-1);return true;">-->
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$REQ_SQ_Contato) echo 'Inserir Contato'; else echo 'Alterar Contato';?>">
    	    &nbsp--- * Insira primeiramente o Contato. Depois insira endereços, telefones e emails * ---<br><br>
    	    <input type="hidden" name="SQ_Contato" size="10" value="<?php echo $_REQUEST[SQ_Contato]?>">
    	    <?php
			 if ($_REQUEST[SQ_Contato]){
    	    	echo '<a class="linkInserirNovo" type="button" href="EnderecoForm.php?SQ_Contato=' . 
								$_REQUEST[SQ_Contato] . '&NM_Contato=' . urlencode($_REQUEST[NM_Contato]) . '">Inserir Endereço</a>';
		    	echo '<a class="linkInserirNovo" type="button" href="TelefoneForm.php?SQ_Contato=' . 
								$_REQUEST[SQ_Contato] . '&NM_Contato=' . urlencode($_REQUEST[NM_Contato]) . '">Inserir Telefone</a>';
		    	echo '<a class="linkInserirNovo" type="button" href="EmailForm.php?SQ_Contato=' . 
								$_REQUEST[SQ_Contato] . '&NM_Contato=' . urlencode($_REQUEST[NM_Contato]) . '">Inserir E-mail</a>';
    	    }
			?>
    	</fieldset>
    	<br>
    	<?php
	    	// Listar Detalhes do Contato
    		$Query =  'Select * from Contato where SQ_Contato = ' . (int)$REQ_SQ_Contato;
 
 	   		if (!$ListaContatos = mysql_query($Query)){
    			echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
    			die();
    		}
    		require "ContatoDetalhes.inc.php";
    		mysql_close($con);
		?>

 	<!--  
    	<fieldset>
    		<legend>Inserindo Telefone</legend>
    		<label class="labelNormal">Operadora: </label>
    		<select name="SQ_Operadora">
    		<?php 
    			//while ($RegOperadora = mysql_fetch_array($SetOperadora))
    			//	echo '<option value="' , $RegOperadora[SQ_Operadora] . '">' . $RegOperadora[NM_Operadora] . '</option>';
    		?>
    		</select>
    		
    		<label>Tipo Mobilidade: </label>
    		<select name="TP_Mobilidade">
    		<?php 
    		//	while ($RegTipoMobilidade = mysql_fetch_array($SetTipoMobilidade))
    			//	echo '<option value="' , $RegTipoMobilidade[TP_Mobilidade] . '">' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    		?>
    		</select>
    		<label>Tipo Uso: </label>
    		<select name="TP_Uso">
    		<?php
    			//while ($RegTipoUso = mysql_fetch_array($SetTipoUso))
    				//echo '<option value="' , $RegTipoUso[TP_Uso] . '">' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    		?>
    		</select><br>
    		<label class="labelNormal">DDD: </label>
    		<input class="Entrada" type="text" name="CD_DDD" size="02" autofocus value = "<?php echo $_REQUEST[DDD]?>">
     		<label>Numero: </label>
    		<input class="Entrada" type="text" name="NR_Telefone" size="10" value ="<?php echo $_REQUEST[NumeroFone]?>"><br>
    		<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="Inserir Telefone">
    	</fieldset>
		<br>  	

		<fieldset>
    		<legend>Inserindo Email</legend>
    		<label class="labelNormal">Tipo Email: </label>
    		<select class="Entrada" name="TP_Email">
    		<?php
//    			while ($RegTipoEmail = mysql_fetch_array($SetTipoEmail))
  //  				echo '<option value="' , $RegTipoEmail[TP_Email] . '">' . $RegTipoEmail[NM_Tipo_Email] . '</option>';
    		?>
    		</select>
    		<label>Email: </label>
    		<input type="text" name="Email" size="50" autofocus value = "<?php echo $_REQUEST[Email] ?>"><br>
    		<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	   <input class="Envia" type="submit" name="Operacao" value="Inserir Email">
    	</fieldset>
   	-->
    </form>
  </BODY>
</HTML>