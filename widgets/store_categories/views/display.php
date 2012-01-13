<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		pyrocms-store Team - Jaap Jolman - Kevin Meier - Rudolph Arthur Hernandez - Gary Hussey
 * @website		http://www.odin-ict.nl/
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
?>
<?php if(is_array($categories)): ?>
<ul>
	<?php foreach($categories as $category): ?>
	<li>
		<?php echo anchor("store/items/{$category->slug}", $category->name); ?>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>