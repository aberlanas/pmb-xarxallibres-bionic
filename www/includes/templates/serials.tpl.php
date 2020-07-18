<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: serials.tpl.php,v 1.225.2.2 2017-11-23 09:24:24 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".tpl.php")) die("no access");

if(!isset($user_query)) $user_query = '';
if(!isset($issn_query)) $issn_query = '';

$serial_header = "
	<h1>!!page_title!!</h1>";

$serial_footer = "";

$serial_access_form ="
<script type='text/javascript'>
<!--
	  function aide_regex() {
			var fenetreAide;
			var prop = 'scrollbars=yes, resizable=yes';
			fenetreAide = openPopUp('./help.php?whatis=regex', 'regex_howto', 500, 400, -2, -2, prop);
	  }
	function test_form() {
		if (document.serial_search.user_query.value=='') {
			document.serial_search.user_query.value='*';
			}
		return true;
	}
-->
</script>

<form class='form-$current_module' name='serial_search' method='post' action='./catalog.php?categ=serials&sub=search' onSubmit='return test_form();' >
	<h3>".$msg["recherche"]." : $msg[771]</h3>
	<div class='form-contenu'>
		<div class='row'>
			<label class='etiquette'>$msg[bulletin_mention_titre_court]</label>
		</div>
		<div class='row'>
			<input class='saisie-inline' id='user_query' type='text' size='36' name='user_query' value='!!user_query!!' />
		</div>
		<div class='row'>
			<span class='astuce'>$msg[155]
				<a class='aide' title='$msg[1900]$msg[1901]$msg[1902]' href='./help.php?whatis=regex' onclick='aide_regex();return false;'>$msg[1550]</a>
			</span>
		</div>
		<div class='row'>
			<label class='etiquette'>$msg[165]</label>
		</div>
		<div class='row'>
			<input class='saisie-inline' id='issn_query' type='text' size='36' name='issn_query' value='!!issn_query!!' />
		</div>
		<div class='row'>
			<label class='etiquette'>".$msg['abonnements_actif_search_filter']."</label>
		</div>
		<div class='row'>
			<input id='filter_abo_actif' type='checkbox' name='filter_abo_actif' ".(isset($filter_abo_actif) && $filter_abo_actif?"checked='checked'":"")." />
		</div>
	</div>
	<div class='row'>
		<input class='bouton' type='submit' value='$msg[142]' />
	</div>
</form>
<script type=\"text/javascript\">
	document.forms['serial_search'].elements['user_query'].focus();
</script>
";

$serial_access_form = str_replace('!!user_query!!', htmlentities(stripslashes($user_query ),ENT_QUOTES, $charset), $serial_access_form);
$serial_access_form = str_replace('!!issn_query!!', htmlentities(stripslashes($issn_query ),ENT_QUOTES, $charset), $serial_access_form);

// template pour le form de catalogage
$select1_prop = "toolbar=no, dependent=yes, resizable=yes, scrollbars=yes";
$select2_prop = "toolbar=no, dependent=yes, resizable=yes, scrollbars=yes";
$select3_prop = "toolbar=no, dependent=yes, resizable=yes, scrollbars=yes";
$select_categ_prop = "toolbar=no, dependent=yes, resizable=yes, scrollbars=yes";

// nombre de parties du form
$nb_onglets = 5;

//	----------------------------------------------------
// 	  $ptab[0] : contenu de l'onglet 0 (Titre)
$ptab[0] = "
<!-- onglet 0 -->
<div id='el0Parent' class='parent'>
	<h3>
		<img src='./images/minus.gif' class='img_plus' align='top' name='imEx' id='el0Img' title='$msg[236]' border='0' onClick=\"expandBase('el0', true); return false;\" />
		$msg[712]
	</h3>
</div>

<div id='el0Child' class='child' etirable='yes' title='".htmlentities($msg[236],ENT_QUOTES, $charset)."' >
	<div id='el0Child_0' title='".htmlentities($msg[237],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit1'>$msg[237]</label>
		</div>
		<div class='row'>
			<input id='f_tit1' type='text' class='saisie-80em' name='f_tit1' value=\"!!tit1!!\" />
		</div>
	</div>
	<div id='el0Child_1' title='".htmlentities($msg[239],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit3'>$msg[239]</label>
		</div>
		<div class='row'>
			<input class='saisie-80em' type='text' id='f_tit3' name='f_tit3' value=\"!!tit3!!\" />
		</div>
	</div>
	<div id='el0Child_2' title='".htmlentities($msg[240],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit4'>$msg[240]</label>
		</div>
		<div class='row'>
			<input class='saisie-80em' id='f_tit4' type='text' name='f_tit4' value=\"!!tit4!!\"  />
		</div>
	</div>
</div>
";

$ptab_bul[0] = "
<!-- onglet 0 -->
<div id='el0Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' align='top' name='imEx' id='el0Img' title='$msg[236]' border='0' onClick=\"expandBase('el0', true); return false;\" />
		$msg[712]
	</h3>
</div>

<div id='el0Child' class='child' etirable='yes' title='".htmlentities($msg[236],ENT_QUOTES, $charset)."' >
	<div id='el0Child_0' title='".htmlentities($msg[239],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit3'>$msg[239]</label>
		</div>
		<div class='row'>
			<input class='saisie-80em' type='text' id='f_tit3' name='f_tit3' value=\"!!tit3!!\" />
		</div>
	</div>
	<div id='el0Child_1' title='".htmlentities($msg[240],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit4'>$msg[240]</label>
		</div>
		<div class='row'>
			<input class='saisie-80em' id='f_tit4' type='text' name='f_tit4' value=\"!!tit4!!\"  />
		</div>
	</div>
</div>
";

//	----------------------------------------------------
// 	  $ptab[1] : contenu de l'onglet 1 (Mention de responsabilit�)
//	----------------------------------------------------

$aut_fonctions = marc_list_collection::get_instance('function');
if($pmb_authors_qualification){
	$authors_qualification_tpl="
		<!--    Vedettes    -->
        <div style='float:left;margin-right:10px;'>
            <label for='f_aut0' class='etiquette'>".$msg['notice_vedette_composee_author']."</label>
			<div class='row'>
				<img class='img_plus' hspace='3' border='0' onclick=\"expand_vedette(this,'vedette0'); return false;\" title='d�tail' name='imEx' src='./images/plus.gif'>
				<input type='text' class='saisie-30emr'  readonly='readonly'  name='notice_role_composed_0_vedette_composee_apercu_autre' id='notice_role_composed_0_vedette_composee_apercu_autre'  data-form-name='vedette_composee' value=\"!!vedette_apercu!!\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"del_vedette('role',!!iaut!!);\" />
			</div>
		</div>
		<div class='row' id='vedette0' style='margin-bottom:6px;display:none'>
			!!vedette_author!!
		</div>
		<script type='text/javascript'>
			vedette_composee_update_all('notice_role_composed_0_vedette_composee_subdivisions');
		</script>
	";
}else{
	$authors_qualification_tpl="";
}
$ptab[1] = "
<script>
	function fonction_selecteur_auteur() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,6)+'_id'+name.substr(6);
		openPopUp('./select.php?what=auteur&caller=notice&param1='+name_id+'&param2='+name+'&dyn=1&deb_rech='+".pmb_escape()."(document.getElementById(name).value), 'select_author2', 500, 400, -2, -2, '$select1_prop');
	}
	function fonction_selecteur_auteur_change(field) {
		// id champ text = 'f_aut'+n+suffixe
		// id champ hidden = 'f_aut'+n+'_id'+suffixe;
		// select.php?what=auteur&caller=notice&param1=f_aut0_id&param2=f_aut0&deb_rech='+t
		name=field.getAttribute('id');
		name_id = name.substr(0,6)+'_id'+name.substr(6);
		openPopUp('./select.php?what=auteur&caller=notice&param1='+name_id+'&param2='+name+'&dyn=1&deb_rech='+".pmb_escape()."(document.getElementById(name).value), 'select_author2', 500, 400, -2, -2, '$select1_prop');
	}
	function fonction_raz_auteur() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,6)+'_id'+name.substr(6);
		document.getElementById(name_id).value=0;
		document.getElementById(name).value='';
	}
	function fonction_selecteur_fonction() {
		name=this.getAttribute('id').substring(4);
		name_code = name.substr(0,4)+'_code'+name.substr(4);
		openPopUp('./select.php?what=function&caller=notice&param1='+name_code+'&param2='+name+'&dyn=1', 'select_fonction2', 500, 400, -2, -2, '$select1_prop');
	}
	function fonction_raz_fonction() {
		name=this.getAttribute('id').substring(4);
		name_code = name.substr(0,4)+'_code'+name.substr(4);
		document.getElementById(name_code).value=0;
		document.getElementById(name).value='';
	}
	function add_aut(n) {
		template = document.getElementById('addaut'+n);
		aut=document.createElement('div');
		aut.className='row';

		// auteur
		colonne=document.createElement('div');
        //colonne.className='colonne3';
        colonne.style.cssFloat = 'left';
        colonne.style.marginRight = '10px';
		row=document.createElement('div');
		row.className='row';
		suffixe = eval('document.notice.max_aut'+n+'.value');
		nom_id = 'f_aut'+n+suffixe;
		f_aut0 = document.createElement('input');
		f_aut0.setAttribute('name',nom_id);
		f_aut0.setAttribute('id',nom_id);
		f_aut0.setAttribute('type','text');
		f_aut0.className='saisie-30emr';
		f_aut0.setAttribute('value','');
		f_aut0.setAttribute('completion','authors');
		f_aut0.setAttribute('autfield','f_aut'+n+'_id'+suffixe);

		sel_f_aut0 = document.createElement('input');
		sel_f_aut0.setAttribute('id','sel_f_aut'+n+suffixe);
		sel_f_aut0.setAttribute('type','button');
		sel_f_aut0.className='bouton';
		sel_f_aut0.setAttribute('readonly','');
		sel_f_aut0.setAttribute('value','$msg[parcourir]');
		sel_f_aut0.onclick=fonction_selecteur_auteur;

		del_f_aut0 = document.createElement('input');
		del_f_aut0.setAttribute('id','del_f_aut'+n+suffixe);
		del_f_aut0.onclick=fonction_raz_auteur;
		del_f_aut0.setAttribute('type','button');
		del_f_aut0.className='bouton';
		del_f_aut0.setAttribute('readonly','');
		del_f_aut0.setAttribute('value','$msg[raz]');

		f_aut0_id = document.createElement('input');
		f_aut0_id.name='f_aut'+n+'_id'+suffixe;
		f_aut0_id.setAttribute('type','hidden');
		f_aut0_id.setAttribute('id','f_aut'+n+'_id'+suffixe);
		f_aut0_id.setAttribute('value','');

		//f_aut0_content.appendChild(f_aut0);
		row.appendChild(f_aut0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(sel_f_aut0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(del_f_aut0);
		row.appendChild(f_aut0_id);
		colonne.appendChild(row);
		aut.appendChild(colonne);

		// fonction
		colonne=document.createElement('div');
        //colonne.className='colonne3';
        colonne.style.cssFloat = 'left';
        colonne.style.marginRight = '10px';
		row=document.createElement('div');
		row.className='row';
		suffixe = eval('document.notice.max_aut'+n+'.value');
		nom_id = 'f_f'+n+suffixe;
		f_f0 = document.createElement('input');
		f_f0.setAttribute('name',nom_id);
		f_f0.setAttribute('id',nom_id);
		f_f0.setAttribute('type','text');
		f_f0.className='saisie-15emr';
		f_f0.setAttribute('value','".($value_deflt_fonction ? $aut_fonctions->table[$value_deflt_fonction] : '')."');
		f_f0.setAttribute('completion','fonction');
		f_f0.setAttribute('autfield','f_f'+n+'_code'+suffixe);

		sel_f_f0 = document.createElement('input');
		sel_f_f0.setAttribute('id','sel_f_f'+n+suffixe);
		sel_f_f0.setAttribute('type','button');
		sel_f_f0.className='bouton';
		sel_f_f0.setAttribute('readonly','');
		sel_f_f0.setAttribute('value','$msg[parcourir]');
		sel_f_f0.onclick=fonction_selecteur_fonction;

		del_f_f0 = document.createElement('input');
		del_f_f0.setAttribute('id','del_f_f'+n+suffixe);
		del_f_f0.onclick=fonction_raz_fonction;
		del_f_f0.setAttribute('type','button');
		del_f_f0.className='bouton';
		del_f_f0.setAttribute('readonly','readonly');
		del_f_f0.setAttribute('value','$msg[raz]');

		f_f0_code = document.createElement('input');
		f_f0_code.name='f_f'+n+'_code'+suffixe;
		f_f0_code.setAttribute('type','hidden');
		f_f0_code.setAttribute('id','f_f'+n+'_code'+suffixe);
		f_f0_code.setAttribute('value','$value_deflt_fonction');

		var duplicate = document.createElement('input');
		duplicate.setAttribute('onclick','duplicate('+n+','+suffixe+')');
		duplicate.setAttribute('type','button');
		duplicate.className='bouton';
		duplicate.setAttribute('readonly','readonly');
		duplicate.setAttribute('value','".$msg["duplicate"]."');

		row.appendChild(f_f0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(sel_f_f0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(del_f_f0);
		row.appendChild(f_f0_code);
		if(!('".$pmb_authors_qualification."'*1)){
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(duplicate);
		}
		colonne.appendChild(row);
        aut.appendChild(colonne);

		if('".$pmb_authors_qualification."'*1){
	        var role_field='role';
	        if(n==1) role_field='role_autre';
	        if(n==2) role_field='role_secondaire';

			var req = new http_request();
			if(req.request('./ajax.php?module=catalog&categ=get_notice_form_vedette&role_field='+role_field+'&index='+suffixe,1)){
				// Il y a une erreur
				alert ( req.get_text() );
			}else {
			 	vedette_form=req.get_text();
			 	var row_vedette=document.createElement('div');
				row_vedette.className='row';
				row_vedette.innerHTML=vedette_form;
			}
			row_vedette.setAttribute('id','vedette'+suffixe+'_'+role_field);
			row_vedette.style.display='none';

			colonne=document.createElement('div');
	        //colonne.className='colonne3';
	        colonne.style.cssFloat = 'left';
			row=document.createElement('div');
			row.className='row';

			var img_plus = document.createElement('img');
			img_plus.name='img_plus'+suffixe;
			img_plus.setAttribute('id','img_plus'+suffixe+'_'+role_field);
			img_plus.className='img_plus';
			img_plus.setAttribute('hspace','3');
			img_plus.setAttribute('border','0');
			img_plus.setAttribute('src','./images/plus.gif');
			img_plus.setAttribute('onclick','expand_vedette(this, \"vedette'+suffixe+'_'+role_field+'\")');

			var nom_id = 'notice_'+role_field+'_composed_'+suffixe+'_vedette_composee_apercu_autre';
			apercu = document.createElement('input');
			apercu.setAttribute('name',nom_id);
			apercu.setAttribute('id',nom_id);
			apercu.setAttribute('type','text');
			apercu.className='saisie-30emr';
			apercu.setAttribute('readonly','readonly');

			var del_vedette = document.createElement('input');
			del_vedette.setAttribute('onclick','del_vedette(\"'+role_field+'\",'+suffixe+')');
			del_vedette.setAttribute('type','button');
			del_vedette.className='bouton';
			del_vedette.setAttribute('readonly','readonly');
			del_vedette.setAttribute('value','$msg[raz]');

			row.appendChild(img_plus);
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(apercu);
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(del_vedette);
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(duplicate);
			colonne.appendChild(row);
			aut.appendChild(colonne);

			template.appendChild(aut);
			template.appendChild(row_vedette);
			eval(document.getElementById('vedette_script_'+role_field+'_composed_'+suffixe).innerHTML);
		}else{
			template.appendChild(aut);
		}
        eval('document.notice.max_aut'+n+'.value=suffixe*1+1*1');
        ajax_pack_element(f_aut0);
		ajax_pack_element(f_f0);
		init_drag();
	}

	function duplicate(n,suffixe){
		add_aut(n);
        new_suffixe = eval('document.notice.max_aut'+n+'.value')-1;
        document.getElementById('f_aut'+n+new_suffixe).value = document.getElementById('f_aut'+n+suffixe).value;
        document.getElementById('f_aut'+n+'_id'+new_suffixe).value = document.getElementById('f_aut'+n+'_id'+suffixe).value;

        document.getElementById('f_f'+n+new_suffixe).value = '';
        document.getElementById('f_f'+n+'_code'+new_suffixe).value = '';
	}

	function fonction_selecteur_categ() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,7)+'_id'+name.substr(7);
		openPopUp('./select.php?what=categorie&caller=notice&p1='+name_id+'&p2='+name+'&dyn=1', 'select_categ', 700, 500, -2, -2, '$select_categ_prop');
	}
	function fonction_raz_categ() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,7)+'_id'+name.substr(7);
		document.getElementById(name_id).value=0;
		document.getElementById(name).value='';
	}
	function add_categ() {
		template = document.getElementById('el6Child_0');
		categ=document.createElement('div');
		categ.className='row';

		suffixe = eval('document.notice.max_categ.value');

		categ.setAttribute('id','drag_'+suffixe);
		categ.setAttribute('order',suffixe);
		categ.setAttribute('highlight','categ_highlight');
		categ.setAttribute('downlight','categ_downlight');
		categ.setAttribute('dragicon','./images/icone_drag_notice.png');
		categ.setAttribute('handler','handle_'+suffixe);
		categ.setAttribute('recepttype','categ');
		categ.setAttribute('recept','yes');
		categ.setAttribute('dragtype','categ');
		categ.setAttribute('draggable','yes');

		nom_id = 'f_categ'+suffixe
		f_categ = document.createElement('input');
		f_categ.setAttribute('name',nom_id);
		f_categ.setAttribute('id',nom_id);
		f_categ.setAttribute('type','text');
		f_categ.className='saisie-80emr';
		f_categ.setAttribute('value','');
		f_categ.setAttribute('completion','categories_mul');
		f_categ.setAttribute('autfield','f_categ_id'+suffixe);

		del_f_categ = document.createElement('input');
		del_f_categ.setAttribute('id','del_f_categ'+suffixe);
		del_f_categ.onclick=fonction_raz_categ;
		del_f_categ.setAttribute('type','button');
		del_f_categ.className='bouton';
		del_f_categ.setAttribute('readonly','');
		del_f_categ.setAttribute('value','$msg[raz]');

		f_categ_id = document.createElement('input');
		f_categ_id.name='f_categ_id'+suffixe;
		f_categ_id.setAttribute('type','hidden');
		f_categ_id.setAttribute('id','f_categ_id'+suffixe);
		f_categ_id.setAttribute('value','');

		var f_categ_span_handle = document.createElement('span');
		f_categ_span_handle.setAttribute('id','handle_'+suffixe);
		f_categ_span_handle.style.float='left';
		f_categ_span_handle.style.paddingRight='7px';

		var f_categ_drag_img = document.createElement('img');
		f_categ_drag_img.setAttribute('src','./images/sort.png');
		f_categ_drag_img.style.width='12px';
		f_categ_drag_img.style.verticalAlign='middle';

		f_categ_span_handle.appendChild(f_categ_drag_img);
		f_categ_span_handle.appendChild(f_categ_drag_img);

		categ.appendChild(f_categ_span_handle);

		categ.appendChild(f_categ);
		space=document.createTextNode(' ');
		categ.appendChild(space);
		categ.appendChild(del_f_categ);
		categ.appendChild(f_categ_id);

		template.appendChild(categ);

		tab_categ_order = document.getElementById('tab_categ_order');
		if (tab_categ_order.value != '') tab_categ_order.value += ','+suffixe;

		document.notice.max_categ.value=suffixe*1+1*1 ;
		ajax_pack_element(f_categ);
		init_drag();
	}
	function fonction_selecteur_lang() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,6)+'_code'+name.substr(6);
		openPopUp('./select.php?what=lang&caller=notice&p1='+name_id+'&p2='+name, 'select_lang', 500, 400, -2, -2, '$select2_prop');
	}
	function add_lang() {
		templates.add_completion_selection_field('f_lang', 'f_lang_code', 'langue', fonction_selecteur_lang);
	}

	function fonction_selecteur_langorg() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,9)+'_code'+name.substr(9);
		openPopUp('./select.php?what=lang&caller=notice&p1='+name_id+'&p2='+name, 'select_lang', 500, 400, -2, -2, '$select2_prop');
	}
	function add_langorg() {
		templates.add_completion_selection_field('f_langorg', 'f_langorg_code', 'langue', fonction_selecteur_langorg);
	}

	function expand_vedette(el,what) {
		var obj=document.getElementById(what);
		if(obj.style.display=='none'){
			obj.style.display='block';
	    	el.src = './images/minus.gif';
			init_drag();
		}else{
			obj.style.display='none';
	    	el.src =  './images/plus.gif';
		}
	}

	function del_vedette(role,index) {
		vedette_composee_delete_all('notice_'+role+'_composed_'+index+'_vedette_composee_subdivisions');
		init_drag();
	}
</script>
<div id='el1Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el1Img' onClick=\"expandBase('el1', true); return false;\" title='$msg[243]' border='0' />
		$msg[243]
	</h3>
