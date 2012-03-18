<?php defined('BASEPATH') OR exit('No direct script access allowed');

function display_bids($auction)
{
  if ( !isset($auction) ) { return null; }

  $ci =& get_instance();

  //  $ci->lang->load('store/bid');
  $ci->load->model('store/bid_m');
  $ci->load->model('store/auctions_m');

  $data['id']	= $auction->auctions_id;
  $data['slug']	= $ci->auctions_m->get_auction($data['id'])->slug;
  $data['bids']	= $ci->bid_m->get_by_auction_id($data['id']);
  
  
  /**
   * The following allows us to load views
   * without breaking theme overloading
   **/
  $view		= array(
			'path' => 'modules/store/bid/',
			'view' => 'bid_helper'
			);
  
  if (file_exists($ci->template->get_views_path().$view['path'].$view['view'].(pathinfo($view['view'], PATHINFO_EXTENSION) ? '' : EXT)))
    {
      // look in the theme for overloaded views
      $path = $ci->template->get_views_path().$view['path'];
    }
  else
    {
      // or look in the module
      list($path, $view) = Modules::find($view['view'], 'store', 'views/auction/');
    }
  
  // save the existing view array so we can restore it
  $save_path = $ci->load->get_view_paths();
  
  // add this view location to the array
  $ci->load->set_view_path($path);
  
  // output the comments html
  $comment_view = $ci->load->_ci_load(array('_ci_view' => $view, '_ci_vars' => ( $data )));

  // Put the old array back
  $ci->load->set_view_path($save_path);
}
