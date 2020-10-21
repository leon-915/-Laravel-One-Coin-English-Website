<?php
include ( 'iCalEasyReader.php' );
$ical = new iCalEasyReader();
$lines = $ical->load( file_get_contents( 'example.ics' ) );

var_dump( $lines );
