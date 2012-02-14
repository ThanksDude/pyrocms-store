<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

// admin
$route['store/admin/categories(/:any)?']				= 'admin_categories$1';
$route['store/admin/products(/:any)?']					= 'admin_products$1';
$route['store/admin/orders(/:any)?']					= 'admin_orders$1';
$route['store/admin/auctions(/:any)?']					= 'admin_auctions$1';
$route['store/admin/attributes/categories(/:any)?']		= 'admin_attributes_categories$1';
$route['store/admin/attributes(/:any)?']				= 'admin_attributes$1';
$route['store/admin/tags(/:any)?']						= 'admin_tags$1';
$route['store/admin/category(/:any)?']					= 'admin_products/category_products$1';
