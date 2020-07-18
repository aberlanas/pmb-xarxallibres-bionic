<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: bannette_tpl.class.php,v 1.15.2.3 2017-10-27 15:12:27 jpermanne Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once("$include_path/templates/bannette_tpl.tpl.php");
@ini_set('zend.ze1_compatibility_mode',0);
require_once($include_path."/h2o/pmb_h2o.inc.php");

class bannette_tpl {
	
	// ---------------------------------------------------------------
	//		propri�t�s de la classe
	// ---------------------------------------------------------------	
	public $id = 0;		// MySQL id in table 'bannette_tpl'
	public $name = "";		// nom du template
	public $comment = "";	// description du template
	public $tpl = ""; 		// Template
	
	// ---------------------------------------------------------------
	//		constructeur
	// ---------------------------------------------------------------
	public function bannette_tpl($id=0) {			
		$this->id = $id+0;
		$this->getData();
	}
	
	// ---------------------------------------------------------------
	//		getData() : r�cup�ration infos 
	// ---------------------------------------------------------------
	public function getData() {
		global $dbh,$msg;
	
		if($this->id) {
			$requete = "SELECT * FROM bannette_tpl WHERE bannettetpl_id='".$this->id."' LIMIT 1 ";
			$result = @pmb_mysql_query($requete, $dbh);
			if(pmb_mysql_num_rows($result)) {
				$temp = pmb_mysql_fetch_object($result);				
				$this->name	= $temp->bannettetpl_name;
				$this->comment	= $temp->bannettetpl_comment;
 				$this->tpl = $temp->bannettetpl_tpl;
			}
		}
	}
	
	// ---------------------------------------------------------------
	//		show_list : affichage de la liste des �l�ments
	// ---------------------------------------------------------------	
	public function show_list($link="./edit.php") {	
		global $dbh, $charset,$msg;
		global $bannette_tpl_liste, $bannette_tpl_liste_ligne;
		
		$tableau = "";
		$requete = "SELECT * FROM bannette_tpl ORDER BY bannettetpl_name ";
		$result = @pmb_mysql_query($requete, $dbh);
		if(pmb_mysql_num_rows($result)) {
			$pair="odd";
			while(($temp = pmb_mysql_fetch_object($result))){	
				$id = $temp->bannettetpl_id;			
				$name = $temp->bannettetpl_name;
				$comment = $temp->bannettetpl_comment;
						
					
				if($pair=="even") $pair ="odd";	else $pair ="even";
				// contruction de la ligne
				$ligne=$bannette_tpl_liste_ligne;
				
				$ligne = str_replace("!!name!!",	htmlentities($name,ENT_QUOTES, $charset), $ligne);
				$ligne = str_replace("!!comment!!",	htmlentities($comment,ENT_QUOTES, $charset), $ligne);
				$ligne = str_replace("!!pair!!",	$pair, $ligne);					
				$ligne = str_replace("!!link_edit!!",	$link."?categ=tpl&sub=bannette&action=edit&id=$id", $ligne);	
				$ligne = str_replace("!!id!!",		$id, $ligne);	
				$tableau.=$ligne;			
			}				
		}
		$liste = str_replace("!!bannette_tpl_liste!!",$tableau, $bannette_tpl_liste);	
		$liste = str_replace("!!link_ajouter!!",	$link."?categ=tpl&sub=bannette&action=edit", $liste);	
		return $liste;
	}	
	
