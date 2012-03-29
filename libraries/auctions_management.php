<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Auctions manager
 * 
 * @author Antoine Benevaut
 * 
 * @package    	OursITShow
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
    $this->ci->load->library('store_auctions');
    $this->ci->load->library('store_settings');
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
}
/* End of file auctions_management.php */