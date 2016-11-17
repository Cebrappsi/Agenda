<?php	
    require "comum.php";
    require "TipoSituacaoConsultaClasse.php";
    
    if (!$con  = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}
	
    $ObjTipo_Situacao_Consulta = new TipoSituacaoConsulta();
    $REQ_TP_Situacao_Consulta = $_REQUEST[TP_Situacao_Consulta];
    echo ('ins' . $REQ_TP_Situacao_Consulta);	
	if ((!$_REQUEST['Operacao']) and ($REQ_TP_Situacao_Consulta)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela'
		$ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = $REQ_TP_Situacao_Consulta;
		if (!$ObjTipo_Situacao_Consulta->GetReg($MsgErro)){ 
			echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . $MsgErro .'</a>';
			die();
		} else{
			$_REQUEST[TP_Situacao_Consulta] = mysql_result($ObjTipo_Situacao_Consulta->Regs,0,TP_Situacao_Consulta);
			$_REQUEST[NM_Tipo_Situacao_Consulta] = mysql_result($ObjTipo_Situacao_Consulta->Regs,0,NM_Tipo_Situacao_Consulta);	
		}
	}
	
	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
	    $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = strtoupper($_REQUEST[TP_Situacao_Consulta]);
	    $ObjTipo_Situacao_Consulta->NM_Tipo_Situacao_Consulta = $_REQUEST[NM_Tipo_Situacao_Consulta];
	    if (!$ObjTipo_Situacao_Consulta->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    }
	
	if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
		$ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = strtoupper($_REQUEST[TP_Situacao_Consulta]);
		$ObjTipo_Situacao_Consulta->NM_Tipo_Situacao_Consulta = $_REQUEST[NM_Tipo_Situacao_Consulta];
		
		//print_r('antes critica'. $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta . $ObjTipo_Situacao_Consulta->NM_Tipo_Situacao_Consulta);
		
		if (!$ObjTipo_Situacao_Consulta->Edit($MsgErro))
			echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
		else {
			//mysql_query("commit");
			echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
		}	
	}
	//ok - vamos incluir	
    
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
			width:20%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="">
    	<fieldset>
    		<legend> <?php if (!$REQ_TP_Endereco) echo "Inserindo "; else echo "Alterando ";?> Situação da Consulta</legend>
    		<label class="labelNormal">Tipo Situacao da Consulta:</label>
    		<input class="Entrada" type="text" name="TP_Situacao_Consulta" size="1" value="<?php echo $_REQUEST[TP_Situacao_Consulta]?>"><br><br>
    		<label class="labelNormal">Nome Tipo Situacao Consulta:</label>
    		<input class="Entrada" type="text" name="NM_Tipo_Situacao_Consulta" size="30" value="<?php echo $_REQUEST[NM_Tipo_Situacao_Consulta]?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="TipoSituacaoConsultaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_TP_Situacao_Consulta) echo "Inserir"; else echo "Alterar";?>>
    </form>
  </BODY>
</HTML>
