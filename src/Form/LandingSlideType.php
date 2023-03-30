<?php

namespace App\Form;

use App\Entity\LandingSlide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LandingSlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('textcontent', TextType::class, ["label"=> "Text Content"])
            ->add('tags', TextType::class, ["label"=> "Tags"])
            ->add('image',TextType::class, ["label"=> "İmage"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LandingSlide::class,
        ]);
    }
}
