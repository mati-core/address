<?php

declare(strict_types=1);

namespace MatiCore\Address\Entity;


use Baraja\Doctrine\UUID\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;
use Nette\SmartObject;
use Nette\Utils\Strings;
use Nette\Utils\Validators;

/**
 * @ORM\Entity()
 * @ORM\Table(name="address__address")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 */
class Address
{

	use UuidIdentifier;
	use SmartObject;

	/**
	 * @var Country|null
	 * @ORM\ManyToOne(targetEntity="\MatiCore\Address\Entity\Country")
	 * @ORM\JoinColumn(name="country_id", referencedColumnName="id", nullable=true)
	 */
	private Country|null $country;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $firstName;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $lastName;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $companyName;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $in;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $tin;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $street;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $city;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $zipCode;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $email;

	/** 
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $phone;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $gpsN;

	/**
	 * @var string|null
	 * @ORM\Column(type="string", nullable=true)
	 */
	private string|null $gpsE;

	/**
	 * @param string|null $street
	 * @param string|null $city
	 */
	public function __construct(?string $street, ?string $city)
	{
		$this->street = $street;
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function __toString(): string
	{
		return $this->getStreet() . ', ' . $this->getCity() . ', ' . $this->getZipCode();
	}

	/**
	 * @return Country|null
	 */
	public function getCountry(): ?Country
	{
		return $this->country;
	}

	/**
	 * @param Country|null $country
	 * @return Address
	 */
	public function setCountry(?Country $country): self
	{
		$this->country = $country ? : null;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFirstName(): ?string
	{
		return $this->firstName ? : null;
	}

	/**
	 * @param string|null $firstName
	 * @return Address
	 */
	public function setFirstName(?string $firstName): self
	{
		$this->firstName = $firstName === null || trim($firstName) === ''
			? null
			: Strings::firstUpper(trim($firstName));

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLastName(): ?string
	{
		return $this->lastName ? : null;
	}

	/**
	 * @param string|null $lastName
	 * @return Address
	 */
	public function setLastName(?string $lastName): self
	{
		$this->lastName = $lastName === null || trim($lastName) === ''
			? null
			: Strings::firstUpper(trim($lastName));

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return trim($this->getFirstName() . ' ' . $this->getLastName());
	}

	/**
	 * @param string $name
	 * @return Address
	 */
	public function setName(string $name): self
	{
		$name = trim($name);

		if (Strings::contains($name, ' ')) {
			preg_match('/^(?<firstName>\S+)\s*(?<lastName>.*?)$/', $name, $nameParser);

			$this->setFirstName($nameParser['firstName']);
			$lastName = '';

			foreach (explode(' ', trim($nameParser['lastName'])) as $item) {
				$lastName .= ($lastName === '' ? '' : ' ') . Strings::firstUpper($item);
			}

			$this->setLastName($lastName);
		} else {
			$this->setFirstName($name);
		}

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCompanyName(): ?string
	{
		return $this->companyName ? : null;
	}

	/**
	 * @param string|null $companyName
	 * @return Address
	 */
	public function setCompanyName(?string $companyName): self
	{
		$this->companyName = $companyName === null || trim($companyName) === ''
			? null
			: Strings::firstUpper($companyName);

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getIn(): ?string
	{
		return $this->in;
	}

	/**
	 * @param string|null $in
	 * @return $this
	 */
	public function setIn(?string $in): self
	{
		$this->in = $in;

		return $this;
	}

	/**
	 * @return string|null
	 * @deprecated Use getIn()
	 */
	public function getIc(): ?string
	{
		return $this->getIn();
	}

	/**
	 * @param string|null $ic
	 * @return $this
	 * @deprecated Use setIn()
	 */
	public function setIc(?string $ic): self
	{
		return $this->setIn($ic);
	}

	/**
	 * @return string|null
	 */
	public function getTin(): ?string
	{
		return $this->tin;
	}

	/**
	 * @param string|null $tin
	 * @return $this
	 */
	public function setTin(?string $tin): self
	{
		$this->tin = $tin;

		return $this;
	}

	/**
	 * @return string|null
	 * @deprecated Use getTin()
	 */
	public function getDic(): ?string
	{
		return $this->getTin();
	}

	/**
	 * @param string|null $dic
	 * @return Address
	 * @deprecated Use setTin()
	 */
	public function setDic(?string $dic): self
	{
		$this->setTin($dic);

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getStreet(): ?string
	{
		return $this->street ? : null;
	}

	/**
	 * @param string|null $street
	 * @return Address
	 */
	public function setStreet(?string $street): self
	{
		if ($street === null || trim($street) === '') {
			$this->street = null;
		} else {
			$this->street = $street;
		}

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getCity(): ?string
	{
		return $this->city ? : null;
	}

	/**
	 * @param string|null $city
	 * @return Address
	 */
	public function setCity(?string $city): self
	{
		if ($city === null || trim($city) === '') {
			$this->city = null;
		} else {
			$this->city = Strings::firstUpper($city);
		}

		return $this;
	}

	/**
	 * @deprecated since 2018-09-27
	 * @return string
	 */
	public function getTown(): string
	{
		return $this->getCity();
	}

	/**
	 * @return string|null
	 */
	public function getZipCode(): ?string
	{
		return $this->zipCode;
	}

	/**
	 * @param string|null $zipCode
	 * @return Address
	 */
	public function setZipCode(?string $zipCode): self
	{
		$this->zipCode = $zipCode === null || trim($zipCode) === ''
			? null
			: preg_replace('/\s+/', '', $zipCode);

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getEmail(): ?string
	{
		return $this->email;
	}

	/**
	 * @param string|null $email
	 * @return Address
	 * @throws AddressException
	 */
	public function setEmail(?string $email): self
	{
		if ($email === null || trim($email) === '') {
			$this->email = null;
		} else {
			if (!Validators::isEmail($email)) {
				throw new AddressException('Input ' . json_encode($email) . ' is not valid e-mail address.');
			}

			$this->email = $email;
		}

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPhone(): ?string
	{
		return $this->phone;
	}

	/**
	 * @param string|null $phone
	 * @return Address
	 */
	public function setPhone(?string $phone): self
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGpsN(): ?string
	{
		return $this->gpsN;
	}

	/**
	 * @param string|null $gpsN
	 * @return Address
	 */
	public function setGpsN(?string $gpsN): self
	{
		$this->gpsN = $gpsN;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getGpsE(): ?string
	{
		return $this->gpsE;
	}

	/**
	 * @param string|null $gpsE
	 * @return Address
	 */
	public function setGpsE(?string $gpsE): self
	{
		$this->gpsE = $gpsE;

		return $this;
	}

}
