<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: indexint.inc.php,v 1.17 2017-04-04 12:42:07 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

if(!isset($id_pclass)) $id_pclass = '';

// on a besoin des templates indexation interne
include($include_path.'/templates/indexint.tpl.php');

// la classe de gestion des indexation interne
require_once($class_path.'/indexint.class.php');

print '<h1>'.$msg[140].'&nbsp;: '.$msg['indexint_menu_title'].'</h1>';

switch($sub) {
	case 'reach':
		include('./autorites/indexint/indexint_list.inc.php');
		break;
	case 'delete':
		$indexint = new indexint($id, $id_pclass);
		$sup_result = $indexint->delete();
		if(!$sup_result) {
			include('./autorites/indexint/indexint_list.inc.php');
		}else {
			error_message($msg[132], $sup_result, 1, './autorites.php?categ=indexint&sub=indexint_form&id='.$id);
		}
		break;
	case 'replace':
		$indexint = new indexint($id, $id_pclass);
		if(!$n_indexint_id) {
			$indexint->replace_form();
		} else {
			// routine de remplacement
			$rep_result = $indexint->replace($n_indexint_id, $aut_link_save);
			if(!$rep_result) {
				include('./autorites/indexint/indexint_list.inc.php');
			}else {
				error_message($msg[132], $rep_result, 1, './autorites.php?categ=indexint&sub=indexint_form&id='.$id);
			}
		} 
		break;
	case 'duplicate':
		$indexint = new indexint($id);
		$id = 0;
		$indexint->show_form(true);
		break;
	case 'update':
		// mettre � jour 
		$indexint = new indexint($id, $id_pclass);
		$indexint->update($indexint_nom, $indexint_comment, $id_pclass, $authority_statut, $authority_thumbnail_url);
		if($indexint->get_cp_error_message()) {
			require_once($include_path.'/user_error.inc.php');
			error_message($msg['indexint_create'], $indexint->get_cp_error_message(), 1, './autorites.php?categ=indexint&sub=indexint_form&id='.$indexint->indexint_id);
		}else {
			$id = $indexint->indexint_id;
			$sub = 'indexint';
			include('./autorites/see/main.inc.php');
		}
		break;
	case 'indexint_form':
		// affichage du form pour cr�ation modification
		$indexint = new indexint($id,$id_pclass);
		$indexint->show_form();	
		break;
	case 'indexint_last':
		$last_param = 1;
		$tri_param =  'order by indexint_id desc ';
		$limit_param = 'limit 0, '.$pmb_nb_lastautorities;
		$clef = '';
		$nbr_lignes = 0 ;
		include('./autorites/indexint/indexint_list.inc.php');
		break;
	case 'pclass':
		include('./autorites/indexint/pclass.inc.php');
	break;		
	case 'pclass_form':
		include('./autorites/indexint/pclass_form.inc.php');
	break;		
	case 'pclass_update' :
		include('./autorites/indexint/pclass_update.inc.php');
		break; 
	case 'pclass_delete' :
		include('./autorites/indexint/pclass_delete.inc.php');
		break; 
	default:
		if(!$pmb_allow_authorities_first_page && $user_input == ''){
			indexint::search_form($id_pclass);
		}else {
			// affichage du d�but de la liste (par d�faut)
			include('./autorites/indexint/indexint_list.inc.php');
		}
		break;
}
