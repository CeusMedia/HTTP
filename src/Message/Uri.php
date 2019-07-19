<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface{

    protected $scheme;
    protected $host;
    protected $port;
    protected $path;
    protected $query;
    protected $fragment;
    protected $username;
    protected $password;

    public function __construct($uri = NULL)
    {
        if(!is_null($uri)){
            $parts  = (object)array_merge([
                'scheme'    => null,
                'host'      => null,
                'port'      => null,
                'user'      => null,
                'pass'      => null,
                'path'      => null,
                'query'     => null,
                'fragment'  => null,
            ], parse_url($uri));
            $this->withScheme($parts->scheme);
            $this->withHost($parts->host);
            $this->withPort($parts->port);
            $this->withPath($parts->path);
            $this->withQuery($parts->query);
            $this->withFragment($parts->fragment);
            $this->withUserInfo($parts->user, $parts->pass);
        }
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getAuthority(): string
    {
        $string     = '';
        $userInfo   = $this->getUserInfo();
        $port       = $this->getPort();
        return vsprintf('%s%s%s', array(
            strlen($userInfo) ? $userInfo.'@' : '',
            $this->getHost(),
            !is_null($port) ? ':'.$port : '',
        ));
    }

    public function getUserInfo(): string
    {
        $string = '';
        if(!is_null($this->username)){
            $string .= $this->username;
            if(!is_null($this->password))
                $string .= ':'.$this->password;
        }
        return $string;
    }

    public function getHost(): string
    {
        return (string)$this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath(): string
    {
		$path	= strlen($this->path) ? $this->path : '/';
		if (!$path[0] === '/')
			$path	= '/'.$path;
        return (string)$path;
    }

    public function getQuery(): string
    {
        return (string)$this->query;
    }

    public function getFragment(): string
    {
        return (string)$this->fragment;
    }

    public function withScheme($scheme): self
    {
        $this->scheme   = $scheme;
        return $this;
    }

    public function withUserInfo($username, $password = NULL): self
    {
        $this->username   = $username;
        $this->password   = $password;
        return $this;
    }

    public function withHost($host): self
    {
        if(!strlen(trim($host)))
            $host = NULL;
        $this->host   = $host;
        return $this;
    }

    public function withPort($port): self
    {
        if(!strlen(trim($port)))
            $port = NULL;
        $this->port   = $port;
        return $this;
    }

    public function withPath($path): self
    {
        if(!strlen(trim($path)))
            $path = NULL;
        $this->path   = $path;
        return $this;
    }

    public function withQuery($query): self
    {
        if(!strlen(trim($query)))
            $query = NULL;
        $this->query   = $query;
        return $this;
    }

    public function withFragment($fragment): self
    {
        if(!strlen(trim($fragment)))
            $fragment = NULL;
        $this->fragment   = $fragment;
        return $this;
    }

    public function __toString(): string
    {
        $uriAsString    = vsprintf('%s%s%s%s%s', array(
            strlen($this->getScheme()) ? $this->getScheme().':' : '',
            strlen($this->getAuthority()) ? '//'.$this->getAuthority() : '',
            $this->getPath(),
            strlen($this->getQuery()) ? '?'.$this->getQuery() : '',
            strlen($this->getFragment()) ? '#'.$this->getFragment() : '',
        ));
/*        var_export($this);
        var_export($uriAsString);
        die;*/
        return $uriAsString;
    }
}
