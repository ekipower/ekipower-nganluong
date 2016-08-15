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

use Eki\Symfony\Helper\Extension\ExtensionHelper;

use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Finder\Finder;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class EkiNganluongSimulatorExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
		$loader = new YamlFileLoader($container, new FileLocator( __DIR__ . '/../Resources/config' ));
        $loader->load( 'services.yml' );

        $configuration = $this->getConfiguration( $configs, $container );
        $config = $this->processConfiguration( $configuration, $configs );

		if ( isset($config['form']) )
		{
			foreach($config['form'] as $key => $form)
			{
				$container->setParameter(
					'nganluong.simulator.processor.controller.' . $key . '.form.type',
					$form['type']
				);
			}
		}
    }

    /**
     * Automatically imports ...
     *
     * @param ContainerBuilder $container
     */
    public function prepend( ContainerBuilder $container )
    {
        ExtensionHelper::configureBundle($this, $container, 'DoctrineCache', 'doctrine_cache');
	} 
}
