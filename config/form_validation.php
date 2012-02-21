<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

$config = array(

	'settings' => array(	
			array(	'field' => 'name',
					'label' => 'lang:store_settings_name',
					'rules' => 'trim|max_length[50]|required' ),
					
			array(	'field' => 'email',
					'label' => 'lang:store_settings_email',
					'rules' => 'trim|max_length[100]|required|valid_email' ),
					
			array(	'field' => 'additional_emails',
					'label' => 'lang:store_settings_additional_emails',	
					'rules' => 'trim|max_length[100]|valid_emails' ),
					
			array(	'field' => 'currency',
					'label' => 'lang:store_settings_currency',
					'rules' => 'trim|max_length[10]|required|is_natural_no_zero') ,
					
			array(	'field' => 'item_per_page',
					'label' => 'lang:store_settings_item_per_page',
					'rules' => 'trim|max_length[10]|required' ),
					
			array(	'field' => 'show_with_tax',
					'label' => 'lang:store_settings_show_with_tax',
					'rules' => 'required'),
					
			array(	'field' => 'display_stock',
					'label' => 'lang:store_settings_display_stock',
					'rules' => 'required' ),
					
			array(	'field' => 'allow_comments',
					'label' => 'lang:store_settings_allow_comments',
					'rules' => 'required'),
					
			array(	'field' => 'new_order_mail_alert',
					'label' => 'lang:store_settings_new_order_mail_alert',
					'rules' => 'required'),
					
			array(	'field' => 'active',
					'label' => 'lang:store_settings_active',
					'rules' => 'required'),
					
			array(	'field' => 'terms_and_conditions',
					'label' => 'lang:store_settings_terms_and_conditions',
					'rules' => 'required'),
					
			array(	'field' => 'privacy_policy',
					'label' => 'lang:store_settings_privacy_policy',
					'rules' => 'required'),
					
			array(	'field' => 'delivery_information',
					'label' => 'lang:store_settings_delivery_information',
					'rules' => 'required')

		),

	'add_category' => array(
			array(	'field' => 'name',
					'label' => 'store_category_name',
					'rules' => 'trim|max_length[50]|required' ),
					
			array(	'field' => 'html',
					'label' => 'store_category_html',
					'rules' => 'trim|max_length[1000]|required' ),
					
			array(	'field' => 'parent_id',
					'label' => 'store_category_parent',
					'rules' => 'trim|max_length[10]|' ),
					
			array(	'field' => 'images_id',
					'label' => 'store_category_images_id',
					'rules' => 'trim|max_length[10]|' ),
					
			array(	'field' => 'store_store_id',
					'label' => 'store_category_store_id',
					'rules' => 'trim|max_length[10]|' )
		),

	'edit_category' => array(
			array(	'field' => 'name',
					'label' => 'store_category_name',
					'rules' => 'trim|max_length[50]|required' ),
					
			array(	'field' => 'html',
					'label' => 'store_category_html',
					'rules' => 'trim|max_length[1000]|required' ),
					
			array(	'field' => 'parent_id',
					'label' => 'store_category_parent',
					'rules' => 'trim|max_length[10]|' ),
					
			array(	'field' => 'images_id',
					'label' => 'store_category_images_id',
					'rules' => 'trim|max_length[10]|' ),
					
			array(	'field' => 'store_store_id',
					'label' => 'store_category_store_id',
					'rules' => 'trim|max_length[10]|' )
		),

	'add_product' => array(
			array('field' => 'name', 
					'label' => 'store_product_name', 
					'rules' => 'trim|max_length[50]|required'),
					
			array('field' => 'html', 
					'label' => 'store_product_html', 
					'rules' => 'trim|max_length[1000]|required'),
					
			array('field' => 'categories_id', 
					'label' => 'store_product_category', 
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'config_id',
					'label' => 'store_product_store_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'products_id',
					'label' => 'store_product_product_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'meta_description',
					'label' => 'store_product_meta_description',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'meta_keywords',
					'label' => 'store_product_meta_keywords',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'price',
					'label' => 'store_product_price',
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'stock',
					'label' => 'store_product_stock',
					'rules' => 'trim|max_length[10]|'),
			
			array('field' => 'limited',
					'label' => 'store_product_limited',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'limited_used',
					'label' => 'store_product_limited_used',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'discount',
					'label' => 'store_product_discount',
					'rules' => 'trim|max_length[10]|'),

			array('field' => 'images_id',
					'label' => 'store_product_images',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_product_thumbnail',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'allow_comments',
					'label' => 'store_product_allow_comments',
					'rules' => 'trim|max_length[10]|required')
					
		),

	'edit_product' => array(
			array('field' => 'name', 
					'label' => 'store_product_name', 
					'rules' => 'trim|max_length[50]|required'),
					
			array('field' => 'html', 
					'label' => 'store_product_html', 
					'rules' => 'trim|max_length[1000]|required'),
					
			array('field' => 'categories_id', 
					'label' => 'store_product_category', 
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'config_id',
					'label' => 'store_product_store_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'products_id',
					'label' => 'store_product_product_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'meta_description',
					'label' => 'store_product_meta_description',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'meta_keywords',
					'label' => 'store_product_meta_keywords',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'price',
					'label' => 'store_product_price',
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'stock',
					'label' => 'store_product_stock',
					'rules' => 'trim|max_length[10]|'),
			
			array('field' => 'limited',
					'label' => 'store_product_limited',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'limited_used',
					'label' => 'store_product_limited_used',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'discount',
					'label' => 'store_product_discount',
					'rules' => 'trim|max_length[10]|'),

			array('field' => 'images_id',
					'label' => 'store_product_images',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_product_thumbnail',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'allow_comments',
					'label' => 'store_product_allow_comments',
					'rules' => 'trim|max_length[10]|required')
					
				),


	'add_auction' => array(
			array('field' => 'name', 
					'label' => 'store_auction_name', 
					'rules' => 'trim|max_length[50]|required'),
					
			array('field' => 'html', 
					'label' => 'store_auction_html', 
					'rules' => 'trim|max_length[1000]|required'),
					
			array('field' => 'categories_id', 
					'label' => 'store_auction_category', 
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'config_id',
					'label' => 'store_auction_store_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'auctions_id',
					'label' => 'store_auction_auction_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'attributes_id',
					'label' => 'store_auction_attributes',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'meta_description',
					'label' => 'store_auction_meta_description',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'meta_keywords',
					'label' => 'store_auction_meta_keywords',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'price',
					'label' => 'store_auction_price',
					'rules' => 'trim|max_length[10]|required'),

			array('field' => 'start_at',
					'label' => 'store_auction_start_at',
					'rules' => 'required'),

			array('field' => 'end_at',
					'label' => 'store_auction_end_at',
					'rules' => 'required'),
					
			array('field' => 'stock',
					'label' => 'store_auction_stock',
					'rules' => 'trim|max_length[10]|'),
			
			array('field' => 'limited',
					'label' => 'store_auction_limited',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'limited_used',
					'label' => 'store_auction_limited_used',
					'rules' => 'trim|max_length[10]|'),

			array('field' => 'images_id',
					'label' => 'store_auction_images',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_auction_thumbnail',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'allow_comments',
					'label' => 'store_auction_allow_comments',
					'rules' => 'trim|max_length[10]|required')
					
		),

	'edit_auction' => array(
			array('field' => 'name', 
					'label' => 'store_auction_name', 
					'rules' => 'trim|max_length[50]|required'),
					
			array('field' => 'html', 
					'label' => 'store_auction_html', 
					'rules' => 'trim|max_length[1000]|required'),
					
			array('field' => 'categories_id', 
					'label' => 'store_auction_category', 
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'config_id',
					'label' => 'store_auction_store_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'auctions_id',
					'label' => 'store_auction_auction_id',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'attributes_id',
					'label' => 'store_auction_attributes',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'meta_description',
					'label' => 'store_auction_meta_description',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'meta_keywords',
					'label' => 'store_auction_meta_keywords',
					'rules' => 'trim|max_length[1000]|'),
					
			array('field' => 'price',
					'label' => 'store_auction_price',
					'rules' => 'trim|max_length[10]|required'),
					
			array('field' => 'start_at',
					'label' => 'store_auction_start_at',
					'rules' => 'required'),

			array('field' => 'end_at',
					'label' => 'store_auction_end_at',
					'rules' => 'required'),

			array('field' => 'stock',
					'label' => 'store_auction_stock',
					'rules' => 'trim|max_length[10]|'),
			
			array('field' => 'limited',
					'label' => 'store_auction_limited',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'limited_used',
					'label' => 'store_auction_limited_used',
					'rules' => 'trim|max_length[10]|'),

			array('field' => 'images_id',
					'label' => 'store_auction_images',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'thumbnail_id',
					'label' => 'store_auction_thumbnail',
					'rules' => 'trim|max_length[10]|'),
					
			array('field' => 'allow_comments',
					'label' => 'store_auction_allow_comments',
					'rules' => 'trim|max_length[10]|required')
					
		)

);

?>