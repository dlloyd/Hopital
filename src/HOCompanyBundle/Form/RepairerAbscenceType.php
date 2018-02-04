<?php

namespace HOCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class RepairerAbscenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('motif',TextareaType::class)
        ->add('dateBegin',DateType::class,array('required' => false,'widget'=>'single_text'))
        ->add('dateEnd',DateType::class,array('required' => false,'widget'=>'single_text'))
        ->add('repairer',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:Repairer',
                    'property' => 'username',
                    'multiple' => false ,));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HOCompanyBundle\Entity\RepairerAbscence'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hocompanybundle_repairerabscence';
    }


}
