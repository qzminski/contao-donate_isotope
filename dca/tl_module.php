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
$GLOBALS['TL_DCA']['tl_module']['palettes']['donations'] = '{title_legend},name,headline,type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
