<?php

declare(strict_types=1);

namespace MatiCore\Address;


/**
 * Class CountryException
 * @package MatiCore\Address
 */
class CountryException extends \Exception
{

	/**
	 * @return CountryException
	 * @throws CountryException
	 */
	public static function countriesAlreadyInstalled(): self
	{
		throw new self('Countries are already installed.');
	}
	
}