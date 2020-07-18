<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: explnum_doc.php,v 1.7 2016-09-19 12:24:53 mbertin Exp $

$base_path=".";
require_once($base_path."/includes/init.inc.php");

require_once($base_path."/includes/error_report.inc.php") ;

require_once($base_path."/includes/global_vars.inc.php");
require_once('./includes/opac_config.inc.php');


if ($css=="") $css=1;
	
// r�cup�ration param�tres MySQL et connection � la base
require_once('./includes/opac_db_param.inc.php');
require_once('./includes/opac_mysql_connect.inc.php');
$dbh = connection_mysql();

//Sessions !! Attention, ce doit �tre imp�rativement le premer include (� cause des cookies)
require_once($base_path."/includes/session.inc.php");

require_once('./includes/start.inc.php');

require_once("./includes/check_session_time.inc.php");

// r�cup�ration localisation
require_once('./includes/localisation.inc.php');

// version actuelle de l'opac
require_once('./includes/opac_version.inc.php');

require_once ("./includes/explnum.inc.php");  

// si param�trage authentification particuli�re et pour la re-authentification ntlm
if (file_exists($base_path.'/includes/ext_auth.inc.php')) require_once($base_path.'/includes/ext_auth.inc.php');
$explnumdoc_id=$explnumdoc_id+0;
$resultat = pmb_mysql_query("SELECT * FROM explnum_doc WHERE id_explnum_doc = '$explnumdoc_id' ", $dbh);
$nb_res = pmb_mysql_num_rows($resultat) ;

if (!$nb_res) {
	header("Location: images/mimetype/unknown.gif");
	exit ;
	} 
	
$ligne = pmb_mysql_fetch_object($resultat);
if ($ligne->explnum_doc_data) {
	create_tableau_mimetype() ;
	$name=$_mimetypes_bymimetype_[$ligne->explnum_mimetype]["plugin"] ;
	if ($name) {
		$type = "" ;
		// width='700' height='525' 
		$name = " name='$name' ";
	} else $type="type='$ligne->explnum_mimetype'" ;
	if ($_mimetypes_bymimetype_[$ligne->explnum_mimetype]["embeded"]=="yes") {
		print "<html><body><EMBED src=\"./explnum_doc_data.php?explnumdoc_id=$explnumdoc_id\" $type $name controls='console' ></EMBED></body></html>" ;
		exit ;
	}
	
	$nomfichier="";
	if ($ligne->explnum_doc_nomfichier) {
		$nomfichier=$ligne->explnum_doc_nomfichier;
	}
	elseif ($ligne->explnum_doc_extfichier)
		$nomfichier="pmb".$ligne->explnum_id.".".$ligne->explnum_doc_extfichier;
	if ($nomfichier) header("Content-Disposition: inline; filename=".$nomfichier);
	
	header("Content-Type: ".$ligne->explnum_doc_mimetype);
	print $ligne->explnum_doc_data;
	exit ;
}
if ($ligne->explnum_doc_mimetype=="URL") {
	if($ligne->explnum_doc_url){
		header("Location: $ligne->explnum_doc_url");
	}
	exit ;
}
	
?>