<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accountname', TextType::class, ["label" => "Account Name"])
            ->add('nickname', TextType::class, ["label" => "Nickname"])
            ->add('approvalbadge', CheckboxType::class, ["label" => "Approval Badge", "required" => FALSE])
            ->add('hasbusiness', CheckboxType::class, ["label" => "Has Business", "required" => FALSE]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
