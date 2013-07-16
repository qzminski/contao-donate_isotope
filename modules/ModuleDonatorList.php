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
 * Class ModuleDonatorList
 *
 * Front end module "donator list".
 */
class ModuleDonatorList extends \Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_donatorlist';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['donatorlist'][0]) . ' ###';
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
		$objMembers = $this->Database->execute("SELECT * FROM tl_member WHERE donate_list!=''");

		if (!$objMembers->numRows)
		{
			return;
		}

		$arrMembers = array();

		// Generate members
		while ($objMembers->next())
		{
			$arrMembers[$objMembers->id] = $objMembers->row();

			switch ($objMembers->donate_list)
			{
				case 'name':
					$arrMembers[$objMembers->id]['_display'] = $objMembers->firstname . ' ' . $objMembers->lastname;
					break;

				case 'company':
					$arrMembers[$objMembers->id]['_display'] = $objMembers->company;
					break;
			}
		}

		$this->Template->members = $arrMembers;
	}
}
