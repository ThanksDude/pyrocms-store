<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
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
	protected $section = 'auctions';
	protected $upload_config;
	protected $upload_path;

	public function __construct()
	{
		parent::__construct();

		$this->config->load('auctions');

		$this->load->helper('date');

		$this->load->library('form_validation');
		$this->load->library('store_settings');
		//		$this->load->library('cron_like');
		$this->load->library('auctions_management');
		$this->load->library('unit_test');

		$this->unit->active(FALSE);

		$this->load->model('categories_m');
		$this->load->model('products_m');
		$this->load->model('auctions_m');
		$this->load->model('images_m');

		$this->load->language('general');
		// $this->load->language('messages');
		$this->load->language('auctions');
		$this->load->language('settings');
		$this->load->language('general');
		$this->load->language('dashboard');
		$this->load->language('statistics');
		$this->load->language('settings');
		$this->load->language('categories');
		$this->load->language('products');
		$this->load->language('auctions');
		$this->load->language('tags');
		$this->load->language('attributes');
		$this->load->language('orders');

		$this->upload_path = $this->config->item('upload_path');

		if(is_dir($this->upload_path) OR @mkdir($this->upload_path, 0777, TRUE)):

			$this->upload_config['upload_path'] = './' . $this->upload_path;

		else:

			$this->upload_config['upload_path'] = './uploads/store/';

		endif;

		$this->upload_config['allowed_types']	= $this->config->item('allowed_types');
		$this->upload_config['max_size']		= $this->config->item('max_size');
		$this->upload_config['max_width']		= $this->config->item('max_width');
		$this->upload_config['max_height']		= $this->config->item('max_height');

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(js('jquery-ui.timepicker.js', 'store'))
			 ->append_metadata(js('datepicker.js', 'store'))
		       	 ->append_metadata(css('timepicker.css', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index()
	{
		$store_id = $this->store_settings->item('store_id');
		$this->unit->run($store_id, 'is_string', "Store id");

		$auctions = $this->auctions_m->get_all();
		$this->unit->run($auctions, array(), "All auctions");

		foreach($auctions as $auction):
			$this->unit->run($auction, array(), "Auction");

			$this->auctions_management->status_manager($auction);

			$category = $this->categories_m->get_category_name($auction->categories_id);
			$this->unit->run($category, array(), "Auction category");

			if($category):

				$auction->category = $category;

			endif;

			$image = $this->images_m->get_image($auction->images_id);
			$this->unit->run($image, array(), "Auction image");

			if($image):

				$source_image_path = $this->upload_config['upload_path'] . $image->filename;
				$this->images_m->create_thumb($source_image_path);

				$output = '<a href="uploads/store/auctions/' . $image->filename;
				$output .= '" rel="cbox_images" class="auction_images';
				$output .= '" title="' . ucfirst($auction->name) . '" >';
				$output .= '<img class="auctions" src="uploads/store/auctions/' . $image->name . '_thumb';
				$output .= $image->extension . '" alt="' . $image->name . '" /></a>';

				$auction->image = $output;

			endif;

		endforeach;

		$this->data->auctions = $auctions;
		$this->data->status_list = $this->config->item('status');

		// Error report
		echo $this->unit->report();

		$this->template
			 ->build('admin/auctions/index', $this->data);
	}

	public function add()
	{
		$this->load->library('upload', $this->upload_config);

		$id = $this->store_settings->item('store_id');
		$this->unit->run($id, 'is_string', "store id");

		$valid = $this->form_validation->run('add_auction');
		$this->unit->run($valid, TRUE, "validite du formulaire");

		if($valid):

			$uploaded = $this->upload->do_upload('userfile');
			$this->unit->run($uploaded, TRUE, "validite de l'upload");

			if($uploaded):

				$image_file = $this->upload->data();
				$this->unit->run($image_file, TRUE, "contenu de l'image uploader");

				if($image_file):

					$new_image_id = $this->images_m->add_image($image_file, 'auction');

				endif;

			else:

				$new_image_id = 0;

			endif;

			$this->unit->run($new_image_id, 'is_int', "id de l'image uploader");


			if(($auction_id = $this->auctions_m->add_auction($new_image_id))):

			  // Use auction_id to CRON an event. Awake a script at the start AND at the end of the auction
			  // to auto-start/auto-end the auction
			  //
			  // $this->cron_like::add_event( /* start */ );
			  // $this->cron_like::add_event( /* end */ );
			  // 

				$this->session->set_flashdata('success', sprintf(lang('store_messages_auction_success_create'), $this->input->post('name')));
				redirect('admin/store/auctions');

			else:

				$this->session->set_flashdata(array('error' => lang('store_messages_auction_error_create')));

			endif;

		endif;

		$this->data->categories = $this->products_m->make_categories_dropdown(0);
		$this->data->action = 'add';
		$this->data->auction->categories_id = NULL;
		$this->data->auction->status = 1;
		$this->data->auction->name = NULL;
		$this->data->auction->html = NULL;
		$this->data->auction->meta_description = NULL;
		$this->data->auction->meta_keywords = NULL;
		$this->data->auction->attributes_id = 0;
		$this->data->auction->price = 0;
		$this->data->auction->start_at = now();
		$this->data->auction->end_at = now();
		$this->data->auction->discount = 0;
		$this->data->auction->stock = 0;
		$this->data->auction->limited = 0;
		$this->data->auction->limited_used = 0;
		$this->data->auction->images_id = NULL;
		$this->data->auction->thumbnail_id = NULL;
		$this->data->auction->allow_comments	= 1;

		// Error report
		echo $this->unit->report();

		$this->template
			 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			 ->build('admin/auctions/form', $this->data);
	}

	public function edit($auctions_id, $ajax = false)
	{
		$this->load->library('upload', $this->upload_config);

		if($this->form_validation->run('edit_auction')):

       			$new_image_id = 0;

			if($this->upload->do_upload('userfile')):
				$image_file = $this->upload->data();

				if($image_file):

					$new_image_id = $this->images_m->add_image($image_file, 'auction');

				endif;

			endif;

       			if($this->auctions_m->update_auction($auctions_id, $new_image_id)):

			  // Use id (auction id) to CRON an event. Awake a script at the start AND at the end of the auction
			  // to auto-start/auto-end the auction
			  //
			  // $this->cron_like::change_event( /* start */, /* new_start */ );
			  // $this->cron_like::change_event( /* end */, /* new_end */ );
			  // 

				$this->session->set_flashdata('success', sprintf(lang('store_messages_auction_success_edit'), $this->input->post('name')));
       				$auction		= $this->auctions_m->get_auction($auctions_id);
	       			$category_name	= $this->categories_m->get_category($auction->categories_id)->name;

				// Update status
				$this->auctions_management->status_manager($auction);

       				redirect('admin/store/auctions');

       			else:

       				$this->session->set_flashdata(array('error' => lang('store_messages_auction_error_edit')));

       			endif;

		endif;

	       	$auction		= $this->auctions_m->get_auction($auctions_id);
	       	$auction_image	= $this->images_m->get_image($auction->images_id);

	       	if($auction_image):

       	       		$source_image_path = $this->upload_config['upload_path'] . $auction_image->filename;
       	       		$this->images_m->create_thumb($source_image_path);

       	       	endif;

       	       	$this->data->categories		= $this->products_m->make_categories_dropdown($auction->categories_id);
       		$this->data->action			= 'edit';
      		$this->data->auction		= $auction;
 	       	$this->data->auction_image	= $auction_image;

       		if(!$ajax):

       			$this->template->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))->build('admin/auctions/form', $this->data);

       		else:

       			$wysiwyg = $this->load->view('fragments/wysiwyg', $this->data, TRUE);
  	       		$output = $this->load->view('admin/auctions/form', $this->data, TRUE);
       	       		echo $wysiwyg . $output;

       	       	endif;

		$this->template
			 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			 ->build('admin/auctions/form', $this->data);
	}

	public function delete($auctions_id)
	{
		$this->auctions_m->delete_auction($auctions_id);
		redirect('admin/store/auctions');
	}

}