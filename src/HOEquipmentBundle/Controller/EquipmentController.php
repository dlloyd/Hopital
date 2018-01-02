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

    public function equipmentInterventionsAction($id){
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        return $this->render('HOEquipmentBundle:Equipment:interventions.html.twig',array('equipment'=>$equipment,));
    }


	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

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


    public function printingEquipmentsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $title = "Liste des équipements";
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findEquipments() ;

        return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,'equipments'=>$equipments,));
       

    }


    public function printingMaterialAction(){
        $em = $this->getDoctrine()->getManager();
        
        $title = "Liste du matériel d'interventions ";
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findMaterialInterventions() ;

        return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,'equipments'=>$equipments,));
       

    }

    public function printingEquipmentsToControlAction(){
        $em = $this->getDoctrine()->getManager();
        
        $title = "Liste des équipements à controller";
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findEquipmentsToControl() ;

        return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,'equipments'=>$equipments,));
       

    }







    


}
