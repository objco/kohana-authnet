<?php defined('SYSPATH') or die('No direct script access.');
/**
 * AuthNet ARB
 *
 * @package    AuthNet
 * @author     The Objective Company
 * @copyright  (c) 2010 The Objective Company
 * @license    https://raw.github.com/ObjectiveCompany/kohana-authnet/master/LICENSE
 */
class AuthNet_ARB extends AuthNet {

	const CREATE	= 'ARBCreateSubscriptionRequest';
	const UPDATE	= 'ARBUpdateSubscriptionRequest';
	const CANCEL	= 'ARBCancelSubscriptionRequest';

	/**
	 * @var  string  Current transaction type - create, update, or cancel a subscription.
	 */
	protected $_type = AuthNet_ARB::CREATE;
	protected $_default_values;
	protected $_values;
	protected $_response;

	// Members that have access methods
	protected static $_properties = array(
		'response', 'validate',
	);
	
	// Permitted subscription units
	protected static $_payment_interval_units = array(
		'days' => 'Days',
		'months' => 'Months',
	);
	
	// Permitted account types
	protected static $_account_types = array(
		'checking' => 'Checking',
		'businessChecking' => 'Business Checking',
		'savings' => 'Savings',
	);
	
	// Permitted account types
	protected static $_echeck_types = array(
		'PPD' => 'PPD',
		'WEB' => 'WEB',
		'CCD' => 'CCD',
	);
	
	// Validation
	protected $_validate;
	protected $_required_fields = array
	(
		AuthNet_ARB::CREATE => array('payment_interval', 'payment_interval_unit', 'start_date', 'total_occurrences', 'amount', 'first_name', 'last_name'),
		AuthNet_ARB::UPDATE => array('subscription_id'),
		AuthNet_ARB::CANCEL => array('subscription_id'),
	);
	protected $_required_fields_cc = array(
		'card_number', 'exp_date',
	);
	protected $_required_fields_bank = array(
		'account_type', 'routing_number', 'account_number', 'name_on_account', 'echeck_type',
	);
	
