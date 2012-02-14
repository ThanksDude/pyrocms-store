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
		$this->load->model('auctions_m');

		$this->load->helper('date');
		
		$this->template
			 ->append_metadata(css('store.css', 'store'))
			 ->append_metadata(js('store.js', 'store'));
	}

	public function index($autions = FALSE)
	{
	  if($autions):
	    redirect('store/categories/explore/top/tiles');
	  else:
	    redirect('store/categories/browse/top/tiles');
	  endif;
	}
	
	public function browse($types = 'top', $views = 'tiles', $name = NULL)
	{
		switch($types):
		
			case 'top':
			
				switch($views):
				
					case 'tiles':
						
						$categories = $this->categories_m->get_all();
						foreach ($categories as $category):
				
							$image = $this->images_m->get_image($category->images_id);
							
							if($image):
							 
								$this->images_m->front_image_resize('uploads/store/categories/', $image, 175, 140);	
								$category->image = $image;
							
							endif;
								
						endforeach;
				
						$this->data->categories =	$categories;
				
						$this->template
							 ->build('categories/index/tiles', $this->data);

					break;

					case 'list':

						$categories = $this->categories_m->get_all();
						foreach ($categories as $category):

							$image = $this->images_m->get_image($category->images_id);

							if($image):

								$this->images_m->front_image_resize('uploads/store/categories/', $image, 175, 140);	
								$category->image = $image;

							endif;

						endforeach;

						$this->data->categories = $categories;	

						$this->template
							 ->build('categories/index/list', $this->data);

					break;

				endswitch;

			break;

			case 'sub':

				if(!$name):

					redirect('store/categories/browse/top/tiles');

				else:

					switch($views):

						case 'tiles':

							$name = str_replace('-', ' ', $name);
							$category = $this->categories_m->get_category_by_name($name);

							if($category):

								$products = $this->products_m->get_products($category->categories_id);

								if($products):

									foreach ($products as $product):

										$image = $this->images_m->get_image($product->images_id);
										if($image):
										 
											$this->images_m->front_image_resize('uploads/store/products/', $image, "", 150, 120);	
											$product->image = $image;
										
										endif;

									endforeach;

									$this->data->products		= $products;
									$this->data->category_name	= $category->name;
						
									$this->template
										 ->build('categories/tiles', $this->data);
						
									else:
									
										redirect('store/categories/browse/top/tiles/'.$category->name);
										
									endif;
								
							else:
							
								redirect('store/categories/browse/top/tiles');
							
							endif;
							
						break;
					
						case 'list':
							
							$name = str_replace('-', ' ', $name);
							$category = $this->categories_m->get_category_by_name($name);
							
							if($category):
								
								$products = $this->products_m->get_products($category->categories_id);
								
								if($products):
								
									foreach ($products as $product):
										
										$image = $this->images_m->get_image($product->images_id);
										if($image):
										 
											$this->images_m->front_image_resize('uploads/store/products/', $image, "", 150, 120);	
											$product->image = $image;
										
										endif;		
									
									endforeach;
									
									$this->data->products		= $products;
									$this->data->category_name	= $category->name;
						
									$this->template
										 ->build('categories/list', $this->data);
						
									else:
									
										redirect('store/categories/browse/top/list/'.$category->name);
										
									endif;
								
							else:
							
								redirect('store/categories/browse/top/list');
							
							endif;
							
						break;
					
					endswitch;
				
				endif;
			
			break;
		
		endswitch;
	}


	public function explore($types = 'top', $views = 'tiles', $name = NULL)
	{
	  switch($types)
	    {
	    case 'top':
	      {
		switch($views)
		  {
		    
		  case 'tiles':
		    {
		      $categories = $this->categories_m->get_all();
		      foreach ( $categories as $category )
			{
			  $image = $this->images_m->get_image($category->images_id);
			  
			  if ( $image )
			    {
			      $this->images_m->front_image_resize('uploads/store/categories/', $image, 175, 140);
			      $category->image = $image;
			    }
			}
		      $this->data->categories =	$categories;
		      
		      $this->template
			->build('categories/auction/tiles', $this->data);
		      break;
		    } /* top.$views.tiles */
		    
		  case 'list':
		    {
		      $categories = $this->categories_m->get_all();
		      foreach ( $categories as $category )
			{
			  $image = $this->images_m->get_image($category->images_id);
			  
			  if ( $image )
			    {
			      $this->images_m->front_image_resize('uploads/store/categories/', $image, 175, 140);	
			      $category->image = $image;
			  }
			}	  
		      $this->data->categories = $categories;	
		      
		      $this->template
			->build('categories/auction/list', $this->data);
		      break;
		    } /* top.$views.list */
		    
		    break;
		     /* top.$views */
		  }

		break;
	      } /* top */

	    case 'sub':
	      {  
		if ( !$name )
		  {
		    redirect('store/categories/explore/top/tiles');
		  }
		else
		  {
		    switch ( $views )
		      {
			
		      case 'tiles':
			{
			  $name = str_replace('-', ' ', $name);
			  $category = $this->categories_m->get_category_by_name($name);
			  
			  if ( $category )
			    {
			      
			      $auctions = $this->auctions_m->get_auctions($category->categories_id);
			      
			      if ( $auctions )
				{	    
				  foreach ( $auctions as $auction )
				    {
				      $image = $this->images_m->get_image($auction->images_id);
				      
				      if ( $image )
					{
					  $this->images_m->front_image_resize('uploads/store/auctions/', $image, "", 150, 120);	
					  $auction->image = $image;
					}
				    }
				  
				  $this->data->auctions		= $auctions;
				  $this->data->category_name	= $category->name;
				  
				  $this->template
				    ->build('categories/auction_tiles', $this->data);
				}
			      else
				{
				  redirect('store/categories/explore/top/tiles/'.$category->name);
				}
			    }	  
			  else
			    {
			      redirect('store/categories/explore/top/tiles');
			    }	  
			  break;
			} /* sub.$views.tiles */

		      case 'list':
			{
			  $name = str_replace('-', ' ', $name);
			  $category = $this->categories_m->get_category_by_name($name);
			  
			  if ( $category )
			    {
			      $auctions = $this->auctions_m->get_auctions($category->categories_id);
			      
			      if ( $auctions )
				{
				  foreach ( $auctions as $auction )
				    {
				      $image = $this->images_m->get_image($auction->images_id);
				      
				      if ( $image )
					{
					  $this->images_m->front_image_resize('uploads/store/auctions/', $image, "", 150, 120);	
					  $auction->image = $image;
					}		
				    }
				  
				  $this->data->auctions      	= $auctions;
				  $this->data->category_name	= $category->name;
				  
				  $this->template
				    ->build('categories/auction_list', $this->data);
				}
			      else
				{
				  redirect('store/categories/explore/top/list/'.$category->name);
				}
			    }
			  else
			    {
			      redirect('store/categories/explore/top/list');
			    }
			  break;
			} /* sub.$views.list */

			break;
		      } /* sub.$views */

		  }
		break;
	      } /* sub */

	    }
	}
}
/* End of file categories.php */
/* Location: ./store/controllers/categories.php */