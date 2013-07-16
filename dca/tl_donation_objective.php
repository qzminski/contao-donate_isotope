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
 * Table tl_donation_objective
 */
$GLOBALS['TL_DCA']['tl_donation_objective'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Multilingual',
		'ptable'                      => 'tl_donation_category',
		'languages'                   => \IsotopeDonate::getWebsiteLanguages(),
		'langColumn'                  => 'language',
		'pidColumn'                   => 'lid',
		'fallbackLang'                => \IsotopeDonate::getFallbackLanguage(),
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary',
				'pid' => 'index',
				'lid' => 'index'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 4,
			'fields'                  => array('name'),
			'headerFields'            => array('id', 'name'),
			'flag'                    => 1,
			'panelLayout'             => 'filter,search,limit',
			'child_record_callback'   => array('tl_donation_objective', 'generateObjectiveRow')
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation_objective']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation_objective']['copy'],
				'href'                => 'act=paste&amp;mode=copy',
				'icon'                => 'copy.gif'
			),
			'cut' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation_objective']['cut'],
				'href'                => 'act=paste&amp;mode=cut',
				'icon'                => 'cut.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation_objective']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation_objective']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{name_legend},name,amount,description;{complete_legend},completed,nextSteps'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'pid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'language' => array
		(
			'sql'                     => "varchar(2) NOT NULL default ''"
		),
		'lid' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'name' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation_objective']['name'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255, 'translatableFor'=>'*', 'tl_class'=>'w50'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'amount' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation_objective']['amount'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation_objective']['description'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('mandatory'=>true, 'rte'=>'tinyMCE', 'translatableFor'=>'*', 'tl_class'=>'clr'),
			'sql'                     => "text NULL"
		),
		'completed' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation_objective']['completed'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'checkbox',
			'eval'                    => array('tl_class'=>'m12 clr'),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'nextSteps' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation_objective']['nextSteps'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'translatableFor'=>'*', 'tl_class'=>'clr'),
			'sql'                     => "text NULL"
		)
	)
);


class tl_donation_objective extends Backend
{

	/**
	 * Generate an objective row and return it as HTML string
	 * @param array
	 * @return string
	 */
	public function generateObjectiveRow($arrRow)
	{
		return '<div>' . ($arrRow['completed'] ? '<span style="text-decoration:line-through">' : '') . $arrRow['name'] . ($arrRow['completed'] ? '</span>' : '') . '</div>';
	}
}
