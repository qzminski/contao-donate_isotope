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
 * Modify the tl_member palette
 */
$GLOBALS['TL_DCA']['tl_member']['palettes']['default'] = str_replace('gender;', 'gender;{donate_legend},donate_list;', $GLOBALS['TL_DCA']['tl_member']['palettes']['default']);


/**
 * Add fields to tl_member
 */
$GLOBALS['TL_DCA']['tl_member']['fields']['donate_list'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['donate_list'],
	'exclude'                 => true,
	'filter'                  => true,
	'inputType'               => 'select',
	'options'                 => array('name', 'company'),
	'reference'               => &$GLOBALS['TL_LANG']['tl_member']['donate_list'],
	'eval'                    => array('includeBlankOption'=>true, 'blankOptionLabel'=>$GLOBALS['TL_LANG']['tl_member']['donate_list']['hide'], 'feEditable'=>true, 'feViewable'=>true, 'feGorup'=>'personal'),
	'sql'                     => "varchar(8) NOT NULL default ''"
);
