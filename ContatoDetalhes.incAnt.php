<?php 
 	
    // Chegar Aqui com a lista $listaContatos carregada com os contatos a serem apresentados
    //echo mysql_num_rows($ListaContatos);	
    //echo 'dentr0';
 	echo '<table class="CabecalhoTabela" border="1">';
    
    while ($dados = mysql_fetch_array($ListaContatos))
    {
    	//pegando relações com a Clinica
    	if (!$SetRelacoes = mysql_query('SELECT Relacionamento.*, Tipo_Relacionamento.NM_Tipo_Relacao ' .
    			' from Relacionamento ' .
    			' inner join Tipo_Relacionamento on Relacionamento.TP_Relacao = Tipo_Relacionamento.TP_Relacao ' .
    			' where SQ_Contato = ' . $dados[SQ_Contato] .
    			' order by Tipo_Relacionamento.NM_Tipo_Relacao')){
    		echo '<a class="MsgErro">Não foi possível efetuar consulta Relacionamento: ' .
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
    		echo '<td size="30">' . $dados[NM_Contato] . '</td>';
    		//echo '<td size="50"><a href=ContatoDetalhesForm.php?SQ_Contato=' . $dados[SQ_Contato] . '>' . urlencode($dados[NM_Contato]) . '</a></td>';
    		echo '<td align="center">'; 
    		while ($RegRelacoes = mysql_fetch_array($SetRelacoes))
	    	      echo  $RegRelacoes[NM_Tipo_Relacao] . '<br>'; 
    		echo  '</td>';
    		echo '<td>' . implode('/',array_reverse(explode('-',$dados[DT_Nascimento]))) . '</td>';
    		echo '<td size="14">' . $dados[Identificacao] . '</td>';
    		echo '<td>' . $dados[Observacoes] . '</td>';
    		echo '<td><a href=ContatoForm.php?SQ_Contato=' . $dados[SQ_Contato] . 
    										 '&Operacao=' . urlencode("Mostrar Contato") .
    										 '>Alterar</a></td>';
    		echo '<td><a href=ContatoDelete.php?SQ_Contato=' . $dados[SQ_Contato] . '&NM_Contato=' . urlencode($dados[NM_Contato]) . '>Excluir</a></td>';
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
        	         ' - UF: ' . $RegEndereco[CD_UF] . 
        		     ' - CEP: ' .  $RegEndereco[CEP] . '</td>';
        		echo '<td><a href=EnderecoForm.php?SQ_Contato=' . $RegEndereco[SQ_Contato] . 
        										'&NM_Contato=' . urlencode($dados[NM_Contato]) .
												'&TP_Endereco=' . $RegEndereco[TP_Endereco] .
												'&NM_Tipo_Endereco=' . urlencode($RegEndereco[NM_Tipo_Endereco]) .
        										'&Operacao=' . urlencode("Mostrar Endereco") .
        										'>Alterar</a></td>';
        		echo '<td><a href=EnderecoDelete.php?SQ_Contato=' . $RegEndereco[SQ_Contato] .
												   '&NM_Contato=' . urlencode($dados[NM_Contato]) .
        									       '&TP_Endereco=' . $RegEndereco[TP_Endereco] . '&NM_Tipo_Endereco=' . 
        		                                           urlencode($RegEndereco[NM_Tipo_Endereco]) . '>Excluir</a></td>';
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
    		echo '<td><a href=TelefoneForm.php?SQ_Contato=' . $RegTelefone[SQ_Contato] .
    										  '&NM_Contato=' . urlencode($dados[NM_Contato]) .
											  '&NR_Telefone=' . $RegTelefone[NR_Telefone] . '>Alterar</a></td>';
    		echo '<td><a href=TelefoneDelete.php?SQ_Contato=' . $RegTelefone[SQ_Contato] .
    										  '&NM_Contato=' . urlencode($dados[NM_Contato]) .
											  '&NR_Telefone=' . $RegTelefone[NR_Telefone] .'&NM_Tipo_Telefone=' . 
    		                                   urlencode($dados[NM_Tipo_Telefone]) . '>Excluir</a></td>';    		echo '</tr>';
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
    		echo '<td align="left" colspan="5">Email ' . $RegEmail[NM_Tipo_Email] . ' - Email: ' . $RegEmail[Email] . '</td>';
    		echo '<td><a href=EmailForm.php?SQ_Contato=' . $RegEmail[SQ_Contato] . 
										  '&NM_Contato=' . urlencode($dados[NM_Contato]) .
										  '&TP_Email=' . $RegEmail[TP_Email] . '>Alterar</a></td>';
    		echo '<td><a href=EmailDelete.php?SQ_Contato=' . $RegEmail[SQ_Contato] . 
											'&NM_Contato=' . urlencode($dados[NM_Contato]) .
											'&TP_Email=' . $RegEmail[TP_Email] . '&NM_Tipo_Email=' . 
    										  urlencode($dados[NM_Tipo_Email]) . '>Excluir</a></td>';
    		echo '</tr>';
    	}
    	 
    }
    echo '</table>';
  ?>