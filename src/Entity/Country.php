<?php

declare(strict_types=1);

namespace MatiCore\Address\Entity;


use Baraja\Doctrine\UUID\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;
use Nette\SmartObject;

/**
 * @ORM\Entity()
 * @ORM\Table(name="address__country")
 */
class Country
{

	use SmartObject;
	use UuidIdentifier;

	/**
	 * @var string
	 * @ORM\Column(type="string")
	 */
	private string $name;

	/**
	 * @var string
	 * @ORM\Column(type="string", unique=true)
	 */
	private string $isoCode;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $icon;

	/**
	 * @var bool
	 * @ORM\Column(type="boolean")
	 */
	private bool $active = false;

	/**
	 * @param string $name
	 * @param string $isoCode
	 */
	public function __construct(string $name, string $isoCode)
	{
		$this->setName($name);
		$this->isoCode = $isoCode;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getIsoCode(): string
	{
		return $this->isoCode;
	}

	/**
	 * @param string $isoCode
	 */
	public function setIsoCode(string $isoCode): void
	{
		$this->isoCode = $isoCode;
	}

	/**
	 * @return string|null
	 */
	public function getIcon(): ?string
	{
		return $this->icon;
	}

	/**
	 * @param string|null $icon
	 */
	public function setIcon(?string $icon = null): void
	{
		$this->icon = $icon;
	}

	/**
	 * @return bool
	 */
	public function isActive(): bool
	{
		return $this->active;
	}

	/**
	 * @param bool $active
	 */
	public function setActive(bool $active = true): void
	{
		$this->active = $active;
	}

}