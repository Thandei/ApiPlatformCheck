<?php

namespace App\Form;

use App\Config\SystemLogPriorityType;
use App\Entity\SystemLog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SystemLogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('priority', ChoiceType::class, ["label" => "Priority", "choices" => SystemLogPriorityType::getValuesArray()])
            ->add('content', TextareaType::class, ["label" => "Content", "attr"  => ["placeholder"=>"Write something..."]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SystemLog::class,
        ]);
    }
}
