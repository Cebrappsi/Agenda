
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
    <form method="post" action="ConvenioInsert.php">
    	<fieldset>
    		<legend>Inserindo Convenio</legend>
    		<label class="labelNormal">Nome: </label>
    		<input class="Entrada" type="text" name="NM_Convenio" size="30" value= 
    		       <?php echo '"' . $_REQUEST[NM_Convenio] . '"'?>  ><br><br>
    		<label class="labelNormal">Data Ativação:</label>
    		<input class="Entrada" type="date" name="DT_Ativacao" size="10" value=
    		       <?php echo $_REQUEST[DT_Ativacao] ?> ><br><br>
    		<label class="labelNormal">Data Desativação:</label>
    		<input class="Entrada" type="date" name="DT_Desativacao" size="10" value=
    		       <?php echo $_REQUEST[DT_Desativacao] ?> ><br><br>
    	</fieldset>
    
    	<a class="linkVoltar" href="Convenio.php">Voltar</a>
    	<input class="Envia" type="submit" value="Inserir">
    </form>
    
    <?php	
    if (!isset($_REQUEST[NM_Convenio]) && !isset($_REQUEST[DT_Ativacao]) && !isset($_REQUEST[DT_Desativacao]))
    	//Tela sendo apresentada pela primeira vez
        die();
    
    require "comum.php";
    require "ConvenioClasse.php";
    
    $con = conecta_BD($MsgErro);
    if (!$con){
       echo '<a class="MsgErro">Erro: ' . $ObjConvenio->MsgErro .'<br></a>';
	   die();
	}
    //ok - vamos incluir	
    $ObjConvenio = new Convenio();
    $ObjConvenio->NM_Convenio = $_REQUEST[NM_Convenio];
    $ObjConvenio->DT_Ativacao = $_REQUEST[DT_Ativacao];
    $ObjConvenio->DT_Desativacao = $_REQUEST[DT_Desativacao];
    if (!$ObjConvenio->insert($Con,$MsgErro))
        echo '<a class="MsgErro">Erro na inserção: ' . $ObjConvenio->MsgErro .'<br></a>';
    else 
       echo '<a class="MsgSucesso">Registro Incluido com sucesso!</a>';
    
    mysql_close($con);
    ?>
  </BODY>
</HTML>