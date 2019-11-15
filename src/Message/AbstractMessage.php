<?php
namespace CeusMedia\HTTP\Message;

use CeusMedia\HTTP\Message\Stream;
use CeusMedia\HTTP\Message\Header\Collection as HeaderCollection;
use CeusMedia\HTTP\Message\Header\Field as HeaderField;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractMessage implements MessageInterface
{
	protected $protocolVersion	= '1.1';
	protected $headers			= array();
	protected $body;

	public function __construct()
	{
		$this->headers		= new HeaderCollection();
	}

	public function getHeader( $name ): array
	{
		$list	= [];
		foreach( $this->headers->getFieldsByName( $name ) as $field )
			$list[]	= $field->getValue();
		return $list;
	}

	public function getHeaders(): array
	{
		$list   = [];
		$keyMap	= [];
		foreach( $this->headers->getFields() as $field ){
			$name	= $field->getName();
			$key	= strtolower( $name );
			if( !array_key_exists( $key, $keyMap ) ){
				$list[$name]	= [];
				$keyMap[$key]	= $name;
			}
			$list[$keyMap[$key]][]	= $field->getValue();
		}
		return $list;
	}

	public function getHeaderLine( $name ): string
	{
		$list   	= [];
		foreach( $this->headers->getFieldsByName( $name ) as $field )
			$list[]	= $field->getValue();
		return join(', ', $list );
	}

	public function getProtocolVersion(): string
	{
		return $this->protocolVersion;
	}

	public function getBody(): StreamInterface
	{
		if(is_null( $this->body ) )
			return new Stream( fopen( 'php://memory', 'rw' ) );
		return $this->body;
	}

	public function withBody( StreamInterface $body ): self
	{
		$this->body = $body;
		return $this;
	}

	public function hasHeader( $name ): bool
	{
		return $this->headers->hasField( $name );
	}

	public function withHeader( $name, $value ): self
	{
		$copy	= clone $this;
		$copy->headers->setField( new HeaderField( $name, $value ), TRUE );
		return $this;
	}

	public function withAddedHeader( $name, $value ): self
	{
		$this->headers->setField( new HeaderField( $name, $value ), FALSE );
		return $this;
	}

	public function withoutHeader( $name ): self
	{
		$this->headers->removeFieldByName( $name );
		return $this;
	}

	public function withProtocolVersion( $version ): self
	{
		$this->protocolVersion	= $version;
		return $this;
	}
}
