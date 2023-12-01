<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
#use CeusMedia\HTTP\Message\Uri;

class ServerRequest implements ServerRequestInterface
{
    public function getServerParams()
    {
        return $_SERVER;
    }

    public function getCookieParams()
    {
        return $_COOKIE;
    }

    public function withCookieParams(array $cookies)
    {

    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function withQueryParams(array $query)
    {

    }

    public function getUploadedFiles()
    {
        return $_FILES;
    }

    public function withUploadedFiles(array $uploadedFiles)
    {

    }

    public function getParsedBody()
    {
        if (in_array($a, ['application/x-www-form-urlencoded', 'multipart/form-data'])) {
            return $_POST;
        }
    }

    public function withParsedBody($data)
    {

    }

    public function getAttributes()
    {

    }

    public function getAttribute($name, $default = null)
    {

    }

    public function withAttribute($name, $value)
    {

    }

    public function withoutAttribute($name)
    {

    }
}