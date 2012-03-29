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
}