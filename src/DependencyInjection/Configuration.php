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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('contao_remember_language');
        $treeBuilder
            ->getRootNode()
            ->children()
                ->booleanNode('enable_redirect')
                    ->info('Enables the automatic redirect to the saved language.')
                    ->defaultValue(true)
                ->end()
                ->booleanNode('save_language')
                    ->info('Saves the current language as a cookie.')
                    ->defaultValue(true)
                ->end()
                ->scalarNode('cookie_name')
                    ->info('Name of the cookie where the language is saved.')
                    ->cannotBeEmpty()
                    ->defaultValue('contao_remember_language')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
