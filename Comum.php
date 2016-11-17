<?php
function Conecta_BD(&$MsgErro)
{
    //echo '<br/>Conectando BD';
    $Con = mysql_connect('localhost', 'root', "tav001");
    if (!$Con) {
        $MsgErro = 'Não foi possível conectar: ' . mysql_error();
        return false;
    }
    //print_r("<br/>" . $this->MsgErro);
    if (!mysql_select_db('db_clinica', $Con)) {
        $MsgErro = 'Não foi possivel abrir o banco de dados: ' . mysql_error();
        return false;
    }

    return $Con;
}
//echo '<meta http-equiv="Content-Type" content="text/html; charset="ISO-8859-1" />';
//echo '<meta http-equiv="Content-Type" content="text/html; charset="utf-8" />';

function MsgPopup(&$MsgErro)
{
    echo '<script language="Javascript">';
    echo 'alert(' . $MsgErro . ')';
    //echo '//history.back();'
    echo '</script>';
}

function isTime($time,$is24Hours=true,$seconds=false) {
	$pattern = "/^".($is24Hours ? "([1-2][0-3]|[01]?[1-9])" : "(1[0-2]|0?[1-9])").":([0-5]?[0-9])".($seconds ? ":([0-5]?[0-9])" : "")."$/";
	if (preg_match($pattern, $time)) {
		return true;
	}
	return false;
}
?>