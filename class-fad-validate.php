<?php

if( ! class_exists( 'Fad_Validate' ) ) {

class Fad_Validate {


	/**
	 * Used for singleton loading method
	 * 
	 * @access private
	 */
	private static $instance = NULL;


	/**
	 * Array of all methods to run
	 * 
	 * @type array
	 * @access protected
	 */
	private $methods = array();


	/**
	 * The total count of methods in this instance
	 * 
	 * @access protected
	 */
	private $method_count = 0;


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
	* @type array
	*/
	private $all_actions;


	/**
	* Last function performed
	*
	* @access private
	* @type array
	*/
	private $last_action;


	/**
	* All errors logged
	*
	* @access private
	* @type array
	*/
	private $all_errors;


	/**
	* Last error logged
	*
	* @access private static
	* @type array
	*/
	private $last_error;


	/**
	* Holds any custom error messages
	*
	* @access private static
	* @type array
	*/
	private $custom_error_messages;


	/**
	 * Function for singleton loading of the class
	 * 
	 * @var access public static
	 * @return type class obj
	 */
	public static function initialize() {

		/*if ( ! self::$instance ) {

			self::$instance = new self();

		} */

		self::$instance = new self();

		return self::$instance;

	}


	/**
	 * The construct class.
	 * 
	 * @param type $dir. An alternate direcotry to look in
	 */
	public function __construct() {}


	/**
	 * 
	 * @param string $method
	 * @param mixed $args
	 * @return \Fad_Validate
	 */
	public function __call( $method, $args ){

		// Add it to the count to call later
		$this->methods[ $method ] = $args;
		$this->method_count++;

		return $this;

	}


	/**
	 * Runs all the stored methods.
	 * 
	 * @param mixed $args
	 */
	public function validate( $args = NULL ){

		if( ! empty( $args ) )
			$this->set( $args );

		if( ! empty( $this->methods ) && $this->method_count > 0 ){

			foreach( $this->methods as $method => $args ){

				$this->load_method( $method, $args );

			}

		}
		
		return $this;

	}


	/**
	 * Loads the class
	 * 
	 */
	protected function load_method( $method, $args ){

		// Get the path to the class
		$file_path = $this->get_class_file_path( $method );

		// Check it exists and is readable
		if ( is_readable( $file_path ) ){

			include $file_path;

			$class_name = $this->get_class_name( $method );

			// If it has a singleton occurance load it
			if( method_exists( $class_name, 'get_instance' ) ){

				$class = call_user_func( array( $class_name, 'get_instance' ) );

			// If it's already been loaded into the global array
			} /* elseif() {


			// Else create a new instance of it
			} else */ {

				$class = new $class_name;

			}

			// Call the function we want.
			// Merge the instance to validate var with any other args passed to that method specifcally
			$result = call_user_func_array( array( $class, $method ), array_merge( (array) $this->get_validating(), (array) $args ) );

			// Set the result to the action and error array.
			$this->set_action( $method, $this->get_validating(), $result );

		} else {

			$this->set_action( $method, $this->get_validating(), FALSE, 'Method does not exist.' );

		}

	}


	/**
	 * The file name of the method
	 * 
	 * @param string $method
	 * @return string 
	 */
	protected function get_class_name( $method ){

		return 'Fad_Validator_' . ucwords( strtolower( $method ) );

	}


	/**
	 * Returns the file name for the provided method.
	 * 
	 * @param string $method
	 * @return string
	 */
	protected function get_class_file_name( $method ){
		
		return 'class-' . strtolower( str_replace( array( '_', ' ' ), '-', $this->get_class_name( $method ) ) );

	}


	/**
	 * Gets the absolute path to the method
	 * 
	 * @param string $method
	 * @return string
	 */
	protected function get_class_file_path( $method ){

		if( strstr( $method, 'class-' ) === FALSE )
				$method = $this->get_class_file_name( $method );

		return dirname( __FILE__ ) . "/rules/{$method}.php";

	}


	/**
	 * Sets the value to validate
	 * 
	 * @access public
	 */
	public function set( $args ){

		$this->validating = $args;

		return $this;

	}


	/**
	 * Returns the var we're currently validating
	 * 
	 * @access public
	 * @return mixed
	 */
	public function get_validating(){

		return $this->validating;

	}


	/**
	 * Clears the current argument array we're working on
	 * 
	 * @return null
	 */
	public function clear_validating(){

		$this->validating = NULL;

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
	public function get_actions(){

		return $this->all_actions;

	}


	/**
	 * Returns an array of the last action performed
	 * 
	 * @access public
	 * @return array
	 */
	public function get_last_action(){

		return $this->last_action;

	}


	/**
	* Used to update the global actions array, global error array and last error array.
	*
	* @access private
	*/
	private function set_action( $function, $value, $result, $error_message = NULL ){

		$result = ( $result ? 'TRUE' : 'FALSE' );
		
		$this->all_actions[ $function ][ $value ] = $result;

		$this->last_action = array( 'function' => $function, 'value' => $value, 'result' => $result );

		if( 'FALSE' == $result )
			$this->set_error( $function , $result, $error_message );

	}


	/**
	 * Returns all error messages
	 * 
	 * @access public
	 * @return array
	 */
	public function get_errors(){

		return $this->all_errors;

	}


	/**
	 * Returns HTML formatted errors
	 * 
	 * @access public
	 * @return string
	 */
	public function get_html_errors( $opening_container = '<p>' ){

		$output = '';

		if( empty( $this->all_errors ) )
			return $output;

		$closing_container = substr_replace( $opening_container, '</', 0, 1 );

		foreach( $this->all_errors as $method => $details ){

			foreach( $details as $value => $error_message ){

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
	public function get_last_error(){

		return $this->last_error;

	}


	/**
	* Used to set last error message and global errors
	*
	* @access private static
	*/
	private function set_error( $function, $value, $error_message = NULL ){

		if( empty( $error_message ) )
			$error_message = $this->get_error_message( $function );

		$this->all_errors[ $function ][ $value ] = $error_message;

		$this->last_error = array( 'function' => $function, 'value' => $value, 'error' => $error_message );

	}


	/**
	* Returns the correct error message for the supplied function
	*
	* @access public
	* @return string the error message
	*/
	public function get_error_message( $function ){

		if( isset( $this->custom_error_messages[ $function ] ) ){

			return $this->custom_error_messages[ $function ];

		} elseif( $this->error_messages( $function ) !== FALSE ){

			return $this->error_messages( $function );

		} else {

			return 'No error message found';

		}

	}


	private function error_messages( $function ){

		$error_messages = array(

							'int'		=> 'Must be an interger.',
							'between'	=> 'Must be between %s and %s.',

		);

		if( ! empty( $function ) && isset( $error_messages[ $function  ] )  )
			return $error_messages[ $function  ];

		else return false;

	}
	
	
	
	/**
	* Used to clear all_actions, last_action, all_errors and last_error.
	*
	* @access public
	* @return boolean
	*/
	public function clearAll(){

		$this->clearAllActions();
		$this->clearLastAction();

		$this->clearAllErrors();
		$this->clearLastError();

	}


	/**
	* Used to clear all_actions.
	*
	* @access public
	* @return boolean
	*/
	public function clearAllActions(){

		$this->all_actions = NULL;

	}


	/**
	* Used to clear last_action.
	*
	* @access public
	* @return boolean
	*/
	public function clearLastAction(){

		$this->last_action = NULL;

	}


	/**
	* Used to clear actions associated with a specific function.
	*
	* @access public
	* @return boolean
	*/
	public function clearActions( $function ){

		if( isset( $this->all_actions[ $function ] ) )
			$this->all_actions[ $function ] = NULL;

	}


	/**
	* Used to clear all_errors.
	*
	* @access public
	* @return boolean
	*/
	public function clearAllErrors(){

		$this->all_errors = NULL;

	}

	/**
	* Used to clear last_error.
	*
	* @access public
	* @return boolean
	*/
	public function clearLastError(){

		$this->last_error = NULL;

	}


	/**
	* Used to clear errors associated with a specific function.
	*
	* @access public
	* @return boolean
	*/
	public function clearErrors( $function ){

		if( isset( $this->all_errors[ $function ] ) )
			$this->all_errors[ $function ] = NULL;

	}


} /* Fad_Validate */

} /* class_exists */