</div>
<div id='el1Child' class='child' etirable='yes' title='".htmlentities($msg[243],ENT_QUOTES, $charset)."'>
	<div id='el1Child_0' title='".htmlentities($msg[244],ENT_QUOTES, $charset)."' movable='yes'>
		<!--	Auteur principal	-->
		<div class='row'>
			<div id='el1Child_0a' style='float:left;margin-right:10px;'>
				<label for='f_aut0' class='etiquette'>$msg[244]</label>
				<div class='row'>
					<input type='text' completion='authors' autfield='f_aut0_id' id='auteur0' class='saisie-30emr' name='f_aut0' data-form-name='f_aut0' value=\"!!aut0!!\" />
					<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=auteur&caller=notice&param1=f_aut0_id&param2=f_aut0&deb_rech='+".pmb_escape()."(this.form.f_aut0.value), 'select_author0', 500, 400, -2, -2, '$select1_prop')\" />
					<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_aut0.value=''; this.form.f_aut0_id.value='0'; \" />
					<input type='hidden' name='f_aut0_id' data-form-name='f_aut0_id' id='f_aut0_id' value=\"!!aut0_id!!\" />
				</div>
			</div>
			<!--	Fonction	-->
			<div id='el1Child_1a' style='float:left;margin-right:10px;'>
				<label for='f_f0' class='etiquette'>$msg[245]</label>
				<div class='row'>
					<input type='text' class='saisie-15emr' id='f_f0' name='f_f0' data-form-name='f_f0' value=\"!!f0!!\" completion=\"fonction\" autfield=\"f_f0_code\" />
					<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=function&caller=notice&p1=f_f0_code&p2=f_f0', 'select_func0', 500, 400, -2, -2, '$select2_prop')\" />
					<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_f0.value=''; this.form.f_f0_code.value='0'; \" />
					<input type='hidden' name='f_f0_code' data-form-name='f_f0_code' id='f_f0_code' value=\"!!f0_code!!\" />
				</div>
			</div>
			$authors_qualification_tpl
		</div>
		<div class='row'></div>
	</div>
	<div id='el1Child_2' title='".htmlentities($msg[246],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Autres auteurs    -->
	    <div id='el1Child_2a' class='row'>
	    	<div class='row'>
		        <label for='f_aut1' class='etiquette'>$msg[246]</label>
		        <input type='hidden' name='max_aut1' value=\"!!max_aut1!!\" />
	        </div>
	        <div class='row' id='addaut1'>
		        !!autres_auteurs!!
			</div>
		</div>
		<div class='row'></div>
	</div>
	<div id='el1Child_3' title='".htmlentities($msg[247],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Auteurs secondaires     -->
	    <div  id='el1Child_3a' class='row'>
	    	<div class='row'>
		        <label for='f_aut2' class='etiquette'>$msg[247]</label>
		        <input type='hidden' name='max_aut2' value=\"!!max_aut2!!\" />
	        </div>
	        <div class='row' id='addaut2'>
	        	!!auteurs_secondaires!!
			</div>
		</div>
		<div class='row'></div>
	</div>
</div>
";

//	----------------------------------------------------
//	Autres auteurs
//	----------------------------------------------------
if($pmb_authors_qualification){
	$authors_add_aut_button_tpl="";
	$authors_qualification_tpl="
         <!--    Vedettes    -->
        <div  id='el1Child_2b_others_vedettes' style='float:left;'>
			<div class='row'>
				<img class='img_plus' hspace='3' border='0' onclick=\"expand_vedette(this,'vedette!!iaut!!_autre'); return false;\" title='d�tail' name='imEx' src='./images/plus.gif'>
				<input type='text' class='saisie-30emr'  readonly='readonly'  name='notice_role_autre_composed_!!iaut!!_vedette_composee_apercu_autre' id='notice_role_autre_composed_!!iaut!!_vedette_composee_apercu_autre'  data-form-name='vedette_composee_autre' value=\"!!vedette_apercu!!\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"del_vedette('role_autre',!!iaut!!);\" />
				<input class='bouton' type='button' onclick='duplicate(1,!!iaut!!);' value='".$msg['duplicate']."'>
				<input type='button' style='!!bouton_add_display!!' class='bouton' value='+' onClick=\"add_aut(1);\"/>
            </div>
		</div>
		<div class='row' id='vedette!!iaut!!_autre' style='margin-bottom:6px;display:none'>
			!!vedette_author!!
		</div>
		<script type='text/javascript'>
			vedette_composee_update_all('notice_role_autre_composed_!!iaut!!_vedette_composee_subdivisions');
		</script>
	";
}else{
	$authors_add_aut_button_tpl="
		<input class='bouton' type='button' onclick='duplicate(1,!!iaut!!);' value='".$msg['duplicate']."'>
		<input type='button' style='!!bouton_add_display!!' class='bouton' value='+' onClick=\"add_aut(1);\"/>";
	$authors_qualification_tpl="";
}
$ptab[11] = "
	<div class='row'>
		<div id='el1Child_2b_first' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-30emr' completion='authors' autfield='f_aut1_id!!iaut!!' id='f_aut1!!iaut!!' name='f_aut1!!iaut!!' value=\"!!aut1!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=auteur&caller=notice&param1=f_aut1_id!!iaut!!&param2=f_aut1!!iaut!!&deb_rech='+".pmb_escape()."(this.form.f_aut1!!iaut!!.value), 'select_author2', 400, 400, -2, -2, '$select1_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_aut1!!iaut!!.value=''; this.form.f_aut1_id!!iaut!!.value='0'; \" />
				<input type='hidden' name='f_aut1_id!!iaut!!' data-form-name='f_aut1_id' id='f_aut1_id!!iaut!!' value=\"!!aut1_id!!\" />
				</div>
			</div>
		<!--	Fonction	-->
		<div id='el1Child_2b_others' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-15emr' id='f_f1!!iaut!!' name='f_f1!!iaut!!' completion='fonction' autfield='f_f1_code!!iaut!!' value=\"!!f1!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=function&caller=notice&p1=f_f1_code!!iaut!!&p2=f_f1!!iaut!!', 'select_func2', 400, 400, -2, -2, '$select2_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_f1!!iaut!!.value=''; this.form.f_f1_code!!iaut!!.value='0'; \" />
				<input type='hidden' name='f_f1_code!!iaut!!' id='f_f1_code!!iaut!!' value=\"!!f1_code!!\" />
				$authors_add_aut_button_tpl
			</div>
		</div>
		$authors_qualification_tpl
	</div>
	" ;

//	----------------------------------------------------
//	Autres secondaires
//	----------------------------------------------------
if($pmb_authors_qualification){
	$authors_add_aut_button_tpl="";
	$authors_qualification_tpl="
        <!--    Vedettes    -->
        <div  id='el1Child_3b_others_vedettes' style='float:left'>
			<div class='row'>
				<img class='img_plus' hspace='3' border='0' onclick=\"expand_vedette(this,'vedette!!iaut!!_secondaire'); return false;\" title='d�tail' name='imEx' src='./images/plus.gif'>
				<input type='text' class='saisie-30emr'  readonly='readonly'  name='notice_role_secondaire_composed_!!iaut!!_vedette_composee_apercu_autre' id='notice_role_secondaire_composed_!!iaut!!_vedette_composee_apercu_autre'  data-form-name='vedette_composee' value=\"!!vedette_apercu!!\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"del_vedette('role_secondaire',!!iaut!!);\" />
				<input class='bouton' type='button' onclick='duplicate(2,!!iaut!!);' value='".$msg['duplicate']."'>
				<input type='button' style='!!bouton_add_display!!' class='bouton' value='+' onClick=\"add_aut(2);\"/>
            </div>
		</div>
		<div class='row' id='vedette!!iaut!!_secondaire' style='margin-bottom:6px;display:none'>
			!!vedette_author!!
		</div>
		<script type='text/javascript'>
			vedette_composee_update_all('notice_role_secondaire_composed_!!iaut!!_vedette_composee_subdivisions');
		</script>
	";
}else{
	$authors_add_aut_button_tpl="
		<input class='bouton' type='button' onclick='duplicate(2,!!iaut!!);' value='".$msg['duplicate']."'>
		<input type='button' style='!!bouton_add_display!!' class='bouton' value='+' onClick=\"add_aut(2);\"/>	";
	$authors_qualification_tpl="";
}
$ptab[12] = "
	<div class='row'>
		<div id='el1Child_3b_first' style='float:left;margin-right:10px;'>
			<div class='row'>
				 <input type='text' class='saisie-30emr' completion='authors' autfield='f_aut2_id!!iaut!!' id='f_aut2!!iaut!!' name='f_aut2!!iaut!!' data-form-name='f_aut2' value=\"!!aut2!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=auteur&caller=notice&param1=f_aut2_id!!iaut!!&param2=f_aut2!!iaut!!&deb_rech='+".pmb_escape()."(this.form.f_aut2!!iaut!!.value), 'select_author2', 500, 400, -2, -2, '$select1_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_aut2!!iaut!!.value=''; this.form.f_aut2_id!!iaut!!.value='0'; \" />
				<input type='hidden' name='f_aut2_id!!iaut!!' data-form-name='f_aut2_id' id='f_aut2_id!!iaut!!' value=\"!!aut2_id!!\" />
			</div>
		</div>
		<!--	Fonction	-->
		<div id='el1Child_3b_others' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-15emr' id='f_f2!!iaut!!' name='f_f2!!iaut!!' completion='fonction' autfield='f_f2_code!!iaut!!' value=\"!!f2!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=function&caller=notice&p1=f_f2_code!!iaut!!&p2=f_f2!!iaut!!', 'select_func2', 500, 400, -2, -2, '$select2_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_f2!!iaut!!.value=''; this.form.f_f2_code!!iaut!!.value='0'; \" />
				$authors_add_aut_button_tpl
				<input type='hidden' name='f_f2_code!!iaut!!' data-form-name='f_f2_code' id='f_f2_code!!iaut!!' value=\"!!f2_code!!\" />
			</div>			
		</div>
		$authors_qualification_tpl
	</div>
	" ;

//	----------------------------------------------------
// 	  $ptab[2] : contenu de l'onglet 2 Editeurs
//	----------------------------------------------------
$ptab[2] = "
<!-- onglet 2 -->
<div id='el2Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el2Img' border='0' onClick=\"expandBase('el2', true); return false;\" />
		".$msg['serial_onglet_editeurs']."
	</h3>
</div>
<div id='el2Child' class='child' etirable='yes' title='".htmlentities($msg[249],ENT_QUOTES, $charset)."'>
	<div id='el2Child_0' title='".htmlentities($msg[164],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Editeur    -->
		<div id='el2Child_0a' class='row'>
			<label for='f_ed1' class='etiquette'>$msg[164]</label>
		</div>
		<div id='el2Child_0b' class='row'>
			<input type='text' completion='publishers' autfield='f_ed1_id' id='f_ed1' name='f_ed1' data-form-name='f_ed1' value=\"!!ed1!!\" class='saisie-30emr' />
			<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=editeur&caller=notice&p1=f_ed1_id&p2=f_ed1&p3=dummy&p4=dummy&p5=dummy&p6=dummy&deb_rech='+".pmb_escape()."(this.form.f_ed1.value), 'select_ed1', 500, 400, -2, -2, '$select1_prop')\" />
			<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_ed1.value=''; this.form.f_ed1_id.value='0'; \" />
			<input type='hidden' name='f_ed1_id' id='f_ed1_id' data-form-name='f_ed1_id' value=\"!!ed1_id!!\" />
		</div>
	</div>
	<div id='el2Child_4' title='".htmlentities($msg[252],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Ann�e    -->
			<div id='el2Child_4a' class='row'>
				<label for='f_year' class='etiquette'>$msg[252]</label>
			</div>
			<div id='el2Child_4b' class='row'>
				<input type='text' class='saisie-30em' id='f_year' name='f_year' value=\"!!year!!\" />
			</div>
		</div>
	<div id='el2Child_7' title='".htmlentities($msg[254],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Autre �diteur    -->
		<div id='el2Child_7a' class='row'>
			<label for='f_ed2' class='etiquette'>$msg[254]</label>
		</div>
		<div id='el2Child_7b' class='row'>
	    	<input type='text' completion='publishers' autfield='f_ed2_id' id='f_ed2' name='f_ed2' data-form-name='f_ed2' value=\"!!ed2!!\" class='saisie-30emr' />
	    	<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=editeur&caller=notice&p1=f_ed2_id&p2=f_ed2&p3=dummy&p4=dummy&p5=dummy&p6=dummy&deb_rech='+".pmb_escape()."(this.form.f_ed2.value), 'select_ed1', 500, 400, -2, -2, '$select1_prop')\" />
	    	<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_ed2.value=''; this.form.f_ed2_id.value='0'; \" />
	    	<input type='hidden' name='dummy' />
	    	<input type='hidden' name='f_ed2_id' id='f_ed2_id' data-form-name='f_ed2_id' value=\"!!ed2_id!!\" />
		</div>
	</div>
</div>
";

//	----------------------------------------------------
//	ISBN, EAN ou no. commercial
// 	  $ptab[30] : contenu de l'onglet 30
//	----------------------------------------------------
$ptab[30] = "
<!-- onglet 30 -->
<div id='el30Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el30Img' title='$msg[255]' border='0' onClick=\"expandBase('el30', true); return false;\" />
		$msg[serial_ISSN]
	</h3>
</div>
<div id='el30Child' class='child' etirable='yes' title='".htmlentities($msg["serial_ISSN"],ENT_QUOTES, $charset)."'>
	<div id='el30Child_0' title='$msg[serial_ISSN]' movable='yes'>
		<!--	ISBN, EAN ou no. commercial	-->
		<div id='el30Child_0a' class='row'>
			<label for='f_cb' class='etiquette'>$msg[serial_ISSN]</label>
		</div>
		<div id='el30Child_0b' class='row'>
			<input class='saisie-20emr' id='f_cb' name='f_cb' data-form-name='f_cb' readonly value=\"!!cb!!\" />
		    <input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./catalog/setcb.php?notice_id=!!notice_id!!', 'getcb', 300, 150, -2, -2, 'toolbar=no, resizable=yes')\" />
		    <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_cb.value=''; \" />
		</div>
	</div>
</div>
";


//	----------------------------------------------------
// 	  $ptab[3] : contenu de l'onglet 3 (Notes)
//	----------------------------------------------------
$ptab[3] = "
<!-- onglet 3 -->
<div id='el5Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el5Img' title='$msg[263]' border='0' onClick=\"expandBase('el5', true); return false;\" />
		$msg[264]
	</h3>
</div>
<div id='el5Child' class='child' etirable='yes' title='".htmlentities($msg[264],ENT_QUOTES, $charset)."'>
	<div id='el5Child_0' title='".htmlentities($msg[265],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Note g�n�rale    -->
		<div id='el5Child_0a' class='row'>
			<label for='f_n_gen' class='etiquette'>$msg[265]</label>
		</div>
		<div id='el5Child_0b' class='row'>
			<textarea id='f_n_gen' class='saisie-80em' name='f_n_gen' rows='3' wrap='virtual'>!!n_gen!!</textarea>
		</div>
	</div>
	<div id='el5Child_1' title='".htmlentities($msg[266],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Note de contenu    -->
		<div id='el5Child_1a' class='row'>
			<label for='f_n_contenu' class='etiquette'>$msg[266]</label>
		</div>
		<div id='el5Child_1b' class='row'>
			<textarea class='saisie-80em' id='f_n_contenu' name='f_n_contenu' rows='5' wrap='virtual'>!!n_contenu!!</textarea>
		</div>
	</div>
	<div id='el5Child_2' title='".htmlentities($msg[267],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    R�sum�/extrait    -->
		<div id='el5Child_2a' class='row'>
			<label for='f_n_resume' class='etiquette'>$msg[267]</label>
		</div>
		<div id='el5Child_2b' class='row'>
			<textarea class='saisie-80em' id='f_n_resume' name='f_n_resume' rows='5' wrap='virtual'>!!n_resume!!</textarea>
		</div>
	</div>
</div>
";

//	----------------------------------------------------
// 	  $ptab[4] : contenu de l'onglet 4 (Indexation)
//	----------------------------------------------------
$ptab[4] = "
<!-- onglet 4 -->
<div id='el6Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el6Img' title=\"$msg[268]\" border='0' onClick=\"expandBase('el6', true);recalc_recept(); return false;\" />
		$msg[269]
	</h3>
</div>
<div id='el6Child' class='child' etirable='yes' title='".htmlentities($msg[269],ENT_QUOTES, $charset)."'>
	<div id='el6Child_0' title='".htmlentities($msg[134],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Cat�gories    -->
		<div id='el6Child_0a' class='row'>
			<label for='f_categ' class='etiquette'>$msg[134]</label>
		</div>
		<input type='hidden' name='max_categ' value=\"!!max_categ!!\" />
		!!categories_repetables!!
		<div id='addcateg'/>
		</div>
	</div>
	<div id='el6Child_1' title='".htmlentities($msg["indexint_catal_title"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    indexation interne    -->
		<div id='el6Child_1a' class='row'>
			<label for='f_categ' class='etiquette'>$msg[indexint_catal_title]</label>
		</div>
		<div id='el6Child_1b' class='row'>
			<input type='text' class='saisie-80emr' id='f_indexint' name='f_indexint' value=\"!!indexint!!\" completion=\"indexint\" autfield=\"f_indexint_id\" />
			<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=indexint&caller=notice&param1=f_indexint_id&param2=f_indexint&parent=0&deb_rech='+".pmb_escape()."(this.form.f_indexint.value)+'&typdoc='+(this.form.typdoc.value)+'&num_pclass=!!num_pclass!!', 'select_categ', 600, 320, -2, -2, '$select3_prop')\" />
			<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_indexint.value=''; this.form.f_indexint_id.value='0'; \" />
			<input type='hidden' name='f_indexint_id' id='f_indexint_id' value='!!indexint_id!!' />
		</div>
	</div>
	<div id='el6Child_2' title='".htmlentities($msg[324],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Indexation libre    -->
		<div id='el6Child_2a' class='row'>
			<label for='f_indexation' class='etiquette'>$msg[324]</label>
		</div>
		<div id='el8Child_2b' class='row'>
			<textarea class='saisie-80em' id='f_indexation' completion='tags' keys='113' name='f_indexation' rows='3' wrap='virtual'>!!f_indexation!!</textarea>
		</div>
		<div id='el8Child_2_comment' class='row'>
			<span>$msg[324]$msg[1901]$msg[325]</span>
		</div>
	</div>
	!!concept_form!!
</div>
";
//	----------------------------------------------------
//	 Categories repetables
// 	  $ptab[40]
//	----------------------------------------------------
$ptab[40] = "
	<script type='text/javascript' src='./javascript/categ_drop.js'></script>
	<input type='hidden' name='tab_categ_order' id='tab_categ_order' value='!!tab_categ_order!!' />
	<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=categorie&caller=notice&autoindex_class=autoindex_record&indexation_lang=!!indexation_lang_sel!!&p1=f_categ_id!!icateg!!&p2=f_categ!!icateg!!&dyn=1&parent=0&deb_rech=', 'select_categ', 700, 500, -2, -2, '$select_categ_prop')\" />
	<input type='button' class='bouton' value='+' onClick=\"add_categ();\"/>

	<div id='drag_!!icateg!!'  class='row' dragtype='categ' draggable='yes' recept='yes' recepttype='categ' handler='handle_!!icateg!!'
		dragicon=\"".$base_path."/images/icone_drag_notice.png\" dragtext='!!categ_libelle!!' downlight=\"categ_downlight\" highlight=\"categ_highlight\"
		order='!!icateg!!' style='' >
		<span id=\"handle_!!icateg!!\" style=\"float:left; padding-right : 7px\"><img src=\"".$base_path."/images/sort.png\" style='width:12px; vertical-align:middle' /></span>

		<input type='text' class='saisie-80emr' id='f_categ!!icateg!!' name='f_categ!!icateg!!' value=\"!!categ_libelle!!\" completion=\"categories_mul\" autfield=\"f_categ_id!!icateg!!\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_categ!!icateg!!.value=''; this.form.f_categ_id!!icateg!!.value='0'; \" />
		<input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
	</div>
	";
$ptab[401] = "
	<div id='drag_!!icateg!!' class='row' dragtype='categ' draggable='yes' recept='yes' recepttype='categ' handler='handle_!!icateg!!'
		dragicon=\"".$base_path."/images/icone_drag_notice.png\" dragtext='!!categ_libelle!!' downlight=\"categ_downlight\" highlight=\"categ_highlight\"
		order='!!icateg!!' style='' >
		<span id=\"handle_!!icateg!!\" style=\"float:left; padding-right : 7px\"><img src=\"".$base_path."/images/sort.png\" style='width:12px; vertical-align:middle' /></span>

		<input type='text' class='saisie-80emr' id='f_categ!!icateg!!' name='f_categ!!icateg!!' value=\"!!categ_libelle!!\" completion=\"categories_mul\" autfield=\"f_categ_id!!icateg!!\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_categ!!icateg!!.value=''; this.form.f_categ_id!!icateg!!.value='0'; \" />
		<input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
	</div>
	";

//    ----------------------------------------------------
//     Langue de la publication
//       $ptab[7] : contenu de l'onglet 7 (langues)
//    ----------------------------------------------------

$ptab[5] = "
<!-- onglet 7 -->
<div id='el7Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el7Img' title='langues' border='0' onClick=\"expandBase('el7', true); return false;\" />
		$msg[710]
	</h3>
</div>
<div id='el7Child' class='child' etirable='yes' title='".htmlentities($msg[710],ENT_QUOTES, $charset)."'>
	<div id='el7Child_0' title='".htmlentities($msg[710],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Langues    -->
		<div id='el7Child_0a' class='row'>
			<label for='f_langue' class='etiquette'>$msg[710]</label>
		</div>
		<input type='hidden' id='max_lang' name='max_lang' value=\"!!max_lang!!\" />
		!!langues_repetables!!
		<div id='addlang'/>
		</div>
	</div>
	<div id='el7Child_1' title='".htmlentities($msg[711],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Langues    -->
		<div id='el7Child_1a' class='row'>
			<label for='f_langorg' class='etiquette'>$msg[711]</label>
		</div>
		<input type='hidden' id='max_langorg' name='max_langorg' value=\"!!max_langorg!!\" />
		!!languesorg_repetables!!
		<div id='addlangorg'/>
		</div>
	</div>
</div>
";

//    ----------------------------------------------------
//     Langues repetables
//       $ptab[70]
//    ----------------------------------------------------
$ptab[50] = "
	<div id='el7Child_0a' class='row'>
		<input type='text' class='saisie-30emr' id='f_lang!!ilang!!' name='f_lang!!ilang!!' value=\"!!lang!!\" completion=\"langue\" autfield=\"f_lang_code!!ilang!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_lang_code!!ilang!!&p2=f_lang!!ilang!!', 'select_lang', 400, 400, -2, -2, '$select2_prop')\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_lang!!ilang!!.value=''; this.form.f_lang_code!!ilang!!.value=''; \" />
		<input type='hidden' name='f_lang_code!!ilang!!' id='f_lang_code!!ilang!!' value='!!lang_code!!' />
		<input type='button' class='bouton' value='+' onClick=\"add_lang();\"/>
	</div>
	";

