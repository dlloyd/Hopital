<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOEquipmentBundle\Entity\Zone;
use HOEquipmentBundle\Form\ZoneType;

class ZoneController extends Controller
{
    
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $zones = $em->getRepository('HOEquipmentBundle:Zone')->findAll();
        return $this->render('HOEquipmentBundle:Zone:index.html.twig',array('zones'=>$zones,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$zones = $em->getRepository('HOEquipmentBundle:Zone')->findAll();
		$zone = new Zone();
        $form = $this->createForm(new ZoneType(),$zone);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($zone);
            $em->flush();

            return $this->redirectToRoute('ho_create_zone');
        }

        return $this->render('HOEquipmentBundle:Zone:create.html.twig', array('form' => $form->createView(),
        																					'zones' => $zones,));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('HOEquipmentBundle:Zone')->find($id);
        $form = $this->createForm(new ZoneType(),$zone);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($zone);
            $em->flush();

            return $this->redirectToRoute('ho_zone_homepage');
        }

        return $this->render('HOEquipmentBundle:Zone:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('HOEquipmentBundle:Zone')->find($id);

        if($zone){
        	$em->remove($zone);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_zone_homepage');
	}
}
