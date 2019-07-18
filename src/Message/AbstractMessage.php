<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

abstract class AbstractMessage implements MessageInterface
{
	protected $protocolVersion = '1.1';
	protected $headers         = array();

	public function getHeaders(){
        $list   = [];
        foreach($this->headers as $header)
            $list[$header['name']]  = $header['values'];
		return $list;
	}

	public function getHeader($name)
    {
        $key    = strtolower($name);
        if(!isset($this->headers[$key]))
            return [];
		return $this->headers[$key]['values'];
	}

	public function getHeaderLine($name)
    {
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
        return $this->body;
    }

	public function withBody(StreamInterface $body): self
    {
        $this->body = $body;
	}

	public function hasHeader($name): bool
    {
        $key    = strtolower($name);
        return isset($this->headers[$key]);
	}

    public function withHeader($name, $value): self
    {
        $key    = strtolower($name);
        if(!is_array($value))
            $value  = [$value];
        $this->headers[$key]   = [
            'name'      => $name,
            'values'    => $value,
        ];
        return $this;
    }

    public function withAddedHeader($name, $value): self
    {
        if(!$this->hasHeader($name))
            return $this->withHeader($name, $value);
        $key    = strtolower($name);
        $header = $this->headers[$key];
        foreach($value as $item)
            $header['values'][]   = $item;
        return $this;
    }

    public function withoutHeader($name): self
    {
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
