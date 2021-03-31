<?php

declare(strict_types=1);

namespace MatiCore\Address;

/**
 * Interface CountryManagerAccessor
 * @package MatiCore\Address
 */
interface CountryManagerAccessor
{

	/**
	 * @return CountryManager
	 */
	public function get(): CountryManager;

}