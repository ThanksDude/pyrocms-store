<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
class Module_Store extends Module {

	public $version = '0.2';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Online Store',
				'nl' => 'Online Webwinkel',
				'de' => 'Online Store',
				'zh' => 'ç·šä¸Šĺ•†ĺş—'
			),
			'description' => array(
				'en' => 'This is a PyroCMS Store module.',
				'nl' => 'Dit is een webwinkel module voor PyroCMS',
				'de' => 'Dies ist ein Online-Shop fur PyroCMS',
				'zh' => 'é€™ć�Żä¸€ĺ€‹ PyroCMS ĺ•†ĺş—ć¨ˇçµ„'

			),
			'frontend'	=> TRUE,
			'backend'	=> TRUE,
			'skip_xss'	=> TRUE,
			'menu'		=> 'content',
			'author'	=> 'Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey - Marijan Greguric',
		
			'roles'		=> array(
				'admin_store'
			),
			
			'sections' => array(
			    'store' => array(
				    'name'		=> 'store:menu',
				    'uri'		=> 'admin/store',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'store:dashboard:shortcut',
						   'uri'	=> 'admin/store',
						   'class'	=> 'dashboard'
						),
						array(
					 	   'name'	=> 'store:statistics:shortcut',
						   'uri'	=> 'admin/store/statistics',
						   'class'	=> 'statistics'
						),
						array(
					 	   'name'	=> 'store:settings:shortcut',
						   'uri'	=> 'admin/store/settings',
						   'class'	=> 'settings'
						)
					)
				),
			    'categories' => array(
				    'name'		=> 'store:category:menu',
				    'uri'		=> 'admin/store/categories',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'store:category:shortcut:list',
						   'uri'	=> 'admin/store/categories',
						   'class'	=> 'list'
						),
						array(
					 	   'name'	=> 'store:category:shortcut:add',
						   'uri'	=> 'admin/store/categories/add',
						   'class'	=> 'add'
						)
					)
				),
			    'products' => array(
				    'name'		=> 'store:products:menu',
				    'uri'		=> 'admin/store/products',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'store:products:shortcut:list',
						   'uri'	=> 'admin/store/products',
						   'class'	=> 'list'
						),
						array(
					 	   'name'	=> 'store:products:shortcut:add',
						   'uri'	=> 'admin/store/products/add',
						   'class'	=> 'add'
						)
					)
				),
			    'auctions' => array(
					'name'		=> 'store:auctions:menu',
					'uri'		=> 'admin/store/auctions',
					'shortcuts'	=> array(
						array(
						'name'	=> 'store:auctions:shortcut:list',
						'uri'	=> 'admin/store/auctions',
						'class'	=> 'list'
						),
						array(
						'name'	=> 'store:auctions:shortcut:add',
						'uri'	=> 'admin/store/auctions/add',
						'class'	=> 'add'
						)
					)
				),
			    'orders' => array(
				    'name'		=> 'store:orders:menu',
				    'uri'		=> 'admin/store/orders',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'store:orders:shortcut:list',
						   'uri'	=> 'admin/store/orders',
						   'class'	=> 'list'
						)
					)
				),
			    'tags' => array(
				    'name'		=> 'store:tags:menu',
				    'uri'		=> 'admin/store/tags',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'store:tags:shortcut:list',
						   'uri'	=> 'admin/store/tags',
						   'class'	=> 'list'
						),
						array(
					 	   'name'	=> 'store:tags:shortcut:add',
						   'uri'	=> 'admin/store/tags/add',
						   'class'	=> 'add'
						)
					)
				),
			    'attributes' => array(
				    'name'		=> 'store:attributes:menu',
				    'uri'		=> 'admin/store/attributes',
				    'shortcuts'	=> array(
						array(
					 	   'name'	=> 'store:attributes:shortcut:list',
						   'uri'	=> 'admin/store/attributes',
						   'class'	=> 'list'
						),
						array(
					 	   'name'	=> 'store:attributes:shortcut:add',
						   'uri'	=> 'admin/store/attributes/add',
						   'class'	=> 'add'
						)
				    	,
				    	array(
				    			'name'	=> 'store:attributes:shortcut:add:category',
				    			'uri'	=> 'admin/store/attributes/add_category',
				    			'class'	=> 'add'
				    	),
						array(
					 	   'name'	=> 'store:attributes:shortcut:list:category',
						   'uri'	=> 'admin/store/attributes/category',
						   'class'	=> 'list'
						)
					)
				)
			)
		);
	}

	public function install()
	{
		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `core_stores` (
				`store_id` INT NOT NULL AUTO_INCREMENT ,
				`core_sites_id` INT(5) NOT NULL ,
				PRIMARY KEY (`store_id`, `core_sites_id`) )
			ENGINE = InnoDB;");
		
		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_settings') . "` (
				`settings_id` INT NOT NULL AUTO_INCREMENT ,
				`slug` VARCHAR(255) NOT NULL ,
				`type` VARCHAR(255) NOT NULL ,
				`value` TEXT NOT NULL ,
				`options` VARCHAR(255) NOT NULL ,
				`tab` VARCHAR(255) NOT NULL ,
				`is_required` ENUM('1','0') NOT NULL ,
				`gui` ENUM('1','0') NOT NULL ,
				`order` INT NOT NULL ,
				PRIMARY KEY (`settings_id`) )
			ENGINE = InnoDB;");
		
		$this->db->query("INSERT INTO `core_stores` (store_id, core_sites_id) VALUES (null,(SELECT `id` FROM `core_sites` WHERE ref='" . $this->site_ref . "'));");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (NULL, 'store_id', 'text',  LAST_INSERT_ID(), '', 'general', '1', '0', 0);");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'name', 'text', '', '', 'general', '1', '1', '1');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'email', 'text', '', '', 'general', '1', '1', '2');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'additional_emails', 'text', '', '', 'general', '1', '1', '3');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'currency', 'dropdown', '', '1=EUR|2=USD', 'general', '1', '1', '4');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'item_per_page', 'text', '', '', 'general', '1', '1', '5');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'show_with_tax', 'radio', '', '', 'general', '1', '1', '6');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'display_stock', 'radio', '', '', 'general', '1', '1', '7');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'allow_comments', 'radio', '', '', 'general', '1', '1', '8');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'new_order_mail_alert', 'radio', '', '', 'general', '1', '1', '9');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'active', 'radio', '', '', 'general', '1', '1', '10');");
		
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'paypal_enabled', 'radio', '0', '', 'payment-gateways', '1', '1', '12');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'paypal_account', 'text', '', '', 'payment-gateways', '1', '1', '13');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'paypal_developer_mode', 'radio', '1', '', 'payment-gateways', '1', '1', '14');");
		
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'authorize_enabled', 'radio', '0', '', 'payment-gateways', '1', '1', '15');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'authorize_account', 'text', '', '', 'payment-gateways', '1', '1', '16');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'authorize_secret', 'text', '', '', 'payment-gateways', '1', '1', '17');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'authorize_developer_mode', 'radio', '1', '', 'payment-gateways', '1', '1', '18');");
		
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'terms_and_conditions', 'wysiwyg|simple', '', '', 'extra', '1', '1', '22');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'privacy_policy', 'textarea', '', '', 'extra', '1', '1', '23');");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_settings') . "` (`settings_id`, `slug`, `type`, `value`, `options`, `tab`, `is_required`, `gui`, `order`) VALUES (null, 'delivery_information', 'textarea', '', '', 'extra', '1', '1', '24');");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_currency') . "` (
				`currency_id` INT NOT NULL AUTO_INCREMENT ,
				`currency_symbol` VARCHAR(45) NULL ,
				`currency_name` VARCHAR(100) NULL ,
				PRIMARY KEY (`currency_id`) )
			ENGINE = InnoDB;");

		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_currency') . "` (currency_id, currency_symbol, currency_name) VALUES (null, '&euro;', 'EUR') ");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_currency') . "` (currency_id, currency_symbol, currency_name) VALUES (null, '&dollar;', 'USD') ");
		
		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_status') . "` (
				`status_id` INT NOT NULL AUTO_INCREMENT ,
				`status_name` VARCHAR(255) NULL ,
				PRIMARY KEY (`status_id`) )
			ENGINE = InnoDB;");

		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_status') . "` (status_id, status_name) VALUES (null, 'store_status_new') ");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_status') . "` (status_id, status_name) VALUES (null, 'store_status_cancel') ");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_status') . "` (status_id, status_name) VALUES (null, 'store_status_awaiting_payment') ");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_status') . "` (status_id, status_name) VALUES (null, 'store_status_payment_recieved') ");
		$this->db->query("INSERT INTO `" . $this->db->dbprefix('store_status') . "` (status_id, status_name) VALUES (null, 'store_status_order_complete') ");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_users_addresses') . "` (
				`users_id` SMALLINT(5) UNSIGNED NOT NULL ,
				`addresses_users_id` INT NOT NULL AUTO_INCREMENT ,
				`firstname` VARCHAR(100) NULL ,
				`lastname` VARCHAR(100) NULL ,
				`email` VARCHAR(100) NULL ,
				`telephone` VARCHAR(45) NULL ,
				`newsletter` ENUM('1','0') NULL ,
				`shipping` ENUM('1','0') NULL ,
				`payment` ENUM('1','0') NULL ,
				`address1` VARCHAR(100) NOT NULL ,
				`address2` VARCHAR(100) NULL ,
				`organisation` VARCHAR(100) NULL ,
				`city` VARCHAR(100) NULL ,
				`postal_code` VARCHAR(8) NULL ,
				`country` VARCHAR(100) NULL ,
				`state` VARCHAR(100) NULL ,
				PRIMARY KEY (`addresses_users_id`, `users_id`) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_products') . "` (
				`products_id` INT NOT NULL AUTO_INCREMENT ,
				`categories_id` INT NOT NULL ,
				`attributes_id` INT NOT NULL ,
				`name` VARCHAR(100) NOT NULL ,
				`slug` VARCHAR(100) NOT NULL ,
				`meta_description` TEXT NULL ,
				`meta_keywords` TEXT NULL ,
				`html` LONGTEXT NULL ,
				`price` FLOAT NULL ,
				`stock` INT NULL ,
				`limited` INT NULL ,
				`limited_used` INT NULL ,
				`discount` FLOAT NULL ,
				`images_id` VARCHAR(50) NULL ,
				`thumbnail_id` VARCHAR(50) NULL ,
				`allow_comments` ENUM('1','0') NULL ,
				PRIMARY KEY (`products_id`, `categories_id`) ,
				UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_auctions') . "` (
				`auctions_id` INT NOT NULL AUTO_INCREMENT ,
				`categories_id` INT NOT NULL ,
				`attributes_id` INT NOT NULL ,
				`name` VARCHAR(100) NOT NULL ,
				`slug` VARCHAR(100) NOT NULL ,
				`meta_description` TEXT NULL ,
				`meta_keywords` TEXT NULL ,
				`html` LONGTEXT NULL ,
				`price` FLOAT NULL ,
				`stock` INT NULL ,
				`end_at` INT NULL ,
				`start_at` INT NULL ,
				`limited` INT NULL ,
				`limited_used` INT NULL ,
				`images_id` VARCHAR(50) NULL ,
				`thumbnail_id` VARCHAR(50) NULL ,
				`allow_comments` ENUM('1','0') NULL ,
				PRIMARY KEY (`auctions_id`, `categories_id`) ,
				UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_bids') . "` (
				`bid_id` INT NOT NULL AUTO_INCREMENT ,
				`auction_id` INT NOT NULL ,
				`user_id` INT NOT NULL ,
				`price` VARCHAR(255) NULL ,
				`devise` VARCHAR(255) NULL ,
				`date` VARCHAR(255) NULL ,
				PRIMARY KEY (`bid_id`) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_categories') . "` (
				`categories_id` INT NOT NULL AUTO_INCREMENT ,
				`name` VARCHAR(50) NOT NULL ,
				`slug` VARCHAR(50) NOT NULL ,
				`html` LONGTEXT NULL ,
				`parent_id` INT NULL ,
				`images_id` VARCHAR(50) NULL ,
				`thumbnail_id` VARCHAR(50) NULL ,
				PRIMARY KEY (`categories_id`) ,
				UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_attributes') . "` (
				`attributes_id` INT NOT NULL AUTO_INCREMENT ,
				`name` VARCHAR(50) NOT NULL ,
				`html` LONGTEXT NULL ,
				PRIMARY KEY (`attributes_id`) ,
				UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_tags') . "` (
				`tags_id` INT NOT NULL AUTO_INCREMENT ,
				`name` VARCHAR(50) NULL ,
				PRIMARY KEY (`tags_id`) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_products_has_tags') . "` (
				`products_id` INT NOT NULL ,
				`categories_id` INT NOT NULL ,
				`tags_id` INT NOT NULL ,
				PRIMARY KEY (`products_id`, `categories_id`, `tags_id`) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_order_addresses') . "` (
				`addresses_orders_id` INT NOT NULL AUTO_INCREMENT ,
				`firstname` VARCHAR(100) NULL ,
				`lastname` VARCHAR(100) NULL ,
				`email` VARCHAR(100) NULL ,
				`telephone` VARCHAR(45) NULL ,
				`newsletter` ENUM('1','0') NULL ,
				`shipping` ENUM('1','0') NULL ,
				`payment` ENUM('1','0') NULL ,
				`address1` VARCHAR(255) NOT NULL ,
				`address2` VARCHAR(255) NULL ,
				`organisation` VARCHAR(100) NULL ,
				`city` VARCHAR(100) NULL ,
				`postal_code` VARCHAR(8) NULL ,
				`country` VARCHAR(100) NULL ,
				`state` VARCHAR(100) NULL ,
				PRIMARY KEY (`addresses_orders_id`) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_orders') . "` (
				`orders_id` INT NOT NULL AUTO_INCREMENT ,
				`users_id` SMALLINT(5) UNSIGNED NOT NULL ,
				`invoice_nr` VARCHAR(80) NULL ,
				`ip_address` VARCHAR(20) NULL ,
				`telefone` VARCHAR(45) NULL ,
				`status` INT NULL ,
				`comments` LONGTEXT NULL ,
				`date_added` DATETIME NULL ,
				`date_modified` DATETIME NULL ,
				`payment_address` INT NOT NULL ,
				`payment_method` VARCHAR(45) NULL ,
				`shipping_address` INT NOT NULL ,
				`shipping_method` VARCHAR(45) NULL ,
				`tax` FLOAT NULL ,
				`shipping_cost` FLOAT NULL ,
				`amount` FLOAT NULL ,
				PRIMARY KEY (`orders_id`, `users_id`, `payment_address`, `shipping_address`) )
			ENGINE = InnoDB;");

		$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_orders_has_products') . "` (
				`orders_id` INT NOT NULL ,
				`users_id` SMALLINT(5) UNSIGNED NOT NULL ,
				`products_id` INT NOT NULL ,
				`number` INT NULL ,
				PRIMARY KEY (`orders_id`, `users_id`, `products_id`) )
			ENGINE = InnoDB;");
		
		$this->db->query("
		CREATE TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_product_has_attributes'). "` (
				`product_id` int(11) NOT NULL,
				`attributes_id` int(11) NOT NULL,
				PRIMARY KEY (`product_id`,`attributes_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1") ;
		
		$this->db->query("
				ALTER TABLE  `" . $this->db->dbprefix('store_product_has_attributes'). "` 
				ADD FOREIGN KEY (  `product_id` ) REFERENCES `".$this->db->dbprefix('store_products')."`  (
				`products_id`
		) ON DELETE CASCADE ON UPDATE RESTRICT ");

		if(is_dir('uploads/store') OR @mkdir('uploads/store',0777,TRUE))
		{
			// make upload folders for admin images and stuff
			if ( (is_dir('uploads/store/products') OR @mkdir('uploads/store/products',0777,TRUE) ) &&
				(is_dir('uploads/store/categories') OR @mkdir('uploads/store/categories',0777,TRUE)) && (is_dir('uploads/store/auctions') OR @mkdir('uploads/store/auctions',0777,TRUE)) ) {
				return TRUE;
			}
		}
	}

	public function uninstall()
	{
		$this->db->query("DELETE FROM `core_stores` WHERE store_id=(SELECT `value` FROM `" . $this->db->dbprefix('store_settings') . "` WHERE slug='store_id');");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_settings') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_currency') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_status') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_users_addresses') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_bids') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_categories') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_attributes') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_products') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_auctions') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_tags') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_products_has_tags') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_orders') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_order_addresses') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_orders_has_store_products') . "`;");
		$this->db->query("DROP TABLE IF EXISTS `" . $this->db->dbprefix('store_product_attributes') . "`;");
		$this->db->delete('settings', array('module' => 'store'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		switch($old_version)
		{
		case '0.1':
			{
			$this->db->query("
			CREATE  TABLE IF NOT EXISTS `" . $this->db->dbprefix('store_auctions') . "` (
				`auctions_id` INT NOT NULL AUTO_INCREMENT ,
				`categories_id` INT NOT NULL ,
				`attributes_id` INT NOT NULL ,
				`name` VARCHAR(100) NOT NULL ,
				`slug` VARCHAR(100) NOT NULL ,
				`meta_description` TEXT NULL ,
				`meta_keywords` TEXT NULL ,
				`html` LONGTEXT NULL ,
				`price` FLOAT NULL ,
				`stock` INT NULL ,
				`limited` INT NULL ,
				`limited_used` INT NULL ,
				`images_id` VARCHAR(50) NULL ,
				`thumbnail_id` VARCHAR(50) NULL ,
				`allow_comments` ENUM('1','0') NULL ,
				PRIMARY KEY (`auctions_id`, `categories_id`) ,
				UNIQUE INDEX `name_UNIQUE` (`name` ASC) )
			ENGINE = InnoDB;");
			}
		}
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */