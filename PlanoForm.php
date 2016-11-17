<?php
    //print_r($_REQUEST);	
    require "PlanoClasse.php";
    require "Comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
   	
    $ObjPlano = new PlanoClass();
    $REQ_SQ_Plano = $_REQUEST[SQ_Plano];
    
 	if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Plano)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela 
		$ObjPlano->SQ_Plano = $REQ_SQ_Plano;
    	if (!$ObjPlano->GetReg($MsgErro)) 
			echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
		else {
			// echo 'achei registro...' .  mysql_result($ObjPlano->Regs,0,NM_Plano) . '...' . $MsgErro ;
			// echo 'NM_Plano: ' . mysql_result($ObjPlano->Regs,0,NM_Plano);
			// echo 'DT_Desat: ' . mysql_result($ObjPlano->Regs,0,DT_Desativacao);
			$_REQUEST[SQ_Convenio] =  mysql_result($ObjPlano->Regs,0,SQ_Convenio);
			$_REQUEST[NM_Plano] =  mysql_result($ObjPlano->Regs,0,NM_Plano);
			$_REQUEST[DT_Ativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjPlano->Regs,0,DT_Ativacao))));
			$_REQUEST[DT_Desativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjPlano->Regs,0,DT_Desativacao))));
		}
 	}

	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
	    $ObjPlano->SQ_Convenio = $_REQUEST[SQ_Convenio];
	    $ObjPlano->NM_Plano = $_REQUEST[NM_Plano];
	    $ObjPlano->DT_Ativacao = $_REQUEST[DT_Ativacao];
	    $ObjPlano->DT_Desativacao = $_REQUEST[DT_Desativacao];
	    //print_r($ObjPlano);
	    if (!$ObjPlano->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
	}

	if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar 
	    $ObjPlano->SQ_Plano = $_REQUEST[SQ_Plano];
	    $ObjPlano->SQ_Convenio = $_REQUEST[SQ_Convenio];
	    $ObjPlano->NM_Plano = $_REQUEST[NM_Plano];
	    $ObjPlano->DT_Ativacao = $_REQUEST[DT_Ativacao];
	    $ObjPlano->DT_Desativacao = $_REQUEST[DT_Desativacao];
	    //print_r($ObjPlano);
	    if (!$ObjPlano->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
	    else {
	       //mysql_query("commit");
	       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
	    }
	    //header("Location: Plano.php
	}
	//prepara consulta convenio para montar a lista de conveios do combobox
	if (!$consulta = mysql_query('SELECT * from Convenio order by NM_Convenio')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Convenio: ' . mysql_error() .'<br></a>';
		die();
	}
	//echo mysql_num_rows($consulta);
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
    		<legend> <?php if (!$REQ_SQ_Plano) echo "Inserindo "; else echo "Alterando ";?> Plano</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Plano" size="30" value="<?php echo $_REQUEST[NM_Plano] ?>"><br><br>
    		<label class="labelNormal">Convênio: </label>
    		<select class="Entrada" name="SQ_Convenio">
    		   	<?php while ($dados = mysql_fetch_array($consulta)) 
		    		    if (mysql_result($ObjPlano->Regs,0,SQ_Convenio) == $dados[SQ_Convenio])
		    		        echo '<option value="' , $dados[SQ_Convenio] . '"selected>' . $dados[NM_Convenio] . '</option>';
		    	        else 
		    	        	echo '<option value="' , $dados[SQ_Convenio] . '">' . $dados[NM_Convenio] . '</option>';
		    	?>
	    	</select><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value="<?php echo $_REQUEST[DT_Ativacao]?>"><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value="<?php echo $_REQUEST[DT_Desativacao]?>"><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="PlanoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Plano) echo "Inserir"; else echo "Alterar";?> >
    </form>
  </BODY>
</HTML>