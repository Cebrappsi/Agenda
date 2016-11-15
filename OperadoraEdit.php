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
    require "OperadoraClasse.php";
    $ObjOperadora = new Operadora();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjOperadora->SQ_Operadora = $_REQUEST[SQ_Operadora];
    
    //Acesso o registro para preencher os campos
    if (!$ObjOperadora->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($ObjOperadora->Regs,0,SQ_Operadora) . '...' . //$ObjOperadora->MsgErro ;
    //echo 'CD_Operadora1: ' . mysql_result($ObjOperadora->Regs,0,NM_Operadora);
    echo '<form method="post" action="OperadoraEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Operadora de Telefonia</legend>';
    	   echo '<input type="hidden" name="SQ_Operadora" value=' . mysql_result($ObjOperadora->Regs,0,SQ_Operadora) . ' size="10" />';
    	   echo '<label class="labelNormal">Código:</label>';
    	   echo '<input class="Entrada" type="text" name="CD_Operadora" value="' . mysql_result($ObjOperadora->Regs,0,CD_Operadora) . '" size="2" /><br />';
    	   echo '<label class="labelNormal">Nome:</label></label>';
    	   echo '<input class="Entrada" type="text" name="NM_Operadora" value="' . mysql_result($ObjOperadora->Regs,0,NM_Operadora) . '" size="30" /><br />';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="operadora.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar"/>';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjOperadora->Regs);
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))
    	die();//// S� apresenta os dados
    
    //Houve altera��o - proceder altera��o
    //echo ('Alterando');
    
    $ObjOperadora->SQ_Operadora = $_REQUEST[SQ_Operadora];
    $ObjOperadora->CD_Operadora = $_REQUEST[CD_Operadora];
    $ObjOperadora->NM_Operadora = $_REQUEST[NM_Operadora];
    
    if (!$ObjOperadora->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjOperadora->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Operadora.php
    
    mysql_close($con);
    //echo 'CD_Operadora = ' . mysql_result($ObjOperadora->Regs,0,CD_Operadora);
    
    ?>
  </BODY>
</HTML>
