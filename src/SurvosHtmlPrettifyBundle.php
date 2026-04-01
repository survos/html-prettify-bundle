<?php

namespace Survos\HtmlPrettifyBundle;

use Gajus\Dindent\Indenter;
use Survos\CoreBundle\Bundle\AssetMapperBundle;
use Survos\HtmlPrettifyBundle\Twig\HtmlPrettifyExtension;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Reference;
use Twig\Environment;

class SurvosHtmlPrettifyBundle extends AssetMapperBundle
{
    public const ASSET_PACKAGE = 'html-prettify';
//        protected string $extensionAlias = 'prettify_html';

    /**
     * @param array<mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder->autowire('gajus_indenter', Indenter::class)
            ->setArgument('$options', $config)
            ->setPublic(true);

        $builder
            ->setDefinition('survos.html_pretty', new Definition(HtmlPrettifyExtension::class))
            ->addTag('twig.extension')
            ->setPublic(false);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        //        indentation_character	Character(s) used for indentation. Defaults to 4 whitespace characters.
        $definition->rootNode()
            ->children()
            ->scalarNode('indentation_character')->defaultValue('    ')->end()
            ->end();
        ;
    }
}
