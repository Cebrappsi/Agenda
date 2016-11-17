<?php
//	print_r ($_REQUEST);
    require "comum.php";
    require "UFClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}

  	$ObjUF = new UF();
	$REQ_CD_UF = $_REQUEST[CD_UF];

	if ((!$_REQUEST['Operacao']) and ($REQ_CD_UF)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela 
		//Acesso o registro para preencher os campos
     	$ObjUF->CD_UF = $REQ_CD_UF;
		if (!$ObjUF->GetReg($MsgErro)) {
       		echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . $MsgErro .'</a>';
	   		die();
		}
		else {
			$_REQUEST[CD_UF] = mysql_result($ObjUF->Regs,0,CD_UF);
			$_REQUEST[NM_UF] = mysql_result($ObjUF->Regs,0,NM_UF);
		}
 	}

	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
	 	$ObjUF->CD_UF = $_REQUEST[CD_UF];
    	$ObjUF->NM_UF = $_REQUEST[NM_UF];
    	if (!$ObjUF->insert($MsgErro))
        	echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else 
       		echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';   
	}

    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar 
		$ObjUF->CD_UF = $_REQUEST[CD_UF];
   		$ObjUF->NM_UF = $_REQUEST[NM_UF];
    	if (!$ObjUF->Edit($MsgErro))
        	echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
    	else 
       		echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
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
    		<legend><?php if (!$REQ_SQ_Convenio) echo "Inserindo "; else echo "Alterando ";?> Unidade da Federação</legend>
    		<label class="labelNormal">Sigla:</label>
    		<input class="Entrada" type="text" name="CD_UF" size="2" value="<?php echo $_REQUEST[CD_UF] ?>"><br>
    		<label class="labelNormal">Nome:</label>
    		<input class="Entrada" type="text" name="NM_UF" size="30" value="<?php echo $_REQUEST[NM_UF] ?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="UFLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="<?php if (!$REQ_CD_UF) echo "Inserir"; else echo "Alterar"?>">
    </form>
