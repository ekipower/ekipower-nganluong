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

use Eki\Payum\Nganluong\Bridge\Symfony\BasePaymentFactory;

class NganluongPaymentFactory extends BasePaymentFactory
{
    public function getName()
    {
        return $this->radical;
    }
}