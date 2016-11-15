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
    require "tipoEmailClasse.php";
    $Objtipo_Email = new tipo_Email();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $Objtipo_Email->TP_Email = $_REQUEST[TP_Email];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$Objtipo_Email->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da altera��o : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($Objtipo_Email->Regs,0,TP_Email) . '...' . $Objtipo_Email->MsgErro ;
    echo '<form method="post" action="tipoEmailEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Tipo de Email</legend>';
    	   echo '<input type="hidden" name="TP_Email" size="10" value=' . mysql_result($Objtipo_Email->Regs,0,TP_Email) . '>';
           echo '<label class="labelNormal">Código tipo_Email:</label>';
           echo '<label class="MostraDados">' . mysql_result($Objtipo_Email->Regs,0,TP_Email) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome Tipo Email:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Tipo_Email" size="30" value="' . mysql_result($Objtipo_Email->Regs,0,NM_Tipo_Email) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="tipoEmail.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($Objtipo_Email->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// S� apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $Objtipo_Email->TP_Email = $_REQUEST[TP_Email];
    $Objtipo_Email->NM_Tipo_Email = $_REQUEST[NM_Tipo_Email];
    
    //print_r('antes critica'. $Objtipo_Email->TP_Email . $Objtipo_Email->NM_Tipo_Email); 
 
    if (!$Objtipo_Email->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na altera��o : ' . $Objtipo_Email->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Altera��o com sucesso!</a>';
    }
    //header("Location: tipo_EmailEdit.php");
    
    mysql_close($con);
    //echo 'TP_Email = ' . mysql_result($Objtipo_Email->Regs,0,TP_Email);
    
    ?>
  </BODY>
</HTML>
