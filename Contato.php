<!DOCTYPE html>
<HTML>
  <HEAD>
	<TITLE> Frame 3 </TITLE>
    <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
    <style>body {
        background-color:#D8D8D8; font-family:Verdana; font-size:10pt;
        }
        </style>
  </HEAD>
  <BODY>
    <table class="CabecalhoTabela" border="1">
    
    <?php
    require "comum.php";
    
    if (!conecta_BD($con,$MsgErro)){
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
    		 $Query = $Query . 'Where Relacionamento.TP_Relacao = "P"';
    		break;
    	case 'Profissionais':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "R"';
    		break;
    	case 'Convenios':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "C"';
    		break;
    	case 'Serviços':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "S"';
    		break;
    	case 'Outros':
    		$Query = $Query . 'Where Relacionamento.TP_Relacao = "O"';
    		break;
    	case 'PesquisaContatos':
    		echo "Nao implementado";
   			break;
    }
    //echo $_REQUEST[Tipo] .  	$Query;
    if (!$consulta = mysql_query($Query)){
	    echo '<a class="MsgErro">Não foi possível efetuar consulta Contato: ' . mysql_error() .'<br></a>';
		die();
    }

    //echo mysql_num_rows($consulta);	
    echo '<a class="linkInserirNovo" href="ContatoInsert.php">Inserir Novo Contato</a>';
    echo('<br><br>');
    while ($dados = mysql_fetch_array($consulta))
    {
    	//pegando relações com a Clinica
    	if (!$SetPapel = mysql_query('SELECT Relacionamento.*, Tipo_Relacionamento.NM_Tipo_Relacao ' .
    			' from Relacionamento ' .
    			' inner join Tipo_Relacionamento on Relacionamento.TP_Relacao = Tipo_Relacionamento.TP_Relacao ' .
    			' where SQ_Contato = ' . $dados[SQ_Contato] .
    			' order by Tipo_Relacionamento.NM_Tipo_Relacao')){
    		echo '<a class="MsgErro">Não foi possível efetuar consulta Tipo Contato: ' .
    					mysql_error() .'<br></a>';
    		die();
    	}
    	echo '<tr>';
	    	echo '<th width ="20%">Nome</th>';
	    	echo '<th>Relação</th>';
	    	echo '<th>Nascimento</th>';
	    	echo '<th>Identificacao</th>';
	    	echo '<th>Observações</th>';
	    	echo '<th>Alterar?</th>';
	    	echo '<th>Excluir?</th>';
    	echo '</tr>';
    	echo "<tr>";
    		//echo '<td size="30">' . $dados[NM_Contato] . '</td>';
    		echo '<td size="50"><a href=ContatoDetalhesEdit.php?SQ_Contato=' . $dados[SQ_Contato] . '>' . $dados[NM_Contato] . '</a></td>';
    		echo '<td align="center">'; 
    		while ($RegPapel = mysql_fetch_array($SetPapel))
	    	      echo  $RegPapel[NM_Tipo_Relacao] . '<br>'; 
    		echo  '</td>';
    		echo '<td>' . $dados[DT_Nascimento] . '</td>';
    		echo '<td size="14">' . $dados[Identificacao] . '</td>';
    		echo '<td>' . $dados[Observacoes] . '</td>';
    		echo '<td><a href=ContatoEdit.php?SQ_Contato=' . $dados[SQ_Contato] . '>Alterar</a></td>';
    		echo '<td><a href=ContatoDelete.php?SQ_Contato=' . $dados[SQ_Contato] .
    		                                     '&Confirma=' . '>Excluir</a></td>';
        echo '</tr>';
        
        //Endereço
        if (!$SetEndereco = mysql_query('SELECT endereco.* , tipo_Endereco.NM_Tipo_Endereco ' .
        								' from Endereco ' . 
        							    ' inner join Tipo_Endereco on Endereco.Tp_Endereco = Tipo_Endereco.Tp_Endereco ' .
        								' where SQ_Contato = ' . $dados[SQ_Contato] .
        								' order by TP_Endereco')){
        	echo '<a class="MsgErro">Não foi possível efetuar consulta Endereço: ' . 
        								mysql_error() .'<br></a>';
        	die();
        }
        while ($RegEndereco = mysql_fetch_array($SetEndereco))
        	{
        		echo "<tr>";
        		echo '<td align="left" colspan="5">Endereço ' . $RegEndereco[NM_Tipo_Endereco] . 
        			 ' - Rua: ' . $RegEndereco[Rua] . 
        			 ' - Nro: ' . $RegEndereco[Numero] . 
        			 ' - Complemento: ' . $RegEndereco[Complemento] . 
        		     ' - Bairro: ' . $RegEndereco[Bairro] . 
        		     ' - Cidade: ' . $RegEndereco[Cidade] . 
        	         ' - UF: ' . $RegEndereco[UF] . 
        		     ' - CEP: ' .  $RegEndereco[CEP] . '</td>';
        		echo '<td><a href=EnderecoEdit.php?SQ_Contato=' . $RegEndereco[SQ_Contato] . 
        										'&TP_Endereco=' . $RegEndereco[TP_Endereco] . '>Alterar</a></td>';
        		echo '<td><a href=EnderecoDelete.php?SQ_Contato=' . $RegEndereco[SQ_Contato] .
        										'&TP_Endereco=' . $RegEndereco[TP_Endereco] . '&Confirma=' . '>Excluir</a></td>';
        		echo '</tr>';
    	}
    	
    	//Telefone
    	if (!$SetTelefone = mysql_query('SELECT Telefone.* , tipo_Mobilidade.NM_Tipo_Mobilidade, Tipo_uso.NM_Tipo_Uso, Operadora.* ' .
    			' from Telefone ' .
    			' inner join Tipo_Mobilidade on Telefone.Tp_Mobilidade = Tipo_Mobilidade.Tp_Mobilidade ' .
    			' inner join Tipo_Uso on Telefone.Tp_Uso = Tipo_Uso.Tp_Uso ' .
    			' inner join Operadora on Telefone.SQ_Operadora = Operadora.SQ_Operadora ' .
    			' where SQ_Contato = ' . $dados[SQ_Contato] .
    			' order by NM_Operadora')){
    			echo '<a class="MsgErro">Não foi possível efetuar consulta Telefone: ' .
    					mysql_error() .'<br></a>';
    			die();
    	}
    	while ($RegTelefone = mysql_fetch_array($SetTelefone))
    	{
    		echo "<tr>";
    		echo '<td align="left" colspan="5">Fone ' . $RegTelefone[NM_Tipo_Uso] .
    		' - Tipo Mobilidade: ' . $RegTelefone[NM_Tipo_Mobilidade] .
    		' - Operadora: ' . $RegTelefone[NM_Operadora] .
    		' - DDD: ' . $RegTelefone[CD_DDD] .
    		' - Número: ' . $RegTelefone[NR_Telefone] . '</td>';
    		echo '<td><a href=TelefoneEdit.php?SQ_Contato=' . $RegTelefone[SQ_Contato] .
    										  '&NR_Telefone=' . $RegTelefone[NR_Telefone] . '>Alterar</a></td>';
    		echo '<td><a href=TelefoneDelete.php?SQ_Contato=' . $RegTelefone[SQ_Contato] .
    										  '&NR_Telefone=' . $RegTelefone[NR_Telefone] . '&Confirma=' . '>Excluir</a></td>';
    		echo '</tr>';
    	}
        // Email
    	if (!$SetEmail = mysql_query('SELECT Email.* , tipo_Email.NM_Tipo_Email ' .
    			' from Email ' .
    			' inner join Tipo_Email on Email.Tp_Email = Tipo_Email.Tp_Email ' .
    			' where SQ_Contato = ' . $dados[SQ_Contato] .
    			' order by TP_Email')){
    			echo '<a class="MsgErro">Não foi possível efetuar consulta Email: ' .
    					mysql_error() .'<br></a>';
    			die();
    	}
    	while ($RegEmail = mysql_fetch_array($SetEmail))
    	{
    		echo "<tr>";
    		echo '<td align="left" colspan="5">Email ' . $RegEmail[NM_Tipo_Email] .
    		' - Email: ' . $RegEmail[Email] .
    		 '</td>';
    		echo '<td><a href=EmailEdit.php?SQ_Contato=' . $RegEmail[SQ_Contato] .
    		'&TP_Email=' . $RegEmail[TP_Email] . '>Alterar</a></td>';
    		echo '<td><a href=EmailDelete.php?SQ_Contato=' . $RegEmail[SQ_Contato] .
    		'&TP_Email=' . $RegEmail[TP_Email] . '&Confirma=' . '>Excluir</a></td>';
    		echo '</tr>';
    	}
    	 
    }
    echo '</table>';
    mysql_close($con);
  ?>
  </BODY>
</HTML>