	// ---------------------------------------------------------------
	//		show_form : affichage du formulaire de saisie
	// ---------------------------------------------------------------
	public function show_form($link="./edit.php", $act="") {
	
		global $msg;
		global $bannette_tpl_form;
		global $charset;
		global $name, $comment;
		
		$form=$bannette_tpl_form;		
		$action = $link."?categ=tpl&sub=bannette&action=update&id=!!id!!";
		
		if($this->id) {
			$libelle = $msg["bannette_tpl_modifier"];			
			$button_delete = "<input type='button' class='bouton' value='".$msg[63]."' onClick=\"confirm_delete();\">";
			$action_delete = $link."?categ=tpl&sub=bannette&action=delete&id=!!id!!";
			$button_duplicate = "<input type='button' class='bouton' value='".$msg["edit_tpl_duplicate_button"]."' onClick=\"document.location='./edit.php?categ=tpl&sub=bannette&action=duplicate&id=".$this->id."';\" />";
		} else {			
			$libelle = $msg["bannette_tpl_ajouter"];
			$button_delete = "";
			$button_duplicate = "";
			$action_delete= "";
		}
		
		
		$fields_options="<select id='fields_options' name='fields_options'>";
		$fields_options.="<optgroup label='".$msg["bannette_tpl_insert_group_bannette"]."'>";
		
		$fields_options.="<option value='{{info.id}}'>".$msg["bannette_tpl_insert_id"]."</option>";
		$fields_options.="<option value='{{info.name}}'>".$msg["bannette_tpl_insert_name"]."</option>";
		$fields_options.="<option value='{{info.opac_name}}'>".$msg["bannette_tpl_insert_opac_name"]."</option>";
		$fields_options.="<option value='{{info.header}}'>".$msg["bannette_tpl_insert_header"]."</option>";
		$fields_options.="<option value='{{info.footer}}'>".$msg["bannette_tpl_insert_footer"]."</option>";
		$fields_options.="<option value='
		{% for sommaire in sommaires %}
			{{sommaire.level}} - {{sommaire.title}}
		{% endfor %}
				'>".$msg["bannette_tpl_insert_chapters"]."</option>";
		$fields_options.="<option value='
		{% for sommaire in sommaires %}
			{% for record in sommaire.records %}
				{{record.render}}
			{% endfor %}
		{% endfor %}
				'>".$msg["bannette_tpl_insert_records_by_chapters"]."</option>";
		$fields_options.="<option value='{{sommaires.1.title}}'>".$msg["bannette_tpl_insert_title_chapter"]."</option>";
		$fields_options.="<option value='{{sommaires.1.level}}'>".$msg["bannette_tpl_insert_level_chapter"]."</option>";
		$fields_options.="<option value='
		{% for record in records %}
			{{record.render}}
		{% endfor %}
				'>".$msg["bannette_tpl_insert_records_render"]."</option>";
		$fields_options.="<option value='{{records.length}}'>".$msg["bannette_tpl_insert_records_length"]."</option>";
		$fields_options.="<option value='{{records.length_total}}'>".$msg["bannette_tpl_insert_records_length_total"]."</option>";
		$fields_options.="<option value='{{info.date_diff}}'>".$msg["bannette_tpl_insert_date_diff"]."</option>";
		$fields_options.="<option value='{{info.equation}}'>".$msg["bannette_tpl_insert_equation"]."</option>";
		$fields_options.="</optgroup>";
		
		$fields_options.="<optgroup label='".$msg["bannette_tpl_insert_group_empr"]."'>";
		$fields_options.="<option value='{{empr.name}}'>".$msg["bannette_tpl_insert_empr_name"]."</option>";
		$fields_options.="<option value='{{empr.first_name}}'>".$msg["bannette_tpl_insert_empr_first_name"]."</option>";
		$fields_options.="<option value='{{empr.civ}}'>".$msg["bannette_tpl_insert_empr_civ"]."</option>";
		$fields_options.="<option value='{{empr.cb}}'>".$msg["bannette_tpl_insert_empr_cb"]."</option>";
		$fields_options.="<option value='{{empr.login}}'>".$msg["bannette_tpl_insert_empr_login"]."</option>";
		$fields_options.="<option value='{{empr.mail}}'>".$msg["bannette_tpl_insert_empr_mail"]."</option>";
		$fields_options.="<option value='{{empr.name_and_adress}}'>".$msg["bannette_tpl_insert_empr_name_and_adress"]."</option>";
		//$fields_options.="<option value='{{empr.statut_id}}'>".$msg["bannette_tpl_insert_empr_statut_id"]."</option>";
		$fields_options.="<option value='{{empr.statut_lib}}'>".$msg["bannette_tpl_insert_empr_statut_lib"]."</option>";
		//$fields_options.="<option value='{{empr.categ_id}}'>".$msg["bannette_tpl_insert_empr_categ_id"]."</option>";
		$fields_options.="<option value='{{empr.categ_lib}}'>".$msg["bannette_tpl_insert_empr_categ_lib"]."</option>";
		//$fields_options.="<option value='{{empr.codestat_id}}'>".$msg["bannette_tpl_insert_empr_codestat_id"]."</option>";
		$fields_options.="<option value='{{empr.codestat_lib}}'>".$msg["bannette_tpl_insert_empr_codestat_lib"]."</option>";
		//$fields_options.="<option value='{{empr.langopac_code}}'>".$msg["bannette_tpl_insert_empr_langopac_code"]."</option>";
		//$fields_options.="<option value='{{empr.langopac_lib}}'>".$msg["bannette_tpl_insert_empr_langopac_lib"]."</option>";
		$fields_options.="<option value='{{empr.all_information}}'>".$msg["bannette_tpl_insert_empr_tout"]."</option>";
		$fields_options.="<option value='".htmlentities("<a href='{{global.opac_url_base}}empr.php?code=!!code!!&emprlogin=!!login!!&date_conex=!!date_conex!!'>".$msg["bannette_tpl_insert_empr_connect"]."</a>",ENT_QUOTES,$charset)."'>".$msg["bannette_tpl_insert_empr_connect"]."</option>";
		$fields_options.="<option value='".htmlentities("<a href='{{global.opac_url_base}}empr.php?tab=dsi&lvl=bannette_gerer&code=!!code!!&emprlogin=!!login!!&date_conex=!!date_conex!!'>".$msg["bannette_tpl_gerer_vos_alertes"]."</a>",ENT_QUOTES,$charset)."'>".$msg["bannette_tpl_gerer_vos_alertes"]."</option>";
		$fields_options.="<option value='".htmlentities("<a href='{{global.opac_url_base}}empr.php?tab=dsi&lvl=bannette&id_bannette={{info.id}}&code=!!code!!&emprlogin=!!login!!&date_conex=!!date_conex!!'>{{info.name}}</a>",ENT_QUOTES,$charset)."'>".$msg["bannette_tpl_lien_vers_bannette"]."</option>";
		$fields_options.="</optgroup>";
		
		$fields_options.="<optgroup label='".htmlentities($msg["bannette_tpl_insert_group_loc"],ENT_QUOTES, $charset)."'>";
		$fields_options.="<option value='{{loc.name}}'>".$msg["bannette_tpl_insert_loc_name"]."</option>";
		$fields_options.="<option value='{{loc.adr1}}'>".$msg["bannette_tpl_insert_loc_adr1"]."</option>";
		$fields_options.="<option value='{{loc.adr2}}'>".$msg["bannette_tpl_insert_loc_adr2"]."</option>";
		$fields_options.="<option value='{{loc.cp}}'>".$msg["bannette_tpl_insert_loc_cp"]."</option>";
		$fields_options.="<option value='{{loc.town}}'>".$msg["bannette_tpl_insert_loc_town"]."</option>";
		$fields_options.="<option value='{{loc.phone}}'>".$msg["bannette_tpl_insert_loc_phone"]."</option>";
		$fields_options.="<option value='{{loc.email}}'>".$msg["bannette_tpl_insert_loc_email"]."</option>";
		$fields_options.="<option value='{{loc.website}}'>".$msg["bannette_tpl_insert_loc_website"]."</option>";
		$fields_options.="</optgroup>";
		
		$fields_options.="</select>";		
		
		$form = str_replace("!!libelle!!",	$libelle, $form);
		$form = str_replace("!!name!!",		htmlentities($this->name,ENT_QUOTES, $charset), $form);
		$form = str_replace("!!comment!!",	htmlentities($this->comment,ENT_QUOTES, $charset), $form);
		$form=str_replace('!!fields_options!!', $fields_options, $form);	
		$form=str_replace('!!bannettetpl_tpl!!', htmlentities($this->tpl,ENT_QUOTES, $charset), $form);	

		$form = str_replace("!!action!!",	$action, $form);
		$form = str_replace("!!duplicate!!", $button_duplicate, $form);		
		$form = str_replace("!!delete!!",	$button_delete,	$form);
		$form = str_replace("!!action_delete!!",$action_delete,	$form);
		$form = str_replace("!!id!!",		$this->id, $form);
		return $form;
	}
	
