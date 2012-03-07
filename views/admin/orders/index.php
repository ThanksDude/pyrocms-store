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
	<h4><?php echo lang('store:orders:title')?></h4>
</section>

<section class="item">
	
	<?php if ($orders): ?>

		<?php echo form_open('/admin/store/orders/delete'); ?>
    
        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                    <th><?php echo lang('store:orders:label:invoice_nr'); ?></th>
                    <th><?php echo lang('store:orders:label:user'); ?></th>
                    <th><?php echo lang('store:orders:label:amount'); ?></th>
                    <th><?php echo lang('store:orders:label:shipping_cost'); ?></th>
                    <th><?php echo lang('store:orders:label:status'); ?></th>
                    <th width="320" class="align-center"><span><?php echo lang('store:orders:label:actions'); ?></span></th>
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
                <?php foreach($orders as $order) { ?>
                    <tr>
                        <td><?php echo form_checkbox('action_to[]', $order->orders_id); ?></td>
                        <td><?php echo $order->invoice_nr; ?></td>
                        <td>
                        <?php $users_name = $this->orders_m->get_orders_users($order->users_id);
                                echo $users_name;?>
                        </td>
                        <td>$<?php echo $order->amount; ?></td>
                        <td>$<?php echo $order->shipping_cost; ?></td>
                        <td>
                        <?php  $status = $this->orders_m->get_orders_status($order->orders_id);                        
                                echo lang('store:status:orders:'.$status->status_name); ?>
                        </td>
                        <td class="align-center buttons buttons-small">
                        <?php echo anchor('/admin/store/orders/view/' . $order->orders_id, lang('store:orders:buttons:view'), 'class="btn green view"'); ?>
                            <?php echo anchor('/admin/store/orders/edit/' . $order->orders_id, lang('store:orders:buttons:edit'), 'class="btn orange edit"'); ?>
                            <?php echo anchor('/admin/store/orders/delete/' . $order->orders_id, lang('store:orders:buttons:delete'), array('class'=>'confirm btn red delete')); ?>
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
		<div class="no_data"><?php echo lang('store:orders:messages:information:no_items'); ?></div>
	<?php endif; ?>
</section>