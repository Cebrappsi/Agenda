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
	
	//Acesso o registro para preencher os campos
	$ObjContato->SQ_Contato = $_REQUEST[SQ_Contato];
    if (!$ObjContato->GetReg($MsgErro)) {
       echo '<a class="MsgErro">' . 'Erro na busca do contato : ' . MsgErro .'</a>';
	   die();
	}
	//echo mysql_result($ObjContato->Regs,0,SQ_Contato);
	// Preparacao para Área para Endereço
	require "EnderecoClasse.php";
	$ObjEndereco = new Endereco();
	$ObjEndereco->SQ_Contato = $_REQUEST[SQ_Contato];
	$ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
	if (!$ObjEndereco->GetReg($MsgErro)) {
		echo '<a class="MsgErro">' . 'Erro na busca do Endereco : ' . MsgErro .'</a>';
		die();
	}
	
    if (!$SetTipoEndereco = mysql_query('SELECT * from Tipo_Endereco order by NM_Tipo_Endereco')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Endereço: ' . mysql_error() .'<br></a>';
	   	die();
	}
	if (!$SetUF = mysql_query('SELECT * from UF order by CD_UF')){
	   	echo '<a class="MsgErro">Não foi possível efetuar consulta UF: ' . mysql_error() .'<br></a>';
	   	die();
	}
	
    echo '<form method="post" action="EnderecoEdit.php">';
    	echo '<fieldset>';
    	   echo '<legend>Alteração de Endereço</legend>';
    	   echo '<input type="hidden" name="SQ_Contato" value=' . $_REQUEST[SQ_Contato] . ' size="10" >';
    	   echo '<input type="hidden" name="TP_Endereco" value=' . $_REQUEST[TP_Endereco] . ' size="1" >';
    	   echo '<p>Nome: ' . mysql_result($ObjContato->Regs,0,NM_Contato) . '<br></p>';
    	   echo '<p>Tipo Endereço: ';
    	   while ($RegTipoEndereco = mysql_fetch_array($SetTipoEndereco))
    	   	if ($_REQUEST[TP_Endereco] == $RegTipoEndereco[TP_Endereco])
    	   	    echo $RegTipoEndereco[NM_Tipo_Endereco];
    	   echo '<br></p>';
    	   echo '<label class="labelNormal">Rua: </label>';
    	   echo '<input type="text" name="Rua" size="50" autofocus value = "' . mysql_result($ObjEndereco->Regs,0,Rua) . '">&nbsp';
    	   echo '<label >Numero: </label>';
    	   echo '<input type="text" name="Numero" size="10" value ="' . mysql_result($ObjEndereco->Regs,0,Numero) . '"><br>';
    	   echo '<label class="labelNormal">Complemento: </label>';
    	   echo '<input class="Entrada" type="text" name="Complemento" size="50" value ="' . mysql_result($ObjEndereco->Regs,0,Complemento) . '"><BR>';
    	   echo '<label class="labelNormal">Bairro: </label>';
    	   echo '<input class="Entrada" name="Bairro" size="50" value ="' . mysql_result($ObjEndereco->Regs,0,Bairro) . '"><br>';
    	   echo '<label class="labelNormal">Cidade: </label>';
    	   echo '<input class="Entrada" name="Cidade" size="50" value = "' . mysql_result($ObjEndereco->Regs,0,Cidade) . '">&nbsp';
    	   echo '<label>UF: </label>';
    	   echo '<select name="CD_UF">';
    	   
    	   while ($RegUF = mysql_fetch_array($SetUF)){
    	   	 if ($RegUF[CD_UF] == mysql_result($ObjEndereco->Regs,0,CD_UF))
    	   		echo '<option selected  value="' , $RegUF[CD_UF] . '">' . $RegUF[NM_UF] . '</option>';
    	     else 
    	     	echo '<option           value="' , $RegUF[CD_UF] . '">' . $RegUF[NM_UF] . '</option>';
    	   } 
    	   echo '</select>';
    	   echo '<label>&nbspCEP: </label>';
    	   echo '<input name="CEP" size="10" pattern="\d{5}-?\d{3}" value = ' . mysql_result($ObjEndereco->Regs,0,CEP) . '><br>';
    	
    	echo '</fieldset>';
    	echo '<a class="linkVoltar" href="Contato.php">Voltar</a>';
        echo '<input class="Envia" type="submit" name="submit" value="Alterar"/>';
    echo '</form>';
    	  
    echo '<br>';
    
    if(empty($_POST['submit']))
    	die();//// Só apresenta os dados
    
    //Houve alteração - proceder altera��o
    //echo ('Alterando');
    /*
    
    */
    $ObjEndereco->SQ_Contato  = $_REQUEST[SQ_Contato];
    $ObjEndereco->TP_Endereco = $_REQUEST[TP_Endereco];
    $ObjEndereco->Rua         = $_REQUEST[Rua];
    $ObjEndereco->Numero      = $_REQUEST[Numero];
    $ObjEndereco->Complemento = $_REQUEST[Complemento];
    $ObjEndereco->Bairro      = $_REQUEST[Bairro];
    $ObjEndereco->Cidade      = $_REQUEST[Cidade];
    $ObjEndereco->CD_UF       = $_REQUEST[CD_UF];
    $ObjEndereco->CEP         = $_REQUEST[CEP];
        
    if (!$ObjEndereco->Edit($MsgErro))
        echo '<a class="MsgErro">' . 'Erro na alteração do Endereco: ' . $ObjEndereco->MsgErro .'</a>';
    else {
       //mysql_query("commit");
       echo '<a class="MsgSucesso">Alteração Endereco com sucesso!</a>';
    }
    
    //header("Location: Contato.php
    
    mysql_close($con);
    //echo 'SQ_Contato = ' . mysql_result($ObjContato->Regs,0,SQ_Contato);
    
    ?>
  </BODY>
</HTML>
