<?php

namespace SiteBundle\Form;

use SiteBundle\Entity\Ad;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class ,array(
                    'label'  => 'Categorie :',
                    'placeholder' => 'Tous',
                    'required' => false,
                    'constraints'=>array(),
                    'class' => 'SiteBundle:Category',
                    'choice_label' => function ($cat) {
                        return $cat->getLibelle();
                    },
                    'attr' => array( 'class' => 'search-field' )
                )
            )
            ->add('title', TextType::class,array(
                    'label'  => 'Annonce :',
                    'constraints'=>array(),
                    'required' => false,
                    'attr' => array( 'class' => 'search-field' )
                )
            )
            ->add('valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ad::class,
        ));
    }
}