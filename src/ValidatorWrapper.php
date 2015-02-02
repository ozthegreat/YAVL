<?php namespace Valitator;

abstract class ValidateWrapper {

	/**
	 * Stores instances of all the 'rules' classes that have be included and loaded
	 * so they aren't included more than once.
	 *
	 * @access protected
	 */
	protected static $global_loaded_classes = array();


	/**
	 * Stores an array of every action run in every instance.
	 *
	 * @access protected
	 */
	protected static $global_all_actions = array();


	/**
	 * Stores info about everytime the validate class has been run.
	 *
	 * @access protected
	 */
	protected static $global_debug_info = array();


} /* Fad_Validate_Wrapper */
