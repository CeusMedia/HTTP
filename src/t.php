<?php
require_once '../vendor/autoload.php';

use CeusMedia\HTTP\Client;
use CeusMedia\HTTP\Message\Uri;

$client		= new Client();
$request	= $client->createMessage()->withUri(new Uri('https://ceusmedia.de/'));
print_r($request);
print_r($client->send($request));
