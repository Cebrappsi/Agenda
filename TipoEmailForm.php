<?php	
    
    require "comum.php";
    require "TipoEmailClasse.php";
    
    if (!$con  = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}
    
    $ObjTipo_Email = new TipoEmailClass();
    $REQ_TP_Email = $_REQUEST[TP_Email];
    
    if ((!$_REQUEST['Operacao']) and ($REQ_TP_Email)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
    	//Acesso o registro para preencher os campos
    	$ObjTipo_Email->TP_Email = $REQ_TP_Email;
    	if (!$ObjTipo_Email->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na consulta : ' . $MsgErro .'</a>';
    	else {
    		$_REQUEST[TP_Email] =  mysql_result($ObjTipo_Email->Regs,0,TP_Email);
    		$_REQUEST[NM_Tipo_Email] = mysql_result($ObjTipo_Email->Regs,0,NM_Tipo_Email);
    	}
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
    	$ObjTipo_Email->TP_Email = $_REQUEST[TP_Email];
    	$ObjTipo_Email->NM_Tipo_Email = $_REQUEST[NM_Tipo_Email];
    	if (!$ObjTipo_Email->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	//Houve alteraçao - proceder altera��o
    	$ObjTipo_Email->TP_Email = $_REQUEST[TP_Email];
    	$ObjTipo_Email->NM_Tipo_Email = $_REQUEST[NM_Tipo_Email];  
     	if (!$ObjTipo_Email->Edit($MsgErro))
        	echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
    	else 
       		echo '<a class="MsgSucesso">Altera��o com sucesso!</a>';
       	//header("Location: TipoEmailList.php");
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
    		<legend> <?php if (!$REQ_TP_Email) echo "Inserindo "; else echo "Alterando ";?> Tipo de Email</legend>
    		<label class="labelNormal">Tipo Email:</label>
    		<input class="Entrada" type="text" name="TP_Email" size="2" value ="<?php echo $_REQUEST[TP_Email] ?>"><br>
    		<label class="labelNormal">Nome Tipo Email:</label>
    		<input class="Entrada" type="text" name="NM_Tipo_Email" size="30" value="<?php echo $_REQUEST[NM_Tipo_Email] ?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="TipoEmailLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_TP_Email) echo "Inserir"; else echo "Alterar";?>>
    </form>
    
   </BODY>
</HTML>
