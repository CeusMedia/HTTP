<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
    public function __toString(): string
    {
        return '';
    }

    public function close()
    {

    }

    public function detach()
    {

    }

    public function getSize()
    {
        return 0;
    }

    public function tell()
    {

    }

    public function eof(): bool
    {

    }

    public function isSeekable(): bool
    {

    }

    public function seek(int $offset, $whence = SEEK_SET)
    {

    }

    public function rewind()
    {

    }

    public function isWritable(): bool
    {

    }


    public function write(string $string): int
    {
        return 0;
    }

    public function isReadable(): bool
    {

    }

    public function read(int $length): string
    {
        return '';
    }

    public function getContents(): string
    {
        return '';
    }

    public function getMetadata($key = NULL)
    {

    }
}
