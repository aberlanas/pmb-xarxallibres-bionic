<?php
// +-------------------------------------------------+
// | 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: frbr_entity_works_datasource_performers.class.php,v 1.2 2017-06-02 09:52:43 tsamson Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class frbr_entity_works_datasource_performers extends frbr_entity_common_datasource {
	
	public function __construct($id=0){
		$this->entity_type = 'authors';
		parent::__construct($id);
	}
	
	/*
	 * R�cup�ration des donn�es de la source...
	 */
	public function get_datas($datas=array()){
		$query = "select distinct responsability_tu_author_num as id, responsability_tu_num as parent FROM responsability_tu
			WHERE responsability_tu_type = 1 AND responsability_tu_num IN (".implode(',', $datas).")";
		$datas = $this->get_datas_from_query($query);
		$datas = parent::get_datas($datas);
		return $datas;
	}
}