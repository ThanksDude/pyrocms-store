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
	protected $upload_path		= 'uploads/store/categories/';

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
		$this->load->language('dashboard');
		$this->load->language('statistics');
		$this->load->language('settings');
		$this->load->language('categories');
		$this->load->language('products');
		$this->load->language('orders');
		$this->load->language('auctions');
		$this->load->language('donations');
		$this->load->language('tags');
		$this->load->language('attributes');
		$this->load->language('attributes_categories');

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
				'label' => 'store:attributes:label:name',
				'rules' => 'trim|max_length[255]|required'
			),
			array(
				'field' => 'html',
				'label' => 'store:attributes:label:html',
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
		$attributes = $this->attributes_m->get_all();

		$this->data->attributes =& $attributes;
		if($ajax):

			$list = $this->load->view('admin/attributes/index', $this->data, TRUE);
			echo $list;
			
		else:
			
			$this->template
				 ->title($this->module_details['name'], lang('store:attributes:title'))
				 ->build('admin/attributes/index', $this->data);
				 
		endif;
	}

	public function add($ajax = FALSE)
	{
		$this->form_validation->set_rules($this->item_validation_rules);
		
		if($this->form_validation->run()):

			if($this->attributes_m->add_attribute($this->input->post())):
				
				// ON SUCCESS
				$this->session->set_flashdata('success', sprintf(lang('store:attributes:messages:success:add'), $this->input->post('name')));
				redirect('admin/store/attributes');

			else:

				// ON ERROR
				$this->session->set_flashdata(array('error'=> lang('store:attributes:messages:error:add')));
				redirect('admin/store/attributes/add');
				
			endif;

		else:
		
			foreach ($this->item_validation_rules AS $rule):
			
				//$this->data->{$rule['field']} = $this->input->post($rule['field']);
				$this->data->attribute->{$rule['field']} = $this->input->post($rule['field']);
			
			endforeach;

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/attributes/form', $this->data, TRUE);

				echo $wysiwyg . $form;
				
			else:
				
				$this->template
				 	 ->title($this->module_details['name'], lang('store:attributes:title') . " - " . lang('store:attributes:title:add'))
					 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
					 ->build('admin/attributes/form', $this->data);
	
			endif;

		endif;
	}

	public function edit($attributes_id = 0, $ajax = FALSE)
	{
		$this->data->attribute = $this->attributes_m->get($attributes_id);

		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run()):
	
			unset($_POST['btnAction']);
			if($this->attributes_m->update($attributes_id, $this->input->post())):

				// ON SUCCESS
				$this->session->set_flashdata('success', sprintf(lang('store:attributes:messages:success:edit'), $this->input->post('name')));
				redirect('admin/store/attributes');

			else:

				// ON ERROR
				$this->session->set_flashdata(array('error'=> lang('store:attributes:messages:error:edit')));
				redirect('admin/store/attributes/edit/'.$attributes_id);
				
			endif;

		else:

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/attributes/form', $this->data, TRUE);
			
				echo $wysiwyg . $form;
				
			else:
			
				$this->template
				 	 ->title($this->module_details['name'], lang('store:attributes:title') . " - " . lang('store:attributes:title:edit'))
					 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
					 ->build('admin/attributes/form', $this->data);

			endif;
		
		endif;
	}

	public function delete($attributes_id)
	{
		if(isset($_POST['btnAction']) AND is_array($_POST['action_to'])):

			$this->attributes_m->delete_many($this->input->post('action_to'));

		elseif(is_numeric($attributes_id)):

			$this->attributes_m->delete($attributes_id);

		endif;
		redirect('admin/store/attributes');
	}
}
/* End of file admin_attributes.php */
/* Location: ./store/controllers/admin_attributes.php */