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

  public function last_bid() {
    $id		= $this->attribute('id');
    $price		= $this->attribute('price', 0);
    
    $last_bid = $this->auctions_management->get_last_bid($id);

    return $this->cart->format_number($last_bid ? $last_bid->price : $price);
  }
}

/* End of file plugin.php */