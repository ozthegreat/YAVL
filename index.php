<?php

/**
 * TODO:
 * 
 * Define Error messages at a class level. Allow params to be passed
 * Store loaded classes globally so only loading once.
 * Change returned options (boolean).
 * Break on first error.
 * How it stores error, show values passed for each individual functions
 * 
 */

require 'class-fad-validate.php';

$query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 );

$query_chain->validate( 12 );

$second_query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 );

$second_query_chain->validate( 20 );


print_r( $query_chain->get_actions() );
echo '<br /><br />';
print_r( $query_chain->get_last_action() ); die;



echo $query_chain->get_html_errors();
echo '<br /><br />';
print_r( $query_chain->get_actions() );
echo '<br /><br />';
print_r( $query_chain->get_errors() );
