<?php
/**
 * This file is part of the EkiNganluongSimulatorBundle package.
 *
 * (c) EkiPower <http://ekipower.github.com/>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */ 

namespace Eki\Nganluong\SimulatorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

class AtmCardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('type', 'choice', array(
//                'label'    => 'eki.sylius.form.credit_card.type',
//                'expanded' => true,
//              ))
            ->add('cardholderName', 'text', array(
                'label' => 'eki.form.credit_card.holder',
            ))
            ->add('number', 'text', array(
                  'label' => 'eki.form.credit_card.number',
            ))
//            ->add('securityCode', 'text', array(
//                  'label' => 'eki.form.credit_card.security_code',
//            ))
            ->add('expiryMonth', 'choice', array(
                  'label'   => 'eki.form.credit_card.expiry_month',
                  'choices' => $this->getMonthChoices()
            ))
            ->add('expiryYear', 'choice', array(
                  'label'   => 'eki.form.credit_card.expiry_year',
                  'choices' =>  $this->getViableYears()
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eki\Nganluong\Simulator\Model\AtmCard',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'eki_atm_card';
    }

    /**
     * Get years to add as choices in expiryYear
     *
     * @return array
     */
    private function getViableYears()
    {
        $yearChoices = array();
        $currentYear = (int) date("Y");

        for ($i = 0; $i <= 20; $i++) {
            $yearChoices[$currentYear + $i] = $currentYear + $i;
        }

        return $yearChoices;
    }

    /**
     * Get months to add as choices in expiryMonth
     *
     * @return array
     */
    private function getMonthChoices()
    {
        $monthChoices = array();

        foreach (range(1, 12) as $month) {
            $monthChoices[$month] = str_pad($month, 2, 0, STR_PAD_LEFT);
        }

        return $monthChoices;
    }
}
