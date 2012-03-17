<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author     	Antoine Benevaut
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Auctions_m extends MY_Model
{
	protected $_table	= 'store_auctions';
	protected $images_path	= 'uploads/store/auctions/';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('store/store_settings');
		$this->_store = $this->store_settings->item('store_id');
		
		$this->load->model('store/images_m');
		$this->load->model('files/file_m');
	}

	public function update_auction($auctions_id, $new_image_id=0)
	{
		$this->data = $this->input->post();
		array_pop($this->data);
		unset($this->data['userfile']);
		$this->data['slug'] = str_replace(' ', '-', $this->data['name']);
		
		if(!($new_image_id == 0)):

			$auction = $this->get_auction($auctions_id);
			$this->images_m->delete_image($auction->images_id, $this->images_path);
			$this->data['images_id'] = $new_image_id;

		endif;

		return $this->db
					->where('auctions_id', $auctions_id)
					->update($this->_table, $this->data);
	}

	public function add_auction($new_image_id=0)
	{
		$this->data = $this->input->post();
		array_pop($this->data);
		unset($this->data['userfile']);
		$this->data['slug'] = str_replace(' ', '-', $this->data['name']);
		$this->data['start_at'] = strtotime($this->data['start_at']);
		$this->data['end_at'] = strtotime($this->data['end_at']);
		$this->data['images_id'] = $new_image_id;

		return $this->db->insert($this->_table, $this->data) ? $this->db->insert_id() : FALSE;
	}

	public function delete_auction($auctions_id)
	{
		$auction = $this->get_auction($auctions_id);

		$this->images_m->delete_image($auction->images_id, $this->images_path);

		return $this->db
					->where('auctions_id', $auctions_id)
					->delete($this->_table);
	}

	public function count_auctions($categories_id)
	{
		return $this->count_by('categories_id', $categories_id);
	}

	public function end_auction($auctions_id)
	{
	  $this->data = array('is_active'=>0);
	  
	  return $this->db
	    ->where('auctions_id', $auctions_id)
	    ->update($this->_table, $this->data);
	}

	public function set_auction_winner($auctions_id, $bid_id)
	{
	  $this->data = array('winning_bid_id' => $bid_id);
	  
	  return $this->db
	    ->where('auctions_id', $auctions_id)
	    ->update($this->_table, $this->data);
	}


	public function get_auctions($categories_id)
	{
		return $this->db
					->where('categories_id', $categories_id)->get($this->_table)
					->result();
	}

	public function get_auction($auctions_id)
	{
		return $this->db
					->where('auctions_id', $auctions_id)
					->limit(1)
					->get($this->_table)
					->row();
	}

	public function get_auction_attributes($attributes)
	{
		$this->db->where('attributes_id',$attributes);
		$this->query = $this->db->get('store_attributes');
		
		foreach($this->query->result() as $this->attribute):

			$this->result = array();
			$this->items = explode("|", $this->attribute->html);
			
			foreach($this->items as $this->item):

				$this->temp = explode("=", $this->item);
				$this->result[$this->temp[0]] = $this->temp[1];

			endforeach;

			return $this->result;

		endforeach;
	}

	public function build_order()
	{
		$this->data = array(
			'users_id'			=>	$this->user->id,
			'invoice_nr'		=>	rand(1, 100),
			'ip_address'		=>	$this->input->ip_address(),
			'telefone'			=>	'0',
			'status'			=>	'0',
			'comments'			=>	'0',
			'date_added'		=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			'date_modified'		=>	mdate("%Y-%m-%d %H:%i:%s",time()),
			'payment_address'	=>	'0',
			'shipping_address'	=>	'0',
			'payment_method'	=>	'0',
			'shipping_method'	=>	'0',
			'tax'				=>	'0',
			'shipping_cost'		=>	'0',
		);

		$this->db->insert('store_orders',$this->data);
		$this->order_id = $this->db->insert_id();

		foreach($this->cart->contents() as $items):

			$this->data = array(
				'orders_id'		=>	$this->order_id,
				'users_id'		=>	$this->user->id,
				'auctions_id'	=>	$items['id'],
				'number'		=>	$items['qty']
			);

			$this->db->insert('store_orders_has_store_auctions',$this->data);

		endforeach;

		redirect('/store/checkout/process/' . $this->input->post('gateway') . '/' . $this->order_id . '/');
	}

	public function get_order($orders_id)
	{
		return $this->db
					->where('orders_id',$orders_id)
					->get('store_orders_has_store_auctions');
	}

	public function get_orders_auction_name($orders_id)
	{
		foreach($this->db->where('orders_id',$orders_id)->limit(1)->get('store_orders_has_store_auctions')->result() as $this->order):

			foreach($this->db->where('auctions_id',$this->order->auctions_id)->get('store_auctions')->result() as $this->auction):

				return $this->auction->name;

			endforeach;

		endforeach;
	}

	public function get_orders_auction_price($orders_id)
	{
		foreach($this->db->where('orders_id',$orders_id)->limit(1)->get('store_orders_has_store_auctions')->result() as $this->order):

			foreach($this->db->where('auctions_id',$this->order->auctions_id)->get('store_auctions')->result() as $this->auction):

				return $this->auction->price;

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