<?php

if( ! class_exists( 'Fad_Validator_Int' ) ){

	class Fad_Validator_Int extends Fad_Validate {

		public function int( $i ){

			return ( ! filter_var( $i, FILTER_VALIDATE_INT ) ? FALSE : TRUE );

		}

	}

}