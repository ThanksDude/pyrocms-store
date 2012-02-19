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
<section class="title">
    <h4><?php echo lang('store:orders:title:'.$this->method);?></h4>
</section>

<section class="item">

		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('even', ''); ?>">
				<label for="name"><?php echo lang('store:orders:label:invoice_nr'); ?></label>
				<div><?php echo $order->invoice_nr; ?></div>
			</li>
			
			<li class="<?php echo alternator('even', ''); ?>">
				<label for="name"><?php echo lang('store:orders:label:status'); ?></label>
				<div><?php echo lang('store:status:orders:'.$status->status_name); ?></div>
			</li>
			
			<li class="<?php echo alternator('even', ''); ?>">
				<label for="name"><?php echo lang('store:orders:label:user'); ?></label>
				<div><?php echo $users_name; ?></div>
			</li>
			
			<li class="<?php echo alternator('even', ''); ?>">
				<label for="name"><?php echo lang('store:orders:label:shipping_address'); ?></label>
				<div><?php echo $order->shipping_address; ?></div>
			</li>

			<li class="<?php echo alternator('even', ''); ?>">
				<label for="name"><?php echo lang('store:orders:label:shipping_method'); ?></label>
				<div><?php echo $order->shipping_method; ?></div>
			</li>
            
            <li class="<?php echo alternator('even', ''); ?>">
            	<label for="name"><?php echo lang('store:orders:label:items'); ?></label>
            	<div>
            		<?php foreach($items as $item) { ?>
            				<span><?php echo($item['quantities']); ?> x <?php echo($item['name']); ?> - <?php echo($item['price']); ?></span><br>
            		<?php } ?>
            	
            	</div>
            </li>

			<li class="<?php echo alternator('even', ''); ?>">
            	<label for="name"><?php echo lang('store:orders:label:amount'); ?></label>
            	<div><?php echo $order->amount; ?></div>
            </li>

			<li class="<?php echo alternator('even', ''); ?>">
            	<label for="name"><?php echo lang('store:orders:label:shipping_cost'); ?></label>
            	<div><?php echo $order->shipping_cost ?></div>
            </li>

			<li class="<?php echo alternator('even', ''); ?>">
            	<label for="name"><?php echo lang('store:orders:label:name','name'); ?></label>
            	<div><?php print_r($order) ?></div>
            </li>

        </ul>
		
		</div>
		

		

</section>