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
	// Preparacao para Área para Telefone
	require "TelefoneClasse.php";
	$ObjTelefone = new Telefone();
	$ObjTelefone->SQ_Contato = $_REQUEST[SQ_Contato];
	$ObjTelefone->NR_Telefone = $_REQUEST[NR_Telefone];
	if (!$ObjTelefone->GetReg($MsgErro)) {
		echo '<a class="MsgErro">' . 'Erro na busca do Telefone : ' . MsgErro .'</a>';
		die();
	}
	
    echo '<form method="post" action="TelefoneDelete.php">';
    	echo '<fieldset>';
    		echo '<legend>Excluindo Telefone</legend>';
    		echo '<input type="hidden" name="SQ_Contato" size="10" value="' . $_REQUEST[SQ_Contato] . '">';
    		echo '<input type="hidden" name="NR_Telefone" size="1" value="' . $_REQUEST[NR_Telefone] . '">';
    		echo '<label class="labelNormal">Nome: </label>'; 
    		echo '<label class="MostraDados">' . mysql_result($ObjContato->Regs,0,NM_Contato) . '</label><br><br>';
    	    echo '<label class="labelNormal">Nro Telefone: </label>';
    	    echo '<label class="MostraDados">' . $ObjTelefone->NR_Telefone . '</label><br><br>';
    		echo '<label class="labelConfirma">Confirma exclusão de Telefone? (S/N) :</label>';
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
    
    if (!$ObjTelefone->Delete($MsgErro))
       //MsgPopup('Erro na Exclus�o do Registro : ' . $ObjContato->MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Telefone : ' . $ObjContato->MsgErro .'</a>';
    else 
      // MsgPopup( $ObjContato->MsgErro);
       echo '<br><a class="MsgSucesso">Telefone excluido com sucesso!</a>';
      //header("Location: Contato.php");
    mysql_close($con);
    ?>
  </BODY>
</HTML>