<?php

namespace HOInterventionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AlertServiceType extends AbstractType
{

    public $service;

    public function __construct($data){
        $this->service = $data;
    }
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if(!empty($this->service)){
            $rooms = $this->service->getRooms();
            $equipments = $this->service->getEquipments();
        }
        else{
            $rooms=null;
            $equipments = null;
        }
        $builder
        ->add('serviceRoom',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:ServiceRoom',
                    'property' => 'name',
                    'choices'  => $rooms,
                    'group_by' => function($serviceRoom){
                        return $serviceRoom->getService()->getName();
                    },
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))

        ->add('equipment',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:Equipment',
                    'choice_label' => function ($equipment) {
                            return $equipment->getName()." / ".$equipment->getCode();
                        },
                    'choices'  => $equipments,
                    'group_by' => function($equipment){
                        return $equipment->getServiceRoom()->getService()->getName();
                    },
                    'query_builder' => function (\HOEquipmentBundle\Repository\EquipmentRepository $er) {
                        return $er->createQueryBuilder('e')
                            ->where('e.serviceRoom IS NOT NULL');
                    },
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))
        
        ->add('alertCategory',EntityType::class,array(
                'class'    => 'HOInterventionBundle:AlertCategory',
                'property' => 'name',
                'required' => true, 
                'expanded' => false,
                'multiple' => false ,))
        ->add('designation',TextareaType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HOInterventionBundle\Entity\AlertService'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hointerventionbundle_alertservice';
    }


}
