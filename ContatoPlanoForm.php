<?php 
   require "comum.php";
   //echo 'In-'. $_REQUEST[Operacao];
    if (!$con = conecta_BD($MsgErro)){
    	echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
    	die();
    }
	// preparacao das listas a serem apresentadas    		
    if (!$SetConvenioPlano = mysql_query('SELECT Convenio.SQ_Convenio,Convenio.NM_Convenio, Plano.SQ_Plano,Plano.NM_Plano ' .
       									 'FROM Plano ' .
								         'inner join Convenio on Plano.SQ_Convenio = Convenio.SQ_Convenio '. 
								         'where Plano.DT_Desativacao = "0000-00-00"')){
    	echo '<a class="MsgErro">Não foi possível efetuar consulta Convenios/Planos: ' . mysql_error() .'<br></a>';
    	die();
    }
    
    // Mostrar Contato / Plano
    require "ContatoPlanoClasse.php";
    $ObjContatoPlano = new ContatoPlano();
    
    if ($_REQUEST[Operacao] == "Mostrar") { // Nenhuma operacao informada e Chave informada - Mostrar dados da tabela
    	//echo 'Altera E';
    	$ObjContatoPlano->SQ_Contato  = $_REQUEST[SQ_Contato];
    	$ObjContatoPlano->SQ_Convenio = $_REQUEST[SQ_Convenio];
    	$ObjContatoPlano->SQ_Plano    = $_REQUEST[SQ_Plano];
    	if (!$ObjContatoPlano->GetReg($MsgErro)) {
    		echo '<a class="MsgErro">' . 'Erro na busca do Contato Plano : ' . MsgErro .'</a>';
    	}
    	else{
    		$_REQUEST[DT_Validade] = implode('/',array_reverse(explode('-',mysql_result($ObjContatoPlano->Regs,0,DT_Validade))));
    		$_REQUEST[NR_Inscricao]      = mysql_result($ObjContatoPlano->Regs,0,NR_Inscricao);	
    	} 
    }	
    
    
    //inserindo Contato Plano             
    if ($_REQUEST[Operacao] == 'Inserir'){ //Inserir
    	//echo 'Inserindo contato plano';
    	$ObjContatoPlano->SQ_Contato  = $_REQUEST[SQ_Contato];
    	$ObjContatoPlano->SQ_Convenio = floor($_REQUEST[ConvPlan] / 10000);
    	$ObjContatoPlano->SQ_Plano    = $_REQUEST[ConvPlan] % 10000;
    	$ObjContatoPlano->NR_Inscricao = $_REQUEST[NR_Inscricao];
    	$ObjContatoPlano->DT_Validade  = $_REQUEST[DT_Validade];
    	if (!$ObjContatoPlano->insert($MsgErro))
    		echo '<a class="MsgErro">Erro na inserção: ' . $MsgErro .'<br></a>';
    	else
    		echo '<a class="MsgSucesso">Contato Plano Incluido com sucesso!</a>';
    		
    	//unset($_REQUEST[TP_Endereco]);

    }

    if ($_REQUEST[Operacao] == 'Alterar'){ //Alterar
    	$ObjContatoPlano->SQ_Contato  = $_REQUEST[SQ_Contato];
    	$ObjContatoPlano->SQ_Convenio = floor($_REQUEST[ConvPlan] / 10000);
    	$ObjContatoPlano->SQ_Plano    = $_REQUEST[ConvPlan] % 10000;
    	$ObjContatoPlano->NR_Inscricao= $_REQUEST[NR_Inscricao];
    	$ObjContatoPlano->DT_Validade = $_REQUEST[DT_Validade];
    	
    	if (!$ObjContatoPlano->Edit($MsgErro))
    		echo '<a class="MsgErro">' . 'Erro na alteração do ContatoPlano: ' . $ObjContatoPlano->MsgErro .'</a>';
    	else {
    		//mysql_query("commit");
    		echo '<a class="MsgSucesso">Alteração ContatoPlano com sucesso!</a>';
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
       		<legend> <?php if (!$_REQUEST[SQ_Convenio]) echo "Inserindo "; else echo "Alterando ";?> Plano do Contato</legend>
    		<label class="labellongo">Nome: <?php echo $_REQUEST[NM_Contato]?></label>
    		<br>
    	</fieldset>
    	<br>
    	<fieldset>
    		<label class="labelNormal">Conv / Plano: </label>
    		<select name="ConvPlan">
    		<?php 
    			while ($RegConvenioPlano = mysql_fetch_array($SetConvenioPlano)){
    				
    				if ($_REQUEST[SQ_Convenio] == $RegConvenioPlano[SQ_Convenio] && $_REQUEST[SQ_Plano] == $RegConvenioPlano[SQ_Plano])
    					echo '<option selected value=' . ((int)$RegConvenioPlano[SQ_Convenio] * 10000 + (int)$RegConvenioPlano[SQ_Plano]) . 
    											'>' . $RegConvenioPlano[NM_Convenio] . '->' . $RegConvenioPlano[NM_Plano] . '</option>';
    				else	
    					echo '<option          value=' . ((int)$RegConvenioPlano[SQ_Convenio] * 10000 + (int)$RegConvenioPlano[SQ_Plano]) . 
    											'>' . $RegConvenioPlano[NM_Convenio] . '->' . $RegConvenioPlano[NM_Plano] . '</option>';
    			}
    		?>
    		</select>
    		<br>
    		<label class="labelNormal">NR Inscricao: </label>
    		<input class="Entrada" type="text" name="NR_Inscricao" size="10" value ="<?php echo $_REQUEST[NR_Inscricao]?>"><br>
     		<label class="LabelNormal">Data Validade: </label>
    		<input class="Entrada" type="date" name="DT_Validade" size="10" value ="<?php echo $_REQUEST[DT_Validade]?>"><br>
    		<a class="linkVoltar" href="ContatoForm.php?SQ_Contato=<?php echo $_REQUEST[SQ_Contato]
														. '&Operacao=' . urlencode("Mostrar Contato")?>">Voltar</a>
    	    <input class="Envia" type="submit" name="Operacao" value="<?php if (!$_REQUEST[SQ_Convenio]) echo 'Inserir'; else echo 'Alterar';?>">
    	</fieldset>
    	<br>  
 	  <?php
 	  
      // Listar Detalhes do Contato
      $Query =  'Select * from Contato where SQ_Contato = ' . (int)$_REQUEST[SQ_Contato];
      
      if (!$ListaContatos = mysql_query($Query)){
      	echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
      	die();
      }
      require "ContatoDetalhes.inc.php";
      mysql_close($con);
     ?>
    </form>
  </BODY>
</HTML>