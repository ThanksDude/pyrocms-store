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
    <li>
      <div>
	<h2><?php echo $auction->name; ?></h2>
	{{ ratings:vote steps="5" module="store_auction" item-id="<?php echo $auction->auctions_id; ?>" }}
	<a href="{{ url }}">{{ theme:image file="<?php echo base_url(); ?>uploads/default/{{ status }}.gif" alt="vote {{item}}" }}</a>
	{{ /ratings:vote }}
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
      <div>
<p>
	  <span><?php echo lang('store_auction_price'). " : ";?>
	    <?php echo $this->cart->format_number($auction->price); ?>
          </span>
      </p></div>

      <div>
<p>
	  <span>Time
	<?php echo standard_date('DATE_RSS', round(abs($auction->end_at - $auction->start_at))); ?>
          </span>
      </p></div>

      <div><p><?php echo lang('store_auction_stock'). " : " . $auction->stock ;?></p></div>
      
    </li>
  </ul>
	<?php echo display_bids($auction); ?>
	<?php echo display_comments($auction->auctions_id, 'store_auction'); ?>
</div>
