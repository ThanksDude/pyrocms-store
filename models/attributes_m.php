<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Attributes_m extends MY_Model
{
	protected $_table		= 'store_attributes';
	protected $primary_key	= 'attributes_id';
	protected $_store;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');
	}
	/**  
	 * Add Attribute
     	* @param array of input
     	* @return true or false
     	*/	
	public function add_attribute($input)
	{
	   $insert_data['name'] =  $input['name'];
	   $insert_data['html'] =  $input['html'];
	   return $this->db->insert($this->_table, $insert_data) ? $this->db->insert_id() : FALSE;
	}
	
	public function make_attributes_list()
		{
			$attributes = $this->db->get('store_attributes');
		
			if($attributes->num_rows() == 0):
		
				return array();
		
			else:
				$this->data  = array();
				foreach($attributes->result() as $attribute):
					$this->data[$attribute->attributes_id] = $attribute->name;
				endforeach;
		
				return $this->data;
		
			endif;
		
		
		}
	
}