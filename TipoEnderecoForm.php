<?php	
    require "comum.php";
    require "TipoEnderecoClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}
    	
    $ObjTipo_Endereco = new TipoEnderecoClass();
    $REQ_TP_Endereco = $_REQUEST[TP_Endereco];
    
    if ((!$_REQUEST['Operacao']) and ($REQ_TP_Endereco)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
    	//Acesso o registro para preencher os campos
    	$ObjTipo_Endereco->TP_Endereco = $REQ_TP_Endereco;
    	if (!$ObjTipo_Endereco->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na consulta : ' . $MsgErro .'</a>';
    	else {
    		$_REQUEST[TP_Endereco] =  mysql_result($ObjTipo_Endereco->Regs,0,TP_Endereco);
    		$_REQUEST[NM_Tipo_Endereco] = mysql_result($ObjTipo_Endereco->Regs,0,NM_Tipo_Endereco);
    	}
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
	    $ObjTipo_Endereco->TP_Endereco = $_REQUEST[TP_Endereco];
	    $ObjTipo_Endereco->NM_Tipo_Endereco = $_REQUEST[NM_Tipo_Endereco];
	    if (!$ObjTipo_Endereco->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	$ObjTipo_Endereco->TP_Endereco = $_REQUEST[TP_Endereco];
	    $ObjTipo_Endereco->NM_Tipo_Endereco = $_REQUEST[NM_Tipo_Endereco];
	    if (!$ObjTipo_Endereco->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
	    }
	    //header("Location: tipo_EnderecoEdit.php")
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
    		<legend> <?php if (!$REQ_TP_Endereco) echo "Inserindo "; else echo "Alterando ";?> Tipo de Endereço</legend>
    		<label class="labelNormal">Tipo Endereço:</label>
    		<input class="Entrada" type="text" name="TP_Endereco" size="2" value ="<?php echo $_REQUEST[TP_Endereco] ?>"><br>
    		<label class="labelNormal">Nome Tipo Endereco:</label>
    		<input class="Entrada" type="text" name="NM_Tipo_Endereco" size="30" value="<?php echo $_REQUEST[NM_Tipo_Endereco] ?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="TipoEnderecoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_TP_Endereco) echo "Inserir"; else echo "Alterar";?>>
    </form>
  </BODY>
</HTML>
