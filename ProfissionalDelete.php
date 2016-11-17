 <?php
  if ($_REQUEST[Operacao] == "Excluir"){
    require "comum.php";
 	require "ProfissionalClasse.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }
   
	$ObjProfissional = new Profissional();
    $ObjProfissional->SQ_Profissional = $_REQUEST[SQ_Profissional];
	$ObjProfissional->SQ_Especialidade_Clinica = $_REQUEST[SQ_Especialidade_Clinica];
    if (!$ObjProfissional->Delete($MsgErro))
       //MsgPopup('Erro na Exclus?o do Registro : ' . $MsgErro);
        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
    else 
      // MsgPopup( $ObjProfissional->MsgErro);
       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
      //header("Location: Profissional.php?");
    mysql_close($con);
  }
?>
<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8;font-family:Verdana; font-size:10pt;
        }
		label.labelConfirma{
			float:left;
			width:30%;
			margin-right:0.5em;
			padding-top:0.2em;
			text-align:right;
		}
        </style>
  </HEAD>
  <BODY>
 
    <form method="post" action="ProfissionalDelete.php">
    	<fieldset>
    		<legend>Excluindo Profissional</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Profissional - <?php echo $_REQUEST[NM_Profissional] . 
												' - ' . $_REQUEST[NM_Especialidade_Clinica]?> ? </label><br><br>
   			<input type="hidden" name="SQ_Profissional" size="10" value="<?php echo $_REQUEST[SQ_Profissional] ?> ">
    		<input type="hidden" name="SQ_Especialidade_Clinica" size="10" value="<?php echo $_REQUEST[SQ_Especialidade_Clinica] ?>">
    	</fieldset>
      	<a class="linkVoltar" href="ProfissionalLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  </BODY>
</HTML>
