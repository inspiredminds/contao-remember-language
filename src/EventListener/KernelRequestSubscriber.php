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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    private $availableLocales;
    private $enableRedirect;
    private $cookieName;

    public function __construct(array $availableLocales, bool $enableRedirect, string $cookieName)
    {
        $this->availableLocales = $availableLocales;
        $this->enableRedirect = $enableRedirect;
        $this->cookieName = $cookieName;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->enableRedirect) {
            return;
        }

        $request = $event->getRequest();

        if ('/' !== $request->getPathInfo() || !$request->cookies->has($this->cookieName)) {
            return;
        }

        $savedLanguage = $request->cookies->get($this->cookieName);

        if (empty($savedLanguage) || !\in_array($savedLanguage, $this->availableLocales, true)) {
            return;
        }

        $request->headers->set('Accept-Language', $savedLanguage);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 128],
            ],
        ];
    }
}
