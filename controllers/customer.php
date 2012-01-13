<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Customer extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->library('store_settings');

		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('cart');
		$this->load->language('settings');

		$this->load->model('store_m');
		$this->load->model('categories_m');
		$this->load->model('products_m');

		$this->load->helper('date');
		
		$this->template
			 ->append_metadata(css('store.css', 'store'))
			 ->append_metadata(js('store.js', 'store'));
	}

	public function index()
	{
		$this->template
			 ->build('customer/index', $this->data);
	}

	public function purchase_history()
	{
		$this->template
			 ->build('customer/purchase_history', $this->data);
	}

	public function order_status()
	{
		$this->template
			 ->build('customer/order_status', $this->data);
	}

	public function my_downloads()
	{
		$this->template
			 ->build('customer/my_downloads', $this->data);
	}

	public function profile()
	{
		$this->template
			 ->build('customer/profile', $this->data);
	}
}
/* End of file customer.php */
/* Location: ./store/controllers/customer.php */