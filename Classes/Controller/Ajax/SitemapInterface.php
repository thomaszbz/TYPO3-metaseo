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

namespace Metaseo\Metaseo\Controller\Ajax;

use TYPO3\CMS\Core\Http\AjaxRequestHandler;

interface SitemapInterface
{
    /**
     * Executes an AJAX request which displays the data (usually as a list)
     *
     * @param array $params Array of parameters from the AJAX interface, currently unused (as of 6.2.14)
     *                      becomes available starting with 7.4.0 (c048cede,
     *                      https://forge.typo3.org/issues/68186)
     * @param AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     *
     * @return void
     */
    public function indexAction($params = array(), AjaxRequestHandler &$ajaxObj = null);

    /**
     * Blacklists a sitemap entry so that it does not appear in the sitemap presented to search engines
     *
     * @param array $params Array of parameters from the AJAX interface, currently unused (as of 6.2.14)
     *                      becomes available starting with 7.4.0 (c048cede,
     *                      https://forge.typo3.org/issues/68186)
     * @param AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     *
     * @return void
     */
    public function blacklistAction($params = array(), AjaxRequestHandler &$ajaxObj = null);

    /**
     * Undoes the blacklist operation
     *
     * @param array $params Array of parameters from the AJAX interface, currently unused (as of 6.2.14)
     *                      becomes available starting with 7.4.0 (c048cede,
     *                      https://forge.typo3.org/issues/68186)
     * @param AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     *
     * @return void
     */
    public function whitelistAction($params = array(), AjaxRequestHandler &$ajaxObj = null);

    /**
     * Deletes an entry from the sitemap. Entry will reappear as soon as it's indexed again
     *
     * @param array $params Array of parameters from the AJAX interface, currently unused (as of 6.2.14)
     *                      becomes available starting with 7.4.0 (c048cede,
     *                      https://forge.typo3.org/issues/68186)
     * @param AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     *
     * @return void
     */
    public function deleteAction($params = array(), AjaxRequestHandler &$ajaxObj = null);

    /**
     * Performs delete operation for all the entries in the sitemap
     *
     * @param array $params Array of parameters from the AJAX interface, currently unused (as of 6.2.14)
     *                      becomes available starting with 7.4.0 (c048cede,
     *                      https://forge.typo3.org/issues/68186)
     * @param AjaxRequestHandler $ajaxObj Object of type AjaxRequestHandler
     *
     * @return void
     */
    public function deleteAllAction($params = array(), AjaxRequestHandler &$ajaxObj = null);



}
