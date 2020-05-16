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

use Contao\CoreBundle\Exception\RedirectResponseException;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class KernelRequestSubscriber implements EventSubscriberInterface
{
    private $scopeMatcher;
    private $router;
    private $availableLocales;
    private $prependLocale;
    private $enableRedirect;
    private $cookieName;

    public function __construct(ScopeMatcher $scopeMatcher, RouterInterface $router, array $availableLocales, bool $prependLocale, bool $enableRedirect, string $cookieName)
    {
        $this->scopeMatcher = $scopeMatcher;
        $this->router = $router;
        $this->availableLocales = $availableLocales;
        $this->prependLocale = $prependLocale;
        $this->enableRedirect = $enableRedirect;
        $this->cookieName = $cookieName;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$this->enableRedirect || !$this->prependLocale) {
            return;
        }

        $request = $event->getRequest();

        if (!$this->scopeMatcher->isFrontendRequest($request) || '/' !== $request->getPathInfo() || !$request->cookies->has($this->cookieName)) {
            return;
        }

        $savedLanguage = $request->cookies->get($this->cookieName);

        if (empty($savedLanguage) || !\in_array($savedLanguage, $this->availableLocales, true)) {
            return;
        }

        $languageUrl = $this->router->generate('contao_index', ['_locale' => $savedLanguage]);

        if ($languageUrl === $request->getPathInfo()) {
            return;
        }

        throw new RedirectResponseException($languageUrl, Response::HTTP_SEE_OTHER);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 18],
            ],
        ];
    }
}
