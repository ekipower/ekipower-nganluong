<?php
/**
 * This file is part of the EkiPayumNganluong package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\Nganluong\Bridge\Symfony;

use Eki\Payum\Nganluong\Api\PaymentTypes;

use Payum\Bundle\PayumBundle\DependencyInjection\Factory\Payment\AbstractPaymentFactory;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

abstract class BasePaymentFactory extends AbstractPaymentFactory
{
	/**
	* 
	* @var string
	* 
	*/
	protected $radical;
	
	/**
	* 
	* @var string
	* 
	*/
	protected $configDir;
	
	/**
	* Constructor
	* 
	* @param string $loadFile
	* @param string $configDir
	* 
	*/
	public function __construct($radical, $configDir = null)
	{
		$this->radical = $radical;
		$this->configDir = $configDir;
	}
	
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $contextName, array $config)
    {
        if (false == class_exists('\Eki\Payum\Nganluong\PaymentFactory')) {
            throw new RuntimeException('Cannot find nganluong payment factory class');
        }

		$configDir = $this->configDir === null ? __DIR__.'/Resources/config' : $this->configDir;
        $loader = new XmlFileLoader($container, new FileLocator( $configDir ));
        $loader->load($this->radical.'.xml');
		
        return parent::create($container, $contextName, $config);
    }

    /**
     * {@inheritDoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        parent::addConfiguration($builder);
        
        $builder->children()
            ->scalarNode('merchant_id')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('merchant_password')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('receiver_email')->isRequired()->cannotBeEmpty()->end()
            ->booleanNode('sandbox')->defaultTrue()->end()
            ->scalarNode('sandbox_url')->end()
            ->scalarNode('payment_method')->end()
            ->scalarNode('payment_type')->defaultValue(PaymentTypes::TYPE_IMMEDIATE)->end()
        ->end();
    }

    /**
     * {@inheritDoc}
     */
    protected function addApis(Definition $paymentDefinition, ContainerBuilder $container, $contextName, array $config)
    {
		$options = array(
            'merchant_id' => $config['merchant_id'],
            'merchant_password' => $config['merchant_password'],
            'receiver_email' => $config['receiver_email'],
            'sandbox' => $config['sandbox']
		);
		if ( isset($config['sandbox_url']) )
		{
			$options['sandbox_url'] = $config['sandbox_url'];
		}
		if ( isset($config['payment_method']) )
		{
			$options['payment_method'] = $config['payment_method'];
		}
		if ( isset($config['payment_type']) )
		{
			$options['payment_type'] = $config['payment_type'];
		}
		
        $apiDefinition = new DefinitionDecorator('eki.payum.'.$this->radical.'.api.prototype');
        $apiDefinition->replaceArgument(0, $options);
        $apiDefinition->setPublic(true);
        $apiId = 'eki.payum.context.'.$contextName.'.api';
        $container->setDefinition($apiId, $apiDefinition);
        $paymentDefinition->addMethodCall('addApi', array(new Reference($apiId)));
    }

    /**
     * {@inheritDoc}
     */
    protected function addActions(Definition $paymentDefinition, ContainerBuilder $container, $contextName, array $config)
    {
        $loggerDefinition = new Definition();
        $loggerDefinition->setClass('Eki\Payum\Nganluong\Action\LoggerAwareAction');
		$loggerDefinition->addMethodCall(
			'setLogger',
			array(new Reference('logger'))
		);
		$loggerActionId = 'payum.'.$contextName.'.nganluong.action.logger_aware';
        $container->setDefinition($loggerActionId, $loggerDefinition);

        $paymentDefinition->addMethodCall(
            'addAction',
            array(new Reference($loggerActionId), $forcePrepend = true)
        );
    }
}