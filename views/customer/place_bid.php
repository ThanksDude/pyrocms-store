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

<!-- #blank_container : container full width -->
<div id="blank_container" class="top"></div>

<div id="blank_container" class="content">
  

<div id="blank_container" class="sidebar">
  <div id="blank_container" class="sidebar top"></div>
  <div id="blank_container" class="sidebar content">
    <ul>
    {{ navigation:links group="users-edit_profile" }}
    </ul>
  </div>
  <div id="blank_container" class="sidebar bottom"></div>
</div>

<section class="title">
	<h4>Place bid</h4>
</section>

<section class="item">

<ul>
   <li><?php echo $auction->name; ?></li>
   <li><?php echo $auction->html; ?></li>
<li><img src="/uploads/store/auctions/<?php echo $img_auction->filename; ?>" /></li>
<li></li>
</ul>

   <?php echo form_open('store/customer/place_bid/'.$auction->auctions_id); ?>
<ul>
  <li>
    <label for="email">Your price</label>
   <?php echo form_input('price', (isset($last_bid) ? $last_bid[0]->price : $auction->price), 'class="maxlength="100""'); ?>
  </li>
  <br/>
  <li>
   <?php echo form_hidden('id', $auction->auctions_id, 'class="maxlength="100""'); ?>
   <?php echo form_hidden('slug', $auction->slug, 'class="maxlength="100""'); ?>
   <?php echo form_submit('submit', 'Send'); ?>
  </li>
</ul>
<?php echo form_close(); ?>
</section>

</div>

<div id="blank_container" class="bottom"></div>
<!-- #blank_container : end -->