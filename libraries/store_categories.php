<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * store_categories
 * 
 * @author Antoine Benevaut
 * 
 * @package	OursITShow
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