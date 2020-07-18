<?php
// +-------------------------------------------------+
// � 2002-2004 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: search_persopac.class.php,v 1.17 2017-02-08 13:41:40 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

// classes de gestion des recherches personnalis�es

// inclusions principales
require_once("$include_path/templates/search_persopac.tpl.php");
require_once("$class_path/search.class.php");
require_once("$class_path/translation.class.php");

class search_persopac {
	public $id=0;
	public $name="";
	public $shortname="";
	public $query="";
	public $human="";
	public $directlink="";
	public $limitsearch="";
	public $order;
	public $empr_categ_restrict = array();
	
	// constructeur
	public function __construct($id=0) {	
		$this->id = $id+0;
		if($this->id) {
			$this->fetch_data();
		}else $this->get_link();
	}
    
	// r�cup�ration des infos en base
	public function fetch_data() {
		$result = pmb_mysql_query("SELECT * FROM search_persopac WHERE search_id='".$this->id."'");
		$row= pmb_mysql_fetch_object($result);
		$this->name=translation::get_text($this->id,"search_persopac","search_name",$row->search_name);
		$this->shortname=translation::get_text($this->id,"search_persopac","search_shortname",$row->search_shortname);	
		$this->query=$row->search_query;
		$this->human=$row->search_human;
		$this->directlink=$row->search_directlink;
		$this->limitsearch=$row->search_limitsearch;
	
		$this->empr_categ_restrict = array();
		$query  = "select id_categ_empr from search_persopac_empr_categ where id_search_persopac = ".$this->id;
		$result = pmb_mysql_query($query);
		if(pmb_mysql_num_rows($result)){
			while ($row = pmb_mysql_fetch_object($result)){
				$this->empr_categ_restrict[]=$row->id_categ_empr;
			}
		}
	}

	public function get_link() {
		global $onglet_persopac,$launch_search;	
		global $opac_view_filter_class;
		$myQuery = pmb_mysql_query("SELECT search_persopac.*, group_concat(id_categ_empr) as categ_restrict FROM search_persopac left join search_persopac_empr_categ on id_search_persopac = search_id group by search_id order by search_order, search_name ");
		
		$this->search_persopac_list=array();
		$link="";
		$forms_search="";
		if(pmb_mysql_num_rows($myQuery)){
			$i=0;
			//on r�cup�re la cat�gorie du lecteur...
			if($_SESSION['id_empr_session']){
				$req = "select empr_categ from empr where id_empr = ".$_SESSION['id_empr_session'];
				$res =pmb_mysql_query($req);
				if(pmb_mysql_num_rows($res)){
					$empr_categ = pmb_mysql_result($res,0,0);
				}else $empr_categ = 0;
			}else $empr_categ = 0;
			while(($r=pmb_mysql_fetch_object($myQuery))) {	
				if($opac_view_filter_class){
					if(!$opac_view_filter_class->is_selected("search_perso", $r->search_id))  continue; 
				}
				$empr_categ_restrict = ($r->categ_restrict != '' ? explode(",",$r->categ_restrict) : array());
				if(count($empr_categ_restrict) == 0 || in_array($empr_categ,$empr_categ_restrict)){
					$name=translation::get_text($r->search_id,"search_persopac","search_name",$r->search_name);	
					$shortname=translation::get_text($r->search_id,"search_persopac","search_shortname",$r->search_shortname);				
					if($r->search_directlink) {					
						if($shortname)$libelle=$shortname;
						else $libelle=$name;
						$my_search=new search();
						$backup_search=$my_search->serialize_search();
						$my_search->unserialize_search($r->search_query);
						$forms_search.= "\n".$my_search->make_hidden_search_form("./index.php?search_type_asked=extended_search&onglet_persopac=".$r->search_id."&limitsearch=".$r->search_limitsearch,"search_form".$r->search_id)."\n";
						$my_search->destroy_global_env();
						$my_search->unserialize_search($backup_search);
						if($onglet_persopac==$r->search_id) {
							$li_id=" id='current' ";
							$lien="<a href=\"javascript:document.forms['search_form".$r->search_id."'].submit();\">".$libelle."</a>";
						} else {
							$li_id="";
							$lien="<a href=\"javascript:document.forms['search_form".$r->search_id."'].submit();\">".$libelle."</a>";
						}
						$link.="
							<li $li_id >
								$lien	
							</li>";
					}
					$this->search_persopac_list[$i] = new stdClass();		
					$this->search_persopac_list[$i]->id=$r->search_id;
					$this->search_persopac_list[$i]->name=$name;
					$this->search_persopac_list[$i]->shortname=$shortname;
					$this->search_persopac_list[$i]->query=$r->search_query;
					$this->search_persopac_list[$i]->human=$r->search_human;
					$this->search_persopac_list[$i]->directlink=$r->search_directlink;	
					$this->search_persopac_list[$i]->limitsearch=$r->search_limitsearch;				
					$i++;
				}			
			}	
		}
		$this->directlink_user=$link;
		$this->directlink_user_form=$forms_search;
		return true;
	}

