<?php	  
	require "comum.php";
    require "ProfissionalClasse.php";	
    if (!$con = conecta_BD($MsgErro)){
       echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
	   die();
	}
   // Preparacao para Profissionais
    if (!$SetProfissional = mysql_query('Select distinct Relacionamento.SQ_Contato, Contato.NM_Contato from Relacionamento ' .
					    		          'inner join Contato ' . 
					    		          'on Relacionamento.SQ_Contato = Contato.SQ_Contato ' .
					                      'Where Relacionamento.TP_Relacao = "R" '. 
										  'order by NM_Contato')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Relacionamento de Profissionais: ' . mysql_error() .'<br></a>';
    	die();
    }
 
   // Preparacao para Emails
    if (!$SetEspecialidade = mysql_query('SELECT distinct NM_Especialidade, SQ_Especialidade from Especialidade ' .
    		                             'group by NM_Especialidade order by NM_Especialidade')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Especialidades: ' . mysql_error() .'<br></a>';
    	die();
    }
 
	$ObjProfissional = new Profissional();
	$REQ_SQ_Profissional = $_REQUEST[SQ_Profissional];
	//print_r($_REQUEST);	
   
	if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Profissional)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
		$ObjProfissional->SQ_Profissional = $REQ_SQ_Profissional;
		$ObjProfissional->SQ_Especialidade = $_REQUEST['SQ_Especialidade'];
		if (!$ObjProfissional->GetReg($MsgErro))
			echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
		else {
			$_REQUEST[DT_Ativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjProfissional->Regs,0,DT_Ativacao))));
			$_REQUEST[DT_Desativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjProfissional->Regs,0,DT_Desativacao))));
		}
	}
	
	if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
		//ok - vamos incluir	
	    $ObjProfissional->SQ_Profissional = $REQ_SQ_Profissional;
	    $ObjProfissional->SQ_Especialidade = $_REQUEST['SQ_Especialidade'];
		$ObjProfissional->DT_Ativacao = $_REQUEST[DT_Ativacao];
	    $ObjProfissional->DT_Desativacao = $_REQUEST[DT_Desativacao];
	    if (!$ObjProfissional->insert($MsgErro))
	        echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
	    else 
	       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';    
    	}
	
	if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
	    $ObjProfissional->SQ_Profissional = $_REQUEST[SQ_Profissional];
	    $ObjProfissional->SQ_Especialidade = $_REQUEST[SQ_Especialidade];
	    $ObjProfissional->DT_Ativacao = $_REQUEST[DT_Ativacao];
	    $ObjProfissional->DT_Desativacao = $_REQUEST[DT_Desativacao];
	    
	    if (!$ObjProfissional->Edit($MsgErro))
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
    		<legend> <?php if (!$REQ_SQ_Profissional) echo "Inserindo "; else echo "Alterando ";?> Profissional</legend>
    		<label class="labelNormal">Profissional: </label>
    		<?php 
    			if (!$REQ_SQ_Profissional){ //Inserir - Mostrar Lista
    				echo '<select name="SQ_Profissional">';
				 		while ($RegProfissional = mysql_fetch_array($SetProfissional))
    	   					if ($REQ_SQ_Profissional == $RegProfissional[SQ_Contato])
    	   						echo '<option selected  value="' , $RegProfissional[SQ_Contato] . '">' . $RegProfissional[NM_Contato] . '</option>';
    						else
    							echo '<option           value="' , $RegProfissional[SQ_Contato] . '">' . $RegProfissional[NM_Contato] . '</option>';
    			 		echo '</select>';
     			}else // so apresentar 
    				echo '<label class="MostraDados">'. $_REQUEST[NM_Profissional] . '</label>';
    		?>
    		<br><br>
    		<!--- <label class="MostraDados"><?php echo $_REQUEST[NM_Profissional]?></label><br><br> -->
    		<label class="labelNormal">Especialidade: </label>
    		<!--- <label class="MostraDados"><?php echo $_REQUEST[NM_Especialidade]?></label><br><br>--->
    		<?php 
    			if (!$REQ_SQ_Profissional){ //Inserir
    				echo '<select name="SQ_Especialidade">';
				 		while ($RegEspecialidade = mysql_fetch_array($SetEspecialidade))
    	   					if ($_REQUEST[SQ_Especialidade] == $RegEspecialidade[SQ_Especialidade])
    	   						echo '<option selected  value="' , $RegEspecialidade[SQ_Especialidade] . '">'
																 . $RegEspecialidade[NM_Especialidade] . '</option>';
    						else
    							echo '<option           value="' , $RegEspecialidade[SQ_Especialidade] . '">'
																 . $RegEspecialidade[NM_Especialidade] . '</option>';
    			 		echo '</select>';
     			}else // so apresentar 
    				echo '<label class="MostraDados">'. $_REQUEST[NM_Especialidade] . '</label>';
    		?>
    		<br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value="<?php echo $_REQUEST[DT_Ativacao] ?>"><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value="<?php echo $_REQUEST[DT_Desativacao] ?>"><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="ProfissionalLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Profissional) echo "Inserir"; else echo "Alterar";?> >
    </form>
  </BODY>
</HTML>