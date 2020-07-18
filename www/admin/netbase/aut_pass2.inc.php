<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: aut_pass2.inc.php,v 1.16 2017-06-07 12:27:03 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// la taille d'un paquet de notices
$lot = AUTHOR_PAQUET_SIZE; // defini dans ./params.inc.php

// initialisation de la borne de d�part
if(!isset($start)) $start=0;

$v_state=urldecode($v_state);

print "<br /><br /><h2 align='center'>".htmlentities($msg["nettoyage_renvoi_auteurs"], ENT_QUOTES, $charset)."</h2>";

$query = pmb_mysql_query("update authors A1 left join authors A2 on A1.author_see=A2.author_id set A1.author_see=0 where A2.author_id is null");
$affected += pmb_mysql_affected_rows();

$v_state .= "<br /><img src=../../images/d.gif hspace=3>".htmlentities($msg["nettoyage_suppr_auteurs"], ENT_QUOTES, $charset)." : ";
$v_state .= $affected." ".htmlentities($msg["nettoyage_res_suppr_auteurs"], ENT_QUOTES, $charset);
$opt = pmb_mysql_query('OPTIMIZE TABLE authors');
// mise � jour de l'affichage de la jauge
print netbase::get_display_final_progress();

print netbase::get_process_state_form($v_state, $spec, $affected, '2');
