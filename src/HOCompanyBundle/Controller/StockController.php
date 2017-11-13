<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOCompanyBundle\Entity\Stock;
use HOCompanyBundle\Form\StockType;


class StockController extends Controller
{
	public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $stocks = $em->getRepository('HOCompanyBundle:Stock')->findAll();
        return $this->render('HOCompanyBundle:Stock:index.html.twig',array('stocks'=>$stocks,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$stock = new Stock();
        $form = $this->createForm(new StockType(),$stock);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($stock);
            $em->flush();

            return $this->redirectToRoute('ho_create_stock');
        }

        return $this->render('HOCompanyBundle:Stock:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOCompanyBundle:Stock')->find($id);
        $form = $this->createForm(new StockType(),$stock);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($stock);
            $em->flush();

            return $this->redirectToRoute('ho_stock_homepage');
        }

        return $this->render('HOCompanyBundle:Stock:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOCompanyBundle:Stock')->find($id);

        if($stock){
        	$em->remove($stock);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_stock_homepage');
	}



    public function addEquipmentAction(Request $request, $stockId){
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOCompanyBundle:Stock')->find($stockId);
        $equipment = new \HOEquipmentBundle\Entity\Equipment();
        $form = $this->createForm(new \HOEquipmentBundle\Form\EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $equipment->setIsBroken(false);
            $equipment->setStock($stock);
            $em->persist($equipment);
            //$em->merge($stock);
            $em->flush();

            return $this->redirectToRoute('ho_stock_homepage');
        }

        return $this->render('HOCompanyBundle:Stock:add-equipment.html.twig', array('form' => $form->createView(),'stock'=>$stock,));

    }


    public function addSparePartAction(Request $request,$stockId){
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOCompanyBundle:Stock')->find($stockId);
        $spare = new \HOSparePartBundle\Entity\SparePart();
        $form = $this->createForm(new \HOSparePartBundle\Form\SparePartType(),$spare);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $spare->setIsUsed(false);
            $spare->setStock($stock);
            $em->persist($spare);
            //$em->merge($stock);
            $em->flush();

            return $this->redirectToRoute('ho_stock_homepage');
        }

        return $this->render('HOCompanyBundle:Stock:add-spare.html.twig', array('form' => $form->createView(),'stock'=>$stock,));       

    }

}
