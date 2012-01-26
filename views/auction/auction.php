<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
?>
<div id="auction">
  <ul>
    <?php echo form_open('/store/insert_cart/' . $auction->auctions_id . '/'); ?>
    <?php echo form_hidden('redirect', current_url()); ?>
    <li>
      <div>
	<h2><?php echo $auction->name; ?></h2>
      </div>
      <div>
	<?php if(isset($auction->image)) : ?>
	<?php $name = $auction->image->name; $id = $auction->image->id; 
	$extension = $auction->image->extension; ?>			
	<img src="<?php echo base_url();?>uploads/store/auctions/<?php echo $name . $id. '_large' . $extension;?>" alt="<?php echo $auction->name; ?>" />
	<?php endif; ?>				
      </div>
      <div><p><?php echo lang('store_auction_html'). " : ";?></p>
	<?php echo $auction->html; ?>
      </div>
      <div><p>
	  <span><?php echo lang('store_auction_price'). " : ";?>
	    <?php echo $this->cart->format_number($auction->price); ?>
          </span>
	  <?php echo form_input('qty','1') . form_submit('','Add to Cart'); ?>
      </p></div>
      <div><p><?php echo lang('store_auction_stock'). " : " . $auction->stock ;?></p></div>
      
    </li>
    <?php echo form_close(); ?>
  </ul>
</div>
