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
	
	//Acesso o registro para preencher os campos
	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    if (!$ObjContato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na busca do contato : ' . MsgErro .'</a>';
	   die();
	}
	//echo mysql_result($ObjContato->Regs,0,SQ_Contato);
	// Preparacao para Área para Email
	require "EmailClasse.php";
	$ObjEmail = new Email();
	$ObjEmail->SQ_Contato = $_REQUEST[SQ_Contato];
	$ObjEmail->TP_Email = $_REQUEST[TP_Email];
	if (!$ObjEmail->GetReg($MsgErro)) {
		echo '<a class="MsgErro">' . 'Erro na busca do Email : ' . MsgErro .'</a>';
		die();
	}
	
    if (!$SetTipoEmail = mysql_query('SELECT * from Tipo_Email order by NM_Tipo_Email')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Email: ' . mysql_error() .'<br></a>';
	   	die();
	}
	
    echo '<form method="post" action="EmailEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Email</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . $_REQUEST[SQ_Contato] . ' size="10" >';
    	   echo '<input type="hidden" name="TP_Email" value=' . $_REQUEST[TP_Email] . ' size="1" >';
    	   echo '<p>Nome: ' . mysql_result($ObjContato->Regs,0,NM_Contato) . '<br></p>';
    	   echo '<p>Tipo Email: ';
    	   while ($RegTipoEmail = mysql_fetch_array($SetTipoEmail))
    	   	if ($_REQUEST[TP_Email] == $RegTipoEmail[TP_Email])
    	   	    echo $RegTipoEmail[NM_Tipo_Email];
    	   echo '<br></p>';
    	   echo '<label class="labelNormal">Email: </label>';
    	   echo '<input type="email" name="Email" size="50" autofocus value = "' . mysql_result($ObjEmail->Regs,0,Email) . '"><br>';
    	
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
    $ObjEmail->SQ_Contato  = $_REQUEST[SQ_Contato];
    $ObjEmail->TP_Email    = $_REQUEST[TP_Email];
    $ObjEmail->Email       = $_REQUEST[Email];
        
    if (!$ObjEmail->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração do Email: ' . $ObjEmail->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração Email com sucesso!</a>';
    }
    
    //header("Location: Contato.php
    
    mysql_close($con);
    //echo 'SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato);
    
    ?>
  </BODY>
</HTML>
