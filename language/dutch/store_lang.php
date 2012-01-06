<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

// Menu

$lang['store_menu_store']							= 'Winkel';
$lang['store_menu_categories']						= 'Categorieën';
$lang['store_menu_products']						= 'Producten';

// Shortcuts
$lang['store_shortcut_store_dashboard']				= 'Dashboard';
$lang['store_shortcut_store_statistics']			= 'Statistieken';
$lang['store_shortcut_store_settings']				= 'Instellingen';
$lang['store_shortcut_categories_list']				= 'Toon Categorieën';
$lang['store_shortcut_category_add']				= 'Categorie Toevoegen';
$lang['store_shortcut_products_list']				= 'Toon Producten';
$lang['store_shortcut_product_add']					= 'Product Toevoegen';

// Titles
$lang['store_title_store_dashboard']         		= 'Dashboard';
$lang['store_title_store_statistics']         		= 'Statistieken';
$lang['store_title_store_settings']         		= 'Instellingen';
$lang['store_title_category_list']       			= 'Toon Categorieën';
$lang['store_title_category_add']        	 		= 'Categorie Toevoegen';
$lang['store_title_category_edit'] 					= 'Categorie Bewerken';
$lang['store_title_product_list']        			= 'Toon Producten';
$lang['store_title_product_add']					= 'Product Toevoegen';
$lang['store_title_product_edit']					= 'Product Bewerken';

// Tabs
$lang['store_tab_config']							= 'Winkel Instellingen';
$lang['store_tab_payment_gateways']					= 'Betalings Mogelijkheden';
$lang['store_tab_additional_info']					= 'Extra Informatie';

// Fields
$lang['store_settings_name']						= 'Winkelnaam';
$lang['store_settings_email']						= 'Standaard Emailadres';
$lang['store_settings_additional_emails']			= 'Overige Emailadressen (Scheiden met ",")';
$lang['store_settings_currency']					= 'Standaard Valuta';
$lang['store_settings_item_per_page']				= 'Objecten per Pagina';
$lang['store_settings_show_with_tax']				= 'Toon BTW';
$lang['store_settings_display_stock']				= 'Toon Voorraad';
$lang['store_settings_allow_comments']				= 'Commentaar Toestaan';
$lang['store_settings_new_order_mail_alert']		= 'Mail waarchuwing bij nieuwe bestelling';
$lang['store_settings_active']						= 'Is actief';

$lang['store_settings_paypal_enabled']				= 'Paypal Actief';
$lang['store_settings_paypal_account']				= 'Paypal Account';
$lang['store_settings_paypal_developer_mode']		= 'Ontwikkelaarsmode';

$lang['store_settings_authorize_enabled']			= 'Authorize.net Actief';
$lang['store_settings_authorize_account']			= 'Authorize.net Token';
$lang['store_settings_authorize_secret']			= 'Authorize.net Geheim';
$lang['store_settings_authorize_developer_mode']	= 'Ontwikkelaarsmode';

$lang['store_settings_terms_and_conditions']		= 'Algememe voorwaarden';
$lang['store_settings_privacy_policy']				= 'Privacy Beleid';
$lang['store_settings_delivery_information']		= 'Leverings Informatie';

// Radios
$lang['store_radio_yes']							= ' Yes ';
$lang['store_radio_no']								= ' No ';

// Labels
$lang['store_label_store_name']						= 'Winkelnaam';
$lang['store_label_is_default']						= 'Standaard';
$lang['store_label_general_options']				= 'Algemene Opties';
$lang['store_label_email']							= 'Emailadres';
$lang['store_label_email_additional']				= 'Extra Emailadressen';
$lang['store_label_active']							= 'Actief';
$lang['store_label_allow_comments']					= 'Commentaar Toestaan';
$lang['store_label_currency']						= 'Valuta';
$lang['store_label_item_per_page']					= 'Objecten per Pagina';
$lang['store_label_display_stock']					= 'Toon Voorraad';
$lang['store_label_statistics']						= 'Statistieken';
$lang['store_label_num_categories']					= '# Categorieën in de Winkel';
$lang['store_label_num_products']					= '# Producten in de Winkel';
$lang['store_label_num_pending_orders']				= '# Hangende Bestellingen';
$lang['store_label_actions']						= 'Acties';
// Cart
$lang['store_label_cart_qty']						= 'Aantal';
$lang['store_label_cart_name']						= 'Object Omschrijving';
$lang['store_label_cart_price']						= 'Object Prijs';
$lang['store_label_cart_subtotal']					= 'Sub-Total';
$lang['store_label_cart_total']						= 'Total';
$lang['store_label_cart_empty']						= 'Leeg';
// Widget Cart
$lang['store_label_widget_cart_qty']				= 'Aantal';
$lang['store_label_widget_cart_name']				= 'Naam';
$lang['store_label_widget_cart_empty']				= 'Leeg';

