<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: collections.tpl.php,v 1.35.2.1 2017-11-23 14:09:17 wlair Exp $

// templates pour gestion des autorit�s collections

if (stristr($_SERVER['REQUEST_URI'], ".tpl.php")) die("no access");

$selector_prop = "toolbar=no, dependent=yes, width=$selector_x_size, height=$selector_y_size, resizable=yes, scrollbars=yes";

//	----------------------------------
// $collection_form : form saisie collection

$collection_form = jscript_unload_question();
$collection_form.= $pmb_autorites_verif_js!= "" ? "<script type='text/javascript' src='$base_path/javascript/$pmb_autorites_verif_js'></script>":"";
$collection_form.= "
<script src='javascript/ajax.js'></script>
<script type='text/javascript'>
	require(['dojo/ready', 'apps/pmb/gridform/FormEdit'], function(ready, FormEdit){
	     ready(function(){
	     	new FormEdit();
	     });
	});
</script>
<script type='text/javascript'>
<!--
	function test_form(form) {
	";
	if ($pmb_autorites_verif_js != "") {
		$collection_form.= "
						if(typeof check_perso_collection_form == 'function'){
							var check = check_perso_collection_form(form);
							if (check == false) return false;
						}";
	}
$collection_form.=
		"if(form.collection_nom.value.length == 0) {
			alert(\"$msg[166]\");
			return false;
		}
		if(form.ed_id.value == 0) {
			alert(\"$msg[172]\");
			return false;
		}
		unload_off();
		return true;
	}
function confirm_delete() {
        result = confirm(\"".$msg['confirm_suppr']."\");
        if(result) {
        	unload_off();
            document.location='autorites.php?categ=collections&sub=delete&id=!!id!!&user_input=!!user_input_url!!&page=!!page!!&nbr_lignes=!!nbr_lignes!!';
		} else
            document.forms['saisie_collection'].elements['collection_nom'].focus();
    }
function check_link(id) {
	w=window.open(document.getElementById(id).value);
	w.focus();
}
-->
</script>
<script src='javascript/ajax.js'></script>
<script type='text/javascript'>
	document.title='!!document_title!!';
</script>
<form class='form-$current_module' id='saisie_collection' name='saisie_collection' method='post' action='!!action!!' onSubmit=\"return false\" enctype='multipart/form-data'>
<div class='row'>
	<div class='left'><h3>!!libelle!!</h3></div>
	<div class='right'>";

	$collection_form.='
	<!-- Selecteur de statut -->
		<label class="etiquette" for="authority_statut">'.$msg['authorities_statut_label'].'</label>
		!!auth_statut_selector!!
	';

	if(isset($pmb_form_authorities_editables)) {
		if (isset($PMBuserid) && $PMBuserid==1 && $pmb_form_authorities_editables==1){
			$collection_form.="<input type='button' class='bouton_small' value='".$msg["authorities_edit_format"]."' id=\"bt_inedit\"/>";
		}
		if ($pmb_form_authorities_editables==1) {
			$collection_form.="<input type='button' class='bouton_small' value=\"".$msg["authorities_origin_format"]."\" id=\"bt_origin_format\"/>";
		}
	}
	$collection_form .= "
	</div>
</div>
<div class='form-contenu'>
	<div class='row'>
		<a onclick='expandAll();return false;' href='#'><img border='0' id='expandall' src='./images/expand_all.gif'></a>
		<a onclick='collapseAll();return false;' href='#'><img border='0' id='collapseall' src='./images/collapse_all.gif'></a>
	</div>
	<div id='zone-container'>
		<!-- nom -->
		<div id='el0Child_0' class='row'>
			<div id='el0Child_0_a' class='colonne2' movable='yes' title=\"".htmlentities($msg[714], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='form_nom'>$msg[714]</label>
				</div>
				<div class='row'>
					<input type='text' class='saisie-30em' size='40' name='collection_nom' value=\"!!collection_nom!!\" />
				</div>
			</div>
		
			<!-- issn -->
			<div id='el0Child_0_b' class='colonne2' movable='yes' title=\"".htmlentities($msg[165], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='form_issn'>$msg[165]</label>
				</div>
				<div class='row'>
					<input type='text' class='saisie-20em' name='issn' value=\"!!issn!!\" maxlength='50' />
				</div>
			</div>
			<div class='row'></div>
		</div>
		<!-- edparent -->
		<div id='el0Child_1' class='row' movable='yes' title=\"".htmlentities($msg[164], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='form_edparent'>$msg[164]</label>
			</div>
			<div class='row'>
				<input type='text' class='saisie-50emr' id='ed_libelle' name='ed_libelle' value=\"!!ed_libelle!!\" completion=\"publishers\" autfield=\"ed_id\" autexclude=\"!!id!!\"
			    onkeypress=\"if (window.event) { e=window.event; } else e=event; if (e.keyCode==9) { openPopUp('./select.php?what=editeur&caller=saisie_collection&p1=ed_id&p2=ed_libelle&p3=dcoll_id&p4=dcoll_lib&p5=dsubcoll_id&p6=dsubcoll_lib', 'select', $selector_x_size, $selector_y_size, -2, -2, '$selector_prop'); }\" />
			
				<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=editeur&caller=saisie_collection&p1=ed_id&p2=ed_libelle&p3=dcoll_id&p4=dcoll_lib&p5=dsubcoll_id&p6=dsubcoll_lib', 'select', $selector_x_size, $selector_y_size, -2, -2, '$selector_prop')\" title='$msg[157]' value='$msg[parcourir]' />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.ed_libelle.value=''; this.form.ed_id.value='0'; \" />
				<input type='hidden' name='ed_id' id='ed_id' value='!!ed_id!!' />
				<input type='hidden' name='dcoll_id' />
				<input type='hidden' name='dcoll_lib' />
				<input type='hidden' name='dsubcoll_id' />
				<input type='hidden' name='dsubcoll_lib' />
			</div>
		</div>
		
		<!-- web -->
		<div id='el0Child_2' class='row' movable='yes' title=\"".htmlentities($msg[147], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='form_web'>$msg[147]</label>
			</div>
			<div class='row'>
				<input type='text' class='saisie-80em' name='collection_web' id='collection_web' value=\"!!collection_web!!\" maxlength='255' />
				<input class='bouton' type='button' onClick=\"check_link('collection_web')\" title='$msg[CheckLink]' value='$msg[CheckButton]' />
			</div>
		</div>
		
		<!-- Commentaire -->
		<div id='el0Child_3' class='row' movable='yes' title=\"".htmlentities($msg['collection_comment'], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='comment'>".$msg['collection_comment']."</label>
			</div>
			<div class='row'>
				<textarea class='saisie-80em' id='comment' name='comment' cols='62' rows='4' wrap='virtual'>!!comment!!</textarea>
			</div>
		</div>
			
		!!concept_form!!
		!!thumbnail_url_form!!
		!!aut_pperso!!
		<!-- aut_link -->
	</div>
</div>
<div class='row'>
	<div class='left'>
		<input type='button' class='bouton' value='$msg[76]' onClick=\"unload_off();document.location='./autorites.php?categ=collections&sub=reach&user_input=!!user_input_url!!&page=!!page!!&nbr_lignes=!!nbr_lignes!!';\" />
		<input type='button' value='$msg[77]' class='bouton' id='btsubmit' onClick=\"if (test_form(this.form)) this.form.submit();\" />
		!!remplace!!
		!!voir_notices!!
		!!audit_bt!!
		<input type='hidden' name='page' value='!!page!!' />
		<input type='hidden' name='nbr_lignes' value='!!nbr_lignes!!' />
		<input type='hidden' name='user_input' value=\"!!user_input!!\" />
	</div>
	<div class='right'>
		!!delete!!
	</div>
</div>
<div class='row'></div>
</form>
<script type='text/javascript'>
	ajax_parse_dom();
	document.forms['saisie_collection'].elements['collection_nom'].focus();
</script>
";

//	----------------------------------

// $sub_collection_form : form saisie sous collection
$sub_collection_form = jscript_unload_question();
$sub_collection_form.= $pmb_autorites_verif_js!= "" ? "<script type='text/javascript' src='$base_path/javascript/$pmb_autorites_verif_js'></script>":"";
$sub_collection_form.= "
<script src='javascript/ajax.js'></script>
<script type='text/javascript'>
	require(['dojo/ready', 'apps/pmb/gridform/FormEdit'], function(ready, FormEdit){
	     ready(function(){
	     	new FormEdit();
	     });
	});
</script>
<script type='text/javascript'>
<!--
function test_form(form) {
	";
	if ($pmb_autorites_verif_js != "") {
		$sub_collection_form.= "
			if(typeof check_perso_sub_collection_form == 'function'){
				var check = check_perso_sub_collection_form(form);
				if (check == false) return false;
			}";
	}
	$sub_collection_form.="
	if(form.collection_nom.value.length == 0) {
		alert(\"$msg[166]\");
		return false;
	}
	if(form.coll_id.value == 0) {
		alert(\"$msg[180]\");
		return false;
	}
	unload_off();
	return true;
}

function confirm_delete() {
	result = confirm(\"".$msg['confirm_suppr']."\");
    if(result) {
		unload_off();
		document.location='./autorites.php?categ=souscollections&sub=delete&id=!!id!!&user_input=!!user_input_url!!&page=!!page!!&nbr_lignes=!!nbr_lignes!!';
	} else
		document.forms['saisie_sub_collection'].elements['collection_nom'].focus();
}

function check_link(id) {
	w=window.open(document.getElementById(id).value);
	w.focus();
}
-->
</script>
<script type='text/javascript'>
	document.title='!!document_title!!';
</script>
<form class='form-$current_module' name='saisie_sub_collection' method='post' action='!!action!!' enctype='multipart/form-data'>
<div class='left'><h3>!!libelle!!</h3></div>
<div class='right'>";

$sub_collection_form.='
<!-- Selecteur de statut -->
    <label class="etiquette" for="authority_statut">'.$msg['authorities_statut_label'].'</label>
     !!auth_statut_selector!!
';

if(isset($pmb_form_authorities_editables)) {
	if (isset($PMBuserid) && $PMBuserid==1 && $pmb_form_authorities_editables==1){
		$sub_collection_form.="<input type='button' class='bouton_small' value='".$msg["authorities_edit_format"]."' id=\"bt_inedit\"/>";
	}
	if ($pmb_form_authorities_editables==1) {
		$sub_collection_form.="<input type='button' class='bouton_small' value=\"".$msg["authorities_origin_format"]."\" id=\"bt_origin_format\"/>";
	}
}
$sub_collection_form .= "</div>
<div class='form-contenu'>
	<div class='row'>
		<a onclick='expandAll();return false;' href='#'><img border='0' id='expandall' src='./images/expand_all.gif'></a>
		<a onclick='collapseAll();return false;' href='#'><img border='0' id='collapseall' src='./images/collapse_all.gif'></a>
	</div>
	<div id='zone-container'>
		<div id='el0Child_0' class='row'>
			<!-- nom -->
			<div id='el0Child_0_a' class='colonne2' movable='yes' title=\"".htmlentities($msg[67], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='form_nom'>$msg[67]</label>
				</div>
				<div class='row'>
					<input type='text' class='saisie-30em' size='40' name='collection_nom' value=\"!!collection_nom!!\" />
				</div>
			</div>
			<!-- issn -->
			<div id='el0Child_0_b' class='colonne2' movable='yes' title=\"".htmlentities($msg[165], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='form_issn'>$msg[165]</label>
				</div>
				<div class='row'>
					<input type='text' class='saisie-20em' name='issn' value=\"!!issn!!\" maxlength='50' />
				</div>
			</div>
			<div class='row'></div>
		</div>
		<div id='el0Child_1' class='row'>
			<!-- collparent -->
			<div id='el0Child_1_a' class='colonne2' movable='yes' title=\"".htmlentities($msg[179], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='form_collparent'>$msg[179]</label>
				</div>
				<div class='row'>
					<input type='text' class='saisie-30emr' size='34' name='coll_libelle' readonly value=\"!!coll_libelle!!\" />
					<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=collection&caller=saisie_sub_collection&p1=ed_id&p2=ed_libelle&p3=coll_id&p4=coll_libelle&p5=dsubcoll_id&p6=dsubcoll_lib', 'select_coll', $selector_x_size, $selector_y_size, -2, -2, '$selector_prop')\" title='$msg[157]' value='$msg[parcourir]' />
					<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.coll_libelle.value=''; this.form.ed_libelle.value=''; this.form.coll_id.value='0'; \" />
					<input type='hidden' name='coll_id' value='!!coll_id!!' />
					<input type='hidden' name='dsubcoll_id' />
					<input type='hidden' name='dsubcoll_lib' />
				</div>
	        </div>        
			<!-- colledparent -->
			<div id='el0Child_1_b' class='colonne2' movable='yes' title=\"".htmlentities($msg[164], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='form_colledparent'>$msg[164]</label>
				</div>
				<div class='row'>
					<input type='text' class='saisie-30emr' size='34' name='ed_libelle' readonly value=\"!!ed_libelle!!\" />
					<input type='hidden' name='ed_id' value='!!ed_id!!' />
				</div>
			</div>
		</div>
		<!-- web -->
		<div id='el0Child_2' class='row' movable='yes' title=\"".htmlentities($msg[147], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='form_web'>$msg[147]</label>
				</div>
			<div class='row'>
				<input type='text' class='saisie-80em' name='subcollection_web' id='subcollection_web' value=\"!!subcollection_web!!\" />
				<input class='bouton' type='button' onClick=\"check_link('subcollection_web')\" title='$msg[CheckLink]' value='$msg[CheckButton]' />
			</div>
		</div>
		<!-- Commentaire -->
		<div id='el0Child_3' class='row' movable='yes' title=\"".htmlentities($msg['subcollection_comment'], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='comment'>$msg[subcollection_comment]</label>
			</div>
			<div class='row'>
				<textarea class='saisie-80em' id='comment' name='comment' cols='62' rows='4' wrap='virtual'>!!comment!!</textarea>
			</div>
		</div>
		!!concept_form!!
		!!thumbnail_url_form!!
		!!aut_pperso!!
		<!-- aut_link -->
	</div>
</div>
<div class='row'>
	<div class='left'>
		<input type='button' class='bouton' value='$msg[76]' onClick=\"unload_off();document.location='./autorites.php?categ=souscollections&sub=reach&user_input=!!user_input_url!!&page=!!page!!&nbr_lignes=!!nbr_lignes!!';\" />
		<input type='submit' value='$msg[77]' class='bouton' onClick=\"return test_form(this.form)\" />
		!!remplace!!
		!!voir_notices!!
		!!audit_bt!!
		<input type='hidden' name='page' value='!!page!!' />
		<input type='hidden' name='nbr_lignes' value='!!nbr_lignes!!' />
		<input type='hidden' name='user_input' value=\"!!user_input!!\" />
	</div>
	<div class='right'>
		!!delete!!
	</div>
</div>
<div class='row'></div>
</form>
<script type='text/javascript'>
	document.forms['saisie_sub_collection'].elements['collection_nom'].focus();
	ajax_parse_dom();
</script>
";

// $collection_replace_form : form remplacement collection
$collection_replace_form = "
<script type='text/javascript'>
<!--
	function test_form(form) {
		if(form.by.value.length == 0) {
			alert(\"$msg[180]\");
			return false;
		}
		return true;
	}
-->
</script>
<form class='form-$current_module' name='coll_replace' method='post' action='./autorites.php?categ=collections&sub=replace&id=!!id!!'>
<h3>$msg[159] !!coll_name!! (!!coll_editeur!!)</h3>
<div class='form-contenu'>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[160]</label>
	</div>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[186]</label>
	</div>
	<div class='row'>
		<input type='text' class='saisie-30emr' class='list' name='coll_libelle' readonly value='' />
		<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=collection&caller=coll_replace&p1=ed_id&p2=ed_libelle&p3=by&p4=coll_libelle&p5=dsubcoll_id&p6=dsubcoll_lib&no_display=!!id!!', 'select_coll', $selector_x_size, $selector_y_size, -2, -2, '$selector_prop')\" title='$msg[157]' value='$msg[parcourir]' />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.coll_libelle.value=''; this.form.ed_libelle.value=''; this.form.by.value='0'; \" />
		<input type='hidden' name='by' value=''>
	</div>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[164]</label>
	</div>
	<div class='row'>
		<input type='text' class='saisie-30emr' class='list' name='ed_libelle' readonly value='' />
		<input type='hidden' name='dsubcoll_id'>
		<input type='hidden' name='dsubcoll_lib'>
		<input type='hidden' name='ed_id' value='!!ed_id!!'>
	</div>
	<div class='row'>		
		<input id='aut_link_save' name='aut_link_save' type='checkbox' checked='checked' value='1'>".$msg["aut_replace_link_save"]."
	</div>	
</div>
<div class='row'>
	<input type='button' class='bouton' value='$msg[76]' onClick=\"document.location='./autorites.php?categ=collections&sub=collection_form&id=!!id!!'\">
	<input type='submit' class='bouton' value='$msg[159]' onClick=\"return test_form(this.form)\">
</div>
</form>
";

// $sub_coll_rep_form : form remplacement sous collection
$sub_coll_rep_form = "
<script type='text/javascript'>
<!--
	function test_form(form) {
		if(form.by.value.length == 0) {
			alert(\"$msg[180]\");
			return false;
		}
		return true;
	}
-->
</script>
<form class='form-$current_module' name='saisie_sub_collection' method='post' action='./autorites.php?categ=souscollections&sub=replace&id=$id'>
<h3>$msg[159] !!subcoll_name!! </h3>
<div class='form-contenu'>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[160]</label>
	</div>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[192]</label>
	</div>
	<div class='row'>
		<input type='text' name='sub_coll_nom'  class='saisie-30emr' readonly value='' />
		<input type='hidden' name='by' value=''>
		<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=subcollection&caller=saisie_sub_collection&p1=ed_id&p2=ed_libelle&p3=coll_id&p4=coll_libelle&p5=by&p6=sub_coll_nom', 'select_sub_coll', $selector_x_size, $selector_y_size, -2, -2, 'toolbar=no, resizable=yes')\" title='$msg[157]' value='$msg[parcourir]' />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.sub_coll_nom.value=''; this.form.coll_libelle.value=''; this.form.ed_libelle.value=''; this.form.ed_id.value=''; this.form.coll_id.value=''; this.form.by.value='0'; \" />
	</div>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[179]</label>
	</div>
	<div class='row'>
		<input type='text' class='saisie-30emr' name='coll_libelle' readonly value='' />
		<input type='hidden' name='coll_id' value='!!coll_id!!' />
	</div>
	<div class='row'>
		<label class='etiquette' for='par'>$msg[164]</label>
	</div>
	<div class='row'>
		<input type='text' class='saisie-30emr' name='ed_libelle' readonly value='' />
		<input type='hidden' name='ed_id' value=''>
	</div>
	<div class='row'>		
		<input id='aut_link_save' name='aut_link_save' type='checkbox' checked='checked' value='1'>".$msg["aut_replace_link_save"]."
	</div>	
</div>
<div class='row'>
	<input type='button' class='bouton' value='$msg[76]' onClick=\"document.location='./autorites.php?categ=souscollections&sub=collection_form&id=!!id!!'\">
	<input type='submit' class='bouton' value='$msg[159]' onClick=\"return test_form(this.form)\">
</div>
</form>
";

