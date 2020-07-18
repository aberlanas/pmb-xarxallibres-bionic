<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: factures.inc.php,v 1.35 2017-02-02 08:37:28 jpermanne Exp $

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

// gestion des factures
require_once("$class_path/entites.class.php");
require_once("$class_path/actes.class.php");
require_once("$class_path/liens_actes.class.php");
require_once("$include_path/templates/actes.tpl.php");
require_once("$include_path/templates/factures.tpl.php");

//Affiche la liste des factures pour un etablissement
function show_list_fac($id_bibli, $id_exercice = 0) {
	
	global $msg, $charset;
	global $search_form_actes, $faclist_form,$faclist_bt_chk,$faclist_script;
	global $faclist_bt_pay;
	global $nb_per_page_acq,$nb_per_page;
	global $class_path;
	global $user_input, $statut, $page, $nbr_lignes, $tri_param, $limit_param, $last_param, $sortBy;
	global $tab_bib;
	
	//gestion du tri
	if(!isset($sortBy)){
		if(trim($_SESSION["acquisition_fac_sort"])){
			$sortBy=$_SESSION["acquisition_fac_sort"];
		}else{
			$sortBy="";
		}
	}else{
		$_SESSION["acquisition_fac_sort"]=$sortBy;
	}
	
	//Creation selecteur etablissement
	$sel_bibli ="<select class='saisie-50em' id='id_bibli' name='id_bibli' onchange=\"submit();\" >";
	foreach($tab_bib[0] as $k=>$v) {
		$sel_bibli.="<option value='".$v."' ";
		if($v==$id_bibli) $sel_bibli.="selected='selected' ";
		$sel_bibli.=">".htmlentities($tab_bib[1][$k], ENT_QUOTES, $charset)."</option>";
	}
	$sel_bibli.="</select>";
	$search_form_actes=str_replace('<!-- sel_bibli -->', $sel_bibli,$search_form_actes);
	
	//Creation selecteur statut
	$sel_statut = "<select class='saisie-25em' id='statut' name='statut' onchange=\"submit();\" >";
	$list_statut = actes::getStatelist(TYP_ACT_FAC);
	foreach($list_statut as $k=>$v){
		$sel_statut.="<option value='".$k."'>".htmlentities($v, ENT_QUOTES, $charset)."</option>";
	}
	$sel_statut.= "</select>";
	$search_form_actes=str_replace('<!-- sel_statut -->', $sel_statut ,$search_form_actes);
	
	//Creation selecteur exercice comptable
	$sel_exercice = exercices::getHtmlSelect($id_bibli, $id_exercice, true, array('id'=>'id_exercice','name'=>'id_exercice','onchange'=>'submit();'));
	$search_form_actes=str_replace('<!-- sel_exercice -->', $sel_exercice, $search_form_actes);
	$search_form_actes=str_replace('<!-- sel_exercice_label -->', htmlentities($msg['acquisition_budg_exer'], ENT_QUOTES, $charset), $search_form_actes);
	
	//Affichage form de recherche
	$titre = htmlentities($msg['recherche'].' : '.$msg['acquisition_ach_fac'], ENT_QUOTES, $charset);
	$action ="./acquisition.php?categ=ach&sub=fact&action=list&user_input=";
	$search_form_actes = str_replace('!!form_title!!', $titre, $search_form_actes);
	$search_form_actes = str_replace('!!action!!', $action, $search_form_actes);
	$search_form_actes = str_replace('!!user_input!!', $user_input, $search_form_actes);
	$search_form_actes = str_replace('!!sortBy!!', $sortBy, $search_form_actes);
	
	print $search_form_actes;
	if (!$statut) {
		$statut = getSessionFacState(); //Recuperation du statut courant
	} else {
		setSessionFacState($statut);	
	}
	print "<script type='text/javascript' >document.forms['search'].elements['statut'].value = ".$statut.";document.forms['search'].elements['user_input'].focus();
	document.forms['search'].elements['user_input'].select();</script>";
	
	//Prise en compte du formulaire de recherche
	// nombre de r�f�rences par pages
	if(!isset($nb_per_page)){
		if ($nb_per_page_acq != "") 
			$nb_per_page = $nb_per_page_acq ;
		else 
			$nb_per_page = 10;
	}
	
	
	// traitement de la saisie utilisateur

	require_once($class_path."/analyse_query.class.php");
	
	// on r�cup�re le nombre de lignes qui vont bien
	if(!$nbr_lignes) {

		if(!$user_input) {
			$nbr_lignes = entites::getNbActes($id_bibli, TYP_ACT_FAC, $statut, 0, '', $id_exercice);
		} else {
			$aq=new analyse_query(stripslashes($user_input),0,0,0,0);
			if ($aq->error) {
				error_message($msg["searcher_syntax_error"],sprintf($msg["searcher_syntax_error_desc"],$aq->current_car,$aq->input_html,$aq->error_message));
				exit;
			}
			$nbr_lignes = entites::getNbActes($id_bibli, TYP_ACT_FAC, $statut, $aq, $user_input, $id_exercice);
		}

	} else {
		$aq=new analyse_query(stripslashes($user_input),0,0,0,0);
	}

	
	if(!$page) $page=1;
	$debut =($page-1)*$nb_per_page;


	if($nbr_lignes) {
	
		$url_base = "$PHP_SELF?categ=ach&sub=fact&action=list&id_bibli=$id_bibli&id_exercice=$id_exercice&user_input=".rawurlencode(stripslashes($user_input))."&statut=$statut&sortBy=$sortBy" ;
		
		// on lance la vraie requ�te
		if(!$user_input) {
			$res = entites::listActes($id_bibli, TYP_ACT_FAC, $statut, $debut, $nb_per_page, 0, '', $sortBy, $id_exercice);
		} else {
			$res = entites::listActes($id_bibli, TYP_ACT_FAC, $statut, $debut, $nb_per_page, $aq, $user_input, $sortBy, $id_exercice);
		}
	
	
		//Affichage liste des factures
		$fac_list="";	
		$nbr = pmb_mysql_num_rows($res);
		
		$parity=1;
		for($i=0;$i<$nbr;$i++) {
			$row=pmb_mysql_fetch_object($res);
			
			$st = ( ($row->statut) & ~(STA_ACT_ARC) );
			switch ($st) {
				case STA_ACT_REC :
					$st_fac = htmlentities($msg['acquisition_fac_rec'], ENT_QUOTES, $charset);
					break;
				case STA_ACT_PAY :
					$st_fac = htmlentities($msg['acquisition_fac_pay'], ENT_QUOTES, $charset);
					break;
				default :
					$st_fac = '';
			}
			
			if( ($row->statut & STA_ACT_ARC) == STA_ACT_ARC ) $st_fac = '<s>'.$st_fac.'</s>';	
			
			if ($parity % 2) {
				$pair_impair = "even";
			} else {
				$pair_impair = "odd";
			}
			$parity += 1;
			$tr_javascript = "onmouseover=\"this.className='surbrillance'\" onmouseout=\"this.className='".$pair_impair."'\" ";
			$dn_javascript = "onmousedown=\"document.location='./acquisition.php?categ=ach&sub=fact&action=modif&id_bibli=".$id_bibli."&id_exercice=".$id_exercice."&id_fac=".$row->id_acte."' \" ";
	        $fac_list.= "<tr class='".$pair_impair."' ".$tr_javascript." style='cursor: pointer' >
						<td ".$dn_javascript." ><i>".$row->numero."</i></td>
						<td ".$dn_javascript." ><i>".$row->num_acte_parent."</i></td>
						<td ".$dn_javascript." ><i>".htmlentities($row->raison_sociale, ENT_QUOTES, $charset)."</i></td>
						<td ".$dn_javascript." ><i>".formatdate($row->date_acte)."</i></td>
						<td ".$dn_javascript." ><i>$st_fac</i></td>
						<td>
							<a href=# onclick=\"openPopUp('./pdf.php?pdfdoc=fact&id_fac=".$row->id_acte."' ,'print_PDF', 600, 500, -2, -2, 'toolbar=no, dependent=yes, resizable=yes');\" >
								<img src='./images/print.gif' border='0' align='center' alt='".htmlentities($msg['imprimer'],ENT_QUOTES, $charset)."' title='".htmlentities($msg['imprimer'],ENT_QUOTES, $charset)."' />
							</a>
						</td>";
	        if($statut==STA_ACT_REC) {
	        	$fac_list.= "<td><input type='checkbox' name='chk[]' id='chk[".$row->id_acte."]' value='".$row->id_acte."'/></td>";
	        }
			$fac_list.= "</tr>";
		}
	
		if (!$last_param) {
			$nav_bar = aff_pagination ($url_base, $nbr_lignes, $nb_per_page, $page, 10, true, true) ;
		} else {
	    	$nav_bar = "";
		}
		
		$fieldList=array("1"=>"numero","2"=>"num_acte_parent","3"=>"raison_sociale","4"=>"date_acte");
		foreach ($fieldList as $k=>$field){
			if($sortBy==$field){
				$faclist_form = str_replace('!!sortBy_'.$k.'_1!!',"-".$field,$faclist_form);
				$faclist_form = str_replace('!!sortBy_'.$k.'_2!!',"&nbsp;&#x25B4;",$faclist_form);
			}elseif($sortBy=="-".$field){
				$faclist_form = str_replace('!!sortBy_'.$k.'_1!!',$field,$faclist_form);
				$faclist_form = str_replace('!!sortBy_'.$k.'_2!!',"&nbsp;&#x25BE;",$faclist_form);
			}else{
				$faclist_form = str_replace('!!sortBy_'.$k.'_1!!',$field,$faclist_form);
				$faclist_form = str_replace('!!sortBy_'.$k.'_2!!',"",$faclist_form);
			}
		}
		$faclist_form = str_replace('<!-- fac_list -->',$fac_list,$faclist_form);
		$faclist_form = str_replace('<!-- nav_bar -->',$nav_bar,$faclist_form);
		
		$bt_list='';
		$bt_sup='';
		if($statut==STA_ACT_REC) {
			//colonne chk
			$faclist_form=str_replace("<!-- chk_th -->", "<th class='act_cell_chkbox'>&nbsp;</th>",$faclist_form);
		
			//Bouton S�lectionner
			$faclist_form=str_replace('<!-- bt_chk -->', $faclist_bt_chk,$faclist_form);

			//JavaScript
			$faclist_form=str_replace('<!-- script -->', $faclist_script,$faclist_form);

			//bouton payer
			$bt_list=$faclist_bt_pay;
		}
		
		$faclist_form = str_replace('<!-- bt_list -->',$bt_list,$faclist_form);
		$faclist_form = str_replace('<!-- bt_sup -->',$bt_sup,$faclist_form);
		print $faclist_form;	
	
	} else {
		// la requ�te n'a produit aucun r�sultat
		error_message($msg['acquisition_fac_rech'], str_replace('!!fac_cle!!', stripslashes($user_input), $msg['acquisition_fac_rech_error']), 0, './categ=ach&sub=fact&action=list&id_bibli='.$id_bibli);
	}
		
}


