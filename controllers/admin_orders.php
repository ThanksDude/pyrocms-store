<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_orders extends Admin_Controller
{
	protected $section			= 'orders';
	protected $upload_config;
	protected $upload_path		= 'uploads/store/orders/';

	public function __construct()
	{
		parent::__construct();

		$this->load->model('tags_m');
		$this->load->model('products_m');
		$this->load->model('orders_m');
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
		$this->load->language('tags');
		$this->load->language('attributes');
		$this->load->language('attributes_categories');
		$this->load->language('status');


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
				'label' => 'store:tags:label:name',
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
		$orders = $this->orders_m->get_all();

		$this->data->orders =& $orders;
		if($ajax):

			$list = $this->load->view('admin/orders/index', $this->data, TRUE);
			echo $list;
			
		else:

			$this->template
				 ->title($this->module_details['name'], lang('store:orders:title'))
				 ->build('admin/orders/index', $this->data);
				 
		endif;
	}
	
	public function view($orders_id, $ajax = FALSE)
	{
		$order 				= $this->orders_m->get_order($orders_id);
		$users_name 		= $this->orders_m->get_orders_users($order->users_id);
		$items				= $this->orders_m->get_orders_product_all($orders_id);
		//$items_prices		= $this->orders_m->get_orders_product_price($orders_id);
		//$items_quantities	= $this->orders_m->get_orders_product_quantities($orders_id);
		$status				= $this->orders_m->get_orders_status($orders_id);
		
		$this->data->order				= $order;
		$this->data->users_name			= $users_name;
		$this->data->items				= $items;
		//$this->data->items_prices		= $items_prices;
		//$this->data->items_quantities	= $items_quantities;
		$this->data->status				= $status;
			
		if($ajax):
	
			$list = $this->load->view('admin/orders/view', $this->data, TRUE);
			echo $list;
			
		else:
	
			$this->template
				 ->title($this->module_details['name'], lang('store:orders:title'))
				 ->build('admin/orders/view', $this->data);
				 
		endif;
	}	

	public function add($ajax = FALSE)
	{
		$this->form_validation->set_rules($this->item_validation_rules);

		if($this->form_validation->run()):

			if($this->tags_m->create($this->input->post())):

				// ON SUCCESS
				$this->session->set_flashdata('success', sprintf(lang('store:orders:messages:success:add'), $this->input->post('name')));
				redirect('admin/store/orders');

			else:

				// ON ERROR
				$this->session->set_flashdata(array('error'=> lang('store:orders:messages:error:add')));
				redirect('admin/store/orders/add');

			endif;

		else:
		
			foreach ($this->item_validation_rules AS $rule):
			
				$this->data->{$rule['field']} = $this->input->post($rule['field']);
			
			endforeach;

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/orders/form', $this->data, TRUE);

				echo $wysiwyg . $form;
				
			else:
				
				$this->template
				 	 ->title($this->module_details['name'], lang('store:orders:title') . " - " . lang('store:orders:title:add'))
				 	 ->build('admin/orders/form', $this->data);
				 	 
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
				$this->session->set_flashdata('success', sprintf(lang('store:orders:messages:success:edit'), $this->input->post('name')));
				redirect('admin/store/orders');

			else:

				// ON ERROR
				$this->session->set_flashdata(array('error'=> lang('store:orders:messages:error:edit')));
				redirect('admin/store/orders/edit' . $tags_id);

			endif;

		else:

			if($ajax):
	
				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$form		= $this->load->view('admin/orders/form', $this->data, TRUE);
			
				echo $wysiwyg . $form;
				
			else:
			
				$this->template
				 	 ->title($this->module_details['name'], lang('store:orders:title') . " - " . lang('store:orders:title:edit'))
				 	 ->build('admin/orders/form', $this->data);

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
		redirect('admin/store/orders');
	}
}
/* End of file admin_orders.php */
/* Location: ./store/controllers/admin_orders.php */