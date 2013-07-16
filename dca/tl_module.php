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
 * Add a palette to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['donations'] = '{title_legend},name,headline,type;{config_legend},paypal_email;{redirect_legend:hide},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';


/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['paypal_email'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['paypal_email'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('maxlength'=>255, 'rgxp'=>'email'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);
