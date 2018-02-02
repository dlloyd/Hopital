<?php

namespace HOInterventionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class InterventionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('comment',TextareaType::class)
        ->add('equipment',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:Equipment',
                    'choice_label' => function ($equipment) {
                            return $equipment->getName()." / ".$equipment->getCode();
                        },
                    'group_by' => function($equipment){
                        return $equipment->getCategory()->getName();
                    },
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))
        ->add('repairer',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:Repairer',
                    'choice_label' => function ($rep) {
                            return $rep->getUsername()." / ".$rep->getStatus()->getStatus();
                        },  
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))
        ->add('category',EntityType::class,array(
                    'class'    => 'HOInterventionBundle:InterventionCategory',
                    'property' => 'name',
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))
        ->add('serviceRoom',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:ServiceRoom',
                    'choice_label' => function ($room) {
                            return $room->getName();
                        },
                    'group_by' => function($room) {
                                        return $room->getService()->getName();
                                    },
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HOInterventionBundle\Entity\Intervention'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hointerventionbundle_intervention';
    }


}
