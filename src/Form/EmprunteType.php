<?php

namespace App\Form;

use App\Entity\Emprunte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmprunteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('debut',DateType::class,['widget'=>'single_text','attr'=>['class'=>'form-control']])
            ->add('fin',DateType::class,['widget'=>'single_text','attr'=>['class'=>'form-control']])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Emprunte::class,
        ]);
    }
}
