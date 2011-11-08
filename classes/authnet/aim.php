<?php defined('SYSPATH') or die('No direct script access.');
/**
 * AuthNet AIM
 *
 * @package    AuthNet
 * @author     The Objective Company
 * @copyright  (c) 2010 The Objective Company
 * @license    https://raw.github.com/ObjectiveCompany/kohana-authnet/master/LICENSE
 */
class AuthNet_AIM extends AuthNet {

	const AUTH_CAPTURE			= 'AUTH_CAPTURE';
	const AUTH_ONLY				= 'AUTH_ONLY';
	const CAPTURE_ONLY			= 'CAPTURE_ONLY';
	const CREDIT				= 'CREDIT';
	const PRIOR_AUTH_CAPTURE	= 'PRIOR_AUTH_CAPTURE';
	const VOID					= 'VOID';
	
	// Members that have access methods
	protected static $_properties = array(
		'response','validate',
	);
	
	// Transaction Response
	protected $_response;
	
	// Default Required Transaction Values
	protected $_default_values = array
	(
		'version'			=> '3.1',
		'delim_data'		=> 'TRUE',
		'delim_char'		=> '|',
		'encap_char'		=> '',
		'relay_response'	=> 'FALSE',
		'type'				=> AuthNet_AIM::AUTH_CAPTURE,
		'method'			=> 'CC', // TODO: Add support for ECHECK.
	);
	
	// Transaction Values
	protected $_values = array();
	
	// Validation
	protected $_validate;
	protected $_required_fields = array
	(
		AuthNet_AIM::AUTH_CAPTURE			=> array('amount', 'card_num', 'exp_date'),
		AuthNet_AIM::AUTH_ONLY			=> array('amount', 'card_num', 'exp_date'),
		AuthNet_AIM::CAPTURE_ONLY			=> array('amount', 'card_num', 'exp_date', 'auth_code'),
		AuthNet_AIM::CREDIT				=> array('amount', 'card_num', 'exp_date', 'trans_id'),
		AuthNet_AIM::PRIOR_AUTH_CAPTURE	=> array('amount', 'card_num', 'exp_date', 'trans_id'),
		AuthNet_AIM::VOID					=> array('amount', 'card_num', 'exp_date', 'trans_id'),
	);
	
	protected $_rules = array
	(
		/**
		 * Transaction Information
		 */ 

		// The total amount to be charged or credited including tax, shipping and any other charges.
		// Required if x_type = AUTH_CAPTURE, AUTH_ONLY, CAPTURE_ONLY, CREDIT.
		'amount' => array(
			'numeric'	=> NULL,
			'max_length' => array(15),
		),

		// The customer’s credit card number.
		// When x_type=CREDIT, only the last four digits are required.
		// Between 13 and 16 digits without spaces.
		'card_num' => array(
			'credit_card' => NULL,
		),

		// The customer’s credit card expiration date.
		// Required - MMYY, MM/YY, MM-YY, MMYYYY, MM/YYYY, MM-YYYY
		'exp_date' => array(
			'date' => NULL,
		),

		// Must be a valid CVV2, CVC2 or CID value.
		// 3 or 4 digits, required if the merchant would like to use the Card Code Verification (CCV) security feature.
		'card_code' => array(
			'digit' => NULL,
			'min_length' => array(3),
			'max_length' => array(4),
		),

		// The payment gateway assigned transaction ID of the original transaction.
		// Required when x_type = CREDIT, PRIOR_AUTH_CAPTURE, VOID
		'trans_id' => array(),

		// The authorization code for an original transaction not authorized on the payment gateway.
		// Required only for CAPTURE_ONLY transactions.
		// 6 characters
		'auth_code' => array(
			'alpha_numeric' => NULL,
			'max_length' => array(6),
		),

		// The request to process test transactions.
		'test_request' => array(),

		// The recurring billing status.
		'recurring_billing' => array(),

		// Indicates in seconds after a transaction is submitted during which the payment gateway will check for a duplicate transaction. 
		// The maximum time allowed is 8 hours (28800 seconds).
		'duplicate_window' => array(
			'range' => array(0, 28800),
		),

		/**
		 * Order Information
		 */

		// The merchant assigned invoice number for the transaction.
		// Up to 20 characters (no symbols)
		'invoice_num' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(20),
		),

		// The transaction description.
		// Up to 255 (no symbols)
		'description' => array(
			'max_length' => array(255),
		),

		// Itemized Order Information.
		'line_item' => array(),

		/**
		 * Customer Information
		 */

