<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOCompanyBundle\Entity\Zone;
use HOCompanyBundle\Form\ZoneType;

class ZoneController extends Controller
{
	public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $zones = $em->getRepository('HOCompanyBundle:Zone')->findAll();
        return $this->render('HOCompanyBundle:Zone:index.html.twig',array('zones'=>$zones,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$zones = $em->getRepository('HOCompanyBundle:Zone')->findAll();
		$zone = new Zone();
        $form = $this->createForm(new ZoneType(),$zone);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($zone);
            $em->flush();

            return $this->redirectToRoute('ho_create_zone');
        }

        return $this->render('HOCompanyBundle:Zone:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('HOCompanyBundle:Zone')->find($id);
        $form = $this->createForm(new ZoneType(),$zone);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($zone);
            $em->flush();

            return $this->redirectToRoute('ho_zone_homepage');
        }

        return $this->render('HOCompanyBundle:Zone:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $zone = $em->getRepository('HOCompanyBundle:Zone')->find($id);

        if($zone){
        	$em->remove($zone);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_zone_homepage');
	}
}
