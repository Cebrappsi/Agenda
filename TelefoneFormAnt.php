<?php 
   require "comum.php";
   //echo 'In-'. $_REQUEST[Operacao];
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
	// preparacao das listas a serem apresentadas    		
    if (!$SetTipoEndereco = mysql_query('SELECT * from Tipo_Endereco order by NM_Tipo_Endereco')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Endereço: ' . mysql_error() .'<br></a>';
    	die();
    }
    if (!$SetUF = mysql_query('SELECT * from UF order by CD_UF')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta UF: ' . mysql_error() .'<br></a>';
    	die();
    }
/*
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
    
    // Mostrar Contato / Endereco
    require "EnderecoClasse.php";
    $ObjEndereco = new Endereco();
    
    if ($_REQUEST[Operacao] == "Mostrar Endereco") { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	//echo 'Altera E';
    	
    	$ObjEndereco->SQ_Contato = $_REQUEST[SQ_Contato];
    	$ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
    	if (!$ObjEndereco->GetReg($MsgErro)) {
    		echo '<a class="MsgErro">' . 'Erro na busca do Endereco : ' . MsgErro .'</a>';
    	}
    	else{
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
    if ($_REQUEST[Operacao] == 'Inserir Endereco'){ //Inserir Endereço
    	//echo 'Inserindo endereço';
    	$ObjEndereco->SQ_Contato = $_REQUEST[SQ_Contato];
    	$ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
    	$ObjEndereco->Rua = $_REQUEST[Rua];
    	$ObjEndereco->Numero = $_REQUEST[Numero];
    	$ObjEndereco->Complemento = $_REQUEST[Complemento];
    	$ObjEndereco->Bairro = $_REQUEST[Bairro];
    	$ObjEndereco->Cidade = $_REQUEST[Cidade];
    	$ObjEndereco->CD_UF = $_REQUEST[CD_UF];
    	$ObjEndereco->CEP = $_REQUEST[CEP];
    	if (!$ObjEndereco->insert($MsgErro)){
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    		unset($_REQUEST[TP_Endereco]);
    	}
    	else{
    		echo '<a class="MsgSucesso">Endereço Incluido com sucesso!</a>';
    		unset($_REQUEST[TP_Endereco]);
    	}
    }
    if ($_REQUEST[Operacao] == 'Alterar Endereco'){ //Inserir Endereço
    	$ObjEndereco->SQ_Contato  = $_REQUEST[SQ_Contato];
    	$ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
    	$ObjEndereco->Rua         = $_REQUEST[Rua];
    	$ObjEndereco->Numero      = $_REQUEST[Numero];
    	$ObjEndereco->Complemento = $_REQUEST[Complemento];
    	$ObjEndereco->Bairro      = $_REQUEST[Bairro];
    	$ObjEndereco->Cidade      = $_REQUEST[Cidade];
    	$ObjEndereco->CD_UF       = $_REQUEST[CD_UF];
    	$ObjEndereco->CEP         = $_REQUEST[CEP];
    	
    	if (!$ObjEndereco->Edit($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na alteração do Endereco: ' . $ObjEndereco->MsgErro .'</a>';
    	else {
    		//mysql_query("commit");
    		echo '<a class="MsgSucesso">Alteração Endereco com sucesso!</a>';
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
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
         label.MostraDados{
			float:left;
			width:40%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:left;
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
    //print_r($_REQUEST); //debug var recebidas
    
    require "comum.php";
    require "ContatoClasse.php";
    $ObjContato = new Contato();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
	//Acesso o registro para preencher os campos
	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    if (!$ObjContato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na busca do contato : ' . MsgErro .'</a>';
	   die();
	}
	//echo mysql_result($ObjContato->Regs,0,SQ_Contato);
	// Preparacao para Área para Telefone
	require "TelefoneClasse.php";
	$ObjTelefone = new Telefone();
	$ObjTelefone->SQ_Contato = $_REQUEST[SQ_Contato];
	$ObjTelefone->NR_Telefone = $_REQUEST[NR_Telefone];
	if (!$ObjTelefone->GetReg($MsgErro)) {
		echo '<a class="MsgErro">' . 'Erro na busca do Telefone : ' . MsgErro .'</a>';
		die();
	}
	
// Preparacao para Área para Telefone/tipo uso, Operadora
	if (!$SetOperadora = mysql_query('SELECT * from Operadora order by NM_Operadora')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Operadora: ' . mysql_error() .'<br></a>';
		die();
	}
    if (!$SetTipoMobilidade = mysql_query('SELECT * from Tipo_Mobilidade order by NM_Tipo_Mobilidade')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Mobilidade: ' . mysql_error() .'<br></a>';
	   	die();
	}
	if (!$SetTipoUso = mysql_query('SELECT * from Tipo_uso order by NM_Tipo_Uso')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Uso: ' . mysql_error() .'<br></a>';
	   	die();
	}
	
    echo '<form method="post" action="TelefoneEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Telefone</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . $_REQUEST[SQ_Contato] . ' size="10" >';
    	   echo '<input type="hidden" name="NR_Telefone" value=' . $_REQUEST[NR_Telefone] . ' size="10" >';
    	   //echo '<label class="labelNormal">Nome: </label>'; 
    	   //echo '<label>' . mysql_result($ObjContato->Regs,0,NM_Contato) . '</label><br><br>';
    	   //echo '<label class="labelNormal">Telefone: </label>'; 
    	   //echo '<label>' . mysql_result($ObjTelefone->Regs,0,NR_Telefone) . '</label><br><br>';
    	   echo '<label class="labelNormal">Nome: </label>';
    	   echo '<label class="MostraDados">' . mysql_result($ObjContato->Regs,0,NM_Contato) . '</label><br><br>';
    	   echo '<label class="labelNormal">Nro Telefone: </label>';
    	   echo '<label class="MostraDados">' . $ObjTelefone->NR_Telefone . '</label><br><br>';
    	   echo '<label class="labelNormal">Operadora: </label>';
    	   echo '<select class="Entrada" name="SQ_Operadora">';
    	   while ($RegOperadora = mysql_fetch_array($SetOperadora)){
    	   	 if ($RegOperadora[SQ_Operadora] == mysql_result($ObjTelefone->Regs,0,SQ_Operadora))
    	   		echo '<option selected  value=' , $RegOperadora[SQ_Operadora] . '>' . $RegOperadora[NM_Operadora] . '</option>';
    	     else 
    	     	echo '<option           value=' , $RegOperadora[SQ_Operadora] . '>' . $RegOperadora[NM_Operadora] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Tipo Mobilidade: </label>';
    	   echo '<select name="TP_Mobilidade">';
    	   while ($RegTipoMobilidade = mysql_fetch_array($SetTipoMobilidade)){
    	   	 if ($RegTipoMobilidade[TP_Mobilidade] == mysql_result($ObjTelefone->Regs,0,TP_Mobilidade))
    	   		echo '<option selected  value=' , $RegTipoMobilidade[TP_Mobilidade] . '>' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    	     else 
    	     	echo '<option           value=' , $RegTipoMobilidade[TP_Mobilidade] . '>' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Tipo Uso: </label>';
    	   echo '<select name="TP_Uso">';
    	   while ($RegTipoUso = mysql_fetch_array($SetTipoUso)){
    	   	 if ($RegTipoUso[TP_Uso] == mysql_result($ObjTelefone->Regs,0,TP_Uso))
    	   		echo '<option selected  value=' , $RegTipoUso[TP_Uso] . '>' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    	     else 
    	     	echo '<option           value=' , $RegTipoUso[TP_Uso] . '>' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">DDD: </label>';
    	   echo '<input class="Entrada" type="text" name="CD_DDD" size="2" value ="' . mysql_result($ObjTelefone->Regs,0,CD_DDD) . '"><BR>';   
    	echo '</fieldset>';
    	echo '<a class="linkVoltar" href="Contato.php">Voltar</a>';
        echo '<input class="Envia" type="submit" name="submit" value="Alterar"/>';
    echo '</form>';
    	  
    echo '<br>';
    
    if(empty($_POST['submit']))
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder altera��o
    //echo ('Alterando');
    /*
    
    */
    $ObjTelefone->SQ_Contato    = $_REQUEST[SQ_Contato];
    $ObjTelefone->NR_Telefone   = $_REQUEST[NR_Telefone];
    $ObjTelefone->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    $ObjTelefone->TP_Uso        = $_REQUEST[TP_Uso];
    $ObjTelefone->CD_DDD        = $_REQUEST[CD_DDD];
    $ObjTelefone->SQ_Operadora  = $_REQUEST[SQ_Operadora];
        
    if (!$ObjTelefone->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração do Telefone: ' . $ObjTelefone->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração Telefone com sucesso!</a>';
    }
    
    //header("Location: Contato.php
    
    mysql_close($con);
    //echo 'SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato);
    
    ?>
  </BODY>
</HTML>
