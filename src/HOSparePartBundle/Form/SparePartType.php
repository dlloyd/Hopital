<?php

namespace HOSparePartBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class SparePartType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('serialNumber',TextType::class)
        ->add('complDesignation',TextareaType::class,array('required' =>false,))
        ->add('manufactureDate',DateType::class,array('required' => false,'widget'=>'single_text'))
        ->add('brand',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:EquipmentBrand',
                    'property' => 'name',
                    'multiple' => false ,))
        ->add('type',EntityType::class,array(
                    'class'    => 'HOSparePartBundle:SparePartType',
                    'property' => 'name',
                    'multiple' => false ,));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HOSparePartBundle\Entity\SparePart'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hosparepartbundle_sparepart';
    }


}
