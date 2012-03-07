<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class product extends Public_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->library('store_settings');

		$this->load->language('general');
		$this->load->language('cart');
		$this->load->language('settings');
		$this->load->language('products');

		$this->load->model('store_m');
		$this->load->model('categories_m');
		$this->load->model('products_m');
		$this->load->model('attributes_m');


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
	
	public function view($product_slug = NULL)
	{
		if($product_slug != NULL):
	
			$product = $this->products_m->get_by('slug', $product_slug);
			if($product):
			
				$image = $this->images_m->get_image($product->images_id);
				if($image):
				
					$this->images_m->front_image_resize('uploads/store/products/', $image, "_large", 400, 300);
					$product->image = $image;
					
				endif;
				$attributes = $this->attributes_m->get_products_attributes($product->products_id);
				if(isset($attributes)):

					$product->attributes = array();
					foreach ($attributes as $attribute_id):
						$attribute=$this->products_m->get_product_attributes($attribute_id);
						$product->attributes[] = $attribute;
					endforeach;

				endif;
				
				$this->data->product = $product;
				$this->template
					 ->build('product/product', $this->data);
				
			endif;
			
		else:
		
			redirect('store/categories/browse/top/tiles');
		
		endif;
	}
}
/* End of file product.php */
/* Location: ./store/controllers/product.php */