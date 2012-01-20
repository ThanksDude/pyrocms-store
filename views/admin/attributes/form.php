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
    <h4><?php echo lang('store_title_attribute_'.$this->method);?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('store_attribute_name','name'); ?> <span><?php echo lang('required_label');?></span></label>
				<div class="input"><?php echo form_input('name', set_value('name',$attribute->name), 'class="width-15 text" maxlength="50"'); ?></div>
            </li>
            
			<li class="<?php echo alternator('', 'even'); ?>">
                <label for="name"><?php echo lang('store_attribute_html','html'); ?> <span><?php echo lang('required_label');?></span></label>
                <div class="input"><?php echo form_textarea('html', set_value('html',$attribute->html), 'class="wysiwyg-simple" maxlength="1000"'); ?></div>
            </li>
        </ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>
<!-- <?php $this->load->view('fragments/wysiwyg', ''); ?> -->