<?php

/**
 * isotope_donate extension for Contao Open Source CMS
 *
 * Copyright (C) 2013 Kamil Kuzminski
 *
 * @package isotope_donate
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */

namespace Contao;


/**
 * Class ModuleDonations
 *
 * Front end module "donations".
 */
class ModuleDonations extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_donations';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['donations'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$objQuery = new DC_Multilingual_Query('tl_donation_category');
		$objCategories = $objQuery->getStatement()->execute();

		if (!$objCategories->numRows)
		{
			return;
		}

		$arrCategories = array();

		// Generate categories
		while ($objCategories->next())
		{
			$objQuery = new DC_Multilingual_Query('tl_donation_objective');
			$objQuery->addWhere("t1.pid=?");
			$objObjectives = $objQuery->getStatement()->execute($objCategories->id);

			if (!$objObjectives->numRows)
			{
				continue;
			}

			$arrObjectives = array();

			// Generate objectives
			while ($objObjectives->next())
			{
				$arrObjectives[$objObjectives->id] = $objObjectives->row();
				$arrObjectives[$objObjectives->id]['description'] = \String::toHtml5($objObjectives->description);
				$arrObjectives[$objObjectives->id]['nextSteps'] = \String::toHtml5($objObjectives->nextSteps);
			}

			$arrCategories[] = array
			(
				'name' => $objCategories->name,
				'description' => \String::toHtml5($objCategories->description),
				'objectives' => $arrObjectives
			);
		}

		if (empty($arrCategories))
		{
			return;
		}

		$this->Template->categories = $arrCategories;
	}
}
