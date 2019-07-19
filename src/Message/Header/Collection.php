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
namespace CeusMedia\HTTP\Message\Header;

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
class Collection
{
	protected $allowedHeaders	= array(
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

	protected $fields	= [];

	public function addField( Field $field )
	{
		return $this->setField( $field, FALSE );
	}

	public function addFieldPair( $name, $value )
	{
		$field	= new Field( $name, $value );
		$this->addField( $field );
	}

	public function addFields( $fields )
	{
		foreach( $fields as $field )
			$this->addField( $field );
	}

	public function getFields()
	{
		$list	= array();
		foreach( $this->fields as $key => $fieldList ){
			if(!count($fieldList))
				continue;
			$values	= [];
			$name = null;
			foreach($fieldList as $field){
				$name 		= $name ? $name : $field->getName();
				$values[]	= $field->getValue();
			}
			$list[$name]	= $values;
		}
		return $list;
	}

	public function getFieldsByName( $name )
	{
		$list	= array();
		$key	= strtolower( $name );
		foreach($this->fields as $index => $field)
			if(strtolower($field->getName()) === $key)
				$list[]	 = $field;
		return array();
	}

	public function hasField( $name )
	{
		$key	= strtolower( $name );
		foreach($this->fields as $field)
			if(strtolower($field->getName()) === $key)
				return TRUE;
		return FALSE;
	}

	public function removeField( Field $field )
	{
		foreach($this->fields as $index => $item)
			if(strtolower($item->getName()) === strtolower($field->getName()))
				if($item->getValue() === $field->getValue())
					unset($this->fields[$index]);
		return $this;
	}

	public function removeByName( $name )
	{
		foreach($this->fields as $index => $item)
			if(strtolower($item->getName()) === strtolower($field->getName()))
				unset($this->fields[$index]);
		return $this;
	}

	public function setField( Field $field, $emptyBefore = TRUE ): self
	{
		$this->validateFieldName($field->getName());
        $key    = strtolower($field->getName());
		if(!isset($this->fields[$key]) || $emptyBefore)
			$this->fields[$key]   = [];
        $this->fields[$key][]   = $field;
		return $this;
	}

	public function setFieldPair( $name, $value, $emptyBefore = TRUE )
	{
		$this->setField( new Field( $name, $value ), $emptyBefore );
		return $this;
	}

	public function render(){
		$fields	= $this->fields;
		if (!$fields)
			return '';
		$list	= array();
		foreach($fields as $field)
			$list[]	= $field->toString();
		$string	= join("\r\n", $list)."\r\n";
		return $string;
	}

	protected function validateFieldName($name){
		$name	= strtolower( $name );
		foreach($this->allowedHeaders as $section => $names)
			if(in_array($name, $names))
				return TRUE;
		if(substr($name, 0, 2) === 'x-')
			return TRUE;
		return FALSE;
	}

	public function __toString()
	{
		return $this->render();
	}
}
?>
