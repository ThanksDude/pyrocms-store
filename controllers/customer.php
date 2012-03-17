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

	public function place_bid($auction_id = null)
	{
	  if ( !isset($this->current_user) ):
	    redirect('register');
	  endif;

	  $this->data['auction'] = $this->auctions_m->get_auction($auction_id);
	  
	  if ( $auction_id && isset($this->data['auction']) && !empty($this->data['auction']) ) {

	    $this->data['last_bid'] = $this->bid_m->get_by_auction_id($auction_id, 1);
	    
	    if ( ($this->data['img_auction'] = $this->images_m->get_image($this->data['auction']->images_id)) ) {
	      $this->images_m->front_image_resize('uploads/store/categories/', $this->data['img_auction'], 1024, 768);
	    }

	    /* if ( ($this->data['img_auction'] = $this->images_m->get_image($this->data['auction'])) ) { */
	    /*   $this->images_m->front_image_resize('uploads/store/categories/', $this->data['img_auction'], 1024, 768); */
	    /* } */

	    $post = array(
			  'user_id'    	=> $this->current_user->id,
			  'auction_id'	=> $this->input->post('id'),
			  'price'      	=> $this->input->post('price'),
			  'date'       	=> now()
			  );

	    $validation = array(
				array(
				      'field' => 'id',
				      'label' => 'id',
				      'rules' => 'required',
				      ),
				array(
				      'field' => 'price',
				      'label' => 'price',
				      'rules' => 'required|numeric',
				      ),
				array(
				      'field' => 'slug',
				      'label' => 'slug',
				      'rules' => 'required',
				      )
				);
	    
	    $this->form_validation->set_rules($validation);
	    $valid = $this->form_validation->run();
	    
	    if ( $valid ):
		$this->bid_m->insert($post);
		$this->session->set_flashdata('success', "success");
		redirect('store/customer/bid_history');
	    else:
		$this->session->set_flashdata(array('error' => "error"));
	    endif;

	    $this->template
	      ->build('customer/place_bid', $this->data);
	  }
	  else {
	    redirect('store');
	  }
	}

	public function bid_history()
	{
		$this->load->library('unit_test');
		$this->unit->active(FALSE);
		
		$this->data['current_bid'] = null;
		foreach ($this->auctions_m->get_all_active() as $auction) {
		  $this->data['current_bid'][]	= array('auction'=>$auction, 'bid'=>$this->bid_m->limit(1)
							->get_latest_auction_bids_by_user_id($this->current_user->id, $auction->auctions_id)
							);
		}


		$this->data['won_bid'] = null;
		foreach ($this->auctions_m->get_all_inactive() as $auction) {
		  $bids = $this->bid_m->limit(1)
		    ->get_latest_auction_inactive_bids_by_user_id($this->current_user->id, $auction->auctions_id);

		  if ( !empty($bids) && ($bids[0]->bid_id == $auction->winning_bid_id) ) {
		    $this->data['won_bid'][] = array('auction'=>$auction, 'bid'=>$bids[0]);
		  }
		}

		$this->unit->run($this->data['current_bid'], 'is_array', "Current bid for user");
		$this->unit->run($this->data['won_bid'], 'is_array', "Bid won by user");
	
	
		// Error report
		echo $this->unit->report();
		$this->template
		  ->build('customer/bid_history', $this->data);
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