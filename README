# Kohana AuthNet

AuthNet payment gateway module for Kohana v3.x, which features support for both AIM and ARB requests.

Note that Authorize.net now provides SDKs, you may want to consider vendor code from their [developer center](http://developer.authorize.net/downloads/).

Documentation:
- http://developer.authorize.net/api/aim/
- http://developer.authorize.net/api/arb/

## Basic AIM Request

Creates, validates, and processes an Authorize.net AIM transaction. Note that the x_ prefix is not used.

	$aim = AuthNet_AIM::factory(array(
		'card_num'		=> '4111111111111111',
		'exp_date'		=> '0115',

		'amount'		=> '19.99',
		'description'	=> 'Sample Transaction',

		'first_name'	=> 'John',
		'last_name'		=> 'Doe',
		'address'		=> '1234 Street',
		'state'			=> 'WA',
		'zip'			=> '98004',
	));

	if ($aim->check() AND $aim->process())
	{
		// Application Specific Code...
	}
	else
	{
		$values = $aim->validate()->as_array();
		$errors = $aim->validate()->errors('authnet/aim');
	}
	
## Create an ARB Subscription

	$arb = AuthNet_ARB::factory(array(
		'subscription_name'		=> 'Example ARB Subscription',
		
		'card_num'				=> '4111111111111111',
		'exp_date'				=> '0115',
		
		'first_name'			=> 'John',
		'last_name'				=> 'Doe',
		
		'payment_interval'		=> 6,
		'payment_interval_unit'	=> 'months',
		'start_date'			=> date('d/m/Y'),
		'total_occurrences'		=> 12,
		
		'amount'				=> '120.00',
	));
	
	if ($arb->check() AND $arb->process())
	{
		// Do something with the subscription id returned from Authorize.net.
		//echo $arb->subscription_id;
		
		// Application Specific Code...
	}
	else
	{
		$values = $arb->validate()->as_array();
		$errors = $arb->validate()->errors('authnet/arb');
	}
	
## Update an ARB Subscription

	$arb = AuthNet_ARB::factory(array(
		'subscription_id'		=> 11111111,

		'card_num'				=> '4111111111111112',
		'exp_date'				=> '0116',
	), AuthNet_ARB::UPDATE);
	
	if ($arb->check() AND $arb->process())
	{
		// Application Specific Code...
	}
	else
	{
		$values = $arb->validate()->as_array();
		$errors = $arb->validate()->errors('authnet/arb');
	}

## Cancel an ARB Subscription

	$arb = AuthNet_ARB::factory(array(
		'subscription_id'		=> 11111111,
	), AuthNet_ARB::CANCEL);
	
	if ($arb->check() AND $arb->process())
	{
		// Application Specific Code...
	}
	else
	{
		$values = $arb->validate()->as_array();
		$errors = $arb->validate()->errors('authnet/arb');
	}