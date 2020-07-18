<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: collections.inc.php,v 1.13 2017-06-07 12:27:03 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once("$class_path/collection.class.php");

// la taille d'un paquet de notices
$lot = COLLECTION_PAQUET_SIZE; // defini dans ./params.inc.php

// initialisation de la borne de d�part
if(!isset($start)) $start=0;

$v_state=urldecode($v_state);

print "<br /><br /><h2 align='center'>".htmlentities($msg["nettoyage_suppr_collections"], ENT_QUOTES, $charset)."</h2>";

$query = pmb_mysql_query("SELECT collection_id from collections left join notices on collection_id=coll_id left join sub_collections on sub_coll_parent=collection_id where coll_id is null and sub_coll_parent is null ");
$affected=0;
if($affected = pmb_mysql_num_rows($query)){
	while ($ligne = pmb_mysql_fetch_object($query)) {
		$coll = new collection($ligne->collection_id);
		$coll->delete();
	}
}

//Nettoyage des informations d'autorit�s pour les collections
collection::delete_autority_sources();

$query = pmb_mysql_query("update notices left join collections ON collection_id=coll_id SET coll_id=0, subcoll_id=0 WHERE collection_id is null");

$spec = $spec - CLEAN_COLLECTIONS;
$v_state .= "<br /><img src=../../images/d.gif hspace=3>".htmlentities($msg["nettoyage_suppr_collections"], ENT_QUOTES, $charset)." :";
$v_state .= $affected." ".htmlentities($msg["nettoyage_res_suppr_collections"], ENT_QUOTES, $charset);
$opt = pmb_mysql_query('OPTIMIZE TABLE collections');
// mise � jour de l'affichage de la jauge
print netbase::get_display_final_progress();

print netbase::get_process_state_form($v_state, $spec);
