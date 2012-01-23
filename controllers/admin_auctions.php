<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	http://www.oursitshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_auctions extends Admin_Controller
{
  protected $section		= 'auctions';
  protected $upload_config;
  protected $upload_path       	= 'uploads/store/auctions/';

  public function __construct()
  {
    parent::__construct();

    $this->load->library('form_validation');
    $this->load->library('store_settings');
    $this->load->library('unit_test');

    $this->unit->active(TRUE);

    $this->load->language('general');
    $this->load->language('messages');
    $this->load->language('auctions');
    $this->load->language('settings');

    $this->load->model('categories_m');
    $this->load->model('auctions_m');
    $this->load->model('images_m');

    $this->load->helper('date');

    if(is_dir($this->upload_path) OR @mkdir($this->upload_path,0777,TRUE)):

      $this->upload_config['upload_path'] = './'. $this->upload_path;

    else:

      $this->upload_config['upload_path'] = './uploads/store/';

    endif;

    $this->upload_config['allowed_types']	= 'gif|jpg|png';
    $this->upload_config['max_size']		= '1024';
    $this->upload_config['max_width']		= '1024';
    $this->upload_config['max_height']		= '768';

    $this->template
      ->set_partial('shortcuts', 'admin/partials/shortcuts')
      ->append_metadata(js('admin.js', 'store'))
      ->append_metadata(css('admin.css', 'store'));
  }

  public function index()
  {
    $store_id = $this->store_settings->item('store_id');
    $this->unit->run($store_id, 'is_string', "Store id");

    $auctions = $this->auctions_m->get_all();
    $this->unit->run($auctions, array(), "Store id");

  foreach($auctions as $auction):

    $category = $this->categories_m->get_category_name($auction->categories_id);
    if($category):

      $auction->category = $category;

    endif;

    $image = $this->images_m->get_image($auction->images_id);

    if($image):

      $source_image_path = $this->upload_config['upload_path'] . $image->filename;
    $this->images_m->create_thumb($source_image_path);
    $output = '<a href="uploads/store/auctions/' . $image->filename;
    $output .= '" rel="cbox_images" class="auction_images';
    $output .= '" title="'. ucfirst($auction->name);
    $output .=  '" >';
    $output .= '<img class="auctions" src="uploads/store/auctions/' . $image->name . '_thumb' . $image->extension;
    $output .= '" alt="' . $image->name;
    $output .= '" /></a>';
    $auction->image = $output;
    endif;

    endforeach;

    $this->data->auctions	= $auctions;

    echo $this->unit->report();

    $this->template
      ->build('admin/auctions/index', $this->data);
  }

  public function add()
  {
    $id = $this->store_settings->item('store_id');
    $this->load->library('upload', $this->upload_config);		

    if($this->form_validation->run('add_auction')):

      if($this->upload->do_upload('userfile')):

	$image_file = $this->upload->data();
    if($image_file):

      $new_image_id = $this->images_m->add_image($image_file, 'auction');

    endif;

    else:

      $new_image_id = 0;

    endif;

    if($this->auctions_m->add_auction($new_image_id)):

      $this->session->set_flashdata('success', sprintf(lang('store_messages_auction_success_create'), $this->input->post('name')));
    redirect('admin/store/auctions');

    else:

      $this->session->set_flashdata(array('error'=> lang('store_messages_auction_error_create')));

    endif;

    endif;

    $this->data->categories					= $this->auctions_m->make_categories_dropdown(0);
    $this->data->action						= 'add';
    $this->data->auction->categories_id		= NULL;
    $this->data->auction->name				= NULL;
    $this->data->auction->html				= NULL;
    $this->data->auction->meta_description	= NULL;
    $this->data->auction->meta_keywords		= NULL;
    $this->data->auction->attributes_id		= 0;
    $this->data->auction->price				= 0;
    $this->data->auction->discount			= 0;
    $this->data->auction->stock				= 0;
    $this->data->auction->limited			= 0;
    $this->data->auction->limited_used		= 0;
    $this->data->auction->images_id			= NULL;
    $this->data->auction->thumbnail_id		= NULL;

    $this->template
      ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
      ->build('admin/auctions/form', $this->data);

  }

  public function edit($auctions_id, $ajax=false)
  {
    $this->load->library('upload', $this->upload_config);

    if($this->form_validation->run('edit_auction')):

      if($this->upload->do_upload('userfile')):

	$image_file = $this->upload->data();
    if($image_file):

      $new_image_id = $this->images_m->add_image($image_file, 'auction');

    endif;

    else:

      $new_image_id = 0;

    endif;

    if($this->auctions_m->update_auction($auctions_id, $new_image_id)):

      $this->session->set_flashdata('success', sprintf(lang('store_messages_auction_success_edit'), $this->input->post('name')));
    $auction		= $this->auctions_m->get_auction($auctions_id);
    $category_name	= $this->categories_m->get_category($auction->categories_id)->name;
    $route			= 'admin/store/category/' . str_replace(' ', '-', $category_name);
    redirect($route);

    else:

      $this->session->set_flashdata(array('error'=> lang('store_messages_auction_error_edit')));

    endif;

    else:

      $auction		= $this->auctions_m->get_auction($auctions_id);
    $auction_image	= $this->images_m->get_image($auction->images_id);
    if($auction_image):

      $source_image_path = $this->upload_config['upload_path'] . $auction_image->filename;
    $this->images_m->create_thumb($source_image_path);

    endif;

    $this->data->categories		= $this->auctions_m->make_categories_dropdown($auction->categories_id);
    $this->data->action			= 'edit';
    $this->data->auction		= $auction;
    $this->data->auction_image	= $auction_image;

    if(!$ajax):

      $this->template
	->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
	->build('admin/auctions/form', $this->data);

    else:

      $wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
    $output		= $this->load->view('admin/auctions/form', $this->data, TRUE);
    echo $wysiwyg . $output;

    endif;

    endif;

  }

  public function delete($auctions_id)
  {
    $this->auctions_m->delete_auction($auctions_id);
    redirect('admin/store/auctions');
  }

  public function category_auctions($category_name)
  {
    $category_name	= str_replace('-', ' ', $category_name);
    $category		= $this->categories_m->get_category_by_name($category_name);

    if($category):

      $auctions = $this->auctions_m->get_auctions($category->categories_id);
    foreach ($auctions as $auction):

    $image = $this->images_m->get_image($auction->images_id);
    if($image):
 
      $auction->image = $this->images_m->get_thumb_anchor($image, 'uploads/store/auctions/');

    endif;

    $auction->category = $category;

    endforeach;
			
    $this->data->category		= $category;
    $this->data->section_title	= lang('store_title_auction_list') . '&nbsp&nbsp-&nbsp&nbsp' . ucfirst($category->name);
    $this->data->auctions		= $auctions;
			
    $this->template
      ->build('admin/auctions/index_category', $this->data);

    else:

      redirect('admin/store/categories');

    endif;

  }
}