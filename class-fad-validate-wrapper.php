<?php

if( ! class_exists( 'Fad_Validate_Wrapper' ) ) {

abstract class Fad_Validate_Wrapper {

	/**
	 * Stores instances of all the 'rules' classes that have be included and loaded
	 * so they aren't included more than once.
	 * 
	 * @access protected
	 */
	protected static $loaded_classes = array();


	/**
	 * Stores info about everytime the validate class has been run.
	 * 
	 * @access protected
	 */
	protected static $debug_info = array();


} /* Fad_Validate_Wrapper */

} /* class_exists */