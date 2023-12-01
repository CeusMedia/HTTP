<?php
/**
 *	Data Object for HTTP Headers.
 *
 *	Copyright (c) 2007-2023 Christian Würker (ceusmedia.de)
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
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/HTTP
 */

namespace CeusMedia\HTTP\Message\Header;

use CeusMedia\HTTP\Message\Header\Field\Parser as HeaderFieldParser;
use InvalidArgumentException;

/**
 *	Data Object of HTTP Headers.
 *	@category		Library
 *	@package		CeusMedia_HTTP_Message_Header
 *	@author			Christian Würker <christian.wuerker@ceusmedia.de>
 *	@copyright		2015-2023 Christian Würker
 *	@license		http://www.gnu.org/licenses/gpl-3.0.txt GPL 3
 *	@link			https://github.com/CeusMedia/HTTP
 */
class Field
{
	/**	@var		string		$name		Name of Header */
	protected string $name;
	/**	@var		string		$value		Value of Header */
	protected $value;

	/**
	 *	Tries to decode qualified values into a map of values ordered by their quality.
	 *	@static
	 *	@access		public
	 *	@param		string		$string			String of qualified values to decode
	 *	@param		boolean		$sortByLength	Flag: assume longer key as more qualified for keys with same quality (default: FALSE)
	 *	@return		array		Map of qualified values ordered by quality
	 */
	public static function decodeQualifiedValues( string $string, bool $sortByLength = TRUE ): array
	{
		return HeaderFieldParser::decodeQualifiedValues( $string, $sortByLength );
	}

	/**
	 *	Constructor.
	 *	@access		public
	 *	@param		string		$name		Name of Header
	 *	@param		string		$value		Value of Header
	 *	@return		void
	 */
	public function __construct( string $name, $value )
	{
		$this->setName( $name );
		$this->setValue( $value );
	}

	/**
	 *	Returns set Header Name.
	 *	@access		public
	 *	@return		string		Header Name
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 *	Returns set Header Value.
	 *	@access		public
	 *	@return		string|array	Header Value or Array of qualified Values
	 */
	public function getValue( ?bool $qualified = FALSE ): string
	{
		if( $qualified )
			return $this->decodeQualifiedValues ( $this->value );
		return $this->value;
	}

	public function setName( string $name ): self
	{
		if( !trim( $name ) )
			throw new InvalidArgumentException( 'Field name cannot be empty' );
		$this->name	= $name;
        return $this;
	}

	public function setValue( $value ): self
	{
		$this->value	= $value;
        return $this;
	}

	/**
	 *	Returns a representative string of Header.
	 *	@access		public
	 *	@return		string
	 */
	public function toString(): string
	{
		if( function_exists( 'mb_convert_case' ) )
			$name	= mb_convert_case( $this->name, MB_CASE_TITLE );
		else
			$name	= str_replace( " ", "-", ucwords( str_replace( "-", " ", $this->name ) ) );
		return $name.": ".$this->value;
	}

	public function __toString(): string
	{
		return $this->toString();
	}
}
