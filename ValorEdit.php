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
    <?php
    //print_r($_REQUEST); //debug var recebidas
    
    require "comum.php";
    require "ValorClasse.php";
    $ObjValor = new Valor();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
//	print_r($_REQUEST);
    //Acesso o registro para preencher os campos
	$ObjValor->SQ_Valor = $_REQUEST[SQ_Valor];
    if (!$ObjValor->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na busca do reg a ser alterado : ' . $ObjValor->MsgErro .'</a>';
	   die();
	}
   // echo 'achei registro...' .  mysql_result($ObjValor->Regs,0,SQ_Especialidade) . '...' . $ObjValor->MsgErro ;
   // echo 'NM_Especialidade: ' . mysql_result($ObjEspecialidade->Regs,0,NM_Especialidade);
	//Lista de convenios
	if (!$ListaConvs = mysql_query('SELECT Especialidade.*, plano.*, convenio.* 
			    							  from Especialidade 
			    		                      inner join convenio 
			    							  on Especialidade.SQ_Convenio = Convenio.SQ_Convenio
	    									  inner join Plano 
			    							  on Especialidade.SQ_Plano = Plano.SQ_Plano 
			    							  order by NM_Convenio, NM_Plano, NM_Especialidade')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Convenio: ' . mysql_error() .'<br></a>';
		die();
	}
    ?>
    
	<form method="post" action="ValorEdit.php">
    	<fieldset>
    	   <legend>Alteração de Valor</legend>
    	   <a class="MsgObs">Cuidado ao alterar Datas e Valores. Esta ação poderá gerar diferenças na parte contábil 
    	                     para o período alterado!<br><br></a>
    	   <label class="labelNormal">Convenio/Plano/Especialidade: </label>
    		<?php
    		
    		echo '<input type="hidden" name="SQ_Valor" value=' . mysql_result($ObjValor->Regs,0,SQ_Valor). '>';
    		echo '<select class="Entrada" name="ConvPlanEspec">';
		    	while ($dados = mysql_fetch_array($ListaConvs)) 
		    		if    (mysql_result($ObjValor->Regs,0,SQ_Convenio) == $dados[SQ_Convenio] 
		    			&& mysql_result($ObjValor->Regs,0,SQ_Plano) ==  $dados[SQ_Plano]
		    			&& mysql_result($ObjValor->Regs,0,SQ_Especialidade) ==  $dados[SQ_Especialidade])
		    			echo '<option value="' , ($dados[SQ_Convenio] * 100000000 + ($dados[SQ_Plano] * 10000) + $dados[SQ_Especialidade]) . '"  selected>' . 
		    									  $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '->' . $dados[NM_Especialidade] . '</option>';
		    		else
		    			echo '<option value="' , ($dados[SQ_Convenio] * 100000000 + ($dados[SQ_Plano] * 10000) + $dados[SQ_Especialidade]) . '">' . 
		    									  $dados[NM_Convenio] . '->' . $dados[NM_Plano] . '->' . $dados[NM_Especialidade] . '</option>';
	    	echo '</select><br><br>';
	    	echo '<label class="labelNormal">Valor da Consulta: </label>';
	    	echo '<input class="Entrada" type="text" name="VL_Consulta" size="12" value=' . '"' . mysql_result($ObjValor->Regs,0,VL_Consulta) . '"><br><br>';
    		echo '<label class="labelNormal">Data Ativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=' . mysql_result($ObjValor->Regs,0,DT_Ativacao) . '><br><br>';
    		echo '<label class="labelNormal">Data Desativação:</label>';
    		echo '<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=' . mysql_result($ObjValor->Regs,0,DT_Desativacao) . '><br><br>';
    	    ?>
    	</fieldset>
    	<a class="linkVoltar" href="Valor.php">Voltar</a>
    	<input class="Envia" type="submit" name="submit" value="Alterar">
    </form>
    <br>
    <?php 
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjValor->Regs);
    //print_r($_REQUEST);			
    if(empty($_REQUEST['submit'])){
         //ECHO 'VAZIO';   //Primeira apresentacao da tela
    	die();//// Só apresenta os dados
    }
    //Houve alteração - proceder alteração
    //echo ('Alterando');
   
    $ObjValor = new Valor();
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
    
    mysql_close($con);
    //echo 'SQ_Valor = ' . mysql_result($ObjValor->Regs,0,SQ_Convenio);
    
    ?>
    
  </BODY>
</HTML>
