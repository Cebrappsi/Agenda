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
    require "UFClasse.php";
    $ObjUF = new UF();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjUF->CD_UF = $_REQUEST[CD_UF];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$ObjUF->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($ObjUF->Regs,0,CD_UF) . '...' . $ObjUF->MsgErro ;
    echo '<form method="post" action="UFEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Unidade da Federação</legend>';
    	   echo '<input type="hidden" name="CD_UF" size="10" value=' . mysql_result($ObjUF->Regs,0,CD_UF) . '>';
           echo '<label class="labelNormal">Código UF:</label>';
           echo '<label class="MostraDados">' . mysql_result($ObjUF->Regs,0,CD_UF) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome UF:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_UF" size="30" value="' . mysql_result($ObjUF->Regs,0,NM_UF) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="UF.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjUF->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// Só apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $ObjUF->CD_UF = $_REQUEST[CD_UF];
    $ObjUF->NM_UF = $_REQUEST[NM_UF];
    
    //print_r('antes critica'. $ObjUF->CD_UF . $ObjUF->NM_UF); 
 
    if (!$ObjUF->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjUF->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: UFEdit.php");
    
    mysql_close($con);
    //echo 'CD_UF = ' . mysql_result($ObjUF->Regs,0,CD_UF);
    
    ?>
  </BODY>
</HTML>
