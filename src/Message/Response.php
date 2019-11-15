<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\ResponseInterface;

class Response extends AbstractMessage implements ResponseInterface
{
	protected int $statusCode		= 0;
	protected string $reasonPhrase	= '';

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
		$copy	= clone $this;
		$copy->statusCode	= $code;
		$copy->reasonPhrase	= $reasonPhrase;
		return $copy;
	}
}
