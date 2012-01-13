<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Cart extends Public_Controller
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
		
		$this->template->append_metadata(css('store.css', 'store'))
						->append_metadata(js('store.js', 'store'));
	}

	public function index()
	{
		redirect('store/cart/show_cart');
	}
	
	public function show_cart(){

		$this->data = array(
			''	=>	''
		);
		
		$this->template->build('cart', $this->data);
	}
	
	public function checkout_cart(){
		$this->store_m->build_order();
	}
	
	public function update_cart(){
		$this->redirect = $this->input->post('redirect');
		$this->data = $this->input->post();
		$this->cart->update($this->data);
		redirect($this->redirect);
	}
	
	public function insert_cart($product){
		$this->redirect = $this->input->post('redirect');
		$this->data = $this->store_m->get_product_in_cart($product);
		$this->cart->insert($this->data);
		redirect($this->redirect);
	}
}
/* End of file cart.php */
/* Location: ./store/controllers/cart.php */