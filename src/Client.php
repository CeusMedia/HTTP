<?php
namespace CeusMedia\HTTP;

use CeusMedia\HTTP\Message\Request;
use CeusMedia\HTTP\Message\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
	protected $handler	= 'Filesystem';

	public function createMessage()
	{
		return new Request();
	}

	public function sendRequest(RequestInterface $request): ResponseInterface
	{
		$className	= __NAMESPACE__.'\\Client\\'.$this->handler.'\\Sender';
		if(!class_exists($className))
			throw new \RuntimeException('Client request sender not existing: '.$className);
		$handler	= new $className;
		return $handler->sendRequest($request);
	}
}
