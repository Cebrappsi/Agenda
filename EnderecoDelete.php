  <?php
    //print_r($_REQUEST); //debug var recebidas
    if ($_REQUEST[Operacao] == "Excluir"){ 
   
	    require "comum.php";
    	require "EnderecoClasse.php";
		$ObjEndereco = new Endereco();	
    	if (!$con = conecta_BD($MsgErro)) {
	  		 echo '<a class="MsgErro">' . 'Erro: ' . $MsgErro .'</a>';
	   	die();
		}
	
		//Acesso o registro para preencher os campos
		// Preparacao para Área para Endereço
	
		$ObjEndereco->SQ_Contato = $_REQUEST[SQ_Contato];
		$ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
	
    	if (!$ObjEndereco->Delete($MsgErro))
       		//MsgPopup('Erro na Exclus�o do Registro : ' . $ObjContato->MsgErro);
        	echo '<br><a class="MsgErro">Erro na Exclusão do Endereço: ' . $MsgErro .'</a>';
    	else 
      		// MsgPopup( $ObjContato->$MsgErro);
       		echo '<br><a class="MsgSucesso">Endereco excluido com sucesso!</a>';
     
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
         label.MostraDados{
			float:left;
			width:30%;
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
    <form method="post" action="EnderecoDelete.php">
    	<fieldset>
	    	<legend>Excluindo Endereço</legend>
	    	<label class="labelConfirma">Confirma exclusão de Endereço - <?php echo $_REQUEST[NM_Contato] . 
												' - ' . $_REQUEST[NM_Tipo_Endereco]?> ? </label><br><br>
			<input type="hidden" name="SQ_Contato" size="10" value="<?php echo $_REQUEST[SQ_Contato]?>">
			<input type="hidden" name="NM_Contato" size="10" value="<?php echo $_REQUEST[NM_Contato]?>">
			<input type="hidden" name="TP_Endereco" size="10" value="<?php echo $_REQUEST[TP_Endereco]?>">
			<input type="hidden" name="NM_Tipo_Endereco" size="10" value="<?php echo $_REQUEST[NM_Tipo_Endereco]?>">
	    </fieldset>
    	<a class="linkVoltar" href="ContatoLista.php">Voltar</a>
    	<input class="Envia" type="submit" name="Operacao"  value="Excluir">
    </form>
  </BODY>
</HTML>