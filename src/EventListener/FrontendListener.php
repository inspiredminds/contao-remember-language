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


namespace InspiredMinds\ContaoRememberLanguage\EventListener;

use Contao\Config;
use Contao\Controller;
use Contao\CoreBundle\Framework\FrameworkAwareInterface;
use Contao\CoreBundle\Framework\FrameworkAwareTrait;
use Contao\Environment;
use Contao\Input;
use Contao\PageModel;
use Contao\System;
use Symfony\Component\DependencyInjection\ContainerInterface;

class FrontendListener implements FrameworkAwareInterface
{
    use FrameworkAwareTrait;


    /**
     * Container
     * @var ContainerInterface
     */
    protected $container;


    /**
     * Constructor with container.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


     /**
     * Hook to redirect to saved language and otherwise save language in a Cookie.
     * @return  PageModel|null
     */
    public function onGetRootPageFromUrl()
    {
        $configAdapter = $this->framework->getAdapter(Config::class);

        // Check if language should be added to the URL at all
        if (!$configAdapter->get('addLanguageToUrl'))
        {
            return null;
        }

        $envAdapter = $this->framework->getAdapter(Environment::class);

        $host = $envAdapter->get('host');

        // Check if language is set
        if (empty($_GET['language']))
        {
            $pageAdapter = $this->framework->getAdapter(PageModel::class);
            $inputAdapter = $this->framework->getAdapter(Input::class);
            $controllerAdapter = $this->framework->getAdapter(Controller::class);

            // Check if cookie is set
            if (null !== ($strCookie = $inputAdapter->cookie('forceLanguage')) && $configAdapter->get('enableLanguageCookie'))
            {
                $accept_language = $strCookie;

                // Always load the language fall back root if "doNotRedirectEmpty" is enabled
                if ($configAdapter->get('addLanguageToUrl') && $configAdapter->get('doNotRedirectEmpty'))
                {
                    $accept_language = '-';
                }

                // Find the matching root pages (thanks to Andreas Schempp)
                $objRootPage = $pageAdapter->findFirstPublishedRootByHostAndLanguage($host, $accept_language);

                // No matching root page found
                if ($objRootPage === null)
                {
                    return null;
                }

                // Redirect to the website root or language root (e.g. en/)
                if ($envAdapter->get('relativeRequest') == '')
                {
                    if ($configAdapter->get('addLanguageToUrl') && !$configAdapter->get('doNotRedirectEmpty'))
                    {
                        $arrParams = array('_locale' => $objRootPage->language);

                        $strUrl = $this->container->get('router')->generate('contao_index', $arrParams);
                        $strUrl = substr($strUrl, \strlen($envAdapter->get('path')) + 1);

                        $controllerAdapter->redirect($strUrl, 301);
                    }

                    // Redirect if the page alias is not "index" or "/" (see #8498, #8560 and #1210)
                    elseif (($objPage = $pageAdapter->findFirstPublishedByPid($objRootPage->id)) !== null && !\in_array($objPage->alias, array('index', '/')))
                    {
                        $controllerAdapter->redirect($objPage->getFrontendUrl(), 302);
                    }
                }
            }
        }
        elseif ($configAdapter->get('saveLanguageCookie'))
        {
            // Save language as cookie
            $systemAdapter = $this->framework->getAdapter(System::class);
            $systemAdapter->setCookie('forceLanguage', $_GET['language'], time() + 365 * 24 * 60 * 60);
        }

        return null;
    }
}
