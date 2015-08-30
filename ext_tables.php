<?php
defined('TYPO3_MODE') or exit;

// ############################################################################
// TABLES
// ############################################################################

// ################
// Settings Root
// ################

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_metaseo_setting_root',
    'EXT:metaseo/Resources/Private/Language/locallang.tca.xml'
);


// ############################################################################
// Backend
// ############################################################################

if (TYPO3_MODE == 'BE') {

    // ####################################################
    // Module category "WEB"
    // ####################################################

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Metaseo.' . $_EXTKEY,
        'web',
        'pageseo',
        '', # Position
        array('BackendPageSeo' => 'main,metadata,geo,searchengines,url,pagetitle,pagetitlesim'), # Controller array
        array(
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ModuleSeo.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleSeo/locallang.xlf',
        )
    );

    // ####################################################
    // Module category "SEO"
    // ####################################################

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        $_EXTKEY,
        'metaseo',
        '',
        '',
        array(),
        array(
            'access' => 'user,group',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleMain/locallang.xlf',
        )
    );


    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Metaseo.' . $_EXTKEY,
        'metaseo',
        'controlcenter',
        '',
        array('BackendControlCenter' => 'main'),
        array(
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ModuleControlCenter.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleControlCenter/locallang.xlf',
        )
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
        'Metaseo.' . $_EXTKEY,
        'metaseo',
        'sitemap',
        'after:controlcenter',
        array('BackendSitemap' => 'main,sitemap'),
        array(
            'access' => 'user,group',
            'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Backend/Icons/ModuleSitemap.png',
            'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/ModuleSitemap/locallang.xlf',
        )
    );

    // AJAX
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'tx_metaseo_backend_ajax::sitemap',
        'Metaseo\\Metaseo\\Controller\\Ajax\\SitemapController->main'
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::registerAjaxHandler(
        'tx_metaseo_backend_ajax::page',
        'Metaseo\\Metaseo\\Controller\\Ajax\\AbstractPageSeoController->main'
    );
}

// ############################################################################
// CONFIGURATION
// ############################################################################

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'MetaSEO');
