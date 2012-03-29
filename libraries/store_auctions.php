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
}