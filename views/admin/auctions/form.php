<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a store module for PyroCMS
 *
 * @author 	Antoine Benevaut, Chris Manouvrier
 * @website	www.oursITshow.org
 * @package 	pyrocms-store
 * @subpackage 	Store Module
**/
?>

<section class="title">
  <h4><?php echo lang('store:auctions:title:'.$this->method);?></h4>
</section>

<section class="item">
  <?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
  <div class="form_inputs">
	<fieldset>
    <ul>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="category"><?php echo lang('store:auctions:label:category','categories_id'); ?> <span><?php echo lang('required_label');?></span></label>
		<div class="input"><?php echo form_dropdown('categories_id', $categories , set_value('categories_id', $auction->categories_id), 'class="text" maxlength="50"'); ?></div>
      </li>	

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="name"><?php echo lang('store:auctions:label:name','name'); ?> <span><?php echo lang('required_label');?></span></label>
		<div class="input"><?php echo form_input('name',set_value('name', $auction->name),'class="text" maxlength="50"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="html"><?php echo lang('store:auctions:label:html','html'); ?> <span><?php echo lang('required_label');?></span></label>
		<div class="input"><?php echo form_textarea('html',set_value('html', $auction->html),'class="wysiwyg-simple" maxlength="1000" rows="7"'); ?></div>
      </li>
      
      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="meta_description"><?php echo lang('store:auctions:label:meta_description','meta_description'); ?></label>
		<div class="input"><?php echo form_textarea('meta_description', set_value('meta_description',$auction->meta_description), ' class="" maxlength="1000" rows="3"');?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="meta_keywords"><?php echo lang('store:auctions:label:meta_keywords','meta_keywords'); ?></label>
		<div class="input"><?php echo form_input('meta_keywords',set_value('meta_keywords',$auction->meta_keywords), 'class="text" maxlength="50"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="attributes"><?php echo lang('store:auctions:label:attributes','attributes_id'); ?></label>
		<div class="input"><?php echo form_input('attributes_id',set_value('attributes_id',$auction->attributes_id),'class="text" maxlength="50"'); ?></div>
      </li>		

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="price"><?php echo lang('store:auctions:label:price','price'); ?> <span><?php echo lang('required_label');?></span></label>
		<div class="input"><?php echo form_input('price',set_value('price',$auction->price),'class="text" maxlength="10"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="start_at"><?php echo lang('store:auctions:label:start_at','start_at'); ?> <span><?php echo lang('required_label');?></span></label>
		<div class="input"><?php echo form_input('start_at',set_value('start_at',$auction->start_at),'class="text" maxlength="10"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
      	<label for="end_at"><?php echo lang('store:auctions:label:end_at','end_at'); ?> <span><?php echo lang('required_label');?></span></label>
      	<div class="input"><?php echo form_input('end_at',set_value('end_at',$auction->end_at),'class="text" maxlength="10"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="stock"><?php echo lang('store:auctions:label:stock','stock'); ?></label>
		<div class="input"><?php echo form_input('stock',set_value('stock',$auction->stock),'class="text" maxlength="10"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="limited"><?php echo lang('store:auctions:label:limited','limited'); ?></label>
		<div class="input"><?php echo form_input('limited',set_value('limited',$auction->limited),'class="text" maxlength="10"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="limited_used"><?php echo lang('store:auctions:label:limited_used','limited_used'); ?></label>
		<div class="input"><?php echo form_input('limited_used',set_value('limited_used',$auction->limited_used),'class="text" maxlength="10"'); ?></div>
      </li>

      <li class="<?php echo alternator('', 'even'); ?>">
      		<label for="images_id"><?php echo lang('store:auctions:label:images','images_id'); ?></label>
      		<div class="input">
      		<!-- 			<?php echo form_input('images_id',set_value('images_id',$auction->images_id),'class="width-15 text" maxlength="10"'); ?> -->
      		<?php 
      			if( isset($auction_image) && $auction_image){
      				$output = '<a href="uploads/store/auctions/' . $auction_image->filename . '"';
      				$output .= ' rel="cbox_images" class="auction_images"  >';
      				$output .= '<img src="uploads/store/auctions/' . $auction_image->name . '_thumb'. $auction_image->extension;
      				$output .= '" alt="' . $auction_image->name . '" /></a>';
      				echo $output;
      			}
      		?>
      		<?php echo form_upload('userfile'); ?></div>
      	</li>

      <li class="<?php echo alternator('', 'even'); ?>">
      		<label for="thumbnail_id"><?php echo lang('store:auctions:label:thumbnail','thumbnail_id'); ?> <span><?php echo lang('required_label');?></span></label>
      		<div class="input"><?php echo form_input('thumbnail_id',set_value('thumbnail_id',$auction->thumbnail_id),'class="width-15 text" maxlength="10"'); ?></div>
      	</li>
      
      <li class="<?php echo alternator('', 'even'); ?>">
		<label for="allow_comments"><?php echo lang('store:auctions:label:allow_comments','allow_comments'); ?></label>
        <div class="input"><?php echo form_radio('allow_comments','1',($auction->allow_comments == 1)).' '.$this->lang->line('store:forms:choice:yes'); ?></div>
        <div class="input"><?php echo form_radio('allow_comments','0',($auction->allow_comments == 0)).' '.$this->lang->line('store:forms:choice:no'); ?></div>
      </li>

    </ul>
    </fieldset>

    <div class="buttons float-right padding-top">
      <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save_exit', 'cancel') )); ?>
    </div>

</div>
<?php echo form_close(); ?>
</section>
<!-- <?php $this->load->view('fragments/wysiwyg', ''); ?> -->
