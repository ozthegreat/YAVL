<?php namespace Valitator;

use ValitatorWrapper;

class Validator extends ValitatorWrapper {

	/**
	 * Array of all methods to run in this instance
	 *
	 * @var array
	 * @access private
	 */
	private $methods = array();

	/**
	 * The total count of methods in this instance
	 *
	 * @access protected
	 */
	private $methodCount = 0;

	/**
	 * The argument we're currently validating
	 *
	 * @access private
	 */
	private $validating;

	/**
	* All actions performed
	*
	* @access private
	* @var array
	*/
	private $allActions = array();

	/**
	* All errors logged
	*
	* @access private
	* @var array
	*/
	private $allErrors = array();

	/**
	* Holds any custom error messages
	*
	* @access private
	* @var array
	*/
	private $customErrorMessages = array();

	/**
	 * If we're running all tests or just breaking on the first error
	 *
	 * @access private
	 * @var boolean
	 */
	private $breakFirst = FALSE;


	/**
	 * Function for singleton loading of the class
	 *
	 * @var access public static
	 * @return type class obj
	 */
	public static function initialize()
	{
		return new self();
	}

	/**
	 * The construct class.
	 *
	 * @access public
	 * @param type $dir. An alternate direcotry to look in
	 */
	public function __construct()
	{

	}

	/**
	 *
	 * @access public
	 * @param string $method
	 * @param mixed $args
	 * @return \Fad_Validate
	 */
	public function __call( $method, $args )
	{
		// Add it to the count to call later
		$this->methods[ $method ] = $args;
		$this->methodCount++;

		return $this->get_current_instance();
	}


	/**
	 * Runs all the stored methods.
	 *
	 * @access public
	 * @param mixed $args
	 */
	public function validate( $args = NULL )
	{
		// Assume true
		$result = TRUE;

		if( ! empty( $args ) )
			$this->set( $args );

		$to_validate = $this->get_validating();

		// Check we have a value to test against
		// Check if it's an array, obj or string
		// Pass to the do_methods class for each value
		if ( ! empty( $to_validate ) )
		{
			if ( is_array( $to_validate ) || is_object( $to_validate ) )
			{
				foreach ( $to_validate as $value )
				{
					$result = $this->do_methods( $value );
				}

			}
			else
			{
				$result = $this->do_methods( $to_validate );
			}
		}
		else
		{
			$this->set_error( 'validate', FALSE, 'validate_empty' );
		}

		return $result;
		// return $this->get_current_instance();
	}

	/**
	 *
	 *
	 * @access protected
	 */
	protected function do_methods( $to_validate )
	{
		// Assume true;
		$result = TRUE;

		// Check we have methods
		// Look through them and call them.
		if ( ! empty( $this->methods ) && $this->methodCount > 0 )
		{
			foreach ( $this->methods as $method => $method_args )
			{
				$result = $this->load_method( $method, $method_args, $to_validate );

				// If $breakFirst is set and the result is false.
				if ( TRUE === $this->breakFirst && FALSE == $result )
					break;
			}

		}
		return $result;
	}

	/**
	 * Loads the class and calls the function
	 * Checks foor classes, Global class obj => class singlton method => manually loads and calls
	 *
	 * @access protected
	 * @return boolean
	 */
	protected function load_method( $method, $method_args, $to_validate )
	{
		// Assume failure
		$result = FALSE;

		// Get the path to the class
		$file_path = $this->get_class_file_path( $method );

		// Check it exists and is readable
		if ( is_readable( $file_path ) )
		{
			include $file_path;

			$class_name = $this->get_class_name( $method );

			// If it's already been loaded into the global array
			if ( isset( parent::$global_loaded_classes[ $class_name ] ) )
			{
				$class = parent::$global_loaded_classes[ $class_name ];

			// If it has a singleton occurance load it
			}
			elseif ( method_exists( $class_name, 'get_instance' ) )
			{
				$class = call_user_func( array( $class_name, 'get_instance' ) );
			}
			else
			{
				$class = new $class_name;
			}

			// Save it back to the global array;
			parent::$global_loaded_classes[ $class_name ] = $class;

			// Call the function we want.
			// Merge the instance to validate var with any other args passed to that method specifcally
			$result = call_user_func_array( array( $class, $method ), array_merge( (array) $to_validate, (array) $method_args ) );

			// Set the result to the action and error array.
			$this->set_action( $method, $to_validate, $result );
		}
		else
		{
			$this->set_action( $method, $to_validate, FALSE, 'method_not_exist' );
		}

		return $result;
	}

	/**
	 * The file name of the method
	 *
	 * @param string $method
	 * @return string
	 */
	protected function get_class_name( $method )
	{
		return 'Fad_Validator_' . ucwords( strtolower( $method ) );
	}

	/**
	 * Returns the file name for the provided method.
	 *
	 * @param string $method
	 * @return string
	 */
	protected function get_class_file_name( $method )
	{
		return 'class-' . strtolower( str_replace( array( '_', ' ' ), '-', $this->get_class_name( $method ) ) );
	}

	/**
	 * Gets the absolute path to the method
	 *
	 * @param string $method
	 * @return string
	 */
	protected function get_class_file_path( $method )
	{
		if ( strstr( $method, 'class-' ) === FALSE )
				$method = $this->get_class_file_name( $method );

		return dirname( __FILE__ ) . "/rules/{$method}.php";
	}

