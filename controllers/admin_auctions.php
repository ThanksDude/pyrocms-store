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
	protected $section			= 'auctions';
	protected $upload_config;
	protected $upload_path		= 'uploads/store/auctions/';

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->library('unit_test');
		
		$this->unit->active(TRUE);
		
		$this->load->language('general');
		$this->load->language('dashboard');
		$this->load->language('statistics');
		$this->load->language('settings');
		$this->load->language('categories');
		$this->load->language('products');
		$this->load->language('orders');
    	$this->load->language('auctions');
		$this->load->language('tags');
		$this->load->language('attributes');
		$this->load->language('attributes_categories');

		$this->load->model('categories_m');
		$this->load->model('products_m');
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
		$this->unit->run($auctions, array(), "All auctions");
		
		foreach($auctions as $auction):

			$this->unit->run($auction, array(), "Auction");
			
			$category = $this->categories_m->get_category_name($auction->categories_id);
			$this->unit->run($category, array(), "Auction category");
		
			if($category):

				$auction->category = $category;
			
			endif;
			
			$image = $this->images_m->get_image($auction->images_id);
			$this->unit->run($image, array(), "Auction image");
		
			if($image):

				$source_image_path = $this->upload_config['upload_path']. $image->filename;
				$this->images_m->create_thumb($source_image_path);
				
				$output = '<a href="uploads/store/auctions/'. $image->filename;
				$output .= '" rel="cbox_images" class="auction_images';
				$output .= '" title="'. ucfirst($auction->name) .'" >';
				$output .= '<img class="auctions" src="uploads/store/auctions/'. $image->name .'_thumb';
				$output .= $image->extension .'" alt="'. $image->name .'" /></a>';
				
				$auction->image = $output;
			
			endif;

		endforeach;
		
		$this->data->auctions	= $auctions;
		
		// Error report
		echo $this->unit->report();
		
		$this->template
			 ->build('admin/auctions/index', $this->data);
	}

	public function add()
	{
		$this->load->library('upload', $this->upload_config);
		
		$id = $this->store_settings->item('store_id');
		$this->unit->run($id, 'is_string', "id du store");
		
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
			
			if($this->auctions_m->add_auction($new_image_id)):
	
				$this->session->set_flashdata('success', sprintf(lang('store:messages:auction:success:create'),
				$this->input->post('name')));
				redirect('admin/store/auctions');
	
			else:
	
				$this->session->set_flashdata(array('error'=> lang('store:messages:auction:error:create')));
				
			endif;
			
		endif;
		
		$this->data->categories	       			= $this->products_m->make_categories_dropdown(0);
		$this->data->auction->categories_id		= NULL;
		$this->data->auction->name	       		= NULL;
		$this->data->auction->html		       	= NULL;
		$this->data->auction->meta_description	= NULL;
		$this->data->auction->meta_keywords		= NULL;
		$this->data->auction->attributes_id		= 0;
		$this->data->auction->price	       		= 0;
		$this->data->auction->start_at     		= now();
		$this->data->auction->end_at       		= now();
		$this->data->auction->discount	       	= 0;
		$this->data->auction->stock	       		= 0;
		$this->data->auction->limited	       	= 0;
		$this->data->auction->limited_used		= 0;
		$this->data->auction->images_id    		= NULL;
		$this->data->auction->thumbnail_id		= NULL;
		
		// Error report
		// echo $this->unit->report();
		
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
				
				$this->session->set_flashdata('success', sprintf(lang('store:messages:auction:success:edit'), $this->input->post('name')));
				$auction		= $this->auctions_m->get_auction($auctions_id);
				$category_name	= $this->categories_m->get_category($auction->categories_id)->name;
				//$route			= 'admin/store/category/' . str_replace(' ', '-', $category_name); 
				//untill Categories lists both auctions and products
				$route 			='admin/store/auctions/';
				redirect($route);
	
			else:
	
				$this->session->set_flashdata(array('error'=> lang('store:messages:auction:error:edit')));
			
			endif;
				
			
		else:

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
}