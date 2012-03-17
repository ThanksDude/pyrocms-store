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

		$this->load->language('general');
		//		$this->load->language('messages');
		$this->load->language('cart');
		$this->load->language('settings');

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
	 */
	public function declare_winner()
	{
	  foreach ( $this->auctions_m->get_by('is_active', 1) as $auction ) {

	    /* => log msg
	      echo $auction->auctions_id."<br/>";
	      echo $auction->start_at."<br/>";
	      echo $auction->end_at."<br/>";
	    */

	    $now = time();

	    if ( $auction->end_at > $now ) { // NOT FINISH YET

	      /* => log msg
		 echo timespan($now, $auction->end_at).'<br/>';
		 echo 'end at '.date('d-m-Y', $auction->end_at).'<br/>';
	      */

	    }
	    else { // ENDING PROCESS

	      // => log
	      // echo lang('store:auctions:label:ended_short');

	      // First stop auction, change is_active to false
	      $this->auctions_m->end_auction($auction->auctions_id);

	      // Second get winning bid, get the latest bid.
	      $winner = $this->bid_m->get_by_auction_id($auction->auctions_id, 1);

	      //var_dump($winner);

	      // Third set to auction information the winning bid id.
	      $this->auctions_m->set_auction_winner($auction->auctions_id, $winner[0]->bid_id);
	    }
	  }
	}
}

/* End of file auction.php */
