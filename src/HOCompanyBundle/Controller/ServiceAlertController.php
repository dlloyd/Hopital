<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HOCompanyBundle\Entity\Service;
use HOCompanyBundle\Form\ServiceType;

use HOCompanyBundle\Entity\AlertService;
use HOCompanyBundle\Form\AlertServiceType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ServiceAlertController extends Controller
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

            return $this->redirectToRoute('ho_create_service');
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




	public function alertAction(){
        $em = $this->getDoctrine()->getManager();
        $alerts = $em->getRepository('HOCompanyBundle:AlertService')->findAll();
        return $this->render('HOCompanyBundle:Alert:index.html.twig',array('alerts'=>$alerts,));
	}

	public function createAlertAction(Request $request,$serviceId){
		$em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($serviceId);    
        $data = array();
    
        $form = $this->createFormBuilder($data)
            ->add('equipment',EntityType::class,array(
                    'class'    => 'HOEquipmentBundle:Equipment',
                    'property' => 'name',
                    'choices'  => $service->getEquipments(),
                    'required' => true, 
                    'expanded' => false,
                    'multiple' => false ,))
            ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $alertState = $em->getRepository('HOCompanyBundle:AlertState')->findOneBy(array('name' => "Prise en compte",));
            $data= $form->getData();
            $alert = new AlertService();
            $alert->setService($service);
            $alert->setEquipment($data['equipment']);
            $alert->setDate(new \AppBundle\Entity\MyDateTime());
            $alert->setAlertState($alertState);

            $em->persist($alert);

            $data['equipment']->setIsBroken(true);
            
            $em->merge($data['equipment']);
            $em->flush();

            return $this->redirectToRoute('ho_alert_service_homepage');
        }
        return $this->render('HOCompanyBundle:Alert:create.html.twig', array('form' => $form->createView(),
                                                                                        'service' => $service,));
    }
       


    public function addEquipmentBaseAction(Request $request,$serviceId){
        $em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($serviceId);
        $equipment = new \HOEquipmentBundle\Entity\Equipment();
        $form = $this->createForm(new \HOEquipmentBundle\Form\EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $equipment->setIsBroken(false);
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
