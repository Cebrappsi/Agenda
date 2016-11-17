<?php
    //print_r($_REQUEST); //debug var recebidas
    
    require "comum.php";
    require "OperadoraClasse.php";
    
    if (!$con = conecta_BD($MsgErro)) {
    	echo '<a class="MsgErro">' . 'Erro: ' . $MsgErro .'</a>';
    	die();
    }
    
    $ObjOperadora = new Operadora();
    $REQ_SQ_Operadora = $_REQUEST[SQ_Operadora];
    
    
    if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Operadora)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
    	//Acesso o registro para preencher os campos
    	$ObjOperadora->SQ_Operadora = $REQ_SQ_Operadora;
    	if (!$ObjOperadora->GetReg($MsgErro)) 
    		echo '<a class="MsgErro">' . 'Erro na Consulta : ' . $MsgErro .'</a>';
    	else {
    		$_REQUEST[CD_Operadora] =  mysql_result($ObjOperadora->Regs,0,CD_Operadora);
    		$_REQUEST[NM_Operadora] =  mysql_result($ObjOperadora->Regs,0,NM_Operadora);
    	}
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
    	$ObjOperadora->CD_Operadora = $_REQUEST[CD_Operadora];
    	$ObjOperadora->NM_Operadora = $_REQUEST[NM_Operadora];
    	if (!$ObjOperadora->insert($MsgErro))
        	echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else 
       		echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    	
    	//header("Location: OperadoraLista.php"); // redireciona para a listagem
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	$ObjOperadora->SQ_Operadora = $_REQUEST[SQ_Operadora];
    	$ObjOperadora->CD_Operadora = $_REQUEST[CD_Operadora];
    	$ObjOperadora->NM_Operadora = $_REQUEST[NM_Operadora];
    	
    	if (!$ObjOperadora->Edit($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
    	else {
    		//mysql_query("commit");
    		echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    	}
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
    		<legend> <?php if (!$REQ_SQ_Operadora) echo "Inserindo "; else echo "Alterando ";?> Operadora de Telefonia</legend>
    		<label class="labelNormal">Código: </label>
    		<input class="Entrada" type="text" name="CD_Operadora" size="2" value ="<?php echo $_REQUEST[CD_Operadora]?> "><br>
    		<label class="labelNormal">Nome:</label>
    	    <input class="Entrada" type="text" name="NM_Operadora" size="30" value="<?phP echo $_REQUEST[NM_Operadora]?> "><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="OperadoraLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Operadora) echo "Inserir"; else echo "Alterar";?>>
    </form>
  </BODY>
</HTML>