	// ---------------------------------------------------------------
	//		delete() : suppression 
	// ---------------------------------------------------------------
	public function delete() {
		global $dbh;
		global $msg;
		
		if(!$this->id)	return $msg[403]; 

		// effacement dans la table
		$requete = "DELETE FROM bannette_tpl WHERE bannettetpl_id='".$this->id."' ";
		pmb_mysql_query($requete, $dbh);
		
		return false;
	}
	
	
	
	// ---------------------------------------------------------------
	//		update($value) : mise � jour 
	// ---------------------------------------------------------------
	public function update($value) {
	
		global $dbh;
		global $msg;
		global $include_path;
			
		// nettoyage des cha�nes en entr�e		
		$value['name'] = addslashes(clean_string($value['name']));
		$value['comment'] = addslashes($value['comment']);
		$value['tpl'] = addslashes($value['tpl']);
		
		if(!$value['name'])	return false;
		
		$requete  = "SET  ";
		$requete .= "bannettetpl_name='".$value["name"]."', ";	
		$requete .= "bannettetpl_comment='".$value["comment"]."', ";
		$requete .= "bannettetpl_tpl='".$value["tpl"]."' ";
		
		if($this->id) {
			// update
			$requete = "UPDATE bannette_tpl $requete WHERE bannettetpl_id=".$this->id." ";
			if(!pmb_mysql_query($requete, $dbh)) {		
				require_once("$include_path/user_error.inc.php"); 
				warning($msg["bannette_tpl_modifier"], $msg["bannette_tpl_modifier_erreur"]);
				return false;
			} 
		} else {
			// creation
			$requete = "INSERT INTO bannette_tpl ".$requete;
			if(pmb_mysql_query($requete, $dbh)) {
				$this->id=pmb_mysql_insert_id();				
			} else {
				require_once("$include_path/user_error.inc.php"); 
				warning($msg["bannette_tpl_ajouter"], $msg["bannette_tpl_ajouter_erreur"]);
				return false;
			}
		}
			
		return true;
	}
		
