<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
         label.MostraDados{
			float:left;
			width:40%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:left;
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
	
	//Acesso o registro para preencher os campos
	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    if (!$ObjContato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na busca do contato : ' . MsgErro .'</a>';
	   die();
	}
	//echo mysql_result($ObjContato->Regs,0,SQ_Contato);
	// Preparacao para Área para Telefone
	require "TelefoneClasse.php";
	$ObjTelefone = new Telefone();
	$ObjTelefone->SQ_Contato = $_REQUEST[SQ_Contato];
	$ObjTelefone->NR_Telefone = $_REQUEST[NR_Telefone];
	if (!$ObjTelefone->GetReg($MsgErro)) {
		echo '<a class="MsgErro">' . 'Erro na busca do Telefone : ' . MsgErro .'</a>';
		die();
	}
	
// Preparacao para Área para Telefone/tipo uso, Operadora
	if (!$SetOperadora = mysql_query('SELECT * from Operadora order by NM_Operadora')){
		echo '<a class="MsgErro">Não foi possível efetuar consulta Operadora: ' . mysql_error() .'<br></a>';
		die();
	}
    if (!$SetTipoMobilidade = mysql_query('SELECT * from Tipo_Mobilidade order by NM_Tipo_Mobilidade')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Mobilidade: ' . mysql_error() .'<br></a>';
	   	die();
	}
	if (!$SetTipoUso = mysql_query('SELECT * from Tipo_uso order by NM_Tipo_Uso')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Uso: ' . mysql_error() .'<br></a>';
	   	die();
	}
	
    echo '<form method="post" action="TelefoneEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Telefone</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . $_REQUEST[SQ_Contato] . ' size="10" >';
    	   echo '<input type="hidden" name="NR_Telefone" value=' . $_REQUEST[NR_Telefone] . ' size="10" >';
    	   //echo '<label class="labelNormal">Nome: </label>'; 
    	   //echo '<label>' . mysql_result($ObjContato->Regs,0,NM_Contato) . '</label><br><br>';
    	   //echo '<label class="labelNormal">Telefone: </label>'; 
    	   //echo '<label>' . mysql_result($ObjTelefone->Regs,0,NR_Telefone) . '</label><br><br>';
    	   echo '<label class="labelNormal">Nome: </label>';
    	   echo '<label class="MostraDados">' . mysql_result($ObjContato->Regs,0,NM_Contato) . '</label><br><br>';
    	   echo '<label class="labelNormal">Nro Telefone: </label>';
    	   echo '<label class="MostraDados">' . $ObjTelefone->NR_Telefone . '</label><br><br>';
    	   echo '<label class="labelNormal">Operadora: </label>';
    	   echo '<select class="Entrada" name="SQ_Operadora">';
    	   while ($RegOperadora = mysql_fetch_array($SetOperadora)){
    	   	 if ($RegOperadora[SQ_Operadora] == mysql_result($ObjTelefone->Regs,0,SQ_Operadora))
    	   		echo '<option selected  value=' , $RegOperadora[SQ_Operadora] . '>' . $RegOperadora[NM_Operadora] . '</option>';
    	     else 
    	     	echo '<option           value=' , $RegOperadora[SQ_Operadora] . '>' . $RegOperadora[NM_Operadora] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Tipo Mobilidade: </label>';
    	   echo '<select name="TP_Mobilidade">';
    	   while ($RegTipoMobilidade = mysql_fetch_array($SetTipoMobilidade)){
    	   	 if ($RegTipoMobilidade[TP_Mobilidade] == mysql_result($ObjTelefone->Regs,0,TP_Mobilidade))
    	   		echo '<option selected  value=' , $RegTipoMobilidade[TP_Mobilidade] . '>' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    	     else 
    	     	echo '<option           value=' , $RegTipoMobilidade[TP_Mobilidade] . '>' . $RegTipoMobilidade[NM_Tipo_Mobilidade] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">Tipo Uso: </label>';
    	   echo '<select name="TP_Uso">';
    	   while ($RegTipoUso = mysql_fetch_array($SetTipoUso)){
    	   	 if ($RegTipoUso[TP_Uso] == mysql_result($ObjTelefone->Regs,0,TP_Uso))
    	   		echo '<option selected  value=' , $RegTipoUso[TP_Uso] . '>' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    	     else 
    	     	echo '<option           value=' , $RegTipoUso[TP_Uso] . '>' . $RegTipoUso[NM_Tipo_Uso] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<br>';
    	   echo '<label class="labelNormal">DDD: </label>';
    	   echo '<input class="Entrada" type="text" name="CD_DDD" size="2" value ="' . mysql_result($ObjTelefone->Regs,0,CD_DDD) . '"><BR>';   
    	echo '</fieldset>';
    	echo '<a class="linkVoltar" href="Contato.php">Voltar</a>';
        echo '<input class="Envia" type="submit" name="submit" value="Alterar"/>';
    echo '</form>';
    	  
    echo '<br>';
    
    if(empty($_POST['submit']))
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder altera��o
    //echo ('Alterando');
    /*
    
    */
    $ObjTelefone->SQ_Contato    = $_REQUEST[SQ_Contato];
    $ObjTelefone->NR_Telefone   = $_REQUEST[NR_Telefone];
    $ObjTelefone->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    $ObjTelefone->TP_Uso        = $_REQUEST[TP_Uso];
    $ObjTelefone->CD_DDD        = $_REQUEST[CD_DDD];
    $ObjTelefone->SQ_Operadora  = $_REQUEST[SQ_Operadora];
        
    if (!$ObjTelefone->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração do Telefone: ' . $ObjTelefone->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração Telefone com sucesso!</a>';
    }
    
    //header("Location: Contato.php
    
    mysql_close($con);
    //echo 'SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato);
    
    ?>
  </BODY>
</HTML>
