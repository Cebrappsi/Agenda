<HTML>
    <HEAD>
	   <TITLE > Frame 1 </TITLE>
       <link rel="stylesheet" type="text/css" href="ClinicaStyle.css" />
       <style>body {
          background-color:#b3f97f;font-family:Verdana; font-size:10pt;
        }
        </style> 
</HEAD>
    <BODY  >
   
<?php
    if ($_REQUEST[Origem] == 'Agenda') {
        echo '<a class="Submenu" " target=dados href="AgendaAtendimento.php">Agenda Atendimento <br></a>';
        echo '<a class="Submenu" target=dados href="AgendaConsulta.php">Consulta Agenda<br></a>';
        echo '<a class="Submenu" target=dados href="AgendaDesmarca.php">Desmarca Consulta<br></a>';
        echo '<a class="Submenu" target=dados href="AgendaAbre.php">Abre Agenda</a>';
        die();
    } elseif ($_REQUEST[Origem] == 'Contatos') {
    	echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Todos">Todos<br></a>';
        echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Pacientes">Pacientes<br></a>';
        echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Profissionais">Profissionais<br></a>';
        echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Convenios">Convênios<br></a>';
        echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Serviços">Serviços<br></a>';
        echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Outros">Outros<br></a>';
        echo '<a class="Submenu" target=dados href="Contato.php?Tipo=Pesquisa">PesquisaContatos<br></a>';
        die();
    } elseif ($_REQUEST[Origem] == 'Tabelas') {
        echo '<a class="Submenu" target=dados href="UF.php">Unidades da Federacão<br></a>';
        echo '<a class="Submenu" target=dados href="Operadora.php">Operadoras de Telefonia<br></a>';
        echo '<br>';
        echo '<a class="Submenu" target=dados href="TipoContato.php">Tipo de Contato<br></a>';
        echo '<a class="Submenu" target=dados href="TipoEmail.php">Tipo de Email<BR></a>';
        echo '<a class="Submenu" target=dados href="TipoEndereco.php">Tipo de endereço<br></a>';
        echo '<a class="Submenu" target=dados href="TipoMobilidade.php">Tipo Mobilidade Telefone<br></a>';
        echo '<a class="Submenu" target=dados href="TipoUso.php">Tipo Uso do Telefone<br></a>';
        echo '<br>';
        echo '<a class="Submenu" target=dados href="Convenio.php">Convênios<br></a>';
        echo '<a class="Submenu" target=dados href="Plano.php">Planos<br></a>';
        echo '<a class="Submenu" target=dados href="Especialidade.php">Especialidades<br></a>';
        echo '<a class="Submenu" target=dados href="EspecialidadeClinica.php">Especialidades da Clínica<br></a>';
        echo '<a class="Submenu" target=dados href="TipoSituacaoConsulta.php">Situação da Consulta<br></a>';
        echo '<a class="Submenu" target=dados href="Valor.php">Valores<br></a>';
        echo '<br>';
        echo '<a class="Submenu" target=dados href="Sala.php">Salas de Atendimento<br></a>';
        echo '<a class="Submenu" target=dados href="HorarioTrabalho.php">Horário Trabalho Prof<BR></a>';
        die();
    } elseif ($_REQUEST[Origem] == 'Administracao') {
        echo 'Em construcao';
        die();
    }
    ?>
    </BODY>
</HTML>