// Buttons
$lang['store_button_add_category']					= 'Categorie Toevoegen';
$lang['store_button_add_product']					= 'Product Toevoegen';
$lang['store_button_edit']							= 'Bewerken';
$lang['store_button_view']							= 'Bekijken';
$lang['store_button_delete']						= 'Verijderen';
$lang['store_button_backup_data']					= 'Data Backuppen';
$lang['store_button_restore_data']					= 'Data Herstellen';

// Cart
$lang['store_button_cart_checkout']					= 'Checkout';
$lang['store_button_cart_update']					= 'Update uw winkelmand';

// Widget Cart
$lang['store_button_widget_cart_details']			= 'Details';
$lang['store_button_widget_cart_update']			= 'Update';

// Messages
$lang['store_messages_no_store_error']				= 'Geen Winkel aangemaakt';
$lang['store_messages_create_success']				= 'Winkel sucessvol aangemaakt';
$lang['store_messages_create_error']				= 'Winkel aanmaken mislukt';
$lang['store_messages_edit_success']				= 'Winkel sucessvol bewerkt';
$lang['store_messages_edit_error']					= 'Winkel bewerken mislukt';
$lang['store_messages_delete_success']				= 'Winkel sucessvol verwijderd';
$lang['store_messages_delete_error']				= 'Winkel verwijderen mislukt';
$lang['store_messages_categorie_create_success']	= 'Categorie sucessfully aangemaakt';
$lang['store_messages_categorie_create_error']		= 'Categorie aanmaken mislukt';
$lang['store_messages_product_create_success']		= 'Product sucessfully aangemaakt';
$lang['store_messages_product_create_error']		= 'Product aanmaken mislukt';

// Choices
$lang['store_choice_yes']							= 'Ja';
$lang['store_choice_no']							= 'Nee';

// Add Category
$lang['store_category_add_label']					= 'Categorie Toevoegen';
$lang['store_category_add_name']					= 'Naam';
$lang['store_category_add_html']					= 'Omschrijving';
$lang['store_category_add_parent_id']				= 'Ouder';
$lang['store_category_add_images_id']				= 'Afbeelingen';
$lang['store_category_add_thumbnail']				= 'Thumbnail';
$lang['store_category_add_store_id']				= 'Winkel ID';

// Add Product
$lang['store_product_add_label']					= 'Product Toevoegen';
$lang['store_product_add_product_id']				= 'Product ID';
$lang['store_product_add_category_id']				= 'Categorie';
$lang['store_product_add_name']						= 'Naam';
$lang['store_product_add_meta_description']			= 'Meta Omschrijving';
$lang['store_product_add_meta_keywords']			= 'Meta Sleutelwoorden';
$lang['store_product_add_html']						= 'Omschrijving';
$lang['store_product_add_price']					= 'Prijs';
$lang['store_product_add_stock']					= 'Voorraad';
$lang['store_product_add_limited']					= 'Gelimiteerd Aantal';
$lang['store_product_add_limited_used']				= 'Gelimiteerd Gebruikt';
$lang['store_product_add_discount']					= 'Korting';
$lang['store_product_add_attributes_id']			= 'Attributen';
$lang['store_product_add_images_id']				= 'Afbeelingen';
$lang['store_product_add_thumbnail']				= 'Thumbnail';
$lang['store_product_add_store_id']					= 'Winkel ID';
$lang['store_product_add_allow_comments']			= 'Commentaar Toestaan';


$lang['store_product_edit_label']					= 'Product Bewerken';// Edit Product
$lang['store_category_edit_label'] 					= 'Categorie Bewerken';// Edit Category


// List Products
$lang['store_product_list_name']					= 'Naam';
$lang['store_product_list_category_id']				= 'Categorie';
$lang['store_product_list_price']					= 'Prijs';
$lang['store_product_list_thumbnail']				= 'Thumbnail';
$lang['store_product_list_discount']				= 'Korting';
$lang['store_product_list_actions']					= 'Acties';
$lang['store_currently_no_products']				= 'Momenteel geen categorieën aangemaakt';

// List Categories
$lang['store_categories_list_name']					= 'Naam';
$lang['store_categories_list_items']				= 'Objecten';
$lang['store_categories_list_category_id']			= 'Categorie';
$lang['store_categories_list_price']				= 'Prijs';
$lang['store_categories_list_parent']				= 'Ouder';
$lang['store_categories_list_thumbnail']			= 'Thumbnail';
$lang['store_categories_list_actions']				= 'Acties';
$lang['store_currently_no_categories']				= 'Momenteel geen producten aangemaakt';