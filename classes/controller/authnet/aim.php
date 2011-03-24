<?php defined('SYSPATH') or die('No direct script access.');
/**
 * AuthNet AIM Example Controller
 *
 * @package    AuthNet
 * @author     The Objective Company
 * @copyright  (c) 2010 The Objective Company
 * @license    http://github.com/ObjectiveCompany/AuthNet/raw/master/LICENSE
 */
class Controller_AuthNet_Aim extends Controller_AuthNet_Template {

	public function action_index()
	{
		if ($_POST)
		{
			$aim = AuthNet_AIM::factory($_POST);

			if ($aim->check() AND $aim->process())
			{
				$this->request->redirect('authnet/aim/success');
			}
			else
			{
				$values = $aim->validate()->as_array();
				$errors = $aim->validate()->errors('authnet/aim');
			}
		}
		else
		{
			$values = array(
				'card_num'		=> '4111111111111111',
				'exp_date'		=> '0115',

				'amount'		=> '19.99',
				'description'	=> 'Sample Transaction',

				'first_name'	=> 'John',
				'last_name'		=> 'Doe',
				'address'		=> '1234 Street',
				'state'			=> 'WA',
				'zip'			=> '98004',
			);
			$errors = array();
		}
		
		$this->template->content = View::factory('authnet/aim/index')
			->bind('values', $values)
			->bind('errors', $errors);
	}
	
	public function action_success()
	{
		$this->template->content = View::factory('authnet/aim/success');
	}

} // End Authorize_Aim