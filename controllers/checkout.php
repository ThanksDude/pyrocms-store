<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Checkout extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->library('store_settings');
		$this->load->library('merchant');

		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('cart');
		$this->load->language('settings');

		$this->load->model('store_m');
		$this->load->model('products_m');
		$this->load->model('checkout_m');

		$this->load->helper('date');

		$this->template
			 ->append_metadata(css('store.css', 'store'))
			 ->append_metadata(js('store.js', 'store'));
	}

	public function index()
	{
		
	}

	public function purchase()
	{
		
	}

	public function review()
	{
		
	}

	public function confirmation()
	{
		
	}

	public function process($gateway,$orders_id)
	{
		$this->orders = $this->products_m->get_order($orders_id);
		switch($gateway):
		
			case 'paypal':
			
				$this->merchant->load('paypal');
				
				if($this->store_settings->item('paypal_developer_mode') == 1):
				
					$this->merchant->initialize(array(
						'paypal_email'	=>	$this->store_settings->item('paypal_account'),
						'test_mode'		=>	TRUE
					));
					
				else:
				
					$this->merchant->initialize(array(
						'paypal_email'	=>	$this->store_settings->item('paypal_account'),
						'test_mode'		=>	FALSE
					));
					
				endif;
				
				foreach($this->orders->result() as $this->order)
				{
					$this->merchant->process(array(
						'currency_code'		=> $this->store_settings->currency(),
						'return_url'		=> site_url('/store/checkout/status/paypal/success/' . $this->order->orders_id . '/'),
						'cancel_url'		=> site_url('/store/checkout/status/paypal/failure/' . $this->order->orders_id . '/'),
						'notify_url'		=> site_url('/store/checkout/ipn/paypal/' . $this->order->orders_id . '/'),
						'amount'			=> $this->order->amount,
						'reference'			=> $this->order->orders_id
					));
				}

			break;
		
		endswitch;
	}
	
	public function ipn($gateway,$orders_id){
		
		switch($gateway):
		
			case 'paypal':
			
				$action = $this->CI->input->get('action', TRUE);
				if($action === FALSE):
				
					$this->checkout_m->ipn_update($orders_id,'2');
					
				elseif($action === 'success'):
				
					$this->checkout_m->ipn_update($orders_id,'4');
					
				elseif($action === 'cancel'):
				
					$this->checkout_m->ipn_update($orders_id,'2');
					
				endif;
				
			break;
		
		endswitch;
	}
	
	public function status($gateway,$status,$order_id)
	{	
		switch($gateway):
		
			case 'paypal':
			
				$this->merchant->load('paypal');
				
				switch($status):
				
					case 'success':
					
						$this->checkout_m->status_update($order_id, '3');
					
					break;
					
					case 'failure':
						
						$this->checkout_m->status_update($order_id, '2');
						
					break;
				
				endswitch;
				
			break;
			
		endswitch;
	}	
}