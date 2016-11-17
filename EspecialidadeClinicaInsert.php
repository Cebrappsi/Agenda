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
    <form method="post" action="EspecialidadeClinicaInsert.php">
    	<fieldset>
    		<legend>Inserindo Especialidade Clinica</legend>
    		<label class="labelNormal">Nome Especialidade: </label>
    		<input class="Entrada" type="text" name="NM_Especialidade_Clinica" size="30" value= 
    		       <?php echo '"' . $_REQUEST[NM_Especialidade_Clinica] . '"'?>  ><br><br>
    		<label class="labelNormal">Tempo Atendimento: </label>
    		<input class="Entrada" type="text" name="Tempo_Atendimento" size="3" value= 
    		       <?php echo '"' . $_REQUEST[Tempo_Atendimento] . '"'?>  ><br><br>
    	</fieldset>
    	<a class="linkVoltar" href="EspecialidadeClinica.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[NM_Especialidade_Clinica]) && !isset($_REQUEST[DT_Ativacao]) && !isset($_REQUEST[DT_Desativacao]))
    	//Tela sendo apresentada pela primeira vez
        die();
    
    require "comum.php";
    require "EspecialidadeClinicaClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjEspecialidade_Clinica->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjEspecialidade_Clinica = new Especialidade_Clinica();
    $ObjEspecialidade_Clinica->NM_Especialidade_Clinica = $_REQUEST[NM_Especialidade_Clinica];
    $ObjEspecialidade_Clinica->Tempo_Atendimento = $_REQUEST[Tempo_Atendimento];
    if (!$ObjEspecialidade_Clinica->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjEspecialidade_Clinica->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>