	/**
	 * Sets the value to validate
	 *
	 * @access public
	 */
	public function set( $args )
	{
		if ( empty( $args ) )
			return FALSE;

		$this->validating = $args;

		return $this->get_current_instance();
	}

	/**
	 * Returns the var we're currently validating
	 *
	 * @access public
	 * @return mixed
	 */
	public function get_validating()
	{
		return $this->validating;
	}

	/**
	 * Clears the current argument array we're working on
	 *
	 * @return null
	 */
	public function clear_validating()
	{
		$this->validating = NULL;
	}

	/**
	 * Current instance only.
	 * Breaks loop on first error.
	 *
	 * @type boolean
	 * @access public
	 */
	public function breakFirst()
	{
		$this->breakFirst = TRUE;

		return $this->get_current_instance();
	}

	/**
	 * Returns $this.
	 * Usefull for chaining.
	 *
	 * @access protected
	 */
	protected function get_current_instance()
	{
		return $this;
	}

	/*********************************************
	 *                                           *
	 *                                           *
	 *        Action & Error Functions           *
	 *                                           *
	 *                                           *
	 ********************************************8/

	/**
	 * Return an array of all actions performed
	 *
	 * @return array
	 */
	public function get_actions()
	{
		return $this->allActions;
	}

	/**
	 * Returns an array of the last action performed
	 *
	 * @access public
	 * @return array
	 */
	public function get_last_action()
	{
		return $this->get_last_key_value_of_array( $this->allActions );
	}

	/**
	* Used to update the global actions array, global error array and last error array.
	*
	* @access private
	*/
	private function set_action( $function, $value, $result, $error_message = NULL )
	{
		$result = ( $result ? 'TRUE' : 'FALSE' );

		$this->allActions[ $function ][ $value ] = $result;

		if( 'FALSE' == $result )
			$this->set_error( $function , $result, $error_message );
	}

	/**
	 * Returns all error messages
	 *
	 * @access public
	 * @return array
	 */
	public function get_errors()
	{
		return $this->allErrors;
	}

	/**
	 * Returns HTML formatted errors
	 *
	 * @access public
	 * @return string
	 */
	public function get_html_errors( $opening_container = '<p>' )
	{
		$output = '';

		if ( empty( $this->allErrors ) )
			return $output;

		$closing_container = substr_replace( $opening_container, '</', 0, 1 );

		foreach ( $this->allErrors as $method => $details )
		{
			foreach ( $details as $value => $error_message )
			{
				$output .= $opening_container;

				$output .= $error_message;

				$output .= $closing_container;

				$value = $error_messages = NULL;
			}

			$method = $details = NULL;
		}

		return $output;
	}

	/**
	 * Gets the last error
	 *
	 * @access public
	 * @return array
	 */
	public function get_last_error()
	{
		return $this->get_last_key_value_of_array( $this->allErrors );
	}

	/**
	* Used to set last error message and global errors
	*
	* @access private
	*/
	private function set_error( $function, $value, $error_message = NULL )
	{
		if ( empty( $error_message ) )
			$error_message = $this->get_error_message( $function );

		$this->allErrors[ $function ][ $value ] = $error_message;
	}

	/**
	* Returns the correct error message for the supplied function
	*
	* @access public
	* @return string the error message
	*/
	public function get_error_message( $function )
	{
		if ( isset( $this->customErrorMessages[ $function ] ) )
		{
			return $this->customErrorMessages[ $function ];
		}
		elseif ( $this->error_messages( $function ) !== FALSE )
		{
			return $this->error_messages( $function );
		}

		return 'No error message found';
	}

	private function error_messages( $function )
	{
		$error_messages = array(

							'method_not_exist'	=> 'Method does not exist.',
							'validate_empty'	=> 'Nothing to validate.',
							'int'				=> 'Must be an interger.',
							'between'			=> 'Must be between %s and %s.',

		);

		if ( ! empty( $function ) && isset( $error_messages[ $function  ] )  )
			return $error_messages[ $function  ];

		return false;
	}

	/**
	* Used to clear allActions, last_action, allErrors and last_error.
	*
	* @access public
	* @return boolean
	*/
	public function clearAll()
	{
		$this->clearAllActions();
		$this->clearLastAction();

		$this->clearAllErrors();
		$this->clearLastError();
	}

	/**
	* Used to clear allActions.
	*
	* @access public
	* @return boolean
	*/
	public function clearAllActions()
	{
		$this->allActions = NULL;
	}

	/**
	* Used to clear actions associated with a specific function.
	*
	* @access public
	* @return boolean
	*/
	public function clearActions( $function )
	{
		if ( isset( $this->allActions[ $function ] ) )
			$this->allActions[ $function ] = NULL;
	}

	/**
	* Used to clear allErrors.
	*
	* @access public
	* @return boolean
	*/
	public function clearAllErrors()
	{
		$this->allErrors = NULL;
	}

	/**
	* Used to clear errors associated with a specific function.
	*
	* @access public
	* @return boolean
	*/
	public function clearErrors( $function )
	{
		if ( isset( $this->allErrors[ $function ] ) )
			$this->allErrors[ $function ] = NULL;
	}

	/**
	 * Returns the last Key => Value element of an array as an array.
	 *
	 * @access protected
	 */
	protected function get_last_key_value_of_array( $array )
	{
		if ( empty( $array ) )
			return FALSE;

		$t = end( $array );

		return array( key( $array ) => $t );
	}

} /* Fad_Validate */
