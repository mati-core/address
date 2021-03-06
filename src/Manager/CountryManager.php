<?php

declare(strict_types=1);

namespace MatiCore\Address;


use Baraja\Doctrine\EntityManager;
use Baraja\Doctrine\EntityManagerException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Nette\Utils\Strings;
use MatiCore\Address\Entity\Country;

/**
 * Class CountryManager
 * @package MatiCore\Address
 */
class CountryManager
{

	/**
	 * @var EntityManager
	 */
	private EntityManager $entityManager;

	/**
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @return int
	 */
	public function getCountriesCount(): int
	{
		return count($this->getCountries());
	}

	/**
	 * @return Country[]
	 */
	public function getCountries(): array
	{
		static $cache;

		if ($cache === null) {
			$cache = $this->entityManager->getRepository(Country::class)
				->createQueryBuilder('country')
				->select('country')
				->orderBy('country.active','DESC')
				->addOrderBy('country.name','ASC')
				->getQuery()
				->getResult();
		}

		return $cache;
	}

	/**
	 * @return Country[]
	 */
	public function getCountriesActive(): array
	{
		static $return;

		if ($return === null) {
			$return = [];

			foreach ($this->getCountries() as $country) {
				if ($country->isActive()) {
					$return[] = $country;
				}
			}
		}

		return $return;
	}

	/**
	 * @param bool $active
	 * @return array<string>
	 */
	public function getCountriesForForm(bool $active = true): array
	{
		$countries = $active === true ? $this->getCountriesActive() : $this->getCountries();

		$list = [];

		foreach($countries as $country){
			$list[$country->getId()] = $country->getName();
		}

		return $list;
	}

	/**
	 * @param string $id
	 * @return Country
	 * @throws NoResultException|NonUniqueResultException
	 */
	public function getCountryById(string $id): Country
	{
		static $cache = [];

		if (isset($cache[$id]) === false) {
			$cache[$id] = $this->entityManager->getRepository(Country::class)
				->createQueryBuilder('country')
				->where('country.id = :id')
				->setParameter('id', $id)
				->getQuery()
				->getSingleResult();
		}

		return $cache[$id];
	}

	/**
	 * @param string $code
	 * @return Country
	 * @throws NoResultException|NonUniqueResultException
	 */
	public function getCountryByIsoCode(string $code): Country
	{
		static $cache = [];
		$code = Strings::upper($code);

		if (isset($cache[$code]) === false) {
			$cache[$code] = $this->entityManager->getRepository(Country::class)
				->createQueryBuilder('country')
				->select('country')
				->where('country.isoCode = :isoCode')
				->setParameter('isoCode', $code)
				->setMaxResults(1)
				->getQuery()
				->getSingleResult();
		}

		return $cache[$code];
	}

