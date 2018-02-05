<?php

namespace HOInterventionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
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
        ->add('alertCategory',EntityType::class,array(
                'class'    => 'HOInterventionBundle:AlertCategory',
                'property' => 'name',
                'required' => true, 
                'expanded' => false,
                'multiple' => false ,))
        ->add('designation',TextareaType::class);


        $formModifier = function (FormInterface $form, \HOCompanyBundle\Entity\ServiceRoom $room = null) {
            $equipments = null === $room ? array() : $room->getEquipments();

            $form->add('equipment',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:Equipment',
                    'choice_label' => function ($equipment) {
                            return $equipment->getBrand()->getName()." / ".$equipment->getCode();
                        },
                    'choices'  => $equipments,
                    'group_by' => function($equipment){
                        return $equipment->getServiceRoom()->getService()->getName();
                    },
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getServiceRoom());
            }
        );

        $builder->get('serviceRoom')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $room = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $room);
            }
        );

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
