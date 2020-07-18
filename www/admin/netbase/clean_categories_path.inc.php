<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: clean_categories_path.inc.php,v 1.6 2017-06-07 12:27:03 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once("$class_path/thesaurus.class.php");
require_once("$class_path/noeuds.class.php");
require_once("$class_path/categories.class.php");

//function process_categ_path($id_noeud, $path='') {
//	global $dbh;
//	
//	if($path) $path.='/';
//	$path.=$id_noeud;
//	
//	$res = noeuds::listChilds($id_noeud, 0);
//	while (($row = pmb_mysql_fetch_object($res))) {
//		// la categorie a des filles qu'on va traiter
//		process_categ_path ($row->id_noeud,$path);
//	}		
//	$req="update noeuds set path='$path' where id_noeud=$id_noeud";
//	pmb_mysql_query($req,$dbh);		
//}

//function process_categ_index() {
//	global $dbh;
//			
//	$q = "select * from categories ";
//	$r = pmb_mysql_query($q, $dbh);
//	while ($obj = pmb_mysql_fetch_object($r)) {	
//		$thes = new categories($obj->num_noeud,$obj->langue);
//		$thes->update_index_path_word();		
//	}	
//}

// Pour tous les th�saurus, on parcours les childs
$list_thesaurus = thesaurus::getThesaurusList();

foreach($list_thesaurus as $id_thesaurus=>$libelle_thesaurus) {
	$thes = new thesaurus($id_thesaurus);
	$noeud_rac =  $thes->num_noeud_racine;
	$r = noeuds::listChilds($noeud_rac, 0);
	while(($row = pmb_mysql_fetch_object($r))){		
		noeuds::process_categ_path($row->id_noeud);
	}
}	
if($thesaurus_auto_postage_search){
	categories::process_categ_index();
}
$spec = $spec - CLEAN_CATEGORIES_PATH;

$v_state=urldecode($v_state);
$v_state.= "<br /><img src=../../images/d.gif hspace=3>".htmlentities($msg["clean_categories_path_end"], ENT_QUOTES, $charset).".";

print netbase::get_process_state_form($v_state, $spec);