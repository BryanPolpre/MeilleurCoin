<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\Ad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AdController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request)
    {
        $adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");

        $adForm= new Ad();
        $form = $this->createFormBuilder($adForm)
            ->add('title',  TextType::class,array('constraints'=>array(new NotBlank), 'label' => 'Titre'))
            ->add('description',  TextareaType::class, array(
                'constraints' => array(New NotBlank),
                'label' => 'Description',
                'attr' => array('rows' => 10, 'cols' => 50)))
            ->add('city',  TextType::class,array('constraints'=>array(new NotBlank), 'label' => 'city'))
            ->add('zip', TextType::class, array('constraints' => array(new NotBlank), 'label' => 'Code Postal'))
            ->add('price', IntegerType::class, array('constraints' => array(new NotNull), 'label' => 'Prix'))
            ->add('valider', SubmitType::class, array('attr' => array('class' => 'save')))
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $adForm->setDateCreated(new DateTime());
            $em->persist($adForm);
            $em->flush();

            return $this->redirect($request->getUri());
        }
        return $this->render("@Site\Ad\add.html.twig", array(
            'form'=> $form->createView(),
            'title'=>isset($adForm)?'Test de formulaire pour'.$adForm->getTitle() : 'Test de formulaire',
        ));
    }

    public function listAction()
    {
        $adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");
        $ads = $adRepo->findAll();

        $args = array('ads' => $ads);
        return $this->render('@Site/Ad/list.html.twig', $args);
    }
    
    public function detailAction(Request $request){
        /*$adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");
        $adForm= new Ad();
        $form->handleRequest($request);*/

        $em = $this->getDoctrine()->getManager();
        $adRepo = $em->getRepository('SiteBundle:Ad');
        $this->$ads = $adRepo->findAll();

        return $this->render('@Site/default/detailAd.html.twig', $ads);
    }
}
