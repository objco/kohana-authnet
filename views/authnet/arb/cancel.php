<?php echo Form::open(); ?>

<fieldset>
<legend>Subscription Information</legend>
<h3>Subscription Information</h3>

<?php if ( ! empty($errors)): ?>
<p>The following errors occurred:</p>
<ul class="errors">
	<?php foreach ($errors as $error): ?>
	<li><?php echo $error; ?></li>
	<?php endforeach ?>
</ul>

<?php endif ?>
<dl>
	<dt><?php echo Form::label('subscription_id', 'Subscription ID'); ?></dt>
	<dd><?php echo Form::input('subscription_id', Arr::get($values, 'subscription_id'), array('id' => 'subscription_id')); ?></dd>
</dl>

</fieldset>

<p><?php echo Form::submit('submit', 'Submit'); ?></p>

<?php echo Form::close(); ?>