<?php
/**
 * Created by PhpStorm.
 * User: santino83
 * Date: 28/05/19
 * Time: 1.46
 */

namespace Costaplus\Config;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('myapp');
        $root = $treeBuilder->getRootNode();

        $root
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('app_name')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('app_version')->defaultValue('1.0.0')->cannotBeEmpty()->end()
                ->scalarNode('db_port')->defaultValue(3306)->end()
            // etc
            ->end();

        return $treeBuilder;
    }


}