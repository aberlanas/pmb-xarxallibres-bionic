<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: notice_authors.inc.php,v 1.8.2.1 2018-01-22 15:57:51 jpermanne Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// r�cup�ration des responsabilit�s d'une notice

require_once("$class_path/marc_table.class.php");
require_once("$class_path/author.class.php");

if (!isset($fonction_auteur)) {
	$fonction_auteur = new marc_list('function');
	$fonction_auteur = $fonction_auteur->table;
}

// get_notice_authors : retourne un tableau avec les responsabilit�s d'une notice donn�e
function get_notice_authors($notice=0) {
	global $dbh;
	
	$responsabilites = array();
	$auteurs = array();
	
	$res['responsabilites'] = array();
	$res['auteurs'] = array();
	
	$rqt = 'select id_responsability, author_id, responsability_fonction, responsability_type from responsability, authors where responsability_notice="'.$notice.'" and responsability_author=author_id order by responsability_type, responsability_ordre ' ;

	$res_sql = pmb_mysql_query($rqt, $dbh);
	while ($notice=pmb_mysql_fetch_object($res_sql)) {
		$responsabilites[] = $notice->responsability_type ;
		$auteurs[] = array( 
			'id' => $notice->author_id,
			'fonction' => $notice->responsability_fonction,
			'responsability' => $notice->responsability_type,
			'id_responsability' => $notice->id_responsability
			) ;
		}
	$res['responsabilites'] = $responsabilites;
	$res['auteurs'] = $auteurs;
	return $res;
}

// constitution du header de responsabilit�
function gen_authors_header($responsabilites) {
	global $pmb_notice_author_functions_grouping;

	$author_list = array();
	$as = array_search ("0", $responsabilites["responsabilites"]);
	if ($as!== FALSE && $as!== NULL) {
		$auteur_0 = $responsabilites["auteurs"][$as] ;
		$auteur = new auteur($auteur_0["id"]);
		if ($auteur->isbd_entry){
			$author_list[] = $auteur->isbd_entry;
		}
	}else {
		//On ne prend que le premier
		$as = array_keys ($responsabilites["responsabilites"], "1" );
		$auteur_1 = $responsabilites["auteurs"][$as[0]] ;
		$auteur = new auteur($auteur_1["id"]);
		if ($auteur->isbd_entry){
			$author_list[] = $auteur->isbd_entry;
		}
	}
	
	if($pmb_notice_author_functions_grouping) {
		$author_list = array_unique($author_list);
	} 
	return  implode ('; ', $author_list);
	
}

// constitution de la mention de responsabilit�
function gen_authors_isbd($responsabilites, $print_mode=0) {
	global $fonction_auteur, $pmb_notice_author_functions_grouping;

	$libelle_mention_resp = '';
	$mention_resp = array() ;
	$author_list_functions = array();
	$as = array_search ("0", $responsabilites["responsabilites"]);
	if ($as!== FALSE && $as!== NULL) {
		$auteur_0 = $responsabilites["auteurs"][$as];
		$auteur = new auteur($auteur_0["id"]);
		if ($print_mode) {
			$resp_lib = $auteur->isbd_entry;
		}else {
			$resp_lib = $auteur->isbd_entry_lien_gestion;
			if($auteur->author_web_link) {
				$resp_lib.= ' '.$auteur->author_web_link;
			}
		}
		if ($auteur_0["fonction"]) {
			$author_list_functions[$resp_lib][] = $fonction_auteur[$auteur_0["fonction"]];
			$mention_resp[] = $resp_lib.", ".$fonction_auteur[$auteur_0["fonction"]];
		}else {
			$author_list_functions[$resp_lib][] = '';
			$mention_resp[] = $resp_lib;
		}
	}
	$as = array_keys ($responsabilites["responsabilites"], "1");
	for ($i = 0 ; $i < count($as) ; $i++) {
		$auteur_1 = $responsabilites["auteurs"][$as[$i]];
		$auteur = new auteur($auteur_1["id"]);
		if ($print_mode) {
			$resp_lib = $auteur->isbd_entry;
		}else {
			$resp_lib = $auteur->isbd_entry_lien_gestion;
			if($auteur->author_web_link) {
				$resp_lib.= ' '.$auteur->author_web_link;
			}
		}
		if ($auteur_1["fonction"]) {
			$author_list_functions[$resp_lib][] = $fonction_auteur[$auteur_1["fonction"]];
			$mention_resp[] = $resp_lib.", ".$fonction_auteur[$auteur_1["fonction"]];
		}else {
			$author_list_functions[$resp_lib][] = '';
			$mention_resp[] = $resp_lib;
		}
	}
	$as = array_keys ($responsabilites["responsabilites"], "2");
	for ($i = 0 ; $i < count($as) ; $i++) {
		$auteur_2 = $responsabilites["auteurs"][$as[$i]];
		$auteur = new auteur($auteur_2["id"]);
		if ($print_mode) {
			$resp_lib = $auteur->isbd_entry;
		}else {
			$resp_lib = $auteur->isbd_entry_lien_gestion;
			if($auteur->author_web_link) {
				$resp_lib.= ' '.$auteur->author_web_link;
			}
		}
		if ($auteur_2["fonction"]) {
			$author_list_functions[$resp_lib][] = $fonction_auteur[$auteur_2["fonction"]];
			$mention_resp[] = $resp_lib.", ".$fonction_auteur[$auteur_2["fonction"]];
		}else {
			$author_list_functions[$resp_lib][] = '';
			$mention_resp[] = $resp_lib;
		}
	}
	
	if($pmb_notice_author_functions_grouping) {
		foreach ($author_list_functions as $isbd => $function_list) {
			if($libelle_mention_resp)$libelle_mention_resp.= '; ';
			$libelle_mention_resp.= $isbd;
			if(count($function_list)) {
				foreach ($function_list as $function) {
					if($function) {
						$libelle_mention_resp.= ', '.$function;
					}
				}
			}
		}
		return $libelle_mention_resp;
	}
    return implode ("; ",$mention_resp);
}