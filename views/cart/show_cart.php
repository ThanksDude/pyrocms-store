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
<div id="show_cart">
	<?php if($this->cart->contents()) { ?>
	<?php echo form_open('/store/cart/update_cart/'); ?>
	<?php echo form_hidden('redirect', current_url()); ?>
	<div id="cart_header">
		<div id="cart_header_qty"><?php echo $this->lang->line('store:cart:label:qty'); ?></div>
		<div id="cart_header_name"><?php echo $this->lang->line('store:cart:label:name'); ?></div>
		<div id="cart_header_price"><?php echo $this->lang->line('store:cart:label:price'); ?></div>
		<div id="cart_header_subtotal"><?php echo $this->lang->line('store:cart:label:subtotal'); ?></div>
	</div>
	<?php $i=1; foreach($this->cart->contents() as $items) { ?>
		<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
		<div class="cart_items">
			<div class="cart_item_qty"><?php echo form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?></div>
			<div class="cart_item_name"><a href="<?php echo site_url(); ?>store/product/view/<?php echo str_replace(' ', '-', $items['name']); ?>/" 
			 title="<?php echo $items['name']; ?>"><?php echo $items['name']; ?></a>
				<div class="cart_item_name_options">
					<?php if ($this->cart->has_options($items['rowid']) == TRUE) { ?>
					<ul class="options_list">
						<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value) { ?>
						<li class="options_item">
							<div class="options_item_name"><?php echo $option_name; ?>:&nbsp;&nbsp;</div>
							<div class="options_item_value"><?php echo $option_value; ?></div>
						</li>
						<?php } ?>
					</ul>
					<?php } ?>
                </div>
			</div>
			<div class="cart_item_price"><?php echo $this->cart->format_number($items['price']); ?></div>
			<div class="cart_item_subtotal"><?php echo $this->cart->format_number($items['subtotal']); ?></div>
		</div>
		<?php } ?>
		<div id="cart_footer">
			<div id="cart_footer">&nbsp;</div>
			<div id="cart_footer_">&nbsp;</div>
			<div id="cart_footer_label_total"><?php echo $this->lang->line('store:cart:label:total'); ?></div>
			<div id="cart_footer_text_total"><?php echo $this->cart->format_number($this->cart->total()); ?></div>
		</div>
		
		<div id="cart_controls_update">
			<?php echo form_submit('update', $this->lang->line('store:cart:button:update_short'),'id="cart_control_update"'); ?>
		</div>
	<?php echo form_close(); ?>
		<div id="cart_controls_checkout">
			<?php echo form_open('/store/checkout/purchase/'); ?>
				<?php echo form_submit('checkout', $this->lang->line('store:cart:button:checkout_short'),'id="cart_control_checkout"'); ?>
			<?php echo form_close(); ?>
		</div>
        <div class="divider"></div>
	<?php } else { ?>
		<?php echo $this->lang->line('store:cart:label:empty'); ?>
	<?php } ?>
</div>