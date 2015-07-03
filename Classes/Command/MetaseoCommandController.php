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

namespace Metaseo\Metaseo\Command;

use Metaseo\Metaseo\Utility\ConsoleUtility;
use Metaseo\Metaseo\Utility\DatabaseUtility;
use Metaseo\Metaseo\Utility\RootPageUtility;

/**
 * TYPO3 Command controller
 */
class MetaseoCommandController extends \TYPO3\CMS\Extbase\Mvc\Controller\CommandController
{

    /**
     * Get whole list of sitemap entries
     *
     * @return  string
     */
    public function garbageCollectorCommand()
    {
        // Expire sitemap entries
        \Metaseo\Metaseo\Utility\SitemapUtility::expire();
    }

    /**
     * Clear sitemap for one root page
     *
     * @param   string $rootPageId Site root page id or domain
     *
     * @return  string
     */
    public function clearSitemapCommand($rootPageId)
    {
        $rootPageId = $this->getRootPageIdFromId($rootPageId);

        if ($rootPageId !== null) {
            $query = 'DELETE FROM tx_metaseo_sitemap
                       WHERE page_rootpid = ' . DatabaseUtility::quote($rootPageId, 'tx_metaseo_sitemap') . '
                         AND is_blacklisted = 0';
            DatabaseUtility::exec($query);

            ConsoleUtility::writeLine('Sitemap cleared');
        } else {
            ConsoleUtility::writeErrorLine('No such root page found');
            ConsoleUtility::teminate(1);
        }
    }

    /**
     * Detect root page from id (either PID or sys_domain)
     *
     * @param  $var
     *
     * @return int|mixed|null
     */
    protected function getRootPageIdFromId($var)
    {
        $ret = null;

        if (is_numeric($var)) {
            // Passed variable is numeric
            $pageId = (int) $var;

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

            /** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepo */
            $pageRepo = $objectManager->get('TYPO3\\CMS\\Frontend\\Page\\PageRepository');

            $page = $pageRepo->getPage($pageId);

            if (empty($page['is_siteroot'])) {
                throw new \RuntimeException('MetaSEO: Page with UID "' . $pageId . '" is no valid root page');
            }

            $ret = $page['uid'];
        } else {
            // Passed variable is domain name
            $query = 'SELECT pid
                        FROM sys_domain
                       WHERE domainName = ' . DatabaseUtility::quote($var, 'sys_domain') . '
                         AND hidden = 0';
            $pid = DatabaseUtility::getOne($query);

            if (!empty($pid)) {
                $ret = $pid;
            }
        }

        return $ret;
    }

    /**
     * Get whole list of sitemap entries
     *
     * @param   string $rootPageId Site root page id or domain
     *
     * @return  string
     */
    public function sitemapCommand($rootPageId)
    {
        $rootPageId = $this->getRootPageIdFromId($rootPageId);

        if ($rootPageId !== null) {
            $domain = RootPageUtility::getDomain($rootPageId);

            $query = 'SELECT page_url
                          FROM tx_metaseo_sitemap
                         WHERE page_rootpid = ' . DatabaseUtility::quote($rootPageId, 'tx_metaseo_sitemap') . '
                           AND is_blacklisted = 0';
            $urlList = DatabaseUtility::getCol($query);

            foreach ($urlList as $url) {
                if ($domain) {
                    $url = \Metaseo\Metaseo\Utility\GeneralUtility::fullUrl($url, $domain);
                }

                ConsoleUtility::writeLine($url);
            }
        } else {
            ConsoleUtility::writeErrorLine('No such root page found');
            ConsoleUtility::teminate(1);
        }
    }
}