$ptab[501] = "
	<div id='el7Child_0a' class='row'>
		<input type='text' class='saisie-30emr' id='f_lang!!ilang!!' name='f_lang!!ilang!!' value=\"!!lang!!\" completion=\"langue\" autfield=\"f_lang_code!!ilang!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_lang_code!!ilang!!&p2=f_lang!!ilang!!', 'select_lang', 400, 400, -2, -2, '$select2_prop')\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_lang!!ilang!!.value=''; this.form.f_lang_code!!ilang!!.value=''; \" />
		<input type='hidden' name='f_lang_code!!ilang!!' id='f_lang_code!!ilang!!' value='!!lang_code!!' />
	</div>
	";

//    ----------------------------------------------------
//     Langues originales repetables
//       $ptab[71]
//    ----------------------------------------------------
$ptab[51] = "
	<div id='el7Child_0b' class='row'>
		<input type='text' class='saisie-30emr' id='f_langorg!!ilangorg!!' name='f_langorg!!ilangorg!!' value=\"!!langorg!!\" completion=\"langue\" autfield=\"f_langorg_code!!ilangorg!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_langorg_code!!ilangorg!!&p2=f_langorg!!ilangorg!!', 'select_lang', 400, 400, -2, -2, '$select2_prop')\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_langorg!!ilangorg!!.value=''; this.form.f_langorg_code!!ilangorg!!.value=''; \" />
		<input type='hidden' name='f_langorg_code!!ilangorg!!' id='f_langorg_code!!ilangorg!!' value='!!langorg_code!!' />
		<input type='button' class='bouton' value='+' onClick=\"add_langorg();\"/>
	</div>
	";
$ptab[511] = "
	<div id='el7Child_0b' class='row'>
		<input type='text' class='saisie-30emr' id='f_langorg!!ilangorg!!' name='f_langorg!!ilangorg!!' value=\"!!langorg!!\" completion=\"langue\" autfield=\"f_langorg_code!!ilangorg!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_langorg_code!!ilangorg!!&p2=f_langorg!!ilangorg!!', 'select_lang', 400, 400, -2, -2, '$select2_prop')\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_langorg!!ilangorg!!.value=''; this.form.f_langorg_code!!ilangorg!!.value=''; \" />
		<input type='hidden' name='f_langorg_code!!ilangorg!!' id='f_langorg_code!!ilangorg!!' value='!!langorg_code!!' />
	</div>
	";


//	----------------------------------------------------
// 	  $ptab[6] : contenu de l'onglet 6 (Liens (ressources electroniques))
//	----------------------------------------------------
$ptab[6] = "
<script>
function chklnk_f_lien(element){
	if(element.value != ''){
		var wait = document.createElement('img');
		wait.setAttribute('src','images/patience.gif');
		wait.setAttribute('align','top');
		while(document.getElementById('f_lien_check').firstChild){
			document.getElementById('f_lien_check').removeChild(document.getElementById('f_lien_check').firstChild);
		}
		document.getElementById('f_lien_check').appendChild(wait);
		var testlink = encodeURIComponent(element.value);
		var req = new XMLHttpRequest();
		req.open('GET', './ajax.php?module=ajax&categ=chklnk&timeout=!!pmb_curl_timeout!!&link='+testlink, true);
		req.onreadystatechange = function (aEvt) {
		  if (req.readyState == 4) {
		  	if(req.status == 200){
				var img = document.createElement('img');
			    var src='';
			    if(req.responseText == '200'){
			    	if((element.value.substr(0,7) != 'http://') && (element.value.substr(0,8) != 'https://')) element.value = 'http://'+element.value;
					//impec, on print un petit message de confirmation
					src = 'images/tick.gif';
				}else{
			      //probl�me...
					src = 'images/error.png';
					img.setAttribute('style','height:1.5em;');
			    }
			    img.setAttribute('src',src);
				img.setAttribute('align','top');
				while(document.getElementById('f_lien_check').firstChild){
					document.getElementById('f_lien_check').removeChild(document.getElementById('f_lien_check').firstChild);
				}
				document.getElementById('f_lien_check').appendChild(img);
			}
		  }
		};
		req.send(null);
	}
}
</script>
<!-- onglet 6 serials.tpl.php -->
<div id='el8Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el8Img' onClick=\"expandBase('el8', true); return false;\" title='$msg[274]' border='0' />
		$msg[274]
	</h3>
</div>
<div id='el8Child' class='child' etirable='yes' title='".htmlentities($msg[274],ENT_QUOTES, $charset)."'>
	<div id='el8Child_0' title='".htmlentities($msg[275],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    URL associ�e    -->
		<div id='el8Child_0a' class='row'>
			<label for='f_l' class='etiquette'>$msg[275]</label>
		</div>
		<div id='el8Child_0b' class='row'>
			<div id='f_lien_check' style='display:inline'></div>
			<input name='f_lien' type='text' class='saisie-80em' id='f_lien' onchange='chklnk_f_lien(this);' value=\"!!lien!!\" maxlength='255' />
			<input class='bouton' type='button' onClick=\"var l=document.getElementById('f_lien').value; eval('window.open(\''+l+'\')');\" title='$msg[CheckLink]' value='$msg[CheckButton]' />
		</div>
	</div>
	<div id='el8Child_1' title='".htmlentities($msg[276],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Format �lectronique de la ressource    -->
		<div id='el8Child_1a' class='row'>
			<label for='f_eformat' class='etiquette'>$msg[276]</label>
		</div>
		<div id='el8Child_1b' class='row'>
			<input type='text' class='saisie-80em' id='f_eformat' name='f_eformat' value=\"!!eformat!!\" />
		</div>
	</div>
</div>
";

//	----------------------------------------------------
//	Champs personnalises
// 	  $ptab[7] : Contenu de l'onglet 7 (champs personnalises)
//	----------------------------------------------------

$ptab[7] = "
<!-- onglet 7 -->
<div id='el9Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el9Img' onClick=\"expandBase('el9', true); recalc_recept(); return false;\" title='".$msg["notice_champs_perso"]."' border='0' /> ".$msg["notice_champs_perso"]."
	</h3>
</div>
<div id='el9Child' class='child' etirable='yes' title='".$msg["notice_champs_perso"]."'>
	!!champs_perso!!
</div>
";
/* --------------------------------LLIUREX CONVOCATORIA----------------
$ptab[999] = "
<!-- onglet 7 -->
<div id='el999Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el999Img' onClick=\"expandBase('el999', true); recalc_recept(); return false;\" title='".$msg["notice_champs_convo"]."' border='0' /> ".$msg["notice_champs_convo"]."
	</h3>
</div>
<div id='el999Child' class='child' etirable='yes' title='".$msg["notice_champs_convo"]."'>
	!!champs_perso!!
</div>
";
-------------------------------------LLIUREX CONVOCATORIA ------------------------------------------- */
//    ----------------------------------------------------
//    Champs de gestion
//       $ptab[8] : Contenu de l'onglet 8 (champs de gestion)
//    ----------------------------------------------------

$ptab[8] = "
<!-- onglet 8 -->
<div id='el10Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el10Img' onClick=\"expandBase('el10', true); return false;\" title='".$msg["notice_champs_gestion"]."' border='0' /> ".$msg["notice_champs_gestion"]."
	</h3>
</div>
<div id='el10Child' class='child' etirable='yes' title='".htmlentities($msg["notice_champs_gestion"],ENT_QUOTES, $charset)."'>
	<div id='el10Child_0' title='".htmlentities($msg["notice_statut_gestion"],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_0a' class='row'>
			<label for='f_notice_statut' class='etiquette'>$msg[notice_statut_gestion]</label>
		</div>
		<div id='el10Child_0b' class='row'>
			!!notice_statut!!
		</div>
	</div>
	<div id='el10Child_7' title='".htmlentities($msg["notice_is_new_gestion"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Nouveaut�    -->
		<div id='el10Child_7a' class='row'>
		    <label for='f_new_gestion' class='etiquette'>".$msg["notice_is_new_gestion"]."</label>
		</div>
		<div id='el10Child_7b' class='row'>
		    <input type='radio' name='f_notice_is_new' !!checked_no!! value='0'>".$msg["notice_is_new_gestion_no"]."<br>
		    <input type='radio' name='f_notice_is_new' !!checked_yes!! value='1'>".$msg["notice_is_new_gestion_yes"]."<br>
		</div>
	</div>
	<div id='el10Child_1' title='".htmlentities($msg["notice_commentaire_gestion"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    commentaire de gestion    -->
		<div id='el10Child_1a' class='row'>
			<label for='f_commentaire_gestion' class='etiquette'>$msg[notice_commentaire_gestion]</label>
		</div>
		<div id='el10Child_1b' class='row'>
			<textarea class='saisie-80em' id='f_commentaire_gestion' name='f_commentaire_gestion' rows='1' wrap='virtual'>!!commentaire_gestion!!</textarea>
		</div>
	</div>
	<div id='el10Child_2' title='".htmlentities($msg["notice_thumbnail_url"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    URL vignette speciale    -->
		<div id='el10Child_2a' class='row'>
			<label for='f_thumbnail_url' class='etiquette'>$msg[notice_thumbnail_url]</label>
		</div>
		<div id='el10Child_2b' class='row'>
			<div id='f_thumbnail_check' style='display:inline'></div>
			<input type=text class='saisie-80em' id='f_thumbnail_url' name='f_thumbnail_url' rows='1' wrap='virtual' value=\"!!thumbnail_url!!\" onchange='chklnk_f_thumbnail_url(this);' />
		</div>
	</div>";
global $pmb_notice_img_folder_id;
if($pmb_notice_img_folder_id)
	$ptab[8].= "
		<div id='el10Child_6' title='".htmlentities($msg['notice_img_load'],ENT_QUOTES, $charset)."' movable='yes'>
			<!--    Vignette upload    -->
			<div id='el10Child_6a' class='row'>
				<label for='f_img_load' class='etiquette'>$msg[notice_img_load]</label>!!message_folder!!
			</div>
			<div id='el10Child_6b' class='row'>
				<input type='file' class='saisie-80em' id='f_img_load' name='f_img_load' rows='1' wrap='virtual' value='' />
			</div>
		</div>";
$ptab[8].="!!ptab_8_serial!!";
$ptab_8_serial= "
	<div id='el10Child_3' title='".htmlentities($msg["opac_show_bulletinage"],ENT_QUOTES, $charset)."' movable='yes' !!display_bulletinage!!>
		<div id='el10Child_3a' class='row'>
			<input type='checkbox' value='1' id='opac_visible_bulletinage' name='opac_visible_bulletinage'  !!opac_visible_bulletinage!! />
			<label for='opac_visible_bulletinage' class='etiquette'>".$msg["opac_show_bulletinage"]."</label>
		</div>
		<div id='el10Child_3b' class='row'>
			<input type='checkbox' value='1' id='a2z_opac_show' name='a2z_opac_show'  !!a2z_opac_show!! />
			<label for='a2z_opac_show' class='etiquette'>".$msg["a2z_opac_show"]."</label>
		</div>
	</div>
";
global $opac_serialcirc_active;
if($opac_serialcirc_active) {
	$ptab[8].= "
	<div id='el10Child_8' title='".htmlentities($msg["opac_serialcirc_demande"],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_8a' class='row'>
			<input type='checkbox' value='1' id='opac_serialcirc_demande' name='opac_serialcirc_demande'  !!opac_serialcirc_demande!! />
			<label for='opac_serialcirc_demande' class='etiquette'>".$msg["opac_serialcirc_demande"]."</label>
		</div>
	</div>
	";
}
global $pmb_notices_show_dates;
if($pmb_notices_show_dates) {
	$ptab[8].= "
	<div id='el10Child_9' title='".htmlentities($msg["noti_crea_date"],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_9a' class='row'>
			!!dates_notice!!
		</div>
	</div>
	";
}
$ptab[8].= "
	<div id='el10Child_4' title='".htmlentities($msg['admin_menu_acces'],ENT_QUOTES, $charset)."' movable='yes'>
		<!-- Droits d'acces -->
		<!-- rights_form -->
	</div>
	<div id='el10Child_5' title='".htmlentities($msg["indexation_lang_select"],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_5a' class='row'>
			<label for='f_notice_lang' class='etiquette'>".$msg["indexation_lang_select"]."</label>
		</div>
		<div id='el10Child_5b' class='row'>
			!!indexation_lang!!
		</div>
	</div>
	<div id='el10Child_10' title='".htmlentities($msg['notice_usage_libelle'],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_10a' class='row'>
		    <label for='f_notice_usage' class='etiquette'>".$msg['notice_usage_libelle']."</label>
		</div>
		<div id='el10Child_10b' class='row'>
			!!num_notice_usage!!
	    </div>
	</div>
</div>
";


//    ----------------------------------------------------
//    Collation
//       $ptab[41] : contenu de l'onglet 41 (collation)
//    ----------------------------------------------------

$ptab[41] = "
<!-- onglet 41 -->
<div id='el41Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el41Img' title='$msg[257]' border='0' onClick=\"expandBase('el41', true); return false;\" />
		$msg[258]
	</h3>
</div>
<div id='el41Child' class='child' etirable='yes' title='".htmlentities($msg[258],ENT_QUOTES, $charset)."'>
	<div id='el41Child_0' title='".htmlentities($msg[259],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Importance mat�rielle (nombre de pages, d'�l�ments...)    -->
		<div id='el41Child_0a' class='row'>
			<label for='f_npages' class='etiquette'>$msg[259]</label>
		</div>
		<div id='el41Child_0b' class='row'>
			<input type='text' class='saisie-80em' id='f_npages' name='f_npages' value=\"!!npages!!\" />
		</div>
	</div>
	<div id='el41Child_1' title='".htmlentities($msg[260],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Autres caract�ristiques mat�rielle (ill., ...)    -->
		<div id='el41Child_1a' class='row'>
			<label for='f_ill' class='etiquette'>$msg[260]</label>
		</div>
		<div id='el41Child_1b' class='row'>
			<input type='text' class='saisie-80em' id='f_ill' name='f_ill' value=\"!!ill!!\" />
		</div>
	</div>
	<div id='el41Child_2' title='".htmlentities($msg[261],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Format    -->
		<div id='el41Child_2a' class='row'>
			<label for='f_size' class='etiquette'>$msg[261]</label>
		</div>
		<div id='el41Child_2b' class='row'>
			<input type='text' class='saisie-80em' id='f_size' name='f_size' value=\"!!size!!\" />
		</div>
	</div>
	<div id='el41Child_3' title='".htmlentities($msg[4050],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Prix    -->
		<div id='el41Child_3a' class='row'>
			<label for='f_prix' class='etiquette'>$msg[4050]</label>
		</div>
		<div id='el41Child_3b' class='row'>
			<input type='text' class='saisie-80em' id='f_prix' name='f_prix' value=\"!!prix!!\" />
		</div>
	</div>
	<div id='el41Child_4' title='".htmlentities($msg[262],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Mat�riel d'accompagnement    -->
		<div id='el41Child_4a' class='row'>
			<label for='f_accomp' class='etiquette'>$msg[262]</label>
		</div>
		<div id='el41Child_4b' class='row'>
			<input type='text' class='saisie-80em' id='f_accomp' name='f_accomp' value=\"!!accomp!!\" />
		</div>
	</div>
</div>
";

