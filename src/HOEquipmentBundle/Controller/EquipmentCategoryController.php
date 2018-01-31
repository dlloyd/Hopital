<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOEquipmentBundle\Entity\EquipmentCategory;
use HOEquipmentBundle\Form\EquipmentCategoryType;

class EquipmentCategoryController extends Controller
{

	public function indexAction(){
		$em = $this->getDoctrine()->getManager();
		$categories = $em->getRepository('HOEquipmentBundle:EquipmentCategory')->findAll();
		return $this->render('HOEquipmentBundle:Category:index.html.twig',array('categories'=>$categories,));
	}

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$categories = $em->getRepository('HOEquipmentBundle:EquipmentCategory')->findAll();
		$categ = new EquipmentCategory();
        $form = $this->createForm(new EquipmentCategoryType(),$categ);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($categ);
            $em->flush();

            return $this->redirectToRoute('ho_create_equipment');
        }

        return $this->render('HOEquipmentBundle:Category:create.html.twig', array('form' => $form->createView(),));


	}


	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $categ = $em->getRepository('HOEquipmentBundle:EquipmentCategory')->find($id);
        $form = $this->createForm(new EquipmentCategoryType(),$categ);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($categ);
            $em->flush();

            return $this->redirectToRoute('ho_category_homepage');
        }

        return $this->render('HOEquipmentBundle:Category:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
	}


	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $categ = $em->getRepository('HOEquipmentBundle:EquipmentCategory')->find($id);

        if($categ){
        	$em->remove($categ);
            $em->flush();
        }
		 return $this->redirectToRoute('ho_category_homepage');
	}
}
