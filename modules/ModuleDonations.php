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

namespace Contao;


/**
 * Class ModuleDonations
 *
 * Front end module "donations".
 */
class ModuleDonations extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_donations';


    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['donations'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        $this->import('FrontendUser', 'User');

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $objQuery = new DC_Multilingual_Query('tl_donation_category');
        $objCategories = $objQuery->getStatement()->execute();

        if (!$objCategories->numRows) {
            return;
        }

        $strRedirect = '';

        // Generate a redirect page
        if ($this->jumpTo > 0) {
            $objJump = \PageModel::findByPk($this->jumpTo);

            if ($objJump !== null) {
                $strRedirect = $this->generateFrontendUrl($objJump->row());
            }
        }

        $arrCategories = array();

        // Generate categories
        while ($objCategories->next()) {
            $objQuery = new DC_Multilingual_Query('tl_donation_objective');
            $objQuery->addField("(SELECT SUM(amount) FROM tl_donation WHERE tl_donation.objective=t1.id) AS donations");
            $objQuery->addWhere("t1.pid=?");
            $objObjectives = $objQuery->getStatement()->execute($objCategories->id);

            if (!$objObjectives->numRows) {
                continue;
            }

            $arrObjectives = array();

            // Generate objectives
            while ($objObjectives->next()) {
                $arrObjectives[$objObjectives->id] = $objObjectives->row();
                $arrObjectives[$objObjectives->id]['description'] = \String::toHtml5($objObjectives->description);
                $arrObjectives[$objObjectives->id]['nextSteps'] = \String::toHtml5($objObjectives->nextSteps);
                $arrObjectives[$objObjectives->id]['paypal_donate'] = false;

                // Enable paypal donations
                if (!$objObjectives->completed && $this->paypal_email != '') {
                    $arrObjectives[$objObjectives->id]['paypal_donate'] = true;
                    $arrObjectives[$objObjectives->id]['paypal_email'] = $this->paypal_email;
                    $arrObjectives[$objObjectives->id]['paypal_item'] = $this->User->id . '_' . $objObjectives->id;

                    if ($strRedirect != '') {
                        $arrObjectives[$objObjectives->id]['paypal_return'] = ampersand(\Environment::get('base') . $strRedirect . '?objective=' . $objObjectives->id);
                    }
                }

                $fltDonations = floatval($objObjectives->donations);
                $fltAmount = floatval($objObjectives->amount);

                // Calculate the percentage
                if ($objObjectives->completed || $fltDonations >= $fltAmount) {
                    $intPercentage = 100;
                    $fltDonations = $fltAmount;
                } else {
                    $intPercentage = round(($fltDonations / $fltAmount) * 100);
                }

                $arrObjectives[$objObjectives->id]['percentage']    = $intPercentage;
                $arrObjectives[$objObjectives->id]['donations']     = $fltDonations;
            }

            $arrCategories[] = array
            (
                'name' => $objCategories->name,
                'description' => \String::toHtml5($objCategories->description),
                'objectives' => $arrObjectives
            );
        }

        if (empty($arrCategories)) {
            return;
        }

        $this->Template->categories = $arrCategories;
    }
}
