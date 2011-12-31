<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Checkout_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
	}

	public function status_update($order_id = NULL,$status = NULL)
	{
		
		if($order_id != NULL && $status != NULL):
		
			$this->data = array('status' => $status);
			$this->db->where('orders_id', $order_id);
			$this->db->update('store_orders',$this->data);
			
			return TRUE;
		
		else:
		
			return FALSE;
		
		endif;
		
	}

	public function ipn_update($order_id = NULL,$status = NULL)
	{
		
		if($order_id != NULL && $status != NULL):
		
			$this->data = array('status' => $status);
			$this->db->where('orders_id', $order_id);
			$this->db->update('store_orders',$this->data);
			
			return TRUE;
		
		else:
		
			return FALSE;
		
		endif;
		
	}
}