<?php

namespace HOCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DefaultController extends Controller
{
   public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $moderators = $em->getRepository('HOUserBundle:User')->findAll();
        return $this->render('HOCompanyBundle:Default:mod.html.twig',array('moderators'=>$moderators,));
    }


   public function addModeratorAction(Request $request){
      
    	$userData = array();
        $roles = array( 1 =>'GESTIONNAIRE D\'INTERVENTION', 2 =>'ALERTEUR',);
  
    	$form = $this->createFormBuilder($userData)
    		->add('name',TextType::class)
    		->add('email',EmailType::class)
            ->add('role',ChoiceType::class, array('choices' => $roles,))
            ->add('service',EntityType::class,array(
                    'class'    => 'HOCompanyBundle:Service',
                    'choice_label' => function ($service) {
                            return $service->getName();
                        },
                    'required' => true, 
                    'expanded' => false,
                    'multiple' => false ,))
    		->getForm();

    	$form->handleRequest($request);

    	if($form->isSubmitted() && $form->isValid()){
            $pass = $this->generatePassword();

    		$userManager = $this->container->get('fos_user.user_manager');
    		$data= $form->getData();
            $user = $userManager->createUser();
            $user->setUsername($data['name']);
            $user->setEmail($data['email']);
            $user->setPlainPassword($pass);
            if($data['service']){
                $user->setService($data['service']);
            }
            

            if($data['role']==1){
                $user->addRole('ROLE_MODERATOR');
            }
            else{
                $user->addRole('ROLE_USER');
            }
            
           
            $user->setEnabled(true);

            $userManager->updateUser($user);

            //envoie par email le mot de passe utilisateur? pour le moment affiche en flash
            $message = "l'utilisateur ".$user->getUsername()." à pour mot de passe ".$pass;
            $request->getSession()
            ->getFlashBag()
            ->add('success', $message);
            return $this->redirectToRoute('ho_moderator_homepage');
        }

        return $this->render('HOCompanyBundle:Default:create-mod.html.twig',array('form' => $form->createView(), ));

    }


    public function disableModeratorAction($id){
    	$em = $this->getDoctrine()->getManager();
        $mod = $em->getRepository('HOUserBundle:User')->find($id); 

        if($mod){
            $mod->setEnabled(false);
            $em->merge($mod);
            $em->flush();
        }

        return $this->redirectToRoute('ho_moderator_homepage');
    }

    public function enableModeratorAction($id){
    	$em = $this->getDoctrine()->getManager();
        $mod = $em->getRepository('HOUserBundle:User')->find($id); 

        if($mod){
            $mod->setEnabled(true);
            $em->merge($mod);
            $em->flush();
        }

        return $this->redirectToRoute('ho_moderator_homepage');
    }

    public function deleteModeratorAction($id){
    	$em = $this->getDoctrine()->getManager();
        $mod = $em->getRepository('HOUserBundle:User')->find($id); 

        if($mod){
            $em->remove($mod);
            $em->flush();
        }

        return $this->redirectToRoute('ho_moderator_homepage');
    }

     public function generatePassword(){
        $string = bin2hex(openssl_random_pseudo_bytes(4)); // 8 chars long
        $special = array('!','@','#','$','%','&');
        $random = rand(0,5);
        return 'NO1'.$string.$special[$random];
    }
}
