<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\Question;
use SiteBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Email;
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
            ->add('username',  TextType::class,array(
                'constraints'=>array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 50))),
                'label' => 'Nom d\'utilisateur'))
            ->add('email',  TextType::class,array(
                'constraints'=>array(
                    new NotBlank, 
                    new Length(array('min' => 5, 'max' => 255)),                    
                    new Email(array(
                        'message' => 'The email "{{ value }}" is not a valid email.',
                        'checkMX' => true))),
                'label' => 'Email'))
            ->add('password',  PasswordType::class,array(
                'constraints'=>array(
                    new NotBlank, 
                    new Length(array('min' => 5, 'max' => 255))),
                'label' => 'Mot de passe'))
            ->add('question', EntityType::class, array(
                'class' => 'SiteBundle\Entity\Question',
                'choice_label' => function(Question $question){
                    return $question->getLibelle();
                },
                'label' => 'Question de sécurité',
                'required' => true))
            ->add('reponse', TextType::class, array(
                'constraints' => array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 50))
                ),
                'label' => 'Réponse de sécurité'))
            ->add('valider', SubmitType::class, array('attr' => array('class' => 'save')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $userForm->setDateRegistered(new DateTime());

            $em->persist($userForm);
            $em->flush();
            return $this->redirect($request->getUriForPath('/'));
        }
        return $this->render("@Site\User\createUser.html.twig", array('form'=> $form->createView()));
    }

    public function connectAction(Request $request)
    {
        $userRepo = $this->getDoctrine()->getRepository("SiteBundle:User");
        $userForm = new User();

        $form = $this->createFormBuilder($userForm)
            ->add('username',  TextType::class,array(
                'constraints'=>array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 50))),
                'label' => 'Nom d\'utilisateur'))
            ->add('password',  PasswordType::class,array(
                'constraints'=>array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 255))),
                'label' => 'Mot de passe'))
            ->add('valider', SubmitType::class, array('attr' => array('class' => 'save')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $userRepo->findBy(array('username' => $form->getData('username')));

            $em = $this->getDoctrine()->getManager();
            $userForm->setDateRegistered(new DateTime());
            $em->persist($userForm);
            $em->flush();

            return $this->redirect($request->getUri());
        }
        return $this->render("@Site\User\createUser.html.twig", array('form'=> $form->createView()));
    }

    public function resetAction(Request $request)
    {
        $userRepo = $this->getDoctrine()->getRepository("SiteBundle:User");
        $userForm = new User();

        $form = $this->createFormBuilder($userForm)
            ->add('username',  TextType::class, array(
                'constraints' => array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 255))),
                'label' => "Nom d'utilisateur"))
                ->add('question', EntityType::class, array(
                'class' => 'SiteBundle\Entity\Question',
                'choice_label' => function(Question $question){
                    return $question->getLibelle();
                },
                'label' => 'Question de sécurité',
                'required' => true))
            ->add('reponse', TextType::class, array(
                'constraints' => array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 50))
                ),
                'label' => 'Réponse de sécurité'))
            ->add('password',  PasswordType::class,array(
                'constraints'=>array(
                    new NotBlank,
                    new Length(array('min' => 5, 'max' => 255))),
                'label' => 'Nouveau mot de passe'))
            ->add('valider', SubmitType::class, array('attr' => array('class' => 'save')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $user = $userRepo->findBy(array('username' => $form->getData()->getUsername()));

            if($userForm->getQuestion()->getLibelle() != $user[0]->getQuestion()->getLibelle() || $userForm->getReponse() != $user[0]->getReponse()){
                $form->addError(new FormError("La question et/ou la réponse n'est pas la bonne"));
                return $this->render("@Site\Security\\reset.html.twig", array('form'=> $form->createView()));
            } else{
                $em = $this->getDoctrine()->getManager();

                $user[0]->setPasswordWithoutCrypt($userForm->getPassword());
                $em->persist($user[0]);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Changement de mot de passe validé'
                );
                return $this->redirect($request->getUri());
            }


        }
        return $this->render("@Site\Security\\reset.html.twig", array('form'=> $form->createView()));
    }
    
}
//$2y$10$ThFZzwt.emb8FtOIKx6Zf.JZitUeJFCG72k1OYinxyVB1rnxPzOAe
//$2y$10$ThFZzwt.emb8FtOIKx6Zf.JZitUeJFCG72k1OYinxyVB1rnxPzOAe
