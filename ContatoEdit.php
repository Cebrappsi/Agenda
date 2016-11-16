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
    require "ContatoClasse.php";
    $ObjContato = new Contato();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    
    //Acesso o registro para preencher os campos
    if (!$ObjContato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
    //echo 'achei registro...' .  mysql_result($ObjContato->Regs,0,SQ_Contato) . '...' . //$ObjContato->MsgErro ;
    //echo 'SQ_Contato1: ' . mysql_result($ObjContato->Regs,0,NM_Contato);
    echo '<form method="post" action="ContatoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Contato de Telefonia</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . mysql_result($ObjContato->Regs,0,SQ_Contato) . ' size="10" />';
    	   echo '<label class="labelNormal">Código:</label>';
    	   echo '<input class="Entrada" type="text" name="SQ_Contato" value="' . mysql_result($ObjContato->Regs,0,SQ_Contato) . '" size="2" /><br />';
    	   echo '<label class="labelNormal">Nome:</label></label>';
    	   echo '<input class="Entrada" type="text" name="NM_Contato" value="' . mysql_result($ObjContato->Regs,0,NM_Contato) . '" size="30" /><br />';
    	echo '</fieldset>';
    	   
    	echo '<a class="linkVoltar" href="Contato.php">Voltar</a>';
    	echo '<input class="Envia" type="submit" name="submit" value="Alterar"/>';
    echo '</form>';
    echo '<br>';
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjContato->Regs);
    //Primeira apresentacao da tela
    if(empty($_POST['submit']))
    	die();//// S� apresenta os dados
    
    //Houve altera��o - proceder altera��o
    //echo ('Alterando');
    
    $ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    $ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    $ObjContato->NM_Contato = $_REQUEST[NM_Contato];
    
    if (!$ObjContato->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjContato->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Contato.php
    
    mysql_close($con);
    //echo 'SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato);
    
    ?>
  </BODY>
</HTML>
