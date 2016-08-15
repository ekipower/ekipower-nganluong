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

class NLWalletType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'label' => 'eki.form.nl_account.email',
            ))
			->add('password', 'repeated', array(
			    'type' => 'password',
			    'invalid_message' => 'eki.form.nl_account.password.invalid_message',
			    'options' => array('attr' => array('class' => 'password-field')),
			    'required' => true,
			    'first_options'  => array('label' => 'eki.form.nl_account.password.first_options'),
			    'second_options' => array('label' => 'eki.form.nl_account.password.second_options'),
			))       
		;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eki\Nganluong\Simulator\Model\NLWallet',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'eki_nl_account';
    }
}
