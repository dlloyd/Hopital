<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use HOCompanyBundle\Entity\Repairer;
use HOCompanyBundle\Form\RepairerType;
use HOCompanyBundle\Entity\RepairerAbscence;
use HOCompanyBundle\Form\RepairerAbscenceType;


class RepairerController extends Controller
{
	public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $repairers = $em->getRepository('HOCompanyBundle:Repairer')->findAll();
        $nbrTasks = array();

        foreach ($repairers as $rep) {
            $nbrTasks[$rep->getId()] = $em->getRepository('HOCompanyBundle:Repairer')->findNbrTasks($rep->getId());
        }
        return $this->render('HOCompanyBundle:Repairer:index.html.twig',array('repairers'=>$repairers,'nbrTasks'=>$nbrTasks,));
    }


	public function createAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$rep = new Repairer();
        $form = $this->createForm(new RepairerType(),$rep);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){

            $em->persist($rep);
            $em->flush();

            return $this->redirectToRoute('ho_create_repairer');
        }

        return $this->render('HOCompanyBundle:Repairer:create.html.twig', array('form' => $form->createView(),));

	}

    public function createAbscenceAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $abs = new RepairerAbscence();
        $form = $this->createForm(new RepairerAbscenceType(),$abs);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $today = new \Datetime('now');
            if($abs->getDateBegin()->format('d-m-Y') == $today->format('d-m-Y')){
                $abs->getRepairer()->setIsActive(false);
            }
            $em->persist($abs);
            $em->flush();

            $message = " Abscence de ".$abs->getRepairer()->getUsername()." ajoutée avec succès ";
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);

            return $this->redirectToRoute('ho_repairer_homepage');
        }

        return $this->render('HOCompanyBundle:Repairer:abscence.html.twig', array('form' => $form->createView(),));

    }

	public function updateAction(Request $request,$id){
		$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('HOCompanyBundle:Repairer')->find($id);
        $form = $this->createForm(new RepairerType(),$rep);

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->merge($rep);
            $em->flush();

            return $this->redirectToRoute('ho_repairer_homepage');
        }

        return $this->render('HOCompanyBundle:Repairer:update.html.twig', array('form' => $form->createView(),'id'=>$id,));
		
	}

	public function deleteAction($id){
		$em = $this->getDoctrine()->getManager();
        $rep = $em->getRepository('HOCompanyBundle:Repairer')->find($id);

        if($rep){
        	$em->remove($rep);
        	$em->flush();
        }
		return $this->redirectToRoute('ho_repairer_homepage');
	}


    public function repairerInterventionsAction($id){
        $em = $this->getDoctrine()->getManager();
        $repairer = $em->getRepository('HOCompanyBundle:Repairer')->find($id);
        return $this->render('HOCompanyBundle:Repairer:repairer.html.twig',array('repairer'=>$repairer,));
    }

    public function repairerAbscencesAction($id){
        $em = $this->getDoctrine()->getManager();
        $repairer = $em->getRepository('HOCompanyBundle:Repairer')->find($id);
        return $this->render('HOCompanyBundle:Repairer:repairer-abscences.html.twig',array('repairer'=>$repairer,));
    }


    public function compareByYearAction(Request $request){
        $data = array();
        $abscences = array();

        $form = $this->createFormBuilder($data)
                ->add('date',\Symfony\Component\Form\Extension\Core\Type\DateType::class,array('required' => true,
                    'widget'=>'choice','format'=>'d-MM-yyyy'))
                ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $param= $form->getData();

            $repairers = $em->getRepository('HOInterventionBundle:Intervention')->findCountTasksRepairerByYear($param['date']);;
            $allAbscences = $em->getRepository('HOCompanyBundle:RepairerAbscence')->findAll(); 

            foreach ($allAbscences as $abs) {
                $isValid = true;
                if($param['date']->format('Y') != $abs->getDateBegin()->format('Y') &&
                 $param['date']->format('Y') != $abs->getDateEnd()->format('Y') ){
                    $isValid = false;
                }
                if($isValid){
                    if(!isset($abscences[$abs->getRepairer()->getId()])){
                        $abscences[$abs->getRepairer()->getId()] = array(); 
                    }
                    array_push($abscences[$abs->getRepairer()->getId()], $abs);
                }
            }
            
            

            return $this->render('HOCompanyBundle:Repairer:repairers-compare.html.twig', array('year' => $param['date']->format('Y'),
                                    'repairers'=>$repairers,
                                    'abscences'=>$abscences,));
   
        }

        return $this->render('HOCompanyBundle:Repairer:compare-year.html.twig', array('form' => $form->createView(),));
        
    }


    public function compareByMonthAction(Request $request){
        $data = array();
        $abscences = array();

        $form = $this->createFormBuilder($data)
                ->add('date',\Symfony\Component\Form\Extension\Core\Type\DateType::class,array('required' => true,
                    'widget'=>'choice','format'=>'d-MM-yyyy',))
                ->getForm();

        if($request->getMethod() == 'POST' && $form->HandleRequest($request)->isValid()){
            $em = $this->getDoctrine()->getManager();
            $param= $form->getData();
            $month = $param['date']->format('m');
            $year = $param['date']->format('Y');

            $repairers = $em->getRepository('HOInterventionBundle:Intervention')->findCountTasksRepairerByMonth($month,$year);
            $allAbscences = $em->getRepository('HOCompanyBundle:RepairerAbscence')->findAll();

            foreach ($allAbscences as $abs) {
                $isValid = true;
                if($param['date']->format('m-Y') < $abs->getDateBegin()->format('m-Y') ||
                   $param['date']->format('m-Y')  > $abs->getDateEnd()->format('m-Y') ){
                    $isValid = false;
                }
                if($isValid){
                    if(!isset($abscences[$abs->getRepairer()->getId()])){
                        $abscences[$abs->getRepairer()->getId()] = array(); 
                    }
                    array_push($abscences[$abs->getRepairer()->getId()], $abs);
                }
            }
            
            

            return $this->render('HOCompanyBundle:Repairer:repairers-compare.html.twig', array('year' => $year,
                                    'month' =>$month,
                                    'repairers'=>$repairers,
                                    'abscences'=>$abscences,));
   
        }

        return $this->render('HOCompanyBundle:Repairer:compare-month.html.twig', array('form' => $form->createView(),));
        
    }



    
}
