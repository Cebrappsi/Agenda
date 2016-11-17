 <?php	
    require "comum.php";
    require "EspecialidadeClinicaClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $ObjEspecialidade_Clinica->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjEspecialidade_Clinica = new EspecialidadeClinica();
    $REQ_SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
    
    if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Especialidade_Clinica)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	$ObjEspecialidade_Clinica->SQ_Especialidade_Clinica = $REQ_SQ_Especialidade_Clinica;
    	if (!$ObjEspecialidade_Clinica->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
    	else {
    		// echo 'achei registro...' .  mysql_result($ObjPlano->Regs,0,NM_Plano) . '...' . $MsgErro ;
    		// echo 'NM_Plano: ' . mysql_result($ObjPlano->Regs,0,NM_Plano);
    		// echo 'DT_Desat: ' . mysql_result($ObjPlano->Regs,0,DT_Desativacao);
    		$_REQUEST[NM_Especialidade_Clinica] = mysql_result($ObjEspecialidade_Clinica->Regs,0,NM_Especialidade_Clinica);
    		$_REQUEST[Tempo_Atendimento] = mysql_result($ObjEspecialidade_Clinica->Regs,0,Tempo_Atendimento);
    	}
    }
    
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
    	$ObjEspecialidade_Clinica->NM_Especialidade_Clinica = $_REQUEST[NM_Especialidade_Clinica];
    	$ObjEspecialidade_Clinica->Tempo_Atendimento = $_REQUEST[Tempo_Atendimento];
    	if (!$ObjEspecialidade_Clinica->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    }
    
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	$ObjEspecialidade_Clinica->SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
    	$ObjEspecialidade_Clinica->NM_Especialidade_Clinica = $_REQUEST[NM_Especialidade_Clinica];
    	$ObjEspecialidade_Clinica->Tempo_Atendimento        = $_REQUEST[Tempo_Atendimento];
    	if (!$ObjEspecialidade_Clinica->Edit($MsgErro))
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
    		<legend> <?php if (!$REQ_SQ_Especialidade_Clinica) echo "Inserindo "; else echo "Alterando ";?> Especialidades da Clínica</legend>
    		<label class="labelNormal">Nome Especialidade: </label>
    		<input class="Entrada" type="text" name="NM_Especialidade_Clinica" size="30" value="<?php echo $_REQUEST[NM_Especialidade_Clinica]?>"><br><br>
    		<label class="labelNormal">Tempo Atendimento(min): </label>
    		<input class="Entrada" type="text" name="Tempo_Atendimento" size="3" value="<?php echo $_REQUEST[Tempo_Atendimento]?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="EspecialidadeClinicaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Especialidade_Clinica) echo "Inserir"; else echo "Alterar";?> >
    </form>
  </BODY>
</HTML>