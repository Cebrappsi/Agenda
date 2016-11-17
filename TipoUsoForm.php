<?php	
	require "comum.php";
    require "TipoUsoClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}
    
    $ObjTipo_Uso = new TipoUsoClass();
    
    $REQ_TP_Uso = $_REQUEST[TP_Uso];
    
    if ((!$_REQUEST['Operacao']) and ($REQ_TP_Uso)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
    	//Acesso o registro para preencher os campos
    	$ObjTipo_Uso->TP_Uso = $REQ_TP_Uso;
    	if (!$ObjTipo_Uso->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na consulta : ' . $MsgErro .'</a>';
    	else {
    		$_REQUEST[TP_Uso] =  mysql_result($ObjTipo_Uso->Regs,0,TP_Uso);
    		$_REQUEST[NM_Tipo_Uso] = mysql_result($ObjTipo_Uso->Regs,0,NM_Tipo_Uso);
    	}
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
		$ObjTipo_Uso->TP_Uso = $_REQUEST[TP_Uso];
	    $ObjTipo_Uso->NM_Tipo_Uso = $_REQUEST[NM_Tipo_Uso];
	    if (!$ObjTipo_Uso->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
     }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
	    $ObjTipo_Uso->TP_Uso = $_REQUEST[TP_Uso];
	    $ObjTipo_Uso->NM_Tipo_Uso = $_REQUEST[NM_Tipo_Uso];
	    
	    //print_r('antes critica'. $Objtipo_Uso->TP_Uso . $Objtipo_Uso->NM_Tipo_Uso); 
	 
	    if (!$ObjTipo_Uso->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
	    }
	    //header("Location: TipoUsoLista.php");
	 
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
    		<legend> <?php if (!$REQ_TP_Uso) echo "Inserindo "; else echo "Alterando ";?> Tipo de Uso Telefone</legend>
    		<label class="labelNormal">Tipo Uso:</label>
    		<input class="Entrada" type="text" name="TP_Uso" size="2" value ="<?php echo $_REQUEST[TP_Uso] ?>"><br>
    		<label class="labelNormal">Nome Tipo Uso:</label>
    		<input class="Entrada" type="text" name="NM_Tipo_Uso" size="30" value="<?php echo $_REQUEST[NM_Tipo_Uso] ?>"><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="TipoUsoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_TP_Uso) echo "Inserir"; else echo "Alterar";?>>
    </form>
  </BODY>
</HTML>