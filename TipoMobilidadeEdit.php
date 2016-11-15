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
			width:15%;
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
    require "tipoMobilidadeClasse.php";
    $Objtipo_Mobilidade = new tipo_Mobilidade();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $Objtipo_Mobilidade->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$Objtipo_Mobilidade->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($Objtipo_Mobilidade->Regs,0,TP_Mobilidade) . '...' . $Objtipo_Mobilidade->MsgErro ;
    echo '<form method="post" action="tipoMobilidadeEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Tipo de Mobilidade do Telefone</legend>';
    	   echo '<input type="hidden" name="TP_Mobilidade" size="10" value=' . mysql_result($Objtipo_Mobilidade->Regs,0,TP_Mobilidade) . '>';
           echo '<label class="labelNormal">Código tipo Mobilidade:</label>';
           echo '<label class="MostraDados">' . mysql_result($Objtipo_Mobilidade->Regs,0,TP_Mobilidade) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome Tipo Mobilidade:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Tipo_Mobilidade" size="30" value="' . mysql_result($Objtipo_Mobilidade->Regs,0,NM_Tipo_Mobilidade) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="tipoMobilidade.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($Objtipo_Mobilidade->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// Só apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $Objtipo_Mobilidade->TP_Mobilidade = $_REQUEST[TP_Mobilidade];
    $Objtipo_Mobilidade->NM_Tipo_Mobilidade = $_REQUEST[NM_Tipo_Mobilidade];
    
    //print_r('antes critica'. $Objtipo_Mobilidade->TP_Mobilidade . $Objtipo_Mobilidade->NM_Tipo_Mobilidade); 
 
    if (!$Objtipo_Mobilidade->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $Objtipo_Mobilidade->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: tipo_MobilidadeEdit.php");
    
    mysql_close($con);
    //echo 'TP_Mobilidade = ' . mysql_result($Objtipo_Mobilidade->Regs,0,TP_Mobilidade);
    
    ?>
  </BODY>
</HTML>