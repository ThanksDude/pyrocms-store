<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Widget_Store_search extends Widgets {

	public $title = array(
		'en' => 'Store Search Engine Widget',
		'nl' => 'Winkel Zoekmachine Widget',
		'de' => 'Store Search Engine Widget',
		'zh' => '商店產品搜索小組件'
	);
	public $description	= array(
		'en' => 'Display the Store Search Engine',
		'nl' => 'Toon de Zoekmachine',
		'de' => 'Zeigen Sie die Store Search Engine',
		'zh' => '商店產品搜索小組件'
	);
	public $author		= 'Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey';
	public $website		= 'http://www.odin-ict.nl/';
	public $version		= '1.0';
	
	public $fields = array(
	);
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function form($options)
	{		
		return array(
		);
	}
	public function run($options)
	{
		return	$options;
	}
}