//Affiche le formulaire de cr�ation de facture depuis une commande
function show_from_cde($id_bibli, $id_cde) {

	global $msg;
	global $lang, $charset;
	global $fact_modif_form, $frame_show_from_cde, $form_search, $bt_enr;
	
	$form = $fact_modif_form;
	$titre = htmlentities($msg['acquisition_fac_cre'], ENT_QUOTES, $charset);

	$date_cre = formatdate(today());

	$cde = new actes($id_cde);
	$num_cde = htmlentities($cde->numero, ENT_QUOTES, $charset);
	$id_fou = $cde->num_fournisseur;
	$fou = new entites($id_fou);
	$lib_fou = htmlentities($fou->raison_sociale, ENT_QUOTES, $charset);

	$bibli = new entites($id_bibli);
	$exer = new exercices($cde->num_exercice);
					
	$numero = '';
	$comment = '';
	$ref = '';
		
	$form = str_replace('<!-- frame_show -->', $frame_show_from_cde, $form);
	
	$form = str_replace('<!-- bouton_enr -->', $bt_enr, $form);
	$form = str_replace('<!-- form_search -->', $form_search, $form);		
	$form = str_replace('!!form_title!!', $titre, $form);		
	$form = str_replace('!!id_bibli!!', $id_bibli, $form);	
	$form = str_replace('!!lib_bibli!!', htmlentities($bibli->raison_sociale, ENT_QUOTES, $charset), $form);	
	$form = str_replace('!!id_exer!!', $exer->id_exercice, $form);	
	$form = str_replace('!!lib_exer!!', htmlentities($exer->libelle, ENT_QUOTES, $charset), $form);	

	$form = str_replace('!!id_cde!!', $id_cde, $form);
	$lien_cde = "<a href=\"./acquisition.php?categ=ach&sub=cmde&action=modif&id_bibli=".$id_bibli."&id_cde=".$id_cde."\">".$num_cde."</a>"; 
	$form = str_replace('!!num_cde!!', $lien_cde, $form);
	$form = str_replace('!!date_cre!!', $date_cre, $form);
	$form = str_replace('!!id_fac!!', 0, $form);
	$form = str_replace('!!numero!!', $numero, $form);
	$form = str_replace('!!date_pay!!', '', $form);
	$form = str_replace('!!num_pay!!', '', $form);
	if($cde->date_paiement != '0000-00-00') 
		$form = str_replace('!!date_pay_cde!!', formatdate($cde->date_paiement), $form);
	else 
		$form = str_replace('!!date_pay_cde!!', '', $form);
	if (!$cde->num_paiement) 
		$form = str_replace('!!num_pay_cde!!', '', $form);
	else 
		$form = str_replace('!!num_pay_cde!!', htmlentities($cde->num_paiement,ENT_QUOTES, $charset), $form);
	$form = str_replace('!!id_fou!!', $id_fou, $form);
	$form = str_replace('!!lib_fou!!', $lib_fou, $form);
	$form = str_replace('!!comment!!', $comment, $form);
	$form = str_replace('!!ref!!', $ref, $form);
	$form = str_replace('!!devise!!', htmlentities($cde->devise, ENT_QUOTES, $charset), $form);

	print $form;

}


