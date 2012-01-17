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
    <h4><?php echo lang('store_title_category_'.$action);?></h4>
</section>

<section class="item">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	<div class="form_inputs">
		<ul>
			<li>
				<label for="name"><?php echo lang('store_category_name','name'); ?><span>*</span></label>
				<div class="input"><?php echo form_input('name', set_value('name',$category->name), 'maxlength="100" id="name"'); ?></div>
            </li>
            <li class="even editor">
                <label for="name"><?php echo lang('store_category_html','html'); ?><span>*</span></label>
                <div class="input"><?php echo form_textarea(array('id' => 'html', 'name' => 'html', 'value' => $category->html, 'rows' => 3, 'class' => 'wysiwyg-simple')); ?></div>
            </li>
            
            <li>
				<label for="parent_id"><?php echo lang('store_category_parent','parent_id'); ?></label>
				<div class="input"><?php echo form_dropdown('parent_id', $dropdown , '0') ?></div>
            </li>
            <li>
                <label for="images_id"><?php echo lang('store_category_images_id','images_id'); ?></label>
				 <div class="input"><?php if(isset($category->image)){ echo $category->image . '&nbsp;';} ?><?php echo form_upload('userfile'); ?></div>
				
            </li>
		</ul>
    </div>
    <div class="buttons float-right padding-top">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
    </div>    
	<?php echo form_close(); ?>
</section>