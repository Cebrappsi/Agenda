<?php
	//print_r($_REQUEST); //debug var recebidas
	if ($_REQUEST[Operacao] == "Excluir"){ 
   	    require "comum.php";
		require "TelefoneClasse.php";
    	if (!$con = conecta_BD($MsgErro)) {
	  		 echo '<a class="MsgErro">' . 'Erro: ' . $MsgErro .'</a>';
		   	die();
		}
		$ObjTelefone = new Telefone();
		$ObjTelefone->SQ_Contato = $_REQUEST[SQ_Contato];
		$ObjTelefone->NR_Telefone = $_REQUEST[NR_Telefone];
		if (!$ObjTelefone->Delete($MsgErro))
       		//MsgPopup('Erro na Exclus�o do Registro : ' . $MsgErro);
        	echo '<br><a class="MsgErro">Erro na Exclusão do Telefone : ' . $MsgErro .'</a>';
    	else 
      		// MsgPopup( $ObjContato->MsgErro);
       		echo '<br><a class="MsgSucesso">Telefone excluido com sucesso!</a>';
     
    	mysql_close($con);
	}    
?>
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
			width:40%;
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
 	<form method="post" action="TelefoneDelete.php">
    	<fieldset>
	    	<label class="labelConfirma">Confirma exclusão de Telefone - <?php echo $_REQUEST[NR_Telefone] . 
												' - ' . $_REQUEST[NM_Contato]?> ? </label><br><br>
   			<input type="hidden" name="SQ_Contato" size="10" value="<?php echo $_REQUEST[SQ_Contato] ?> ">
    		<input type="hidden" name="NR_Telefone" size="10" value="<?php echo $_REQUEST[NR_Telefone] ?>">
    	</fieldset>
    	<a class="linkVoltar" href="ContatoForm.php?SQ_Contato=<?php echo $_REQUEST[SQ_Contato]
														. '&Operacao=' . urlencode("Mostrar Contato")?>">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  </BODY>
</HTML>