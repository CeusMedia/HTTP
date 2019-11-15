<?php
namespace CeusMedia\HTTP\Client\Filesystem;

use CeusMedia\HTTP\Client\ClientException;
use CeusMedia\HTTP\Message\Request;
use CeusMedia\HTTP\Message\Response;
use CeusMedia\HTTP\Message\Stream;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Sender implements ClientInterface
{
	public function sendRequest(RequestInterface $request): ResponseInterface
	{
		$headers	= '';
//		var_export($request->getHeaders());die;
		foreach($request->getHeaders() as $headerName => $headerValue ){
			$headers	.= $headerName.': '.join(',', $headerValue)."\r\n";
		}
		$streamOptions	= ['http'	=> [
			'method'	=> $request->getMethod(),
			'header'	=> $headers,
		]];
		$context	= stream_context_create($streamOptions);
		$handle		= @fopen($request->getUri(), 'r', false, $context);
		if(!$handle){
			if(!count($http_response_header))
				throw new ClientException('Request failed');
			$response	= $this->interpreteHttpResponseHeaders($http_response_header);
		}
		else{
			$response	= $this->interpreteHttpResponseHeaders($http_response_header);
			$bodyStream	= new Stream($handle);
			$response->withBody($bodyStream);
		}
		return $response;
	}

	protected function interpreteHttpResponseHeaders(array $headers): ResponseInterface
	{
		$headersCopy	= $headers;
		$httpResponseLine	= array_shift($headersCopy);
		$parts	= explode(' ', $httpResponseLine, 3 );
		$response	= new Response();
		$response->withStatus($parts[1], $parts[2]);
		foreach($headersCopy as $header){
			list($name, $value)	= preg_split('/\s*:\s*/', $header, 2);
			$response->withAddedHeader($name, $value);
		}
		return $response;
	}
}
