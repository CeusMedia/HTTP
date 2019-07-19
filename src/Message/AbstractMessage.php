<?php
namespace CeusMedia\HTTP\Message;

use CeusMedia\HTTP\Message\Stream;
use CeusMedia\HTTP\Message\Header\Collection as HeaderCollection;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractMessage implements MessageInterface
{
	protected $protocolVersion = '1.1';
	protected $headers         = array();
	protected $body;

	public function __construct(){
		$this->headers		= new HeaderCollection();
	}

	public function getHeader($name)
    {
		return $this->headers->getField($name);
        $key    = strtolower($name);
        if(!isset($this->headers[$key]))
            return [];
		return $this->headers[$key]['values'];
	}

	public function getHeaders(){
		return $this->headers->getFields();
        $list   = [];
        foreach($this->headers as $header)
            $list[$header['name']]  = $header['values'];
		return $list;
	}

	public function getHeaderLine($name)
    {
		return jion(',', $this->headers->getField($name));
        $key    = strtolower($name);
        if(!isset($this->headers[$key]))
            return [];
        return join(',', $this->headers[$key]['values']);
	}

	public function getProtocolVersion(): string
	{
		return $this->protocolVersion;
    }

	public function getBody(): StreamInterface
    {
		if(is_null($this->body))
			return new Stream(fopen('php://memory', 'rw'));
        return $this->body;
    }

	public function withBody(StreamInterface $body): self
    {
        $this->body = $body;
		return $this;
	}

	public function hasHeader($name): bool
    {
		return $this->header->hasField($name);
        $key    = strtolower($name);
        return isset($this->headers[$key]);
	}

    public function withHeader($name, $value): self
    {
		$this->headers->setFieldPair($name, $value, TRUE);
        return $this;
    }

    public function withAddedHeader($name, $value): self
    {
		$this->headers->setFieldPair($name, $value, FALSE);
		return $this;
        if(!$this->hasHeader($name))
            return $this->withHeader($name, $value);
		if(!is_array($value))
            $value  = [$value];
        $key    = strtolower($name);
        $header = $this->headers[$key];
        foreach($value as $item)
            $header['values'][]   = $item;
        return $this;
    }

    public function withoutHeader($name): self
    {
		throw new \Exception('Not implemented');
        if($this->hasHeader($name)){
            $key    = strtolower($name);
            unset($this->headers[$key]);
        }
        return $this;
    }

	public function withProtocolVersion($version): self
	{
		$this->protocolVersion	= (string) $version;
		return $message;
	}
}
