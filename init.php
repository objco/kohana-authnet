<?php defined('SYSPATH') or die('No direct script access.');

if (Kohana::$environment !== Kohana::PRODUCTION)
{
	Route::set('authnet', 'authnet(/<controller>(/<action>(/<id>)))')
		->defaults(array(
			'directory' => 'authnet',
			'controller' => 'welcome',
			'action'     => 'index',
		));
}