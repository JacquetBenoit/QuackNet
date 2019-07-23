<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class QuackForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'label' => false,
                'attr' => ['class' => 'textarea', 'placeholder' => 'Post a new Quack'],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Post',
                'attr' => ['class' => 'button is-primary is-fullwidth'],
            ])
        ;
    }
}