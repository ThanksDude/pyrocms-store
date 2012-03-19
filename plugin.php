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
}

/* End of file plugin.php */