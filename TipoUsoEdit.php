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
    require "tipoUsoClasse.php";
    $Objtipo_Uso = new tipo_Uso();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $Objtipo_Uso->TP_Uso = $_REQUEST[TP_Uso];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$Objtipo_Uso->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($Objtipo_Uso->Regs,0,TP_Uso) . '...' . $Objtipo_Uso->MsgErro ;
    echo '<form method="post" action="tipoUsoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Tipo de Uso do Telefone</legend>';
    	   echo '<input type="hidden" name="TP_Uso" size="10" value=' . mysql_result($Objtipo_Uso->Regs,0,TP_Uso) . '>';
           echo '<label class="labelNormal">Código tipo Uso:</label>';
           echo '<label class="MostraDados">' . mysql_result($Objtipo_Uso->Regs,0,TP_Uso) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome Tipo Uso:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Tipo_Uso" size="30" value="' . mysql_result($Objtipo_Uso->Regs,0,NM_Tipo_Uso) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="tipoUso.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($Objtipo_Uso->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// Só apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $Objtipo_Uso->TP_Uso = $_REQUEST[TP_Uso];
    $Objtipo_Uso->NM_Tipo_Uso = $_REQUEST[NM_Tipo_Uso];
    
    //print_r('antes critica'. $Objtipo_Uso->TP_Uso . $Objtipo_Uso->NM_Tipo_Uso); 
 
    if (!$Objtipo_Uso->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $Objtipo_Uso->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: tipo_UsoEdit.php");
    
    mysql_close($con);
    //echo 'TP_Uso = ' . mysql_result($Objtipo_Uso->Regs,0,TP_Uso);
    
    ?>
  </BODY>
</HTML>