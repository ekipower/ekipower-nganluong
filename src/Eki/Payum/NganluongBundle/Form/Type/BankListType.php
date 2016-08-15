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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Bank list type.
 *
 * @author Nguyen Tien Hy <ngtienhy@gmail.com>
 */
class BankListType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code', 'eki_nganluong_bank_choice', array(
//                'label' => 'eki.nganluong.form.bank_list.code'
                'label' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
       $resolver
            ->setDefaults(
                array(
                    'data_class' => 'Eki\Payum\Nganluong\Model\Bank',
                    'label' => false,
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'eki_nganluong_bank_list';
    }
}
