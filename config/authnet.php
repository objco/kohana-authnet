<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'test_mode' => Kohana::$environment !== Kohana::PRODUCTION,
	
	'api_login'			=> 'my_api_login',
	'transaction_key'	=> 'my_transaction_key',
	
	'aim' => array(
		'url' => array(
			'live' => 'https://secure.authorize.net/gateway/transact.dll',
			'test' => 'https://test.authorize.net/gateway/transact.dll',
		),
	),
	
	'arb' => array(
		'xml_schema' => 'AnetApi/xml/v1/schema/AnetApiSchema.xsd',
		'url' => array(
			'live' => 'https://api.authorize.net/xml/v1/request.api',
			'test' => 'https://apitest.authorize.net/xml/v1/request.api',
		),
	),
);