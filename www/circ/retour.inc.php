<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: retour.inc.php,v 1.35 2017-07-07 09:56:53 ngantier Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

require_once("$class_path/emprunteur.class.php");
require_once("$class_path/serial_display.class.php");
require_once("$class_path/comptes.class.php");
require_once("$class_path/amende.class.php");
require_once("$include_path/resa.inc.php");
require_once("$class_path/expl_to_do.class.php");

if (!isset($action_piege)) $action_piege = '';
if (!isset($piege_resa)) $piege_resa = '';


// gestion des retours
if (isset($_GET['cb_expl'])) {
	$form_cb_expl=$_GET['cb_expl'];
	$_GET['cb_expl']='';
	$confirmed=1;
} else {
	if ($pmb_confirm_retour) $confirmed=0;
	else $confirmed=1;
}	
if(!isset($form_cb_expl)) $form_cb_expl = '';
$expl=new expl_to_do($form_cb_expl);

if($form_cb_expl) {
	$expl->do_form_retour($action_piege,$piege_resa);
}
print $expl->cb_tmpl;
if(isset($expl->expl_form)) {
	print $expl->expl_form;
}
