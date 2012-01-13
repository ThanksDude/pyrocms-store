<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Categories extends Public_Controller
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
		$categories = $this->categories_m->get_all();
		foreach ($categories as $category){

			$image = $this->images_m->get_image($category->images_id);
			
			if($image){ 
				$this->images_m->front_image_resize('uploads/store/categories/', $image, 175, 140);	
				$category->image = $image;
			}	
		}

		$this->data = array(
			'categories'	=>	$categories
		);		

		$this->template->build('index', $this->data);
	}
	
	public function browse($type = 'top', $view = 'tiles',$name = NULL)
	{
		if( ! $name ) { redirect('store'); }
		$name = str_replace('-', ' ', $name);
		$category = $this->categories_m->get_category_by_name($name);
		
		if($category){
			if ( ! $product_slug ) {
				$products = $this->products_m->get_products($category->categories_id);
				if($products){
					foreach ($products as $product){
						
						$image = $this->images_m->get_image($product->images_id);
						if($image){ 
							$this->images_m->front_image_resize('uploads/store/products/', $image, "", 150, 120);	
							$product->image = $image;
						}		
					}
					$this->data = array( 
							'products'	=>	$products, 'category_name' => $category->name );
				}
				$this->template->build('category', $this->data);
			}
			else {  	// display specific product given by $products_id

				$product = $this->products_m->get_by('slug', $product_slug);
				if($product){
					$image = $this->images_m->get_image($product->images_id);
					if($image){ 
						$this->images_m->front_image_resize('uploads/store/products/', $image, "_large", 400, 300);	
						$product->image = $image;
					}						
					$this->data = array( 'product' =>	$product );
					$this->template->build('product', $this->data);
				}
				else { redirect('store/items/'.$category->name); }
				
				
			}
		}
		else {
			redirect('store');
		}
	}
}
/* End of file categories.php */
/* Location: ./store/controllers/categories.php */