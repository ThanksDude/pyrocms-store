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
   <h4><?php echo lang('store:auctions:title')?></h4>
</section>

<section class="item">
<?php if ($auctions): ?>

	<?php echo form_open('admin/store/auctions/delete'); ?>

	<table border="0" class="table-list">
		<thead>
			<tr>
				<th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
				<th><?php echo lang('store:auctions:label:thumbnail'); ?></th>
				<th><?php echo lang('store:auctions:label:name'); ?></th>
				<th><?php echo lang('store:auctions:label:category'); ?></th>
				<th><?php echo lang('store:auctions:label:price'); ?></th>
				<th><?php echo lang('store:auctions:label:remaining'); ?></th>
				<th width="320" class="align-center"><span><?php echo lang('store:auctions:label:actions'); ?></span></th>
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
					<td>
					<?php 
						$now = time();
						if($auction->end_at>$now) {
				  			echo timespan($now, $auction->end_at);
				  		} else {
					  		echo lang('store:auctions:label:ended_short');
				  		}
					?>
					</td>
					<td class="align-center buttons buttons-small">
					   <?php $title = 'title="'. ucfirst($auction->category->name) . ' - ' . ucfirst($auction->name) . '" '; ?>
						<?php echo anchor('store/auction/view/' . $auction->slug, lang('store:auctions:buttons:preview'), $title . 'rel="preview" class="btn green preview" target="_blank"'); ?>
						<?php echo anchor('admin/store/auctions/edit/' . $auction->auctions_id, lang('store:auctions:buttons:edit'), 'class="edit_auction btn orange"'); ?>
						<?php echo anchor('admin/store/auctions/delete/' . $auction->auctions_id, lang('store:auctions:buttons:delete'), array('class'=>'confirm btn red delete')); ?>
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
        <div class="no_data"><?php echo lang('store:auctions:messages:information:no_items'); ?></div>
    <?php endif; ?>
</section>
