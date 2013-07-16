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
 * Table tl_donation
 */
$GLOBALS['TL_DCA']['tl_donation'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('datePaid'),
			'flag'                    => 2,
			'panelLayout'             => 'filter;search,limit'
		),
		'label' => array
		(
			'fields'                  => array('datePaid', 'member', 'objective', 'amount'),
			'showColumns'             => true,
			'label_callback'          => array('tl_donation', 'adjustColumns')
		),
		'global_operations' => array
		(
			'categories' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation']['categories'],
				'href'                => 'table=tl_donation_category',
				'icon'                => 'system/modules/donate_isotope/assets/categories.png',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="c"'
			),
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
				'label'               => &$GLOBALS['TL_LANG']['tl_donation']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_donation']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{member_legend},member,datePaid,objective,amount,notes'
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
		'member' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation']['member'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_donation', 'getAllMembers'),
			'eval'                    => array('mandatory'=>true, 'includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'datePaid' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation']['datePaid'],
			'default'                 => time(),
			'exclude'                 => true,
			'filter'                  => true,
			'search'                  => true,
			'flag'                    => 8,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'datepicker'=>true, 'rgxp'=>'datim', 'tl_class'=>'w50 wizard'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'objective' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation']['objective'],
			'exclude'                 => true,
			'filter'                  => true,
			'inputType'               => 'select',
			'options_callback'        => array('tl_donation', 'getAllObjectives'),
			'eval'                    => array('mandatory'=>true, 'includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'amount' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation']['amount'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'rgxp'=>'digit', 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'notes' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_donation']['notes'],
			'exclude'                 => true,
			'search'                  => true,
			'inputType'               => 'textarea',
			'eval'                    => array('rte'=>'tinyMCE', 'tl_class'=>'clr'),
			'sql'                     => "text NULL"
		)
	)
);


class tl_donation extends Backend
{

	/**
	 * Adjust columns and return them as array
	 * @param array
	 * @param string
	 * @param \DataContainer
	 * @param array
	 * @return array
	 */
	public function adjustColumns($row, $label, DataContainer $dc, $args)
	{
		static $arrMembers, $arrObjectives;

		// Get members
		if (!is_array($arrMembers))
		{
			$arrMembers = $this->getAllMembers();
		}

		// Get objectives
		if (!is_array($arrObjectives))
		{
			$arrObjectives = $this->getAllObjectives();
		}

		$args[1] = $arrMembers[$row['member']];
		$args[2] = $arrObjectives[$row['objective']];
		return $args;
	}


	/**
	 * Get all members and return them as array
	 * @return array
	 */
	public function getAllMembers()
	{
		$arrMembers = array();
		$objMembers = $this->Database->execute("SELECT id, email FROM tl_member ORDER BY id");

		while ($objMembers->next())
		{
			$arrMembers[$objMembers->id] = $objMembers->id . ' - ' . $objMembers->email;
		}

		return $arrMembers;
	}


	/**
	 * Get all objectives and return them as array
	 * @param \DataContainer
	 * @return array
	 */
	public function getAllObjectives($dc=null)
	{
		$arrObjectives = array();
		$objObjectives = $this->Database->execute("SELECT * FROM tl_donation_objective WHERE lid=0 ORDER BY completed, id");

		while ($objObjectives->next())
		{
			if (!$dc->activeRecord)
			{
				$arrObjectives[$objObjectives->id] = $objObjectives->id . ' - ' . $objObjectives->name;
				continue;
			}

			$arrObjectives[($objObjectives->completed ? $GLOBALS['TL_LANG']['tl_donation']['completed'] : $GLOBALS['TL_LANG']['tl_donation']['active'])][$objObjectives->id] = $objObjectives->id . ' - ' . $objObjectives->name;
		}

		return $arrObjectives;
	}
}
