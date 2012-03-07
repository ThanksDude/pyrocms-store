<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Chris Manouvrier
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
		
		public function get_products_tags($products_id = 0)
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
		
		public function update_products_tags($products_id = 0, $tags)
		{
			$this->delete_products_tags($products_id);
			if($tags):
				foreach($tags as $tag):
					$this->data = array('products_id' =>$products_id,'categories_id'=>'0','tags_id'=>$tag);
					$this->db->insert('store_products_has_tags', $this->data); 
				endforeach;
			endif;
			return TRUE;
			
		}
		
		public function add_products_tags($products_id = 0, $tags)
		{
			if($tags):
				foreach($tags as $tag):
					$this->data = array('products_id' =>$products_id,'categories_id'=>'0','tags_id'=>$tag);
					$this->db->insert('store_products_has_tags', $this->data); 
				endforeach;
			endif;
			return TRUE;
			
		}
		
		
		
		public function delete_products_tags($products_id = 0)
		{
					
			return $this->db
						->where('products_id', $products_id)
						->where('categories_id', 0)
						->delete('store_products_has_tags');
		}
}