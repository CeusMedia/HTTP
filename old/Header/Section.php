<?php
/**
 *	...
 *
 *	Copyright (c) 2010-2018 Christian Würker (ceusmedia.de)
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
 *	@package		CeusMedia_Common_Net_HTTP_Header
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2018 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 *	@since			0.7.1
 *	@version		$Id$
 */
/**
 *	...
 *
 *	@category		Library
 *	@package		CeusMedia_Common_Net_HTTP_Header
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2010-2018 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/Common
 *	@since			0.7.1
 *	@version		$Id$
 *	@see			http://www.w3.org/Protocols/rfc2616/rfc2616-sec4.html#sec4.2 RFC 2616 HTTP Message Headers
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
class Net_HTTP_Header_Section
{
	protected $fields	= array(
		'general'	=> array(
			'cache-control'			=> array(),
			'connection'			=> array(),
			'date'					=> array(),
			'pragma'				=> array(),
			'trailer'				=> array(),
			'transfer-encoding'		=> array(),
			'upgrade'				=> array(),
			'via'					=> array(),
			'warning'				=> array()
		),
		'request'	=> array(
			'accept'				=> array(),
			'accept-charset'		=> array(),
			'accept-encoding'		=> array(),
			'accept-language'		=> array(),
			'authorization'			=> array(),
			'expect'				=> array(),
			'from'					=> array(),
			'host'					=> array(),
			'if-match'				=> array(),
			'if-modified-since'		=> array(),
			'if-none-match'			=> array(),
			'if-range'				=> array(),
			'if-unmodified-since'	=> array(),
			'max-forwards'			=> array(),
			'proxy-authorization'	=> array(),
			'range'					=> array(),
			'referer'				=> array(),
			'te'					=> array(),
			'user-agent'			=> array()
		),
		'response'	=> array(
			'accept-ranges'			=> array(),
			'age'					=> array(),
			'etag'					=> array(),
			'location'				=> array(),
			'proxy-authenticate'	=> array(),
			'retry-after'			=> array(),
			'server'				=> array(),
			'vary'					=> array(),
			'www-authenticate'		=> array()
		),
		'entity'	=> array(
			'allow'		=> array(),
			'content-encoding'		=> array(),
			'content-language'		=> array(),
			'content-length'		=> array(),
			'content-location'		=> array(),
			'content-md5'			=> array(),
			'content-range'			=> array(),
			'content-type'			=> array(),
			'expires'				=> array(),
			'last-modified'			=> array()
		),
		'others'	=> array(
		)
	);

	public function addField( Net_HTTP_Header_Field $field )
	{
		return $this->setField( $field, FALSE );
	}

	public function addFieldPair( $name, $value )
	{
		$field	= new Net_HTTP_Header_Field( $name, $value );
		$this->addField( $field );
	}

	public function addFields( $fields )
	{
		foreach( $fields as $field )
			$this->addField( $field );
	}

	public function getField( $name )
	{
		$name	= strtolower( $name );
		foreach( $this->fields as $sectionName => $sectionPairs )
			if( array_key_exists( $name, $sectionPairs ) )
				return $this->fields[$sectionName][$name];
		return NULL;
	}

	public function getFields()
	{
		$list	= array();
		foreach( $this->fields as $sectionName => $sectionPairs )
			foreach( $sectionPairs as $name => $fieldList )
				if( count( $fieldList ) )
					foreach( $fieldList as $field )
						$list[]	= $field;
		return $list;
	}

	public function getFieldsByName( $name, $latestOnly = FALSE )
	{
		$name	= strtolower( $name );
		foreach( $this->fields as $sectionName => $sectionPairs ){
			if( array_key_exists( $name, $sectionPairs ) ){
				if( $this->fields[$sectionName][$name] ){
					if( $latestOnly ){
						$size	= count( $this->fields[$sectionName][$name] );
						return $this->fields[$sectionName][$name][$size - 1];
					}
					return $this->fields[$sectionName][$name];
				}
			}
		}
		if( $latestOnly )
			return NULL;
		return array();
	}

	public function hasField( $name )
	{
		$name	= strtolower( $name );
		foreach( $this->fields as $sectionName => $sectionPairs )
			if( array_key_exists( $name, $sectionPairs ) )
				return (bool) count( $this->fields[$sectionName][$name] );
		return FALSE;
	}

	public function removeField( Net_HTTP_Header_Field $field )
	{
		$name	= $field->getName();
		foreach( $this->fields as $sectionName => $sectionPairs )
		{
			if( !array_key_exists( $name, $sectionPairs ) )
				continue;
			foreach( $sectionPairs as $nr => $sectionField )
				if( $sectionField == $field )
					unset( $this->fields[$sectionName][$name][$nr] );
		}
	}

	public function removeByName( $name )
	{
		if( isset( $this->fields['others'][$name] ) )
			unset( $this->fields['others'][$name] );
		foreach( $this->fields as $sectionName => $sectionPairs )
			if( array_key_exists( $name, $sectionPairs ) )
				$this->fields[$sectionName][$name]		= array();
		return $this;
	}

	public function setField( Net_HTTP_Header_Field $field, $emptyBefore = TRUE )
	{
		$name	= $field->getName();
		foreach( $this->fields as $sectionName => $sectionPairs )
		{
			if( array_key_exists( $name, $sectionPairs ) )
			{
				if( $emptyBefore )
					$this->fields[$sectionName][$name]		= array();
				$this->fields[$sectionName][$name][]	= $field;
				return;
			}
		}
		if( $emptyBefore || !isset( $this->fields['others'][$name] ) )
			$this->fields['others'][$name]	= array();
		$this->fields['others'][$name][]	= $field;
		return $this;
	}

	public function setFieldPair( $name, $value, $emptyBefore = TRUE )
	{
		$this->setField( new Net_HTTP_Header_Field( $name, $value ), $emptyBefore );
		return $this;
	}

	/**
	 *	@deprecated		use method "getFields" instead, which will provide field objects instead of rendered strings
	 *	@todo			0.9: to be removed
	 */
	public function toArray()
	{
		Deprecation::getInstance()->setExceptionVersion( '0.9' )
			->message(  'Use "getFields" instead, which will provide field objects instead of rendered strings' );
		$list	= array();
		foreach( $this->fields as $sectionName => $sectionPairs )
			foreach( $sectionPairs as $name => $fields )
				if( $fields )
					foreach( $fields as $field )
						$list[]	= $field->toString();
		return $list;
	}

	public function render(){
		return Net_HTTP_Header_Renderer::render( $this );
	}

	/**
	 *	@deprecated		use render method instead
	 *	@todo			0.9: to be removed
	 */
	public function toString()
	{
		Deprecation::getInstance()->setExceptionVersion( '0.9' )
			->message(  'Use render method instead' );
		$list = implode( "\r\n", $this->toArray() );												//  collect fields with line breaks inbetween
		return $list ? $list."\r\n" : $list;														//  return field list with line break or empty string
	}
}
?>
