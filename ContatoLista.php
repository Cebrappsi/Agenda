<!DOCTYPE html>
<HTML>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8; font-family:Verdana; font-size:10pt;
        }
    </style>
  </HEAD>
  <BODY> 
    <?php
    require "comum.php";
    
    if (!$con = conecta_BD($MsgErro)){
	    echo '<a class="MsgErro">Erro: ' . $MsgErro .'<br></a>';
		die();
    }

   	$Query =  'Select distinct Relacionamento.SQ_Contato, Contato.* from Relacionamento ' .
    		          'inner join Contato ' . 
    		          'on Relacionamento.SQ_Contato = Contato.SQ_Contato ';
    switch ($_REQUEST[Tipo]) {
    	case 'Todos':	
    		$Query = 'Select * from Contato order by NM_Contato';
    		break;
    	case 'Pacientes':
    		 $Query = $Query . 'Where Relacionamento.TP_Relacao = "P" order by NM_Contato';
    		break;
    	case 'Profissionais':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "R" order by NM_Contato';
    		break;
    	case 'Convenios':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "C" order by NM_Contato';
    		break;
    	case 'Serviços':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "S" order by NM_Contato';
    		break;
    	case 'Outros':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "O" order by NM_Contato';
    		break;
    	case 'PesquisaContatos':
    		echo "Nao implementado";
   			break;
    }
    //echo $_REQUEST[Tipo] .  	$Query;
    if (!$ListaContatos = mysql_query($Query)){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($ListaContatos);	
    echo '<a class="linkInserirNovo" href=ContatoForm.php?Operacao=' . urlencode("Mostrar Contato") . '>Inserir Novo Contato</a>';
    echo '<br><br>';
   // Lista de Contatos Preparada
   require "ContatoDetalhes.inc.php"; 

    mysql_close($con);
  ?>
  </BODY>
</HTML>
