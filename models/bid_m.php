<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Comments model
 *
 * @package	PyroCMS
 * @subpackage	Comments Module
 * @category	Models
 * @author	Phil Sturgeon - PyroCMS Dev Team
 */
class Bid_m extends MY_Model
{
  protected $_table	= 'store_bids';

  public function __construct()
  {
    parent::__construct();

    $this->load->library('store_settings');
    $this->_store = $this->store_settings->item('store_id');
		
    $this->load->model('auctions_m');
  }

  /**
   * Get a bid based on the auction ID
   * @access public
   * @param int $id The ID of the auction
   * @return array
   */
  public function get_by_auction_id($id, $limit = 3)
  {
    $this->db->select('bid.*, prf.username')
      ->from($this->_table.' bid')
      ->join('users prf', 'bid.user_id = prf.id', 'left')
      ->where('auction_id', $id)
      ->limit($limit)
      ->order_by('bid.bid_id DESC');
    
    return $this->db->get()->result();
  }

  /**
   * Insert a new comment
   *
   * @access public
   * @param array $input The data to insert
   * @return void
   */
  public function insert($input)
  {
    $this->load->helper('date');
    
    return parent::insert($input);
  }
}