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
 * Add a palette to tl_content
 */
foreach ($GLOBALS['TL_DCA']['tl_content']['palettes'] as $k => $palette) {
    if ($palette == '__selector__')
        continue;
    $GLOBALS['TL_DCA']['tl_content']['palettes'][$k] = str_replace('protected;','protected,donator_protected;', $palette);
}
//var_dump($GLOBALS['TL_DCA']['tl_content']['palettes']);
/**
 * Add fields to tl_content
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['donator_protected'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['donator_protected'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
    'eval'                    => array('tl_class' => 'w50'),
	'sql'                     => "char(1) NOT NULL default ''"
);
