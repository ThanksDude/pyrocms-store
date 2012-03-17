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

<script type="text/javascript" >
 
$(document).ready(function() {
// vertical tabs by mehdi mousavi
	var $items = $('#vtab>ul>li');
	
// set the menu buttons click function (used to be mouseover)
	$items.click(function() {
   	$items.removeClass('selected');
   	$(this).addClass('selected');
		var index = $items.index($(this));

	 	if($(document).scrollTop() > ($('#menu').height()/2)){
    		$('body,html').animate({ scrollTop: 0 }, 800, function(){ 
				$('#vtab>div').fadeOut(0).eq(index).fadeIn(0);    				
    		});
    		
    	}
    	else { $('#vtab>div').fadeOut(0).eq(index).fadeIn(); }
    	
	}).eq(0).click();// click the first element of the menu
	
	$('#menu').stickyfloat({ duration: 800, offsetY: 250 });

	// make the message box disappear after 3 seconds. 	
	setTimeout(function(){ $('.alert').slideUp('slow');  }, 1000); 
		

 });// end document ready
</script>

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
	<h4>Bid management</h4>
</section>

<section class="item">

<div id="vtab">
	<ul id="menu">
		<li style="display:inline;list-style:none;" class="bid_cur"><a>My current bids</a></li>
		<li class="bid_won" style="display:inline;list-style:none;margin-left:15px;"><a>My won bids</a></li>
	</ul>
		<!-- index tab -->
	<div>
		<!-- <h4>My current bids</h4> -->
		<div class="" id="general">
		<fieldset>
		<ul>
    <?php if (isset($current_bid) && !empty($current_bid)): ?>
    <table border="0" style="width:250px;text-align:center;">
    <tr>
    <th>Auction</th>
    <th>Price</th>
    </tr>
    <?php foreach ($current_bid as $bid_info): ?>
    <tr>
    <td><a href="<?php echo site_url(); ?>/store/auction/view/<?php echo $bid_info['auction']->slug; ?>/" title="<?php echo $bid_info['auction']->name; ?>"><?php echo $bid_info['auction']->name; ?></a></td>
    <td><?php echo $bid_info['bid'][0]->price; ?></td>
    </tr>
 <?php endforeach; ?>
    </table>
 <?php else: ?>
    Vous n'avez pas encore encheris !
 <?php endif; ?>
    
    </ul>
    </fieldset>
		</div>	
	</div>
	
   <!-- Payment Gateways tab -->	
	<div>
		<!-- <h4>My won bids</h4> -->
		<div class="" id="payment-gateways">
		<fieldset>
		<ul>

    <?php if (isset($won_bid) && !empty($won_bid)): ?>
       <table border="0" style="width:250px;text-align:center;">
    <tr>
    <th>Auction</th>
    <th>Price</th>
    </tr>
    <?php foreach ($won_bid as $bid_info): ?>
    <tr>
    <td><a href="<?php echo site_url(); ?>/store/auction/view/<?php echo $bid_info['auction']->slug; ?>/" title="<?php echo $bid_info['auction']->name; ?>"><?php echo $bid_info['auction']->name; ?></a></td>
    <td><?php echo $bid_info['bid']->price; ?></td>
    </tr>
 <?php endforeach; ?>
    </table>
 <?php else: ?>
    Vous n'avez pas encore gagner d'enchere !
 <?php endif; ?>
		</ul>
		</fieldset>
		</div>     
	</div>
	
</div>

</section>

</div>

<div id="blank_container" class="bottom"></div>
<!-- #blank_container : end -->