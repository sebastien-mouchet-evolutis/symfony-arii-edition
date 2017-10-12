<?php

namespace Arii\ReportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BKP_REFType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('db_env')
            ->add('db_type')
            ->add('db_system')
            ->add('db_name')
            ->add('db_instance')
            ->add('db_group')
            ->add('path_source')
            ->add('path_destination')
            ->add('deleted')
            ->add('sinked')
            ->add('updated')
            ->add('db_desc')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Arii\ReportBundle\Entity\BKP_REF'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'arii_reportbundle_bkp_ref';
    }
}
