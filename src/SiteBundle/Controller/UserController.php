<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Description of UserController
 *
 * @author Administrateur
 */
class UserController extends Controller {

    public function createAction(Request $request){
        
        $userRepo = $this->getDoctrine()->getRepository("SiteBundle:User");
        $userForm = new User();
        
        $form = $this->createFormBuilder($userForm)
            ->add('username',  TextType::class,array('constraints'=>array(new NotBlank, new Length(array('min' => 5, 'max' => 50))), 'label' => 'Nom d\'utilisateur'))
            ->add('email',  TextType::class,array('constraints'=>array(new NotBlank, new Length(array('min' => 5, 'max' => 255))), 'label' => 'Email'))
            ->add('password',  PasswordType::class,array('constraints'=>array(new NotBlank, new Length(array('min' => 5, 'max' => 255))), 'label' => 'Mot de passe'))
            ->add('valider', SubmitType::class, array('attr' => array('class' => 'save')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $userForm->setDateRegistered(new DateTime());
            //$userForm->setRoles(array((new Role(1, "test")), new Role(2, "test2")));
            $em->persist($userForm);
            $em->flush();

            return $this->redirect($request->getUri());
        }
        return $this->render("@Site\User\createUser.html.twig", array('form'=> $form->createView()));
    }
    
}
