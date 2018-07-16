<?php

namespace SiteBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SiteBundle\Entity\Ad;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AdController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     * @Template()
     */
    public function addAction(Request $request)
    {
        $adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");

        $adForm= new Ad();
        $form = $this->createFormBuilder($adForm)
            ->add('title',  TextType::class,array('constraints'=>array(new NotBlank), 'label' => 'Titre'))
            ->add('description',  TextareaType::class, array('constraints' => array(New NotBlank), 'label' => 'Description'))
            ->add('city',  TextType::class,array('constraints'=>array(new NotBlank), 'label' => 'city'))
            ->add('zip', TextType::class, array('constraints' => array(new NotBlank), 'label' => 'Code Postal'))
            ->add('price', IntegerType::class, array('constraints' => array(new NotNull), 'label' => 'Code Postal'))
            ->add('valider','submit')
            ->getForm();
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->persist($adForm);
            $em->flush();

            return $this->redirect($request->getUri());
        }
        return array(
            'form'=> $form->createView(),
            'title'=>isset($adForm)?'Test de formulaire pour'.$adForm->getTitle() : 'Test de formulaire',
        );
    }

    public function listAction()
    {
        $adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");
        $ads = $adRepo->findAll();

        $args = array('ads' => $ads);
        return $this->render('@Site/Ad/list.html.twig', $args);
    }
}
