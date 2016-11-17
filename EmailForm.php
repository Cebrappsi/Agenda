<?php
   //print_r($_REQUEST); //debug var recebidas
   
    require "comum.php";
    if (!$con= conecta_BD($MsgErro)) {
	   echo '<a class="MsgErro">' . 'Erro: ' . $MsgErro .'</a>';
	   die();
	}
	
    // Preparacao para Emails
    if (!$SetTipoEmail = mysql_query('SELECT * from Tipo_Email order by NM_Tipo_Email')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Email: ' . mysql_error() .'<br></a>';
    	die();
    }
 
	require "EmailClasse.php";
	$ObjEmail = new Email();
	if ($_REQUEST[Operacao] == "Mostrar Email") { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	//echo 'Mostra';
 	
		$ObjEmail->SQ_Contato = $_REQUEST[SQ_Contato];
		$ObjEmail->TP_Email   = $_REQUEST[TP_Email];
		if (!$ObjEmail->GetReg($MsgErro)) 
			echo '<a class="MsgErro">' . 'Erro na busca do Email : ' . $MsgErro .'</a>';
		else
    	   $_REQUEST[Email] = mysql_result($ObjEmail->Regs,0,Email);
	}

	//inserindo              
    if ($_REQUEST[Operacao] == 'Inserir Email'){ //Inserir Email
    	//echo 'Inserindo e,ao;';
    	$ObjEmail->SQ_Contato = $_REQUEST[SQ_Contato];
    	$ObjEmail->TP_Email = $_REQUEST[TP_Email];
    	$ObjEmail->Email    = $_REQUEST[Email];
    	if (!$ObjEmail->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Email Incluido com sucesso!</a>';
    		
    	unset($_REQUEST[TP_Email]);
    }

	//echo ('Alterando');
    if ($_REQUEST[Operacao] == 'Alterar Email'){ //Alterar Email
    	$ObjEmail->SQ_Contato  = $_REQUEST[SQ_Contato];
    	$ObjEmail->TP_Email    = $_REQUEST[TP_Email];
    	$ObjEmail->Email       = $_REQUEST[Email];
        
    	if (!$ObjEmail->Edit($MsgErro))
        	echo '<a class="MsgErro">' . 'Erro na alteração do Email: ' . $ObjEmail->MsgErro .'</a>';
    	else 
       	//mysql_query("commit");
    	   echo '<a class="MsgSucesso">Alteração Email com sucesso!</a>';
    }  
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
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="">
    	<fieldset>
       		<legend> <?php if (!$_REQUEST[TP_Email]) echo "Inserindo "; else echo "Alterando ";?> Email</legend>
    		<label class="labellongo">Nome: <?php echo $_REQUEST[NM_Contato]?></label>
    		<?php 
    			if (!$_REQUEST[TP_Email]){
    				echo '<label class="labelNormal">Tipo Email: </label>';
					echo '<select name="TP_Email">';
				 		while ($RegTipoEmail = mysql_fetch_array($SetTipoEmail))
    	   					if ($_REQUEST[TP_Email] == $RegTipoEmail[TP_Email])
    	   						echo '<option selected  value="' , $RegTipoEmail[TP_Email] . '">' . $RegTipoEmail[NM_Tipo_Email] . '</option>';
    						else
    							echo '<option           value="' , $RegTipoEmail[TP_Email] . '">' . $RegTipoEmail[NM_Tipo_Email] . '</option>';
    			
       		 		echo '</select>';
     			}else 
    				echo '<label class="labelNormal">Tipo:'. $_REQUEST[NM_Tipo_Email] . '</label>';
    		?>
    		<br>
    	</fieldset>
    	<fieldset>
			<br> 			
    		<label>Email: </label>
    		<input type="text" name="Email" size="50" autofocus value = "<?php echo $_REQUEST[Email] ?>"><br><br>
    		<a class="linkVoltar" href="ContatoForm.php?SQ_Contato=<?php echo $_REQUEST[SQ_Contato]
														. '&Operacao=' . urlencode("Mostrar Contato")?>">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$_REQUEST[TP_Email]) echo 'Inserir Email'; else echo 'Alterar Email';?>">
		</fieldset>
    </form>	
  </BODY>
</HTML>
