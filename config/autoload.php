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
	'Contao\IsotopeDonate' => 'system/modules/isotope_donate/classes/IsotopeDonate.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	//'mod_faqlist' => 'system/modules/isotope_donate/templates/modules'
));
