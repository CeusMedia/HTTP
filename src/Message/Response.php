<?php
namespace CeusMedia\Http\Message;

use Psr\Http\Message\ResponseInterface;

class Response extends AbstractMessage implements ResponseInterface
{
	protected $statusCode   = 0;
	protected $reasonPhrase = '';

	public function getReasonPhrase(): string
	{
		return $this->reasonPhrase;
	}

	public function getStatusCode(): int
	{
		return $this->statusCode;
	}

	public function withStatus( $code, $reasonPhrase = '' ): self
	{
		$this->statusCode   = $code;
		$this->reasonPhrase = $reasonPhrase;
		return $this;
	}
}
