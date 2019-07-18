<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
#use CeusMedia\HTTP\Message\Uri;

class Request extends AbstractMessage implements RequestInterface
{
	protected $requestTarget	= '/';
	protected $method			= 'GET';

	public function getRequestTarget(): string
	{
		return $this->requestTarget;
	}

	public function getMethod(): string
	{
		return $this->method;
	}

	public function getUri(): UriInterface
	{
		return $this->uri;
	}

	public function withMethod($method): Request
	{
		$this->method	= (string) $method;
		return $message;
	}

	public function withRequestTarget($requestTarget): Request
	{
		$this->requestTarget	= (string) $requestTarget;
		return $message;
	}

	public function withUri(UriInterface $uri, $preserveHost = FALSE): self
	{
		if(!$preserveHost || (!$this->getHeader('Host') && $uri->getHost()))
			$this->withHeader('Host', $uri->getHost());
		$this->uri	= $uri;
		return $this;
	}
}
