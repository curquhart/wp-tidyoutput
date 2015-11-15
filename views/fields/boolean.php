<?php
$values = array();
$values[] = array( 'name' => 'True', 'title' => 'True' );
$values[] = array( 'name' => 'False', 'title' => 'False' );
$options[ $field ] = $options[ $field ] ? 'True' : 'False';

require __DIR__ . '/select.php';
