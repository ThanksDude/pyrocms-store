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
	<h4><?php echo lang('store:category:title')?></h4>
</section>

<section class="item">
	
	<?php if ($categories): ?>

		<?php echo form_open('admin/store/categories/delete'); ?>
    
        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('store:category:label:thumbnail'); ?></th>
                    <th><?php echo lang('store:category:label:name'); ?></th>
                    <th><?php echo lang('store:category:label:items'); ?></th>
                    <th><?php echo lang('store:category:label:category_id'); ?></th>
                    <th><?php echo lang('store:category:label:parent'); ?></th>
                    <th width="320" class="align-center"><span><?php echo lang('store:category:label:actions'); ?></span></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach($categories as $category) { ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $category->categories_id); ?></td>
								<td><?php if (isset($category->image)) { echo $category->image; }
											 else { echo $this->images_m->no_image(); } ?></td>
                        <td><?php 
										if (isset($category->name)) { 
											$output = '<a href="admin/store/category/';
											$output .= str_replace(' ', '-', $category->name) . '" >';							
											$output .= $category->name; 
											$output .= '</a>';
										} 
										else { $output = "-------"; }
										echo $output;  
							?></td>
								<td><?php echo $this->products_m->count_products($category->categories_id); ?></td>
                        <td><?php echo $category->categories_id; ?></td>
                        <td><?php echo $category->parent_id; ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('admin/store/categories/edit/' . $category->categories_id, lang('store:category:buttons:edit'), 'class="btn orange edit"'); ?>
                            <?php echo anchor('admin/store/categories/delete/' . $category->categories_id, lang('store:category:buttons:delete'), array('class'=>'confirm btn red delete')); ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

		<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		</div>

		<?php echo form_close(); ?>

	<?php else: ?>
		<div class="no_data"><?php echo lang('store:category:messages:information:no_items'); ?></div>
	<?php endif; ?>
</section>