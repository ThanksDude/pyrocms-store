<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Customer_Place_bid extends Public_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->load->model('bid_m');
    $this->load->library('form_validation');

    $this->template
      ->append_metadata(css('store.css', 'store'))
      ->append_metadata(js('store.js', 'store'));
  }

  public function index()
  {
    $this->template
      ->build('customer/index', $this->data);
  }

  public function create()
  {
    var_dump($_POST); exit();

    redirect('store/auction/view/'.$auction_slug);
  }
}
/* End of file customer_place_bid.php */