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
   <h4><?php echo lang('store_title_auction_list')?></h4>
</section>

<section class="item">
<?php if ($auctions): ?>

	<?php echo form_open('admin/store/list_auctions'); ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('store_auction_thumbnail'); ?></th>
				<th><?php echo lang('store_auction_name'); ?></th>
				<th><?php echo lang('store_auction_category'); ?></th>
				<th><?php echo lang('store_auction_price'); ?></th>
				<th width="320" class="align-center"><span><?php echo lang('store_auction_actions'); ?></span></th>
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
			<?php foreach($auctions as $auction) { ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $auction->auctions_id); ?></td>
					<td><?php if (isset($auction->image)) { echo $auction->image; } 
								 else { echo $this->images_m->no_image(); } ?></td>
					<td><?php echo $auction->name; ?></td>
					<td><?php 
							if (isset($auction->category->name)) { 
								$output = '<a href="admin/store/category/';
								$output .= str_replace(' ', '-', $auction->category->name) . '" ';
								$output .= ' >';						
								$output .= $auction->category->name; 
								$output .= '</a>';
							} 
							else { $output = "-------"; }
							echo $output;  
					?></td>
					<td><?php echo $auction->price; ?></td>
					<td class="align-center buttons buttons-small">
					   <?php $title = 'title="'. ucfirst($auction->category->name) . ' - ' . ucfirst($auction->name) . '" '; ?>
						<?php echo anchor('admin/store/preview/' . $auction->category->slug . '/' . $auction->slug, lang('store_button_view'), $title . 'rel="preview" class="button preview" target="_blank"'); ?>
						<?php echo anchor('admin/store/edit_auction/' . $auction->auctions_id, lang('store_button_edit'), 'class="edit_auction button"'); ?>
						<?php echo anchor('admin/store/delete_auction/' . $auction->auctions_id, lang('store_button_delete'), array('class'=>'confirm button delete')); ?>
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
        <div class="no_data"><?php echo lang('store_messages_auction_no_items'); ?></div>
    <?php endif; ?>
</section>
