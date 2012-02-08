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
$route['store/admin/categories(/:any)?']		= 'admin_categories$1';
$route['store/admin/products(/:any)?']			= 'admin_products$1';
$route['store/admin/auctions(/:any)?']			= 'admin_auctions$1';
$route['store/admin/attributes(/:any)?']		= 'admin_attributes$1';
$route['store/admin/tags(/:any)?']				= 'admin_tags$1';

// admin list products
$route['store/admin/preview/(:any)/(:any)']		= 'store/items/$1/$2';
$route['store/admin/edit_product(/:any)?']		= 'admin_products/edit$1';
$route['store/admin/delete_product(/:any)?']	= 'admin_products/delete$1';

// admin list auctions
$route['store/admin/edit_auction(/:any)?'] = 'admin_auctions/edit$1';
$route['store/admin/delete_auction(/:any)?'] = 'admin_auctions/delete$1';

// admin list categories
$route['store/admin/preview(/:any)?']			= 'store/items$1';
$route['store/admin/edit_category(/:any)?']		= 'admin_categories/edit$1';
$route['store/admin/delete_category(/:any)?']	= 'admin_categories/delete$1';

$route['store/admin/category(/:any)?']			= 'admin_products/category_products$1';
