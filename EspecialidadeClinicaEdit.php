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
    require "EspecialidadeClinicaClasse.php";
    $ObjEspecialidade_Clinica = new Especialidade_Clinica();
    $con = conecta_BD($MsgErro);
    if (!$con) {
	   echo '<a class="MsgErro">' . 'Erro: ' . MsgErro .'</a>';
	   die();
	}
    
    $ObjEspecialidade_Clinica->SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
    $ObjEspecialidade_Clinica->Tempo_Atendimento = $_REQUEST[Tempo_Atendimento];
    
    //Acesso o registro para preencher os campos
    if (!$ObjEspecialidade_Clinica->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na alteraçao : ' . MsgErro .'</a>';
	   die();
	}
   // echo 'achei registro...' .  mysql_result($ObjEspecialidade_Clinica->Regs,0,SQ_Especialidade_Clinica) . '...' . $ObjEspecialidade_Clinica->MsgErro ;
   // echo 'NM_Especialidade_Clinica: ' . mysql_result($ObjEspecialidade_Clinica->Regs,0,NM_Especialidade_Clinica);
    ?>
	<form method="post" action="EspecialidadeClinicaEdit.php">
    	<fieldset>
    	   <legend>Alteração de Especialidade_Clinica</legend>
    	   <input type="hidden" name="SQ_Especialidade_Clinica" value= 
    	   		  <?php echo mysql_result($ObjEspecialidade_Clinica->Regs,0,SQ_Especialidade_Clinica) ?> >
    	   <label class="labelNormal">Nome Especialidade:</label>
    	   <input class="Entrada" type="text" name="NM_Especialidade_Clinica" size="30" value=
    	   		  <?php echo '"'. mysql_result($ObjEspecialidade_Clinica->Regs,0,NM_Especialidade_Clinica) . '"' ?>  ><br><br>
           <label class="labelNormal">Tempo Atendimetno:</label>
    	   <input class="Entrada" type="text" name="Tempo_Atendimento" size="3" value=
    	   		  <?php echo '"'. mysql_result($ObjEspecialidade_Clinica->Regs,0,Tempo_Atendimento) . '"' ?>  ><br><br>    	   		  
    	</fieldset>
    	<a class="linkVoltar" href="EspecialidadeClinica.php">Voltar</a>
    	<input class="Envia" type="submit" name="submit" value="Alterar">
    </form>
    <br>
    <?php 
    //print_r($_REQUEST); //debug var recebidas
    Mysql_free_result($ObjEspecialidade_Clinica->Regs);

    if(empty($_POST['submit']))
        //Primeira apresentacao da tela
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder alteração
    //echo ('Alterando');
    
    $ObjEspecialidade_Clinica->SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
    $ObjEspecialidade_Clinica->NM_Especialidade_Clinica = $_REQUEST[NM_Especialidade_Clinica];
    $ObjEspecialidade_Clinica->Tempo_Atendimento        = $_REQUEST[Tempo_Atendimento];
    if (!$ObjEspecialidade_Clinica->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração : ' . $ObjEspecialidade_Clinica->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração com sucesso!</a>';
    }
    //header("Location: Especialidade_Clinica.php
    
    mysql_close($con);
    //echo 'SQ_Especialidade_Clinica = ' . mysql_result($ObjEspecialidade_Clinica->Regs,0,SQ_Especialidade_Clinica);
    ?>
  </BODY>
</HTML>