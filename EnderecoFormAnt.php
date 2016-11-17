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
    	if (!$ObjEndereco->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Endereço Incluido com sucesso!</a>';
    		
    	unset($_REQUEST[TP_Endereco]);

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
       		<legend> <?php if (!$_REQUEST[TP_Endereco]) echo "Inserindo "; else echo "Alterando ";?> Endereço</legend>
    		<label class="labellongo">Nome: <?php echo $_REQUEST[NM_Contato]?></label>
    		<label class="labelNormal">Tipo: <?php echo $_REQUEST[NM_Tipo_Endereco]?></label>
    		<br>
    	</fieldset>
    	<br>
    	<fieldset>
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
    		<a class="linkVoltar" href="ContatoForm.php?SQ_Contato=<?php echo $_REQUEST[SQ_Contato]
														. '&Operacao=' . urlencode("Mostrar Contato")?>">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$_REQUEST[TP_Endereco]) echo 'Inserir Endereco'; else echo 'Alterar Endereco';?>">
    	</fieldset>
    	<br>  
 	  <?php
 	  
      // Listar Detalhes do Contato
      $Query =  'Select * from Contato where SQ_Contato = ' . (int)$_REQUEST[SQ_Contato];
      
      if (!$ListaContatos = mysql_query($Query)){
      	echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
      	die();
      }
      require "ContatoDetalhes.inc.php";
      mysql_close($con);
      /*
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
    */
      ?>
    
    </form>
  </BODY>
</HTML>