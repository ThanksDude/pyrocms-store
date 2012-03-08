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
	protected $section			= 'store';
	protected $upload_config;
	protected $upload_path		= 'uploads/store/products/';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('store_settings');
		
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

		$this->load->model('store_m');
		$this->load->model('categories_m');
		$this->load->model('products_m');
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

		$this->validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'name',
				'rules' => 'trim|max_length[255]|required'
			)/*,
			array(
				'field' => 'html',
				'label' => 'html',
				'rules' => 'trim|max_length[1000]|required'
			)*/
		);

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(js('stickyfloat.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}
	
	public function index()
	{
		$this->data = array();
		
		$this->template
			 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			 ->title($this->module_details['name'], lang('store:dashboard:title'))
			 ->build('admin/store/dashboard',$this->data);
	}
	
	public function statistics()
	{
		$this->data = array();
		
		$this->template
			 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
			 ->title($this->module_details['name'], lang('store:statistics:title'))
			 ->build('admin/store/statistics',$this->data);
	}
	
	public function settings()
	{
		$this->data = array();

		$this->form_validation->set_rules($this->validation_rules);

		//if(!$this->form_validation->run('store_index')):
		if(!$this->form_validation->run()):			

			$this->data['general_settings']				= $this->store_settings->settings_manager_retrieve('general')->result();
			$this->data['payment_gateways_settings']	= $this->store_settings->settings_manager_retrieve('payment-gateways')->result();
			$this->data['extra_settings']				= $this->store_settings->settings_manager_retrieve('extra')->result();
			
			$this->template
				 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				 ->title($this->module_details['name'], lang('store:settings:title'))
				 ->build('admin/store/settings',$this->data);

		else:
			
			if ( ! $this->store_settings->settings_manager_store() ):
				$this->session->set_flashdata('success', sprintf(lang('store:settings:messages:success:edit'), $this->input->post('name')));
				redirect('admin/store/settings');

			else:

				$this->session->set_flashdata(array('error'=> lang('store:settings:messages:error:edit')));
		
			endif;
			
		endif;
	}	
}
/* End of file admin.php */
/* Location: ./store/controllers/admin.php */