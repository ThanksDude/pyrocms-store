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
<div id="product">
	<ul>
		<?php echo form_open('/store/cart/insert_cart/' . $product->products_id . '/'); ?>
		<?php echo form_hidden('redirect', current_url()); ?>
		<li>
			<div>
				<h2><?php echo $product->name; ?></h2>
			</div>
			<div>
			<?php if(isset($product->image)) : ?>
				<?php $name = $product->image->name; $id = $product->image->id; 
						$extension = $product->image->extension; ?>			
				<img src="<?php echo site_url('uploads/store/products/' . $name . $id. '_large' . $extension);?>" alt="<?php echo $product->name; ?>" />
			<?php endif; ?>
			</div>
			<div><p><?php echo lang('store:products:label:html'). " : ";?></p>
						<?php echo $product->html; ?>
			</div>
			<?php if(isset($product->attributes)) {
				foreach ($product->attributes as $attribute) {

			 ?>
				<div>
				<span><?php echo $attribute['name'];?> : <?php echo form_dropdown($attribute['name'], $attribute['options'], 'class="width-15 text" maxlength="50"'); ?></span>
				</div>
			<? }
			}?>
			<div><p>
				<span><?php echo lang('store:products:label:price'). " : ";?>
						<?php echo $this->cart->format_number($product->price); ?>
                </span>
				<?php echo form_input('qty','1') . form_submit('','Add to Cart'); ?>
			</p></div>
			<div><p><?php echo lang('store:products:label:stock'). " : " . $product->stock ;?></p></div>

		</li>
		<?php echo form_close(); ?>
	</ul>
	<?php 
		if($product->allow_comments) {
			echo display_comments($product->products_id, 'store_product'); 
		}
	?>
</div>
