<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
#use CeusMedia\HTTP\Message\Uri;

class Request extends AbstractMessage implements RequestInterface
{
	protected string $requestTarget	= '/';
	protected string $method			= 'GET';
	protected UriInterface $uri;

	public function getMethod(): string
	{
		return $this->method;
	}

	public function getRequestTarget(): string
	{
		return $this->requestTarget;
	}

	public function getUri(): UriInterface
	{
		return $this->uri;
	}

	public function withMethod( $method ): RequestInterface
	{
		$copy	= clone $this;
		$copy->method	= (string) $method;
		return $copy;
	}

	public function withRequestTarget( $requestTarget ): RequestInterface
	{
		$this->requestTarget	= (string) $requestTarget;
		return $this;
	}

	public function withUri( UriInterface $uri, $preserveHost = FALSE ): RequestInterface
	{
		if( !$preserveHost || ( !$this->getHeader('Host') && $uri->getHost() ) )
			$this->withHeader( 'Host', $uri->getHost() );
		$this->uri	= $uri;
		return $this;
	}
}
