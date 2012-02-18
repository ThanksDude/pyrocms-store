<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Tags_m extends MY_Model
{
	protected $_table		= 'store_tags';
	protected $primary_key	= 'tags_id';
	protected $_store;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');
	}
	/**  
	* Add Tag
	* @param array of input
	* @return true or false
	*/	
		public function add_tag($input)
		{
		   $insert_data['name'] =  $input['name'];
		   return $this->db->insert($this->_table, $insert_data) ? $this->db->insert_id() : FALSE;
		}
		
		public function make_tags_list()
		{
			$tags = $this->db->get('store_tags');
		
			if($tags->num_rows() == 0):
		
				return array();
		
			else:
				$this->data  = array();
				foreach($tags->result() as $tag):
					$this->data[$tag->tags_id] = $tag->name;
				endforeach;
		
				return $this->data;
		
			endif;
		
		
		}
		
		public function get_selected_tags($products_id = 0)
		{
			$tags = $this->db
						 ->select('tags_id')
						 ->where('products_id', $products_id)
						 ->get('store_products_has_tags');
			if($tags->num_rows() == 0):
				return array();
			else:
				$this->data = array();
				foreach($tags->result() as $tag):
					$this->data[] = $tag->tags_id;
				endforeach;
				return $this->data;
			endif;
		}
}