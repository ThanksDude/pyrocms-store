<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Admin_products extends Admin_Controller
{
	protected $section			= 'products';
	protected $upload_config;
	protected $upload_path		= 'uploads/store/products/';

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->library('store_settings');

		$this->load->language('general');
		$this->load->language('messages');
		$this->load->language('products');
		$this->load->language('settings');

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

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index()
	{
		$store_id = $this->store_settings->item('store_id');
		$products = $this->products_m->get_all();

		foreach($products as $product):

			$category = $this->categories_m->get_category_name($product->categories_id);
			if($category):

				$product->category = $category;

			endif;

			$image = $this->images_m->get_image($product->images_id);

			if($image):

				$source_image_path = $this->upload_config['upload_path'] . $image->filename;
				$this->images_m->create_thumb($source_image_path);
				$output = '<a href="uploads/store/products/' . $image->filename;
				$output .= '" rel="cbox_images" class="product_images';
				$output .= '" title="'. ucfirst($product->name);
				$output .=  '" >';
				$output .= '<img class="products" src="uploads/store/products/' . $image->name . '_thumb' . $image->extension;
				$output .= '" alt="' . $image->name;
				$output .= '" /></a>';
				$product->image = $output;
			endif;

		endforeach;

		$this->data->products	= $products;

		$this->template
			 ->build('admin/products/index', $this->data);
	}

	public function add()
	{
		$id = $this->store_settings->item('store_id');
		$this->load->library('upload', $this->upload_config);		

		if($this->form_validation->run('add_product')):

			if($this->upload->do_upload('userfile')):

				$image_file = $this->upload->data();
				if($image_file):

					$new_image_id = $this->images_m->add_image($image_file, 'product');

				endif;

			else:

				$new_image_id = 0;

			endif;

			if($this->products_m->add_product($new_image_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_product_success_create'), $this->input->post('name')));
				redirect('admin/store/products');

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_product_error_create')));

			endif;

		endif;

			$this->data->categories					= $this->products_m->make_categories_dropdown(0);
			$this->data->action						= 'add';
			$this->data->product->categories_id		= NULL;
			$this->data->product->name				= NULL;
			$this->data->product->html				= NULL;
			$this->data->product->meta_description	= NULL;
			$this->data->product->meta_keywords		= NULL;
			$this->data->product->attributes_id		= 0;
			$this->data->product->price				= 0;
			$this->data->product->discount			= 0;
			$this->data->product->stock				= 0;
			$this->data->product->limited			= 0;
			$this->data->product->limited_used		= 0;
			$this->data->product->images_id			= NULL;
			$this->data->product->thumbnail_id		= NULL;

			$this->template
				 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
				 ->build('admin/products/form', $this->data);

	}

	public function edit($products_id, $ajax=false)
	{
		$this->load->library('upload', $this->upload_config);

		if($this->form_validation->run('edit_product')):

			if($this->upload->do_upload('userfile')):

				$image_file = $this->upload->data();
				if($image_file):

					$new_image_id = $this->images_m->add_image($image_file, 'product');

				endif;

			else:

				$new_image_id = 0;

			endif;

			if($this->products_m->update_product($products_id, $new_image_id)):

				$this->session->set_flashdata('success', sprintf(lang('store_messages_product_success_edit'), $this->input->post('name')));
				$product		= $this->products_m->get_product($products_id);
				$category_name	= $this->categories_m->get_category($product->categories_id)->name;
				$route			= 'admin/store/category/' . str_replace(' ', '-', $category_name);
				redirect($route);

			else:

				$this->session->set_flashdata(array('error'=> lang('store_messages_product_error_edit')));

			endif;

		else:

			$product		= $this->products_m->get_product($products_id);
			$product_image	= $this->images_m->get_image($product->images_id);
			if($product_image):

				$source_image_path = $this->upload_config['upload_path'] . $product_image->filename;
				$this->images_m->create_thumb($source_image_path);

			endif;

			$this->data->categories		= $this->products_m->make_categories_dropdown($product->categories_id);
			$this->data->action			= 'edit';
			$this->data->product		= $product;
			$this->data->product_image	= $product_image;

			if(!$ajax):

				$this->template
					 ->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE))
					 ->build('admin/products/form', $this->data);

			else:

				$wysiwyg	= $this->load->view('fragments/wysiwyg', $this->data, TRUE);
				$output		= $this->load->view('admin/products/form', $this->data, TRUE);
				echo $wysiwyg . $output;

			endif;

		endif;

	}

	public function delete($products_id)
	{
		$this->products_m->delete_product($products_id);
		redirect('admin/store/products');
	}

	public function category_products($category_name)
	{
		$category_name	= str_replace('-', ' ', $category_name);
		$category		= $this->categories_m->get_category_by_name($category_name);

		if($category):

			$products = $this->products_m->get_products($category->categories_id);
			foreach ($products as $product):

				$image = $this->images_m->get_image($product->images_id);
				if($image):
 
					$product->image = $this->images_m->get_thumb_anchor($image, 'uploads/store/products/');

				endif;

				$product->category = $category;

			endforeach;
			
			$this->data->category		= $category;
			$this->data->section_title	= lang('store_title_product_list') . '&nbsp&nbsp-&nbsp&nbsp' . ucfirst($category->name);
			$this->data->products		= $products;
			
			$this->template
				 ->build('admin/products/index_category', $this->data);

		else:

			redirect('admin/store/categories');

		endif;

	}
}