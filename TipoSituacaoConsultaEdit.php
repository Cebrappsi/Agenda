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
    require "TipoSituacaoConsultaClasse.php";
    $ObjTipo_Situacao_Consulta = new Tipo_Situacao_Consulta();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
	
    $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = $_REQUEST[TP_Situacao_Consulta];
    
    //print_r ($_REQUEST);
    //Acesso o registro para preencher os campos
    if (!$ObjTipo_Situacao_Consulta->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na consulta da alteração : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($ObjTipo_Situacao_Consulta->Regs,0,TP_Situacao_Consulta) . '...' . $ObjTipo_Situacao_Consulta->MsgErro ;
    echo '<form method="post" action="TipoSituacaoConsultaEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Tipo de Situacao Consulta</legend>';
    	   echo '<input type="hidden" name="TP_Situacao_Consulta" size="1" value=' . mysql_result($ObjTipo_Situacao_Consulta->Regs,0,TP_Situacao_Consulta) . '>';
    	   echo '<label class="labelNormal">Tipo Situacao Consulta:</label>';
           echo '<label class="MostraDados">' . mysql_result($ObjTipo_Situacao_Consulta->Regs,0,TP_Situacao_Consulta) . '</Label><br><BR><BR>';
    	   echo '<label class="labelNormal">Nome Situacao Consulta:</label>';
    	   echo '<input class="Entrada" type="text" name="NM_Situacao_Consulta" size="30" value="' . mysql_result($ObjTipo_Situacao_Consulta->Regs,0,NM_Situacao_Consulta) . '"><br>';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="TipoSituacaoConsulta.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar">';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjTipo_Situacao_Consulta->Regs);
    
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))        
    	die();//// Só apresenta os dados
 
    //Houve alteraçao - proceder altera��o
    $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta = strtoupper($_REQUEST[TP_Situacao_Consulta]);
    $ObjTipo_Situacao_Consulta->NM_Situacao_Consulta = $_REQUEST[NM_Situacao_Consulta];
    
    //print_r('antes critica'. $ObjTipo_Situacao_Consulta->TP_Situacao_Consulta . $ObjTipo_Situacao_Consulta->NM_Situacao_Consulta); 
 
    if (!$ObjTipo_Situacao_Consulta->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjTipo_Situacao_Consulta->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Tipo_SituacaoConsultaEdit.php");
    
    mysql_close($con);
    //echo 'TP_Situacao_Consulta = ' . mysql_result($ObjTipo_Situacao_Consulta->Regs,0,TP_Situacao_Consulta);
    
    ?>
  </BODY>
</HTML>