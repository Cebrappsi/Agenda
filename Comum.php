<?php
//error_reporting(0);

function Conecta_BD(&$MsgErro)
{
	//
	// Config do BD
	//
	require "Clinica.php";
    //echo '<br/>Conectando BD';

    $Con = mysql_connect($servidor, $usuario, $senha);
    if (!$Con) {
        $MsgErro = 'Não foi possível conectar: ' . mysql_error();
        return false;
    }
    //print_r("<br/>" . $this->MsgErro);
    if (!mysql_select_db('db_clinica', $Con)) {
        $MsgErro = 'Não foi possível abrir o banco de dados: ' . mysql_error();
        return false;
    }
    mysql_query ('SET NAMES utf8');
	return $Con;
}

function MsgPopup($MsgErro)
{
    //echo '<script language="Javascript">';
    echo '<script type="text/javascript">';
    echo 'alert(' . '"teste"' . ')';
    //echo 'location.href="Convenio.php"';
   // echo '//history.back()';
    echo '</script>';
}

function isTime($time,$is24Hours=true,$seconds=false) {
	$pattern = "/^".($is24Hours ? "([1-2][0-3]|[01]?[1-9])" : "(1[0-2]|0?[1-9])").":([0-5]?[0-9])".($seconds ? ":([0-5]?[0-9])" : "")."$/";
	if (preg_match($pattern, $time)) {
		return true;
	}
	return false;
}
function diaSemana($dat){ 
	//echo gettype($dat); 
	//print_r($dat); 
	
	if (gettype($dat) == 'Integer')
	   $dat = date_create($dat);
	if (get_class($dat) == 'DateTime'){
		switch (date_format($dat,"w")) {
			case 0: return "Domingo";
			        break;
			case 1: return "Segunda";
					break;
			case 2: return "Terça";
					break;
			case 3: return "Quarta";
					break;
			case 4: return "Quinta";
					break;
			case 5: return "Sexta";
					break;
			case 6: return "Sábado";
					break;
			default: return false;
				break;
		}
	}
	else return false;
}
?>