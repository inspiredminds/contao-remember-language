<?php

/**
 * This file is part of the ContaoRememberLanguage Bundle.
 *
 * (c) inspiredminds <https://github.com/inspiredminds>
 *
 * @package   ContaoRememberLanguage
 * @author    Fritz Michael Gschwantner <https://github.com/fritzmg>
 * @license   LGPL-3.0+
 * @copyright inspiredminds 2018
 */


/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['getRootPageFromUrl'][] = ['contao_remember_language.listener.frontend', 'onGetRootPageFromUrl'];


/**
 * Default settings
 */
$GLOBALS['TL_CONFIG']['enableLanguageCookie'] = false;
$GLOBALS['TL_CONFIG']['saveLanguageCookie'] = false;