//Affiche le formulaire de modification de facture
function show_form_fac($id_bibli, $id_fac) {

	global $msg;
	global $lang, $charset;
	global $fact_modif_form, $frame_show, $bt_sup, $bt_enr, $bt_pay, $form_search;
	global $pmb_type_audit, $bt_audit;
	
	$form = $fact_modif_form;
	
	$titre = htmlentities($msg['acquisition_fac_mod'], ENT_QUOTES, $charset);
	
	$factu = new actes($id_fac);
	$id_fou = $factu->num_fournisseur;
	$date_cre = $factu->date_acte;
	$numero = htmlentities($factu->numero, ENT_QUOTES, $charset);
	$comment = htmlentities($factu->commentaires, ENT_QUOTES, $charset);
	$ref = htmlentities($factu->reference, ENT_QUOTES, $charset);

	$id_cde = liens_actes::getParent($id_fac);
	$cde = new actes($id_cde);
	$num_cde = htmlentities($cde->numero, ENT_QUOTES, $charset);
	
	$fou = new entites($id_fou);
	$lib_fou = htmlentities($fou->raison_sociale, ENT_QUOTES, $charset);

	$bibli = new entites($id_bibli);	
	$exer = new exercices($factu->num_exercice);

	$form = str_replace('<!-- frame_show -->', $frame_show, $form);

	if( (($factu->statut & STA_ACT_PAY) == STA_ACT_PAY) || (($factu->statut & STA_ACT_ARC) == STA_ACT_ARC) )  { 	
		//La facture est pay�e ou archiv�e, donc non modifiable

			
	} else {

		$form = str_replace('<!-- bouton_pay -->', $bt_pay, $form);
		$form = str_replace('<!-- bouton_sup -->', $bt_sup, $form);
		$form = str_replace('<!-- bouton_enr -->', $bt_enr, $form);
		$form = str_replace('<!-- form_search -->', $form_search, $form);

	}

	$form = str_replace('!!form_title!!', $titre, $form);		
	$form = str_replace('!!id_bibli!!', $id_bibli, $form);	
	$form = str_replace('!!lib_bibli!!', htmlentities($bibli->raison_sociale, ENT_QUOTES, $charset), $form);	
	$form = str_replace('!!id_exer!!', $exer->id_exercice, $form);	
	$form = str_replace('!!lib_exer!!', htmlentities($exer->libelle, ENT_QUOTES, $charset), $form);	

	$form = str_replace('!!id_cde!!', $id_cde, $form);
	$lien_cde = "<a href=\"./acquisition.php?categ=ach&sub=cmde&action=modif&id_bibli=".$id_bibli."&id_cde=".$id_cde."\">".$num_cde."</a>"; 
	$form = str_replace('!!num_cde!!', $lien_cde, $form);
	$form = str_replace('!!date_cre!!', formatdate($date_cre), $form);
	$form = str_replace('!!id_fac!!', $id_fac, $form);
	$form = str_replace('!!numero!!', $numero, $form);
	if($factu->date_paiement != '0000-00-00') $form = str_replace('!!date_pay!!', formatdate($factu->date_paiement), $form);
		else $form = str_replace('!!date_pay!!', '', $form);
	if (!$factu->num_paiement) $form = str_replace('!!num_pay!!', '', $form);
		else $form = str_replace('!!num_pay!!', htmlentities($factu->num_paiement,ENT_QUOTES, $charset), $form);
	if($cde->date_paiement != '0000-00-00') $form = str_replace('!!date_pay_cde!!', formatdate($cde->date_paiement), $form);
		else $form = str_replace('!!date_pay_cde!!', '', $form);
	if (!$cde->num_paiement) $form = str_replace('!!num_pay_cde!!', '', $form);
		else $form = str_replace('!!num_pay_cde!!', htmlentities($cde->num_paiement, ENT_QUOTES, $charset) , $form);
	$form = str_replace('!!id_fou!!', $id_fou, $form);
	$form = str_replace('!!lib_fou!!', $lib_fou, $form);
	$form = str_replace('!!comment!!', $comment, $form);
	$form = str_replace('!!ref!!', $ref, $form);
	$form = str_replace('!!devise!!', htmlentities($factu->devise, ENT_QUOTES, $charset), $form );

	if ($id_fac && $pmb_type_audit) {
		$form = str_replace('<!-- bouton_audit -->', $bt_audit, $form);
	}

	print $form;
}


