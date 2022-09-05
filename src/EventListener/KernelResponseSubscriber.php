<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoRememberLanguageBundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoRememberLanguage\EventListener;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelResponseSubscriber implements EventSubscriberInterface
{
    private $scopeMatcher;
    private $availableLocales;
    private $saveLanguage;
    private $cookieName;

    public function __construct(ScopeMatcher $scopeMatcher, array $availableLocales, bool $saveLanguage, string $cookieName)
    {
        $this->scopeMatcher = $scopeMatcher;
        $this->availableLocales = $availableLocales;
        $this->saveLanguage = $saveLanguage;
        $this->cookieName = $cookieName;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$this->saveLanguage) {
            return;
        }

        $request = $event->getRequest();

        if (!$this->scopeMatcher->isFrontendRequest($request)) {
            return;
        }

        $locale = $request->attributes->get('_locale');

        if (empty($locale) || !\in_array($locale, $this->availableLocales, true)) {
            return;
        }

        $response = $event->getResponse();
        $response->headers->setCookie(new Cookie($this->cookieName, $locale, strtotime('+1 year')));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                ['onKernelResponse', -128],
            ],
        ];
    }
}
