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
    require "ConvenioClasse.php";
    $ObjConvenio = new Convenio();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjConvenio->SQ_Convenio = $_REQUEST[SQ_Convenio];
    
    //Acesso o registro para preencher os campos
    if (!$ObjConvenio->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
   // echo 'achei registro...' .  mysql_result($ObjConvenio->Regs,0,SQ_Convenio) . '...' . $ObjConvenio->MsgErro ;
   // echo 'NM_Convenio: ' . mysql_result($ObjConvenio->Regs,0,NM_Convenio);
    ?>
	<form method="post" action="ConvenioEdit.php">
    	<fieldset>
    	   <legend>Alteração de Convenio</legend>
    	   <input type="hidden" name="SQ_Convenio" value= 
    	   		  <?php echo mysql_result($ObjConvenio->Regs,0,SQ_Convenio) ?> >
    	   <label class="labelNormal">Nome:</label>
    	   <input class="Entrada" type="text" name="NM_Convenio" size="30" value=
    	   		  <?php echo '"'. mysql_result($ObjConvenio->Regs,0,NM_Convenio) . '"' ?>  ><br><br>
    	   	<label class="labelNormal">Data Ativação:</label>
   	       	<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=
    	    	  <?php echo mysql_result($ObjConvenio->Regs,0,DT_Ativacao) ?> ><br><br>
    	    <label class="labelNormal">Data Desativação:</label>
    	    <input class="Entrada" type="date" name="DT_Desativacao" size="10" value=
    	    	   <?php echo mysql_result($ObjConvenio->Regs,0,DT_Desativacao) ?> ><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="Convenio.php">Voltar</a>
    	<input class="Envia" type="submit" name="submit" value="Alterar">
    </form>
    <br>
    <?php 
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjConvenio->Regs);

    if(empty($_POST['submit']))
        //Primeira apresentacao da tela
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder alteração
    //echo ('Alterando');
    
    $ObjConvenio->SQ_Convenio = $_REQUEST[SQ_Convenio];
    $ObjConvenio->NM_Convenio = $_REQUEST[NM_Convenio];
    $ObjConvenio->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjConvenio->DT_Desativacao = $_REQUEST[DT_Desativacao];
    
    if (!$ObjConvenio->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjConvenio->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Convenio.php
    
    mysql_close($con);
    //echo 'SQ_Convenio = ' . mysql_result($ObjConvenio->Regs,0,SQ_Convenio);
    ?>
  </BODY>
</HTML>
