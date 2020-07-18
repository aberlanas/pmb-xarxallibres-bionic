<?php
// +-------------------------------------------------+
// � 2002-2011 PMB Services / www.sigb.net pmb@sigb.net et contributeurs (voir www.sigb.net)
// +-------------------------------------------------+
// $Id: onto_common_class.class.php,v 1.2 2017-02-08 17:50:25 tsamson Exp $

if (stristr($_SERVER['REQUEST_URI'], ".class.php")) die("no access");

require_once $class_path.'/onto/common/onto_common_root.class.php';
require_once $class_path.'/onto/onto_ontology.class.php';
require_once $class_path.'/onto/common/onto_common_property.class.php';
require_once $class_path.'/onto/onto_restriction.class.php';


/**
 * class onto_common_class
 * 
 */
class onto_common_class extends onto_common_root {

	/** Aggregations: */

	/** Compositions: */

	 /*** Attributes: ***/

	/**
	 * 
	 * @access protected
	 */
	protected $properties;

	/**
	 * Tableau associatif des restrictions associ�es � chaque propri�t� de la classe.
	 * L'�tiquette du tableau est l'URI de la propri�t� concern�e
	 * @access private
	 */
	private $onto_restrictions;

	/**
	 * 
	 *
	 * @param onto_ontology ontology 

	 * @return void
	 * @access public
	 */
	
	public $pmb_name; 
	
	public function __construct($uri,$ontology) {
		parent::__construct($uri,$ontology);	
		$this->get_properties();
		$this->get_restrictions();
	} // end of member function __construct

	/**
	 * Retourne la liste des URI de propri�t�s li�es � la classe
	 *
	 * @return array()
	 * @access public
	 */
	public function get_properties( ) {
		$properties = $this->ontology->get_class_properties($this->uri);
		foreach($properties as $property_uri){
			$this->set_property($this->get_property($property_uri));
		}
		return $properties;
	} // end of member function get_properties

	/**
	 * Retourne une instance de la propri�t�
	 *
	 * @param string uri_property uri de la propri�t�

	 * @return onto_common_property
	 * @access public
	 */
	public function get_property( $uri_property ) {
		return $this->ontology->get_property($this->uri,$uri_property);
	} // end of member function get_property

	/**
	 * 
	 *
	 * @param onto_common_property property objet repr�sentant une propri�t�

	 * @return void
	 * @access public
	 */
	public function set_property( $property ) {
		$this->properties[$property->uri] = $property;
	} // end of member function set_property
	
	public function set_pmb_name($pmb_name){
		$this->pmb_name = $pmb_name;
	}
	
	protected function fetch_label(){
		$this->label = $this->ontology->get_class_label($this->uri);
	}
	
	public function get_restrictions(){
		foreach($this->properties as $property){			
			$this->onto_restrictions[$property->uri] = $this->ontology->get_restriction($this->uri,$property->uri);
		}
	}
	
	public function get_property_range($uri_property) {
		$range = array();
		if (isset($this->properties[$uri_property])) {
			$range = $this->properties[$uri_property]->range;
		}
		
		return $range;
	}
	
	public function get_property_pmb_datatype($uri_property) {
		$pmb_datatype = $this->properties[$uri_property]->pmb_datatype;
		return $pmb_datatype;
	}
	
	
	/**
	 *
	 *
	 * @param string  uri_property URI d'une propri�t�
	
	 * @return onto_restriction
	 * @access public
	 */
	public function get_restriction($uri_property){
		return $this->onto_restrictions[$uri_property];
	}
	
	public function get_base_uri(){
		global $opac_url_base;
		return $opac_url_base."/".$this->pmb_name."#";
	}
} // end of onto_common_class