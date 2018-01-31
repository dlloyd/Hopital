<?php

namespace HOInterventionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HOInterventionBundle\Entity\Intervention;
use HOInterventionBundle\Form\InterventionType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;



class InterventionController extends Controller
{

	public function indexAction(){
		$em = $this->getDoctrine()->getManager();
		$interventions = $em->getRepository('HOInterventionBundle:Intervention')->findAll();

		return $this->render('HOInterventionBundle:Default:index.html.twig', array('interventions'=>$interventions,));

	}


	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		
		$inter = new Intervention();
        $form = $this->createForm(new InterventionType(),$inter);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
        	$inter->setIsClosed(true);
            $em->persist($inter);
            $em->flush();

            return $this->redirectToRoute('ho_create_intervention');
        }

        return $this->render('HOInterventionBundle:Default:create.html.twig', array('form' => $form->createView(),));


	}


	public function createAlertInterventionAction($alertId,Request $request){
		$em = $this->getDoctrine()->getManager();
		$alert = $em->getRepository('HOInterventionBundle:AlertService')->find($alertId);
		$repairers = $em->getRepository('HOCompanyBundle:Repairer')->findAll();

        foreach ($repairers as $rep) {
            $nbrTasks[$rep->getId()] = $em->getRepository('HOCompanyBundle:Repairer')->findNbrTasks($rep->getId());
        }

		$inter = new Intervention();
        $form = $this->createFormBuilder($inter)
        ->add('equipment',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:Equipment',
                    'choice_label' => function ($equipment) {
                            return $equipment->getName()." / ".$equipment->getCode();
                        },
                    'choices'  => $alert->getService()->getEquipments(),
                    'data'  => $alert->getEquipment(),
                    'group_by' => function($eq){
                        return $eq->getCategory()->getName();
                    },
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))
        ->add('repairer',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:Repairer',
                    'choice_label' => function ($rep) {
                            return $rep->getUsername()." / ".$rep->getFunction()->getName()."-".$rep->getStatus()->getStatus();
                        }, 
                    'required' => false, 
                    'expanded' => false,
                    'multiple' => false ,))
        ->add('dateBegin',DateType::class,array('data' => new \Datetime() ,))
        ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
        	 //Change l'état de l'alerte à en cours de traitement
			$alertState = $em->getRepository('HOInterventionBundle:AlertState')->findOneBy(array('code' => "ECT",));
			// catégorie currative
			$categ = $em->getRepository('HOInterventionBundle:InterventionCategory')->findOneBy(array('code' => "CUR",));

            $inter->setServiceRoom($alert->getServiceRoom());
			$inter->setCategory($categ);
        	$inter->setAlert($alert);
        	$alert->setAlertState($alertState);
            $alert->setIsAwarded(true);
        	$inter->setIsClosed(false);

            if($inter->getEquipment()){
                $inter->getEquipment()->setIsBroken(false);
            }

            $em->persist($inter);
            $em->flush();

            return $this->redirectToRoute('ho_intervention_homepage');
        }
        return $this->render('HOInterventionBundle:Default:alert-interv.html.twig', array('form' => $form->createView(),
        						'alert'=>$alert,'repairers' => $repairers,'nbrTasks'=>$nbrTasks,));


	}


	public function validateInterventionAction($id,Request $request){
		$em = $this->getDoctrine()->getManager();
		$intervention = $em->getRepository('HOInterventionBundle:Intervention')->find($id);

		$form = $this->createFormBuilder($intervention)
		->add('comment',TextareaType::class)
		->add('dateEnd',DateType::class,array('data' => new \Datetime() ,))
		->getForm();

		if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
			//Change l'état de l'alerte à résolue
			$validateAlertState = $em->getRepository('HOInterventionBundle:AlertState')->findOneBy(array('code' => "RSL",));  

			$categ = $em->getRepository('HOInterventionBundle:InterventionCategory')->findOneBy(array('code' => "CUR",));
        	$intervention->setIsClosed(true);
        	$intervention->setCategory($categ);

            if($intervention->getEquipment()){
                $intervention->getEquipment()->setIsBroken(false);
            }

        	$intervention->getAlert()->setAlertState($validateAlertState);
            $em->persist($intervention);

            $em->flush();

            return $this->redirectToRoute('ho_intervention_homepage');
        }

        return $this->render('HOInterventionBundle:Default:valid-interv.html.twig', array('form' => $form->createView(), 
        						'intervention'=>$intervention,));

	}



}
