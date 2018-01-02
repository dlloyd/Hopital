<?php

namespace HOCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RepairerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username',TextType::class)
        ->add('function',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:RepairerFunction',
                    'property' => 'name',
                    'multiple' => false ,))
        ->add('status',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:RepairerStatus',
                    'property' => 'status',
                    'multiple' => false ,));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HOCompanyBundle\Entity\Repairer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hocompanybundle_repairer';
    }


}
