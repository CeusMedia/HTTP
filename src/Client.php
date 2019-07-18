<?php
namespace CeusMedia\HTTP;

use CeusMedia\HTTP\Message\Request;
use CeusMedia\HTTP\Message\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client
{
	public function createMessage()
	{
		return new Request();
	}

	public function send(RequestInterface $request): ResponseInterface
	{
		$headers	= '';
		foreach(array_keys($request->getHeaders()) as $headerKey)
			$headers	.= $request->getHeaderLine($headerKey)."\r\n";
		$streamOptions	= ['http'	=> [
			'method'	=> $request->getMethod(),
			'header'	=> $headers,
		]];

		$context	= stream_context_create($streamOptions);
		$handle		= fopen($request->getUri(), 'r', false, $context);

		$response	= stream_get_contents($handle);
		print_r($response);die;
		$response	= new Response();
		return $response;
	}
}
