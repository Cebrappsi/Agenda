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
			width:10%;
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
    require "ContatoClasse.php";
    $ObjContato = new Contato();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
	if (!$SetTipos = mysql_query('SELECT * from Tipo_Relacionamento order by NM_Tipo_Relacao')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Contato: ' . mysql_error() .'<br></a>';
		die();
	}
        
    //Acesso o registro para preencher os campos
	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    if (!$ObjContato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
	//echo mysql_result($ObjContato->Regs,0,SQ_Contato);
	//Conjunto das Relacoes do contato com a clinica
	if (!$SetPapel = mysql_query('SELECT * ' . 
			' from Relacionamento ' .
			' where SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato) )){
			echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Contato: ' .
					mysql_error() .'<br></a>';
			die();
	}
    //echo 'achei registro...' .  mysql_num_rows($SetPapel);
    //echo 'SQ_Contato1: ' . mysql_result($ObjContato->Regs,0,NM_Contato);
    echo '<form method="post" action="ContatoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Contato</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . mysql_result($ObjContato->Regs,0,SQ_Contato) . ' size="10" >';
    	   echo '<label class="labelNormal">Nome:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Contato" size="50" autofocus value = "' . mysql_result($ObjContato->Regs,0,NM_Contato) . '">';
    	   echo '<label> Tipo Contato: </label>';
    	   //echo mysql_result($ObjContato->Regs,0,TP_Relacao);
    	   while ($RegTipos = mysql_fetch_array($SetTipos)){ //Apresenta todos os tipos
    	   	  //print_r ($RegTipos[TP_Relacao] . $RegTipos[NM_Tipo_Relacao] );
    	   	  echo '<input type="checkbox" class="Entrada" name="TP_Relacao[' . $RegTipos[TP_Relacao] . ']"';
    	   	  mysql_data_seek($SetPapel, 0); //Volta ponteiro dos papeis
    	   	  while ($RegPapel = mysql_fetch_array($SetPapel)){ 
    	   	  	if ($RegTipos[TP_Relacao] == $RegPapel[TP_Relacao]){
    	            echo 'checked';
    	   	  	    break;    	   	 	
    	   	  	}
    	   	  }
    	   	  echo  '>' . $RegTipos[NM_Tipo_Relacao] . '&nbsp&nbsp';
    	   	  
    	   }
    	   echo '<br>';
    	   echo '<label class="labelNormal">Nascimento:</label>';
    	   echo '<input class="Entrada" type="date" name="DT_Nascimento" size="10" value=' . mysql_result($ObjContato->Regs,0,DT_Nascimento) . '><br>';
    	   echo '<label class="labelNormal">Identificacao: </label>';
    	   echo '<input class="Entrada" type="text" name="Identificacao" size="50" value = ' . mysql_result($ObjContato->Regs,0,Identificacao) . '><br>';
    	   echo '<label class="labelNormal">Observacoes: </label>';
    	   echo '<textarea rows="4" cols="100" class="Entrada" name="Observacoes" size="100" >' . mysql_result($ObjContato->Regs,0,Observacoes) . '</textarea>';   	   
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="Contato.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar"/>';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjContato->Regs);
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))
    	die();//// S� apresenta os dados
    
    //Houve alteração - proceder altera��o
    //echo ('Alterando');
    /*
     $artipo = $_REQUEST[TP_Relacao];
    mysql_data_seek($SetTipos, 0);
    while ($RegTipos = mysql_fetch_array($SetTipos)){
    //echo 'tipo='. $RegTipos[TP_Relacao] . '-'. $artipo[$RegTipos[TP_Relacao]] .'/';
    if  ($artipo[$RegTipos[TP_Relacao]] == "on"){
    $ObjContato->TP_Relacao = $RegTipos[TP_Relacao];
    //echo $RegTipos[TP_Relacao];
    }
    }
    */
    $ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
    $ObjContato->DT_Nascimento = $_REQUEST[DT_Nascimento];
    $ObjContato->Identificacao = $_REQUEST[Identificacao];
    $ObjContato->Observacoes = $_REQUEST[Observacoes];
        
    if (!$ObjContato->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjContato->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    
    //Alterando Papeis do contato
    $artipo = $_REQUEST[TP_Relacao];
    mysql_data_seek($SetTipos, 0);
    while ($tipos = mysql_fetch_array($SetTipos)){
    	//echo 'tipo='. $tipos[TP_Relacao] . '-'. $artipo[$tipos[TP_Relacao]] .'/';
    	$ObjContato->TP_Relacao = $tipos[TP_Relacao];
    	//echo $tipos[TP_Relacao];
    	if  ($artipo[$tipos[TP_Relacao]] == "on"){
    		if (!$ObjContato->insertPapel($Con,$MsgErro))
    			echo '<a class="MsgErro">Erro na inserção de Papel: ' . $ObjContato->MsgErro .'<br></a>';
    		else
    			echo '<a class="MsgSucesso">Papel Incluido com sucesso!</a>';
    	}
    	else{
    		if (!$ObjContato->DeletePapel($Con,$MsgErro))
    			echo '<a class="MsgErro">Erro na exclusão de Papel: ' . $ObjContato->MsgErro .'<br></a>';
    		else
    			echo '<a class="MsgSucesso">Papel Incluido com sucesso!</a>';
    	}
    }
    
    
    
    //header("Location: Contato.php
    
    mysql_close($con);
    //echo 'SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato);
    
    ?>
  </BODY>
</HTML>
