<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Widget_Store_categories extends Widgets {

	public $title = array(
		'en' => 'Store Categories',
		'nl' => 'Winkel Categorieen',
		'de' => 'Store Categories',
		'zh' => '商店產品分類'
	);
	public $description	= array(
		'en' => 'Display the Store Categories',
		'nl' => 'Toon de Winkel Categorieen',
		'de' => 'Zeigen Sie die Store Categories',
		'zh' => '顯示商店產品分類'
	);
	public $author		= 'Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey';
	public $website		= 'http://www.odin-ict.nl/';
	public $version		= '1.0';
	
	public function run($options)
	{
		$this->load->model('store/categories_m');
		
		$categories = $this->categories_m->order_by('name')->get_all();
		
		return array('categories' => $categories);
	}
}