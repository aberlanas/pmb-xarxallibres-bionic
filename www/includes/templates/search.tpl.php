<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: search.tpl.php,v 1.38.2.3 2017-12-07 16:36:32 vtouchard Exp $

if (stristr($_SERVER['REQUEST_URI'], ".tpl.php")) die("no access");

if(!isset($mode)) $mode = '';
if(!isset($opac_view_id)) $opac_view_id = 0;
if(!isset($id_empr)) $id_empr = 0;
if(!isset($priv_pro)) $priv_pro = '';
if(!isset($categ)) $categ = '';
if(!isset($sub)) $sub = '';
if(!isset($pmb_extended_search_auto)) $pmb_extended_search_auto = 0;

//Template du formulaire de recherches avanc�es
$search_form="
<script src=\"javascript/ajax.js\"></script>
<script>var operators_to_enable = new Array();</script>
<form class='form-$current_module' name='search_form' action='!!url!!' method='post' onsubmit=\"enable_operators();valid_form_extented_search();\" >
	<h3>
		".($mode==8?$msg["search_expl"]:(($mode==6||$categ=='consult'||$current_module=='autorites')?$msg["search_extended"]:(isset($_SESSION["ext_type"]) && $_SESSION["ext_type"]=="simple"?$msg["connecteurs_external_simple"]:($current_module=="circ"?$msg["search_emprunteur"]:$msg["connecteurs_external_multi"]))))."
		<!--!!precise_h3!!-->
	</h3>
	<div class='form-contenu'>
		<!--!!before_form!!--> 
		<div class='row'>!!limit_search!!";
if(!isset($limited_search) || !$limited_search){
	$search_form .= "
			<label class='etiquette' for='add_field'>".$msg["search_add_field"]."</label> !!field_list!! ";
	if(!$pmb_extended_search_auto){	
		$search_form .="	<input type='button' class='bouton' value='".$msg["925"]."' onClick=\"if (this.form.add_field.value!='') { this.form.action='!!url!!'; this.form.target=''; this.form.submit();} else { alert('".$msg["multi_select_champ"]."'); }\"/>";
	}
}
$search_form .=" </div>
 <br />
		<div class='row'>
			!!already_selected_fields!!
		</div>
	</div>";
if($mode==8)$search_form.="<!--!!limitation_affichage!!-->";		

if($sub=="opac_view" && $action =="add") {
	$search_form.="
	<div class='row'>
			<input type='submit' class='bouton' value='".$msg["142"]."'/>
			".(($categ=='consult') ? "" : "<input type='button' class='bouton' value='".$msg["opac_view_search_save"]."' onClick=\"this.form.launch_search.value=1; this.form.action='!!memo_url!!'; this.form.page.value=''; !!target_js!! this.form.submit()\"/>")."
	</div>";

} else if( $mode!=7 && $mode!=8 && $current_module !="circ" ) {
	$search_form.="
	<div class='row'>
			".(($current_module=='admin')&&($categ=='opac')?"":"<input type='submit' class='bouton' value='".$msg["142"]."'/>")."
			".(($categ=='consult' || $opac_view_id) ? "" : "<input type='button' class='bouton' value='".$msg["search_perso_save"]."' onClick=\"enable_operators();this.form.launch_search.value=1; this.form.action='!!memo_url!!'; this.form.page.value=''; !!target_js!! this.form.submit()\"/>")."
	</div>";
}

if($mode==7 || $mode==8 || $current_module=="circ") $search_form.=	"
	<div class='row'>
		<div class='left'>
			<input type='submit' class='bouton' value='".$msg["142"]."'/>
		</div>
	</div>";
		
$search_form.="
	<input type='hidden' name='delete_field' value=''/>
	<input type='hidden' name='launch_search' value=''/>
	<input type='hidden' name='page' value='!!page!!'/>
	<input type='hidden' name='id_equation' value='!!id_equation!!'/>
	<input type='hidden' name='id_search_persopac' value='!!id_search_persopac!!'/>
	<input type='hidden' name='opac_view_id' value='!!opac_view_id!!'/>
	<input type='hidden' name='priv_pro' value='$priv_pro'/>
	<input type='hidden' name='id_empr' value='$id_empr'/>
	<input type='hidden' name='id_connector_set' value='!!id_connector_set!!'/>
</form>
<script>ajax_parse_dom();	
	function valid_form_extented_search(){
		document.search_form.launch_search.value=1;
		document.search_form.action='!!result_url!!';
		document.search_form.page.value='';
		!!target_js!!
		active_autocomplete();
		//document.search_form.submit();
	}
</script>

";

//<input type='submit' class='bouton' value='".$msg["142"]."' onClick=\"this.form.launch_search.value=1; this.form.action='!!result_url!!'; this.form.page.value=''; !!target_js!! \"/>
?>