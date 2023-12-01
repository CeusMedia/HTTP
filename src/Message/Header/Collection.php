<?php
/**
 *	...
 *
 *	Copyright (c) 2010-2023 Christian Würker (ceusmedia.de)
 *
 *	This program is free software: you can redistribute it and/or modify
 *	it under the terms of the GNU General Public License as published by
 *	the Free Software Foundation, either version 3 of the License, or
 *	(at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *	@category		Library
 *	@package		CeusMedia_HTTP_Message_Header
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/HTTP
 */
namespace CeusMedia\HTTP\Message\Header;

/**
 *	...
 *
 *	@category		Library
 *	@package		CeusMedia_HTTP_Message_Header
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/HTTP
 *	@see			https://www.rfc-editor.org/rfc/rfc2616.html#section-4.2 RFC 2616 HTTP Message Headers (obsolete)
 *	@see			https://www.rfc-editor.org/rfc/rfc9110.html RFC 9110 HTTP Semantics
 *
 *	GENERAL
 *	-------
 *	Cache-Control
 *	Connection
 *	Date
 *	Pragma
 *	Trailer
 *	Transfer-Encoding
 *	Upgrade
 *	Via
 *	Warning
 *
 *	REQUEST
 *	-------
 *	Accept
 *	Accept-Charset
 *	Accept-Encoding
 *	Accept-Language
 *	Authorization
 *	Expect
 *	From
 *	Host
 *	If-Match
 *	If-Modified-Since
 *	If-None-Match
 *	If-Range
 *	If-Unmodified-Since
 *	Max-Forwards
 *	Proxy-Authorization
 *	Range
 *	Referer
 *	TE
 *	User-Agent
 *
 *	RESPONSE
 *	--------
 *	Accept-Ranges
 *	Age
 *	ETag
 *	Location
 *	Proxy-Authenticate
 *	Retry-After
 *	Server
 *	Vary
 *	WWW-Authenticate
 *
 *	ENTITY
 *	------
 *	Allow
 *	Content-Encoding
 *	Content-Language
 *	Content-Length
 *	Content-Location
 *	Content-MD5
 *	Content-Range
 *	Content-Type
 *	Expires
 *	Last-Modified
 */
class Collection
{
	protected array $allowedHeaders	= [
		'general'	=> [
			'cache-control'			=> [],
			'connection'			=> [],
			'date'					=> [],
			'pragma'				=> [],
			'trailer'				=> [],
			'transfer-encoding'		=> [],
			'upgrade'				=> [],
			'via'					=> [],
			'warning'				=> [],
		],
		'request'	=> [
			'accept'				=> [],
			'accept-charset'		=> [],
			'accept-encoding'		=> [],
			'accept-language'		=> [],
			'authorization'			=> [],
			'expect'				=> [],
			'from'					=> [],
			'host'					=> [],
			'if-match'				=> [],
			'if-modified-since'		=> [],
			'if-none-match'			=> [],
			'if-range'				=> [],
			'if-unmodified-since'	=> [],
			'max-forwards'			=> [],
			'proxy-authorization'	=> [],
			'range'					=> [],
			'referer'				=> [],
			'te'					=> [],
			'user-agent'			=> [],
		],
		'response'	=> [
			'accept-ranges'			=> [],
			'age'					=> [],
			'etag'					=> [],
			'location'				=> [],
			'proxy-authenticate'	=> [],
			'retry-after'			=> [],
			'server'				=> [],
			'vary'					=> [],
			'www-authenticate'		=> [],
		],
		'entity'	=> [
			'allow'		=> [],
			'content-encoding'		=> [],
			'content-language'		=> [],
			'content-length'		=> [],
			'content-location'		=> [],
			'content-md5'			=> [],
			'content-range'			=> [],
			'content-type'			=> [],
			'expires'				=> [],
			'last-modified'			=> [],
		],
		'others'	=> [],
	];

	protected array $fields	= [];

	public function addField( Field ...$field ): self
	{
		foreach( $field as $item )
			$this->setField( $item, FALSE );
		return $this;
	}

	public function getFields(): array
	{
		$list	= [];
		foreach( $this->fields as $key => $fields )
			foreach( $fields as $field )
				$list[]	= $field;
		return $list;
	}

	public function getFieldsByName( string $name ): array
	{
		if( !$this->hasField( $name ) )
			return [];
		return $this->fields[strtolower( $name )];
	}

	public function hasField( string $name ): bool
	{
		return array_key_exists( strtolower( $name ), $this->fields );
	}

	public function removeField( Field $field ): self
	{
		$fieldName	= strtolower( $field->getName() );
		foreach( $this->fields as $key => $items ){
			foreach( $items as $index => $item ){
				if( strtolower( $item->getName() ) === $fieldName ){
					if( $item->getValue() === $field->getValue() ){
						unset( $this->fields[$key][$index] );
						if( 0 === count( $this->fields[$key] ) ){
							unset( $this->fields[$key] );
						}
					}
				}
			}
		}
		return $this;
	}

	public function removeFieldByName( string $name ): self
	{
		$name	= strtolower( $name );
		foreach( $this->fields as $key => $items ){
			foreach( $items as $index => $item ){
				if( strtolower( $item->getName() ) === $name ){
					unset( $this->fields[$key][$index] );
					if( 0 === count( $this->fields[$key] ) ){
						unset( $this->fields[$key] );
					}
				}
			}
		}
		return $this;
	}

	public function setField( Field $field, ?bool $emptyBefore = TRUE ): self
	{
		$this->validateFieldName( $field->getName() );
		$key	= strtolower( $field->getName() );
		if( !isset( $this->fields[$key] ) || $emptyBefore )
			$this->fields[$key]		= [];
		$this->fields[$key][]	= $field;
		return $this;
	}

	public function render(): string
	{
		$list	= [];
		foreach( $this->fields as $key => $items )
			foreach( $items as $item )
				$list[]	= $item->toString();
		return join( "\r\n", $list )."\r\n";
	}

	protected function validateFieldName( string $name ): bool
	{
		$name	= strtolower( $name );
		foreach( $this->allowedHeaders as $section => $names )
			if( in_array( $name, $names ) )
				return TRUE;
		if( 'x-' === substr( $name, 0, 2 ) )
			return TRUE;
		return FALSE;
	}

	public function __toString(): string
	{
		return $this->render();
	}
}

