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
			width:10%;
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
    require "tipocontatoClasse.php";
    $Objtipo_contato = new tipo_contato();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $Objtipo_contato->TP_Contato = $_REQUEST[TP_Contato];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$Objtipo_contato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da altera��o : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($Objtipo_contato->Regs,0,TP_Contato) . '...' . $Objtipo_contato->MsgErro ;
    echo '<form method="post" action="tipocontatoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Tipo de Contato</legend>';
    	   echo '<input type="hidden" name="TP_Contato" size="10" value=' . mysql_result($Objtipo_contato->Regs,0,TP_Contato) . '>';
           echo '<label class="labelNormal">Código tipo_contato:</label>';
           echo '<label class="MostraDados">' . mysql_result($Objtipo_contato->Regs,0,TP_Contato) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome Tipo Contato:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Tipo_Contato" size="30" value="' . mysql_result($Objtipo_contato->Regs,0,NM_Tipo_Contato) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="tipocontato.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($Objtipo_contato->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// S� apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $Objtipo_contato->TP_Contato = $_REQUEST[TP_Contato];
    $Objtipo_contato->NM_Tipo_Contato = $_REQUEST[NM_Tipo_Contato];
    
    //print_r('antes critica'. $Objtipo_contato->TP_Contato . $Objtipo_contato->NM_Tipo_Contato); 
 
    if (!$Objtipo_contato->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $Objtipo_contato->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: tipo_contatoEdit.php");
    
    mysql_close($con);
    //echo 'TP_Contato = ' . mysql_result($Objtipo_contato->Regs,0,TP_Contato);
    
    ?>
  </BODY>
</HTML>
