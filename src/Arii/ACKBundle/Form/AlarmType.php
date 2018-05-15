<?php

namespace Arii\ACKBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AlarmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('title')
            ->add('description')
            ->add('alarmType')
            ->add('alarmTime')
            ->add('exitCode')
            ->add('stdout')
            ->add('stderr')
            ->add('response')
            ->add('state')
            ->add('stateTime')
            ->add('job')
            ->add('user')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Arii\ACKBundle\Entity\Alarm'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'arii_ackbundle_alarm';
    }
}
