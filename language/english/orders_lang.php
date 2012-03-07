<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/

/* =========================================== STORE =========================================== */

// MENU ------------------------------------------------------------------------------------------

$lang['store:orders:menu']							= 'Orders';

// SHORTCUTS -------------------------------------------------------------------------------------

$lang['store:orders:shortcut:list']					= 'List Orders';

// TITLES ----------------------------------------------------------------------------------------

$lang['store:orders:title']							= 'Orders';
$lang['store:orders:title:add']						= 'Add';
$lang['store:orders:title:edit']					= 'Edit';
$lang['store:orders:title:view']					= 'View';

// LABELS ----------------------------------------------------------------------------------------

$lang['store:orders:label:store_id']				= 'Store ID';
$lang['store:orders:label:name']					= 'Name';
$lang['store:orders:label:actions']					= 'Actions';
$lang['store:orders:label:invoice_nr']				= 'Invoice Number';
$lang['store:orders:label:amount']				    = 'Amount';
$lang['store:orders:label:status']				    = 'Status';
$lang['store:orders:label:user']				    = 'Users Name';
$lang['store:orders:label:items']				    = 'Items';
$lang['store:orders:label:shipping_address']	    = 'Shipping Address';
$lang['store:orders:label:shipping_method']	        = 'Shipping Method';
$lang['store:orders:label:shipping_cost']	        = 'Shipping Cost';




// MESSAGES --------------------------------------------------------------------------------------

$lang['store:orders:messages:information:no_items']	= 'No Orders created';
$lang['store:orders:messages:success:create']		= 'Order sucessfully created';
$lang['store:orders:messages:success:edit']			= 'Order sucessfully edited';
$lang['store:orders:messages:success:delete']		= 'Order sucessfully deleted';
$lang['store:orders:messages:error:create']			= 'Order creation failed';
$lang['store:orders:messages:error:edit']			= 'Order editing failed';
$lang['store:orders:messages:error:delete']			= 'Order deletion failed';

// BUTTONS --------------------------------------------------------------------------------------

$lang['store:orders:buttons:view']					= 'View';
$lang['store:orders:buttons:edit']					= 'Edit';
$lang['store:orders:buttons:delete']				= 'Delete';

/* End of file Orders_lang.php */