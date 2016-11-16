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
    <form method="post" action="SalaInsert.php">
    	<fieldset>
    		<legend>Inserindo Sala</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Sala" size="30" autofocus value= 
    		       <?php echo '"' . $_REQUEST[NM_Sala] . '"'?>  ><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=
    		       <?php echo $_REQUEST[DT_Ativacao] ?> ><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=
    		       <?php echo $_REQUEST[DT_Desativacao] ?> ><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="Sala.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[NM_Sala]) && !isset($_REQUEST[DT_Ativacao]) && !isset($_REQUEST[DT_Desativacao]))
    	//Tela sendo apresentada pela primeira vez
        die();
    
    require "comum.php";
    require "SalaClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjSala->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjSala = new Sala();
    $ObjSala->NM_Sala = $_REQUEST[NM_Sala];
    $ObjSala->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjSala->DT_Desativacao = $_REQUEST[DT_Desativacao];
    if (!$ObjSala->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjSala->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>