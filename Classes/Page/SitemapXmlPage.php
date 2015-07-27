<?php

/*
 *  Copyright notice
 *
 *  (c) 2015 Markus Blaschke <typo3@markus-blaschke.de> (metaseo)
 *  (c) 2013 Markus Blaschke (TEQneers GmbH & Co. KG) <blaschke@teqneers.de> (tq_seo)
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 */

namespace Metaseo\Metaseo\Page;

use Metaseo\Metaseo\Utility\GeneralUtility;
use Metaseo\Metaseo\Utility\GlobalUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility as Typo3GeneralUtility;

/**
 * Sitemap xml page
 */
class SitemapXmlPage extends AbstractPage
{

    // ########################################################################
    // Attributes
    // ########################################################################


    // ########################################################################
    // Methods
    // ########################################################################

    /**
     * Build sitemap xml
     *
     * @return  string
     */
    public function main()
    {
        // INIT
        $this->tsSetup = GlobalUtility::getTypoScriptFrontendController()
                             ->tmpl->setup['plugin.']['metaseo.']['sitemap.'];

        // check if sitemap is enabled in root
        if (!GeneralUtility::getRootSettingValue('is_sitemap', true)) {
            $this->showError('Sitemap is not available, please check your configuration [control-center]');
        }

        $ret = $this->build();

        return $ret;
    }

    /**
     * Build sitemap index or specific page
     *
     * @return mixed
     */
    protected function build()
    {
        $page = Typo3GeneralUtility::_GP('page');

        /** @var \Metaseo\Metaseo\Sitemap\Generator\XmlGenerator $generator */
        $generator = $this->objectManager->get('Metaseo\\Metaseo\\Sitemap\\Generator\\XmlGenerator');

        if (empty($page) || $page === 'index') {
            $ret = $generator->sitemapIndex();
        } else {
            $ret = $generator->sitemap($page);
        }

        return $ret;
    }
}
