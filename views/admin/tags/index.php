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
	<h4><?php echo lang('store:tags:title')?></h4>
</section>

<section class="item">
	
	<?php if ($tags): ?>

		<?php echo form_open('/admin/store/tags/delete'); ?>
    
        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('store:tags:label:name'); ?></th>
                    <th width="320" class="align-center"><span><?php echo lang('store:tags:label:actions'); ?></span></th>
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
                <?php foreach($tags as $tag) { ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $tag->tags_id); ?></td>
                        <td><?php echo $tag->name; ?></td>
                        <td class="align-center buttons buttons-small">
                            <?php echo anchor('/admin/store/tags/edit/' . $tag->tags_id, lang('store:tags:buttons:edit'), 'class="btn orange edit"'); ?>
                            <?php echo anchor('/admin/store/tags/delete/' . $tag->tags_id, lang('store:tags:buttons:delete'), array('class'=>'confirm btn red delete')); ?>
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
		<div class="no_data"><?php echo lang('store:tags:messages:information:no_items'); ?></div>
	<?php endif; ?>
</section>