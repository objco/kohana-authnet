<?php defined('SYSPATH') or die('No direct script access.');
/**
 * AuthNet Examples Welcome Controller
 *
 * @package    AuthNet
 * @author     The Objective Company
 * @copyright  (c) 2010 The Objective Company
 * @license    http://github.com/ObjectiveCompany/AuthNet/raw/master/LICENSE
 */
class Controller_AuthNet_Welcome extends Controller_AuthNet_Template {
	
	public function action_index()
	{
		$this->template->content = View::factory('authnet/welcome');
	}

} // End Authorize_Welcome