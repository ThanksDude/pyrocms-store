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

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index()
	{
		$tags = $this->tags_m->get_all();

		$this->data->tags	= $tags;
		$this->template
			 ->build('admin/tags/index', $this->data);
	}

	public function add()
	{
		if($this->form_validation->run('add_tag')):

			if($this->tags_m->create()):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_tags_success_create'), $this->input->post('name')));
				redirect('admin/store/tags');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_tags_error_create')));

			endif;

		else:

			$this->data->action			= 'add';
			$this->data->tag->name		= NULL;

			$this->template
				 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				 ->build('admin/tags/form', $this->data);
	
		endif;
	}

	public function edit($tags_id)
	{
		if($this->form_validation->run('edit_tag')):
	
			if($this->tags_m->update($tags_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_tags_success_edit'), $this->input->post('name')));
				redirect('admin/store/tags');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_tags_error_edit')));

			endif;

		else:

			$tag = $this->tags_m->get_tag($tags_id);

			$this->data->action		= 'edit';
			$this->data->tag		= $tag;

			$this->template
				 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				 ->build('admin/tags/form', $this->data);

		endif;
	}

	public function delete($tags_id)
	{
		$this->tags_m->delete($tags_id);
		redirect('admin/store/tags');
	}
}
/* End of file admin_tags.php */
/* Location: ./store/controllers/admin_tags.php */