<?php

declare(strict_types=1);

namespace Survos\HtmlPrettifyBundle;

use Gajus\Dindent\Indenter;
use Survos\HtmlPrettifyBundle\Twig\HtmlPrettifyExtension;
use Survos\Kit\AbstractUxBundle;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

// Symfony\Component\HttpKernel\Bundle\Bundle <-- Flex auto-registration marker (see Survos\Kit\AbstractSurvosBundle)
class SurvosHtmlPrettifyBundle extends AbstractUxBundle
{
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
    }
}
