<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
 **/
class Customer_Place_bid extends Public_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('bid_m');
		$this->load->library('form_validation');
		$this->load->library('unit_test');

		$this->load->model('auctions_m');

		$this->unit->active(FALSE);

		$this->template
			 ->append_metadata(css('store.css', 'store'))
			 ->append_metadata(js('store.js', 'store'));
	}

	public function create()
	{
		if(!isset($this->current_user)):
			redirect('register');
		endif;
		
		$post = array(
			'user_id'		=> $this->current_user->id,
			'auction_id'	=> $this->input->post('id'),
			'price'			=> $this->input->post('price'),
			'date'			=> now()
		);

		$validation = array(
			array(
				'field' => 'id',
				'label' => 'id',
				'rules' => 'required',
			),
			array(
				'field' => 'price',
				'label' => 'price',
				'rules' => 'required|numeric',
			),
			array(
				'field' => 'slug',
				'label' => 'slug',
				'rules' => 'required',
			)
		);

		$this->form_validation->set_rules($validation);
		$valid = $this->form_validation->run();

		if($valid):
			$this->bid_m->insert($post);
			$this->session->set_flashdata('success', "success");
		else:
			$this->session->set_flashdata(array('error' => "error"));
		endif;

		redirect('store/auction/view/' . $this->input->post('slug'));
	}

}

/* End of file customer_place_bid.php */
