<?php
namespace CeusMedia\HTTP\Message;

use Psr\Http\Message;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use CeusMedia\Http\Message\Stream;

class UploadedFile implements UploadedFileInterface
{
	protected $source;
	protected $isStream;
	protected $size;
	protected $error;
	protected $clientFilename;
	protected $clientMediaType;

	public function __construct( $source, int $size, int $error, ?string $clientFilename = NULL, ?string $clientMediaType = NULL )
	{
		$this->source			= $source;
		$this->size				= $size;
		$this->erorr			= $error;
		$this->clientFilename	= $clientFilename;
		$this->clientMediaType	= $clientMediaType;

		if( is_resource( $source ) ){
			$this->isStream		= TRUE;
			$this->source		= new Stream( $source );
		}
		else if( $source instanceof StreamInterface )
			$this->isStream		= TRUE;
		else if( is_string( $source ) )
			$this->isStream		= FALSE;
		else
			throw new \InvalidArgumentException( 'Source must be file path or stream' );
	}

	public function getStream() : StreamInterface
	{
		if( $this->isStream )
			return $this->source;
		return new FileStream; // to implement
	}

	public function moveTo( $targetPath )
	{
		if( $this->isStream ){

		}
		else{

		}
	}

	public function getSize()
	{
		return $this->size;
	}

	public function getError()
	{
		return $this->error;
	}

	public function getClientFilename()
	{
		return $this->clientFilename;
	}

	public function getClientMediaType()
	{
		return $this->clientMediaType;
	}
}
