<?php
// +-------------------------------------------------+
// � 2002-2012 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: frbr_entity_publishers_view_publisherslist.class.php,v 1.2 2017-05-16 09:00:44 dgoron Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

class frbr_entity_publishers_view_publisherslist extends frbr_entity_common_view_django{
	
	
	public function __construct($id=0){
		parent::__construct($id);
		$this->default_template = "<div>
{% for publisher in publishers %}
<h3>{{publisher.name}}</h3>
<blockquote>{{publisher.comment}}</blockquote>
{% endfor %}
</div>";
	}
		
	public function render($datas){	
		//on rajoute nos �l�ments...
		//le titre
		$render_datas = array();
		$render_datas['title'] = $this->msg["frbr_entity_publishers_view_publisherslist_title"];
		$render_datas['publishers'] = array();
		if(is_array($datas)){
			foreach($datas as $publisher_id){
				$publisher = new editeur($publisher_id);
				$infos= $publisher->format_datas();
				$render_datas['publishers'][]=$infos;
			}
		}
		//on rappelle le tout...
		return parent::render($render_datas);
	}
	
	public function get_format_data_structure(){		
		$format = array();
		$format[] = array(
			'var' => "title",
			'desc' => $this->msg['frbr_entity_publishers_view_title']
		);
		$publishers = array(
			'var' => "publishers",
			'desc' => $this->msg['frbr_entity_publishers_view_publishers_desc'],
			'children' => $this->prefix_var_tree(editeur::get_format_data_structure(),"publishers[i]")
		);
		$format[] = $publishers;
		$format = array_merge($format,parent::get_format_data_structure());
		return $format;
	}
}