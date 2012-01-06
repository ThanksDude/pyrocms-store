<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Categories_m extends MY_Model
{
	protected $_table		= 'store_categories';
	protected $primary_key	= 'categories_id';
	protected $_store;
	protected $images_path	= 'uploads/store/categories/';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');
	}

	public function make_categories_dropdown($categories_id=0)
	{
		$categories = $this->db->get('store_categories');
		$selected_cat;
		$parent_cat;

		if($categories_id):

			$selected_cat = $this->categories_m->get($categories_id);
			$parent_cat = $this->categories_m->get($selected_cat->parent_id);

		endif;

		if($categories->num_rows() == 0):

			return array();

		else:

			if(isset($parent_cat) && $parent_cat ):

				$this->data = array( $parent_cat->categories_id => $parent_cat->name);

				foreach($categories->result() as $category):

					if(!( $parent_cat->name == $category->name || $selected_cat->name == $category->name ) ):

						$this->data[$category->categories_id] = $category->name;

					endif;

				endforeach;

				return $this->data;

			else:

				$this->data  = array('0'=>'Select');
				foreach($categories->result() as $category):

					if(isset($selected_cat)):

						if(!($category->name == $selected_cat->name)):

							$this->data[$category->categories_id] = $category->name;

						endif;

					else:

						$this->data[$category->categories_id] = $category->name;

					endif;

				endforeach;

				return $this->data;

			endif;

		endif;

	}

	public function add_category($new_image_id)
	{
		$this->data = $this->input->post();
		array_pop($this->data);
		unset($this->data['userfile']);
		$this->data['slug'] = str_replace(' ', '-', $this->data['name']);

		if ($new_image_id):

			$this->data['images_id'] = $new_image_id;

		endif;

		return $this->db->insert($this->_table, $this->data) ? $this->db->insert_id() : false;

	}

	public function update_category($categories_id, $new_image_id=0)
	{
		$this->data = $this->input->post();
		array_pop($this->data);
		unset($this->data['userfile']);

		$this->data['slug'] = str_replace(' ', '-', $this->data['name']);

		if(!($new_image_id == 0)):

			$category = $this->get_category($categories_id);

			$this->images_m->delete_image($category->images_id, $this->images_path);

			$this->data['images_id'] = $new_image_id;

		endif;

		return $this->db
					->where('categories_id', $categories_id)
					->update($this->_table, $this->data);
	}

	public function get_category($categories_id)
	{
		return $this->db
					->where('categories_id', $categories_id)
					->limit(1)
					->get($this->_table)
					->row();
	}

	public function get_category_by_name($category_name)
	{
		return $this->db
					->where('name', $category_name)
					->limit(1)
					->get($this->_table)
					->row();
	}

	public function delete_category($categories_id)
	{
		$category = $this->get_category($categories_id);

		$this->images_m->delete_image($category->images_id, $this->images_path);

		return $this->db
					->where('categories_id', $categories_id)
					->delete($this->_table);
	}

	public function get_category_name($categories_id)
	{
		return $this->db
					->where('categories_id', $categories_id)
					->limit(1)
					->get($this->_table)
					->row();
	}
}