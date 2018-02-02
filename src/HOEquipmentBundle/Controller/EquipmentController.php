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
        if($this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN') || 
            $this->get('security.authorization_checker')->isGranted('ROLE_MODERATOR')){
            $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
        }
        else{
           $service = $em->getRepository('HOUserBundle:User')->find($this->getUser()->getId())->getService();
           $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAllFromService($service->getId()); 
        }
        
        return $this->render('HOEquipmentBundle:Equipment:index.html.twig',array('equipments'=>$equipments,));
    }

	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll();
		$equipment = new Equipment();
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $code = $this->generateInternalCode();
            $equipment->setCode($code);
            $equipment->setIsOut(false);
            $equipment->setIsBroken(false);
            $em->persist($equipment);
            $em->flush();

            $message = " Equipement ajoutée avec succès ";
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);

            return $this->redirectToRoute('ho_create_equipment');
        }

        return $this->render('HOEquipmentBundle:Equipment:create.html.twig', array('form' => $form->createView(),
        																					'equipments' => $equipments,));
	}

    public function createBrandAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $brand = new \HOEquipmentBundle\Entity\EquipmentBrand();
        $form = $this->createForm(new \HOEquipmentBundle\Form\EquipmentBrandType(),$brand);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em->persist($brand);
            $em->flush();

            return $this->redirectToRoute('ho_create_equipment');
        }

        return $this->render('HOEquipmentBundle:Equipment:brand.html.twig', array('form' => $form->createView(),));


    }


    public function equipmentInterventionsAction($id){
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        return $this->render('HOEquipmentBundle:Equipment:interventions.html.twig',array('equipment'=>$equipment,));
    }


	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $form = $this->createForm(new EquipmentType(),$equipment);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

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


    public function printingEquipmentsAction(){
        $em = $this->getDoctrine()->getManager();
        
        $title = "Liste des équipements";
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findEquipments() ;

        return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,'equipments'=>$equipments,));
       

    }


    public function printingMaterialAction(){
        $em = $this->getDoctrine()->getManager();
        
        $title = "Liste du matériel d'interventions ";
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findMaterialInterventions() ;

        return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,'equipments'=>$equipments,));
       

    }

    public function printingEquipmentsToControlAction(){
        $em = $this->getDoctrine()->getManager();
        
        $title = "Liste des équipements à controller";
        $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findEquipmentsToControl() ;

        return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,'equipments'=>$equipments,));
       

    }



    public function printingByCriteriaAction(Request $request){
        $data =array();
        $list = array();

        $form = $this->createFormBuilder($data)
                ->add('brand',\Symfony\Bridge\Doctrine\Form\Type\EntityType::class,array(
                    'required' => false,
                    'class'    => 'HOEquipmentBundle:EquipmentBrand',
                    'property' => 'name',))
                ->add('category',\Symfony\Bridge\Doctrine\Form\Type\EntityType::class,array(
                    'required' => false,
                    'class'    => 'HOEquipmentBundle:EquipmentCategory',
                    'property' => 'name',))
                ->add('period', \Symfony\Component\Form\Extension\Core\Type\CheckboxType::class, array(
                    'label'    => 'Période?',
                    'required' => false,
                ))
                ->add('dateBegin',\Symfony\Component\Form\Extension\Core\Type\DateType::class,array('required' => false,
                    'widget'=>'single_text',))
                ->add('dateEnd',\Symfony\Component\Form\Extension\Core\Type\DateType::class,array('required' => false,
                    'widget'=>'single_text',))
                ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();    
            $equipments = $em->getRepository('HOEquipmentBundle:Equipment')->findAll() ;
            $param= $form->getData();
            $title = "Liste des équipements";
            foreach ($equipments as $eq) {
                $valid = true;
                if($param['brand']!=null && $param['brand']!=$eq->getBrand() ){
                    $valid = false;
                }
                if($param['category']!= null && $param['category']!=$eq->getCategory() ){
                    $valid = false;
                }
                if($param['period'] && ($param['dateBegin'] > $eq->getUseDate()  || $param['dateEnd'] < $eq->getUseDate() ) ){
                    $valid = false;
                }
                if($valid){
                    array_push($list,$eq);
                }
            }

            $criterias = $this->getPrintCriterias($param);
            return $this->render('HOEquipmentBundle:Equipment:print-page.html.twig', array('title' => $title,
                                    'equipments'=>$list,
                                    'criterias'=>$criterias,));
   
        }

        return $this->render('HOEquipmentBundle:Equipment:print-crit-form.html.twig', array('form' => $form->createView(),));

    }



    public function generateInternalCode(){
        $totalEquipments = $this->getDoctrine()->getManager()->getRepository('HOEquipmentBundle:Equipment')->findEquipmentsCount();

        $totalEquipments++; // on incrémente le code pour le nouvel équipement

        //calcul nombre de zéros devant . ex: 0001 ou lieu de 1
        $zeros ="";
        $digitNumber = strlen($totalEquipments);
        while ($digitNumber < 4) {
            $zeros .="0";
            $digitNumber++;
        }
 
        $code = "HIAOBO".$zeros.$totalEquipments;
        return $code;   
    }

    public function getPrintCriterias($data){
        if($data['brand']!=null){
            $crit['Marque'] = $data['brand']->getName();
        }
        if($data['category']!=null){
            $crit['Domaine'] = $data['category']->getName();
        }
        if($data['period']){
            $crit['date'] = $data['dateBegin']->format('d/m/Y')." - ".$data['dateEnd']->format('d/m/Y');
        }
        return $crit;
    }


    public function transfertEquipmentAction(Request $request,$id){
        $em = $this->getDoctrine()->getManager();
        $equipment = $em->getRepository('HOEquipmentBundle:Equipment')->find($id);
        $form = $this->createFormBuilder($equipment)
              ->add('serviceRoom',\Symfony\Bridge\Doctrine\Form\Type\EntityType::class,array(
                    'required' => false,
                    'class'    => 'HOCompanyBundle:serviceRoom',
                    'property' => 'name',
                    'group_by' => function($serviceRoom){
                        return $serviceRoom->getService()->getName();
                    },))
                
                ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $service = $equipment->getServiceRoom()->getService();
            $equipment->setService($service);
            $em->merge($equipment);
            $em->flush();

            $message = " Transfert de l'équipement ".$equipment->getCode()." réalisé avec succès ";
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);

            return $this->redirectToRoute('ho_equipment_homepage');
   
        }

        return $this->render('HOEquipmentBundle:Equipment:transfert.html.twig', array('form' => $form->createView(),
                                                                                        'equipment'=>$equipment,));


    }







    


}
