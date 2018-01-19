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


$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'].= ';{languagecookie_legend:hide},enableLanguageCookie,saveLanguageCookie';

$GLOBALS['TL_DCA']['tl_settings']['fields']['enableLanguageCookie'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['enableLanguageCookie'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => ['tl_class' => 'w50']
);

$GLOBALS['TL_DCA']['tl_settings']['fields']['saveLanguageCookie'] = array
(
	'label' => &$GLOBALS['TL_LANG']['tl_settings']['saveLanguageCookie'],
	'exclude' => true,
	'inputType' => 'checkbox',
	'eval' => ['tl_class' => 'w50']
);
