<fieldset>
<legend>Payment Information</legend>
<h3>Payment Information</h3>

<dl>
	<dt><?php echo Form::label('card_num', 'Credit Card'); ?></dt>
	<dd><?php echo Form::input('card_num', Arr::get($values, 'card_num'), array('id' => 'card_num')); ?></dd>
	
	<dt><?php echo Form::label('exp_date', 'Exp Date'); ?></dt>
	<dd><?php echo Form::input('exp_date', Arr::get($values, 'exp_date'), array('id' => 'exp_date')); ?></dd>
	
	<dt><?php echo Form::label('first_name', 'First Name'); ?></dt>
	<dd><?php echo Form::input('first_name', Arr::get($values, 'first_name'), array('id' => 'first_name')); ?></dd>
	
	<dt><?php echo Form::label('last_name', 'Last Name'); ?></dt>
	<dd><?php echo Form::input('last_name', Arr::get($values, 'last_name'), array('id' => 'last_name')); ?></dd>
</dl>

</fieldset>