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
    	echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Todos">Todos<br></a>';
        echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Pacientes">Pacientes<br></a>';
        echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Profissionais">Profissionais<br></a>';
        echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Convenios">Convênios<br></a>';
        echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Serviços">Serviços<br></a>';
        echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Outros">Outros<br></a>';
        echo '<a class="Submenu" target=dados href="ContatoLista.php?Tipo=Pesquisa">PesquisaContatos<br></a>';
        die();
    } elseif ($_REQUEST[Origem] == 'Tabelas') {
        echo '<a class="Submenu" target=dados href="UFLista.php">Unidades da Federacão<br></a>';
        echo '<a class="Submenu" target=dados href="OperadoraLista.php">Operadoras de Telefonia<br></a>';
        echo '<br>';
        echo '<a class="Submenu" target=dados href="TipoRelacaoLista.php">Tipo Relação Contato-Clinica<br></a>';
        echo '<a class="Submenu" target=dados href="TipoEmailLista.php">Tipo de Email<BR></a>';
        echo '<a class="Submenu" target=dados href="TipoEnderecoLista.php">Tipo de endereço<br></a>';
        echo '<a class="Submenu" target=dados href="TipoMobilidadeLista.php">Tipo Mobilidade Telefone<br></a>';
        echo '<a class="Submenu" target=dados href="TipoUsoLista.php">Tipo Uso do Telefone<br></a>';
        echo '<br>';
        echo '<a class="Submenu" target=dados href="ConvenioLista.php">Convênios<br></a>';
        echo '<a class="Submenu" target=dados href="PlanoLista.php">Planos<br></a>';
        echo '<a class="Submenu" target=dados href="EspecialidadeLista.php">Especialidades<br></a>';
        echo '<a class="Submenu" target=dados href="EspecialidadeClinicaLista.php">Especialidades da Clínica<br></a>';
        echo '<a class="Submenu" target=dados href="TipoSituacaoConsultaLista.php">Situação da Consulta<br></a>';
        echo '<a class="Submenu" target=dados href="Valor.php">Valores<br></a>';
        echo '<br>';
        echo '<a class="Submenu" target=dados href="SalaLista.php">Salas de Atendimento<br></a>';
        echo '<a class="Submenu" target=dados href="EscalaLista.php">Escala de Trabalho<BR></a>';
        die();
    } elseif ($_REQUEST[Origem] == 'Administracao') {
        echo 'Em construcao';
        die();
    }
    ?>
    </BODY>
</HTML>