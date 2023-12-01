<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message;
use Psr\Http\Message\StreamInterface;

class Stream implements StreamInterface
{
	protected $handle;
	protected $size;
	protected int $position		= 0;

	public function __construct( $handle )
	{
		$this->handle	= $handle;
	}

	public function __toString(): string
	{
		return stream_get_contents( $this->handle );
	}

	public function close()
	{
		fclose( $this->handle );
	}

	public function detach()
	{
	}

	public function eof(): bool
	{
		return feof( $this->handle );
	}

	public function getContents(): string
	{
		return fgets( $this->handle );
	}

	public function getMetadata( $key = NULL )
	{
		if( is_null( $this->metaData ) )
			$this->metaData	= stream_get_meta_data( $this->handle );
		if( is_null( $key ) )
			return $this->metaData;
		$data	= $this->metaData;
		$keyParts	= explode('.', $key);
		foreach( $keyParts as $part ){
			if( !isset( $data[$part] ) )
				return null;
			$data	= $data[$part];
		}
		return $data;
	}

	public function getSize(): int
	{
		return $this->size;
	}

	public function isReadable(): bool
	{
		$mode	= $this->getMetadata('mode');
		return preg_match( '/(r|a|\+)/', $mode );
	}

	public function isWritable(): bool
	{
		$mode	= $this->getMetadata( 'mode' );
		return preg_match( '/(w|a|c|x\+)/', $mode );
	}

	public function isSeekable(): bool
	{
		return (bool) $this->getMetadata( 'seekable' );
	}

	public function read( int $length ): string
	{
		return fread( $this->handle, $length );
	}

	public function rewind()
	{
		rewind( $this->handle );
	}

	public function seek( $offset, $whence = SEEK_SET )
	{
		fseek( $this->handle, $offset, $whence );
	}

	public function tell(): int
	{
		return ftell( $this->handle );
	}

	public function write( string $string ): int
	{
		return fwrite( $this->handle, $string );
	}
}
