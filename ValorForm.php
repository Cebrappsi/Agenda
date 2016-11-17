<?php
	    //print_r($_REQUEST); //debug var recebidas
	    
	    require "comum.php";
	    require "ValorClasse.php";
	    $ObjValor = new Valor();
	    if (!$con = conecta_BD($MsgErro)) {
		   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
		   die();
		}
	    
	//	print_r($_REQUEST);
	    //Acesso o registro para preencher os campos
		$ObjValor->SQ_Valor = $_REQUEST[SQ_Valor];
		$REQ_SQ_Valor = $_REQUEST[SQ_Valor];
		if ((!$_REQUEST['Operacao']) and ($REQ_SQ_Valor)) { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
			$ObjValor->SQ_Valor = $REQ_SQ_Valor;
		    if (!$ObjValor->GetReg($MsgErro)) {
		       echo '<a class="MsgErro">' . 'Erro na busca do reg a ser alterado : ' . $MsgErro .'</a>';
			   die();
			} else{
		   // echo 'achei registro...' .  mysql_result($ObjValor->Regs,0,SQ_Valor) . '...' . $ObjValor->MsgErro ;
		   // echo 'NM_Valor: ' . mysql_result($ObjValor->Regs,0,NM_Valor);
				$ConvPlanEspec = mysql_result($ObjValor->Regs,0,SQ_Convenio) * 100000000 + mysql_result($ObjValor->Regs,0,SQ_Plano)* 10000 
				             														 + mysql_result($ObjValor->Regs,0,SQ_Especialidade);
				echo $ConvPlanEspec;
				$_REQUEST[SQ_Convenio] =  mysql_result($ObjValor->Regs,0,SQ_Convenio);
				$_REQUEST[SQ_Plano] =  mysql_result($ObjValor->Regs,0,SQ_Plano);
				$_REQUEST[SQ_Especialidade] =  mysql_result($ObjValor->Regs,0,SQ_Especialidade);
				$_REQUEST[VL_Consulta] = mysql_result($ObjValor->Regs,0,VL_Consulta);
				$_REQUEST[DT_Ativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjValor->Regs,0,DT_Ativacao))));
				$_REQUEST[DT_Desativacao] = implode('/',array_reverse(explode('-',mysql_result($ObjValor->Regs,0,DT_Desativacao))));
			}
		} 
		
		if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
			$ObjValor->SQ_Convenio = floor($_REQUEST[ConvPlanEspec] / 100000000);
			$ObjValor->SQ_Plano = floor($_REQUEST[ConvPlanEspec] / 10000) % 10000;
			$ObjValor->SQ_Especialidade = $_REQUEST[ConvPlanEspec] % 10000;
			$ObjValor->VL_Consulta = $_REQUEST[VL_Consulta];
			$ObjValor->DT_Ativacao = $_REQUEST[DT_Ativacao];
			$ObjValor->DT_Desativacao = $_REQUEST[DT_Desativacao];
			//print_r($_REQUEST[ConvPlanEspec]);
			//print_r($ObjValor);
			if (!$ObjValor->insert($MsgErro))
				echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
			else
				echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
		}
		
		if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
			$ObjValor->SQ_Valor = $_REQUEST[SQ_Valor];
			$ObjValor->SQ_Convenio = floor($_REQUEST[ConvPlanEspec] / 100000000);
			$ObjValor->SQ_Plano = floor($_REQUEST[ConvPlanEspec] / 10000) % 10000;
			$ObjValor->SQ_Especialidade = $_REQUEST[ConvPlanEspec] % 10000;
			$ObjValor->VL_Consulta = $_REQUEST[VL_Consulta];
			$ObjValor->DT_Ativacao = $_REQUEST[DT_Ativacao];
			$ObjValor->DT_Desativacao = $_REQUEST[DT_Desativacao];
			// print_r($ObjValor->SQ_Convenio);
			 
			if (!$ObjValor->Edit($MsgErro))
				echo '<a class="MsgErro">' . 'Erro na alteração : ' . $MsgErro .'</a>';
			else {
				//mysql_query("commit");
				echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
			}
			//header("Location: Valor.php					
		}
		//Lista de convenios
		if (!$ListaConvs = mysql_query('SELECT Especialidade.*, plano.*, convenio.*
				from Especialidade
				inner join Plano
				on Especialidade.SQ_Plano = Plano.SQ_Plano
				inner join Convenio
				on Especialidade.SQ_Convenio = Convenio.SQ_Convenio
				order by NM_Convenio, NM_Plano, NM_Especialidade')){
			echo '<a class="MsgErro">Não foi possível efetuar consulta Convenio: ' . mysql_error() .'<br></a>';
			die();
		}
		//echo 'Rows=' .mysql_num_rows($ListaConvs);
	    mysql_close($con);
    ?>
<!DOCTYPE html>
<HTML>
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
    		<legend> <?php if (!$REQ_SQ_Valor) echo "Inserindo "; else echo "Alterando ";?> Valor de Consulta</legend>
    		<label class="labelNormal">Convênio/Plano/Especialidade: </label>
    		<select class="Entrada" name="ConvPlanEspec">
	    		<?php 
	    		   	while ($dados = mysql_fetch_array($ListaConvs))   //guardo info a cada 4 posicoes - Conv-plan-Espec
	    		   		if (   mysql_result($ObjValor->Regs,0,SQ_Convenio) == $dados[SQ_Convenio] 
	    		   			&& mysql_result($ObjValor->Regs,0,SQ_Plano) ==  $dados[SQ_Plano] 
	    		   			&& mysql_result($ObjValor->Regs,0,SQ_Especialidade) ==  $dados[SQ_Especialidade])
		           		   	echo '<option value="' . ($dados[SQ_Convenio] * 100000000 + $dados[SQ_Plano] * 10000 + $dados[SQ_Especialidade])  . '"' 
		    	              					   . ' selected>' 
		    	               					   . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '->' . $dados[NM_Especialidade] . '</option>';
	    		   		else 
	    		   			echo '<option value="' .($dados[SQ_Convenio] * 100000000 + $dados[SQ_Plano] * 10000 + $dados[SQ_Especialidade])  . '">'
	    		   			    		   	       . $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '->' . $dados[NM_Especialidade] . '</option>';
	    		 ?>
    		</select><br><br>
	    	<label class="labelNormal">Valor Consulta: </label>
	    	<input class="Entrada" type="text" name="VL_Consulta" size="12" value="<?php echo $_REQUEST[VL_Consulta]?>"><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value="<?php echo $_REQUEST[DT_Ativacao]?>"><br><br>
    		<label class="labelNormal">Data Desativação:</label>   		
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value="<?php echo $_REQUEST[DT_Desativacao]?>"><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="ValorLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value= <?php if (!$REQ_SQ_Valor) echo "Inserir"; else echo "Alterar";?> >
    </form>
    <br>
  </BODY>
</HTML>
