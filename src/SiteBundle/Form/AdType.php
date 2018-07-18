<?php

namespace SiteBundle\Form;

use SiteBundle\Entity\Ad;
use SiteBundle\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',  TextType::class,array('constraints' => array(new NotBlank), 'label' => 'Titre'))
            ->add('description',  TextareaType::class, array(
                'constraints' => array(New NotBlank),
                'label' => 'Description',
                'attr' => array('rows' => 10, 'cols' => 50)))
            ->add('category', EntityType::class, array(
                'class' => 'SiteBundle\Entity\Category',
                'choice_label' => function(Category $category){
                    return $category->getLibelle();
                },
                'label' => 'Catégorie',
                'placeholder' => 'Aucune categorie',
                'required' => false))
            ->add('city',  TextType::class,array('constraints'=>array(new NotBlank), 'label' => 'Ville'))
            ->add('zip', IntegerType::class, array(
                'constraints' => array(new NotBlank),
                'label' => 'Code Postal',
                'attr' => array('max-length' => 5, 'min-length' => 5)
            ))
            ->add('price', NumberType::class, array('scale' => 2, 'constraints' => array(new NotNull), 'label' => 'Prix'))
            ->add('pictures', FileType::class, array('label' => 'Image(s) : ', 'attr' => array('class' => 'upload'), 'required' => false, 'multiple' => true, ))
            ->add('valider', SubmitType::class, array('attr' => array('class' => 'save')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Ad::class,
        ));
    }
}