//Supprime la facture
function sup_fac($id_fac, $id_cde) {

	$cde = new actes($id_cde);
	$cde->statut = ($cde->statut & (~STA_ACT_FAC)); //Statut commande = factur�->non factur�
	$cde->statut = ($cde->statut & (~STA_ACT_PAY)); //Statut commande = pay�->non pay�
	$cde->update_statut();

	actes::delete($id_fac);
	liens_actes::delete($id_fac);
} 


function pay_fac_list() {
	global $chk;
	
	if(is_array($chk)) {
		foreach ($chk as $id_fac) {
			$fac=new actes($id_fac);
			if($fac->type_acte==TYP_ACT_FAC && $fac->statut=STA_ACT_REC) {
				$fac->statut=STA_ACT_PAY;
				$fac->update_statut();
								
				//La commande correspondante est-elle entierement payee
				$id_cde = liens_actes::getParent($id_fac);
				$tab_pay = liens_actes::getChilds($id_cde, TYP_ACT_FAC);
				$paye= true;
				while (($row_pay = pmb_mysql_fetch_object($tab_pay))) {
					if(($row_pay->statut & STA_ACT_PAY) != STA_ACT_PAY){
						$paye = false;
						break;
					}
				}
				if ($paye) {
					$cde=new actes($id_cde);
					$cde->statut = ($cde->statut | STA_ACT_PAY);
					$cde->update_statut();
				}
			}
		}
	}
}


//Traitement des actions
print "<h1>".htmlentities($msg['acquisition_ach_ges'],ENT_QUOTES, $charset)."&nbsp;:&nbsp;".htmlentities($msg['acquisition_ach_fac'],ENT_QUOTES, $charset)."</h1>";

switch($action) {

	case 'list':
		entites::setSessionBibliId($id_bibli);
		show_list_fac($id_bibli);
		break;

	case 'from_cde' :
		show_from_cde($id_bibli, $id_cde);
		break; 
	
	case 'modif':
		show_form_fac($id_bibli, $id_fac);
		break;

	case 'delete' :
		sup_fac($id_fac, $id_cde);
		show_list_fac($id_bibli);
		break;
		
	case 'list_pay':
		pay_fac_list();
		show_list_fac($id_bibli);
		break;		
		
	default:
		print entites::show_list_biblio('show_list_fac');
		break;
}

?>

