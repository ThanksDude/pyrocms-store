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

<section class="title">
  <h4><?php echo lang('store_title_auction_'.$action);?></h4>
</section>

<section class="item">
  <?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
  <div>

    <ol>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_category','categories_id'); ?>
	<?php echo form_dropdown('categories_id', $categories , set_value('categories_id', $auction->categories_id), 'class="text" maxlength="50"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
      </li>	

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_name','name'); ?>
	<?php echo form_input('name',set_value('name', $auction->name),'class="text" maxlength="50"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_html','html'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>			
	<?php echo form_textarea('html',set_value('html', $auction->html),'class="wysiwyg-simple" maxlength="1000" rows="7"'); ?>
      </li>
      
      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_meta_description','meta_description'); ?>
	<?php echo form_textarea('meta_description', set_value('meta_description',$auction->meta_description), ' class="" maxlength="1000" rows="3"');?>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_meta_keywords','meta_keywords'); ?>
	<?php echo form_input('meta_keywords',set_value('meta_keywords',$auction->meta_keywords), 'class="text" maxlength="50"'); ?>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_attributes','attributes_id'); ?>
	<?php echo form_input('attributes_id',set_value('attributes_id',$auction->attributes_id),'class="text" maxlength="50"'); ?>
      </li>		

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_price','price'); ?>
	<?php echo form_input('price',set_value('price',$auction->price),'class="text" maxlength="10"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_start_at','start_at'); ?>
	<?php echo form_input('start_at',set_value('start_at',$auction->start_at),'class="text" maxlength="10"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_end_at','end_at'); ?>
	<?php echo form_input('end_at',set_value('end_at',$auction->end_at),'class="text" maxlength="10"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_stock','stock'); ?>
	<?php echo form_input('stock',set_value('stock',$auction->stock),'class="text" maxlength="10"'); ?>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_limited','limited'); ?>
	<?php echo form_input('limited',set_value('limited',$auction->limited),'class="text" maxlength="10"'); ?>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_limited_used','limited_used'); ?>
	<?php echo form_input('limited_used',set_value('limited_used',$auction->limited_used),'class="text" maxlength="10"'); ?>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_images','images_id'); ?>
	<!-- <?php echo form_input('images_id',set_value('images_id',$auction->images_id),'class="text" maxlength="10"'); ?> -->
	<?php 
	   if( isset($auction_image) && $auction_image){
	   $output = '<a href="uploads/store/auctions/' . $auction_image->filename . '"';
			 $output .= ' rel="cbox_images" class="auction_images"  >';
	   $output .= '<img src="uploads/store/auctions/' . $auction_image->name . '_thumb'. $auction_image->extension;
				 $output .= '" alt="' . $auction_image->name . '" /></a>';
	   echo $output;
	   }
	   ?>
	<?php echo form_upload('userfile'); ?>
      </li>

      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_thumbnail','thumbnail_id'); ?>
	<?php echo form_input('thumbnail_id',set_value('thumbnail_id',$auction->thumbnail_id),'class="text" maxlength="10"'); ?>			
      </li>
      
      <li class="<?php echo alternator('even', ''); ?>">
	<?php echo lang('store_auction_allow_comments','allow_comments'); ?>
        <?php echo form_radio('allow_comments','1',TRUE).$this->lang->line('store_choice_yes'); ?>
        <?php echo form_radio('allow_comments','0',FALSE).$this->lang->line('store_choice_no'); ?>
      </li>

    </ol>

    <div class="buttons float-right padding-top">
      <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save_exit', 'cancel') )); ?>
    </div>

</div>
<?php echo form_close(); ?>
</section>
<!-- <?php $this->load->view('fragments/wysiwyg', ''); ?> -->
