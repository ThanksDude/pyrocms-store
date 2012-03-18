<h3>Bids</h3>

<div>
  <?php foreach ($bids as $bid): ?>
  <div>
    <h3><?php echo $bid->username; ?><small></small></h3>
    <p>
      <?php echo $bid->price; ?>
    </p>
  </div>
  <?php endforeach; ?>
</div>

<?php echo form_open('store/customer/place_bid/'); ?>
<ul>
  <li>
    <label for="email">Your price</label>
    <?php echo form_input('price', (isset($bids[0]) ? ($bids[0]->price + 1) : ''), 'class="maxlength="100""'); ?>
  </li>
  <br/>
  <li>
    <?php echo form_hidden('id', $id, 'class="maxlength="100""'); ?>
   <?php echo form_hidden('slug', $slug, 'class="maxlength="100""'); ?>
    <?php echo form_submit('submit', 'Send'); ?>
  </li>
</ul>
<?php echo form_close(); ?>
<br/>
<br/>
