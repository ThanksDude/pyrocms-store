<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CRON library
 * 
 * @author Antoine Benevaut
 * 
 * @package		OursITShow
 * @subpackage  PyroCMS-Store
 * @category  	Library
 *
 */
class auctions_management
{
  protected	$ci;

  public function __construct() {
    $this->ci =& get_instance();

    $this->ci->config->load('store/auctions');

    $this->ci->load->model('store/auctions_m');
    $this->ci->load->model('store/bid_m'); 
    $this->ci->load->model('store/categories_m');
    $this->ci->load->model('store/images_m');

    $this->ci->load->library('users/Ion_auth');
    $this->ci->load->library('store_settings');
  }

  /*
  **
  ** AUCTIONS
  **
  */

  /**
   * get_auctions
   *
   * @return all auctions
   */
  public function get_auctions() {
    return $this->ci->auctions_m->get_all();
  }

  /**
   * get_auction
   *
   * @return an auction by is id.
   */
  public function get_auction($auction_id) {
    return $this->ci->auctions_m->get_auction($auction_id);
  }

  /**
   * get_auction_picture
   *
   * @args $auction an auction obj
   * @args $width, $height
   *
   * @return the same auction with image informations
   */
  public function get_auction_picture($auction, $width = 175, $height = 150) {
    $auction->image_path = $this->ci->config->item('upload_path');

    if (($auction->image = $this->ci->images_m->get_image($auction->images_id))) {
      $this->ci->images_m->front_image_resize($this->config->item('upload_path'), $auction->image, $width, $height);
    }
    return $auction;
  }

  /**
   * get_active_auctions
   *
   * return started auctions for a category
   */
  public function get_active_auctions($category_id = null) { 
    if (isset($category_id)) {
      $auctions = $this->ci->auctions_m->get_auctions($category_id);
    }
    else {
      $auctions = $this->ci->auctions_m->get_all();
    }

    foreach ($auctions as $key => $auction) {
      if ($auction->status != 1) {
	unset($auctions[$key]);
      }
    }
    return $auctions;
  }

  public function get_ended_auctions($category_id = null) { 
    if (isset($category_id)) {
      $auctions = $this->ci->auctions_m->get_auctions($category_id);
    }
    else {
      $auctions = $this->ci->auctions_m->get_all();
    }

    foreach ($auctions as $key => $auction) {
      if ($auction->status != 2) {
	unset($auctions[$key]);
      }
    }

    return $auctions;
  }

  public function get_not_started_auctions($category_id = null) { 
    if (isset($category_id)) {
      $auctions = $this->ci->auctions_m->get_auctions($category_id);
    }
    else {
      $auctions = $this->ci->auctions_m->get_all();
    }

    foreach ($auctions as $key => $auction) {
      if ($auction->status != 0) {
	unset($auctions[$key]);
      }
    }
    return $auctions;
  }

  /**
   * status_checker
   *
   * @return int
   */
  public function status_checker($start, $end) {
    $now = time();
    
    // if auction don't started
    if ($start > $now && $end > $now) {
      return 0;
    }
    // if auction started
    else if ($start < $now && $end > $now) {
      return 1;
    }
    // if auction ended
    else if ($start < $now && $end < $now) {
      return 2;
    }    
  }

  /**
   * status_manager
   *
   * Update the status of an auction (obj).
   * If the status change to ended (2) the winner is declared in the same time.
   */
  public function status_manager($auction) {
    $mark = $auction->status;

    $auction->status = $this->status_checker($auction->start_at, $auction->end_at);

    if ($mark != $auction->status) {
      $this->ci->auctions_m->update_auction_status($auction);

      if ($auction->status === 2) {
	$bid = $this->ci->bid_m->get_by_auction_id($auction->id, 1);


	//
	// Control bid date
	//


	if (isset($bid) && !empty($bid)) {
	  $this->ci->auctions_m->set_auction_winner($auction->id, $bid[0]->bid_id);

	  $winner = $this->ci->ion_auth->get_user($bid[0]->user_id);


	  //
	  // TEMPORARY
	  // => will create order to have auction as product on cart
	  //

	  $this->ci->load->library('user_agent');
    
	  // to winner
	  Events::trigger('email', array(
					 'title' => "You win an auction !",
					 'content' => "You win an auction !",
					 'slug' => 'customer-won-auction',
					 'email' => $winner->email,
					 ), 'array');
	  
	  // to seller
	  Events::trigger('email', array(
					 'title' => "SOMEONE won an auction !",
					 'content' => "It's amazing ! SOMEONE won the AUCTION_ID!",
					 'slug' => 'customer-won-auction-seller',
					 'email' => $this->store_settings->item('email'),
					 ), 'array');
	}
      }
    }
  }

  /*
  **
  ** BIDS
  **
  */

  //
  // need optimisation
  // Thaht never return 0 :-(
  //
  public function get_count_bids_auction($auction_id) {
    return ($len = count($this->ci->bid_m->get_bids_auction($auction_id))) > 0 ? $len : 0;
  }

  public function get_last_bid($auction_id) {
    $last_bid = $this->ci->bid_m->get_by_auction_id($auction_id, 1);

    return isset($last_bid[0]) ? $last_bid[0] : NULL;
  }

  /*
  **
  ** CATEGORIES
  **
  */

  public function get_category($category_id = 0) {
    return $this->ci->categories_m->get_category($category_id);
  }

  /**
   * get_categories
   *
   * @return array, that store only category with started auction(s).
   */
  public function get_categories() {
    $categories = $this->ci->categories_m->get_all();

    foreach ($categories as $key => $category) {
      if (! ($category->items_number = $this->ci->auctions_m->count_started_auctions($category->categories_id)->count)) {
	unset($categories[$key]);	
      }
    }
    return $categories;
  }
}
/* End of file auctions_management.php */