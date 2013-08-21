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
		$arrCategoryIds = deserialize($this->donation_categories, true);
		$arrCategoryIds = array_map('intval', $arrCategoryIds);
		$arrCategoryIds = array_filter($arrCategoryIds);
		if (!count($arrCategoryIds)) {
			$arrCategoryIds[] = 0;
		}
		$arrCategoryIds = implode(',', $arrCategoryIds);

		$objMembers = $this->Database->execute(
			"SELECT DISTINCT tl_member.*
			 FROM tl_member
			 INNER JOIN tl_donation
			 ON tl_member.id=tl_donation.member
			 INNER JOIN tl_donation_objective
			 ON tl_donation.objective=tl_donation_objective.id
			 INNER JOIN tl_donation_category
			 ON tl_donation_objective.pid=tl_donation_category.id
			 WHERE tl_member.donate_list!='' AND tl_donation_category.id IN ($arrCategoryIds)
			 ORDER BY tl_donation.datePaid");

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
