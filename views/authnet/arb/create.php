<h1>Automated Recurring Billing</h1>

<p>Complete the following form to register a subscription payment with Authorize.net.</p>

<?php echo Form::open(); ?>

<?php if ( ! empty($errors)): ?>
<p>The following errors occurred:</p>
<ul class="errors">
	<?php foreach ($errors as $error): ?>
	<li><?php echo $error; ?></li>
	<?php endforeach ?>
</ul>

<?php endif ?>
<fieldset>
<legend>Subscription Information</legend>
<h3>Subscription Information</h3>

<dl>
	<dt><?php echo Form::label('ref_id', 'Reference ID'); ?></dt>
	<dd><?php echo Form::input('ref_id', Arr::get($values, 'ref_id'), array('id' => 'ref_id')); ?></dd>
	
	<dt><?php echo Form::label('subscription_name', 'Subscription Name'); ?></dt>
	<dd><?php echo Form::input('subscription_name', Arr::get($values, 'subscription_name'), array('id' => 'subscription_name')); ?></dd>
	
	<dt><?php echo Form::label('payment_interval', 'Payment Interval'); ?></dt>
	<dd><?php echo Form::input('payment_interval', Arr::get($values, 'payment_interval'), array('id' => 'payment_interval')); ?></dd>
	
	<dt><?php echo Form::label('payment_interval_unit', 'Payment Interval Unit'); ?></dt>
	<dd><?php echo Form::select('payment_interval_unit', array('days' => 'Days', 'months' => 'Months'), Arr::get($values, 'payment_interval_unit'), array('id' => 'payment_interval_unit')); ?></dd>
	
	<dt><?php echo Form::label('start_date', 'Start Date'); ?></dt>
	<dd><?php echo Form::input('start_date', Arr::get($values, 'start_date'), array('id' => 'start_date')); ?></dd>
	
	<dt><?php echo Form::label('total_occurrences', 'Total Occurrences'); ?></dt>
	<dd><?php echo Form::input('total_occurrences', Arr::get($values, 'total_occurrences'), array('id' => 'total_occurrences')); ?></dd>
	
	<dt><?php echo Form::label('trial_occurrences', 'Trial Occurrences'); ?></dt>
	<dd><?php echo Form::input('trial_occurrences', Arr::get($values, 'trial_occurrences'), array('id' => 'trial_occurrences')); ?></dd>
	
	<dt><?php echo Form::label('amount', 'Amount'); ?></dt>
	<dd><?php echo Form::input('amount', Arr::get($values, 'amount'), array('id' => 'amount')); ?></dd>
	
	<dt><?php echo Form::label('trial_amount', 'Trial Amount'); ?></dt>
	<dd><?php echo Form::input('trial_amount', Arr::get($values, 'trial_amount'), array('id' => 'trial_amount')); ?></dd>
</dl>

</fieldset>

<?php
echo View::factory('authnet/arb/payment-information')
	->bind('values', $values);
?>

<p><?php echo Form::submit('submit', 'Submit'); ?></p>

<?php echo Form::close(); ?>