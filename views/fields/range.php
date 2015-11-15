<?php
$values = array();
array_walk( $range, function ( $value ) use ( &$values ) {
    $values[] = array( 'name' => $value, 'title' => $value );
} );

require __DIR__ . '/select.php';