		// The first name associated with the customer’s billing address.
		'first_name' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(50),
		),

		// The last name associated with the customer’s billing address.
		'last_name' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(50),
		),

		// The company associated with the customer’s billing address.
		'company' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(50),
		),

		// The customer’s billing address.
		'address' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(60),
		),

		// The city of the customer’s billing address.
		'city' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(40),
		),

		// The state of the customer’s billing address
		// Up to 40 characters (no symbols) or a valid two-character state code
		'state' => array(
			//'alpha_numeric' => NULL,
			'min_length' => array(2),
			'max_length' => array(40),
		),

		// The ZIP code of the customer’s billing address
		'zip' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(20),
		),

		// The country of the customer’s billing address
		'country' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(60),
		),

		// The phone number associated with the customer’s billing address
		'phone' => array(
			'digit' => NULL,
			'max_length' => array(25),
		),

		// The fax number associated with the customer’s billing address
		'fax' => array(
			'digit' => NULL,
			'max_length' => array(25),
		),

		// The customer’s valid email address.
		'email' => array(
			'email' => NULL,
			'max_length' => array(255),
		),

		// Indicates whether an email receipt should be sent to the customer.
		'email_customer' => array(),

		// The email receipt header
		// Plain text 
		'header_email_receipt' => array(),

		// The email receipt footer
		// Plain text
		'footer_email_receipt' => array(),

		// Email address to which the merchant’s copy of the customer confirmation email should be sent.
		// If a value is submitted, an email will be sent to this address as well as the address(es) configured in the Merchant Interface.
		// Warning: If included, it can subject the merchant to spam on their business email address, because it announces where the receipt gets returned to, and gives a hint where relay response or silent post information may be sent.
		'merchant_email' => array(
			'email' => NULL,
			'max_length' => array(255),
		),

		// The merchant assigned customer ID
		// Up to 20 characters (no symbols)
		'cust_id' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(20),
		),

		// The customer’s IP address
		// This field is required when using the Fraud Detection SuiteTM (FDS) IP Address Blocking tool.
		'customer_ip' => array(
			'ip' => NULL,
			'max_length' => array(15),
		),

		/**
		 * Shipping Information
		 */

		// The first name associated with the customer’s shipping address
		'ship_to_first_name' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(50),
		),

		// The last name associated with the customer’s shipping address
		'ship_to_last_name' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(50),
		),

		// The company associated with the customer’s shipping address
		'ship_to_company' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(50),
		),

		// The customer’s shipping address
		'ship_to_address' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(60),
		),

		// The city of the customer’s shipping address
		'ship_to_city' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(40),
		),

		// The state of the customer’s shipping address
		// Up to 40 characters (no symbols) or a valid two-character state code
		'ship_to_state' => array(
			//'alpha_numeric' => NULL,
			'min_length' => array(40),
			'max_length' => array(40),
		),

		// The ZIP code of the customer’s shipping address
		'ship_to_zip' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(20),
		),

		// The country of the customer’s shipping address
		'ship_to_country' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(60),
		),

		/**
		 * Additional Shipping Information
		 */

		// The valid tax amount OR the delimited tax information.
		'tax' => array(),

		// The valid freight amount OR delimited freight information.
		'freight' => array(),

		// The valid duty amount OR delimited duty information.
		'duty' => array(),

		// The tax exempt status.
		'tax_exempt' => array(),

		// The merchant assigned purchase order number.
		'po_num' => array(
			//'alpha_numeric' => NULL,
			'max_length' => array(25),
		),

		/**
		 * Cardholder Authentication
		 */

		// Required only for AUTH_ONLY and AUTH_CAPTURE transactions processed through cardholder authentication programs.
		'authentication_indicator' => array(),
		
		// Required only for AUTH_ONLY and AUTH_CAPTURE transactions processed through cardholder authentication programs.
		// Special characters included in this value must be URL encoded.
		'cardholder_authentication_value' => array(),
	);

	public static function factory($values = array(), $type = NULL)
	{
		return new AuthNet_AIM($values, $type);
	}
	
	public function __construct($values = array(), $type = NULL)
	{
		// Merchant Information
		$this->_default_values['login'] = Kohana::config('authnet.api_login');
		$this->_default_values['tran_key'] = Kohana::config('authnet.transaction_key');
		
		// Transaction Type
		if ($type != NULL)
		{
			$this->_default_values['type'] = $type;
		}
		
		// Transaction Values
		foreach ($values as $key => $value)
		{
			if (array_key_exists($key, $this->_rules))
			{
				$this->{$key} = $value;
			}
		}
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
		foreach ($this->_required_fields[$this->_default_values['type']] as $required_field)
		{
			// Must have a value.
			$this->_validate->rule($required_field, 'not_empty');
			
			// Make sure the other rules for this required field have been added.
			if ( ! in_array($required_field, $fields))
			{
				$this->_validate->rules($field, $this->_rules[$required_field]);
			}
		}
		
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
			? Kohana::config('authnet.aim.url.test')
			: Kohana::config('authnet.aim.url.live');
		
		$x_values = array();
		foreach ($this->_default_values as $key => $value)
		{
			$x_values['x_'.$key] = $value;
		}
		foreach ($this->_values as $key => $value)
		{
			if (array_key_exists($key, $this->_rules))
			{
				$x_values['x_'.$key] = $value;
			}
		}
		
		if (isset($x_values['x_exp_date']))
		{
			$x_values['x_exp_date'] = date('m-Y', strtotime($x_values['x_exp_date']));
		}

		// Get the server response
		$response = Remote::get($url, array(
			CURLOPT_HEADER => FALSE,
			CURLOPT_RETURNTRANSFER => TRUE,
			CURLOPT_POSTFIELDS => http_build_query($x_values, '', '&'),
			CURLOPT_SSL_VERIFYPEER => FALSE,
		));
		$this->_response = explode($this->_default_values["delim_char"], $response);
		
		if ($this->_response[0] == 1) // Approved
		{
			return TRUE;
		}
		
		if (isset($this->_validate))
		{
			$this->_validate->error('transaction', implode('.', array_slice($this->_response, 0, 3)));
		}
		
		// Log the error (Response Code, Response Subcode, Response Reason, Response Reason Text)
		Kohana::$log->add(Kohana::ERROR, 'Authorize.net AIM [ '.implode(' : ', array_slice($this->_response, 0, 3)).' ]: '.$this->_response[3]);
		
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
		if (in_array($method, AuthNet_AIM::$_properties))
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
	
} // End AuthNet_AIM