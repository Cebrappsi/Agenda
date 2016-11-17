<?php	
    require "comum.php";
    require "TipoMobilidadeClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}

    $ObjTipo_Mobilidade = new TipoMobilidadeClass();
       
    $REQ_TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    
    if ((!$_REQUEST['Operacao']) and ($REQ_TP_Mobilidade)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
    	//Acesso o registro para preencher os campos
    	$ObjTipo_Mobilidade->TP_Mobilidade = $REQ_TP_Mobilidade;
    	if (!$ObjTipo_Mobilidade->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na consulta : ' . $MsgErro .'</a>';
    	else {
    		$_REQUEST[TP_Mobilidade] =  mysql_result($ObjTipo_Mobilidade->Regs,0,TP_Mobilidade);
    		$_REQUEST[NM_Tipo_Mobilidade] = mysql_result($ObjTipo_Mobilidade->Regs,0,NM_Tipo_Mobilidade);
    	}
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
	    $ObjTipo_Mobilidade->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
	    $ObjTipo_Mobilidade->NM_Tipo_Mobilidade = $_REQUEST[NM_Tipo_Mobilidade];
	    if (!$ObjTipo_Mobilidade->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	$ObjTipo_Mobilidade->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
	    $ObjTipo_Mobilidade->NM_Tipo_Mobilidade = $_REQUEST[NM_Tipo_Mobilidade];
	    
	    //print_r('antes critica'. $Objtipo_Mobilidade->TP_Mobilidade . $Objtipo_Mobilidade->NM_Tipo_Mobilidade); 
	 
	    if (!$ObjTipo_Mobilidade->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
	    }
	    //header("Location: TipoMobilidadeForm.php");
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
    		<legend> <?php if (!$REQ_TP_Mobilidade) echo "Inserindo "; else echo "Alterando ";?> Tipo de Mobilidade Telefone</legend>
    		<label class="labelNormal">Tipo Mobilidade:</label>
    		<input class="Entrada" type="text" name="TP_Mobilidade" size="2" value ="<?php echo $_REQUEST[TP_Mobilidade] ?>"><br>
    		<label class="labelNormal">Nome Tipo Mobilidade:</label>
    		<input class="Entrada" type="text" name="NM_Tipo_Mobilidade" size="30" value="<?php echo $_REQUEST[NM_Tipo_Mobilidade] ?>"><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="TipoMobilidadeLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_TP_Mobilidade) echo "Inserir"; else echo "Alterar";?>>
    </form>
    
  </BODY>
</HTML>
