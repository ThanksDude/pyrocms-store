<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Images_m extends MY_Model
{
	protected $_table = array(
		'files'			=> 'files',
		'file_folders'	=> 'file_folders'
	);
	protected $folder_id;
	protected $product_images	= 'store_product_images';
	protected $category_images	= 'store_category_images';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('store_settings');
		$this->_store = $this->store_settings->item('store_id');

		$this->load->library('image_lib');

		$this->load->model('files/file_m');
		$this->load->model('files/file_folders_m');
	}

	public function add_image($file, $type='product')
	{
		if($type == 'product'):

			$this->folder_exists_create($this->product_images);

		else:

			$this->folder_exists_create($this->category_images);

		endif;

		if(!$file):

			return FALSE;

		endif;

		$data = array(
			'folder_id'		=> (int) $this->folder_id,
			'user_id'		=> 1,
			'type'			=> 'i',
			'name'			=> $file['raw_name'],
			'description'	=> $this->input->post('description') ? $this->input->post('description') : '',
			'filename'		=> $file['file_name'],
			'extension'		=> $file['file_ext'],
			'mimetype'		=> $file['file_type'],
			'filesize'		=> $file['file_size'],
			'width'			=> (int) $file['image_width'],
			'height'		=> (int) $file['image_height'],
			'date_added'	=> now()
		);

		return $this->file_m->insert($data) ? $this->db->insert_id() : FALSE;
	}

	public function get_image($images_id)
	{
		return $this->db
					->where('id', $images_id)
					->where('type', 'i')
					->limit(1)
					->get($this->_table['files'])
					->row();
	}

	public function delete_image($images_id=0, $image_path)
	{
		if(!($images_id == 0)):

			$image = $this->get_image($images_id);
			if($image):

				$thumb_image_path = $image_path . $image->name . '_thumb' . $image->extension;
				if(is_file($thumb_image_path)):

					unlink($thumb_image_path);

				endif;

				$orig_image_path = $image_path . $image->filename;
				if(is_file($orig_image_path)):

					unlink($orig_image_path);

				endif;

				return $this->db
							->where('id', $images_id)
							->where('type', 'i')
							->limit(1)
							->delete($this->_table['files']);

			endif;

		endif;

	}

	public function front_image_resize($source_image_path, $image, $suffix="", $width=75, $height=50)
	{
		$resize_config['image_library']		= 'gd2';
		$resize_config['source_image']		= $source_image_path . $image->filename;
		$resize_config['new_image']			= $source_image_path . $image->name . $image->id. $suffix. $image->extension;
		$resize_config['create_thumb']		= FALSE;
		$resize_config['maintain_ratio']	= TRUE;
		$resize_config['width']				= $width;
		$resize_config['height']			= $height;

		$this->image_lib->initialize($resize_config);
		$this->image_lib->resize();
	}

	public function create_thumb($source_image_path, $width=75, $height=50)
	{
		$resize_config['image_library']		= 'gd2';
		$resize_config['source_image']		= $source_image_path;
		$resize_config['create_thumb']		= TRUE;
		$resize_config['maintain_ratio']	= TRUE;
		$resize_config['width']				= $width;
		$resize_config['height']			= $height;

		$this->image_lib->initialize($resize_config);
		$this->image_lib->resize();
	}

	public function get_thumb_anchor($image, $image_path)
	{
		$source_image = $image_path . $image->filename;
		$thumb_image_path = $image_path . $image->name . '_thumb' . $image->extension;

		if(!is_file($thumb_image_path)):

			$this->images_m->create_thumb($source_image);

		endif;

		$output  	 = '<a href="'. $image_path . $image->filename;
		$output 	.= '" rel="cbox_images" class="product_images';
		$image->name = str_replace(array('-','_') , ' ', $image->name);
		$output		.= '" title="'. ucfirst($image->name) . '" >';
		$output		.= '<img src="'. $thumb_image_path;
		$output		.= '" class="image_thumbs" alt="' . $image->name;
		$output		.= '" /></a>';

		return $output;
	}

	public function folder_exists_create($image_folder_name)
	{

		if($this->file_folders_m->exists($image_folder_name)):

			$this->folder_id = $this->db
									->where('name', $image_folder_name)
									->limit(1)
									->get($this->_table['file_folders'])
									->row()
									->id;
		else:

			$data = array(
				'parent_id'		=> 0,
				'slug'			=> $image_folder_name,
				'name'			=> $image_folder_name,
				'date_added'	=> now()
			);
			$this->db->insert($this->_table['file_folders'], $data);
			$this->folder_id = $this->db->insert_id();
		endif;
	}

	public function no_image()
	{
		return "<p class='no_image'>Upload Image</p>";
	}
}