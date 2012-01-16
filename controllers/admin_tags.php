<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_tags extends Admin_Controller
{
	protected $section			= 'tags';
	protected $upload_config;
	protected $upload_path		= 'uploads/store/categories/';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('tags_m');
		$this->load->model('products_m');
		$this->load->model('images_m');
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->helper('date');
		
		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('tags');
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
			)
		);

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index($ajax = FALSE)
	{
		$tags = $this->tags_m->get_all();

		$this->data->tags =& $tags;
		if($ajax):

			$list = $this->load->view('admin/tags/index', $this->data, TRUE);
			echo $list;
			
		else:

			$this->template
				 ->title($this->module_details['name'], lang(''))
				 ->build('admin/tags/index', $this->data);
				 
		endif;
	}

	public function add($ajax = FALSE)
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run()):

			if($this->tags_m->create($this->input->post())):

				// ON SUCCESS
				$this->session->set_flashdata('success', sprintf(lang('store_messages_tags_success_create'), $this->input->post('name')));
				redirect('admin/store/tags');

			else:

				// ON ERROR
				$this->session->set_flashdata(array('error'=> lang('store_messages_tags_error_create')));
				redirect('admin/store/tags/add');

			endif;

		else:
		
			foreach ($this->item_validation_rules AS $rule):
			
				$this->data->{$rule['field']} = $this->input->post($rule['field']);
			
			endforeach;

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/attributes/form', $this->data, TRUE);

				echo $wysiwyg . $form;
				
			else:
				
				$this->template
				 	 ->title($this->module_details['name'], lang(''))
				 	 ->build('admin/tags/form', $this->data);
				 	 
			endif;
	
		endif;
	}

	public function edit($tags_id, $ajax = FALSE)
	{
		$this->data = $this->tags_m->get($tags_id);

		$this->form_validation->set_rules($this->item_validation_rules);
		
		if($this->form_validation->run()):
	
			unset($_POST['btnAction']);
			if($this->tags_m->update($tags_id, $this->input->post())):

				// ON SUCCESS
				$this->session->set_flashdata('success', sprintf(lang('store_messages_tags_success_edit'), $this->input->post('name')));
				redirect('admin/store/tags');

			else:

				// ON ERROR
				$this->session->set_flashdata(array('error'=> lang('store_messages_tags_error_edit')));
				redirect('admin/store/tags/edit' . $tags_id);

			endif;

		else:

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/attributes/form', $this->data, TRUE);
			
				echo $wysiwyg . $form;
				
			else:
			
				$this->template
				 	 ->title($this->module_details['name'], lang(''))
				 	 ->build('admin/tags/form', $this->data);

			endif;
				 	 
		endif;
	}

	public function delete($tags_id)
	{
		if(isset($_POST['btnAction']) AND is_array($_POST['action_to'])):

			$this->tags_m->delete_many($this->input->post('action_to'));

		elseif(is_numeric($tags_id)):

			$this->tags_m->delete($tags_id);

		endif;
		redirect('admin/store/tags');
	}
}
/* End of file admin_tags.php */
/* Location: ./store/controllers/admin_tags.php */