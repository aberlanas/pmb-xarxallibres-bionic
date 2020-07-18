<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: explnum_create.inc.php,v 1.15 2017-04-19 09:58:22 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// gestion des exemplaires num�riques

//verification des droits de modification notice
$acces_m=1;
if ($gestion_acces_active==1 && $gestion_acces_user_notice==1) {
	require_once("$class_path/acces.class.php");
	$ac= new acces();
	$dom_1= $ac->setDomain(1);
	$acces_m = $dom_1->getRights($PMBuserid,$id,8);
}

if ($acces_m==0) {

	error_message('', htmlentities($dom_1->getComment('mod_noti_error'), ENT_QUOTES, $charset), 1, '');

} else {
	if (file_exists($base_path.'/temp/explnum_doublon_'.$id)) {
		// On supprime les doublons stock�s inutilement
		unlink($base_path.'/temp/explnum_doublon_'.$id);
	}
	require_once($include_path."/templates/explnum.tpl.php");
	
	print "<h1>".$msg['explnum_ajouter_doc']."</h1>";
	
	$notice = new mono_display($id, 1, './catalog.php?categ=modif&id=!!id!!', FALSE);
	print pmb_bidi("<div class='row'><b>".$notice->header."</b><br />");
	print pmb_bidi($notice->isbd.'</div>');
	print "<div class=\"row\">";
	
	$nex = new explnum(0, $id, 0);
	$explnum_form = $nex->explnum_form('./catalog.php?categ=explnum_update&sub=create', "./catalog.php?categ=isbd&id=$id");
		
	print $explnum_form;
	print "</div>";

}
?>