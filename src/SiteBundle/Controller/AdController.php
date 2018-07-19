<?php

namespace SiteBundle\Controller;

use DateTime;
use SiteBundle\Entity\Ad;
use SiteBundle\Entity\Picture;
use SiteBundle\Form\AdSearchType;
use SiteBundle\Form\AdType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
            $adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");
            $em = $this->getDoctrine()->getManager();

            $ad= new Ad();
            $form = $this->createForm(AdType::class, $ad);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $ad->setDateCreated(new DateTime());

                $all_picture=[];
                $i=1;
                foreach($ad->getPictures() as $file)
                {
                    $fileName = $this->generateUniqueFileName().'_'. $i . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('image_directory'), $fileName
                    );
                    $picture = new Picture();
                    $picture->setFile($fileName);
                    $picture->setAd($ad);
                    array_push($all_picture,$picture);
                    $i++;
                }
                $ad->setPictures($all_picture);

                $em->persist($ad);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Annonce enregistrée'
                );

                return $this->redirect($request->getUri());
            }
            return $this->render("@Site\Ad\add.html.twig", array(
                'form'=> $form->createView(),
                'title'=>isset($ad)?'Test de formulaire pour'.$ad->getTitle() : 'Test de formulaire',
            ));
    }

    public function listAction(Request $request)
    {
            $adRepo = $this->getDoctrine()->getRepository("SiteBundle:Ad");
            $all_ad = $adRepo->findAll();

            $ad = new ad();
            $form = $this->createForm(AdSearchType::class, $ad);
            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){
                $all_ad = $adRepo->getAdByParam(array('ad.title' => $ad->getTitle(), 'cat.id' => $ad->getCategory()));
            }

            $args = array(
                'all_ad' => $all_ad,
                'form'=>$form->createView()
            );
            return $this->render('@Site/Ad/list.html.twig', $args);
    }
    
    public function detailAction(Ad $ad){
        return $this->render('@Site/Ad/detailAd.html.twig', array('ad' => $ad));
    }
   
    public function myadsAction()
    {
            $user  =  $this->get( 'security.token_storage' )->getToken()->getUser ();
            $dql = 'SELECT ads FROM SiteBundle:Ad ads WHERE ads.user = :id_user';

            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery($dql);
            $query->setParameter('id_user', $user->getId());
            $result = $query->getResult();

            $args = array('myads' => $result);
            return $this->render('@Site/Ad/myads.html.twig', $args);
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
