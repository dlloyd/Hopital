<?php

namespace HOInterventionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class InterventionEquipmentController extends Controller
{

	public function indexAction(){
		$em = $this->getDoctrine()->getManager();
		$interventions = array();
		$toolBox = $em->getRepository('HOInterventionBundle:ToolBox')->find(1);

		foreach ($toolBox->getEquipments() as $equipment) {
			if($equipment->getIsOut()){
				$id = $equipment->getId();
				$interventions[$id] = $em->getRepository('HOInterventionBundle:InterventionEquipment')->findLastIntervention($id);
			}		
		}
		
		return $this->render('HOInterventionBundle:InterventionEquipment:index.html.twig', array('equipments'=>$toolBox->getEquipments(),
								'interventions' => $interventions,));
	}


	public function addEquipmentAction(Request $request){
        $equipment = new \HOEquipmentBundle\Entity\Equipment();
        $form = $this->createFormBuilder($equipment)
        ->add('code',TextType::class)
        ->add('name',TextType::class)
        ->add('manufactureDate',DateType::class,array('required' => false,'widget'=>'single_text'))
        ->add('useDate',DateType::class,array('required' => false,'widget'=>'single_text',))
        ->add('category',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:EquipmentCategory',
                    'choice_label' => function ($categ) {
                            return $categ->getName();
                        },
                    'group_by' => function($categ) {
                                        return $categ->getFamily()->getName();
                                    },
                    'multiple' => false ,))
        ->getForm();
        

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $toolBox = $em->getRepository('HOInterventionBundle:ToolBox')->find(1);
            $equipment->setToolBox($toolBox);
            $equipment->setIsOut(false);
            $equipment->setIsBroken(false);
            $em->persist($equipment);
            $em->merge($toolBox);
            $em->flush();

            return $this->redirectToRoute('ho_intervention_toolbox');
        }

        return $this->render('HOInterventionBundle:ToolBox:add-equipment.html.twig', array('form' => $form->createView(),));


	}


	public function getOutEquipmentAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $interventions = $em->getRepository('HOInterventionBundle:Intervention')->findAllCurrent();
		$interventionEquipment = new \HOInterventionBundle\Entity\InterventionEquipment();
        $form = $this->createFormBuilder($interventionEquipment)
        ->add('dateOut',DateType::class,array('required' => true,'widget'=>'single_text'))
        ->add('intervention',EntityType::class,array(
                    'class'    => 'HOInterventionBundle:Intervention',
                    'property' => 'id',
                    'choices' => $interventions,
                    'multiple' => false ,))
        ->getForm();
        

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            
            $interventionEquipment->setIsBack(false);
            $interventionEquipment->setEquipment($equipment);
            $equipment->setIsOut(true);
            $em->merge($equipment);
            $em->persist($interventionEquipment);
            $em->flush();

            return $this->redirectToRoute('ho_intervention_toolbox');
        }

        return $this->render('HOInterventionBundle:InterventionEquipment:out.html.twig', array('form' => $form->createView(),
        	'equipment' => $equipment,));


	}

	public function getBackEquipmentAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
		$interventionEquipment = $em->getRepository('HOInterventionBundle:InterventionEquipment')->findLastIntervention($id);
		$intervention = $interventionEquipment->getIntervention();
        $form = $this->createFormBuilder($interventionEquipment)
        ->add('dateReturn',DateType::class,array('required' => true,'widget'=>'single_text','date'=> new \Datetime(),))
        ->getForm();
        
        

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            
            $interventionEquipment->setIsBack(true);
            $equipment->setIsOut(false);
            $em->merge($equipment);
            $em->merge($interventionEquipment);
            $em->flush();

            return $this->redirectToRoute('ho_intervention_toolbox');
        }

        return $this->render('HOInterventionBundle:InterventionEquipment:return.html.twig', array('form' => $form->createView(),
        						'intervention' => $intervention  ,'equipment' => $equipment,));
	}

    public function getBackEquipmentFromInterventionAction($interventionId,$equipmentId){
        $em = $this->getDoctrine()->getManager();
        $intervention = $em->getRepository('HOInterventionBundle:Intervention')->find($equipmentId);

        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($equipmentId);

        if($intervention && $equipment){
            if($equipment->getToolBox()!= null){
                $interventionEquipment = $em->getRepository('HOInterventionBundle:InterventionEquipment')->findLastIntervention($equipmentId);
                $equipment->setIsOut(false);
                $interventionEquipment->setDateReturn(new \Datetime());
                $interventionEquipment->setIsBack(true);
                $em->merge($equipment);
                $em->merge($interventionEquipment);
                $em->flush();
            }
        }

        return $this->redirectToRoute('ho_intervention_validate',array('id' => $interventionId,));


    }



}
