<?php

/**
 * TODO:
 * 
 * Define Error messages at a class level. Allow params to be passed
 * Change returned options (boolean).
 * Break on first error.
 * How it stores error, show values passed for each individual functions
 * 
 */

require 'class-fad-validate.php';

$query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 );

$query_chain->validate( array( 12, 67 ) );

$second_query_chain = Fad_Validate::initialize()->int()->between( 12, 20 )->lessThan( 17 )->greaterThan( 13 )->breakFirst();

$second_query_chain->validate( 20 );

echo 'First Chain All Actions:';
echo '<br /><br />';
print_r( $query_chain->get_actions() );
echo '<br /><br />';
echo '<br /><br />';
echo 'First Chain All Errors:';
echo '<br /><br />';
print_r( $query_chain->get_errors() );

echo '<br /><br />';
echo '<br /><br />';
echo '<br /><br />';
echo '<br /><br />';

echo 'First Chain All Actions:';
echo '<br /><br />';
print_r( $second_query_chain->get_actions() );
echo '<br /><br />';
echo '<br /><br />';
echo 'First Chain All Errors:';
echo '<br /><br />';
print_r( $second_query_chain->get_errors() );
die;

print_r( $query_chain->get_last_action() ); die;



echo $query_chain->get_html_errors();
echo '<br /><br />';
print_r( $query_chain->get_actions() );
echo '<br /><br />';
print_r( $query_chain->get_errors() );
