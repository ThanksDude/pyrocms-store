<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Plugin_Store extends Plugin
{
  public function __construct() {
    $this->load->library('cart');

    $this->load->library('auctions_management');
  }

  public function count_bid() {
    $id		= $this->attribute('id');

    return $this->auctions_management->get_count_bids_auction($id);
  }

  public function last_bid() {
    $id		= $this->attribute('id');
    $price     	= $this->attribute('price', 0);
    
    $last_bid = $this->auctions_management->get_last_bid($id);

    return $this->cart->format_number($last_bid ? $last_bid->price : $price);
  }

  public function shortRemain_time() {
    $s    	= $this->attribute('end');

    $end = time();
    $string = null;

  $t = array( //suffixes
	     'd' => 86400,
	     'h' => 3600,
	     'm' => 60,
	      );

  $s = abs($s - $end);
  foreach($t as $key => &$val) {
    $$key = floor($s / $val);
    $s -= ($$key * $val);
    $string .= ($$key == 0) ? '' : $$key . "$key ";
  }
  return $string.$s.'s';
  }

  function category_information()
  {
    $id = $this->attribute('id');
    $this->load->model('store/categories_m');
    $this->load->model('store/images_m');

    if (($cat = $this->categories_m->get_category($id))) {
	$image = $this->images_m->get_image($cat->images_id);
    
	if ( $image ) {
	  $this->images_m->front_image_resize('uploads/store/categories/', $image, 175, 140);
	  return '<img src="'.base_url().'uploads/store/categories/'.$image->filename.'" width="120" height="75" /><br/><h3>'.$cat->name.'</h3><p>'.$cat->html.'</p>';
	}
      }
      return "";
  }
}

/* End of file plugin.php */