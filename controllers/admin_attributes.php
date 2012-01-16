<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_attributes extends Admin_Controller
{
	protected $section			= 'attributes';
	protected $upload_config;

	public function __construct()
	{
		parent::__construct();

		$this->load->model('attributes_m');
		$this->load->model('products_m');
		$this->load->model('images_m');
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->helper('date');
		
		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('attributes');
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

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index()
	{
		$id = $this->store_settings->item('store_id');

		$attributes = $this->attributes_m->get_all();

		foreach($attributes as $attribute):

			$image = $this->images_m->get_image($attribute->images_id);
			if($image):

				$attribute->image = $this->images_m->get_thumb_anchor($image, $this->upload_path);

			endif;

		endforeach;

		$this->data->attributes	= $attributes;
		$this->template
			 ->build('admin/attributes/index', $this->data);
	}

	public function add()
	{
		if($this->form_validation->run('add_attribute')):

			if($this->attributes_m->create($new_image_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_attributes_success_create'), $this->input->post('name')));
				redirect('admin/store/attributes');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_attributes_error_create')));

			endif;

		else:

			$this->data->action				= 'add';
			$this->data->attribute->name	= NULL;
			$this->data->attribute->html	= NULL;

			$this->template
				 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				 ->build('admin/attributes/form', $this->data);
	
		endif;
	}

	public function edit($attributes_id)
	{
		if($this->form_validation->run('edit_attribute')):
	
			if($this->attributes_m->update($attributes_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_attributes_success_edit'), $this->input->post('name')));
				redirect('admin/store/attributes');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_attributes_error_edit')));

			endif;

		else:

			$attribute = $this->attributes_m->get_attribute($attributes_id);

			$this->data->action		= 'edit';
			$this->data->attribute	= $attribute;

			$this->template
				 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				 ->build('admin/attributes/form', $this->data);

		endif;
	}

	public function delete($attributes_id)
	{
		$this->attributes_m->delete($attributes_id);
		redirect('admin/store/attributes');
	}
}
/* End of file admin_attributes.php */
/* Location: ./store/controllers/admin_attributes.php */