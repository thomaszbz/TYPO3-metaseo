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

namespace Metaseo\Metaseo\Scheduler\Task;

/**
 * Scheduler Task Sitemap TXT
 */
class SitemapTxtTask extends \Metaseo\Metaseo\Scheduler\Task\AbstractSitemapTask
{

    // ########################################################################
    // Attributes
    // ########################################################################

    /**
     * Sitemap base directory
     *
     * @var string
     */
    protected $sitemapDir = 'uploads/tx_metaseo/sitemap_txt';

    // ########################################################################
    // Methods
    // ########################################################################

    /**
     * Build sitemap
     *
     * @param   integer $rootPageId Root page id
     * @param   integer $languageId Language id
     *
     * @return  boolean
     */
    protected function buildSitemap($rootPageId, $languageId)
    {

        if ($languageId !== null) {
            // Language lock enabled
            $sitemapFileName = 'sitemap-r%s-l%s.txt.gz';
        } else {
            $sitemapFileName = 'sitemap-r%s.txt.gz';
        }

        $generator = $this->objectManager->get('Metaseo\\Metaseo\\Sitemap\\Generator\\TxtGenerator');
        $content = $generator->sitemap();

        $fileName = sprintf($sitemapFileName, $rootPageId, $languageId);
        $this->writeToFile(PATH_site . '/' . $this->sitemapDir . '/' . $fileName, $content);

        return true;
    }
}
