<?php
	//print_r('Var recebidas:' . $_REQUEST); //debug var recebidas
    
 	require "comum.php";
 	require "ConvenioClasse.php";
   
 	if (!$con = conecta_BD($MsgErro)) {
    	echo '<a class="MsgErro">' . 'Erro: ' . $MsgErro .'</a>';
		die();
 	}
    
    $ObjConvenio = new Convenio();
 	$REQ_SQ_Convenio = $_REQUEST[SQ_Convenio];
    
 	if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Convenio)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela 
		$ObjConvenio->SQ_Convenio = $REQ_SQ_Convenio;
    	if (!$ObjConvenio->GetReg($MsgErro)) 
			echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
		else {
			// echo 'achei registro...' .  mysql_result($ObjConvenio->Regs,0,NM_Convenio) . '...' . $MsgErro ;
			// echo 'NM_Convenio: ' . mysql_result($ObjConvenio->Regs,0,NM_Convenio);
			// echo 'DT_Desat: ' . mysql_result($ObjConvenio->Regs,0,DT_Desativacao);
			$_REQUEST[NM_Convenio] =  mysql_result($ObjConvenio->Regs,0,NM_Convenio);
			$_REQUEST[DT_Ativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjConvenio->Regs,0,DT_Ativacao))));
			$_REQUEST[DT_Desativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjConvenio->Regs,0,DT_Desativacao))));
		}
 	}

	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
    	$ObjConvenio->NM_Convenio = $_REQUEST[NM_Convenio];
    	$ObjConvenio->DT_Ativacao = $_REQUEST[DT_Ativacao];
    	$ObjConvenio->DT_Desativacao = $_REQUEST[DT_Desativacao];
    	if (!$ObjConvenio->insert($MsgErro))
        	echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else 
       		echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>'; 
    	    //header("Location: convenio.php"); // redireciona para a listagem
	}

	if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar 
    	$ObjConvenio->SQ_Convenio = $_REQUEST[SQ_Convenio];
    	$ObjConvenio->NM_Convenio = $_REQUEST[NM_Convenio];
    	$ObjConvenio->DT_Ativacao = $_REQUEST[DT_Ativacao];
    	$ObjConvenio->DT_Desativacao = $_REQUEST[DT_Desativacao];
      	if (!$ObjConvenio->Edit($MsgErro)) 
    		echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
    	else
    		echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    	    //header("Location: convenio.php"); // redireciona para a listagem
	}
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
			width:15%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="">
    	<fieldset>
    		<legend> <?php if (!$REQ_SQ_Convenio) echo "Inserindo "; else echo "Alterando ";?> Convênio</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Convenio" size="30" value="<?php echo $_REQUEST[NM_Convenio] ?>"><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value="<?php echo $_REQUEST[DT_Ativacao] ?>"><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value="<?php echo $_REQUEST[DT_Desativacao] ?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="ConvenioLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Convenio) echo "Inserir"; else echo "Alterar";?> >
    </form>
</BODY>
</HTML>