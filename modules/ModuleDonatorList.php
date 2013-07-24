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
		$objMembers = $this->Database->execute("SELECT * FROM tl_member INNER JOIN tl_donation ON tl_member.id=tl_donation.member WHERE tl_member.donate_list!=''");

		if (!$objMembers->numRows)
		{
			return;
		}

		$count = 0;
		$arrMembers = array();

		// Generate members
		while ($objMembers->next())
		{
			$arrMembers[$objMembers->id] = $objMembers->row();
			$arrMembers[$objMembers->id]['class'] = trim(((++$count == 1) ? ' first' : '') . (($count == $objMembers->numRows) ? ' last' : '') . ((($count % 2) == 0) ? ' odd' : ' even'));
			$arrMembers[$objMembers->id]['website'] = ampersand($objMembers->website);

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
		$this->Template->showDetails = $GLOBALS['TL_LANG']['MSC']['donate_details'];
	}
}
