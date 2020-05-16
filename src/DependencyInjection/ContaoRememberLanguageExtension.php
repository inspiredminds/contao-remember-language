<?php

declare(strict_types=1);

/*
 * This file is part of the ContaoRememberLanguageBundle.
 *
 * (c) inspiredminds
 *
 * @license LGPL-3.0-or-later
 */

namespace InspiredMinds\ContaoRememberLanguage\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContaoRememberLanguageExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('contao_remember_language.enable_redirect', $config['enable_redirect']);
        $container->setParameter('contao_remember_language.save_language', $config['save_language']);
        $container->setParameter('contao_remember_language.cookie_name', $config['cookie_name']);
    }
}
