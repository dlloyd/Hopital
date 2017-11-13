<?php

namespace HOEquipmentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class EquipmentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('code',TextType::class)
        ->add('name',TextType::class)
        ->add('manufactureDate',DateType::class,array('required' => false,))
        ->add('useDate',DateType::class,array('required' => false,))
        ->add('service',EntityType::class,array(
                    'required' => false,
                    'class'    => 'HOCompanyBundle:Service',
                    'property' => 'name',
                    'multiple' => false ,))
        ->add('category',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:EquipmentCategory',
                    'property' => 'name',
                    'multiple' => false ,));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HOEquipmentBundle\Entity\Equipment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hoequipmentbundle_equipment';
    }


}
