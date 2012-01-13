<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Search extends Public_Controller
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
		redirect('store/categories/browse/top/tiles');
	}

	public function query()
	{
		$this->template
			 ->build('search/query', $this->data);
	}

	public function results()
	{
		$this->template
			 ->build('search/results', $this->data);
	}
}
/* End of file search.php */
/* Location: ./store/controllers/search.php */