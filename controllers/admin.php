<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin extends Admin_Controller
{
	protected $section = 'store';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->library('form_validation');
		$this->load->library('store_settings');
		
		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('dashboard');
		$this->load->language('statistics');
		$this->load->language('settings');

		$this->load->model('store_m');

		$this->load->helper('date');
		
		// We'll set the partials and metadata here since they're used everywhere
		$this->template->set_partial('shortcuts', 'admin/partials/shortcuts')
						->append_metadata(js('admin.js', 'store'))
						->append_metadata(js('stickyfloat.js', 'store'))
						->append_metadata(css('admin.css', 'store'));
	}
	
	public function index()
	{
		$this->data = array();
		
		$this->template
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->title($this->module_details['name'], lang('store_title_store_dashboard'))
			->build('admin/store/dashboard',$this->data);
	}
	
	public function statistics()
	{
		$this->data = array();
		
		$this->template
			->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			->title($this->module_details['name'], lang('store_title_store_statistics'))
			->build('admin/store/statistics',$this->data);
	}
	
	public function settings()
	{
		$this->data = array();

		if(!$this->form_validation->run('store_index')):

			$this->data['general_settings']				= $this->store_settings->settings_manager_retrieve('general')->result();
			$this->data['payment_gateways_settings']	= $this->store_settings->settings_manager_retrieve('payment-gateways')->result();
			$this->data['extra_settings']				= $this->store_settings->settings_manager_retrieve('extra')->result();
			
			$this->template
				->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				->title($this->module_details['name'], lang('store_title_store_settings'))
				->build('admin/store/settings',$this->data);

		else:
			
			if ( ! $this->store_settings->settings_manager_store() ):
				$this->session->set_flashdata('success', sprintf(lang('store_messages_edit_success'), $this->input->post('name')));
				redirect('admin/store/settings');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_edit_error')));
		
			endif;
			
		endif;
	}	
}