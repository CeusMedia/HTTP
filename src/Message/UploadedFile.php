<?php
namespace CeusMedia\HTTP\Message;

use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

class UploadedFile implements UploadedFileInterface
{
	/** @var Stream|StreamInterface  */
	protected $source;
	protected bool $isStream;
	protected int $size;
	protected int $error;
	protected ?string $clientFilename;
	protected ?string $clientMediaType;

	/**
	 *	@param		Stream|StreamInterface|resource|string	$source
	 *	@param		int				$size
	 *	@param		int				$error
	 *	@param		string|null		$clientFilename
	 *	@param		string|null		$clientMediaType
	 *	@throws		InvalidArgumentException
	 */
	public function __construct( $source, int $size, int $error, ?string $clientFilename = NULL, ?string $clientMediaType = NULL )
	{
		$this->source			= $source;
		$this->size				= $size;
		$this->error			= $error;
		$this->clientFilename	= $clientFilename;
		$this->clientMediaType	= $clientMediaType;

		if( $source instanceof StreamInterface )
			$this->isStream		= TRUE;
		else if( is_resource( $source ) ){
			$this->isStream		= TRUE;
			$this->source		= new Stream( $source );
		}
		else if( is_string( $source ) )
			$this->isStream		= FALSE;
		else
			throw new InvalidArgumentException( 'Source must be file path or stream' );
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

	public function getSize(): int
	{
		return $this->size;
	}

	public function getError(): int
	{
		return $this->error;
	}

	public function getClientFilename(): ?string
	{
		return $this->clientFilename;
	}

	public function getClientMediaType(): ?string
	{
		return $this->clientMediaType;
	}
}
