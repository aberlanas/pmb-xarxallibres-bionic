<?php
// +-------------------------------------------------+
// © 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id$

if (stristr($_SERVER['REQUEST_URI'], ".inc.php")) die("no access");

function f_rellena_ceros($as_dato) {
	if(strlen($as_dato)>0 && strlen($as_dato)<9){
		for($i=strlen($as_dato); $i<9; $i++)
			$as_dato="0".$as_dato;}
	
	return $as_dato; 
}

// gestion des exemplaires
print "<h1>".$msg["dupl_expl_titre"]."</h1>";
$notice = new mono_display($id, 1, './catalog.php?categ=modif&id=!!id!!', FALSE);
print pmb_bidi("<div class='row'><b>".$notice->header."</b><br />");
print pmb_bidi($notice->isbd."</div>");

// XARXA

print "<form action='./bllibres_duplica_exemplar.php' method='get'>
 <p>Ejemplar a duplicar <input type='text' name='expl_id' value=$expl_id /></p>
 <p>Número de copias <input type='text' name='bllibres_num_copias' value='1' /></p>
 <p><input type='submit' value='Crear las copias' /></p>
</form>";

?>
