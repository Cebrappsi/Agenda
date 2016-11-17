<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
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
    <form method="post" action="EscalaDelete.php">
    	<fieldset>
    		<legend>Excluindo Escala</legend><br>
    		<label class="labelConfirma">Confirma exclusão de Escala - <?php echo $_REQUEST[NM_Contato] . ' - ' . 
    										$_REQUEST[DT_Ini_Escala] . '- ' . $_REQUEST[Dia_Semana]?> ? </label><br><br>
    		<input type="hidden" name="SQ_Profissional" size="10" value="<?php echo $_REQUEST[SQ_Profissional] ?> ">
    		<input type="hidden" name="DT_Ini_Escala" size="10" value="<?php echo $_REQUEST[DT_Ini_Escala] ?>">
    		<input type="hidden" name="Dia_Semana" size="10" value="<?php echo $_REQUEST[Dia_Semana]?>">
    	</fieldset>
    	<a class="linkVoltar" href="EscalaLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
    
    <?php 
    if ($_REQUEST[Operacao] == "Excluir"){
	    require "EscalaClasse.php";
	    require "comum.php";
	    $ObjEscala = new Escala();
	    
	    if (!$con = conecta_BD($MsgErro)){
		    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
			die();
	    }
	    
	    $ObjEscala->SQ_Profissional = $_REQUEST[SQ_Profissional];
	    $ObjEscala->DT_Ini_Escala = $_REQUEST[DT_Ini_Escala];
	    $ObjEscala->Dia_Semana = $_REQUEST[Dia_Semana];
	    if (!$ObjEscala->Delete($MsgErro))
	       //MsgPopup('Erro na Exclusão do Registro : ' . $MsgErro);
	        echo '<br><a class="MsgErro">Erro na Exclusão da Escala : ' . $MsgErro .'</a>';
	    else 
	      // MsgPopup( $MsgErro);
	       echo '<br><a class="MsgSucesso">Escala excluida com sucesso!</a>';
	      //header("Location: Escala.php");
	    mysql_close($con);
    }
    ?>
  </BODY>
</HTML>