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
<div id="category">
  <ul>
    <?php if(isset($auctions)): ?>
    <?php foreach($auctions as $auction): ?>
    <li><a href="<?php echo site_url(); ?>/store/auction/view/<?php echo $auction->slug; ?>/" 
	   title="<?php echo $auction->name; ?>">
	<div>
	  <h4><?php echo $auction->name; ?></h4>
	</div>
	<div>
	  <?php if(isset($auction->image)) : ?>
	  <?php
	  $name = $auction->image->name;
		$id = $auction->image->id;
	  $extension = $auction->image->extension; ?>
	  <img src="<?php echo base_url(); ?>/uploads/store/auctions/<?php echo $name . $id . $extension; ?>" alt="<?php echo $auction->name; ?>" />
	  <?php else : ?>
	  <?php echo "no image"; ?>		
	  <?php endif; ?>
	</div>
      </a>
    </li>
    <?php endforeach; ?>
    <?php else : ?>
    <li style="padding: 10px 15px 10px 15px; ">
      <div><a href="store" >no auctions</a></div>	
    </li>
    <?php endif; ?>
  </ul>
</div>
