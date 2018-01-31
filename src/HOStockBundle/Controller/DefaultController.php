<?php

namespace HOStockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use HOStockBundle\Entity\Stock;
use HOStockBundle\Form\StockType;

class DefaultController extends Controller
{
   public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $stocks = $em->getRepository('HOStockBundle:Stock')->findAll();
        return $this->render('HOStockBundle:Stock:index.html.twig',array('stocks'=>$stocks,));
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

        return $this->render('HOStockBundle:Stock:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOStockBundle:Stock')->find($id);
        $form = $this->createForm(new StockType(),$stock);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($stock);
            $em->flush();

            return $this->redirectToRoute('ho_stock_homepage');
        }

        return $this->render('HOStockBundle:Stock:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOStockBundle:Stock')->find($id);

        if($stock){
        	$em->remove($stock);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_stock_homepage');
	}




    public function addSparePartAction(Request $request,$stockId){
        $em = $this->getDoctrine()->getManager();
        $stock = $em->getRepository('HOStockBundle:Stock')->find($stockId);
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

        return $this->render('HOStockBundle:Stock:add-spare.html.twig', array('form' => $form->createView(),'stock'=>$stock,));       

    }


}
