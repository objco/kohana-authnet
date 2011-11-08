<?php defined('SYSPATH') or die('No direct script access.');
/**
 * AuthNet ARB Example Controller
 *
 * @package    AuthNet
 * @author     The Objective Company
 * @copyright  (c) 2010 The Objective Company
 * @license    https://raw.github.com/ObjectiveCompany/kohana-authnet/master/LICENSE
 */
class Controller_AuthNet_ARB extends Controller_AuthNet_Template {

	public function action_index()
	{
		$this->template->content = View::factory('authnet/arb/index');
	}
	
	public function action_create()
	{
		if ($_POST)
		{
			$arb = AuthNet_ARB::factory($_POST);
			
			if ($arb->check() AND $arb->process())
			{
				// Do something with the subscription id returned from Authorize.net.
				//echo $arb->subscription_id;
				
				$this->request->redirect('authnet/arb/success');
			}
			else
			{
				$values = $arb->validate()->as_array();
				$errors = $arb->validate()->errors('authnet/arb');
			}
		}
		
		$this->template->content = 	View::factory('authnet/arb/create')
			->bind('values', $values)
			->bind('errors', $errors);
	}
	
	public function action_update()
	{
		if ($_POST)
		{
			$arb = AuthNet_ARB::factory($_POST, AuthNet_ARB::UPDATE);
			
			if ($arb->check() AND $arb->process())
			{
				$this->request->redirect('authnet/arb/success');
			}
			else
			{
				$values = $arb->validate()->as_array();
				$errors = $arb->validate()->errors('authnet/arb');
			}
		}
		
		$this->template->content = 	View::factory('authnet/arb/update')
			->bind('values', $values)
			->bind('errors', $errors);
	}
	
	public function action_cancel()
	{
		if ($_POST)
		{
			$arb = AuthNet_ARB::factory($_POST, AuthNet_ARB::CANCEL);
			
			if ($arb->check() AND $arb->process())
			{
				$this->request->redirect('authnet/arb/success');
			}
			else
			{
				$values = $arb->validate()->as_array();
				$errors = $arb->validate()->errors('authnet/arb');
			}
		}
		
		$this->template->content = 	View::factory('authnet/arb/cancel')
			->bind('values', $values)
			->bind('errors', $errors);
	}
	
	public function action_success()
	{
		$this->template->content = 	View::factory('authnet/arb/success');
	}

} // End AuthNet_ARB