<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use HOEquipmentBundle\Entity\Equipment;
use HOEquipmentBundle\Entity\EquipmentReparation;
use HOEquipmentBundle\Entity\MyDateTime;

use HOEquipmentBundle\Form\EquipmentType;

class EquipmentController extends Controller
{

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
        return $this->render('HOEquipmentBundle:Equipment:index.html.twig',array('equipments'=>$equipments,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
		$equipment = new Equipment();
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($equipment);
            $em->flush();

            return $this->redirectToRoute('ho_create_equipment');
        }

        return $this->render('HOEquipmentBundle:Equipment:create.html.twig', array('form' => $form->createView(),
        																					'equipments' => $equipments,));


	}


	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($equipment);
            $em->flush();

            return $this->redirectToRoute('ho_equipment_homepage');
        }

        return $this->render('HOEquipmentBundle:Equipment:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
	}


	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);

        if($equipment){
        	$em->remove($equipment);
            $em->flush();
        }
		 return $this->redirectToRoute('ho_equipment_homepage');
	}




    public function reparationEquipmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $state = $em->getRepository('HOEquipmentBundle:EquipmentState')->findOneBy(array('state' => 'Fonctionnel'));
        
        if($equipment){
            $data = array();
            $reparation = new EquipmentReparation();
            $form = $this->createFormBuilder($data)
            ->add('repairer','entity',array(
                    'class'    => 'HOCompanyBundle:Repairer',
                    'property' => 'username',
                    'required' => true, 
                    'expanded' => false,
                    'multiple' => false ,))
            ->add('comment','textarea')
            ->getForm();

            if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
                $data= $form->getData();
                $reparation->setRepairer($data['repairer']);
                $reparation->setEquipment($equipment);
                $reparation->setDate(new MyDateTime());
                $reparation->setComment($data['comment']);

                $em->persist($reparation);

                $equipment->setIsBroken(false);
                $equipment->SetState($state);
                $equipment->addReparation($reparation);
                $em->merge($equipment);
                $em->flush();

                return $this->redirectToRoute('ho_equipment_homepage');
            }
            return $this->render('HOEquipmentBundle:Equipment:reparation.html.twig', array('form' => $form->createView(),
                                                                                            'equipment' => $equipment,));
       }
       else{
            throw $this->createAccessDeniedException(" L'équipement avec pour id:".$id." est inexistant !! ");
       }

        

    }


}