	protected $_rules = array
	(
		// Merchant-assigned reference ID for the request.
		'ref_id' => array(
			'max_length' => array(20),
		),
		
		// The payment gateway assigned identification number for the subscription.
		'subscription_id' => array(
			'digit' => NULL,
			'max_length' => array(13),
		),
		
		// Merchant-assigned name for the subscription.
		'subscription_name' => array(
			'max_length' => array(50),
		),
		
		// The measurement of time, in association with the Interval Unit, that is used to define the frequency of the billing occurrences.
		// If the Interval Unit is "months," can be any number between one (1) and 12.
		// If the Interval Unit is "days," can be any number between seven (7) and 365.
		'payment_interval' => array(
			'digit' => NULL,
			'max_length' => array(3),
		),
		
		// The unit of time, in association with the Interval Length, between each billing occurrence.
		// Must be either 'days' or 'months'.
		'payment_interval_unit' => array(
			//'in_array' => array(array_keys(AuthNet_ARB::$_payment_interval_units)),
		),
		
		// The date the subscription begins (also the date the initial billing occurs).
		// YYYY-MM-DD
		'start_date' => array(
			'date' => NULL,
		),
		
		// Number of billing occurrences or payments for the subscription.
		// 9999 for ongoing subscriptions with no end date.
		// If a trial period is specified, this number should include the Trial Occurrences.
		'trial_occurrences' => array(
			'range' => array(0, 9999),
		),
		
		// Number of billing occurrences or payments in the trial period.
		// If a trial period is specified, this number must be included in the Total Occurrences.
		'trial_occurrences' => array(
			'range' => array(0, 99),
		),
		
		// The amount to be billed to the customer for each payment in the subscription.
		'amount' => array(
			'numeric' => NULL,
			'max_length' => array(15),
		),
		
		// The amount to be charged for each payment during a trial period.
		// Required when trial occurrences is specified.
		'trial_amount' => array(
			'numeric' => NULL,
			'max_length' => array(15),
		),
		
		// The credit card number used for payment of the subscription.
		'card_num' => array(
			'credit_card' => NULL,
		),
		
		// The expiration date of the credit card used for the subscription.
		// YYYY-MM
		'exp_date' => array(
			'date' => array(),
		),
		
		// The three- or four-digit card code on the back of most credit cards, on the front for American Express.
		'card_code' => array(
			'digit' => NULL,
			'min_length' => array(3),
			'max_length' => array(4),
		),
		
		// The type of bank account used for payment of the subscription.
		'account_type' => array(
			//'in_array' => array(array_keys(AuthNet_ARB::$_account_types)),
		),
		
		// The routing number of the customer’s bank.
		'routing_number' => array(
			'digit' => NULL,
			'exact_length' => array(9),
		),
		
		// The bank account number used for payment of the subscription.
		'account_number' => array(
			'digit' => NULL,
			'min_length' => array(5),
			'max_length' => array(17),
		),
		
		// The full name of the individual associated with the bank account number.
		'name_on_account' => array(
			'max_length' => array(22),
		),
		
		// The type of electronic check transaction used for the subscription.
		'echeck_type' => array(
			//'in_array' => array(array_keys(AuthNet_ARB::$_echeck_types)),
		),
		
		// The full name of the individual associated with the bank account number.
		'bank_name' => array(
			'max_length' => array(50),
		),
		
		// Merchant-assigned invoice number for the subscription.
		'invoice_number' => array(
			'max_length' => array(20),
		),
		
		// Description of the subscription.
		'description' => array(
			'max_length' => array(255),
		),
		
		// Merchant-assigned identifier for the customer.
		'cust_id' => array(
			'max_length' => array(20),
		),
		
		// The customer’s email address.
		'customer_email' => array(
			'email' => NULL,
		),
		
		// The customer’s phone number.
		'customer_phone' => array(
			'digit' => NULL,
			'max_length' => array(25),
		),
		
		// The customer’s fax number.
		'customer_fax' => array(
			'digit' => NULL,
			'max_length' => array(25),
		),
		
		// The first name associated with the customer’s billing address.
		'first_name' => array(
			'max_length' => array(50),
		),
		
		// The last name associated with the customer’s billing address.
		'last_name' => array(
			'max_length' => array(50),
		),
		
		// The company associated with the customer’s billing address.
		'company' => array(
			'max_length' => array(50),
		),
		
		// The customer’s billing address.
		'address' => array(
			'max_length' => array(60),
		),
		
		// The city of the customer’s billing address.
		'city' => array(
			'max_length' => array(40),
		),
		
		// The state of the customer’s billing address.
		// Must be a valid state code.
		'state' => array(
			'max_length' => array(2),
		),
		
		// The ZIP code of the customer’s billing address.
		'zip' => array(
			'max_length' => array(50),
		),
		
		// The country of the customer’s billing address.
		// Must be a valid two-character country code or full country name (spelled in English).
		'country' => array(
			'max_length' => array(60),
		),
		
		// The first name associated with the customer’s shipping address.
		'ship_to_first_name' => array(
			'max_length' => array(50),
		),
		
		// The last name associated with the customer’s shipping address.
		'ship_to_last_name' => array(
			'max_length' => array(50),
		),
		
		// The company associated with the customer’s shipping address.
		'ship_to_company' => array(
			'max_length' => array(50),
		),
		
		// The customer’s shipping address.
		'ship_to_address' => array(
			'max_length' => array(60),
		),
		
		// The city of the customer’s shipping address.
		'ship_to_city' => array(
			'max_length' => array(40),
		),
		
		// The state of the customer’s shipping address.
		// Must be a valid state code.
		'ship_to_state' => array(
			'max_length' => array(2),
		),
		
		// The ZIP code of the customer’s shipping address.
		'ship_to_zip' => array(
			'max_length' => array(50),
		),
		
		// The country of the customer’s shipping address.
		// Must be a valid two-character country code or full country name (spelled in English).
		'ship_to_country' => array(
			'max_length' => array(60),
		),
	);

	public static function factory(array $values = NULL, $type = NULL)
	{
		return new AuthNet_ARB($values, $type);
	}

	public function __construct(array $values = NULL, $type = NULL)
	{
		// Transaction Type
		if ($type != NULL)
		{
			$this->_type = $type;
		}
		
		// Merchant Information
		$this->_default_values = array();
		$this->_default_values['login'] = Kohana::config('authnet.api_login');
		$this->_default_values['tran_key'] = Kohana::config('authnet.transaction_key');
		
		// Trial occurrences and amounts are required for the create request.
		// Set defaults to resolve any problems with these values not being set.
		if ($this->_type === AuthNet_ARB::CREATE)
		{
			$this->_default_values['trial_occurrences'] = 0;
			$this->_default_values['trial_amount'] = 0;
		}
		
		// Transaction Values
		$this->_values = $values;
	}
	
