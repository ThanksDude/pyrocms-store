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
  <?php echo form_open('/store/customer_place_bid/' . $auction->auctions_id . '/'); ?>
  <?php echo form_hidden('redirect', current_url()); ?>
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
      <div><p><?php echo lang('store:auctions:label:html'). " : ";?></p>
	<?php echo $auction->html; ?>
      </div>
      <div><p>
	  <span><?php echo lang('store:auctions:label:price'). " : ";?>
	    <?php echo $this->cart->format_number($auction->price); ?>
          </span>
      </p></div>
      <div><p>
       <span>
      <?php echo form_input('bid',$this->cart->format_number($auction->price)) . form_submit('','Place Bid'); ?>
      </span>
      </p></div>
      <div><p>
      	  <span><?php echo lang('store:auctions:label:end_at'). " : ";?>
      		<?php echo unix_to_human($auction->end_at, TRUE, 'us'); ?>
      		 </span>
     </p></div>
      	  
    <div><p>
    	<span>
    	<?php 
    		$now = time();
    		if($auction->end_at>$now) {
    			echo lang('store:auctions:label:remaining'). " : "; 
      			echo timespan($now, $auction->end_at);
      		} else {
	      		echo lang('store:auctions:label:ended');
      		}
      	?>
      	</span>
    </p></div>
      	  
      	 
      
      <div><p><?php echo lang('store:auctions:label:stock'). " : " . $auction->stock ;?></p></div>
      
    </li>
  </ul>
	<?php 
		if($auction->allow_comments) {
			echo display_comments($auction->auctions_id, 'store_auction'); 
		}
	?>
</div>
