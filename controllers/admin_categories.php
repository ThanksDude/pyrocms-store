<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_categories extends Admin_Controller
{
	protected $section			= 'categories';
	protected $upload_config;
	protected $upload_path		= 'uploads/store/categories/';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('categories_m');
		$this->load->model('products_m');
		$this->load->model('images_m');
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->helper('date');
		
		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('categories');
		$this->load->language('settings');

		if(is_dir($this->upload_path) OR @mkdir($this->upload_path,0777,TRUE)):

			$this->upload_config['upload_path'] = './'. $this->upload_path;

		else:

			$this->upload_config['upload_path'] = './uploads/store/';

		endif;

		$this->upload_config['allowed_types']	= 'gif|jpg|png';
		$this->upload_config['max_size']		= '1024';
		$this->upload_config['max_width']		= '1024';
		$this->upload_config['max_height']		= '768';

		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'name',
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'html',
				'label' => 'html',
				'rules' => 'trim|max_length[1000]|required'
			)
		);

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index($ajax = FALSE)
	{
		$id = $this->store_settings->item('store_id');

		$categories = $this->categories_m->get_all();

		foreach($categories as $category):

			$image = $this->images_m->get_image($category->images_id);
			if($image):

				$category->image = $this->images_m->get_thumb_anchor($image, $this->upload_path);

			endif;

		endforeach;

		$this->data->categories	= $categories;
		$this->template
			 ->build('admin/categories/index', $this->data);
	}

	public function add($ajax = FALSE)
	{
		$id = $this->store_settings->item('store_id');
		$this->load->library('upload', $this->upload_config);		

		if($this->form_validation->run('add_category')):

			if($this->upload->do_upload('userfile')):

				$image_file = $this->upload->data();
				if($image_file):

					$new_image_id = $this->images_m->add_image($image_file, 'category');

				endif;

			else:

				$new_image_id = 0;

			endif;

			if($this->categories_m->add_category($new_image_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_category_success_create'), $this->input->post('name')));
				redirect('admin/store/categories');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_category_error_create')));

			endif;

		else:
		
			foreach ($this->item_validation_rules AS $rule):
			
				$this->data->{$rule['field']} = $this->input->post($rule['field']);
			
			endforeach;

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/categories/form', $this->data, TRUE);

				echo $wysiwyg . $form;
				
			else:
				
				$this->template
				 	 ->title($this->module_details['name'], lang(''))
				 	 ->build('admin/categories/form', $this->data);
				 	 
			endif;
	
		endif;
	}

	public function edit($categories_id, $ajax = FALSE)
	{
		$id = $this->store_settings->item('store_id');
		$this->load->library('upload', $this->upload_config);	

		if($this->form_validation->run('edit_category')):

			$new_image_id = 0;

			if($this->upload->do_upload('userfile')):

				$image_file = $this->upload->data();
				if($image_file):

					$new_image_id = $this->images_m->add_image($image_file, 'category');

				endif;

			endif;
	
			if($this->categories_m->update_category($categories_id, $new_image_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_category_success_edit'), $this->input->post('name')));
				redirect('admin/store/categories');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_category_error_edit')));

			endif;

		else:

			$category = $this->categories_m->get_category($categories_id);	

			$image = $this->images_m->get_image($category->images_id); 				
			if($image):

				$category->image = $this->images_m->get_thumb_anchor($image, $this->upload_path); 

			endif;

			$this->data->dropdown = $this->categories_m->make_categories_dropdown($categories_id);
			$this->data->category	= $category;


			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/categories/form', $this->data, TRUE);
			
				echo $wysiwyg . $form;
				
			else:
			
				$this->template
				 	 ->title($this->module_details['name'], lang(''))
				 	 ->build('admin/categories/form', $this->data);

			endif;

		endif;
	}

	public function delete($categories_id)
	{
		if(isset($_POST['btnAction']) AND is_array($_POST['action_to'])):

			$this->categories_m->delete_many($this->input->post('action_to'));

		elseif(is_numeric($categories_id)):

			$this->categories_m->delete($categories_id);

		endif;
		redirect('admin/store/categories');
	}
}
/* End of file admin_categories.php */
/* Location: ./store/controllers/admin_categories.php */