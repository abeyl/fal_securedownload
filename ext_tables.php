<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Filetree',
    'LLL:EXT:fal_securedownload/Resources/Private/Language/locallang_be.xlf:plugin.title'
);

$pluginSignature = str_replace('_', '', $_EXTKEY) . '_filetree';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    $pluginSignature,
    'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/FileTree.xml'
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'FileTree');

if (TYPO3_MODE === 'BE') {
    // Add click menu item:
    $GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
        'name' => 'BeechIt\\FalSecuredownload\\Hooks\\ClickMenuOptions'
    );
}

if (class_exists('TYPO3\\CMS\\Core\\Imaging\\IconRegistry')) {
    // Initiate
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'action-folder',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        array(
            'source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/folder.svg',
        )
    );
    $iconRegistry->registerIcon(
        'overlay-inherited-permissions',
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        array(
            'source' => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/overlay-inherited-permissions.svg',
        )
    );

// Fallback for < 7.6
} else {
    \TYPO3\CMS\Backend\Sprite\SpriteManager::addSingleIcons(array(
        'folder' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/folder.png',
        'overlay-permissions' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/permissions-set-in-root-line.png'
    ), 'fal_securedownload');
}
