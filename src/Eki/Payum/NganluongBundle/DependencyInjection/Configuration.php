<?php
/**
 * This file is part of the EkiPayumNganluongBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\NganluongBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('eki_payum_nganluong');

        $rootNode
			->children()
				->arrayNode('api')
                    ->addDefaultsIfNotSet()
					->children()
						->scalarNode('version')->defaultValue('3.1')->end()
						->scalarNode('payment_type')->defaultValue('1')->end()
					->end()
				->end()
				->arrayNode('templates')
                    ->addDefaultsIfNotSet()
					->children()
						->scalarNode('determine_bank')->defaultValue('EkiPayumNganluongBundle:Action:determineBank.html.twig')->end()
					->end()				
				->end()
				->arrayNode('forms')
                    ->addDefaultsIfNotSet()
					->children()
						->scalarNode('determine_bank')->defaultValue('eki_nganluong_bank_list')->end()
					->end()				
				->end()
			->end()
        ;

        return $treeBuilder;
    }
}
