<?php
/**
 * This file is part of the EkiNganluongSimulatorBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\SimulatorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle.
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 *
 * @author Nguyen Tien Hy <ngtienhy@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('eki_nganluong_simulator');

        $this->addFormSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds `form` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addFormSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                    ->children()
						->arrayNode('credit_card')
		                    ->addDefaultsIfNotSet()
							->children()
								->scalarNode('type')->defaultValue('payum_credit_card')->end()
							->end()
						->end()
						->arrayNode('atm_card')
		                    ->addDefaultsIfNotSet()
							->children()
								->scalarNode('type')->defaultValue('eki_atm_card')->end()
							->end()
						->end()
						->arrayNode('nl_account')
		                    ->addDefaultsIfNotSet()
							->children()
								->scalarNode('type')->defaultValue('eki_nl_account')->end()
							->end()
						->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
