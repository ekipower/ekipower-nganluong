<?php
/**
 * This file is part of the EkiPayumNganluongBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\NganluongBundle\Payum\Nganluong;

use Eki\Payum\Nganluong\Bridge\Symfony\NganluongPaymentFactory as BasePaymentFactory;

class NganluongVisaPaymentFactory extends BasePaymentFactory
{
	public function __construct()
	{
		parent::__construct('nganluong_visa');
	}
}