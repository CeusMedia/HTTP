<?php
require_once '../../vendor/autoload.php';

use CeusMedia\HTTP\Client;
use CeusMedia\HTTP\Message\Uri;

$urls		= [
	'https://ceusmedia.de/invalid',
	'https://ceusmedia.de/kontakt',
];
$client		= new Client();

foreach($urls as $nr => $url){
	print(PHP_EOL);
	print(str_pad('--  Test #'.($nr + 1).'  ', 78, '-', STR_PAD_RIGHT).PHP_EOL);
	$request	= $client->createMessage()->withUri(new Uri($url));
	$response	= $client->sendRequest($request);
	print('URL:     '.$url.PHP_EOL);
	print('Status:  '.$response->getStatusCode().' '.$response->getReasonPhrase().PHP_EOL);

	$responseHeaders		= $response->getHeaders();
	if($responseHeaders){
		$body	= $response->getBody()->getContents();
		$body	= $body ? substr($body, 0, 66).'...' : '- empty -';
		print('Body:    '.$body.PHP_EOL);
		print('Headers:'.PHP_EOL);
		$maxHeaderNameLength	= max(array_map('strlen', array_keys($responseHeaders)));
		ksort($responseHeaders);
		foreach($responseHeaders as $name => $values){
			$name	= str_pad($name, $maxHeaderNameLength, ' ', STR_PAD_RIGHT);
			print('  - '.$name.'  '.join(',', $values).PHP_EOL);
		}
	}
	print(PHP_EOL);
}
