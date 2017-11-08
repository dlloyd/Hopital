<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOEquipmentBundle\Entity\EquipmentState;
use HOEquipmentBundle\Form\EquipmentStateType;

class EquipmentStateController extends Controller
{

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $states = $em->getRepository('HOEquipmentBundle:EquipmentState')->findAll();
        return $this->render('HOEquipmentBundle:State:index.html.twig',array('states'=>$states,));
    }


	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$states = $em->getRepository('HOEquipmentBundle:EquipmentState')->findAll();
		$state = new EquipmentState();
        $form = $this->createForm(new EquipmentStateType(),$state);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($state);
            $em->flush();

            return $this->redirectToRoute('ho_create_state');
        }

        return $this->render('HOEquipmentBundle:State:create.html.twig', array('form' => $form->createView(),
        																					'states' => $states,));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $state = $em->getRepository('HOEquipmentBundle:EquipmentState')->find($id);
        $form = $this->createForm(new EquipmentStateType(),$state);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($state);
            $em->flush();

            return $this->redirectToRoute('ho_state_homepage');
        }

        return $this->render('HOEquipmentBundle:State:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $state = $em->getRepository('HOEquipmentBundle:EquipmentState')->find($id);

        if($state){
        	$em->remove($state);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_state_homepage');
	}
}
