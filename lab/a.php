<?php
require_once '../vendor/autoload.php';
new UI_DevOutput;
/*
$file = tmpfile();
$data = stream_get_meta_data($file);
print_m($data);

$file = fopen( 'a.php', 'r' );
$data = stream_get_meta_data($file);
print_m($data);
*/
$file = fopen( 'https://ceusmedia.de/', 'r' );
$data = stream_get_meta_data($file);
print_m($data);

