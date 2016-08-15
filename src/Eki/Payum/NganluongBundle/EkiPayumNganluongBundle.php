<?php
/**
 * This file is part of the EkiPayumNganluongBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\NganluongBundle;

//use Eki\Payum\NganluongBundle\Payum\Nganluong\NganluongPaymentFactory;
use Eki\Payum\NganluongBundle\Payum\Nganluong\NganluongVisaPaymentFactory;
use Eki\Payum\NganluongBundle\Payum\Nganluong\NganluongAtmPaymentFactory;
use Eki\Payum\NganluongBundle\Payum\Nganluong\NganluongNlPaymentFactory;

use Payum\Bundle\PayumBundle\DependencyInjection\PayumExtension;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EkiPayumNganluongBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /** @var $extension PayumExtension */
        $extension = $container->getExtension('payum');

//        $extension->addPaymentFactory(new NganluongPaymentFactory);
        $extension->addPaymentFactory(new NganluongVisaPaymentFactory);
        $extension->addPaymentFactory(new NganluongAtmPaymentFactory);
        $extension->addPaymentFactory(new NganluongNlPaymentFactory);
    }
}
