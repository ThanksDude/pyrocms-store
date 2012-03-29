<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	http://www.oursitshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
 **/
class Admin_donations extends Admin_Controller
{
	protected $section = 'donations';

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('date');

		$this->load->library('form_validation');
		$this->load->library('store_settings');
		$this->load->library('unit_test');

		$this->unit->active(FALSE);

		$this->load->model('categories_m');
		$this->load->model('donations_m');

		$this->load->language('general');
		// $this->load->language('messages');
		$this->load->language('auctions');
		$this->load->language('donations');
		$this->load->language('settings');
		$this->load->language('general');
		$this->load->language('dashboard');
		$this->load->language('statistics');
		$this->load->language('settings');
		$this->load->language('categories');
		$this->load->language('products');
		$this->load->language('auctions');
		$this->load->language('tags');
		$this->load->language('attributes');
		$this->load->language('orders');

		$this->template
			 ->set_partial('shortcuts', 'admin/partials/shortcuts')
			 ->append_metadata(js('admin.js', 'store'))
			 ->append_metadata(css('admin.css', 'store'));
	}

	public function index() {
	}
}