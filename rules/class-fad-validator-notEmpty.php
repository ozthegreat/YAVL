<?php

if( ! class_exists( 'Fad_Validator_Notempty' ) ){

	class Fad_Validator_Notempty extends Fad_Validate {

		public function notEmpty( $s ){

			return ! empty( $s );

		}

	}

}