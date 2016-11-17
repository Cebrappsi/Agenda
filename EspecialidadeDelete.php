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
  
    <form method="post" action="EspecialidadeDelete.php">
    	<fieldset>
    		<legend>Excluindo Especialidade</legend><br><br>
    		<label class="labelConfirma">Confirma exclusão de Especialidade - <?php echo $_REQUEST[NM_Especialidade] ?> ? </label><br><br>
    	    <input type="hidden" name="SQ_Especialidade" size="2" value="<?php echo $_REQUEST[SQ_Especialidade] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="EspecialidadeLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  <?php 
     if ($_REQUEST[Operacao] == "Excluir"){
	    require "EspecialidadeClasse.php";
	    require "comum.php";
	    $ObjEspecialidade = new EspecialidadeClass();
	    
	    if (!$con = conecta_BD($MsgErro)){
		    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
	    }
	    
	    $ObjEspecialidade->SQ_Especialidade = $_REQUEST[SQ_Especialidade];
	    if (!$ObjEspecialidade->Delete($MsgErro))
	       //MsgPopup('Erro na Exclusão do Registro : ' . $MsgErro);
	        echo '<br><a class="MsgErro">Erro na Exclusão do Registro : ' . $MsgErro .'</a>';
	    else 
	      // MsgPopup( $ObjEspecialidade->MsgErro);
	       echo '<br><a class="MsgSucesso">Registro excluido com sucesso!</a>';
	      //header("Location: Especialidade.php?");
	    mysql_close($con);
     }
  ?>
  </BODY>
</HTML>