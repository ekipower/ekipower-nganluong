<?php
/**
 * This file is part of the EkiSyliusPayumBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\Nganluong\Bridge\Sylius\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class ConfigLoader
{
	/**
	* 
	* @var string
	* 
	*/
	private $radical;

	/**
	* 
	* @var 
	* 
	*/
	private $configDir;
	
	public function __construct($radical, $configDir = null)
	{
		$this->radical = $radical;
		$this->configDir = $configDir;
	}
	
    public function load(array $configs, ContainerBuilder $container)
    {
		$configDir = $this->configDir === null ? __DIR__ . '/../Resources/config' : $this->configDir;
		$loader = new XmlFileLoader($container, new FileLocator( $configDir ));
        $loader->load( $this->radical . '.xml' );
    }
}