	// fonction g�n�rant le form de saisie 
	public function do_list() {
		global $tpl_search_persopac_liste_tableau,$tpl_search_persopac_liste_tableau_ligne;
		// liste des lien de recherche directe
		$liste="";
		// pour toute les recherche de l'utilisateur
		$my_search=new search();
		for($i=0;$i<count($this->search_persopac_list);$i++) {
			if ($i % 2) $pair_impair = "even"; else $pair_impair = "odd";      
			//composer le formulaire de la recherche
			$my_search->unserialize_search($this->search_persopac_list[$i]->query);
			$forms_search.= $my_search->make_hidden_search_form("./index.php?search_type_asked=extended_search&limitsearch=".$this->search_persopac_list[$i]->limitsearch,"search_form".$this->search_persopac_list[$i]->id);
			
	        $td_javascript="  onmousedown=\"javascript:document.forms['search_form".$this->search_persopac_list[$i]->id."'].submit();\" ";	
	        $tr_surbrillance = "onmouseover=\"this.className='surbrillance'\" onmouseout=\"this.className='".$pair_impair."'\" ";
	
	        $line = str_replace('!!td_javascript!!',$td_javascript , $tpl_search_persopac_liste_tableau_ligne);
	        $line = str_replace('!!tr_surbrillance!!',$tr_surbrillance , $line);
	        $line = str_replace('!!pair_impair!!',$pair_impair , $line);
	
			$line =str_replace('!!id!!', $this->search_persopac_list[$i]->id, $line);
			$line = str_replace('!!name!!', $this->search_persopac_list[$i]->name, $line);
			$line = str_replace('!!human!!', $this->search_persopac_list[$i]->human, $line);		
			$line = str_replace('!!shortname!!', $this->search_persopac_list[$i]->shortname, $line);
			
			$liste.=$line;
		}
		 
		$tpl_search_persopac_liste_tableau = str_replace('!!lignes_tableau!!',$liste , $tpl_search_persopac_liste_tableau);
		return $forms_search.$tpl_search_persopac_liste_tableau;	
	}

	public function get_forms_list() {
	
		$my_search=new search();
		$forms_search='';
		$links='';
		for($i=0;$i<count($this->search_persopac_list);$i++) {
			//composer le formulaire de la recherche
			$my_search->unserialize_search($this->search_persopac_list[$i]->query);
			$forms_search.= $my_search->make_hidden_search_form("./index.php?search_type_asked=extended_search&limitsearch=".$this->search_persopac_list[$i]->limitsearch,"search_form".$this->search_persopac_list[$i]->id);
			$libelle= $this->search_persopac_list[$i]->name;
			$links.="
				<span>
					<a href=\"javascript:document.forms['search_form".$this->search_persopac_list[$i]->id."'].submit();\">$libelle</a>
					</span><br/>";
		}
		return $forms_search.$links;
	}

} // fin d�finition classe
