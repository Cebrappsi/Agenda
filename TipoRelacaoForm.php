  <?php	
    
    require "comum.php";
    require "tipoRelacaoClasse.php";
    
    if (!$con = conecta_BD($MsgErro)) {
    	echo '<a class="MsgErro">' . 'Erro: ' . $MsgErro .'</a>';
    	die();
    }
    
    $ObjTipo_Relacao = new Tipo_Relacao();
    $REQ_TP_Relacao = $_REQUEST[TP_Relacao];
    
    
    if ((!$_REQUEST['Operacao']) and ($REQ_TP_Relacao)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
    	//Acesso o registro para preencher os campos
    	$ObjTipo_Relacao->TP_Relacao = $REQ_TP_Relacao;
    	if (!$ObjTipo_Relacao->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na consulta : ' . $MsgErro .'</a>';
    	else {
    		$_REQUEST[TP_Relacao] =  mysql_result($ObjTipo_Relacao->Regs,0,TP_Relacao);
    		$_REQUEST[NM_Tipo_Relacao] =  mysql_result($ObjTipo_Relacao->Regs,0,NM_Tipo_Relacao);
    	}
    }
    
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
    	$ObjTipo_Relacao->TP_Relacao = $_REQUEST[TP_Relacao];
    	$ObjTipo_Relacao->NM_Tipo_Relacao = $_REQUEST[NM_Tipo_Relacao];
    	if (!$ObjTipo_Relacao->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';	 
    	//header("Location: TipoRelacaoLista.php"); // redireciona para a listagem
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	$ObjTipo_Relacao->TP_Relacao = $_REQUEST[TP_Relacao];
    	$ObjTipo_Relacao->NM_Tipo_Relacao = $_REQUEST[NM_Tipo_Relacao];
    	
    	if (!$ObjTipo_Relacao->Edit($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
    	else 
      		echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    	//header("Location: TipoRelacaoForm.php");
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
    		<legend> <?php if (!$REQ_TP_Relacao) echo "Inserindo "; else echo "Alterando ";?> Tipo de Relação</legend>
    		<label class="labelNormal">Tipo Relação:</label>
    		<input class="Entrada" type="text" name="TP_Relacao" size="2" value="<?php echo $_REQUEST[TP_Relacao]?>"><br>
    		<label class="labelNormal">Nome Tipo Relação:</label>
    		<input class="Entrada" type="text" name="NM_Tipo_Relacao" size="30" value="<?php echo $_REQUEST[NM_Tipo_Relacao]?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="TipoRelacaoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_TP_Relacao) echo "Inserir"; else echo "Alterar";?>>
    </form>
    
    </BODY>
</HTML>
