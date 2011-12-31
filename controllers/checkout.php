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

	public function __construct(){

		parent::__construct();

		// Load the required classes
		$this->load->library('cart');
		$this->load->library('store_settings');
		$this->load->library('merchant');
		
		$this->load->model('store_m');
		$this->load->model('checkout_m');
		
		$this->load->language('store');
		
		$this->load->helper('date');
		
		$this->template->append_metadata(css('store.css', 'store'))
						->append_metadata(js('store.js', 'store'));
	}
	
	public function index()
	{
		
	}
	
	public function process($gateway,$orders_id)
	{
		$this->orders = $this->store_m->get_order($orders_id);
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
						'return'			=> site_url('/store/checkout/status/paypal/success/' . $this->order->orders_id . '/'),
						'cancel_return'		=> site_url('/store/checkout/status/paypal/failure/' . $this->order->orders_id . '/'),
						'notify_url'		=> site_url('/store/checkout/ipn/paypal/' . $this->order->orders_id . '/'),
						'amount'			=> $this->order->amount,
						'reference'			=> $this->order->orders_id
					));
				}

				$this->merchant->process_return();

			break;
		
		endswitch;
	}
	
	public function ipn($gateway,$orders_id){
		
		switch($gateway):
		
			case 'paypal':
			
				
				
			break;
		
		endswitch;
	}
	
	public function status($gateway,$status,$order_id)
	{	
		switch($gateway):
		
			case 'paypal':
				
				switch($status):
				
					case 'success':
					
						$this->merchant->process_return();
						$this->checkout_m->status_update($order_id,TRUE);
					
					break;
					
					case 'failure':
						
						$this->merchant->process_return();
						$this->checkout_m->status_update($order_id,FALSE);
						
					break;
				
				endswitch;
				
			break;
			
		endswitch;
	}	
}