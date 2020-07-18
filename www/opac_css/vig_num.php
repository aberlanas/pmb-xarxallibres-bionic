<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: vig_num.php,v 1.19 2016-05-18 09:17:54 jpermanne Exp $

$base_path=".";
require_once($base_path."/includes/init.inc.php");

// d�finition du minimum n�c�ssaire 
require_once($base_path."/includes/error_report.inc.php") ;

require_once($base_path."/includes/global_vars.inc.php");
require_once($base_path.'/includes/opac_config.inc.php');

// r�cup�ration param�tres MySQL et connection � la base
require_once($base_path.'/includes/opac_db_param.inc.php');
require_once($base_path.'/includes/opac_mysql_connect.inc.php');
$dbh = connection_mysql();

//Sessions !! Attention, ce doit �tre imp�rativement le premer include (� cause des cookies)
require_once($base_path."/includes/session.inc.php");

if ($css=="") $css=1;
	
require_once($base_path.'/includes/start.inc.php');

require_once($base_path."/includes/check_session_time.inc.php");

// r�cup�ration localisation
require_once($base_path.'/includes/localisation.inc.php');

// version actuelle de l'opac
require_once($base_path.'/includes/opac_version.inc.php');

require_once($include_path."/explnum.inc.php");

//gestion des droits
require_once($class_path."/acces.class.php");

require_once($class_path."/bannette.class.php");

$explnum_id = $explnum_id+0;
$resultat = pmb_mysql_query("SELECT explnum_id, explnum_notice, explnum_bulletin, explnum_mimetype, explnum_vignette,explnum_extfichier FROM explnum WHERE explnum_id = '$explnum_id' ", $dbh);
$nb_res = pmb_mysql_num_rows($resultat) ;

if (!$nb_res) {
	exit ;
} 

$ligne = pmb_mysql_fetch_object($resultat);

if($ligne->explnum_bulletin != 0){
	//si bulletin, les droits sont rattach�s � la notice du p�rio...
	$req = "select bulletin_notice from bulletins where bulletin_id =".$ligne->explnum_bulletin;
	$res = pmb_mysql_query($req,$dbh);
	if(pmb_mysql_num_rows($res)){
		$perio_id = pmb_mysql_result($res,0,0);
	}
}else $perio_id = 0;
//droits d'acces emprunteur/notice
if ($gestion_acces_active==1 && $gestion_acces_empr_notice==1) {
	$ac= new acces();
	$dom_2= $ac->setDomain(2);
	$rights= $dom_2->getRights($_SESSION['id_empr_session'],($perio_id != 0 ? $perio_id : $ligne->explnum_notice));
}

//Accessibilit� des documents num�riques aux abonn�s en opac
if ($ligne->explnum_notice) {
	$req_restriction_abo = "SELECT explnum_visible_opac, explnum_visible_opac_abon FROM notices,notice_statut WHERE notice_id='".$ligne->explnum_notice."' AND statut=id_notice_statut ";
} else {
	$req_restriction_abo = "SELECT explnum_visible_opac, explnum_visible_opac_abon FROM bulletins,notices,notice_statut WHERE bulletin_id='".$ligne->explnum_bulletin."' and bulletin_notice=notice_id AND statut=id_notice_statut ";
}
$result=pmb_mysql_query($req_restriction_abo,$dbh);
$expl_num=pmb_mysql_fetch_object($result);

//droits d'acces emprunteur/document num�rique
if ($gestion_acces_active==1 && $gestion_acces_empr_docnum==1) {
	$ac= new acces();
	$dom_3= $ac->setDomain(3);
	$docnum_rights= $dom_3->getRights($_SESSION['id_empr_session'],$explnum_id);
}

//Accessibilit� sur le document num�rique aux abonn�s en opac
$req_restriction_docnum_abo = "SELECT explnum_visible_opac, explnum_visible_opac_abon FROM explnum,explnum_statut WHERE explnum_id='".$explnum_id."' AND explnum_docnum_statut=id_explnum_statut ";

$result_docnum=pmb_mysql_query($req_restriction_docnum_abo,$dbh);
$docnum_expl_num=pmb_mysql_fetch_object($result_docnum);

$statut_not_account = false;
if ($context_dsi_id_bannette) {
	$bannette = new bannette($context_dsi_id_bannette);
	$statut_not_account = $bannette->statut_not_account;
}

if($opac_show_links_invisible_docnums || (($rights & 16 || (is_null($dom_2) && $expl_num->explnum_visible_opac && (!$expl_num->explnum_visible_opac_abon || ($expl_num->explnum_visible_opac_abon && $_SESSION["user_code"])||($expl_num->explnum_visible_opac_abon&&$statut_not_account))))
	&& ($docnum_rights & 16 || (is_null($dom_3) && $docnum_expl_num->explnum_visible_opac && (!$docnum_expl_num->explnum_visible_opac_abon || ($docnum_expl_num->explnum_visible_opac_abon && $_SESSION["user_code"])))))){
	if ($ligne->explnum_vignette) {
		print $ligne->explnum_vignette;
		exit ;
	} else {
		create_tableau_mimetype();
		$iconname=icone_mimetype ($ligne->explnum_mimetype, $ligne->explnum_extfichier);
		$fp = fopen("./images/mimetype/$iconname" , "r" ) ;
		$contenu_vignette = fread ($fp, filesize("./images/mimetype/$iconname"));
		fclose ($fp) ;
		print $contenu_vignette ;
	}
}
