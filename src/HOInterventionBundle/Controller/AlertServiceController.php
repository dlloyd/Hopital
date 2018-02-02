<?php

namespace HOInterventionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HOInterventionBundle\Entity\AlertService;
use HOInterventionBundle\Form\AlertServiceType;

use Symfony\Component\HttpFoundation\Request;


class AlertServiceController extends Controller
{
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        if($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN') || 
            $this->get('security.authorization_checker')->isGranted('ROLE_MODERATOR')){
            $alerts = $em->getRepository('HOInterventionBundle:AlertService')->findAll();
            return $this->render('HOInterventionBundle:Alert:index.html.twig',array('alerts'=>$alerts,));
        }
        else{
           $service = $em->getRepository('HOUserBundle:User')->find($this->getUser()->getId())->getService();
           $alerts = $em->getRepository('HOInterventionBundle:AlertService')->findAllFromService($service->getId());
           return $this->render('HOInterventionBundle:Alert:index.html.twig',array('alerts'=>$alerts,'service'=>$service,)); 
        }
        
        
	}




	public function createFromServiceAction(Request $request,$serviceId){
        $equipments = array();
		$em = $this->getDoctrine()->getManager();
        $service = $em->getRepository('HOCompanyBundle:Service')->find($serviceId);  


        $alert = new AlertService();
        $form = $this->createForm(new AlertServiceType($service),$alert);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $alertState = $em->getRepository('HOInterventionBundle:AlertState')->findOneBy(array('code' => "PEC",));

            $alert->setService($service);
            $alert->setIsAwarded(false);

            if($alert->getEquipment()){
                $alert->getEquipment()->setIsBroken(true);
            }
            
            $alert->setDate(new \DateTime());
            $alert->setAlertState($alertState);

            $em->persist($alert);

            $em->flush();

            return $this->redirectToRoute('ho_alert_service_homepage');
        }
        return $this->render('HOInterventionBundle:Alert:alert-serv-create.html.twig', array('form' => $form->createView(),
                                                                                        'service' => $service,));
    }

    public function createAction(Request $request){
        $equipments = array();
        $em = $this->getDoctrine()->getManager();
         
        $alert = new AlertService();
        $form = $this->createForm(new AlertServiceType(array()),$alert);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $alertState = $em->getRepository('HOInterventionBundle:AlertState')->findOneBy(array('code' => "PEC",));

            $alert->setService($alert->getServiceRoom()->getService());
            $alert->setIsAwarded(false);

            if($alert->getEquipment()){
                $alert->getEquipment()->setIsBroken(true);
            }
            
            $alert->setDate(new \DateTime());
            $alert->setAlertState($alertState);

            $em->persist($alert);

            $em->flush();

            return $this->redirectToRoute('ho_alert_service_homepage');
        }
        return $this->render('HOInterventionBundle:Alert:create.html.twig', array('form' => $form->createView(),));
    }
}
