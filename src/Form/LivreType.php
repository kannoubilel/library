<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('nbPages',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('dateEdition',DateType::class,['widget'=>'single_text','attr'=>['class'=>'form-control']])
            ->add('nbExemplaire',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('prix',NumberType::class,['attr'=>['class'=>'form-control']])
            ->add('isbn',TextType::class,['attr'=>['class'=>'form-control']])
            ->add('categorie',EntityType::class,['attr'=>['class'=>'form-control'],
                'class'=>Categorie::class,
                'multiple'=>false,
                'expanded'=>false,
                'choice_label'=>'designation'])
            ->add('editeur',EntityType::class,['attr'=>['class'=>'form-control'],
                'class'=>Editeur::class,
                'multiple'=>false,
                'expanded'=>false
                ])
            ->add('auteurs',EntityType::class,[
                'class'=>Auteur::class,
                'multiple'=>true,
                'expanded'=>false,
                'choice_label'=>function($auteur){
                    return $auteur->getPrenom().$auteur->getNom();
                },
                'attr'=>['class'=>'form-control']
            ])
            ->add('image',TextType::class,['attr'=>['class'=>'form-control']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
