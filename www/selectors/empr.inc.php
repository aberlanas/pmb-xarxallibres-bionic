<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: empr.inc.php,v 1.14 2017-01-06 13:52:26 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// la variable $caller, pass�e par l'URL, contient le nom du form appelant
$base_url = "./select.php?what=emprunteur&caller=$caller&param1=$param1&param2=$param2&no_display=$no_display&bt_ajouter=$bt_ajouter&auto_submit=$auto_submit&callback=$callback&infield=$infields";

// classe pour la gestion du s�lecteur
require("./selectors/classes/selector_empr.class.php");

$selector_empr = new selector_empr(stripslashes($user_input));
$selector_empr->proceed();

function show_results($user_input, $nbr_lignes=0, $page=0) {
	global $nb_per_page;
	global $base_url;
	global $caller;
 	global $charset;
 	global $empr;
 	global $callback;

	$user_input = str_replace("*", "%", $user_input) ;
	$where = "empr_nom like '$user_input%' ";

	// on r�cup�re le nombre de lignes qui vont bien
	if(!$user_input) {
		$requete = "SELECT COUNT(1) FROM empr ";
	} else {
		$requete = "SELECT COUNT(1) FROM empr WHERE $where ";
	}

	$res = pmb_mysql_query($requete);
	$nbr_lignes = @pmb_mysql_result($res, 0, 0);

	if(!$page) $page=1;
	$debut =($page-1)*$nb_per_page;

	if($nbr_lignes) {
		// on lance la vraie requ�te

		if(!$user_input) {
			$requete = "SELECT id_empr, empr_nom, empr_prenom, empr_cb, trim(concat(empr_cp,' ',empr_ville)) as lieu FROM empr ORDER BY empr_nom, empr_prenom LIMIT $debut,$nb_per_page ";
			} else {
				$requete = "SELECT id_empr, empr_nom, empr_prenom, empr_cb, trim(concat(empr_cp,' ',empr_ville)) as lieu FROM empr WHERE $where ";
				$requete .= "ORDER BY empr_nom, empr_prenom LIMIT $debut,$nb_per_page ";
				}

		$res = @pmb_mysql_query($requete);
		while(($empr=pmb_mysql_fetch_object($res))) {
            $empr_entry = $empr->empr_nom;
            if($empr->empr_prenom) $empr_entry .= ', '.$empr->empr_prenom;
            print pmb_bidi("
 			<a href='#' onclick=\"set_parent('$caller', '$empr->id_empr', '".htmlentities(addslashes($empr_entry),ENT_QUOTES, $charset)." ($empr->empr_cb)','$callback')\">
				$empr_entry</a>");
			print pmb_bidi(' <i><small>'.$empr->lieu.'</small></i> ('.$empr->empr_cb.')');
			print "<br />";
		}
		pmb_mysql_free_result($res);

		// constitution des liens

		$nbepages = ceil($nbr_lignes/$nb_per_page);
		$suivante = $page+1;
		$precedente = $page-1;

		// affichage du lien pr�c�dent si n�c�ssaire
		print '<hr /><div align=center>';
		if($precedente > 0)
		print "<a href='$base_url&page=$precedente&nbr_lignes=$nbr_lignes&user_input=$user_input'><img src='./images/left.gif' border='0' title='$msg[48]' alt='[$msg[48]]' hspace='3' align='middle' /></a>";
		for($i = 1; $i <= $nbepages; $i++) {
			if($i==$page)
				print "<b>$i/$nbepages</b>";
			}

		if($suivante<=$nbepages)
			print "<a href='$base_url&page=$suivante&nbr_lignes=$nbr_lignes&user_input=$user_input'><img src='./images/right.gif' border='0' title='$msg[49]' alt='[$msg[49]]' hspace='3' align='middle' /></a>";
		}
		print '</div>';
}