//	----------------------------------------------------
// 	  $form_notice : Nouveau p�riodique
//	----------------------------------------------------
$serial_top_form = jscript_unload_question();
$serial_top_form.= "
<!-- script de gestion des onglets -->
<script type='text/javascript' src='./javascript/tabform.js'></script>
".($pmb_catalog_verif_js!= "" ? "<script type='text/javascript' src='$base_path/javascript/$pmb_catalog_verif_js'></script>":"")."
<script type='text/javascript'>
<!--
	function test_notice(form)
	{
	";
if($pmb_catalog_verif_js!= ""){
	$serial_top_form.= "
		if('function' == typeof(check_perso_serial_form)){
			var check = check_perso_serial_form();
			if(check == false) return false;
		} ";
}
$serial_top_form.= "
		titre1 = form.f_tit1.value;
		titre1 = titre1.replace(/^\s+|\s+$/g, ''); //trim la valeur
		if(titre1.length == 0)
			{
				alert(\"$msg[277]\");
				return false;
			}
		return check_form();
	}
-->
</script>
<script src='javascript/ajax.js'></script>
<script src='javascript/move.js'></script>
<script type='text/javascript'>
	var msg_move_to_absolute_pos='".addslashes($msg['move_to_absolute_pos'])."';
	var msg_move_to_relative_pos='".addslashes($msg['move_to_relative_pos'])."';
	var msg_move_saved_ok='".addslashes($msg['move_saved_ok'])."';
	var msg_move_saved_error='".addslashes($msg['move_saved_error'])."';
	var msg_move_up_tab='".addslashes($msg['move_up_tab'])."';
	var msg_move_down_tab='".addslashes($msg['move_down_tab'])."';
	var msg_move_position_tab='".addslashes($msg['move_position_tab'])."';
	var msg_move_position_absolute_tab='".addslashes($msg['move_position_absolute_tab'])."';
	var msg_move_position_relative_tab='".addslashes($msg['move_position_relative_tab'])."';
	var msg_move_invisible_tab='".addslashes($msg['move_invisible_tab'])."';
	var msg_move_visible_tab='".addslashes($msg['move_visible_tab'])."';
	var msg_move_inside_tab='".addslashes($msg['move_inside_tab'])."';
	var msg_move_save='".addslashes($msg['move_save'])."';
	var msg_move_first_plan='".addslashes($msg['move_first_plan'])."';
	var msg_move_last_plan='".addslashes($msg['move_last_plan'])."';
	var msg_move_first='".addslashes($msg['move_first'])."';
	var msg_move_last='".addslashes($msg['move_last'])."';
	var msg_move_infront='".addslashes($msg['move_infront'])."';
	var msg_move_behind='".addslashes($msg['move_behind'])."';
	var msg_move_up='".addslashes($msg['move_up'])."';
	var msg_move_down='".addslashes($msg['move_down'])."';
	var msg_move_invisible='".addslashes($msg['move_invisible'])."';
	var msg_move_visible='".addslashes($msg['move_visible'])."';
	var msg_move_saved_onglet_state='".addslashes($msg['move_saved_onglet_state'])."';
	var msg_move_open_tab='".addslashes($msg['move_open_tab'])."';
	var msg_move_close_tab='".addslashes($msg['move_close_tab'])."';
</script>
<script type='text/javascript'>document.title = '!!document_title!!';</script>
<form class='form-$current_module' id='notice' name='notice' method='post' action='./catalog.php?categ=serials&sub=update' enctype='multipart/form-data' >
<div class='row'>
<div class='left'><h3>!!form_title!!</h3></div><div class='right'>";
if ($PMBuserid==1 && $pmb_form_editables==1) $serial_top_form.="<input type='button' class='bouton_small' value='".$msg["catal_edit_format"]."' onClick=\"expandAll(); move_parse_dom(relative)\" id=\"bt_inedit\"/><input type='button' class='bouton_small' value='Relatif' onClick=\"expandAll(); move_parse_dom((!relative))\" style=\"display:none\" id=\"bt_swap_relative\"/>";
if ($pmb_form_editables==1) $serial_top_form.="<input type='button' class='bouton_small' value=\"".$msg["catal_origin_format"]."\" onClick=\"get_default_pos(); expandAll();  ajax_parse_dom(); if (inedit) move_parse_dom(relative); else initIt();\"/>";
$serial_top_form.="</div>
</div>
<div class='form-contenu'>
<div class='row'>
	!!doc_type!! !!location!!
	</div>
<div class='row'>
	<a href=\"javascript:expandAll()\"><img src='./images/expand_all.gif' border='0' id=\"expandall\"></a>
	<a href=\"javascript:collapseAll()\"><img src='./images/collapse_all.gif' border='0' id=\"collapseall\"></a>";
$serial_top_form .= "
	<input type='hidden' name='b_level' value='!!b_level!!' />
	<input type='hidden' name='h_level' value='!!h_level!!' />
	<input type='hidden' name='serial_id' value='!!id!!' />
	<input type='hidden' name='id_form' value='!!id_form!!' />
	</div>
	!!tab0!!
	<hr class='spacer' />
	!!tab1!!
	<hr class='spacer' />
	!!tab2!!
	<hr class='spacer' />
	!!tab30!!
	<hr class='spacer' />
	!!tab3!!
	<hr class='spacer' />
	!!tab4!!
	<hr class='spacer' />
	!!tab5!!
	<hr class='spacer' />
	!!tab6!!
	<hr class='spacer' />
	!!tab7!!
	<hr class='spacer' />
	!!tab13!!
	<hr class='spacer' />
	!!tab14!!
	<hr class='spacer' />
	!!tab8!!
	<hr class='spacer' />
	!!authperso!!
</div>
<div class='row'>
	<input type='button' class='bouton' value='$msg[76]' !!annul!!>&nbsp;
	<input type='button' class='bouton' value='$msg[77]' id='btsubmit' onClick=\"if (test_notice(this.form)) {unload_off();this.form.submit();}\" />
	!!link_duplicate!!
	!!link_audit!!
	</div>
</form>
<script type='text/javascript'>
	get_pos();
	ajax_parse_dom();
	document.forms['notice'].elements['f_tit1'].focus();
</script>
";

$message_search = "
<div class='row'>
	<h2>".$msg[401]."</h2>
</div>
";

$serial_action_bar = "
<script type=\"text/javascript\">
	<!--

	var has_bulletin = !!nb_bulletins!!;
	var has_expl = !!nb_expl!!;
	var has_arti= !!nb_articles!!;
	var has_etat_coll = !!nb_etat_coll!!;
	var has_abo= !!nb_abo!!;

	function confirm_serial_delete()
	{
	phrase1 = \"$msg[serial_SupConfirm]\";
	phrase2 = \"$msg[serial_SupNbBulletin] \";
	phrase3 = \"$msg[serial_SupExemplaire]\";
	phrase4 = \"$msg[serial_SupArti]\";
	phrase5 = \"$msg[serial_SupEtatColl]\";
	phrase6 = \"$msg[serial_SupAbo]\";" .
			"
	if(!has_bulletin && !has_expl && !has_etat_coll && !has_abo) {
		result = confirm(phrase1);
	}else if(has_bulletin || has_etat_coll || has_abo){
		result = true;
		if(result && has_bulletin)
			result = confirm(phrase2 + has_bulletin + \"\\n\" + phrase1);
		if(result && has_expl)
			result = confirm(phrase3 + has_expl + \"\\n\" + phrase1);
		if(result && has_arti)
			result = confirm(phrase4 + has_arti + \"\\n\" + phrase1);
		if(result && has_etat_coll)
			result = confirm(phrase5 + has_etat_coll + \"\\n\" + phrase1);
		if(result && has_abo)
			result = confirm(phrase6 + has_abo + \"\\n\" + phrase1);
		if(result)
			result = confirm(phrase1);
	}
	if(result)
		document.location = './catalog.php?categ=serials&sub=delete&serial_id=!!serial_id!!';
	}
	-->
</script>
<div class='left'>
	<input type='button' class='bouton' onclick=\"document.location='./catalog.php?categ=serials&sub=serial_form&id=!!serial_id!!'\" value='$msg[62]' />&nbsp;";
if ($z3950_accessible){
	$serial_action_bar .= "<input type='button' class='bouton' value='$msg[notice_z3950_update_bouton]' onclick='document.location=\"./catalog.php?categ=z3950&id_notice=!!serial_id!!&issn=!!issn!!\"' />&nbsp;";
}
$serial_action_bar.="
	<input type='button' class='bouton' value='$msg[4002]' onClick=\"document.location='./catalog.php?categ=serials&sub=bulletinage&action=bul_form&serial_id=!!serial_id!!&bul_id=0'\" />&nbsp;
	<input type='button' class='bouton' value=' $msg[explnum_ajouter_doc] ' onClick=\"document.location='./catalog.php?categ=serials&sub=explnum_form&serial_id=!!serial_id!!&explnum_id=0'\">
	<input type='button' class='bouton' value='$msg[158]'  onClick=\"document.location='./catalog.php?categ=serials&sub=serial_replace&serial_id=!!serial_id!!'\" />&nbsp;
	<input type='button' class='bouton' value='$msg[serial_duplicate_bouton]'  onClick=\"document.location='./catalog.php?categ=serials&sub=serial_duplicate&serial_id=!!serial_id!!'\" />&nbsp;";
if ($acquisition_active) {
	$serial_action_bar.="<input type='button' class='bouton' value='".$msg["acquisition_sug_do"]."' onclick=\"document.location='./catalog.php?categ=sug&action=modif&id_bibli=0&id_notice=!!serial_id!!'\" />&nbsp;";
}
$serial_action_bar.="</div>
<div class='right'>
	!!delete_serial_button!!
	</div>
<div class='row'></div>
";

$scan_request_record_button="";
if((SESSrights & CIRCULATION_AUTH) && $pmb_scan_request_activate){
	$scan_request_record_button .= "<input type='button' class='bouton' value='".$msg["scan_request_record_button"]."' onclick='document.location=\"./circ.php?categ=scan_request&sub=request&action=edit&from_bulletin=!!bul_id!!\"' />";
}
//<input type='button' class='bouton' onclick=\"confirm_serial_delete();\" value='$msg[63]' />
$bul_action_bar = "
<script type=\"text/javascript\">
	<!--

	var has_expl = !!nb_expl!!;

	function confirm_bul_delete()
	{
		phrase1 = \"$msg[serial_SupBulletin]\";
		phrase2 = \"$msg[serial_SupExemplaire]\";

		if(!has_expl) {
			result = confirm(phrase1);
		} else {
			result = confirm(phrase2 + has_expl + \"\\n\" + phrase1);
			if(result)
				result = confirm(phrase1);
		}

		if(result)
			document.location = './catalog.php?categ=serials&sub=bulletinage&action=delete&bul_id=!!bul_id!!';
		else
			document.forms['addex'].elements['noex'].focus();
	}
	-->
</script>
<div class='left'>
	<input type='button' class='bouton' onclick=\"document.location='./catalog.php?categ=serials&sub=bulletinage&action=bul_form&bul_id=!!bul_id!!'\" value='$msg[62]' />&nbsp;
	<input type='button' class='bouton' onClick=\"document.location='./catalog.php?categ=serials&sub=bulletinage&action=bul_duplicate&bul_id=!!bul_id!!';\" value='$msg[empr_duplicate_button]' />
	<input type='button' class='bouton' value='$msg[158]'  onClick=\"document.location='./catalog.php?categ=serials&sub=bulletin_replace&serial_id=!!serial_id!!&bul_id=!!bul_id!!'\" />&nbsp;
	".$scan_request_record_button."
</div>
<div class='right'>
	!!bulletin_delete_button!!
</div>
<div class='row'></div>
";

$serial_bul_form = jscript_unload_question();
$serial_bul_form.= "
".($pmb_catalog_verif_js!= "" ? "<script type='text/javascript' src='./javascript/$pmb_catalog_verif_js'></script>":"")."
<script type='text/javascript'>
<!--
	function test_form(form)
	{";
if($pmb_catalog_verif_js!= ""){
	$serial_bul_form.= "
		var check = check_perso_bull_form()
		if(check == false) return false;";
}
$serial_bul_form.= "
		test1 = form.bul_no.value+form.bul_date.value+form.bul_titre.value;// concat�nation des valeurs � tester
		test = test1.replace(/^\s+|\s+$/g, ''); //trim de la valeur
		if(test.length == 0)
			{
				alert(\"$msg[serial_BulletinDate]\");
				form.bul_no.focus();
				return false;
			}";

$serial_bul_form.= "
		return true;
	}
-->
</script>
<script type='text/javascript' src='javascript/tabform.js'></script>
<script type='text/javascript' src='javascript/ajax.js'></script>
";
if ($pmb_form_editables) {
	$serial_bul_form.="<script type='text/javascript' src='javascript/move.js'></script>
		<script type='text/javascript'>
			var msg_move_to_absolute_pos='".addslashes($msg['move_to_absolute_pos'])."';
			var msg_move_to_relative_pos='".addslashes($msg['move_to_relative_pos'])."';
			var msg_move_saved_ok='".addslashes($msg['move_saved_ok'])."';
			var msg_move_saved_error='".addslashes($msg['move_saved_error'])."';
			var msg_move_up_tab='".addslashes($msg['move_up_tab'])."';
			var msg_move_down_tab='".addslashes($msg['move_down_tab'])."';
			var msg_move_position_tab='".addslashes($msg['move_position_tab'])."';
			var msg_move_position_absolute_tab='".addslashes($msg['move_position_absolute_tab'])."';
			var msg_move_position_relative_tab='".addslashes($msg['move_position_relative_tab'])."';
			var msg_move_invisible_tab='".addslashes($msg['move_invisible_tab'])."';
			var msg_move_visible_tab='".addslashes($msg['move_visible_tab'])."';
			var msg_move_inside_tab='".addslashes($msg['move_inside_tab'])."';
			var msg_move_save='".addslashes($msg['move_save'])."';
			var msg_move_first_plan='".addslashes($msg['move_first_plan'])."';
			var msg_move_last_plan='".addslashes($msg['move_last_plan'])."';
			var msg_move_first='".addslashes($msg['move_first'])."';
			var msg_move_last='".addslashes($msg['move_last'])."';
			var msg_move_infront='".addslashes($msg['move_infront'])."';
			var msg_move_behind='".addslashes($msg['move_behind'])."';
			var msg_move_up='".addslashes($msg['move_up'])."';
			var msg_move_down='".addslashes($msg['move_down'])."';
			var msg_move_invisible='".addslashes($msg['move_invisible'])."';
			var msg_move_visible='".addslashes($msg['move_visible'])."';
			var msg_move_saved_onglet_state='".addslashes($msg['move_saved_onglet_state'])."';
			var msg_move_open_tab='".addslashes($msg['move_open_tab'])."';
			var msg_move_close_tab='".addslashes($msg['move_close_tab'])."';
		</script>";
}
$serial_bul_form .= "
<!-- serial_bul_form -->
<script type='text/javascript'>document.title = '!!document_title!!';</script>
<form class='form-$current_module' id='notice' name='notice' method='post' action='./catalog.php?categ=serials&sub=bulletinage&action=update' onSubmit='return false;' enctype='multipart/form-data' >
<h3><div class='left'>!!form_title!!</div><div class='right'>";
if ($PMBuserid==1 && $pmb_form_editables==1) $serial_bul_form.="<input type='button' class='bouton_small' value='Editer format' onClick=\"expandAll(); move_parse_dom(relative)\" id=\"bt_inedit\"/><input type='button' class='bouton_small' value='Relatif' onClick=\"expandAll(); move_parse_dom((!relative))\" style=\"display:none\" id=\"bt_swap_relative\"/>";
if ($pmb_form_editables==1) $serial_bul_form.="<input type='button' class='bouton_small' value=\"Format d'origine\" onClick=\"get_default_pos(); expandAll();  ajax_parse_dom(); if (inedit) move_parse_dom(relative); else initIt();\"/>";
$serial_bul_form.="</div></h3>
<div class='row'></div>
<div class='form-contenu'>
<div class='row'>
	!!doc_type!! !!location!!
	</div>
<div class='row'>
		<a href=\"javascript:expandAll()\"><img src='./images/expand_all.gif' border='0' id=\"expandall\"></a>
		<a href=\"javascript:collapseAll()\"><img src='./images/collapse_all.gif' border='0' id=\"collapseall\"></a>
		<input type=\"hidden\" name=\"b_level\" value=\"!!b_level!!\">
		<input type=\"hidden\" name=\"h_level\" value=\"!!h_level!!\">
</div>

<!-- onglet bul -->
<div id='elbulParent' class='parent'>
	<div class='row'>
		<h3>
			<img src='./images/minus.gif' class='img_plus' align='top' name='imEx' id='elbulImg' title=\"".$msg["perio_bull_form_info_bulletin"]."\" border='0' onClick=\"expandBase('elbul', true); return false;\"/>
			".$msg["perio_bull_form_info_bulletin"]."
		</h3>
	</div>
</div>
<div id='elbulChild' class='child' title='".htmlentities($msg["perio_bull_form_info_bulletin"],ENT_QUOTES, $charset)."' >
<div class='colonne2'>
	<div class='row'>
		<label class='etiquette' for='bul_no'>$msg[4025]</label>
	</div>
	<div class='row'>
		<input type='text' id='bul_no' name='bul_no' value='!!bul_no!!' class='saisie-20em' />
		<input type='hidden' name='bul_id' value='!!bul_id!!' />
		<input type='hidden' name='serial_id' value='!!serial_id!!' />
	</div>
</div>
<div class='colonne_suite'>
	<div class='row'>
		<label class='etiquette' for='bul_cb'>$msg[bulletin_code_barre]</label>
		</div>
	<div class='row'>
		<input class='saisie-20emr' id='bul_cb' name='bul_cb' readonly value=\"!!bul_cb!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./catalog/setcb.php?formulaire_appelant=notice&objet_appelant=bul_cb&bulletin=1&notice_id=!!bul_id!!', 'getcb', 220, 100, -2, -2, 'toolbar=no, resizable=yes')\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.bul_cb.value=''; \" />
		</div>
	</div>
<div class='colonne3'>
	<div class='row'>
		<label class='etiquette' >$msg[4026]</label>
	</div>
	<div class='row'>
		!!date_date!!
	</div>
</div>
<div class='colonne_suite'>
	<div class='row'>
		<label class='etiquette' >$msg[bulletin_mention_periode]</label>
	</div>
	<div class='row'>
		<input type='text' id='bul_date' name='bul_date' value='!!bul_date!!' class='saisie-50em' />
	</div>
</div>
<div class='row'>
	<div class='row'>
		<label class='etiquette' >$msg[bulletin_mention_titre]</label>
	</div>
	<div class='row'>
		<input type='text' id='bul_titre' name='bul_titre' value='!!bul_titre!!' class='saisie-50em' />&nbsp;!!create_notice_bul!!
	</div>
</div>
</div>
<!-- Formulaire de notice de bulletin -->
!!tab0!!
<hr class='spacer' />
!!tab1!!
<!--<hr class='spacer' />
!!tab2!!-->
<hr class='spacer' />
!!tab3!!
<hr class='spacer' />
!!tab4!!
<hr class='spacer' />
!!tab41!!
<hr class='spacer' />
!!tab5!!
<hr class='spacer' />
!!tab6!!
<hr class='spacer' />
!!tab7!!
<hr class='spacer' />
!!tab13!!
<hr class='spacer' />
!!tab14!!
<hr class='spacer' />
!!tab8!!
<hr class='spacer' />
!!tab999!!
<hr class='spacer' />
!!authperso!!
</div>
<div class='row'>
	<input type=\"button\" class=\"bouton\" value=\"$msg[76]\" onClick=\"unload_off();history.go(-1);\" />&nbsp;<input type=\"button\" class=\"bouton\" value=\"$msg[77]\" onClick=\"if (test_form(this.form)) {unload_off();this.form.submit();}\" />
	!!link_audit!!
	!!link_duplicate!!
	</div>
</form>
<script type='text/javascript'>".($pmb_form_editables?"get_pos(); ":"")."
	ajax_parse_dom();
	if (document.forms['notice']) {
		if (document.forms['notice'].elements['f_tit1']) document.forms['notice'].elements['f_tit1'].focus();
			else document.forms['notice'].elements['bul_no'].focus();
	} else document.forms['serial_bul_form'].elements['bul_no'].focus();

</script>

";

/* � partir d'ici, template du forme de catalogage de d�pouillement */
//	----------------------------------------------------
// 	  $pdeptab[0] : contenu de l'onglet 0 (zone de titre)

$pdeptab[0] = "
<!-- onglet 0 -->
<div id='el0Parent' class='parent'>
	<h3>
		<img src='./images/minus.gif' class='img_plus' align='top' name='imEx' id='el0Img' title='$msg[236]' border='0' onClick=\"expandBase('el0', true); return false;\" />
		$msg[712]
	</h3>
</div>
<div id='el0Child' class='child' etirable='yes' title='".htmlentities($msg[236],ENT_QUOTES, $charset)."' >
	<div id='el0Child_0' title='".htmlentities($msg[237],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit1'>$msg[237]</label>
		</div>
		<div class='row'>
			<input id='f_tit1' type='text' class='saisie-80em' name='f_tit1' value=\"!!tit1!!\" />
		</div>
	</div>
	<div id='el0Child_1' title='".htmlentities($msg[239],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit3'>$msg[239]</label>
		</div>
		<div class='row'>
			<input class='saisie-80em' type='text' id='f_tit3' name='f_tit3' value=\"!!tit3!!\" />
		</div>
	</div>
	<div id='el0Child_2' title='".htmlentities($msg[240],ENT_QUOTES, $charset)."' movable='yes'>
		<div class='row'>
			<label class='etiquette' for='f_tit4'>$msg[240]</label>
		</div>
		<div class='row'>
			<input class='saisie-80em' id='f_tit4' type='text' name='f_tit4' value=\"!!tit4!!\"  />
		</div>
	</div>
</div>
";

//	----------------------------------------------------
// 	  $pdeptab[1] : contenu de l'onglet 1 (mention de responsabilit�)
//	----------------------------------------------------
$aut_fonctions= marc_list_collection::get_instance('function');
if($pmb_authors_qualification){
	$authors_qualification_tpl="
        <!--    Vedettes    -->
        <div style='float:left;'>
            <label for='f_aut0' class='etiquette'>".$msg['notice_vedette_composee_author']."</label>
			<div class='row'>
				<img class='img_plus' hspace='3' border='0' onclick=\"expand_vedette(this,'vedette0'); return false;\" title='d�tail' name='imEx' src='./images/plus.gif'>

				<input type='text' class='saisie-30emr'  readonly='readonly'  name='notice_role_composed_0_vedette_composee_apercu_autre' id='notice_role_composed_0_vedette_composee_apercu_autre'  data-form-name='vedette_composee' value=\"!!vedette_apercu!!\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"del_vedette('role',!!iaut!!);\" />
			</div>
		</div>
		<div class='row' id='vedette0' style='margin-bottom:6px;display:none'>
			!!vedette_author!!
		</div>
		<script type='text/javascript'>
			vedette_composee_update_all('notice_role_composed_0_vedette_composee_subdivisions');
		</script>
	";
}else{
	$authors_qualification_tpl="";
}
$pdeptab[1] = "
<script>
	function fonction_selecteur_auteur() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,6)+'_id'+name.substr(6);
		openPopUp('./select.php?what=auteur&caller=notice&param1='+name_id+'&param2='+name+'&dyn=1&deb_rech='+".pmb_escape()."(document.getElementById(name).value), 'select_author2', 400, 400, -2, -2, '$select1_prop');
	}
	function fonction_selecteur_auteur_change(field) {
		// id champ text = 'f_aut'+n+suffixe
		// id champ hidden = 'f_aut'+n+'_id'+suffixe;
		// select.php?what=auteur&caller=notice&param1=f_aut0_id&param2=f_aut0&deb_rech='+t
		name=field.getAttribute('id');
		name_id = name.substr(0,6)+'_id'+name.substr(6);
		openPopUp('./select.php?what=auteur&caller=notice&param1='+name_id+'&param2='+name+'&dyn=1&deb_rech='+".pmb_escape()."(document.getElementById(name).value), 'select_author2', 400, 400, -2, -2, '$select1_prop');
	}
	function fonction_raz_auteur() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,6)+'_id'+name.substr(6);
		document.getElementById(name_id).value=0;
		document.getElementById(name).value='';
	}
	function fonction_selecteur_fonction() {
		name=this.getAttribute('id').substring(4);
		name_code = name.substr(0,4)+'_code'+name.substr(4);
		openPopUp('./select.php?what=function&caller=notice&param1='+name_code+'&param2='+name+'&dyn=1', 'select_fonction2', 400, 400, -2, -2, '$select1_prop');
	}
	function fonction_raz_fonction() {
		name=this.getAttribute('id').substring(4);
		name_code = name.substr(0,4)+'_code'+name.substr(4);
		document.getElementById(name_code).value=0;
		document.getElementById(name).value='';
	}
	function add_aut(n) {
		template = document.getElementById('addaut'+n);
		aut=document.createElement('div');
		aut.className='row';

		// auteur
		colonne=document.createElement('div');
        //colonne.className='colonne3';
        colonne.style.cssFloat = 'left';
        colonne.style.marginRight = '10px';
		row=document.createElement('div');
		row.className='row';
		suffixe = eval('document.notice.max_aut'+n+'.value')
		nom_id = 'f_aut'+n+suffixe
		f_aut0 = document.createElement('input');
		f_aut0.setAttribute('name',nom_id);
		f_aut0.setAttribute('id',nom_id);
		f_aut0.setAttribute('type','text');
		f_aut0.className='saisie-30emr';
		f_aut0.setAttribute('value','');
		f_aut0.setAttribute('completion','authors');
		f_aut0.setAttribute('autfield','f_aut'+n+'_id'+suffixe);

		sel_f_aut0 = document.createElement('input');
		sel_f_aut0.setAttribute('id','sel_f_aut'+n+suffixe);
		sel_f_aut0.setAttribute('type','button');
		sel_f_aut0.className='bouton';
		sel_f_aut0.setAttribute('readonly','');
		sel_f_aut0.setAttribute('value','$msg[parcourir]');
		sel_f_aut0.onclick=fonction_selecteur_auteur;

		del_f_aut0 = document.createElement('input');
		del_f_aut0.setAttribute('id','del_f_aut'+n+suffixe);
		del_f_aut0.onclick=fonction_raz_auteur;
		del_f_aut0.setAttribute('type','button');
		del_f_aut0.className='bouton';
		del_f_aut0.setAttribute('readonly','');
		del_f_aut0.setAttribute('value','$msg[raz]');

		f_aut0_id = document.createElement('input');
		f_aut0_id.name='f_aut'+n+'_id'+suffixe;
		f_aut0_id.setAttribute('type','hidden');
		f_aut0_id.setAttribute('id','f_aut'+n+'_id'+suffixe);
		f_aut0_id.setAttribute('value','');

		//f_aut0_content.appendChild(f_aut0);
		row.appendChild(f_aut0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(sel_f_aut0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(del_f_aut0);
		row.appendChild(f_aut0_id);
		colonne.appendChild(row);
		aut.appendChild(colonne);

		// fonction
		colonne=document.createElement('div');
        //colonne.className='colonne3';
        colonne.style.cssFloat = 'left';
        colonne.style.marginRight = '10px';
		row=document.createElement('div');
		row.className='row';
		suffixe = eval('document.notice.max_aut'+n+'.value');
		nom_id = 'f_f'+n+suffixe;
		f_f0 = document.createElement('input');
		f_f0.setAttribute('name',nom_id);
		f_f0.setAttribute('id',nom_id);
		f_f0.setAttribute('type','text');
		f_f0.className='saisie-15emr';
		f_f0.setAttribute('value','".($value_deflt_fonction ? $aut_fonctions->table[$value_deflt_fonction] : '')."');
		f_f0.setAttribute('completion','fonction');
		f_f0.setAttribute('autfield','f_f'+n+'_code'+suffixe);

		sel_f_f0 = document.createElement('input');
		sel_f_f0.setAttribute('id','sel_f_f'+n+suffixe);
		sel_f_f0.setAttribute('type','button');
		sel_f_f0.className='bouton';
		sel_f_f0.setAttribute('readonly','');
		sel_f_f0.setAttribute('value','$msg[parcourir]');
		sel_f_f0.onclick=fonction_selecteur_fonction;

		del_f_f0 = document.createElement('input');
		del_f_f0.setAttribute('id','del_f_f'+n+suffixe);
		del_f_f0.onclick=fonction_raz_fonction;
		del_f_f0.setAttribute('type','button');
		del_f_f0.className='bouton';
		del_f_f0.setAttribute('readonly','readonly');
		del_f_f0.setAttribute('value','$msg[raz]');

		f_f0_code = document.createElement('input');
		f_f0_code.name='f_f'+n+'_code'+suffixe;
		f_f0_code.setAttribute('type','hidden');
		f_f0_code.setAttribute('id','f_f'+n+'_code'+suffixe);
		f_f0_code.setAttribute('value','$value_deflt_fonction');

		var duplicate = document.createElement('input');
		duplicate.setAttribute('onclick','duplicate('+n+','+suffixe+')');
		duplicate.setAttribute('type','button');
		duplicate.className='bouton';
		duplicate.setAttribute('readonly','readonly');
		duplicate.setAttribute('value','".$msg['duplicate']."');

		row.appendChild(f_f0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(sel_f_f0);
		space=document.createTextNode(' ');
		row.appendChild(space);
		row.appendChild(del_f_f0);
		row.appendChild(f_f0_code);
		if(!('".$pmb_authors_qualification."'*1)){
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(duplicate);
		}
		colonne.appendChild(row);

	    aut.appendChild(colonne);

		if('".$pmb_authors_qualification."'*1){
	        var role_field='role';
	        if(n==1) role_field='role_autre';
	        if(n==2) role_field='role_secondaire';

			var req = new http_request();
			if(req.request('./ajax.php?module=catalog&categ=get_notice_form_vedette&role_field='+role_field+'&index='+suffixe,1)){
				// Il y a une erreur
				alert ( req.get_text() );
			}else {
			 	vedette_form=req.get_text();
			 	var row_vedette=document.createElement('div');
				row_vedette.className='row';
				row_vedette.innerHTML=vedette_form;
			}
			row_vedette.setAttribute('id','vedette'+suffixe);
			row_vedette.style.display='none';

			colonne=document.createElement('div');
			//colonne.className='colonne3';
	        colonne.style.cssFloat = 'left';
			row=document.createElement('div');
			row.className='row';

			var img_plus = document.createElement('img');
			img_plus.name='img_plus'+suffixe;
			img_plus.setAttribute('id','img_plus'+suffixe);
			img_plus.className='img_plus';
			img_plus.setAttribute('hspace','3');
			img_plus.setAttribute('border','0');
			img_plus.setAttribute('src','./images/plus.gif');
			img_plus.setAttribute('onclick','expand_vedette(this, \"vedette'+suffixe+'\")');

			var nom_id = 'notice_'+role_field+'_composed_'+suffixe+'_vedette_composee_apercu_autre';
			apercu = document.createElement('input');
			apercu.setAttribute('name',nom_id);
			apercu.setAttribute('id',nom_id);
			apercu.setAttribute('type','text');
			apercu.className='saisie-30emr';
			apercu.setAttribute('readonly','readonly');

			var del_vedette = document.createElement('input');
			del_vedette.setAttribute('onclick','del_vedette(\"'+role_field+'\",'+suffixe+')');
			del_vedette.setAttribute('type','button');
			del_vedette.className='bouton';
			del_vedette.setAttribute('readonly','readonly');
			del_vedette.setAttribute('value','$msg[raz]');

			row.appendChild(img_plus);
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(apercu);
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(del_vedette);
			space=document.createTextNode(' ');
			row.appendChild(space);
			row.appendChild(duplicate);
			colonne.appendChild(row);
			aut.appendChild(colonne);

			template.appendChild(aut);
			template.appendChild(row_vedette);
			eval(document.getElementById('vedette_script_'+role_field+'_composed_'+suffixe).innerHTML);
		}else{
			template.appendChild(aut);
		}
	    eval('document.notice.max_aut'+n+'.value=suffixe*1+1*1');
        ajax_pack_element(f_aut0);
		ajax_pack_element(f_f0);
		init_drag();
		ajax_pack_element(f_f0);
	}

	function duplicate(n,suffixe){
		add_aut(n);
        new_suffixe = eval('document.notice.max_aut'+n+'.value')-1;
        document.getElementById('f_aut'+n+new_suffixe).value = document.getElementById('f_aut'+n+suffixe).value;
        document.getElementById('f_aut'+n+'_id'+new_suffixe).value = document.getElementById('f_aut'+n+'_id'+suffixe).value;

        document.getElementById('f_f'+n+new_suffixe).value = '';
        document.getElementById('f_f'+n+'_code'+new_suffixe).value = '';
	}

	function fonction_selecteur_categ() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,7)+'_id'+name.substr(7);
		openPopUp('./select.php?what=categorie&caller=notice&p1='+name_id+'&p2='+name+'&dyn=1', 'select_categ', 700, 500, -2, -2, '$select_categ_prop');
	}
	function fonction_raz_categ() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,7)+'_id'+name.substr(7);
		document.getElementById(name_id).value=0;
		document.getElementById(name).value='';
	}
	function add_categ() {
		template = document.getElementById('el6Child_0');
		categ=document.createElement('div');
		categ.className='row';

		suffixe = eval('document.notice.max_categ.value');

		categ.setAttribute('id','drag_'+suffixe);
		categ.setAttribute('order',suffixe);
		categ.setAttribute('highlight','categ_highlight');
		categ.setAttribute('downlight','categ_downlight');
		categ.setAttribute('dragicon','./images/icone_drag_notice.png');
		categ.setAttribute('handler','handle_'+suffixe);
		categ.setAttribute('recepttype','categ');
		categ.setAttribute('recept','yes');
		categ.setAttribute('dragtype','categ');
		categ.setAttribute('draggable','yes');

		nom_id = 'f_categ'+suffixe
		f_categ = document.createElement('input');
		f_categ.setAttribute('name',nom_id);
		f_categ.setAttribute('id',nom_id);
		f_categ.setAttribute('type','text');
		f_categ.className='saisie-80emr';
		f_categ.setAttribute('value','');
		f_categ.setAttribute('completion','categories_mul');
		f_categ.setAttribute('autfield','f_categ_id'+suffixe);

		del_f_categ = document.createElement('input');
		del_f_categ.setAttribute('id','del_f_categ'+suffixe);
		del_f_categ.onclick=fonction_raz_categ;
		del_f_categ.setAttribute('type','button');
		del_f_categ.className='bouton';
		del_f_categ.setAttribute('readonly','');
		del_f_categ.setAttribute('value','$msg[raz]');

		f_categ_id = document.createElement('input');
		f_categ_id.name='f_categ_id'+suffixe;
		f_categ_id.setAttribute('type','hidden');
		f_categ_id.setAttribute('id','f_categ_id'+suffixe);
		f_categ_id.setAttribute('value','');

		var f_categ_span_handle = document.createElement('span');
		f_categ_span_handle.setAttribute('id','handle_'+suffixe);
		f_categ_span_handle.style.float='left';
		f_categ_span_handle.style.paddingRight='7px';

		var f_categ_drag_img = document.createElement('img');
		f_categ_drag_img.setAttribute('src','./images/sort.png');
		f_categ_drag_img.style.width='12px';
		f_categ_drag_img.style.verticalAlign='middle';

		f_categ_span_handle.appendChild(f_categ_drag_img);
		f_categ_span_handle.appendChild(f_categ_drag_img);

		categ.appendChild(f_categ_span_handle);

		categ.appendChild(f_categ);
		space=document.createTextNode(' ');
		categ.appendChild(space);
		categ.appendChild(del_f_categ);
		categ.appendChild(f_categ_id);

		template.appendChild(categ);

		tab_categ_order = document.getElementById('tab_categ_order');
		if (tab_categ_order.value != '') tab_categ_order.value += ','+suffixe;

		document.notice.max_categ.value=suffixe*1+1*1 ;
		ajax_pack_element(f_categ);
		init_drag();
	}
	function fonction_selecteur_lang() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,6)+'_code'+name.substr(6);
		openPopUp('./select.php?what=lang&caller=notice&p1='+name_id+'&p2='+name, 'select_lang', 400, 400, -2, -2, '$select2_prop');
	}
	function add_lang() {
		templates.add_completion_selection_field('f_lang', 'f_lang_code', 'langue', fonction_selecteur_lang);
	}

	function fonction_selecteur_langorg() {
		name=this.getAttribute('id').substring(4);
		name_id = name.substr(0,9)+'_code'+name.substr(9);
		openPopUp('./select.php?what=lang&caller=notice&p1='+name_id+'&p2='+name, 'select_lang', 400, 400, -2, -2, '$select2_prop');
	}
	function add_langorg() {
		templates.add_completion_selection_field('f_langorg', 'f_langorg_code', 'langue', fonction_selecteur_langorg);
	}

	function expand_vedette(el,what) {
		var obj=document.getElementById(what);
		if(obj.style.display=='none'){
			obj.style.display='block';
	    	el.src = './images/minus.gif';
			init_drag();
		}else{
			obj.style.display='none';
	    	el.src =  './images/plus.gif';
		}
	}

	function del_vedette(role,index) {
		vedette_composee_delete_all('notice_'+role+'_composed_'+index+'_vedette_composee_subdivisions');
		init_drag();
	}

</script>
<div id='el1Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el1Img' onClick=\"expandBase('el1', true); return false;\" title='$msg[243]' border='0' />
		$msg[243]
	</h3>
</div>
<div id='el1Child' class='child' etirable='yes' title='".htmlentities($msg[243],ENT_QUOTES, $charset)."'>
	<div id='el1Child_0' title='".htmlentities($msg[244],ENT_QUOTES, $charset)."' movable='yes'>
		<!--	Auteur principal	-->
		<div class='row'>
			<div style='float:left;margin-right:10px;'>
				<label for='f_aut0' class='etiquette'>$msg[244]</label>
				<div class='row'>
					<input type='text' completion='authors' autfield='f_aut0_id' id='auteur0' class='saisie-30emr' name='f_aut0' value=\"!!aut0!!\" />
	
					<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=auteur&caller=notice&param1=f_aut0_id&param2=f_aut0&deb_rech='+".pmb_escape()."(this.form.f_aut0.value), 'select_author0', 400, 400, -2, -2, '$select1_prop')\" />
					<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_aut0.value=''; this.form.f_aut0_id.value='0'; \" />
					<input type='hidden' name='f_aut0_id' id='f_aut0_id' value=\"!!aut0_id!!\" />
				</div>
			</div>
			<!--	Fonction	-->
			<div style='float:left;margin-right:10px;'>
				<label for='f_f0' class='etiquette'>$msg[245]</label>
				<div class='row'>
					<input type='text' class='saisie-15emr' id='f_f0' name='f_f0' value=\"!!f0!!\" completion=\"fonction\" autfield=\"f_f0_code\" />
					<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=function&caller=notice&p1=f_f0_code&p2=f_f0', 'select_func0', 400, 400, -2, -2, '$select2_prop')\" />
					<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_f0.value=''; this.form.f_f0_code.value='0'; \" />
					<input type='hidden' name='f_f0_code' id='f_f0_code' value=\"!!f0_code!!\" />
				</div>
			</div>
		</div>
		$authors_qualification_tpl
		<div class='row'></div>
	</div>
	<div id='el1Child_2' title='".htmlentities($msg[246],ENT_QUOTES, $charset)."' movable='yes'>
		<!--	autres auteurs	-->
		<div class='row'>
			<div class='row'>
				<label for='f_aut1' class='etiquette'>$msg[246]</label>
				<input type='hidden' name='max_aut1' value=\"!!max_aut1!!\" />
			</div>
			!!autres_auteurs!!
			<div id='addaut1'/>
			</div>
		</div>
		<div class='row'></div>
	</div>
	<div id='el1Child_3' title='".htmlentities($msg[247],ENT_QUOTES, $charset)."' movable='yes'>
		<!--	Auteurs secondaires 	-->
		<div class='row'>
			<div class='row'>
				<label for='f_aut2' class='etiquette'>$msg[247]</label>
				<input type='hidden' name='max_aut2' value=\"!!max_aut2!!\" />
			</div>
			!!auteurs_secondaires!!
			<div id='addaut2'/>
			</div>
		</div>
		<div class='row'></div>
	</div>
</div>
";

//	----------------------------------------------------
//	Autres auteurs
//	----------------------------------------------------

if($pmb_authors_qualification){
	$authors_add_aut_button_tpl="";
	$authors_qualification_tpl="
         <!--    Vedettes    -->
        <div style='float:left'>
			<div class='row'>
				<img class='img_plus' hspace='3' border='0' onclick=\"expand_vedette(this,'vedette!!iaut!!_autre'); return false;\" title='d�tail' name='imEx' src='./images/plus.gif'>
				<input type='text' class='saisie-30emr'  readonly='readonly'  name='notice_role_autre_composed_!!iaut!!_vedette_composee_apercu_autre' id='notice_role_autre_composed_!!iaut!!_vedette_composee_apercu_autre'  data-form-name='vedette_composee_autre' value=\"!!vedette_apercu!!\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"del_vedette('role_autre',!!iaut!!);\" />
				<input class='bouton' type='button' onclick='duplicate(1,!!iaut!!);' value='".$msg['duplicate']."'>
				<input type='button' class='bouton' style='!!bouton_add_display!!' value='+' onClick=\"add_aut(1);\"/>
            </div>
		</div>
		<div class='row' id='vedette!!iaut!!_autre' style='margin-bottom:6px;display:none'>
			!!vedette_author!!
		</div>
		<script type='text/javascript'>
			vedette_composee_update_all('notice_role_autre_composed_!!iaut!!_vedette_composee_subdivisions');
		</script>
	";
}else{
	$authors_add_aut_button_tpl="
			<input class='bouton' type='button' onclick='duplicate(1,!!iaut!!);' value='".$msg['duplicate']."'>
			<input type='button' style='!!bouton_add_display!!' class='bouton' value='+' onClick=\"add_aut(1);\"/>";
	$authors_qualification_tpl="";
}
$pdeptab[11] = "
	<div class='row'>
		<div id='el1Child_2b_first' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-30emr' completion='authors' autfield='f_aut1_id!!iaut!!' id='f_aut1!!iaut!!' name='f_aut1!!iaut!!' value=\"!!aut1!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=auteur&caller=notice&param1=f_aut1_id!!iaut!!&param2=f_aut1!!iaut!!&deb_rech='+".pmb_escape()."(this.form.f_aut1!!iaut!!.value), 'select_author2', 400, 400, -2, -2, '$select1_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_aut1!!iaut!!.value=''; this.form.f_aut1_id!!iaut!!.value='0'; \" />
				<input type='hidden' name='f_aut1_id!!iaut!!' id='f_aut1_id!!iaut!!' value=\"!!aut1_id!!\" />
				</div>
			</div>
		<!--	Fonction	-->
		<div id='el1Child_2b_others' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-15emr' id='f_f1!!iaut!!' name='f_f1!!iaut!!' completion='fonction' autfield='f_f1_code!!iaut!!' value=\"!!f1!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=function&caller=notice&p1=f_f1_code!!iaut!!&p2=f_f1!!iaut!!', 'select_func2', 400, 400, -2, -2, '$select2_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_f1!!iaut!!.value=''; this.form.f_f1_code!!iaut!!.value='0'; \" />
				$authors_add_aut_button_tpl
				<input type='hidden' name='f_f1_code!!iaut!!' id='f_f1_code!!iaut!!' value=\"!!f1_code!!\" />
			</div>
		</div>
		$authors_qualification_tpl
	</div>
	" ;

//	----------------------------------------------------
//	Autres secondaires
//	----------------------------------------------------
if($pmb_authors_qualification){
	$authors_add_aut_button_tpl="";
	$authors_qualification_tpl="
        <!--    Vedettes    -->
        <div style='float:left;'>
			<div class='row'>
				<img class='img_plus' hspace='3' border='0' onclick=\"expand_vedette(this,'vedette!!iaut!!_secondaire'); return false;\" title='d�tail' name='imEx' src='./images/plus.gif'>
				<input type='text' class='saisie-30emr'  readonly='readonly'  name='notice_role_secondaire_composed_!!iaut!!_vedette_composee_apercu_autre' id='notice_role_secondaire_composed_!!iaut!!_vedette_composee_apercu_autre'  data-form-name='vedette_composee' value=\"!!vedette_apercu!!\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"del_vedette('role_secondaire',!!iaut!!);\" />
				<input class='bouton' type='button' onclick='duplicate(2,!!iaut!!);' value='".$msg['duplicate']."'>
				<input type='button' class='bouton' style='!!bouton_add_display!!' value='+' onClick=\"add_aut(2);\"/>
            </div>
		</div>
		<div class='row' id='vedette!!iaut!!_secondaire' style='margin-bottom:6px;display:none'>
			!!vedette_author!!
		</div>
		<script type='text/javascript'>
			vedette_composee_update_all('notice_role_secondaire_composed_!!iaut!!_vedette_composee_subdivisions');
		</script>
	";
}else{
	$authors_add_aut_button_tpl="
		<input class='bouton' type='button' onclick='duplicate(2,!!iaut!!);' value='".$msg['duplicate']."'>
		<input type='button' style='!!bouton_add_display!!' class='bouton' value='+' onClick=\"add_aut(2);\"/>	";
	$authors_qualification_tpl="";
}
$pdeptab[12] = "
	<div class='row'>
		<div id='el1Child_3b_first' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-30emr' completion='authors' autfield='f_aut2_id!!iaut!!' id='f_aut2!!iaut!!' name='f_aut2!!iaut!!' value=\"!!aut2!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=auteur&caller=notice&param1=f_aut2_id!!iaut!!&param2=f_aut2!!iaut!!&deb_rech='+".pmb_escape()."(this.form.f_aut2!!iaut!!.value), 'select_author2', 400, 400, -2, -2, '$select1_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_aut2!!iaut!!.value=''; this.form.f_aut2_id!!iaut!!.value='0'; \" />
				<input type='hidden' name='f_aut2_id!!iaut!!' id='f_aut2_id!!iaut!!' value=\"!!aut2_id!!\" />
			</div>
		</div>
		<!--	Fonction	-->
		<div id='el1Child_3b_others' style='float:left;margin-right:10px;'>
			<div class='row'>
				<input type='text' class='saisie-15emr' id='f_f2!!iaut!!' name='f_f2!!iaut!!' completion='fonction' autfield='f_f2_code!!iaut!!' value=\"!!f2!!\" />
				<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=function&caller=notice&p1=f_f2_code!!iaut!!&p2=f_f2!!iaut!!', 'select_func2', 400, 400, -2, -2, '$select2_prop')\" />
				<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_f2!!iaut!!.value=''; this.form.f_f2_code!!iaut!!.value='0'; \" />
				$authors_add_aut_button_tpl
				<input type='hidden' name='f_f2_code!!iaut!!' id='f_f2_code!!iaut!!' value=\"!!f2_code!!\" />
			</div>
		</div>
		$authors_qualification_tpl
	</div>
	" ;

//	----------------------------------------------------
// 	  $pdeptab[2] : contenu de l'onglet 2 (pagination)

$pdeptab[2] = "
<!-- onglet 2 -->
<div id='el2Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el2Img' title=\"pagination\" border='0' onClick=\"expandBase('el2', true); return false;\">
		$msg[serial_Pagination]
	</h3>
</div>
<div id='el2Child' class='child' etirable='yes' title='".htmlentities($msg["serial_Pagination"],ENT_QUOTES, $charset)."'>
	<div id='el2Child_0' title='".htmlentities($msg["serial_Pagination"],ENT_QUOTES, $charset)."' movable='yes'>
		<div  id='el2Child_0a' class='row'>
			<label class='etiquette' for='pagination'>".$msg["serial_Pagination"]."</label>
		</div>
		<div id='el2Child_0b' class='row'>
			<input type='text' class='saisie-80em' name='pages' value=\"!!pages!!\">
		</div>
	</div>
</div>
";

//	----------------------------------------------------
// 	  $pdeptab[3] : contenu de l'onglet 3 (notes)

$pdeptab[3] = "
<!-- onglet 3 -->
<div id='el5Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el5Img' title='$msg[263]' border='0' onClick=\"expandBase('el5', true); return false;\" />
		$msg[264]
	</h3>
</div>
<div id='el5Child' class='child' etirable='yes' title='".htmlentities($msg[264],ENT_QUOTES, $charset)."'>
	<div id='el5Child_0' title='".htmlentities($msg[265],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Note g�n�rale    -->
		<div id='el5Child_0a' class='row'>
		    <label for='f_n_gen' class='etiquette'>$msg[265]</label>
		</div>
		<div id='el5Child_0b' class='row'>
		    <textarea id='f_n_gen' class='saisie-80em' name='f_n_gen' data-form-name='f_n_gen' rows='3' wrap='virtual'>!!n_gen!!</textarea>
		</div>
	</div>
	<div id='el5Child_1' title='".htmlentities($msg[266],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Note de contenu    -->
		<div id='el5Child_1a' class='row'>
		    <label for='f_n_contenu' class='etiquette'>$msg[266]</label>
		</div>
		<div id='el5Child_1b' class='row'>
		    <textarea id='f_n_contenu' class='saisie-80em' name='f_n_contenu' data-form-name='f_n_contenu' rows='5' wrap='virtual'>!!n_contenu!!</textarea>
		</div>
	</div>
	<div id='el5Child_2' title='".htmlentities($msg[267],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    R�sum�/extrait    -->
		<div id='el5Child_2a' class='row'>
		    <label for='f_n_resume' class='etiquette'>$msg[267]</label>
		</div>
		<div id='el5Child_2b' class='row'>
		    <textarea class='saisie-80em' id='f_n_resume' name='f_n_resume' data-form-name='f_n_resume' rows='5' wrap='virtual'>!!n_resume!!</textarea>
		</div>
	</div>
</div>
";

//	----------------------------------------------------
// 	  $pdeptab[4] : contenu de l'onglet 4 (indexation)

$pdeptab[4] = "
<!-- onglet 4 -->
<div id='el6Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el6Img' title=\"$msg[268]\" border='0' onClick=\"expandBase('el6', true);recalc_recept(); return false;\" />
		$msg[269]
	</h3>
</div>
<div id='el6Child' class='child' etirable='yes' title='".htmlentities($msg[269],ENT_QUOTES, $charset)."'>
	<div id='el6Child_0' title='".htmlentities($msg[134],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Cat�gories    -->
		<div id='el6Child_0a' class='row'>
			<label for='f_categ' class='etiquette'>$msg[134]</label>
		</div>
		<input type='hidden' name='max_categ' value=\"!!max_categ!!\" />
		!!categories_repetables!!
		<div id='addcateg'/>
		</div>
	</div>
	<div id='el6Child_1' title='".htmlentities($msg["indexint_catal_title"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    indexation interne    -->
		<div id='el6Child_1a' class='row'>
			<label for='f_categ' class='etiquette'>$msg[indexint_catal_title]</label>
		</div>
		<div id='el6Child_1b' class='row'>
	        <input type='text' class='saisie-80emr' id='f_indexint' name='f_indexint' data-form-name='f_indexint' value=\"!!indexint!!\" completion=\"indexint\" autfield=\"f_indexint_id\"  typdoc=\"typdoc\" />
	        <input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=indexint&caller=notice&param1=f_indexint_id&param2=f_indexint&parent=0&deb_rech='+".pmb_escape()."(this.form.f_indexint.value)+'&typdoc='+(this.form.typdoc.value)+'&num_pclass=!!num_pclass!!', 'select_categ', 600, 320, -2, -2, '$select3_prop')\" />
	        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_indexint.value=''; this.form.f_indexint_id.value='0'; \" />
	        <input type='hidden' name='f_indexint_id' data-form-name='f_indexint_id' id='f_indexint_id' value='!!indexint_id!!' />
	    </div>
	</div>
	<div id='el6Child_2' title='".htmlentities($msg[324],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Indexation libre    -->
		<div id='el6Child_2a' class='row'>
			<label for='f_indexation' class='etiquette'>$msg[324]</label>
		</div>
		<div id='el8Child_2b' class='row'>
	        <textarea class='saisie-80em' id='f_indexation' name='f_indexation' data-form-name='f_indexation' rows='3' wrap='virtual' completion='tags' keys='113'>!!f_indexation!!</textarea>
	    </div>
		<div id='el8Child_2_comment' class='row'>
			<span>$msg[324]$msg[1901]$msg[325]</span>
		</div>
	</div>
	!!concept_form!!
</div>
";
//	----------------------------------------------------
//	 Categories repetables
// 	  $ptab[40]
//	----------------------------------------------------
$pdeptab[40] = "
	<script type='text/javascript' src='./javascript/categ_drop.js'></script>
	<input type='hidden' name='tab_categ_order' id='tab_categ_order' value='!!tab_categ_order!!' />
	<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=categorie&caller=notice&autoindex_class=autoindex_record&indexation_lang=!!indexation_lang_sel!!&p1=f_categ_id!!icateg!!&p2=f_categ!!icateg!!&dyn=1&parent=0&deb_rech=', 'select_categ', 700, 500, -2, -2, '$select_categ_prop')\" />
	<input type='button' class='bouton' value='+' onClick=\"add_categ();\"/>
	<div id='drag_!!icateg!!'  class='row' dragtype='categ' draggable='yes' recept='yes' recepttype='categ' handler='handle_!!icateg!!'
		dragicon=\"".$base_path."/images/icone_drag_notice.png\" dragtext='!!categ_libelle!!' downlight=\"categ_downlight\" highlight=\"categ_highlight\"
		order='!!icateg!!' style='' >
 		<span id=\"handle_!!icateg!!\" style=\"float:left; padding-right : 7px\"><img src=\"".$base_path."/images/sort.png\" style='width:12px; vertical-align:middle' /></span>

        <input type='text' class='saisie-80emr' id='f_categ!!icateg!!' name='f_categ!!icateg!!' data-form-name='f_categ' value=\"!!categ_libelle!!\" completion=\"categories_mul\" autfield=\"f_categ_id!!icateg!!\" />
        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_categ!!icateg!!.value=''; this.form.f_categ_id!!icateg!!.value='0'; \" />
       	<input type='hidden' name='f_categ_id!!icateg!!' data-form-name='f_categ_id' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
	</div>
	";
$pdeptab[401] = "
	<div id='drag_!!icateg!!' class='row' dragtype='categ' draggable='yes' recept='yes' recepttype='categ' handler='handle_!!icateg!!'
		dragicon=\"".$base_path."/images/icone_drag_notice.png\" dragtext='!!categ_libelle!!' downlight=\"categ_downlight\" highlight=\"categ_highlight\"
		order='!!icateg!!' style='' >
		<span id=\"handle_!!icateg!!\" style=\"float:left; padding-right : 7px\"><img src=\"".$base_path."/images/sort.png\" style='width:12px; vertical-align:middle' /></span>

		<input type='text' class='saisie-80emr' id='f_categ!!icateg!!' name='f_categ!!icateg!!' value=\"!!categ_libelle!!\" completion=\"categories_mul\" autfield=\"f_categ_id!!icateg!!\" />
		<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_categ!!icateg!!.value=''; this.form.f_categ_id!!icateg!!.value='0'; \" />
		<input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
	</div>
	";

//	----------------------------------------------------
// 	  $pdeptab[5] : contenu de l'onglet 5 (langues)
//    ----------------------------------------------------

$pdeptab[5] = "
<!-- onglet 7 -->
<div id='el7Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el7Img' title='langues' border='0' onClick=\"expandBase('el7', true); return false;\" />
		$msg[710]
	</h3>
</div>
<div id='el7Child' class='child' etirable='yes' title='".htmlentities($msg[710],ENT_QUOTES, $charset)."'>
	<div id='el7Child_0' title='".htmlentities($msg[710],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Langues    -->
		<div id='el7Child_0a' class='row'>
			<label for='f_langue' class='etiquette'>$msg[710]</label>
		</div>
		<input type='hidden' id='max_lang' name='max_lang' value=\"!!max_lang!!\" />
		!!langues_repetables!!
		<div id='addlang'/>
		</div>
	</div>
	<div id='el7Child_1' title='".htmlentities($msg[711],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Langues    -->
		<div id='el7Child_1a' class='row'>
			<label for='f_langorg' class='etiquette'>$msg[711]</label>
		</div>
		<input type='hidden' id='max_langorg' name='max_langorg' value=\"!!max_langorg!!\" />
		!!languesorg_repetables!!
		<div id='addlangorg'/>
		</div>
	</div>
</div>
";

//    ----------------------------------------------------
//     Langues r�p�tables
//       $ptab[70]
//    ----------------------------------------------------
$pdeptab[50] = "
	<div id='el7Child_0a' class='row'>
        <input type='text' class='saisie-30emr' id='f_lang!!ilang!!' name='f_lang!!ilang!!' data-form-name='f_lang' value=\"!!lang!!\" completion=\"langue\" autfield=\"f_lang_code!!ilang!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_lang_code!!ilang!!&p2=f_lang!!ilang!!', 'select_lang', 500, 400, -2, -2, '$select2_prop')\" />
        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_lang!!ilang!!.value=''; this.form.f_lang_code!!ilang!!.value=''; \" />
        <input type='hidden' name='f_lang_code!!ilang!!' data-form-name='f_lang_code' id='f_lang_code!!ilang!!' value='!!lang_code!!' />
        <input type='button' class='bouton' value='+' onClick=\"add_lang();\"/>
    </div>
	";

$pdeptab[501] = "
	<div id='el7Child_0a' class='row'>
        <input type='text' class='saisie-30emr' id='f_lang!!ilang!!' name='f_lang!!ilang!!' value=\"!!lang!!\" completion=\"langue\" autfield=\"f_lang_code!!ilang!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_lang_code!!ilang!!&p2=f_lang!!ilang!!', 'select_lang', 500, 400, -2, -2, '$select2_prop')\" />
        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_lang!!ilang!!.value=''; this.form.f_lang_code!!ilang!!.value=''; \" />
        <input type='hidden' name='f_lang_code!!ilang!!' id='f_lang_code!!ilang!!' value='!!lang_code!!' />
    </div>
	";

//    ----------------------------------------------------
//     Langues originales r�p�tables
//       $ptab[71]
//    ----------------------------------------------------
$pdeptab[51] = "
	<div id='el7Child_0b' class='row'>
        <input type='text' class='saisie-30emr' id='f_langorg!!ilangorg!!' name='f_langorg!!ilangorg!!' data-form-name='f_langorg' value=\"!!langorg!!\" completion=\"langue\" autfield=\"f_langorg_code!!ilangorg!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_langorg_code!!ilangorg!!&p2=f_langorg!!ilangorg!!', 'select_lang', 500, 400, -2, -2, '$select2_prop')\" />
        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_langorg!!ilangorg!!.value=''; this.form.f_langorg_code!!ilangorg!!.value=''; \" />
        <input type='hidden' name='f_langorg_code!!ilangorg!!' data-form-name='f_langorg_code' id='f_langorg_code!!ilangorg!!' value='!!langorg_code!!' />
        <input type='button' class='bouton' value='+' onClick=\"add_langorg();\"/>
    </div>
	";
$pdeptab[511] = "
	<div id='el7Child_0b' class='row'>
        <input type='text' class='saisie-30emr' id='f_langorg!!ilangorg!!' name='f_langorg!!ilangorg!!' value=\"!!langorg!!\" completion=\"langue\" autfield=\"f_langorg_code!!ilangorg!!\" />
		<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=lang&caller=notice&p1=f_langorg_code!!ilangorg!!&p2=f_langorg!!ilangorg!!', 'select_lang', 500, 400, -2, -2, '$select2_prop')\" />
        <input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_langorg!!ilangorg!!.value=''; this.form.f_langorg_code!!ilangorg!!.value=''; \" />
        <input type='hidden' name='f_langorg_code!!ilangorg!!' id='f_langorg_code!!ilangorg!!' value='!!langorg_code!!' />
    </div>
	";



//	----------------------------------------------------
// 	  $pdeptab[6] : contenu de l'onglet 6 (liens)

$pdeptab[6] = "
<script>
function chklnk_f_lien(element){
	if(element.value != ''){
		var wait = document.createElement('img');
		wait.setAttribute('src','images/patience.gif');
		wait.setAttribute('align','top');
		while(document.getElementById('f_lien_check').firstChild){
			document.getElementById('f_lien_check').removeChild(document.getElementById('f_lien_check').firstChild);
		}
		document.getElementById('f_lien_check').appendChild(wait);
		var testlink = encodeURIComponent(element.value);
		var check = new http_request();
		if(check.request('./ajax.php?module=ajax&categ=chklnk',true,'&timeout=!!pmb_curl_timeout!!&link='+testlink)){
			alert(check.get_text());
		}else{
			var result = check.get_text();
			var img = document.createElement('img');
			var src='';
			if(result == '200') {
				if((element.value.substr(0,7) != 'http://') && (element.value.substr(0,8) != 'https://')) element.value = 'http://'+element.value;
				//impec, on print un petit message de confirmation
				src = 'images/tick.gif';
			}else{
				//probl�me...
				src = 'images/error.png';
				img.setAttribute('style','height:1.5em;');
			}
			img.setAttribute('src',src);
			img.setAttribute('align','top');
			while(document.getElementById('f_lien_check').firstChild){
				document.getElementById('f_lien_check').removeChild(document.getElementById('f_lien_check').firstChild);
			}
			document.getElementById('f_lien_check').appendChild(img);
		}
	}
}
</script>
<!-- onglet 6 serials.tpl.php bis -->
<div id='el8Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el8Img' onClick=\"expandBase('el8', true); return false;\" title='$msg[274]' border='0' />
		$msg[274]
	</h3>
</div>
<div id='el8Child' class='child' etirable='yes' title='".htmlentities($msg[274],ENT_QUOTES, $charset)."'>
	<div id='el8Child_0' title='".htmlentities($msg[275],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    URL associ�e    -->
		<div id='el8Child_0a' class='row'>
			<label for='f_l' class='etiquette'>$msg[275]</label>
		</div>
		<div id='el8Child_0b' class='row'>
			<div id='f_lien_check' style='display:inline'></div>
			<input name='f_lien' data-form-name='f_lien' type='text' class='saisie-80em' id='f_lien' onchange='chklnk_f_lien(this);' value=\"!!lien!!\" maxlength='255' />
			<input class='bouton' type='button' onClick=\"var l=document.getElementById('f_lien').value; eval('window.open(\''+l+'\')');\" title='$msg[CheckLink]' value='$msg[CheckButton]' />
		</div>
	</div>
	<div id='el8Child_1' title='".htmlentities($msg[276],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Format �lectronique de la ressource    -->
		<div id='el8Child_1a' class='row'>
			<label for='f_eformat' class='etiquette'>$msg[276]</label>
		</div>
		<div id='el8Child_1b' class='row'>
		    <input type='text' class='saisie-80em' id='f_eformat' name='f_eformat' data-form-name='f_eformat' value=\"!!eformat!!\" />
		</div>
	</div>
</div>
";

//	----------------------------------------------------
//    Onglet map
//    ----------------------------------------------------
global $pmb_map_activate;
$pdeptab[14] = $ptab[14] = '';
if ($pmb_map_activate)
	$pdeptab[14] = $ptab[14] = "
	<!-- onglet 14 -->
	<div id='el14Parent' class='parent'>
		<h3>
			<img src='./images/plus.gif' class='img_plus' name='imEx' id='el14Img' onClick=\"expandBase('el14', true); return false;\" title='".$msg["notice_map_onglet_title"]."' border='0' /> ".$msg["notice_map_onglet_title"]."
		</h3>
	</div>

	<div id='el14Child' class='child' etirable='yes' title='".htmlentities($msg['notice_map_onglet_title'],ENT_QUOTES, $charset)."'>
		<div id='el14Child_0' title='".htmlentities($msg['notice_map'],ENT_QUOTES, $charset)."' movable='yes'>
			<div id='el14Child_0a' class='row'>
				<label class='etiquette'>$msg[notice_map]</label>
			</div>
			<div id='el14Child_0b' class='row'>
				!!notice_map!!
			</div>
		</div>
	</div>
	";

//	----------------------------------------------------
//	Champs personalis�s
// 	  $ptab[7] : Contenu de l'onglet 7 (champs personalis�s)
//	----------------------------------------------------

$pdeptab[7] = "
<!-- onglet 7 -->
<div id='el9Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el9Img' onClick=\"expandBase('el9', true); recalc_recept(); return false;\" title='".$msg["notice_champs_perso"]."' border='0' /> ".$msg["notice_champs_perso"]."
	</h3>
</div>
<div id='el9Child' class='child' etirable='yes' title='".$msg["notice_champs_perso"]."'>
	!!champs_perso!!
</div>
";


//	----------------------------------------------------
//	Champs personalis�s
// 	  $ptab[7] : Contenu de l'onglet 7 (champs personalis�s)
//	----------------------------------------------------

$pdeptab[999] = "
<!-- onglet 7 -->
<div id='el999Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el999Img' onClick=\"expandBase('el999', true); recalc_recept(); return false;\" title='".$msg["notice_champs_convo"]."' border='0' /> ".$msg["notice_champs_convo"]."
	</h3>
</div>
<div id='el999Child' class='child' etirable='yes' title='".$msg["notice_champs_convo"]."'>
	!!champs_perso!!
</div>
";

//    ----------------------------------------------------
//    Champs de gestion
//       $ptab[8] : Contenu de l'onglet 8 (champs de gestion)
//    ----------------------------------------------------

$pdeptab[8] = "
<!-- onglet 8 -->
<div id='el10Parent' class='parent'>
	<h3>
		<img src='./images/plus.gif' class='img_plus' name='imEx' id='el10Img' onClick=\"expandBase('el10', true); return false;\" title='".$msg["notice_champs_gestion"]."' border='0' /> ".$msg["notice_champs_gestion"]."
	</h3>
</div>
<div id='el10Child' class='child' etirable='yes' title='".htmlentities($msg["notice_champs_gestion"],ENT_QUOTES, $charset)."'>
	<div id='el10Child_0' title='".htmlentities($msg["notice_statut_gestion"],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_0a' class='row'>
			<label for='f_notice_statut' class='etiquette'>$msg[notice_statut_gestion]</label>
		</div>
		<div id='el10Child_0b' class='row'>
			!!notice_statut!!
		</div>
	</div>
	<div id='el10Child_7' title='".htmlentities($msg["notice_is_new_gestion"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Nouveaut�    -->
		<div id='el10Child_7a' class='row'>
		    <label for='f_new_gestion' class='etiquette'>".$msg["notice_is_new_gestion"]."</label>
		</div>
		<div id='el10Child_7b' class='row'>
		    <input type='radio' name='f_notice_is_new' !!checked_no!! value='0'>".$msg["notice_is_new_gestion_no"]."<br>
		    <input type='radio' name='f_notice_is_new' !!checked_yes!! value='1'>".$msg["notice_is_new_gestion_yes"]."<br>
		</div>
	</div>
	<div id='el10Child_1' title='".htmlentities($msg["notice_commentaire_gestion"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    commentaire de gestion    -->
		<div id='el10Child_1a' class='row'>
			<label for='f_commentaire_gestion' class='etiquette'>$msg[notice_commentaire_gestion]</label>
		</div>
		<div id='el10Child_1b' class='row'>
			<textarea class='saisie-80em' id='f_commentaire_gestion' name='f_commentaire_gestion' rows='1' wrap='virtual'>!!commentaire_gestion!!</textarea>
		</div>
	</div>
	<div id='el10Child_2' title='".htmlentities($msg["notice_thumbnail_url"],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    URL vignette speciale    -->
		<div id='el10Child_2a' class='row'>
			<label for='f_thumbnail_url' class='etiquette'>$msg[notice_thumbnail_url]</label>
		</div>
		<div id='el10Child_2b' class='row'>
			<div id='f_thumbnail_check' style='display:inline'></div>
			<input type='text' class='saisie-80em' id='f_thumbnail_url' name='f_thumbnail_url' rows='1' wrap='virtual' value=\"!!thumbnail_url!!\" onchange='chklnk_f_thumbnail_url(this);' />
		</div>
	</div>";
global $pmb_notice_img_folder_id;
if($pmb_notice_img_folder_id)
	$pdeptab[8].= "
	<div id='el10Child_6' title='".htmlentities($msg['notice_img_load'],ENT_QUOTES, $charset)."' movable='yes'>
		<!--    Vignette upload    -->
		<div id='el10Child_6a' class='row'>
			<label for='f_img_load' class='etiquette'>$msg[notice_img_load]</label>!!message_folder!!
		</div>
		<div id='el10Child_6b' class='row'>
			<input type='file' class='saisie-80em' id='f_img_load' name='f_img_load' rows='1' wrap='virtual' value='' />
		</div>
	</div>";
$pdeptab[8].= "
	<div id='el10Child_4' title='".htmlentities($msg['admin_menu_acces'],ENT_QUOTES, $charset)."' movable='yes'>
		<!-- Droits d'acces -->
		<!-- rights_form -->
	</div>
	<div id='el10Child_5' title='".htmlentities($msg["indexation_lang_select"],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_5a' class='row'>
			<label for='f_notice_lang' class='etiquette'>".$msg["indexation_lang_select"]."</label>
		</div>
		<div id='el10Child_5b' class='row'>
		!!indexation_lang!!
		</div>
	</div>";
global $pmb_notices_show_dates;
if($pmb_notices_show_dates)
	$pdeptab[8].= "
		<div id='el10Child_9' title='".htmlentities($msg[noti_crea_date],ENT_QUOTES, $charset)."' movable='yes'>
			<div id='el10Child_9a' class='row'>
				!!dates_notice!!
			</div>
		</div>";
$pdeptab[8].= "
	<div id='el10Child_10' title='".htmlentities($msg['notice_usage_libelle'],ENT_QUOTES, $charset)."' movable='yes'>
		<div id='el10Child_10a' class='row'>
		    <label for='f_notice_usage' class='etiquette'>".$msg['notice_usage_libelle']."</label>
		</div>
		<div id='el10Child_10b' class='row'>
			!!num_notice_usage!!
	    </div>
	</div>
</div>
";

//    ----------------------------------------------------
//     Titres uniformes
//       $pdeptab[230] : contenu de l'onglet 230 (Titres uniformes)
//    ----------------------------------------------------
global $pmb_use_uniform_title;
if ($pmb_use_uniform_title) {
	$pdeptab[230] = "
	<!-- onglet 230 -->
	<div id='el230Parent' class='parent'>
	<h3>
	    <img src='./images/plus.gif' class='img_plus' name='imEx' id='el230Img' title='titres_uniformes' border='0' onClick=\"expandBase('el230', true); return false;\" />
	    ".$msg["catal_onglet_titre_uniforme"]."
	</h3>
	</div>

	<div id='el230Child' class='child' etirable='yes' title='".htmlentities($msg["aut_menu_titre_uniforme"],ENT_QUOTES, $charset)."'>

	<div id='el230Child_0' title='".htmlentities($msg["aut_menu_titre_uniforme"],ENT_QUOTES, $charset)."' movable='yes'>
	<!--    Titres uniformes    -->
	!!titres_uniformes!!
	</div>

	</div>
	";
} else $pdeptab[230] = "";


//	-----------------------------------------------------------
// 	  $analysis_top : formulaire de notice de d�pouillement
global $pmb_catalog_verif_js;
$analysis_top_form = jscript_unload_question();
$analysis_top_form.= "
<!-- script de gestion des onglets -->
<script type='text/javascript' src='./javascript/tabform.js'></script>
".($pmb_catalog_verif_js!= "" ? "<script type='text/javascript' src='./javascript/$pmb_catalog_verif_js'></script>":"")."
<script type='text/javascript'>
<!--
	function test_notice(form)
	{";
if($pmb_catalog_verif_js!= ""){
	$analysis_top_form.= "
		var check = check_perso_analysis_form();
		if(check == false) return false;";
}
$analysis_top_form.="
		if(form.f_tit1.value.length == 0)
			{
				alert(\"$msg[277]\");
				return false;
			}

		if(document.forms['notice'].elements['perio_type_use_existing']){
			var perio_type = document.forms['notice'].elements['perio_type_use_existing'].checked;
			var bull_type =  document.forms['notice'].elements['bull_type_use_existing'].checked;
			var perio_type_new = document.forms['notice'].elements['perio_type_new'].checked;
			var bull_type_new =  document.forms['notice'].elements['bull_type_new'].checked;

			if(!perio_type && bull_type) {
				alert(\"".$msg['z3950_bull_already_linked']."\")
				return false;
			}
			if(perio_type_new && (document.getElementById('f_perio_new').value == '')){
				alert(\"".$msg['z3950_serial_title_mandatory']."\")
				return false;
			}

			if(bull_type_new && (document.getElementById('f_bull_new_titre').value == '') && (document.getElementById('f_bull_new_mention').value == '')
			&& (document.getElementById('f_bull_new_date').value == '') && (document.getElementById('f_bull_new_num').value == '')){
				alert(\"".$msg['z3950_fill_bull']."\")
				return false;
			}

			if(perio_type && bull_type && (document.getElementById('bul_id').value) == '0'){
					alert(\"".$msg['z3950_no_bull_selected']."\")
					return false;
			}
		}";

$analysis_top_form.= "
		return check_form();
	}
-->
</script>
<script src='javascript/ajax.js'></script>
<script src='javascript/move.js'></script>
<script type='text/javascript'>
	var msg_move_to_absolute_pos='".addslashes($msg['move_to_absolute_pos'])."';
	var msg_move_to_relative_pos='".addslashes($msg['move_to_relative_pos'])."';
	var msg_move_saved_ok='".addslashes($msg['move_saved_ok'])."';
	var msg_move_saved_error='".addslashes($msg['move_saved_error'])."';
	var msg_move_up_tab='".addslashes($msg['move_up_tab'])."';
	var msg_move_down_tab='".addslashes($msg['move_down_tab'])."';
	var msg_move_position_tab='".addslashes($msg['move_position_tab'])."';
	var msg_move_position_absolute_tab='".addslashes($msg['move_position_absolute_tab'])."';
	var msg_move_position_relative_tab='".addslashes($msg['move_position_relative_tab'])."';
	var msg_move_invisible_tab='".addslashes($msg['move_invisible_tab'])."';
	var msg_move_visible_tab='".addslashes($msg['move_visible_tab'])."';
	var msg_move_inside_tab='".addslashes($msg['move_inside_tab'])."';
	var msg_move_save='".addslashes($msg['move_save'])."';
	var msg_move_first_plan='".addslashes($msg['move_first_plan'])."';
	var msg_move_last_plan='".addslashes($msg['move_last_plan'])."';
	var msg_move_first='".addslashes($msg['move_first'])."';
	var msg_move_last='".addslashes($msg['move_last'])."';
	var msg_move_infront='".addslashes($msg['move_infront'])."';
	var msg_move_behind='".addslashes($msg['move_behind'])."';
	var msg_move_up='".addslashes($msg['move_up'])."';
	var msg_move_down='".addslashes($msg['move_down'])."';
	var msg_move_invisible='".addslashes($msg['move_invisible'])."';
	var msg_move_visible='".addslashes($msg['move_visible'])."';
	var msg_move_saved_onglet_state='".addslashes($msg['move_saved_onglet_state'])."';
	var msg_move_open_tab='".addslashes($msg['move_open_tab'])."';
	var msg_move_close_tab='".addslashes($msg['move_close_tab'])."';
</script>
<script type='text/javascript'>document.title = '!!document_title!!';</script>
<form class='form-$current_module' id='notice' name='notice' method='post' action='./catalog.php?categ=serials&sub=analysis&action=update' enctype='multipart/form-data'>
<h3><div class='left'>!!form_title!!</div><div class='right'>";
if ($PMBuserid==1 && $pmb_form_editables==1) $analysis_top_form.="<input type='button' class='bouton_small' value='Editer format' onClick=\"expandAll(); move_parse_dom(relative)\" id=\"bt_inedit\"/><input type='button' class='bouton_small' value='Relatif' onClick=\"expandAll(); move_parse_dom((!relative))\" style=\"display:none\" id=\"bt_swap_relative\"/>";
if ($pmb_form_editables==1) $analysis_top_form.="<input type='button' class='bouton_small' value=\"Format d'origine\" onClick=\"get_default_pos(); expandAll();  ajax_parse_dom(); if (inedit) move_parse_dom(relative); else initIt();\"/>";
$analysis_top_form.="</div></h3>&nbsp;
<div class='form-contenu'>
<div class='row'>
	!!doc_type!!  !!location!!
</div>
<div class='row'>
	<a href=\"javascript:expandAll()\"><img src='./images/expand_all.gif' border='0' id=\"expandall\"></a>
	<a href=\"javascript:collapseAll()\"><img src='./images/collapse_all.gif' border='0' id=\"collapseall\"></a>";

$analysis_top_form .= "
	<input type=\"hidden\" name=\"b_level\" value=\"!!b_level!!\">
	<input type=\"hidden\" name=\"h_level\" value=\"!!h_level!!\">
	<input type=\"hidden\" name=\"serial_id\" id=\"serial_id\" value=\"!!id!!\">
	<input type=\"hidden\" name=\"bul_id\" id=\"bul_id\" value=\"!!bul_id!!\">
	<input type=\"hidden\" name=\"analysis_id\" value=\"!!analysis_id!!\">
	<input type=\"hidden\" name=\"id_form\" value=\"!!id_form!!\">
	</div>
	!!type_catal!!
	!!tab0!!
	<hr class='spacer' />
	!!tab1!!
	<hr class='spacer' />
	!!tab2!!
	<hr class='spacer' />
	!!tab3!!
	<hr class='spacer' />
	!!tab4!!
	<hr class='spacer' />
	!!tab5!!
	<hr class='spacer' />
	!!tab6!!";
if ($pmb_use_uniform_title) $analysis_top_form .= "<hr class='spacer' />!!tab230!!";
$analysis_top_form .= "<hr class='spacer' />
	<hr class='spacer' />
	!!tab7!!
	<hr class='spacer' />
	!!tab13!!
	<hr class='spacer' />
	!!tab14!!
	<hr class='spacer' />
	!!tab8!!
	<hr class='spacer' />
	!!tab999!!
	<hr class='spacer' />
	!!authperso!!
	</div>
<div class='row'>
	<div class='left'>
		<input type='button' class='bouton' value='$msg[76]' onClick=\"unload_off();history.go(-1);\" />
		<input type='button' class='bouton' value='$msg[77]' id='btsubmit' onClick=\"if (test_notice(this.form)) {unload_off();this.form.submit();}\" />
		!!link_duplicate!!
		!!link_move!!
		!!link_audit!!
	</div>
	<div class='right'>!!link_supp!!</div>
</div>
<div class='row'></div>
</form>
<script type='text/javascript'>".($pmb_form_editables?"get_pos(); ":"")."
	ajax_parse_dom();
	document.forms['notice'].elements['f_tit1'].focus();
	</script>
";

function notice_bul_form() {
}
$notice_bulletin_form = jscript_unload_question();
$notice_bulletin_form.="<div class='row'>
		<a href=\"javascript:expandAll()\"><img src='./images/expand_all.gif' border='0' id=\"expandall\"></a>
		<a href=\"javascript:collapseAll()\"><img src='./images/collapse_all.gif' border='0' id=\"collapseall\"></a>
		!!doc_type!! !!location!!
		<input type=\"hidden\" name=\"b_level\" value=\"!!b_level!!\">
		<input type=\"hidden\" name=\"h_level\" value=\"!!h_level!!\">
		<input type=\"hidden\" name=\"serial_id\" value=\"!!id!!\">
		<input type=\"hidden\" name=\"bul_id\" value=\"!!bul_id!!\">
		<input type=\"hidden\" name=\"analysis_id\" value=\"!!analysis_id!!\">
		<input type=\"hidden\" name=\"id_form\" value=\"!!id_form!!\">
	</div>
	!!serial_bul_form!!
	!!tab0!!
	<hr class='spacer' />
	!!tab1!!
	<hr class='spacer' />
	!!tab2!!
	<hr class='spacer' />
	!!tab3!!
	<hr class='spacer' />
	!!tab4!!
	<hr class='spacer' />
	!!tab5!!
	<hr class='spacer' />
	!!tab6!!
	<hr class='spacer' />
	!!tab7!!
	<hr class='spacer' />
	!!tab8!!
	<hr class='spacer' />
	!!tab999!!
	<hr class='spacer' />
	!!authperso!!
	</div>
";

//$serial_bul_form=str_replace("!!serial_bul_form!!",$serial_bul_form,$notice_bulletin_form);

$liste_script ="
<script type=\"text/javascript\" src=\"./javascript/tablist.js\"></script>
";

// Modif ER suppression du form en liste_debut et liste_fin : <form class='form-$current_module' name=\"notice_list\" class=\"notice-bu\">
$liste_debut ="
<a href=\"javascript:expandAll()\"><img src='./images/expand_all.gif' border='0' id=\"expandall\"></a>
<a href=\"javascript:collapseAll()\"><img src='./images/collapse_all.gif' border='0' id=\"collapseall\"></a>
";

$liste_fin = "";

// template pour le form de saisie code barre (p�riodiques)
// cr�ation d'un exemplaire rattach� � un bulletin
//if($pmb_numero_exemplaire_auto>0) $num_exemplaire_test="if(eval(form.option_num_auto.checked == false ))";
if($pmb_numero_exemplaire_auto==1 || $pmb_numero_exemplaire_auto==3) {
	$num_exemplaire_test="var r=false;try { r=form.option_num_auto.checked;} catch(e) {};if(r==false) ";
} else {
	$num_exemplaire_test="";
}
if ($pmb_rfid_activate==1 ) {
	$num_exemplaire_rfid_test="if(0)";
} else {
	$num_exemplaire_rfid_test="";
}
$bul_cb_form = "
<script type='text/javascript'>
<!--
	function test_form(form) {
		$num_exemplaire_rfid_test
		$num_exemplaire_test
		if(form.noex.value.replace(/^\s+|\s+$/g, '').length == 0) {
			alert(\"$msg[292]\");
			document.forms['addex'].elements['noex'].focus();
			return false;
		}
		return true;
	}
-->
</script>
<form class='form-$current_module' name='addex' method='post' action='./catalog.php?categ=serials&sub=bulletinage&action=expl_form&bul_id=!!bul_id!!&expl_id=0'>
	<div class='row'>
		<h3>$msg[290]</h3>
	</div>
	<!--	Contenu du form	-->
	<div class='form-contenu'>
		<div class='row'>
			!!etiquette!!
		</div>
		<div class='row'>
			!!saisie_num_expl!!
		</div>
	</div>
	<div class='row'>
		!!btn_ajouter!!
		<input type='button' class='bouton' value=' $msg[explnum_ajouter_doc] ' onClick=\"document.location='./catalog.php?categ=serials&sub=bulletinage&action=explnum_form&bul_id=!!bul_id!!&explnum_id=0'\">
		!!btn_print_ask!!
	</div>
</form>
<script type='text/javascript'>
	document.forms['addex'].elements['noex'].focus();
</script>
";

//	----------------------------------
//	$bul_expl_form :form de saisie/modif exemplaire de bulletin
if ($pmb_rfid_activate==1 && $pmb_rfid_serveur_url ) {
	if($pmb_rfid_driver=="ident")  $script_erase="init_rfid_erase(rfid_ack_erase);";
	else $script_erase="rfid_ack_erase(1);";

	$rfid_script_catalog="
		$rfid_js_header
		<script type='text/javascript'>
			var flag_cb_rfid=0;
			flag_program_rfid_ask=0;
			setTimeout(\"init_rfid_read_cb(0,f_expl);\",0);;
			nb_part_readed=0;

			var msg_rfid_programmation_confirmation = '".addslashes($msg['rfid_programmation_confirmation'])."';
			var msg_rfid_etiquette_programmee_message = '".addslashes($msg['rfid_etiquette_programmee_message'])."';
					
			function program_rfid() {
				flag_semaphore_rfid=1;
				flag_program_rfid_ask=0;
				var nbparts = 0;
				if(document.getElementById('f_ex_nbparts')) {
					nbparts = document.getElementById('f_ex_nbparts').value;	
					if(nb_part_readed!= nbparts) {
						flag_semaphore_rfid=0;
						alert(\"".addslashes($msg['rfid_programmation_nbpart_error'])."\");
						return;
					}
				} else {
					nbparts = 1;
				}
				$script_erase
			}
		</script>
		<script type='text/javascript' src='".$base_path."/javascript/rfid.js'></script>
";
	$rfid_program_button="<input type=button class='bouton' value=' ". $msg['rfid_configure_etiquette_button']." ' onClick=\"program_rfid_ask();\">";
}else {
	$rfid_script_catalog="";
	$rfid_program_button="";
}

$bul_expl_form = jscript_unload_question();
$bul_expl_form.="
$rfid_script_catalog
<script type='text/javascript'>
	require(['dojo/ready', 'apps/pmb/gridform/FormEdit'], function(ready, FormEdit){
	     ready(function(){
	     	new FormEdit('catalog', 'expl_bulletin');
	     });
	});
</script>
<script type='text/javascript'>
<!--
	function test_form(form) {
		!!questionrfid!!
		if((form.f_ex_cb.value.replace(/^\s+|\s+$/g, '').length == 0) || (form.expl_cote.value.replace(/^\s+|\s+$/g, '').length == 0)) {
			alert(\"$msg[304]\");
			return false;
		}
		if (typeof(form.expl_codestat) == 'undefined') {
			alert(\"".$msg["expl_codestat_mandatory"]."\");
			return false;
		}
		unload_off();
		return check_form();
	}
	function calcule_section(selectBox) {
		for (i=0; i<selectBox.options.length; i++) {
			id=selectBox.options[i].value;
			list=document.getElementById(\"docloc_section\"+id);
			list.style.display=\"none\";
		}

		id=selectBox.options[selectBox.selectedIndex].value;
		list=document.getElementById(\"docloc_section\"+id);
		list.style.display=\"block\";
	}
-->
</script>
<form class='form-$current_module' name='expl' id='expl-form' method='post' action='!!action!!'>
<div class='left'>
	<h3>$msg[300]</h3>
</div>
<div class='right'>";
if ($PMBuserid==1 && $pmb_form_expl_editables==1){
	$bul_expl_form.="<input type='button' class='bouton_small' value='".$msg["catal_edit_format"]."' id=\"bt_inedit\"/>";
}
if ($pmb_form_expl_editables==1) {
	$bul_expl_form.="<input type='button' class='bouton_small' value=\"".$msg["catal_origin_format"]."\" id=\"bt_origin_format\"/>";
}
$bul_expl_form.="</div>
<div class='form-contenu'>
	<div id='zone-container'>
		<div id='el0Child_0' class='row' movable='yes' title=\"".htmlentities($msg['291'], ENT_QUOTES, $charset)."\">
			<!-- code barre -->
			<label class='etiquette' for='f_ex_cb'>".$msg['291']."</label>
			<div class='row'>
				<input type='text' class='saisie-20emr' id=\"f_ex_cb\" value='!!cb!!' name='f_ex_cb' readonly='readonly' />
				<input type=button class='bouton' value='".$msg['parcourir']."' onclick=\"openPopUp('./catalog/expl/setcb.php', 'ex_getcb', 220, 100, -2, -2, 'toolbar=no')\" />".(file_exists("print_cb.php")?"<input type='button' value='".htmlentities($msg["print_print"],ENT_QUOTES,$charset)."' onClick='h=new http_request(); h.request(\"print_cb.php?cb=\"+document.getElementById(\"f_ex_cb\").value, false,\"\", false, function(){},function(){},\"impr_cb\")' class='bouton'/>":"")."
			</div>
		</div>
		<div id='el0Child_1' class='row'>
			<div id='el0Child_1_a' movable='yes' class='colonne3' title=\"".htmlentities($msg['296'], ENT_QUOTES, $charset)."\">
				<!-- cote -->
					<label class='etiquette' for='f_ex_cote'>$msg[296]</label>
				<div class='row'>
					<input type='text' class='saisie-20em' id=\"f_ex_cote\" name='expl_cote' value='!!cote!!' />
				</div>
			</div>
			<div id='el0Child_1_b' movable='yes' class='colonne3' title=\"".htmlentities($msg['294'], ENT_QUOTES, $charset)."\">
				<!-- type document -->
				<label class='etiquette' for='f_ex_typdoc'>$msg[294]</label>
				<div class='row'>
					!!type_doc!!
				</div>
			</div>
			<div id='el0Child_1_c' movable='yes' class='colonne3' title=\"".htmlentities($msg['expl_nbparts'], ENT_QUOTES, $charset)."\">
				<!-- Nombre de parties -->
				<label class='etiquette' for='f_ex_nbparts'>".$msg["expl_nbparts"]."</label>
				<div class='row'>
					<input type='text' class='saisie-5em' id=\"f_ex_nbparts\" value='!!nbparts!!' name='f_ex_nbparts' />
				</div>
			</div>
		</div>
		<div id='el0Child_2' class='row'>
			<div id='el0Child_2_a' movable='yes' class='colonne3' title=\"".htmlentities($msg['298'], ENT_QUOTES, $charset)."\">
				<!-- localisation -->
				<label class='etiquette' for='f_ex_location'>".$msg['298']."</label>
				<div class='row'>
					!!localisation!!
				</div>
			</div>
			<div id='el0Child_2_b' movable='yes' class='colonne3' title=\"".htmlentities($msg['295'], ENT_QUOTES, $charset)."\">
				<!-- section -->
				<label class='etiquette' for='f_ex_section'>".$msg['295']."</label>
				<div class='row'>
					!!section!!
				</div>
			</div>
			<div id='el0Child_2_c' movable='yes' class='colonne3' title=\"".htmlentities($msg['651'], ENT_QUOTES, $charset)."\">
				<!-- proprietaire -->
				<label class='etiquette' for='f_ex_owner'>".$msg['651']."</label> 
				<div class='row'>
					!!owner!!
				</div>
			</div>
		</div>
		<div id='el0Child_3' class='row'>
			<div id='el0Child_3_a' movable='yes' class='colonne3' title=\"".htmlentities($msg['297'], ENT_QUOTES, $charset)."\">
				<!-- statut -->
				<label class='etiquette' for='f_ex_statut'>".$msg['297']."</label>
				<div class='row'>
					!!statut!!
				</div>
			</div>
			<div id='el0Child_3_b' movable='yes' class='colonne3' title=\"".htmlentities($msg['299'], ENT_QUOTES, $charset)."\">
				<!-- code stat -->
				<label class='etiquette' for='f_ex_cstat'>".$msg['299']."</label>
				<div class='row'>
					!!codestat!!
				</div>
			</div>
			!!antivol_form!!
		</div>

		<!-- notes -->
		<div id='el0Child_4' class='row' movable='yes' title=\"".htmlentities($msg['expl_message'], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='f_ex_note'>".$msg['expl_message']."</label>
			</div>
			<div class='row'>
				<textarea name='expl_note' id='f_ex_note' class='saisie-80em'>!!note!!</textarea>
			</div>
		</div>
		<div id='el0Child_5' class='row' movable='yes' title=\"".htmlentities($msg['expl_zone_comment'], ENT_QUOTES, $charset)."\">
			<div class='row'>
				<label class='etiquette' for='f_ex_comment'>".$msg['expl_zone_comment']."</label>
			</div>
			<div class='row'>
				<textarea name='f_ex_comment' id='f_ex_comment' class='saisie-80em'>!!comment!!</textarea>
			</div>
		</div>

		<!-- prix et date -->
		<div id='el0Child_6' class='row'>
			<div id='el0Child_6_a' class='colonne3' movable='yes' title=\"".htmlentities($msg['4050'], ENT_QUOTES, $charset)."\">
				<div class='row'>
					<label class='etiquette' for='f_ex_prix'>".$msg['4050']."</label>
				</div>
				<div class='row'>
					<input type='text' class='text' name='expl_prix' id='f_ex_prix' value=\"!!prix!!\" />
				</div>
			</div>
			!!create_update_date_form!!
			!!filing_return_date_form!!
		</div>
		<!-- index_concept_form -->
		!!champs_perso!!
		!!perio_circ_tpl!!
	</div>
</div>
<div class='row'>
	<br />
	<div class='left'>
		<input type='button' class='bouton' value=' $msg[76] ' onClick=\"unload_off();history.go(-1);\" />
		!!bt_modifier!!
		$rfid_program_button
		!!bt_dupliquer!!
		!!link_audit!!
	</div>
	<div class='right'>
		!!del!!
	</div>
	<!-- chams de gestion -->
	<input type=\"hidden\" name=\"expl_bulletin\" value=\"!!bul_id!!\">
	<input type=\"hidden\" name=\"id_form\" value=\"!!id_form!!\">
	<input type=\"hidden\" name=\"org_cb\" value=\"!!org_cb!!\">
	<input type=\"hidden\" name=\"expl_id\" value=\"!!expl_id!!\">
</div>
<div class='row'></div>
</form>
<script type='text/javascript' src='./javascript/ajax.js' ></script>
<script type=\"text/javascript\">
	<!--
	document.forms['expl'].elements['expl_cote'].focus();
	ajax_parse_dom();
	
	function confirm_expl_delete() {
		phrase = \"".$msg['confirm_suppr_serial_expl']."\";
		result = confirm(phrase);
		if(result) {
			unload_off();
			document.location = './catalog.php?categ=serials&sub=bulletinage&action=expl_delete&bul_id=!!bul_id!!&expl_id=!!expl_id!!';
		}
	}
	-->
</script>
";

$serial_edit_access ="
<script type='text/javascript'>
<!--
	function test_form(form){
		if(form.user_query.value.replace(/^\s+|\s+$/g, '').length == 0){
			alert(\"$msg[141]\");
			form.user_query.focus();
			return false;
		}
		return true;
	}
-->
</script>
<form class='form-$current_module' name='serial_search' method='post' action='./edit.php?categ=serials&sub=!!etat!!'>
<div class='form-contenu'>
	<div class='row'>
		<label class='etiquette' for='form_cb'>!!message!!</label>
	</div>
	<div class='row'>
		<input class='saisie-80em' id='user_query' type='text' name='user_query' value='!!user_query!!' />
	</div>
</div>
<div class='row'>
	<input class='bouton' type='submit' value='$msg[89]' onClick='return test_form(this.form)' />
</div>
</form>
<script type=\"text/javascript\">
	document.forms['serial_search'].elements['user_query'].focus();
</script>
";
$serial_edit_access = str_replace('!!user_query!!', htmlentities(stripslashes($user_query ),ENT_QUOTES, $charset), $serial_edit_access);

$serial_list_tmpl = "
<h1>$msg[1152] \"<strong>!!cle!!</strong>\"</h1>
<table border='0' width='100%'>
!!list!!
</table>
<div class='row'>
!!nav_bar!!
</div>
";

// $perio_replace : form remplacement periodique
$perio_replace = "
<form class='form-".$current_module."' name='perio_replace' method='post' action='./catalog.php?categ=serials&sub=serial_replace&serial_id=!!serial_id!!'>
<h3>".$msg['159']." !!old_perio_libelle!! </h3>
<div class='form-contenu'>
	<div class='row'>
		<label class='etiquette' for='par'>".$msg['160']."</label>
	</div>
	<div class='row'>
		<input type='text' class='saisie-50emr' value='' id='perio_libelle' name='perio_libelle' readonly>
		<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=perio&caller=perio_replace&param1=by&param2=perio_libelle&no_display=!!serial_id!!', 'select_perio', 600, 400, -2, -2, '".$selector_prop."')\" title='".$msg['157']."' value='".$msg['parcourir']."' />
		<input type='button' class='bouton' value='".$msg['raz']."' onclick=\"this.form.perio_libelle.value=''; this.form.by.value='0'; \" />
		<input type='hidden' name='by' value=''>
	</div>
	!!perio_replace_categories!!
	<div class='row'>
		<input type='radio' name='notice_replace_links' value='0' ".($deflt_notice_replace_links==0?"checked='checked'":"")." /> ".$msg['notice_replace_links_option_keep_all']."
		<input type='radio' name='notice_replace_links' value='1' ".($deflt_notice_replace_links==1?"checked='checked'":"")." /> ".$msg['notice_replace_links_option_keep_replacing']."
		<input type='radio' name='notice_replace_links' value='2' ".($deflt_notice_replace_links==2?"checked='checked'":"")." /> ".$msg['notice_replace_links_option_keep_replaced']."
	</div>
</div>
<div class='row'>
	<input type='button' class='bouton' value='".$msg['76']."' onClick=\"history.go(-1);\">
	<input type='submit' class='bouton' value='".$msg['159']."'>
</div>
</form>
";
// $bulletin_replace : form remplacement bulletin
$bulletin_replace = "
<form class='form-".$current_module."' name='bulletin_replace' method='post' action='./catalog.php?categ=serials&sub=bulletin_replace&serial_id=!!serial_id!!&bul_id=!!bul_id!!'>
<h3>".$msg['159']." !!old_bulletin_libelle!! </h3>
<div class='form-contenu'>
	<div class='row'>
		<label class='etiquette' for='par'>".$msg['160']."</label>
	</div>
	<div class='row'>
		<input type='text' class='saisie-50emr' value='' id='bulletin_libelle' name='bulletin_libelle' readonly>
		<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=bulletin&caller=bulletin_replace&param1=by&param2=bulletin_libelle&no_display=!!bul_id!!', 'select_bulletin', 600, 500, -2, -2, 'toolbar=no, dependent=yes, resizable=yes, scrollbars=yes')\" title='".$msg['157']."' value='".$msg['parcourir']."' />
		<input type='button' class='bouton' value='".$msg['raz']."' onclick=\"this.form.bulletin_libelle.value=''; this.form.by.value='0'; \" />
		<input type='hidden' name='by' value=''>
	</div>
	<div class='row'>
	!!del_depouillement!!
	</div>
	!!bulletin_replace_categories!!
	<div class='row'>
		<input type='radio' name='notice_replace_links' value='0' ".($deflt_notice_replace_links==0?"checked='checked'":"")." /> ".$msg['notice_replace_links_option_keep_all']."
		<input type='radio' name='notice_replace_links' value='1' ".($deflt_notice_replace_links==1?"checked='checked'":"")." /> ".$msg['notice_replace_links_option_keep_replacing']."
		<input type='radio' name='notice_replace_links' value='2' ".($deflt_notice_replace_links==2?"checked='checked'":"")." /> ".$msg['notice_replace_links_option_keep_replaced']."
	</div>
</div>

<div class='row'>
	<input type='button' class='bouton' value='".$msg['76']."' onClick=\"history.go(-1);\">
	<input type='submit' class='bouton' value='".$msg['159']."'>
</div>
</form>
";
//	----------------------------------
//	$bul_expl_form1 :form de saisie/modif exemplaire bulletinage

if ($pmb_rfid_activate==1 && $pmb_rfid_serveur_url ) {
	if($pmb_rfid_driver=="ident") $script_erase="init_rfid_erase(rfid_ack_erase);";
	else $script_erase="rfid_ack_erase(1);";
	$rfid_script_bulletine="
		$rfid_js_header
		<script type='text/javascript'>
			var flag_cb_rfid=0;
			flag_program_rfid_ask=0;
			setTimeout(\"init_rfid_read_cb(0,f_expl);\",0);;

			var msg_rfid_programmation_confirmation = '".addslashes($msg['rfid_programmation_confirmation'])."';
			var msg_rfid_etiquette_programmee_message = '".addslashes($msg['rfid_etiquette_programmee_message'])."';

			function program_rfid() {
				flag_semaphore_rfid=1;
				flag_program_rfid_ask=0;
				var cb = document.getElementById('f_ex_cb').value;
				$script_erase
			}
		</script>
		<script type='text/javascript' src='".$base_path."/javascript/rfid.js'></script>
";

	$rfid_program_button="<input  type=button class='bouton_small' value=' ". $msg['rfid_configure_etiquette_button']." ' onClick=\"program_rfid_ask();\">";
}else {
	$rfid_script_bulletine="";
	$rfid_program_button="";
}


$expl_bulletinage_tpl="
$rfid_script_bulletine
<script type='text/javascript'>
<!--

function test_form(form){
	!!questionrfid!!
	if((form.f_ex_cb.value.replace(/^\s+|\s+$/g, '').length == 0) || (form.expl_cote.value.replace(/^\s+|\s+$/g, '').length == 0)){
		alert(\"$msg[304]\");
		return false;
	}

	if (typeof(form.expl_codestat) == 'undefined') {
			alert(\"".$msg["expl_codestat_mandatory"]."\");
			return false;
	}

	return check_form();
}
function calcule_section(selectBox) {
	for (i=0; i<selectBox.options.length; i++) {
		id=selectBox.options[i].value;
		list=document.getElementById(\"docloc_section\"+id);
		list.style.display=\"none\";
	}
	id=selectBox.options[selectBox.selectedIndex].value;
	list=document.getElementById(\"docloc_section\"+id);
	list.style.display=\"block\";
}
-->
</script>

	<h3>$msg[300]</h3>
	<div class='row'>
		<div class='colonne3'>
			<!-- code barre -->
			<label class='etiquette' for='f_ex_cb'>$msg[291]</label>
			<div class='row'>
				<input type='text' class='text' id=\"f_ex_cb\" value='!!cb!!' name='f_ex_cb' >
			</div>
		</div>
		<div class='colonne3'>
			<!-- cote -->
			<label class='etiquette' for='f_ex_cote'>$msg[296]</label>
			<div class='row'>
				<input type='text' class='text' id=\"f_ex_cote\" name='expl_cote' value='!!cote!!' />
			</div>
		</div>
		<div class='colonne3'>
			<!-- type document -->
			<label class='etiquette' for='f_ex_typdoc'>$msg[294]</label>
			<div class='row'>
				!!type_doc!!
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='colonne3'>
			<!-- localisation -->
			<label class='etiquette' for='f_ex_location'>$msg[298]</label>
			<div class='row'>
				!!localisation!!
			</div>
		</div>
		<div class='colonne3'>
			<!-- section -->
			<label class='etiquette' for='f_ex_section'>$msg[295]</label>
			<div class='row'>
				!!section!!
			</div>
		</div>
		<div class='colonne3'>
			<!-- propri�taire -->
			<label class='etiquette' for='f_ex_owner'>$msg[651]</label>
			<div class='row'>
				!!owner!!
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='colonne3'>
			<!-- statut -->
			<label class='etiquette' for='f_ex_statut'>$msg[297]</label>
			<div class='row'>
				!!statut!!
			</div>
		</div>
		<div class='colonne3'>
			<!-- code stat -->
			<label class='etiquette' for='f_ex_cstat'>$msg[299]</label>
			<div class='row'>
				!!codestat!!
			</div>
		</div>
		!!type_antivol!!
	</div>
	<!-- notes -->
	<div class='row'>
		<label class='etiquette' for='f_ex_note'>$msg[expl_message]</label>
	</div>
	<div class='row'>
		<textarea name='expl_note' id='f_ex_note' class='saisie-80em'>!!note!!</textarea>
	</div>
	<div class='row'>
		<label class='etiquette' for='f_ex_comment'>$msg[expl_zone_comment]</label>
	</div>
	<div class='row'>
		<textarea name='expl_comment' id='f_ex_comment' class='saisie-80em'>!!comment!!</textarea>
	</div>
	<!-- prix -->
	<div class='row' id='expl_prix'>
		<label class='etiquette' for='f_ex_prix'>$msg[4050]</label>
	</div>
	<div class='row' id='expl_prix'>
		<input type='text' class='text' name='expl_prix' id='f_ex_prix' value=\"!!prix!!\" />
	</div>
	!!champs_perso!!
	<div class='row'></div>
	<hr />
";
$bul_expl_form1 ="

<form class='form-$current_module' name='expl' id='expl-form' method='post'  enctype='multipart/form-data' action='!!action!!'>
<div class='form-contenu'>

	!!expl_bulletinage_tpl!!

	<h3>".htmlentities($msg['abt_numeric_bulletinage_form'],ENT_QUOTES, $charset)."</h3>
	<div class='row'>

	<label class='etiquette' for='f_filename'>".htmlentities($msg['abt_numeric_bulletinage_form_filename'], ENT_QUOTES,$charset)."</label>
	<br /><input type='text' class='saisie-80em' name='f_filename' id='f_filename' />
	<br /><label class='etiquette' for='f_fichier'>".htmlentities($msg['abt_numeric_bulletinage_form_fichier'], ENT_QUOTES,$charset)."</label>
	<br /><input type='file' size='50' class='saisie-80em' name='f_fichier' id='f_fichier' />
	<br /><label class='etiquette' for='f_url'>".htmlentities($msg['abt_numeric_bulletinage_form_url'], ENT_QUOTES,$charset)."</label>
	<br /><input type='text' class='saisie-80em' name='f_url' id='f_url' />
	<br /><label class='etiquette' for='f_statut'>".htmlentities($msg['abt_numeric_bulletinage_form_statut'], ENT_QUOTES,$charset)."</label>
	<br />!!statut_list!!
	</div>
	<div class='row'></div>

	<hr />
	<h3>$msg[abonnements_titre_donnees_bulletin]</h3>
	<div class='row'>
		<div class='colonne3'>
				<label class='etiquette' for='bul_no'>$msg[4025]</label>
			<div class='row'>
				<input type='text' id='bul_no' name='bul_no' value='!!bul_no!!' class='saisie-20em' />
			</div>
		</div>
		<div class='colonne3'>

			<div class='row'>
			!!destinataire!!
			</div>
		</div>
	</div>
	<div class='row'>
		<div class='row'>
			<label class='etiquette' >$msg[4026]</label>
		</div>
		<div class='row'>
			!!date_date!!
		</div>
	</div>
	<div class='row'>
		<div class='row'>
			<label class='etiquette' >$msg[bulletin_mention_periode]</label>
		</div>
		<div class='row'>
			<input type='text' id='bul_date' name='bul_date' value='!!bul_date!!' class='saisie-50em' />
		</div>
	</div>
	<div class='row'>
		<div class='row'>
			<label class='etiquette' >$msg[bulletin_mention_titre]</label>
		</div>
		<div class='row'>
			<input type='text' id='bul_titre' name='bul_titre' value='!!bul_titre!!' class='saisie-50em' />&nbsp;!!create_notice_bul!!
		</div>
	</div>
</div>
	<div class='left'>
		<input type='submit' class='bouton_small' value=' $msg[77] ' name='bouton_enregistre'  />
		$rfid_program_button
	</div>
	<!-- chams de gestion -->
	<input type=\"hidden\" name=\"expl_bulletin\" value=\"!!bul_id!!\">
	<input type=\"hidden\" name=\"id_form\" value=\"!!id_form!!\">
	<input type=\"hidden\" name=\"org_cb\" value=\"!!org_cb!!\">
	<input type=\"hidden\" name=\"expl_id\" value=\"!!expl_id!!\">

	<input type=\"hidden\" name=\"serial_id\" value=\"!!serial_id!!\">
	<input type=\"hidden\" name=\"numero\" value=\"!!numero!!\">
</form>
!!focus!!
";

$analysis_type_form = "
		<div class='row' id='zone_article'>
		<input type='hidden' name='id_sug' value='!!id_sug!!' />
		<div class='colonne3'>
			<h3>".$msg['acquisition_catal_perio']."</h3>
			<input type=\"radio\" id=\"perio_type_use_existing\"  value=\"use_existing\" name=\"perio_type\"  !!perio_type_use_existing!!><label for=\"perio_type_use_existing\">".$msg["acquisition_catal_perio_exist"]."</label>
			<blockquote>
				<div class='row'>
					<label for='f_perio_existing' class='etiquette'>".$msg[233]."</label>
					<div class='row' >
						<input type='text' completion='perio' autfield='serial_id' id='f_perio_existing' class='saisie-30emr' name='f_perio_existing' value=\"\" />
						<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=perio&caller=notice&param1=serial_id&param2=f_perio_existing&deb_rech='+".pmb_escape()."(this.form.f_perio_existing.value), 'select_perio', 600, 600, -2, -2, '$select1_prop');this.form.f_bull_existing.value=''; this.form.bul_id.value='0'; \" />
						<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_perio_existing.value=''; this.form.serial_id.value='0';this.form.f_bull_existing.value=''; this.form.bul_id.value='0'; \" />
					</div>
				</div>
			</blockquote>
			<input type=\"radio\" id=\"perio_type_new\"  value=\"insert_new\" name=\"perio_type\" !!perio_type_new!!><label for=\"perio_type_new\">".$msg["acquisition_catal_perio_new"]."</label>
			<blockquote>
				<div class='row'>
					<label for='f_perio_new' class='etiquette'>".$msg[233]."</label>
					<div class='row' >
						<input type='text' id='f_perio_new' class='saisie-50em' name='f_perio_new' value=''/>
					</div>
				</div>
				<div class='row'>
					<label for='f_perio_new_issn' class='etiquette'>".$msg["z3950_issn"]."</label>
					<div class='row' >
						<input type='text' id='f_perio_new_issn' class='saisie-50em' name='f_perio_new_issn' value=''/>
					</div>
				</div>
			</blockquote>
		</div>
		<div class='colonne3'>
			<h3>".$msg['acquisition_catal_bull']."</h3>
			<input type=\"radio\" id=\"bull_type_use_existing\" !!bull_type_use_existing!! value=\"use_existing\" name=\"bull_type\"><label for=\"bull_type_use_existing\">".$msg["acquisition_catal_bull_exist"]."</label>
			<blockquote>
				<div class='row'>
					<label for='f_bull_existing' class='etiquette'>".$msg['abonnements_titre_numerotation']."/".$msg[4026]."</label>
					<div class='row' >
						<input type='text' completion='bull' autfield='bul_id' id='f_bull_existing' class='saisie-30emr' name='f_bull_existing' linkfield='serial_id' value=\"\" ' />
						<input type='button' class='bouton' value='$msg[parcourir]' onclick=\"openPopUp('./select.php?what=bulletin&caller=notice&param1=bul_id&param2=f_bull_existing&no_display='+this.form.bul_id.value+'&deb_rech='+".pmb_escape()."(this.form.f_bull_existing.value)+'&idperio='+this.form.serial_id.value, 'select_bull', 600, 600, -2, -2, '$select1_prop')\" />
						<input type='button' class='bouton' value='$msg[raz]' onclick=\"this.form.f_bull_existing.value=''; this.form.bul_id.value='0'; \" />
					</div>
				</div>
			</blockquote>
			<input type=\"radio\" id=\"bull_type_new\" !!bull_type_new!! value=\"insert_new\" name=\"bull_type\"><label for=\"bull_type_new\">".$msg["acquisition_catal_bull_new"]."</label>
			<blockquote>
				<div class='row'>
					<div class='colonne2'>
						<div class='row'>
							<label for='f_bull_new_num' class='etiquette'>".$msg['abonnements_titre_numerotation']."</label>
						</div>
						<div class='row'>
							<input type='text' id='f_bull_new_num' class='saisie-20em' name='f_bull_new_num' value=''/>
						</div>
					 </div>
					 <div class='colonne2'>
						<div class='row' >
							<label for='f_bull_new_titre' class='etiquette'>".$msg[233]."</label>
						</div>
						<div class='row'>
							<input type='text' id='f_bull_new_titre' class='saisie-50em' name='f_bull_new_titre' value='' />
						</div>
					</div>
				</div>
				<div class='row'>
					<div class='colonne2'>
						<div class='row'>
							<label class='etiquette' >$msg[4026]</label>
						</div>
						<div class='row'>
							!!date_date!!
						</div>
					</div>
					<div class='colonne2'>
						<div class='row'>
							<label class='etiquette' >".$msg['bulletin_mention_periode']."</label>
						</div>
						<div class='row'>
							<input type='text' id='f_bull_new_mention' name='f_bull_new_mention' value='' class='saisie-50em' />
						</div>
					</div>
				</div>
			</blockquote>
		</div>
	</div>
";

$perio_replace_categories = "
<div class='row'>&nbsp;</div>
<div class='row'>
	<label class='etiquette' for='keep_categories_label'>".$msg["perio_replace_keep_categories"]."</label>
</div>
<div class='row'>
	".$msg[39]." <input type='radio' name='keep_categories' value='0' checked='checked' onclick=\"document.getElementById('perio_replace_categories').setAttribute('style','display:none;');\" />
	".$msg[40]." <input type='radio' name='keep_categories' value='1' onclick=\"document.getElementById('perio_replace_categories').setAttribute('style','');\" />
</div>
<div class='row'>&nbsp;</div>
<div class='row' id='perio_replace_categories' style='display:none';>
	!!perio_replace_category!!
	<input type='hidden' id='f_nb_categ' name='f_nb_categ' value='!!nb_categ!!' />
</div>
		";
$perio_replace_category = "
<div class='row'>
	<input type='checkbox' id='f_categ!!icateg!!' name='f_categ!!icateg!!' checked='checked' />
	!!categ_libelle!!
	<input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
</div>";

$bulletin_replace_categories = "
<div class='row'>&nbsp;</div>
<div class='row'>
	<label class='etiquette' for='keep_categories_label'>".$msg["bulletin_replace_keep_categories"]."</label>
</div>
<div class='row'>
	".$msg[39]." <input type='radio' name='keep_categories' value='0' checked='checked' onclick=\"document.getElementById('bulletin_replace_categories').setAttribute('style','display:none;');\" />
	".$msg[40]." <input type='radio' name='keep_categories' value='1' onclick=\"document.getElementById('bulletin_replace_categories').setAttribute('style','');\" />
</div>
<div class='row'>&nbsp;</div>
<div class='row' id='bulletin_replace_categories' style='display:none';>
	!!bulletin_replace_category!!
	<input type='hidden' id='f_nb_categ' name='f_nb_categ' value='!!nb_categ!!' />
</div>
		";
$bulletin_replace_category = "
<div class='row'>
	<input type='checkbox' id='f_categ!!icateg!!' name='f_categ!!icateg!!' checked='checked' />
	!!categ_libelle!!
	<input type='hidden' name='f_categ_id!!icateg!!' id='f_categ_id!!icateg!!' value='!!categ_id!!' />
</div>";

// $analysis_move : form d�placement d�pouillement
$analysis_move = "
<form class='form-$current_module' name='analysis_move' method='post' action='./catalog.php?categ=serials&sub=analysis&action=analysis_move&bul_id=!!bul_id!!&analysis_id=!!analysis_id!!'>
<div class='form-contenu'>
<div class='row'>
<label class='etiquette'>".$msg['analysis_move_sel_perio']."</label>
</div>
<div class='row'>
<input type='text' class='saisie-50emr' value='' id='perio_libelle' name='perio_libelle' readonly>
<input class='bouton' type='button' onclick=\"openPopUp('./select.php?what=perio&caller=analysis_move&param1=to_perio&param2=perio_libelle', 'select_perio', 600, 500, -2, -2, 'toolbar=no, dependent=yes, resizable=yes, scrollbars=yes')\" title='".$msg['157']."' value='".$msg['parcourir']."' />
<input type='button' class='bouton' value='".$msg['raz']."' onclick=\"this.form.perio_libelle.value=''; this.form.to_perio.value='0'; \" />
<input type='hidden' id='to_perio' name='to_perio' value='0'>
</div>
<div class='row'>
<label class='etiquette'>".$msg['analysis_move_sel_bull']."</label>
</div>
<div class='row'>
<input type='text' class='saisie-50emr' value='' id='bulletin_libelle' name='bulletin_libelle' readonly>
<input class='bouton' type='button' onclick=\"var idperio=document.getElementById('to_perio').value; if(idperio!=0){ openPopUp('./select.php?what=bulletin&caller=analysis_move&param1=to_bul&param2=bulletin_libelle&idperio='+idperio, 'select_bulletin', 600, 500, -2, -2, 'toolbar=no, dependent=yes, resizable=yes, scrollbars=yes'); }else{ alert('".$msg['analysis_move_sel_perio_choose']."'); }\" title='".$msg['157']."' value='".$msg['parcourir']."' />
<input type='button' class='bouton' value='".$msg['raz']."' onclick=\"this.form.bulletin_libelle.value=''; this.form.to_bul.value='0'; \" />
<input type='hidden' id='to_bul' name='to_bul' value='0'>
</div>

<div class='row'>
<input type='button' class='bouton' value='".$msg['76']."' onClick=\"history.go(-1);\">
<input type='button' class='bouton' value='".$msg['analysis_move_bouton']."' onClick=\"var to_bul=document.getElementById('to_bul').value; if(to_bul!=0){document.forms['analysis_move'].submit();}else{ alert('".$msg['analysis_move_sel_bull_choose']."'); }\">
</div>
</form>
";