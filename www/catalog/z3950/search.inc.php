<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: search.inc.php,v 1.14 2017-01-31 15:41:41 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

if(!isset($issn)) $issn = '';
if(!isset($isbn)) $isbn = '';

//-------------------- LLIUREX 22/02/2018 ------------------------------
// Chequeamos la tabla z_attr para ver si es correcta
// Si no lo es, la inyectamos nueva. Esto soluciona el problema de z3950.
check_z_attr_table();
//------------------- FIN LLIUREX 22/02/2018---------------------------


print "<h1>$msg[z3950_recherche]</h1>";

$crit1 = $_COOKIE['PMB-Z3950-criterion1'];
$crit2 = $_COOKIE['PMB-Z3950-criterion2'];
$bool1 = $_COOKIE['PMB-Z3950-boolean'];
$clause = $_COOKIE['PMB-Z3950-clause'];

/* default values */
if ($crit1 == '') $crit1 = 'isbn';
if ($bool1 == '') $bool1 = 'ET';

if($issn){
	$crit1 = 'issn';
	$isbn = $issn;
}

if ($clause != "") 
	$bibli_selectionees = explode(",",$clause);
else 
	$bibli_selectionees = array();

$select_bib="";
$requete_bib = "SELECT bib_id, bib_nom, base FROM z_bib where search_type='CATALOG' ORDER BY bib_nom, base ";
$res_bib = pmb_mysql_query($requete_bib, $dbh);

while(($liste_bib=pmb_mysql_fetch_object($res_bib))) {
	
	$pos = array_search($liste_bib->bib_id, $bibli_selectionees);

	if ($pos === false) { 
		$select_bib.= "<input type='checkbox' name='bibli[]' value='".
			$liste_bib->bib_id."' class='checkbox' />&nbsp;".
			$liste_bib->bib_nom." - ".$liste_bib->base."\n";
	} else {
		$select_bib.= "<input type='checkbox' name='bibli[]' value='".
			$liste_bib->bib_id."' checked class='checkbox' />&nbsp;".
			$liste_bib->bib_nom." - ".$liste_bib->base."\n";
	}
	
	$select_bib.="<br />";
}

$z3950_search_tpl = str_replace('!!liste_bib!!', $select_bib, $z3950_search_tpl);
$z3950_search_tpl = str_replace('!!isbn!!', $isbn, $z3950_search_tpl);
$z3950_search_tpl = str_replace('!!id_notice!!', $id_notice, $z3950_search_tpl);
$z3950_search_tpl = str_replace('!!crit1!!', z_gen_combo_box ($crit1,"crit1"), $z3950_search_tpl);
$z3950_search_tpl = str_replace('!!crit2!!', z_gen_combo_box ($crit2,"crit2"), $z3950_search_tpl);
$z3950_search_tpl = str_replace("<option value='$bool1'>", "<option value='$bool1' selected>", $z3950_search_tpl);

print $z3950_search_tpl ;
