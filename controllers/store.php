<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Store extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->library('store_settings');

		$this->load->language('general');
		$this->load->language('products');
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
	  $i = $this->store_settings->item('sell_method');

	  if ( isset($i) && (strcmp($i, "1") == 0) ):
	    redirect('store/categories/explore/top/tiles');
	  else:
	    redirect('store/categories/browse/top/tiles');
	  endif;
	}
}