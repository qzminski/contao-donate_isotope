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
}
