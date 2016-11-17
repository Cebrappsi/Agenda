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
			width:50%;
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
		
		label.labelConfirma{
			float:left;
			width:30%;
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
    echo '<form method="post" action="EmailDelete.php">';
    	echo '<fieldset>';
    		echo '<legend>Excluindo Email</legend>';
    		echo '<input type="hidden" name="SQ_Contato" size="10" value="' . $_REQUEST[SQ_Contato] . '">';
    		echo '<input type="hidden" name="TP_Email" size="1" value="' . $_REQUEST[TP_Email] . '">';
    		echo '<label class="labelNormal">Nome: </label>'; 
    		echo '<label class="MostraDados">' . mysql_result($ObjContato->Regs,0,NM_Contato) . '</label><br><br>';
    	    echo '<label class="labelNormal">Tipo Email: </label>';
    	    while ($RegTipoEmail = mysql_fetch_array($SetTipoEmail))
    	      if ($_REQUEST[TP_Email] == $RegTipoEmail[TP_Email])
    	   	     echo '<label class="MostraDados">' . $RegTipoEmail[NM_Tipo_Email] . '</label><br><br>';
    		echo '<label class="labelConfirma">Confirma exclusão de Email? (S/N) :</label>';
    		echo '<input class="Entrada" type="text" name="Confirma" size="1" value="'.$_REQUEST[Confirma]. '">';
    	echo '</fieldset>';
    	echo '<a class="linkVoltar" href="Contato.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" value="Excluir">';
    echo '</form>';
    
    //echo 'Antes--Request:'; print_r($_REQUEST); echo '.'; var_dump( $_REQUEST); echo '<br>';
    /*$arrpost = Array (SQ_Contato => (string)$_REQUEST[SQ_Contato] , Confirma => $_REQUEST[Confirma]);
    echo 'Depois-Arrpost:'; print_r($arrpost); echo '.'; var_dump($arrpost);echo '<br>';	
    */ 
    if (!isset($_REQUEST[Confirma]) || $_REQUEST[Confirma] == "")
        die();
    	
    if ((strtoupper($_REQUEST[Confirma]) <> 'S' && strtoupper($_REQUEST[Confirma]) <> 'N')){
         echo '<a class="MsgObs">Informe S ou N<br></a>';
		 die();
    }
    
    if (strtoupper($_REQUEST[Confirma]) == 'N'){
    	header("Location: Contato.php");
    	die();
    }
    
    //die('passou:' ) . $_REQUEST[Confirma] . '"' . $_REQUEST[SQ_Contato];
    //return;
    
    if (!$ObjEmail->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjContato->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Email : ' . $ObjContato->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjContato->MsgErro);
       echo '<br><a class="MsgSucesso">Email excluido com sucesso!</a>';
      //header("Location: Contato.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>