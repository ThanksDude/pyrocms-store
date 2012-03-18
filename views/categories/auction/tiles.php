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
<div id="categories">
  <ul>
    <?php foreach($categories as $category) { ?>
    <li><a href="<?php echo site_url('store/categories/explore/sub/tiles/'.str_replace(' ', '-', $category->name)); ?>/" 
	   title="<?php echo $category->name; ?>">	
	<div>
	  <h4 class="category_title"><?php echo ucfirst($category->name); ?></h4>
	</div>
	<div>		
	  <?php if (isset($category->image)) : ?>
	  <img src="<?php echo base_url('/uploads/store/categories/' . $category->image->filename);?>" alt="<?php echo $category->name; ?>" width="175" height="140"/>
	  <?php else : ?>
	  <?php echo ucfirst($category->name); ?>			
	  <?php endif; ?>
	  
	</div>
	<div>
       <h5><?php
	    if ($category->items_number == 0) { $output = "no auctions"; }
	    else if($category->items_number == 1) { $output = "1 item"; }
	    else { $output = $category->items_number . " items"; } 
	    echo $output; 
	    ?></h5>			
	</div>
      </a>	
    </li>
    <?php } ?>
  </ul>

</div>
