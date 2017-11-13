<?php

namespace HOSparePartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HOSparePartBundle\Entity\SparePart;


use HOSparePartBundle\Form\SparePartTypeType;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $spareParts = $em->getRepository('HOSparePartBundle:SparePart')->findAll();
        return $this->render('HOSparePartBundle:Spare:index.html.twig',array('spareParts'=>$spareParts,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$sparePart = new \HOSparePartBundle\Entity\SparePart();
        $form = $this->createForm(new  \HOSparePartBundle\Form\SparePartType(),$sparePart);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
        	$sparePart->setIsUsed(false);
            $em->persist($sparePart);
            $em->flush();

            return $this->redirectToRoute('ho_create_spare_part');
        }

        return $this->render('HOSparePartBundle:Spare:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $sparePart = $em->getRepository('HOSparePartBundle:SparePart')->find($id);
        $form = $this->createForm(new  \HOSparePartBundle\Form\SparePartType(),$sparePart);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($sparePart);
            $em->flush();

            return $this->redirectToRoute('ho_spare_part_homepage');
        }

        return $this->render('HOCompanyBundle:Spare:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $sparePart = $em->getRepository('HOSparePartBundle:SparePart')->find($id);

        if($sparePart){
        	$em->remove($sparePart);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_spare_part_homepage');
	}


	public function indexTypeAction(){
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('HOSparePartBundle:SparePartType')->findAll();
        return $this->render('HOSparePartBundle:Type:index.html.twig',array('types'=>$types,));
    }

	public function createTypeAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$type = new  \HOSparePartBundle\Entity\SparePartType();
        $form = $this->createForm(new \HOSparePartBundle\Form\SparePartTypeType(),$type);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($type);
            $em->flush();

            return $this->redirectToRoute('ho_create_spare_part_type');
        }

        return $this->render('HOSparePartBundle:Type:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateTypeAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('HOSparePartBundle:SparePartType')->find($id);
        $form = $this->createForm(new \HOSparePartBundle\Form\SparePartTypeType(),$type);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($type);
            $em->flush();

            return $this->redirectToRoute('ho_spare_part_type_homepage');
        }

        return $this->render('HOCompanyBundle:Type:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteTypeAction($id){
		$em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('HOSparePartBundle:SparePartType')->find($id);

        if($type){
        	$em->remove($type);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_spare_part_type_homepage');
	}
}
