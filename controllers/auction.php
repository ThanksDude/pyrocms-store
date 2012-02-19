<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class auction extends Public_Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->load->library('cart');
    $this->load->library('store_settings');

    $this->load->language('general');
    $this->load->language('cart');
    $this->load->language('settings');
    $this->load->language('auctions');

    $this->load->model('store_m');
    $this->load->model('categories_m');
    $this->load->model('auctions_m');

    $this->load->helper('date');
		
    $this->template
      ->append_metadata(css('store.css', 'store'))
      ->append_metadata(js('store.js', 'store'));
  }

  public function index()
  {
    
  }
	
  public function view($auction_slug = NULL)
  {
    if ( $auction_slug != NULL )
      {	
	$auction = $this->auctions_m->get_by('slug', $auction_slug);
	
	if ( $auction )
	  {			
	    $image = $this->images_m->get_image($auction->images_id);
	    
	    if ( $image )
	      {			
		$this->images_m->front_image_resize('uploads/store/auctions/', $image, "_large", 400, 300);
		$auction->image = $image;	
	      }
	    
	    $this->data->auction = $auction;
	    $this->template
	      ->build('auction/auction', $this->data);	
	  }
      }
    else
      {	
	redirect('store/categories/browse/top/tiles');	
      }
  }
}

/* End of file auction.php */