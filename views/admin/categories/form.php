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
    <h4><?php echo lang('store:category:title:'.$this->method);?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('store:category:label:name','name'); ?><span>*</span></label>
				<div class="input"><?php echo form_input('name', set_value('name',(isset($category)) ? $category->name : ''), 'maxlength="100" id="name"'); ?></div>
            </li>
            
            <li class="<?php echo alternator('', 'even'); ?> editor">
                <label for="html"><?php echo lang('store:category:label:html','html'); ?><span>*</span></label>
                <div class="input"><?php echo form_textarea(array('id' => 'html', 'name' => 'html', 'value' => (isset($category)) ? $category->html : '', 'rows' => 3, 'class' => 'wysiwyg-simple')); ?></div>
            </li>
            
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="parent_id"><?php echo lang('store:category:label:parent','parent_id'); ?></label>
				<div class="input"><?php echo form_dropdown('parent_id', isset($dropdown) ? $dropdown : array( '0' => 'None') , '0') ?></div>
            </li>
            
			<li class="<?php echo alternator('', 'even'); ?>">
                <label for="images_id"><?php echo lang('store:category:label:images_id','images_id'); ?></label>
				 <div class="input"><?php if(isset($category->image)){ echo $category->image . '&nbsp;';} ?><?php echo form_upload('userfile'); ?></div>
				
            </li>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>
<!-- <?php $this->load->view('fragments/wysiwyg', ''); ?> -->