<h1>Advanced Integration Method (AIM)</h1>

<?php echo Form::open(); ?>

<fieldset>
<legend>Payment Information</legend>
<h3>Payment Information</h3>

<?php if ( ! empty($errors)): ?>
<p>The following errors occurred:</p>
<ul class="errors">
	<?php foreach ($errors as $error): ?>
	<li><?php echo $error; ?></li>
	<?php endforeach ?>
</ul>

<?php endif ?>
<dl>
	<dt><?php echo Form::label('first_name', 'First Name'); ?></dt>
	<dd><?php echo Form::input('first_name', Arr::get($values, 'first_name'), array('id' => 'first_name')); ?></dd>
	
	<dt><?php echo Form::label('last_name', 'Last Name'); ?></dt>
	<dd><?php echo Form::input('last_name', Arr::get($values, 'last_name'), array('id' => 'last_name')); ?>	</dd>
	
	<dt><?php echo Form::label('address', 'Address'); ?></dt>
	<dd><?php echo Form::input('address', Arr::get($values, 'address'), array('id' => 'address')); ?></dd>
	
	<dt><?php echo Form::label('state', 'State'); ?></dt>
	<dd><?php echo Form::input('state', Arr::get($values, 'state'), array('id' => 'state')); ?></dd>
	
	<dt><?php echo Form::label('zip', 'Zip'); ?></dt>
	<dd><?php echo Form::input('zip', Arr::get($values, 'zip'), array('id' => 'zip')); ?></dd>
	
	<dt><?php echo Form::label('card_num', 'Card Number'); ?></dt>
	<dd><?php echo Form::input('card_num', Arr::get($values, 'card_num'), array('id' => 'card_num')); ?></dd>
	
	<dt><?php echo Form::label('exp_date', 'Exp Date'); ?></dt>
	<dd><?php echo Form::input('exp_date', Arr::get($values, 'exp_date'), array('id' => 'exp_date')); ?></dd>
	
	<dt><?php echo Form::label('amount', 'Amount'); ?></dt>
	<dd><?php echo Form::input('amount', Arr::get($values, 'amount'), array('id' => 'amount')); ?></dd>
	
	<dt><?php echo Form::label('description', 'Description'); ?></dt>
	<dd><?php echo Form::textarea('description', Arr::get($values, 'description'), array('id' => 'description')); ?></dd>
	
	<dd class="submit"><?php echo Form::submit('submit', 'Submit'); ?></dd>
</dl>

</fieldset>

<?php echo Form::close(); ?>