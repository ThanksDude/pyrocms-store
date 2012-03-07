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
	<h4><?php echo lang('store:products:title')?></h4>
</section>

<section class="item">
<?php if ($products): ?>

	<?php echo form_open('admin/store/products/delete'); ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('store:products:label:thumbnail'); ?></th>
				<th><?php echo lang('store:products:label:name'); ?></th>
				<th><?php echo lang('store:products:label:category'); ?></th>
				<th><?php echo lang('store:products:label:price'); ?></th>
				<th><?php echo lang('store:products:label:discount'); ?></th>
				<th width="320" class="align-center"><span><?php echo lang('store:products:label:actions'); ?></span></th>
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
			<?php foreach($products as $product) { ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $product->products_id); ?></td>
					<td><?php if (isset($product->image)) { echo $product->image; } 
								 else { echo $this->images_m->no_image(); } ?></td>
					<td><?php echo $product->name; ?></td>
					<td><?php 
							if (isset($product->category->name)) { 
								$output = '<a href="admin/store/category/';
								$output .= str_replace(' ', '-', $product->category->name) . '" ';
								$output .= ' >';						
								$output .= $product->category->name; 
								$output .= '</a>';
							} 
							else { $output = "-------"; }
							echo $output;  
					?></td>
					<td><?php echo $product->price; ?></td>
					<td><?php echo $product->discount; ?></td>
					<td class="align-center buttons buttons-small">
					   <?php 
					   if (isset($product->category->name))
					   {
					   		$title = 'title="'. ucfirst($product->category->name) . ' - ' . ucfirst($product->name) . '" '; 
					   }
					   else
					   {
					   		$title = 'title="'. ucfirst($product->name) . '" '; 
					   }
					    ?>
						<?php echo anchor('store/product/view/' . $product->slug, lang('store:products:buttons:preview'), $title . 'rel="preview" class="preview btn green" target="_blank"'); ?>
						<?php echo anchor('admin/store/products/edit/' . $product->products_id, lang('store:products:buttons:edit'), 'class="btn orange edit"'); ?>
						<?php echo anchor('admin/store/products/delete/' . $product->products_id, lang('store:products:buttons:delete'), array('class'=>'confirm btn red delete')); ?>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<div class="table_action_buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
	</div>

	<?php echo form_close(); ?>

	<?php else: ?>
        <div class="no_data"><?php echo lang('store:products:messages:information:no_items'); ?></div>
    <?php endif; ?>
</section>