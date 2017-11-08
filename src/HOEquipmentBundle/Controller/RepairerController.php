<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOEquipmentBundle\Entity\Repairer;
use HOEquipmentBundle\Form\RepairerType;

class RepairerController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $repairers = $em->getRepository('HOEquipmentBundle:Repairer')->findAll();
        return $this->render('HOEquipmentBundle:Repairer:index.html.twig',array('repairers'=>$repairers,));
    }


	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$repairers = $em->getRepository('HOEquipmentBundle:Repairer')->findAll();
		$rep = new Repairer();
        $form = $this->createForm(new RepairerType(),$rep);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($rep);
            $em->flush();

            return $this->redirectToRoute('ho_create_repairer');
        }

        return $this->render('HOEquipmentBundle:Repairer:create.html.twig', array('form' => $form->createView(),
        																					'repairers' => $repairers,));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('HOEquipmentBundle:Repairer')->find($id);
        $form = $this->createForm(new RepairerType(),$rep);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($rep);
            $em->flush();

            return $this->redirectToRoute('ho_repairer_homepage');
        }

        return $this->render('HOEquipmentBundle:Repairer:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('HOEquipmentBundle:Repairer')->find($id);

        if($rep){
        	$em->remove($rep);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_repairer_homepage');
	}
}
