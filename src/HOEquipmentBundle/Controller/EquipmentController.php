<?php

namespace HOEquipmentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use HOEquipmentBundle\Entity\Equipment;
use HOEquipmentBundle\Entity\EquipmentReparation;
use HOEquipmentBundle\Entity\MyDateTime;

use HOEquipmentBundle\Form\EquipmentType;

class EquipmentController extends Controller
{

    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
        return $this->render('HOEquipmentBundle:Equipment:index.html.twig',array('equipments'=>$equipments,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
		$equipment = new Equipment();
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($equipment);
            $em->flush();

            return $this->redirectToRoute('ho_create_equipment');
        }

        return $this->render('HOEquipmentBundle:Equipment:create.html.twig', array('form' => $form->createView(),
        																					'equipments' => $equipments,));


	}


	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($equipment);
            $em->flush();

            return $this->redirectToRoute('ho_equipment_homepage');
        }

        return $this->render('HOEquipmentBundle:Equipment:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
	}


	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);

        if($equipment){
        	$em->remove($equipment);
            $em->flush();
        }
		 return $this->redirectToRoute('ho_equipment_homepage');
	}


    public function isBrokenAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);

        if($equipment){
            $equipment->setIsBroken(true);
            $em->merge($equipment);
            $em->flush();
        }

        if($request->isXmlHttpRequest() ){
            return new JsonResponse(array('data'=>'Demande validée'));
        }
                         
        else{
            return $this->redirectToRoute('ho_equipment_homepage');
        }  

       
    }


    public function reparationEquipmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        
        if($equipment){
            $data = array();
            $reparation = new EquipmentReparation();
            $form = $this->createFormBuilder($data)
            ->add('repairer','entity',array(
                    'class'    => 'HOEquipmentBundle:Repairer',
                    'property' => 'username',
                    'required' => true, 
                    'expanded' => false,
                    'multiple' => false ,))
            ->add('problem','textarea')
            ->getForm();

            if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
                $data= $form->getData();
                $reparation->setRepairer($data['repairer']);
                $reparation->setEquipment($equipment);
                $reparation->setDate(new MyDateTime());
                $reparation->setProblem($data['problem']);

                $em->persist($reparation);

                $equipment->setIsBroken(false);
                $em->merge($equipment);
                $em->flush();

                return $this->redirectToRoute('ho_equipment_homepage');
            }
            return $this->render('HOEquipmentBundle:Equipment:reparation.html.twig', array('form' => $form->createView(),
                                                                                            'equipment' => $equipment,));
       }
       else{
            throw $this->createAccessDeniedException(" L'équipement avec pour id:".$id." est inexistant !! ");
       }

        

    }


}
