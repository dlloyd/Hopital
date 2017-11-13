<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOCompanyBundle\Entity\Repairer;
use HOCompanyBundle\Form\RepairerType;


class RepairerController extends Controller
{
	public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $repairers = $em->getRepository('HOCompanyBundle:Repairer')->findAll();
        return $this->render('HOCompanyBundle:Repairer:index.html.twig',array('repairers'=>$repairers,));
    }


	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$rep = new Repairer();
        $form = $this->createForm(new RepairerType(),$rep);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($rep);
            $em->flush();

            return $this->redirectToRoute('ho_create_repairer');
        }

        return $this->render('HOCompanyBundle:Repairer:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('HOCompanyBundle:Repairer')->find($id);
        $form = $this->createForm(new RepairerType(),$rep);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($rep);
            $em->flush();

            return $this->redirectToRoute('ho_repairer_homepage');
        }

        return $this->render('HOCompanyBundle:Repairer:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('HOCompanyBundle:Repairer')->find($id);

        if($rep){
        	$em->remove($rep);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_repairer_homepage');
	}



    
}
