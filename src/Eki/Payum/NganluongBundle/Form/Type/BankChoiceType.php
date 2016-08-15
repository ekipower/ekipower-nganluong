<?php
/**
 * This file is part of the EkiPayumNganluongBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Payum\NganluongBundle\Form\Type;

use Eki\Payum\Nganluong\Api\BankCodes;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Bank choice type.
 *
 * @author Nguyen Tien Hy <ngtienhy@gmail.com>
 */
class BankChoiceType extends AbstractType
{
	/**
	* 
	* @var array
	* 
	*/
	protected $choices;
	
    /**
     * Constructor.
     *
     * @param EntityRepository $repository
     */
    public function __construct(array $choices = null)
    {
		if ($choices === null)
		{
			$choices = BankCodes::getBankList();
		}
		
        $this->choices = $choices;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'choices' 	  => $this->choices,
                'label'       => 'eki.nganluong.form.bank_choice.bank_choice',
                'empty_value' => 'eki.nganluong.form.bank_choice.select'
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'eki_nganluong_bank_choice';
    }
}
