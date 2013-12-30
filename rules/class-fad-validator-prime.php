<?php

if( ! class_exists( 'Fad_Validator_Prime' ) ){

	class Fad_Validator_Prime extends Fad_Validate {

		public function prime( $s ){

			// Check it's a number
			// Check it is positive and not 0
			if( ! is_int( $s ) || $s <= 0 )
				return FALSE;

			// 2 is prime
			if( $s == 2 )
				return true;

			// 1 is not prime.
			// If it's divisable by 2 it's not prime
			if( $s == 1 || $s % 2 == 0 )
				return false;

			
			// Checks the odd numbers. If any of them is a factor, then it returns false.
			// The sqrt can be an aproximation, hence just for the sake of
			// security, one rounds it to the next highest integer value.
			for( $i = 3; $i <= ceil( sqrt( $s ) ); $i = $i + 2 ) {

				if( $s % $i == 0 )
					return FALSE;

			}

			return TRUE;

		}

	}

}