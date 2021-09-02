<?php

declare(strict_types=1);


namespace App\AdminModule\Presenters;


use Baraja\Doctrine\EntityManagerException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use MatiCore\Address\CountryException;
use MatiCore\Address\CountryManager;
use Nette\Application\AbortException;

class CountryInnerPackagePresenter extends BaseAdminPresenter
{

	/**
	 * @var CountryManager
	 * @inject
	 */
	public CountryManager $countryManager;

	public function actionDefault(): void
	{
		$this->template->countries = $this->countryManager->getCountries();
	}

	/**
	 * @throws AbortException
	 */
	public function actionInstall(): void
	{
		try {
			$this->countryManager->installCountries();

			$this->flashMessage('Seznam zemí byl úspěšně nainstalován.', 'success');
		} catch (CountryException $e) {
			$this->flashMessage('Země jsou již nainstalovány, nebo tabulka není prázdná.', 'warning');
		} catch (EntityManagerException $e) {
			$this->flashMessage('Při ukládání do databáze nastala chyba.', 'danger');
		}

		$this->redirect('default');
	}

	/**
	 * @param string $id
	 * @throws AbortException
	 */
	public function handleActive(string $id): void
	{
		try {
			$country = $this->countryManager->getCountryById($id);
			$country->setActive(!$country->isActive());

			$this->entityManager->getUnitOfWork()->commit($country);
			$this->flashMessage('Změny byly úspěšně uloženy.', 'success');
		} catch (NoResultException|NonUniqueResultException $e) {
			$this->flashMessage('Požadovaná země nenalezena.', 'danger');
		} catch (EntityManagerException $e) {
			$this->flashMessage('Při ukládání do databáze nastala chyba.', 'danger');
		}

		$this->redirect('default');
	}

}