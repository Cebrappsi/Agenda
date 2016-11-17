<?php 
   require "comum.php";
   //echo 'In-'. $_REQUEST[Operacao];
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
	// preparacao das listas a serem apresentadas    		
    // Preparacao para �rea para Telefone/tipo uso, Operadora
    if (!$SetTipoMobilidade = mysql_query('SELECT * from Tipo_Mobilidade order by NM_Tipo_Mobilidade')){
    	echo '<a class="MsgErro">N�o foi poss�vel efetuar consulta Tipo Mobilidade: ' . mysql_error() .'<br></a>';
    	die();
    }
    if (!$SetTipoUso = mysql_query('SELECT * from Tipo_uso order by NM_Tipo_Uso')){
    	echo '<a class="MsgErro">N�o foi poss�vel efetuar consulta Tipo Uso: ' . mysql_error() .'<br></a>';
    	die();
    }
    if (!$SetOperadora = mysql_query('SELECT * from Operadora order by NM_Operadora')){
    	echo '<a class="MsgErro">N�o foi poss�vel efetuar consulta Operadora: ' . mysql_error() .'<br></a>';
    	die();
    }
/*
    // Preparacao para Emails
    if (!$SetTipoEmail = mysql_query('SELECT * from Tipo_Email order by NM_Tipo_Email')){
    	echo '<a class="MsgErro">N�o foi poss�vel efetuar consulta Tipo Email: ' . mysql_error() .'<br></a>';
    	die();
    }
    */
    
    // Mostrar Contato / Telefone
    require "TelefoneClasse.php";
   	$ObjTelefone = new Telefone();
      	
    if ($_REQUEST[Operacao] == "Mostrar Telefone") { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	//echo 'Altera E';
    	
    	$ObjTelefone->SQ_Contato = $_REQUEST[SQ_Contato];
    	$ObjTelefone->NR_Telefone = $_REQUEST[NR_Telefone];
    	if (!$ObjTelefone->GetReg($MsgErro)) {
    		echo '<a class="MsgErro">' . 'Erro na busca do Telefone : ' . $MsgErro .'</a>';
    	}
    	else{
    		$_REQUEST[TP_Mobilidade]         = mysql_result($ObjTelefone->Regs,0,TP_Mobilidade);
    		$_REQUEST[TP_Uso]      = mysql_result($ObjTelefone->Regs,0,TP_Uso);
    		$_REQUEST[CD_DDD] = mysql_result($ObjTelefone->Regs,0,CD_DDD);
    		$_REQUEST[SQ_Operadora]      = mysql_result($ObjTelefone->Regs,0,SQ_Operadora);
    	} 
    }	
    
    
    //inserindo Telefone             
    if ($_REQUEST[Operacao] == 'Inserir Telefone'){ //Inserir Endere�o
    	echo 'Inserindo Telefone';
   		$ObjTelefone->SQ_Contato    = $_REQUEST[SQ_Contato];
	    $ObjTelefone->NR_Telefone   = $_REQUEST[NR_Telefone];
	    $ObjTelefone->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
	    $ObjTelefone->TP_Uso        = $_REQUEST[TP_Uso];
	    $ObjTelefone->CD_DDD        = $_REQUEST[CD_DDD];
	    $ObjTelefone->SQ_Operadora  = $_REQUEST[SQ_Operadora];

	    echo 't' . $ObjTelefone->NR_Telefone;
	    if (!$ObjTelefone->Insert($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na Inser�ao do Telefone: ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Telefone incluido Telefone com sucesso!</a>';
	    }		
	    unset($_REQUEST[NR_Telefone]);
    }
    
    if ($_REQUEST[Operacao] == 'Alterar Telefone'){ //Inserir Endere�o
    	$ObjTelefone->SQ_Contato    = $_REQUEST[SQ_Contato];
    	$ObjTelefone->NR_Telefone   = $_REQUEST[NR_Telefone];
    	$ObjTelefone->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    	$ObjTelefone->TP_Uso        = $_REQUEST[TP_Uso];
    	$ObjTelefone->CD_DDD        = $_REQUEST[CD_DDD];
    	$ObjTelefone->SQ_Operadora  = $_REQUEST[SQ_Operadora];
    	
    	if (!$ObjTelefone->Edit($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na altera��o do Telefone: ' . $ObjTelefone->MsgErro .'</a>';
    	else {
    		//mysql_query("commit");
    		echo '<a class="MsgSucesso">Altera��o Telefone com sucesso!</a>';
    	}
    }
    
    /* 
    if ($_REQUEST[Operacao] == 'Inserir Email' && $_SESSION[SQ_Contato] > 0){
    	echo 'Inserindo Email';
    	require "EmailClasse.php";
    	$ObjEmail = new Email();
    	$ObjEmail->SQ_Contato  = $_SESSION[SQ_Contato];
    	$ObjEmail->TP_Email    = $_REQUEST[TP_Email];
    	$ObjEmail->Email       = $_REQUEST[Email];
    	
    	if (!$ObjEmail->Insert($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na Inser��o do Email: ' . $MsgErro .'</a>';
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
		 label.labelLongo{
			float:left;
			width:30%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
    </style>
  </HEAD>
  <BODY>
	<form method="post" action="">
	<fieldset>
			<legend> <?php if (!$_REQUEST[NR_Telefone]) echo "Inserindo "; else echo "Alterando ";?> Telefone</legend>
    		<label class="labellongo">Nome: <?php echo $_REQUEST[NM_Contato]?></label>
    		<?php 
    			if (!$_REQUEST[NR_Telefone]){
    				echo '<label class="labelNormal">Nro Telefone: </label>';
    				echo '<input class="Entrada" type="text" name="NR_Telefone" size="9" value ="' . $_REQUEST[NR_Telefone] . '"><BR>';
    			}else 
    				echo '<label class="labelNormal">Nro Telefone: ' . $_REQUEST[NR_Telefone] . '</label>';
    			echo '<br>';
    		?>
    	</fieldset>
    	<br>
    	<fieldset>
    	   <label class="labelNormal">Operadora: </label>
    	   <select class="Entrada" name="SQ_Operadora">
    	   <?php 
    	   		while ($RegOperadora = mysql_fetch_array($SetOperadora)){
    	   	 		if ($RegOperadora[SQ_Operadora] == $_REQUEST[SQ_Operadora])
    	   				echo '<option selected  value=' , $RegOperadora[SQ_Operadora] . '>' . $RegOperadora[NM_Operadora] . '</option>';
    	     		else 
    	     			echo '<option           value=' , $RegOperadora[SQ_Operadora] . '>' . $RegOperadora[NM_Operadora] . '</option>';
    	   		}
    	   	?> 
    	   </select>
    	   <br><br>
    	   <label class="labelNormal">Tipo Mobilidade: </label>
    	   <select name="TP_Mobilidade">
    	   <?php 
    	   		while ($RegTipoMobilidade = mysql_fetch_array($SetTipoMobilidade)){
    	   	 		if ($RegTipoMobilidade[TP_Mobilidade] == $_REQUEST[TP_Mobilidade])
    	   			echo '<option selected  value=' , $RegTipoMobilidade[TP_Mobilidade] . '>' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    	     	else 
    	     		echo '<option           value=' , $RegTipoMobilidade[TP_Mobilidade] . '>' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    	   		}
    	   	?>
    	   </select>
    	   <br><br>
    	   <label class="labelNormal">Tipo Uso: </label>
    	   <select name="TP_Uso">
    	   <?php 
    	   		while ($RegTipoUso = mysql_fetch_array($SetTipoUso)){
    	   	 		if ($RegTipoUso[TP_Uso] == $_REQUEST[TP_Uso])
    	   				echo '<option selected  value=' , $RegTipoUso[TP_Uso] . '>' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    	     		else 
    	     			echo '<option           value=' , $RegTipoUso[TP_Uso] . '>' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    	   		}
    	   	?>
    	   </select>
    	   <br><br>
    	   <label class="labelNormal">DDD: </label>
    	   <input class="Entrada" type="text" name="CD_DDD" size="2" value ="<?php echo $_REQUEST[CD_DDD] ?> "><BR>
    	   <br>
    	</fieldset>
    	<a class="linkVoltar" href="ContatoForm.php?SQ_Contato=<?php echo $_REQUEST[SQ_Contato]
														. '&Operacao=' . urlencode("Mostrar Contato")?>">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao" value="<?php if (!$_REQUEST[NR_Telefone]) echo 'Inserir Telefone'; else echo 'Alterar Telefone';?>">
    </form>
  	<?php     
    mysql_close($con);
    ?>
  </BODY>
</HTML>