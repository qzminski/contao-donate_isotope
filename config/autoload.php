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
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contao\IsotopeDonate'     => 'system/modules/donate_isotope/classes/IsotopeDonate.php',
	'Contao\ModuleDonations'   => 'system/modules/donate_isotope/modules/ModuleDonations.php',
	'Contao\ModuleDonatorList' => 'system/modules/donate_isotope/modules/ModuleDonatorList.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_donations'   => 'system/modules/donate_isotope/templates/modules',
	'mod_donatorlist' => 'system/modules/donate_isotope/templates/modules'
));
