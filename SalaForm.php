<?php	  
    require "comum.php";
    require "SalaClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}
	$ObjSala = new Sala();
	$REQ_SQ_Sala = $_REQUEST[SQ_Sala];
		
	if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Sala)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
		$ObjSala->SQ_Sala = $REQ_SQ_Sala;
		if (!$ObjSala->GetReg($MsgErro))
			echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
		else {
			$_REQUEST[NM_Sala] =  mysql_result($ObjSala->Regs,0,NM_Sala);
			$_REQUEST[DT_Ativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjSala->Regs,0,DT_Ativacao))));
			$_REQUEST[DT_Desativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjSala->Regs,0,DT_Desativacao))));
		}
	}
	
	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
		//ok - vamos incluir	
	    $ObjSala->NM_Sala = $_REQUEST[NM_Sala];
	    $ObjSala->DT_Ativacao = $_REQUEST[DT_Ativacao];
	    $ObjSala->DT_Desativacao = $_REQUEST[DT_Desativacao];
	    if (!$ObjSala->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';    
    	}
	
	if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
	    $ObjSala->SQ_Sala = $_REQUEST[SQ_Sala];
	    $ObjSala->NM_Sala = $_REQUEST[NM_Sala];
	    $ObjSala->DT_Ativacao = $_REQUEST[DT_Ativacao];
	    $ObjSala->DT_Desativacao = $_REQUEST[DT_Desativacao];
	    
	    if (!$ObjSala->Edit($MsgErro))
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
    		<legend> <?php if (!$REQ_SQ_Sala) echo "Inserindo "; else echo "Alterando ";?> Sala</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Sala" size="30" autofocus value="<?php echo $_REQUEST[NM_Sala] ?>"><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value="<?php echo $_REQUEST[DT_Ativacao] ?>"><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value="<?php echo $_REQUEST[DT_Desativacao] ?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="SalaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Sala) echo "Inserir"; else echo "Alterar";?> >
    </form>
  </BODY>
</HTML>