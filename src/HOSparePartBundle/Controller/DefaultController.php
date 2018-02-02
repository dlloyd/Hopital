<?php

namespace HOSparePartBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HOSparePartBundle\Entity\SparePart;


use HOSparePartBundle\Form\SparePartTypeType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DefaultController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $spareParts = $em->getRepository('HOSparePartBundle:SparePart')->findAllNotUsed();
        return $this->render('HOSparePartBundle:Spare:index.html.twig',array('spareParts'=>$spareParts,));
    }

    public function spareByTypeAction($id){
        $em = $this->getDoctrine()->getManager();
        $type = $em->getRepository('HOSparePartBundle:SparePartType')->find($id);

        $spareParts = $em->getRepository('HOSparePartBundle:SparePart')->findAllNotUsedByType($id);

        return $this->render('HOSparePartBundle:Spare:spares-by-type.html.twig',array('spareParts'=>$spareParts,'type'=>$type,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$sparePart = new \HOSparePartBundle\Entity\SparePart();
        $form = $this->createForm(new  \HOSparePartBundle\Form\SparePartType(),$sparePart);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
        	$sparePart->setIsUsed(false);
            $em->persist($sparePart);
            $em->flush();

            $message = " Pièce détachée ajoutée avec succès ";
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);

            return $this->redirectToRoute('ho_spare_part_type_homepage');
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
        $nbrStock = array();
        $types = $em->getRepository('HOSparePartBundle:SparePartType')->findAll();

        foreach ($types as $type) {
            $id = $type->getId();
            $nbr = $em->getRepository('HOSparePartBundle:SparePartType')->findCountAllNotUsed($id);
            $nbrStock[$id] = $nbr;
        }
        return $this->render('HOSparePartBundle:Type:index.html.twig',array('types'=>$types,'nbrStock'=>$nbrStock));
    }

    public function createBrandAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $brand = new \HOEquipmentBundle\Entity\EquipmentBrand();
        $form = $this->createForm(new \HOEquipmentBundle\Form\EquipmentBrandType(),$brand);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em->persist($brand);
            $em->flush();

            return $this->redirectToRoute('ho_create_spare_part');
        }

        return $this->render('HOSparePartBundle:Spare:brand.html.twig', array('form' => $form->createView(),));


    }

	public function createTypeAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$type = new  \HOSparePartBundle\Entity\SparePartType();
        $form = $this->createForm(new \HOSparePartBundle\Form\SparePartTypeType(),$type);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($type);
            $em->flush();

            return $this->redirectToRoute('ho_create_spare_part');
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


    public function setOutSparePartAction($id,Request $request){
        $em = $this->getDoctrine()->getManager();
        $sparePart = $em->getRepository('HOSparePartBundle:SparePart')->find($id);
        $interventions = $em->getRepository('HOInterventionBundle:Intervention')->findAllCurrent();
        $form = $this->createFormBuilder($sparePart)
        ->add('intervention',EntityType::class,array(
                    'class'    => 'HOInterventionBundle:Intervention',
                    'property' => 'id',
                    'choices' => $interventions,
                    'multiple' => false ,))
        ->getForm();
        

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $sparePart->setIsUsed(true);
            $em->merge($sparePart);
            $em->flush();

            return $this->redirectToRoute('ho_spare_part_homepage');
        }

        return $this->render('HOSparePartBundle:Spare:out.html.twig', array('form' => $form->createView(),
            'sparePart' => $sparePart,));

    }
}
