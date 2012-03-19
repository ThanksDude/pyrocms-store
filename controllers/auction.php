<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
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
		$this->load->library('auctions_management');

		$this->load->language('general');
		//		$this->load->language('messages');
		$this->load->language('cart');
		$this->load->language('settings');
		$this->load->language('auctions');

		$this->load->model('store_m');
		$this->load->model('categories_m');
		$this->load->model('auctions_m');

		$this->load->helper('date');
		$this->load->helper('auction_date');
		$this->load->helper('bids');

		$this->template
			 ->append_metadata(css('store.css', 'store'))
			 ->append_metadata(js('store.js', 'store'));
	}

	/**
	 * Redirect to products or auctions categories list,
	 * allowed by store_setting 'sell_method'.
	 */
	public function index()
	{
		$i = $this->store_settings->item('sell_method');

		if ( isset($i) && (strcmp($i, "1") == 0) ):
			redirect('store/categories/explore/top/tiles');
		else:
			redirect('store/categories/browse/top/tiles');
		endif;
	}

	/**
	 * Display auction description
	 */
	public function view($auction_slug = NULL)
	{
		if ($auction_slug != NULL):
			$auction = $this->auctions_m->get_by('slug', $auction_slug);
			
			$auction->last_bid = $this->auctions_management->get_last_bid($auction->id);
		
			if ($auction):
				$image = $this->images_m->get_image($auction->images_id);

				if ($image):
					$this->images_m->front_image_resize('uploads/store/auctions/', $image, "_large", 400, 300);
					$auction->image = $image;
				endif;

				$this->data->auction = $auction;
				$this->template->build('auction/auction', $this->data);
			endif;
		else:
			redirect('store/categories/browse/top/tiles');
		endif;
	}

	/**
	 * Display auction description
	 */
	public function json($auctions_id = NULL)
	{
	  if ($auctions_id != NULL) {
	    $auction = $this->auctions_m->get_auction($auctions_id);
	  
	    $auction = $auction ? $auction : array('error' => 'id not found');
	    $this->template->build_json($auction);
	  }
	  else {
	    $this->template->build_json(array('error' => 'precise auction id'));
	  }
	}

	/**
	 * Method called by CRON
	 *
	 * Change status to auctions:
	 * not-started => started
	 * started => ended
	 *
	 */
	public function cron_status()
	{
	  foreach ( $this->auctions_management->get_active_auctions() as $auction ) {
	    $this->auctions_management->status_manager($auction);
	  }
	}
}

/* End of file auction.php */
