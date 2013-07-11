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


/**
 * Back end modules
 */
array_insert($GLOBALS['BE_MOD']['content'], 1, array
(
	'isotope_donate' => array
	(
		'tables' => array('tl_donation_category', 'tl_donation_objective'),
		'icon'   => 'system/modules/isotope_donate/assets/icon.png'
	)
));
