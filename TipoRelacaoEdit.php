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
    require "tipoRelacaoClasse.php";
    $Objtipo_Relacao = new tipo_Relacao();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $Objtipo_Relacao->TP_Relacao = $_REQUEST[TP_Relacao];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$Objtipo_Relacao->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($Objtipo_Relacao->Regs,0,TP_Relacao) . '...' . $Objtipo_Relacao->MsgErro ;
    echo '<form method="post" action="tipoRelacaoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Tipo de Relacao</legend>';
    	   echo '<input type="hidden" name="TP_Relacao" size="10" value=' . mysql_result($Objtipo_Relacao->Regs,0,TP_Relacao) . '>';
           echo '<label class="labelNormal">Código tipo Relacao:</label>';
           echo '<label class="MostraDados">' . mysql_result($Objtipo_Relacao->Regs,0,TP_Relacao) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome Tipo Relação:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Tipo_Relacao" size="30" value="' . mysql_result($Objtipo_Relacao->Regs,0,NM_Tipo_Relacao) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="tipoRelacao.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($Objtipo_Relacao->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// S� apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $Objtipo_Relacao->TP_Relacao = $_REQUEST[TP_Relacao];
    $Objtipo_Relacao->NM_Tipo_Relacao = $_REQUEST[NM_Tipo_Relacao];
    
    //print_r('antes critica'. $Objtipo_Relacao->TP_Relacao . $Objtipo_Relacao->NM_Tipo_Relacao); 
 
    if (!$Objtipo_Relacao->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $Objtipo_Relacao->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: tipo_RelacaoEdit.php");
    
    mysql_close($con);
    //echo 'TP_Relacao = ' . mysql_result($Objtipo_Relacao->Regs,0,TP_Relacao);
    
    ?>
  </BODY>
</HTML>