	/**
	 * Install countries
	 *
	 * @throws CountryException
	 * @throws EntityManagerException
	 */
	public function installCountries(): void
	{
		if (count($this->getCountries()) > 0) {
			CountryException::countriesAlreadyInstalled();
		}

		$countryList = [
			['Afghanistan', 'AFG'],
			['Aland Islands', 'ALA'],
			['Albania', 'ALB'],
			['Algeria', 'DZA'],
			['American Samoa', 'ASM'],
			['Andorra', 'AND'],
			['Angola', 'AGO'],
			['Anguilla', 'AIA'],
			['Antarctica', 'ATA'],
			['Antigua and Barbuda', 'ATG'],
			['Argentina', 'ARG'],
			['Armenia', 'ARM'],
			['Aruba', 'ABW'],
			['Australia', 'AUS'],
			['Austria', 'AUT'],
			['Azerbaijan', 'AZE'],
			['Bahamas', 'BHS'],
			['Bahrain', 'BHR'],
			['Bangladesh', 'BGD'],
			['Barbados', 'BRB'],
			['Belarus', 'BLR'],
			['Belgium', 'BEL'],
			['Belize', 'BLZ'],
			['Benin', 'BEN'],
			['Bermuda', 'BMU'],
			['Bhutan', 'BTN'],
			['Bolivia', 'BOL'],
			['Bosnia and Herzegovina', 'BIH'],
			['Botswana', 'BWA'],
			['Bouvet Island', 'BVT'],
			['Brazil', 'BRA'],
			['British Virgin Islands', 'VGB'],
			['British Indian Ocean Territory', 'IOT'],
			['Brunei Darussalam', 'BRN'],
			['Bulgaria', 'BGR'],
			['Burkina Faso', 'BFA'],
			['Burundi', 'BDI'],
			['Cambodia', 'KHM'],
			['Cameroon', 'CMR'],
			['Canada', 'CAN'],
			['Cape Verde', 'CPV'],
			['Cayman Islands', 'CYM'],
			['Central African Republic', 'CAF'],
			['Chad', 'TCD'],
			['Chile', 'CHL'],
			['China', 'CHN'],
			['Hong Kong, SAR China', 'HKG'],
			['Macao, SAR China', 'MAC'],
			['Christmas Island', 'CXR'],
			['Cocos (Keeling) Islands', 'CCK'],
			['Colombia', 'COL'],
			['Comoros', 'COM'],
			['Congo (Brazzaville)', 'COG'],
			['Congo, (Kinshasa)', 'COD'],
			['Cook Islands', 'COK'],
			['Costa Rica', 'CRI'],
			['C??te d Ivoire', 'CIV'],
			['Croatia', 'HRV'],
			['Cuba', 'CUB'],
			['Cyprus', 'CYP'],
			['Czech Republic', 'CZE'],
			['Denmark', 'DNK'],
			['Djibouti', 'DJI'],
			['Dominica', 'DMA'],
			['Dominican Republic', 'DOM'],
			['Ecuador', 'ECU'],
			['Egypt', 'EGY'],
			['El Salvador', 'SLV'],
			['Equatorial Guinea', 'GNQ'],
			['Eritrea', 'ERI'],
			['Estonia', 'EST'],
			['Ethiopia', 'ETH'],
			['Falkland Islands (Malvinas)', 'FLK'],
			['Faroe Islands', 'FRO'],
			['Fiji', 'FJI'],
			['Finland', 'FIN'],
			['France', 'FRA'],
			['French Guiana', 'GUF'],
			['French Polynesia', 'PYF'],
			['French Southern Territories', 'ATF'],
			['Gabon', 'GAB'],
			['Gambia', 'GMB'],
			['Georgia', 'GEO'],
			['Germany', 'DEU'],
			['Ghana', 'GHA'],
			['Gibraltar', 'GIB'],
			['Greece', 'GRC'],
			['Greenland', 'GRL'],
			['Grenada', 'GRD'],
			['Guadeloupe', 'GLP'],
			['Guam', 'GUM'],
			['Guatemala', 'GTM'],
			['Guernsey', 'GGY'],
			['Guinea', 'GIN'],
			['Guinea-Bissau', 'GNB'],
			['Guyana', 'GUY'],
			['Haiti', 'HTI'],
			['Heard and Mcdonald Islands', 'HMD'],
			['Holy See (Vatican City State)', 'VAT'],
			['Honduras', 'HND'],
			['Hungary', 'HUN'],
			['Iceland', 'ISL'],
			['India', 'IND'],
			['Indonesia', 'IDN'],
			['Iran, Islamic Republic of', 'IRN'],
			['Iraq', 'IRQ'],
			['Ireland', 'IRL'],
			['Isle of Man', 'IMN'],
			['Israel', 'ISR'],
			['Italy', 'ITA'],
			['Jamaica', 'JAM'],
			['Japan', 'JPN'],
			['Jersey', 'JEY'],
			['Jordan', 'JOR'],
			['Kazakhstan', 'KAZ'],
			['Kenya', 'KEN'],
			['Kiribati', 'KIR'],
			['Korea (North)', 'PRK'],
			['Korea (South)', 'KOR'],
			['Kuwait', 'KWT'],
			['Kyrgyzstan', 'KGZ'],
			['Lao PDR', 'LAO'],
			['Latvia', 'LVA'],
			['Lebanon', 'LBN'],
			['Lesotho', 'LSO'],
			['Liberia', 'LBR'],
			['Libya', 'LBY'],
			['Liechtenstein', 'LIE'],
			['Lithuania', 'LTU'],
			['Luxembourg', 'LUX'],
			['Macedonia, Republic of', 'MKD'],
			['Madagascar', 'MDG'],
			['Malawi', 'MWI'],
			['Malaysia', 'MYS'],
			['Maldives', 'MDV'],
			['Mali', 'MLI'],
			['Malta', 'MLT'],
			['Marshall Islands', 'MHL'],
			['Martinique', 'MTQ'],
			['Mauritania', 'MRT'],
			['Mauritius', 'MUS'],
			['Mayotte', 'MYT'],
			['Mexico', 'MEX'],
			['Micronesia, Federated States of', 'FSM'],
			['Moldova', 'MDA'],
			['Monaco', 'MCO'],
			['Mongolia', 'MNG'],
			['Montenegro', 'MNE'],
			['Montserrat', 'MSR'],
			['Morocco', 'MAR'],
			['Mozambique', 'MOZ'],
			['Myanmar', 'MMR'],
			['Namibia', 'NAM'],
			['Nauru', 'NRU'],
			['Nepal', 'NPL'],
			['Netherlands', 'NLD'],
			['Netherlands Antilles', 'ANT'],
			['New Caledonia', 'NCL'],
			['New Zealand', 'NZL'],
			['Nicaragua', 'NIC'],
			['Niger', 'NER'],
			['Nigeria', 'NGA'],
			['Niue', 'NIU'],
			['Norfolk Island', 'NFK'],
			['Northern Mariana Islands', 'MNP'],
			['Norway', 'NOR'],
			['Oman', 'OMN'],
			['Pakistan', 'PAK'],
			['Palau', 'PLW'],
			['Palestinian Territory', 'PSE'],
			['Panama', 'PAN'],
			['Papua New Guinea', 'PNG'],
			['Paraguay', 'PRY'],
			['Peru', 'PER'],
			['Philippines', 'PHL'],
			['Pitcairn', 'PCN'],
			['Poland', 'POL'],
			['Portugal', 'PRT'],
			['Puerto Rico', 'PRI'],
			['Qatar', 'QAT'],
			['R??union', 'REU'],
			['Romania', 'ROU'],
			['Russian Federation', 'RUS'],
			['Rwanda', 'RWA'],
			['Saint-Barth??lemy', 'BLM'],
			['Saint Helena', 'SHN'],
			['Saint Kitts and Nevis', 'KNA'],
			['Saint Lucia', 'LCA'],
			['Saint-Martin (French part)', 'MAF'],
			['Saint Pierre and Miquelon', 'SPM'],
			['Saint Vincent and Grenadines', 'VCT'],
			['Samoa', 'WSM'],
			['San Marino', 'SMR'],
			['Sao Tome and Principe', 'STP'],
			['Saudi Arabia', 'SAU'],
			['Senegal', 'SEN'],
			['Serbia', 'SRB'],
			['Seychelles', 'SYC'],
			['Sierra Leone', 'SLE'],
			['Singapore', 'SGP'],
			['Slovakia', 'SVK'],
			['Slovenia', 'SVN'],
			['Solomon Islands', 'SLB'],
			['Somalia', 'SOM'],
			['South Africa', 'ZAF'],
			['South Georgia and the South Sandwich Islands', 'SGS'],
			['South Sudan', 'SSD'],
			['Spain', 'ESP'],
			['Sri Lanka', 'LKA'],
			['Sudan', 'SDN'],
			['Suriname', 'SUR'],
			['Svalbard and Jan Mayen Islands', 'SJM'],
			['Swaziland', 'SWZ'],
			['Sweden', 'SWE'],
			['Switzerland', 'CHE'],
			['Syrian Arab Republic (Syria)', 'SYR'],
			['Taiwan, Republic of China', 'TWN'],
			['Tajikistan', 'TJK'],
			['Tanzania, United Republic of', 'TZA'],
			['Thailand', 'THA'],
			['Timor-Leste', 'TLS'],
			['Togo', 'TGO'],
			['Tokelau', 'TKL'],
			['Tonga', 'TON'],
			['Trinidad and Tobago', 'TTO'],
			['Tunisia', 'TUN'],
			['Turkey', 'TUR'],
			['Turkmenistan', 'TKM'],
			['Turks and Caicos Islands', 'TCA'],
			['Tuvalu', 'TUV'],
			['Uganda', 'UGA'],
			['Ukraine', 'UKR'],
			['United Arab Emirates', 'ARE'],
			['United Kingdom', 'GBR'],
			['United States of America', 'USA'],
			['US Minor Outlying Islands', 'UMI'],
			['Uruguay', 'URY'],
			['Uzbekistan', 'UZB'],
			['Vanuatu', 'VUT'],
			['Venezuela (Bolivarian Republic)', 'VEN'],
			['Viet Nam', 'VNM'],
			['Virgin Islands, US', 'VIR'],
			['Wallis and Futuna Islands', 'WLF'],
			['Western Sahara', 'ESH'],
			['Yemen', 'YEM'],
			['Zambia', 'ZMB'],
			['Zimbabwe', 'ZWE'],
		];

		foreach ($countryList as $countryData) {
			$country = new Country($countryData[0], $countryData[1]);
			if ($countryData[1] === 'CZE') {
				$country->setActive(true);
			}
			$this->entityManager->persist($country);
		}

		$this->entityManager->flush();
	}
}