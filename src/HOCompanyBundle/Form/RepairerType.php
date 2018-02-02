<?php

namespace HOCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class RepairerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username',TextType::class)
        ->add('status',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:RepairerStatus',
                    'property' => 'status',
                    'multiple' => false ,))
        ->add('isActive',CheckboxType::class, array(
                        'label'    => 'Disponible?',
                        'required' => false,
                    ));
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
