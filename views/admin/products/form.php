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
<section class="title">
	<h4><?php echo lang('store:products:title:'.$this->method);?></h4>
</section>

<section class="item">


	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

	<!-- Start store tabs -->
	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#store-general-tab"><span><?php echo lang('store:products:tabs:general'); ?></span></a></li>
			<li><a href="#store-categories-tab"><span><?php echo lang('store:products:tabs:categories'); ?></span></a></li>
			<li><a href="#store-attribute-tab"><span><?php echo lang('store:products:tabs:attributes'); ?></span></a></li>
			<li><a href="#store-image-tab"><span><?php echo lang('store:products:tabs:images'); ?></span></a></li>
			<li><a href="#store-tag-tab"><span><?php echo lang('store:products:tabs:tags'); ?></span></a></li>
		</ul>
	
		<!-- General tab -->
		<div class="form_inputs" id="store-general-tab">
	    <fieldset>   
		<ul>
			
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('store:products:label:name','name'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('name',set_value('name', $product->name),'class="width-15 text" maxlength="50"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="html"><?php echo lang('store:products:label:html','html'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_textarea('html',set_value('html', $product->html),'class="wysiwyg-simple" maxlength="1000" rows="7"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="meta_description"><?php echo lang('store:products:label:meta_description','meta_description'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_textarea('meta_description', set_value('meta_description',$product->meta_description), ' class="" maxlength="1000" rows="3"');?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="meta_keywords"><?php echo lang('store:products:label:meta_keywords','meta_keywords'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('meta_keywords',set_value('meta_keywords',$product->meta_keywords), 'class="width-15 text" maxlength="50"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="price"><?php echo lang('store:products:label:price','price'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('price',set_value('price',$product->price),'class="width-15 text" maxlength="10"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="discount"><?php echo lang('store:products:label:discount','discount'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('discount',set_value('discount',$product->discount),'class="width-15 text" maxlength="10"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="stock"><?php echo lang('store:products:label:stock','stock'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('stock',set_value('stock',$product->stock),'class="width-15 text" maxlength="10"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="limited"><?php echo lang('store:products:label:limited','limited'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('limited',set_value('limited',$product->limited),'class="width-15 text" maxlength="10"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="limited_used"><?php echo lang('store:products:label:limited_used','limited_used'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('limited_used',set_value('limited_used',$product->limited_used),'class="width-15 text" maxlength="10"'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="allow_comments"><?php echo lang('store:products:label:allow_comments','allow_comments'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_radio('allow_comments','1',TRUE).$this->lang->line('store_choice_yes'); ?></div>
				<div class="input"><?php echo form_radio('allow_comments','0',FALSE).$this->lang->line('store_choice_no'); ?></div>
			</li>
		</ul>
		</fieldset>
		</div>
		<!-- Category tab -->
		<div class="form_inputs" id="store-categories-tab">
	    <fieldset>
	       <ul>
	       	<li class="<?php echo alternator('', 'even'); ?>">
				One product can be in more then one category!	
			</li>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="categories_id"><?php echo lang('store:products:label:category','categories_id'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_dropdown('categories_id', $categories , set_value('categories_id', $product->categories_id), 'class="width-15 text" maxlength="50"'); ?></div>
			</li>
	       </ul>
	    </fieldset>
	    </div> 
		<!-- Attribute tab -->
		<div class="form_inputs" id="store-attribute-tab">
		<fieldset>
	       <ul>
	       	<li class="<?php echo alternator('', 'even'); ?>">
				<label for="attributes_id"><?php echo lang('store:products:label:attributes','attributes_id'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('attributes_id',set_value('attributes_id',$product->attributes_id),'class="width-15 text" maxlength="50"'); ?></div>
			</li>
	       </ul>
	    </fieldset>
		</div>
		<!-- Image tab -->
		<div class="form_inputs" id="store-image-tab">
	    <fieldset>
	       <ul>
	       <li class="<?php echo alternator('', 'even'); ?>">
				<label for="images_id"><?php echo lang('store:products:label:images','images_id'); ?></label>
				<div class="input">
				<!-- 			<?php echo form_input('images_id',set_value('images_id',$product->images_id),'class="width-15 text" maxlength="10"'); ?> -->
				<?php 
					if( isset($product_image) && $product_image){
						$output = '<a href="uploads/store/products/' . $product_image->filename . '"';
						$output .= ' rel="cbox_images" class="product_images"  >';
						$output .= '<img src="uploads/store/products/' . $product_image->name . '_thumb'. $product_image->extension;
						$output .= '" alt="' . $product_image->name . '" /></a>';
						echo $output;
					}
				?>
				<?php echo form_upload('userfile'); ?></div>
			</li>
			
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="thumbnail_id"><?php echo lang('store:products:label:thumbnail','thumbnail_id'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('thumbnail_id',set_value('thumbnail_id',$product->thumbnail_id),'class="width-15 text" maxlength="10"'); ?></div>
			</li>
	       </ul>
	    </fieldset>
	    </div> 
	    <!-- Tags tab -->
		<div class="form_inputs" id="store-tag-tab">
	    <fieldset>
	       <ul>
	       	<li class="<?php echo alternator('', 'even'); ?>">
				Tab for product tags
			</li>
			
	       </ul>
	    </fieldset>
	    </div> 
	</div><!-- End of store tabs -->	
	   
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>
<!-- <?php $this->load->view('fragments/wysiwyg', ''); ?> -->