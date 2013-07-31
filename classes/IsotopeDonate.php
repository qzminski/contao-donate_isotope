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


class IsotopeDonate
{

	/**
	 * Get available website languages
	 * @return array
	 */
	public static function getWebsiteLanguages()
	{
		return \Database::getInstance()->execute("SELECT DISTINCT(language) FROM tl_page WHERE type='root'")
									   ->fetchEach('language');
	}

	/**
	 * Get the website fallback language
	 * @return string
	 */
	public static function getFallbackLanguage()
	{
		return \Database::getInstance()->prepare("SELECT language FROM tl_page WHERE type='root' AND fallback=1")
									   ->limit(1)
									   ->execute()
									   ->language;
	}

    /*
     * Protect a content element to donators only
     * @param   \Database_Result
     * @param   string
     * @param   \ContentElement
     * @return  string
     */
    public function protectElement($objRow, $strBuffer, $objElement)
    {
        if (!$objRow->donator_protected) {
            return $strBuffer;
        }

        $objUser = \FrontendUser::getInstance();
        if (!$objUser->id) {
            return '';
        }

        $objDonation = \Database::getInstance()->prepare("SELECT tl_member.id FROM tl_member INNER JOIN tl_donation ON tl_member.id=tl_donation.member WHERE tl_member.id=?")->execute($objUser->id);
        if (!$objDonation->numRows) {
            return '';
        }

        return $strBuffer;
    }
}
