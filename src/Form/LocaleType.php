<?php

namespace App\Form;

use App\Entity\Locale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocaleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, ["label" => "Language Code"])
            ->add('flag', TextType::class, ["label" => "Flag Path"])
            ->add('name', TextType::class, ["label" => "Language Name"])
            ->add('systemsdefault', CheckboxType::class, ["label" => "Set the language option to be added as the system default.", "required" => FALSE]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Locale::class,
        ]);
    }
}
