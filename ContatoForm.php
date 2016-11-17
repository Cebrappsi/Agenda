<?php 
   //prepara consulta para montar a lista de relacoes
   require "comum.php";
   echo 'In-'. $_REQUEST[Operacao];
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
    session_start();
    require "ContatoClasse.php";
    $ObjContato = new Contato();
    $arrRelacoes = $_REQUEST['TP_Relacao'];
    $REQ_SQ_Contato = $_REQUEST[SQ_Contato];
    
    // Alterar Contato
    if ($_REQUEST[Operacao] == "Mostrar Contato" and $REQ_SQ_Contato) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	echo 'Altera';
    	$ObjContato->SQ_Contato = $REQ_SQ_Contato;
    	if (!$ObjContato->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
    	else {
    		// echo 'achei registro...' .  mysql_result($ObjConvenio->Regs,0,NM_Convenio) . '...' . $MsgErro ;
    		// echo 'NM_Convenio: ' . mysql_result($ObjConvenio->Regs,0,NM_Convenio);
    		// echo 'DT_Desat: ' . mysql_result($ObjConvenio->Regs,0,DT_Desativacao);
    		$_SESSION[SQ_Contato] = $ObjContato->SQ_Contato; //Salva Contato para outras operacoes
    		echo 'Salvando Contato Alteracao - ' . $_SESSION[SQ_Contato]; 
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
    				die();
    		}
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
		    die();
		}
		else
		   echo '<a class="MsgSucesso">Contato Incluido com sucesso!</a>';
    
		$_SESSION[SQ_Contato] = $ObjContato->SQ_Contato; //Salva Contato para outras operacoes
		echo 'Salvando Contato - Insercao' . $_SESSION[SQ_Contato];
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
    
   	// Alterando Contao
    if ($_REQUEST['Operacao'] == "Alterar Contato"){ // Clicou botao alterar - alterar
    	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
	    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
	    $ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
	    $ObjContato->Identificacao = $_REQUEST[Identificacao];
	    $ObjContato->Observacoes = $_REQUEST[Observacoes];
	    echo 'j' .$ObjContato->Identificacao . $ObjContato->Observacoes . $ObjContato->NM_Contato;
	    if (!$ObjContato->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração Contato: ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Alteração Contato com sucesso!</a>';
	    }
	    
	    $_SESSION[SQ_Contato] = $ObjContato->SQ_Contato; //Salva Contato para outras operacoes
	    echo 'Salvando Contato - ' . $_SESSION[SQ_Contato];
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
	    
	    //header("Location: Contato.php
    }
    
    /*
    if ($_REQUEST[Operacao] == "Mostrar Endereco" and $REQ_SQ_Contato) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	echo 'Altera E';
    	
    	require "EnderecoClasse.php";
    	$ObjEndereco = new Endereco();
    	$ObjEndereco->SQ_Contato = $REQ_SQ_Contato;
    	$REQ_TP_Endereco = $_REQUEST[TP_Endereco];
    	$ObjEndereco->TP_Endereco = $REQ_TP_Endereco;
    	if (!$ObjEndereco->GetReg($MsgErro)) {
    		echo '<a class="MsgErro">' . 'Erro na busca do Endereco : ' . MsgErro .'</a>';
    		die();
    	}
    	else{
    		$_SESSION[SQ_Contato] = $ObjEndereco->SQ_Contato; //Salva Endereço para outras operacoes
    		$_SESSION[TP_Endereco] = $ObjEndereco->TP_Endereco;
    		echo 'Salvando Endereco Alteracao';
    		$_REQUEST[Rua]         = mysql_result($ObjEndereco->Regs,0,Rua);
    		$_REQUEST[Numero]      = mysql_result($ObjEndereco->Regs,0,Numero);
    		$_REQUEST[Complemento] = mysql_result($ObjEndereco->Regs,0,Complemento);
    		$_REQUEST[Bairro]      = mysql_result($ObjEndereco->Regs,0,Bairro);
    		$_REQUEST[Cidade]      = mysql_result($ObjEndereco->Regs,0,Cidade);
    		$_REQUEST[CD_UF]          = mysql_result($ObjEndereco->Regs,0,CD_UF);
    		$_REQUEST[CEP]         = mysql_result($ObjEndereco->Regs,0,CEP);
    	} 
    }	
    
    
    //inserindo Endereço             
    if ($_REQUEST[Operacao] == 'Inserir Endereco' && $_SESSION[SQ_Contato] > 0){ //Inserir Endereço
    	echo 'Inserindo endereço';
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
    	if (!$ObjEndereco->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Endereço Incluido com sucesso!</a>';
    }

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
    mysql_close($con);
    
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
    	<?php
      		echo 'x'. $_REQUEST[Operacao];
      		if ($_REQUEST[Operacao] == "Mostrar Contato" || $_REQUEST[Operacao] == "Inserir Contato" || 
      			$_REQUEST[Operacao] == "Alterar Contato" ){
		?> 
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
    		<label class="labelNormal">Observacoes: </label>
    		<textarea rows="2" cols="100" class="Entrada" name="Observacoes" size="100" ><?php echo $_REQUEST[Observacoes]?></textarea><BR>    		
    		<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$REQ_SQ_Contato) echo 'Inserir Contato'; else echo 'Alterar Contato';?>">
    	    --- *Insira primeiramente o Contato. Depois insira endereços, telefones e emails * ---
    	    <input class="Envia" type="submit" name="Operacao" value="Inserir Endereco">
    	    <input class="Envia" type="submit" name="Operacao" value="Inserir Telefone">
    	    <input class="Envia" type="submit" name="Operacao" value="Inserir Email">
    	    --- *Insira primeiramente o Contato. Depois insira endereços, telefones e emails * ---
    	</fieldset>
    	<br>
    	<?php
      }
      /*
      if ($_REQUEST[Operacao] == "Mostrar Contato" || $_REQUEST[Operacao] == "Inserir Contato" || 
      	  $_REQUEST[Operacao] == "Inserir Endereco" || $_REQUEST[Operacao] == "Alterar Endereco" ||
      	  $_REQUEST[Operacao] == "Mostrar Endereco"	){
      ?>
    	<fieldset>
    		<legend>Inserindo Endereço</legend>
    		<label class="labelNormal">Tipo Endereço: </label>
    		<select name="TP_Endereco">
    		<?php 
    			while ($RegTipoEndereco = mysql_fetch_array($SetTipoEndereco)){
    				
    				if ($_REQUEST[TP_Endereco] == $RegTipoEndereco[TP_Endereco])
    					echo '<option selected value="' . $RegTipoEndereco[TP_Endereco] . '">' . $RegTipoEndereco[NM_Tipo_Endereco] . '</option>';
    				else	
    					echo '<option          value="' . $RegTipoEndereco[TP_Endereco] . '">' . $RegTipoEndereco[NM_Tipo_Endereco] . '</option>';
    			}
    		?>
    		</select>
    		<br>
    		<label class="labelNormal">Rua: </label>
    		<input class="Entrada" type="text" name="Rua" size="50" autofocus value ="<?php echo $_REQUEST[Rua]?>">&nbsp
     		<label class="LabelNormal">Numero: </label>
    		<input class="Entrada" type="text" name="Numero" size="10" value ="<?php echo $_REQUEST[Numero]?>"><br>
    		<label class="labelNormal">Complemento: </label>
    		<input class="Entrada" type="text" name="Complemento" size="50" value ="<?php echO $_REQUEST[Complemento]?>"><BR>
    		<label class="labelNormal">Bairro: </label>
    		<input class="Entrada" name="Bairro" size="50" value ="<?php echo $_REQUEST[Bairro]?>"><br>
    		<label class="labelNormal">Cidade: </label>
    		<input class="Entrada" name="Cidade" size="50" value = "<?php echo $_REQUEST[Cidade]?>">&nbsp
    		<label>UF: </label>
    		<select name="CD_UF">
    		<?php 
    			while ($RegUF = mysql_fetch_array($SetUF)){
    				if ($_REQUEST[CD_UF] == $RegUF[CD_UF])
    					echo '<option selected  value="' , $RegUF[CD_UF] . '">' . $RegUF[NM_UF] . '</option>';
    				else
    					echo '<option           value="' , $RegUF[CD_UF] . '">' . $RegUF[NM_UF] . '</option>';
    			}
    		?>
    		</select>
    		<label>&nbspCEP: </label>
    		<input name="CEP" size="10" pattern="\d{5}-?\d{3}" value =<?php echo $_REQUEST[CEP]?>><br>
    		<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$REQ_SQ_Contato) echo 'Inserir Endereco'; else echo 'Alterar Endereco';?>">
    	</fieldset>
    	<br>  
 	<?php
      }

      if ($_REQUEST[Operacao] == "Mostrar Contato" || $_REQUEST[Operacao] == "Inserir Contato" || 
      	  $_REQUEST[Operacao] == "Inserir Telefone" || $_REQUEST[Operacao] == "Alterar Telefone"){
      ?>
    	<fieldset>
    		<legend>Inserindo Telefone</legend>
    		<label class="labelNormal">Operadora: </label>
    		<select name="SQ_Operadora">
    		<?php 
    			while ($RegOperadora = mysql_fetch_array($SetOperadora))
    				echo '<option value="' , $RegOperadora[SQ_Operadora] . '">' . $RegOperadora[NM_Operadora] . '</option>';
    		?>
    		</select>
    		
    		<label>Tipo Mobilidade: </label>
    		<select name="TP_Mobilidade">
    		<?php 
    			while ($RegTipoMobilidade = mysql_fetch_array($SetTipoMobilidade))
    				echo '<option value="' , $RegTipoMobilidade[TP_Mobilidade] . '">' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    		?>
    		</select>
    		<label>Tipo Uso: </label>
    		<select name="TP_Uso">
    		<?php
    			while ($RegTipoUso = mysql_fetch_array($SetTipoUso))
    				echo '<option value="' , $RegTipoUso[TP_Uso] . '">' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
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
 	<?php
      }
      
      if ($_REQUEST[Operacao] == "Mostrar Contato" || $_REQUEST[Operacao] == "Inserir Contato" || 
      	  $_REQUEST[Operacao] == "Inserir Email" || $_REQUEST[Operacao] == "Alterar Email"){
      ?>
		<fieldset>
    		<legend>Inserindo Email</legend>
    		<label class="labelNormal">Tipo Email: </label>
    		<select class="Entrada" name="TP_Email">
    		<?php
    			while ($RegTipoEmail = mysql_fetch_array($SetTipoEmail))
    				echo '<option value="' , $RegTipoEmail[TP_Email] . '">' . $RegTipoEmail[NM_Tipo_Email] . '</option>';
    		?>
    		</select>
    		<label>Email: </label>
    		<input type="text" name="Email" size="50" autofocus value = "<?php echo $_REQUEST[Email] ?>"><br>
    		<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	   <input class="Envia" type="submit" name="Operacao" value="Inserir Email">
    	</fieldset>
   	<?php
      }
      ?>
    	*/
    </form>
  </BODY>
</HTML>