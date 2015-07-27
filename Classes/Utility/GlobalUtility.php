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

namespace Metaseo\Metaseo\Utility;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Lang\LanguageService;

/**
 * retrieve global objects
 */
class GlobalUtility
{
    const BE_USER = 'BE_USER';
    const TSFE    = 'TSFE';
    const LANG    = 'LANG';

    /**
     * Get the TYPO3 CMS BackendUserAuthentication
     *
     * @return BackendUserAuthentication
     *
     * @throws \RuntimeException
     */
    public static function getBackendUserAuthentication()
    {
        if (!isset($GLOBALS[self::BE_USER]) || !($GLOBALS[self::BE_USER] instanceof BackendUserAuthentication)) {
            throw new \RuntimeException;
        }
        return $GLOBALS[self::BE_USER];
    }

    /**
     * Get the TYPO3 CMS TypoScriptFrontendController
     *
     * @return TypoScriptFrontendController
     *
     * @throws \RuntimeException
     */
    public static function getTypoScriptFrontendController()
    {
        if (!isset($GLOBALS[self::TSFE]) || !($GLOBALS[self::TSFE] instanceof TypoScriptFrontendController)) {
            throw new \RuntimeException;
        }
        return $GLOBALS[self::TSFE];
    }

    /**
     * Set the TYPO3 CMS TypoScriptFrontendController
     *
     * @param TypoScriptFrontendController $tsfe
     */
    public static function setTypoScriptFrontendController(TypoScriptFrontendController $tsfe)
    {
        $GLOBALS[self::TSFE] = $tsfe;
    }

    /**
     * Get the TYPO3 CMS LanguageService
     *
     * @return LanguageService
     *
     * @throws \RuntimeException
     */
    protected function getLanguageService()
    {
        if (!isset($GLOBALS[self::LANG]) || !($GLOBALS[self::LANG] instanceof LanguageService)) {
            throw new \RuntimeException;
        }
        return $GLOBALS[self::LANG];
    }
}
