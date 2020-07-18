<?php

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

$base_path=".";                            
$base_auth = "ADMINISTRATION_AUTH";  
$base_title = "\$msg[7]";
$class_path= "./classes";
$include_path= "./includes";

//---------------------LLIUREX 12/02/2015 -------------------------
require_once ("$base_path/includes/init.inc.php");
//--------------------- FIN LLIUREX 12/02/2015 -------------------------
require_once("$class_path/notice.class.php");
require_once("$class_path/expl.class.php");
require_once("$class_path/indexint.class.php");
require_once("$include_path/notice_authors.inc.php");
require_once("$include_path/notice_categories.inc.php");

print "<link rel='stylesheet' href='xarxallibres.css'>";

$link2 = @mysql_connect(SQL_SERVER, USER_NAME, USER_PASS) OR die("Error MySQL");

function f_rellena_ceros($as_dato) {
	if(strlen($as_dato)>0 && strlen($as_dato)<9){
		for($i=strlen($as_dato); $i<9; $i++)
			$as_dato="0".$as_dato;}
	
	return $as_dato; 
}

print "<h1>PMB Duplicar Ejemplares - Banc de Llibres</h1>";
print "<h2> Ejemplar a duplicar :  $expl_id </h2>";
print "<h2> Numero de copias : $bllibres_num_copias </h2>";

// Creamos el enlace para volver al registro luego:
$regsql = "SELECT expl_notice FROM `exemplaires` WHERE expl_id = \"$expl_id\";";
$resultDataReg = @mysql_query($regsql, $link2);
if (@mysql_num_rows($resultDataReg) != 0) {
	while ($rowData = mysql_fetch_array($resultDataReg)) {
		$id=$rowData['expl_notice'];
		print "<h2><a href=\"./catalog.php?categ=isbd&id=$id\">Volver al registro</a></h2>";
	}
}else {
	$id="";
}

print "<div class='container'>";

$PASOS=0;
$FONDO=0;

// Creamos tantas copias como se han indicado 
for ($i = 1; $i <= $bllibres_num_copias; $i++) {
	
	if ($bllibres_num_copias < 320){
	
		$PASOS=320/$bllibres_num_copias;
	}else{
		if ($FONDO>=360){
			$FONDO=0;
		}
		$PASOS=1;

	}

	print "<div class='estilo' style='background-color:hsl(".$FONDO.",50%,50%)'> Copia num $i ";
	
	// Obtenemos primero el siguiente cb a aplicar
	$sql = 'SELECT expl_cb FROM `exemplaires` WHERE expl_cb LIKE \'0000%\' ORDER BY `expl_cb` DESC LIMIT 1 ';
	$resultData = @mysql_query($sql, $link2);
	
	if (@mysql_num_rows($resultData) != 0) {

		while ($rowData = mysql_fetch_array($resultData)) {	
			$cb=$rowData['expl_cb'];
			$newcb = f_rellena_ceros($cb+1);
			print "ID : $newcb <br>" ;
			
			$sql_duplica 	= "CREATE TEMPORARY TABLE temp_exemplaires SELECT * FROM exemplaires WHERE expl_id = \"$expl_id\";";
			$sql_update_id	= "UPDATE temp_exemplaires SET expl_id = \"\";";
			$sql_update_cb= "UPDATE temp_exemplaires SET expl_cb = \"$newcb\";";
			$sql_insert	= "INSERT INTO exemplaires SELECT * FROM temp_exemplaires;";
			$sql_drop		=" DROP TABLE temp_exemplaires;";
				
			$resultAux = @mysql_query($sql_duplica, $link2);
			$resultAux = @mysql_query($sql_update_id, $link2);
			$resultAux = @mysql_query($sql_update_cb, $link2);
			$resultAux = @mysql_query($sql_insert, $link2);
			$resultAux = @mysql_query($sql_drop, $link2);
			
			$FONDO=$FONDO+$PASOS;
			print "</div>";
		}// fin del while
	}else {
		print "No hay nada";
	} // fin del if

} // fin del for
mysql_close();		


print "</div>";


?>
