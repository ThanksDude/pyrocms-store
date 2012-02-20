<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Products_m extends MY_Model
{
	protected $_table		= 'store_products';
	protected $images_path	= 'uploads/store/products/';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');
		
		$this->load->model('images_m');
		$this->load->model('files/file_m');
		$this->load->model('tags_m');

	}

	public function update_product($products_id, $new_image_id=0)
	{
		$this->data = $this->input->post();
		array_pop($this->data);
		unset($this->data['userfile']);
		$this->data['slug'] = str_replace(' ', '-', $this->data['name']);
		
		if(isset($this->data['tags_id'])):
			$this->tags_m->update_products_tags($products_id, $this->data['tags_id']);
			unset($this->data['tags_id']);
		else:
			$this->tags_m->delete_products_tags($products_id);
		endif;
		
		if(!($new_image_id == 0)):

			$product = $this->get_product($products_id);
			$this->images_m->delete_image($product->images_id, $this->images_path);
			$this->data['images_id'] = $new_image_id;

		endif;

		return $this->db
					->where('products_id', $products_id)
					->update($this->_table, $this->data);
	}

	public function add_product($new_image_id=0)
	{
		$this->data = $this->input->post();
		array_pop($this->data);
		unset($this->data['userfile']);
		$this->data['slug'] = str_replace(' ', '-', $this->data['name']);
		$this->data['images_id'] = $new_image_id;
		
		
		if(isset($this->data['tags_id'])):
			$products_tags = $this->data['tags_id'];
			unset($this->data['tags_id']);
			$products_id = $this->db->insert($this->_table, $this->data) ? $this->db->insert_id() : FALSE;
			$this->tags_m->add_products_tags($products_id, $products_tags);
		else:
			$products_id = $this->db->insert($this->_table, $this->data) ? $this->db->insert_id() : FALSE;
		endif;
		
		return $products_id;
	}

	public function delete_product($products_id)
	{
		$product = $this->get_product($products_id);

		$this->images_m->delete_image($product->images_id, $this->images_path);

		return $this->db
					->where('products_id', $products_id)
					->delete($this->_table);
	}

	public function make_categories_dropdown($selected_id=0)
	{
		$this->load->model('categories_m');
		$categories = $this->db->get('store_categories');
		if($selected_id):

			$selected_cat = $this->categories_m->get($selected_id);

		endif;

		if($categories->num_rows() == 0):

		  	return array();

		else:

			if(isset($selected_cat)):

				$data  = array( $selected_cat->categories_id => $selected_cat->name);

			else:

				$data  = array('0'=>'Select');

			endif;

			foreach($categories->result() as $category):

				if(isset($selected_cat)):

					if(!($selected_cat->name == $category->name)):

						$data[$category->categories_id] = $category->name;

					endif;

				else:

					$data[$category->categories_id] = $category->name;

				endif;

			endforeach;

		endif;

		return $data;
	}

	public function make_attributes_dropdown($selected_id=0)
	{
		$this->load->model('attributes_m');
		$attributes = $this->db->get('store_attributes');
		if($selected_id):

			$selected_cat = $this->attributes_m->get($selected_id);

		endif;

		if($attributes->num_rows() == 0):

		  	return array();

		else:

			if(isset($selected_cat)):

				$data  = array( $selected_cat->attributes_id => $selected_cat->name);

			else:

				$data  = array('0'=>'Select');

			endif;

			foreach($attributes->result() as $attribute):

				if(isset($selected_cat)):

					if(!($selected_cat->name == $attribute->name)):

						$data[$attribute->attributes_id] = $attribute->name;

					endif;

				else:

					$data[$attribute->attributes_id] = $attribute->name;

				endif;

			endforeach;

		endif;

		return $data;
	}

	public function count_products($categories_id)
	{
		return $this->count_by('categories_id', $categories_id);
	}

	public function get_products($categories_id)
	{
		return $this->db
					->where('categories_id', $categories_id)->get($this->_table)
					->result();
	}

	public function get_product($products_id)
	{
		return $this->db
					->where('products_id', $products_id)
					->limit(1)
					->get($this->_table)
					->row();
	}

	public function get_product_in_cart($products_id,$options)
	{
		$product = $this->db
						->where('products_id', $products_id)
						->limit(1)
						->get('store_products')->row();

		$this->items = array(
				'id'      => $product->products_id,
				'qty'     => $this->input->post('qty'),
				'price'   => $product->price,
				'name'    => $product->name,
				'options' => $options
		);

		return $this->items;
	}
	
	public function get_product_attributes($attributes)
	{
		$this->db->where('attributes_id',$attributes);
		$this->query = $this->db->get('store_attributes');
		
		foreach($this->query->result() as $this->attribute):
			$this->data = array();
			$this->data['name'] = $this->attribute->name;
			$this->data['options'] = array();
			$this->items = explode("|", $this->attribute->html);
			
			foreach($this->items as $this->item):

				$this->temp = explode("=", $this->item);
				$this->data['options'][$this->temp[0]] = $this->temp[1];

			endforeach;

			return $this->data;

		endforeach;
	}

	public function build_order($gateway)
	{
		$this->data = array(
			'users_id'			=>	$this->current_user->id,
			'invoice_nr'		=>	rand(1, 100),
			'ip_address'		=>	$this->input->ip_address(),
			'status'			=>	'0',
			'comments'			=>	'0',
			'date_added'		=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			'date_modified'		=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			'payment_method'	=>	'0',
			'payment_address'	=>	'0',
			'shipping_method'	=>	'0',
			'shipping_address'	=>	'0',
			'shipping_cost'		=>	'0',
			'amount'			=>	$this->cart->total(),
		);

		$this->db->insert('store_orders',$this->data);
		$this->order_id = $this->db->insert_id();

		foreach($this->cart->contents() as $items):

			$this->data = array(
				'orders_id'		=>	$this->order_id,
				'users_id'		=>	$this->current_user->id,
				'products_id'	=>	$items['id'],
				'number'		=>	$items['qty']
			);

			$this->db->insert('store_orders_has_products',$this->data);

		endforeach;

		redirect('/store/checkout/process/' . $gateway . '/' . $this->order_id . '/');
	}

	public function get_order($orders_id)
	{
		return $this->db
					->where('orders_id',$orders_id)
					->get('store_orders');
	}

	public function get_orders_product_name($orders_id)
	{
		foreach($this->db->where('orders_id',$orders_id)->limit(1)->get('store_orders_has_products')->result() as $this->order):

			foreach($this->db->where('products_id',$this->order->products_id)->get('store_products')->result() as $this->product):

				return $this->product->name;

			endforeach;

		endforeach;
	}

	public function get_orders_product_price($orders_id)
	{
		foreach($this->db->where('orders_id',$orders_id)->limit(1)->get('store_orders_has_products')->result() as $this->order):

			foreach($this->db->where('products_id',$this->order->products_id)->get('store_products')->result() as $this->product):

				return $this->product->price;

			endforeach;

		endforeach;
	}

	public function get_orders_users($users_id)
	{
		foreach($this->db->where('id',$users_id)->limit(1)->get('users')->result() as $this->item):

			return $this->item->username;

		endforeach;
	}
}