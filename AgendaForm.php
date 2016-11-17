<?php 
   //prepara consulta para montar a lista de relacoes
   require "comum.php";
   print_r ($_REQUEST);
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
	// preparacao das listas a serem apresentadas    		
    if (!$SetContato = mysql_query('SELECT contato.*,contato_plano.*, plano.NM_Plano ' .
    		                       'from Contato '. 
    							   'left join contato_plano on contato.SQ_Contato = Contato_plano.SQ_Contato '. 
    		              		   'inner join plano on contato_Plano.SQ_Plano = plano.SQ_Plano '.
    							   'where Contato_plano.SQ_Contato in (select SQ_Contato from relacionamento where TP_Relacao = "P")'.
    							   'order by NM_Contato, NM_Plano')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
    	die();
    }
    if (!$SetProfissional = mysql_query('SELECT Contato.NM_Contato from Contato where SQ_Contato = '. $_REQUEST['SQ_Contato_Profissional'])){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
    	die();
    }
    else 
    	$NM_Contato_Profissional =  mysql_result($SetProfissional,0,NM_Contato);
    
    if (!$SetSala = mysql_query('SELECT * ' .
					    		' from sala' .
					    		' where DT_Ativacao > "0000-00-00" and ' .
					    		'       DT_Desativacao = "0000-00-00"' )){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Salas: ' . mysql_error() . '<br></a>';
    	//mysql_error() .'<br></a>';
    	die();
    }
    if (!$SetTipoSituacaoConsulta = mysql_query('SELECT * from Tipo_Situacao_Consulta order by NM_Tipo_Situacao_Consulta')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Situacao Consulta: ' . mysql_error() . '<br></a>';
    	die();
    }
    	 
    require "AgendaClasse.php";
    $ObjConsulta = new Agenda();
    
    // Alterar Contato
    if ($_REQUEST[Operacao] == "Mostrar" and $_REQUEST[SQ_Contato_Paciente]) { // Nenhuma operacao informada e Paciente informado - Mostrar dados da tabela
    	//echo 'Altera';
    	$ObjConsulta->DT_Consulta = $_REQUEST[DT_Consulta];
    	$ObjConsulta->HR_Consulta = $_REQUEST[HR_Consulta];
    	$ObjConsulta->SQ_Contato_Profissional = $_REQUEST['SQ_Contato_Profissional'];
    	if (!$ObjConsulta->GetReg($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na Busca : ' . $MsgErro .'</a>';
    	else {
    		// echo 'achei registro...' .  mysql_result($ObjConvenio->Regs,0,NM_Convenio) . '...' . $MsgErro ;
    		 
    		$_REQUEST[ContatoPlan] =  mysql_result($ObjConsulta->Regs,0,SQ_Contato_Paciente) * 10000 +
    		                          mysql_result($ObjConsulta->Regs,0,SQ_Plano);
    		$_REQUEST[SQ_Sala] = mysql_result($ObjConsulta->Regs,0,SQ_Sala);
    		$_REQUEST[TP_Situacao_Consulta] = mysql_result($ObjConsulta->Regs,0,TP_Situacao_Consulta);
    		//recupera relacoes
    	}
    }
    
    // Inserir Contato
    if ($_REQUEST[Operacao] == "Inserir"){  // Clicou botao inserir - insere
	    //Inserir Contato  
		$ObjConsulta->DT_Consulta = implode('/',  array_reverse(explode('-',$_REQUEST['DT_Consulta'])));
    	$ObjConsulta->HR_Consulta = $_REQUEST['HR_Consulta'];
    	$ObjConsulta->SQ_Contato_Profissional = $_REQUEST['SQ_Contato_Profissional'];
    	$ObjConsulta->SQ_Contato_Paciente = floor($_REQUEST['ContatoPlan'] / 10000);
    	$ObjConsulta->SQ_Plano            = $_REQUEST['ContatoPlan'] % 10000;
    	$ObjConsulta->SQ_Sala = $_REQUEST['SQ_Sala'];
    	$ObjConsulta->TP_Situacao_Consulta = $_REQUEST['TP_Situacao_Consulta']; 
		if (!$ObjConsulta->insert($MsgErro)){
		    echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
		 //   die();
		}
		else {
		   echo '<a class="MsgSucesso">Consulta Incluida com sucesso!</a>';
    	}
   	}
    
   	// Alterando Consulta
    if ($_REQUEST['Operacao'] == "Alterar"){ // Clicou botao alterar - alterar
    	$ObjConsulta->DT_Consulta = implode('/',  array_reverse(explode('-',$_REQUEST['DT_Consulta'])));
    	$ObjConsulta->HR_Consulta = $_REQUEST['HR_Consulta'];
    	$ObjConsulta->SQ_Contato_Profissional = $_REQUEST['SQ_Contato_Profissional'];
    	$ObjConsulta->SQ_Contato_Paciente = floor($_REQUEST['ContatoPlan'] / 10000);
    	$ObjConsulta->SQ_Plano            = $_REQUEST['ContatoPlan'] % 10000;
    	$ObjConsulta->SQ_Sala = $_REQUEST['SQ_Sala'];
    	$ObjConsulta->TP_Situacao_Consulta = $_REQUEST['TP_Situacao_Consulta'];
	    if (!$ObjConsulta->Edit($MsgErro))
	        echo '<a class="MsgErro">' . 'Erro na alteração Consulta: ' . $MsgErro .'</a>';
	    else {
	       	echo '<a class="MsgSucesso">Alteração Consulta com sucesso!</a>';
	    }
	}
   
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
		  label.MostraDados{
			float:left;
			width:50%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:left;
		 }
		 label.labelLongo{
			float:left;
			width:30%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
			}
		
        </style>
  </HEAD>
  <BODY>
    <form method="post" action="">
    	<fieldset>
       		<legend> <?php if (!$_REQUEST['SQ_Paciente']) echo "Inserindo "; else echo "Alterando ";?> Consulta</legend>
    		<label class="labelNormal">Data Consulta: </label>
    		<label class="MostraDados"><?php echo implode('/',  array_reverse(explode('-',$_REQUEST['DT_Consulta'])));?></label><br><br>
    		<label class="labelNormal">Hora Consulta: </label>
    		<label class="MostraDados"><?php echo $_REQUEST['HR_Consulta']?></label><br><br>
    		<label class="labelNormal">Profissional: </label>
    		<label class="MostraDados"><?php echo $NM_Contato_Profissional?></label><br><br>
    		
    		<label class="labelNormal">Paciente: </label>
    		<select name="ContatoPlan">
    		<?php 
				while ($RegContato = mysql_fetch_array($SetContato))
    	   			if ($_REQUEST[ContatoPlan] == ($RegContato[SQ_Contato] * 10000 + $RegContato[SQ_Plano]))
    	   				echo '<option selected  value="' , $RegContato[SQ_Contato] * 10000 + $RegContato[SQ_Plano] . '">' . $RegContato[NM_Contato]. ' -> ' . $RegContato[NM_Plano] . '</option>';
    				else
    					echo '<option           value="' , $RegContato[SQ_Contato] * 10000 + $RegContato[SQ_Plano]. '">' . $RegContato[NM_Contato]. ' -> ' . $RegContato[NM_Plano] . '</option>';  	
	    	?>
	    	</select>
     		<br><br>
     		<label class="labelNormal">Sala: </label>
     		<select name="SQ_Sala">
    		<?php 
				while ($RegSala = mysql_fetch_array($SetSala))
    	   			if ($_REQUEST[SQ_Sala] == $RegSala[SQ_Sala])
    	   				echo '<option selected  value="' , $RegSala[SQ_Sala] . '">' . $RegSala[NM_Sala] . '</option>';
    				else
    					echo '<option           value="' , $RegSala[SQ_Sala] . '">' . $RegSala[NM_Sala] . '</option>';
   	    	?>
   			</select>
     		<br><br>
     		<label class="labelNormal">Situacao: </label>
     		<select name="TP_Situacao_Consulta">
    		<?php 
				if ($_REQUEST[Operacao] == "Mostrar")
					$_REQUEST[TP_Situacao_Consulta] = 'M'; //Estou marcando - Default = Marcada
				while ($RegTipoSituacaoConsulta = mysql_fetch_array($SetTipoSituacaoConsulta))
    	   			if ($_REQUEST[TP_Situacao_Consulta] == $RegTipoSituacaoConsulta[TP_Situacao_Consulta])
    	   				echo '<option selected  value="' , $RegTipoSituacaoConsulta[TP_Situacao_Consulta] . '">' . 
				 										   $RegTipoSituacaoConsulta[NM_Tipo_Situacao_Consulta] . '</option>';
    				else
    					echo '<option           value="' , $RegTipoSituacaoConsulta[TP_Situacao_Consulta] . '">' . 
    													   $RegTipoSituacaoConsulta[NM_Tipo_Situacao_Consulta] . '</option>';
   	    	?>
   			</select>
     		<br><br>
           	
    		<a class="linkVoltar" href="AgendaLista.php">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$_REQUEST[SQ_Contato_Paciente]) 
    	    																	echo 'Inserir';else	echo 'Alterar'?>">
    	</fieldset>
    	<br>
    	<?php
    	// Listar Detalhes do Contato
    	/*	$Query =  'Select * from Contato where SQ_Contato = ' . (int)$REQ_SQ_Contato;
 
 	   		if (!$ListaContatos = mysql_query($Query)){
    			echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
    			die();
    		}
    		require "ContatoDetalhes.inc.php";
    */		
    	mysql_close($con);
		?>
    </form>
  </BODY>
</HTML>