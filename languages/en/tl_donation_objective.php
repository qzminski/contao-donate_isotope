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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_donation_objective']['name']        = array('Name', 'Please enter the objective name.');
$GLOBALS['TL_LANG']['tl_donation_objective']['alias']       = array('Alias', 'Used for the anchor.');
$GLOBALS['TL_LANG']['tl_donation_objective']['amount']      = array('Goal amount', 'Please enter the objective goal amount.');
$GLOBALS['TL_LANG']['tl_donation_objective']['description'] = array('Description', 'Please enter the objective description.');
$GLOBALS['TL_LANG']['tl_donation_objective']['completed']   = array('Objective completed', 'Mark the objective as completed.');
$GLOBALS['TL_LANG']['tl_donation_objective']['nextSteps']   = array('Next steps', 'Please enter the objective next stesps.');
$GLOBALS['TL_LANG']['tl_donation_objective']['published']   = array('Publish objective', 'Make the object visible on the website.');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_donation_objective']['name_legend']     = 'Name and description';
$GLOBALS['TL_LANG']['tl_donation_objective']['complete_legend'] = 'Completed settings';
$GLOBALS['TL_LANG']['tl_donation_objective']['publish_legend']  = 'Publish settings';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_donation_objective']['new']        = array('New objective', 'Create a new news objective');
$GLOBALS['TL_LANG']['tl_donation_objective']['show']       = array('Objective details', 'Show the details of news objective ID %s');
$GLOBALS['TL_LANG']['tl_donation_objective']['edit']       = array('Edit objective', 'Edit news objective ID %s');
$GLOBALS['TL_LANG']['tl_donation_objective']['copy']       = array('Duplicate objective', 'Duplicate news objective ID %s');
$GLOBALS['TL_LANG']['tl_donation_objective']['cut']        = array('Move objective', 'Move news objective ID %s');
$GLOBALS['TL_LANG']['tl_donation_objective']['delete']     = array('Delete objective', 'Delete news objective ID %s');
$GLOBALS['TL_LANG']['tl_donation_objective']['editheader'] = array('Edit category settings', 'Edit the category settings');
$GLOBALS['TL_LANG']['tl_donation_objective']['toggle']     = array('Publish/unpublish objective', 'Publish/unpublish objective ID %s');
