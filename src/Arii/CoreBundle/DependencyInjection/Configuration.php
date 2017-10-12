<?php

namespace Arii\CoreBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $user_agent = getenv("HTTP_USER_AGENT");

        if(strpos($user_agent, "Win") !== FALSE) {
            $root = $_SERVER['DOCUMENT_ROOT'].'\..\..';
            $java_home = '%JAVA_HOME%';
            $charset = 'ISO';
            $java = "$root\jre";
        }
        else {
            $root = $_SERVER['DOCUMENT_ROOT'].'/../..';
            $java_home = '${JAVA_HOME}';
            $charset = 'UTF-8';
            $java = "$root/jre";
        }
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('arii_core');
        $rootNode
            ->children()
              ->scalarNode('charset')
                ->defaultValue($charset)
              ->end()
            ->end()
            ->children()
              ->scalarNode('workspace')
                ->defaultValue('../workspace')
              ->end()
            ->end()
            ->children()
              ->scalarNode('modules')
                ->defaultValue('ATS(ROLE_USER),JID(ROLE_USER),DS(ROLE_USER),JOC(ROLE_USER),GVZ(ROLE_USER),Report(ROLE_USER),MFT(ROLE_OPERATOR),Admin(ROLE_ADMIN)')
              ->end()
            ->end()
            ->children()
              ->scalarNode('perl')
                ->defaultValue('perl')
              ->end()
            ->end()
            ->children()
              ->scalarNode('java')
                ->defaultValue($java)
              ->end()
            ->end()
            ->children()
              ->scalarNode('ditaa')
                ->defaultValue('ditaa/ditaa0_9.jar')
              ->end()
            ->end()
            ->children()
              ->scalarNode('plantuml')
                ->defaultValue('plantuml/plantuml.jar')
              ->end()
            ->end()
            ->children()
              ->scalarNode('graphviz_dot')
                ->defaultValue('graphviz/bin/dot.exe')
              ->end()
            ->end()
            ->children()
              ->scalarNode('osjs_config')
                ->defaultValue($root.'/jobscheduler/arii/config')
              ->end()
            ->end()                
            ->children()
              ->arrayNode('color')
                ->children()
                    ->scalarNode('SUCCESS')->defaultValue('#ccebc5')->end()
                    ->scalarNode('STARTING')->defaultValue('#00ff33')->end()
                    ->scalarNode('RUNNING')->defaultValue('#ffffcc')->end()
                    ->scalarNode('FAILURE')->defaultValue('#fbb4ae')->end()
                    ->scalarNode('STOPPED')->defaultValue('#FF0000')->end()
                    ->scalarNode('TERMINATED')->defaultValue('#ff66cc')->end()
                    ->scalarNode('QUEUED')->defaultValue('#AAA')->end()
                    ->scalarNode('STOPPING')->defaultValue('#ffffcc')->end()
                    ->scalarNode('INACTIVE')->defaultValue('lightgrey')->end()
                    ->scalarNode('ACTIVATED')->defaultValue('#006633/lightgrey')->end()
                    ->scalarNode('WAIT_REPLY')->defaultValue('grey')->end()       
                    ->scalarNode('CHK_RUN_WINDOW')->defaultValue('white')->end()
                    ->scalarNode('STARTJOB')->defaultValue('#00ff33')->end()
                    ->scalarNode('JOB_ON_ICE')->defaultValue('#ccffff')->end()
                    ->scalarNode('ON_ICE')->defaultValue('#ccffff')->end()
                    ->scalarNode('JOB_ON_HOLD')->defaultValue('#3333ff')->end()
                    ->scalarNode('ON_HOLD')->defaultValue('#ccffff')->end()
                    ->scalarNode('OPEN')->defaultValue('#fbb4ae')->end()
                    ->scalarNode('ACKNOWLEDGED')->defaultValue('#ffffcc')->end()
                    ->scalarNode('CLOSED')->defaultValue('#ccebc5')->end()
                    ->scalarNode('QUEUED')->defaultValue('#AAA')->end()
                    ->scalarNode('UNKNOW')->defaultValue('#BBB')->end()
                ->end()
              ->end()
            ->end()
                
                ;
        return $treeBuilder;
    }
}
