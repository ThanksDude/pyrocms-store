<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 		Antoine Benevaut
 * @website		http://www.ThanksDu.de
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
?>

<section class="title">
	<h4>Place bid</h4>
</section>

<section class="item">
<ul>
   <li><?php echo $auction->name; ?></li>
   <li><?php echo $auction->html; ?></li>
<li><img src="uploads/store/categories/<?php echo $img_cat_auction->filename; ?>" width="150" height="150" /></li>
<li><img src="uploads/store/auctions/<?php echo $img_auction->filename; ?>" width="150" height="150" /></li>
</ul>

   <?php echo form_open('store/customer/place_bid/'.$auction->id); ?>
<ul>
  <li>
    <label for="email">Your price</label>
	<?php if ($auction->status === '1') : ?>
      <?php echo form_input('price',$this->cart->format_number($auction->price)).form_hidden('id', $auction->id, 'class="maxlength="100""').form_hidden('slug', $auction->slug, 'class="maxlength="100""').form_submit('','Place Bid'); ?>
	<?php endif; ?>
  </li>
</ul>
<?php echo form_close(); ?>
</section>
