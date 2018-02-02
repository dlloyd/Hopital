<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HOCompanyBundle\Entity\Service;
use HOCompanyBundle\Form\ServiceType;
use HOCompanyBundle\Entity\ServiceRoom;
use HOCompanyBundle\Form\ServiceRoomType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ServiceController extends Controller
{
	public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('HOCompanyBundle:Service')->findAll();
        return $this->render('HOCompanyBundle:Service:index.html.twig',array('services'=>$services,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$service = new Service();
        $form = $this->createForm(new ServiceType(),$service);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($service);
            $em->flush();
            $message = " Service ajoutée avec succès ";
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);

            return $this->redirectToRoute('ho_service_homepage');
        }

        return $this->render('HOCompanyBundle:Service:create.html.twig', array('form' => $form->createView(),));

	}

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($id);
        $form = $this->createForm(new ServiceType(),$service);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($service);
            $em->flush();

            return $this->redirectToRoute('ho_service_homepage');
        }

        return $this->render('HOCompanyBundle:Service:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($id);

        if($service){
        	$em->remove($service);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_service_homepage');
	}




    // Ajouter une salle à un service
    public function addRoomAction($serviceId,Request $request){
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($serviceId);
        $serviceRoom = new ServiceRoom();
        $form = $this->createForm(new ServiceRoomType($service),$serviceRoom);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $serviceRoom->setService($service);
            $em->persist($serviceRoom);
            $em->flush();
            $message = "Salle ".$serviceRoom->getName()." ajoutée avec succès";
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);

            return $this->redirectToRoute('ho_service_add_room',array('serviceId'=> $serviceId,));
        }

        return $this->render('HOCompanyBundle:Service:add-room.html.twig', array('form' => $form->createView(),'serviceId'=>$serviceId,
                                'service' => $service));
    }




	

    public function addEquipmentBaseAction(Request $request,$serviceId){
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($serviceId);
        $equipment = new \HOEquipmentBundle\Entity\Equipment();
        $form = $this->createFormBuilder($equipment)
            ->add('code',TextType::class)
            ->add('name',TextType::class)
            ->add('manufactureDate',DateType::class,array('required' => false,'widget'=>'single_text'))
            ->add('useDate',DateType::class,array('required' => false,'widget'=>'single_text',))
            ->add('serviceRoom',EntityType::class,array(
                        'required' => false,
                        'class'    => 'HOCompanyBundle:ServiceRoom',
                        'choices'  => $service->getRooms(),
                        'property' => 'name',
                        'multiple' => false ,))
            ->add('category',EntityType::class,array(
                        'class'    => 'HOEquipmentBundle:EquipmentCategory',
                        'choice_label' => function ($categ) {
                            return $categ->getName();
                        },
                    'group_by' => function($categ) {
                                        return $categ->getFamily()->getName();
                                    },
                    'multiple' => false ,))
                    
            ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $equipment->setIsBroken(false);
            $equipment->setIsOut(true);
            $equipment->setService($service);
            $em->persist($equipment);
            
            $em->flush();

            return $this->redirectToRoute('ho_service_homepage');
        }

        return $this->render('HOCompanyBundle:Service:add-equipment-base.html.twig', array('form' => $form->createView(),
                                                                                            'service'=>$service,));
    }


    public function addEquipmentFromStockAction(Request $request,$serviceId){
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($serviceId);
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
        $data = array();
        $equipmentNotUse =array();

        foreach ($equipments as $eq) {
            if(!$eq->getService())
                array_push($equipmentNotUse, $eq);
        }
        
        $form = $this->createFormBuilder($data)
            ->add('equipment',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:Equipment',
                    'choices'   => $equipmentNotUse,
                    'property' => 'name',
                    'group_by' => function($equipment) {
                                        return 'Stock '.$equipment->getStock()->getId();
                                    },
                    'required' => true, 
                    'expanded' => false,
                    'multiple' => false ,))
            ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $data= $form->getData();

            $service->addEquipment($data['equipment']);
            $data['equipment']->setService($service);
            $data['equipment']->setUseDate(new \Datetime());
            $em->merge($data['equipment']);
            $em->merge($service);
            
            $em->flush();

            return $this->redirectToRoute('ho_service_homepage');
        }

        return $this->render('HOCompanyBundle:Service:add-equipment-stock.html.twig', array('form' => $form->createView(),
                                                                                            'service'=>$service,));
    }

	
}
