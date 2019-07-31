<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
//                'label' => false,
                'attr' => ['class' => 'input', 'placeholder' => 'firstname']
            ])
            ->add('name', TextType::class, [
                'attr' => ['class' => 'input', 'placeholder' => 'name']
            ])
            ->add('duckname', TextType::class, [
                'attr' => ['class' => 'input', 'placeholder' => 'duckname']
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'input', 'placeholder' => 'email']
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'input', 'placeholder' => 'password']
            ])
            ->add('picture', TextType::class, [
                'attr' => ['class' => 'input', 'placeholder' => 'picture'],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