	/**
	 * Initializes validation rules for each available transaction value.
	 *
	 * @return void
	 */
	protected function _validate()
	{
		$this->_validate = Validate::factory($this->_values);
		
		// Trim all fields
		$this->_validate->filter(TRUE, 'trim');
		
		$fields = array_keys($this->_values);
		foreach ($fields as $field)
		{
			if ( ! empty($this->_rules[$field]))
			{
				$this->_validate->rules($field, $this->_rules[$field]);
			}
		}
		
		// Set rules for required fields.
		foreach ($this->_required_fields[$this->_type] as $required_field)
		{
			// Must have a value.
			$this->_validate->rule($required_field, 'not_empty');
			
			// Make sure the other rules for this required field have been added.
			if ( ! in_array($required_field, $fields))
			{
				$this->_validate->rules($field, $this->_rules[$required_field]);
			}
		}
		
		// TODO: Require fields based on credit card or bank account option.
		
		// Placeholder for transaction errors
		$this->_validate->rule('transaction', TRUE);
	}
	
	/**
	 * Validates the current aim transaction values.
	 *
	 * @return  boolean
	 */
	public function check()
	{
		if ( ! isset($this->_validate))
		{
			// Initialize the validation object
			$this->_validate();
		}
		else
		{
			// Validation object has been created, just exchange the data array
			$this->_validate->exchangeArray($this->_values);
		}
		
		if ($this->_validate->check())
		{
			// Fields may have been modified by filters
			$this->_values = array_merge($this->_values, $this->_validate->getArrayCopy());
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function process()
	{
		$url = Kohana::config('authnet.test_mode')
			? Kohana::config('authnet.arb.url.test')
			: Kohana::config('authnet.arb.url.live');
		
		$values = array_merge($this->_default_values, $this->_values);
		
		// Load the XML request view and assign the transaction values.
		$xml = View::factory('authnet/arb/xml')
			->bind('type', $this->_type)
			->bind('values', $values);
			
		// Get the server response
		$response = Remote::get($url, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_HTTPHEADER => array("Content-Type: text/xml"),
			CURLOPT_POSTFIELDS => (string) $xml,
			CURLOPT_POST => 1,
			CURLOPT_SSL_VERIFYPEER => 0
		));
		
		// Create a XMLDOM object for accessing the response values.
		// Removes the unsupported relative namespace returned by Authorize.net before creating the XMLDOM.
		$this->_response = new SimpleXMLElement(preg_replace('/xmlns="(.+?)"/', '', $response));
		
		if ($this->_response->messages->resultCode == 'Ok')
		{
			// Retrive the subscription id and store it in the transaction values.
			$this->subscription_id = $this->_response->subscriptionId;
			return TRUE;
		}
		
		if (isset($this->_validate))
		{
			$this->_validate->error('transaction', $this->_response->messages->message->code);
		}
		
		// Log the error (Response Code, Response Subcode, Response Reason, Response Reason Text)
		Kohana::$log->add(Kohana::ERROR, 'Authorize.net ARB [ '.$this->_response->messages->message->code.' ]: '.$this->_response->messages->message->text);
		
		return FALSE;
	}
	
	/**
	 * Handles access method calls.
	 *
	 * @param   string  method name
	 * @param   array   method arguments
	 * @return  mixed
	 */
	public function __call($method, array $args)
	{
		if (in_array($method, AuthNet_ARB::$_properties))
		{
			// Return the property
			return $this->{'_'.$method};
		}
		else
		{
			throw new Kohana_Exception('Invalid method :method called in :class',
				array(':method' => $method, ':class' => get_class($this)));
		}
	}
	
	/**
	 * Handles get requests.
	 *
	 * @param   string  key
	 * @return  mixed
	 */
	public function __get($key)
	{
		if (array_key_exists($key, $this->_rules))
		{
			return $this->_values[$key];
		}
		else
		{
			throw new Kohana_Exception('The :property property does not exist in the :class class',
				array(':property' => $key, ':class' => get_class($this)));
		}
	}
	
	/**
	 * Handles setting of values.
	 *
	 * @param   string  key
	 * @param   mixed   value
	 * @return  void
	 */
	public function __set($key, $value)
	{
		if (array_key_exists($key, $this->_rules))
		{
			$this->_values[$key] = $value;
		}
		else
		{
			throw new Kohana_Exception('The :property: property does not exist in the :class: class',
				array(':property:' => $key, ':class:' => get_class($this)));
		}
	}

} // End AuthNet_ARB