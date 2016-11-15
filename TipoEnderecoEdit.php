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
    require "tipoEnderecoClasse.php";
    $Objtipo_Endereco = new tipo_Endereco();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $Objtipo_Endereco->TP_Endereco = $_REQUEST[TP_Endereco];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$Objtipo_Endereco->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($Objtipo_Endereco->Regs,0,TP_Endereco) . '...' . $Objtipo_Endereco->MsgErro ;
    echo '<form method="post" action="tipoEnderecoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Altera��o de Tipo de Endereco</legend>';
    	   echo '<input type="hidden" name="TP_Endereco" size="10" value=' . mysql_result($Objtipo_Endereco->Regs,0,TP_Endereco) . '>';
           echo '<label class="labelNormal">Código tipo Endereço:</label>';
           echo '<label class="MostraDados">' . mysql_result($Objtipo_Endereco->Regs,0,TP_Endereco) . '</Label><br><BR>';
    	   echo '<label class="labelNormal">Nome Tipo Endereço:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Tipo_Endereco" size="30" value="' . mysql_result($Objtipo_Endereco->Regs,0,NM_Tipo_Endereco) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="tipoEndereco.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($Objtipo_Endereco->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// Só apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $Objtipo_Endereco->TP_Endereco = $_REQUEST[TP_Endereco];
    $Objtipo_Endereco->NM_Tipo_Endereco = $_REQUEST[NM_Tipo_Endereco];
    
    //print_r('antes critica'. $Objtipo_Endereco->TP_Endereco . $Objtipo_Endereco->NM_Tipo_Endereco); 
 
    if (!$Objtipo_Endereco->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $Objtipo_Endereco->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: tipo_EnderecoEdit.php");
    
    mysql_close($con);
    //echo 'TP_Endereco = ' . mysql_result($Objtipo_Endereco->Regs,0,TP_Endereco);
    
    ?>
  </BODY>
</HTML>