	public function update_from_form() {
		global $name, $comment,$bannettetpl_tpl;
		
		$value['name']=stripslashes($name);
		$value['comment']=stripslashes($comment);
		$value['tpl']=stripslashes($bannettetpl_tpl);
		
		$this->update($value); 		
	}
	
	public static function gen_tpl_select($select_name="form_bannette_tpl", $selected_id=0, $onchange="", $invisible_default=0) {		
		global $msg;
		
		$requete = "SELECT bannettetpl_id, concat(bannettetpl_name,'. ',bannettetpl_comment) as nom  FROM bannette_tpl ORDER BY bannettetpl_name ";
		if($invisible_default) {
			return gen_liste ($requete, "bannettetpl_id", "nom", $select_name, $onchange, $selected_id, 0, $msg["bannette_tpl_list_default"], "","", 0) ;
		} else {
			return gen_liste ($requete, "bannettetpl_id", "nom", $select_name, $onchange, $selected_id, 0, $msg["bannette_tpl_list_default"], 0,$msg["bannette_tpl_list_default"], 0) ;
		}	
	}	
	
	public static function render($id, $data) {	
		global $dbh, $charset;
		$requete = "SELECT * FROM bannette_tpl WHERE bannettetpl_id='".$id."' LIMIT 1 ";
		$result = @pmb_mysql_query($requete, $dbh);
		if(pmb_mysql_num_rows($result)) {
			$temp = pmb_mysql_fetch_object($result);
			$data=encoding_normalize::utf8_normalize($data);
			$temp->bannettetpl_tpl=encoding_normalize::utf8_normalize($temp->bannettetpl_tpl);
			$data_to_return = H2o::parseString($temp->bannettetpl_tpl)->render($data);
			if ($charset !="utf-8") {
				$data_to_return = utf8_decode($data_to_return);
			}
			return $data_to_return;			
		}
	}

} // fin class 
