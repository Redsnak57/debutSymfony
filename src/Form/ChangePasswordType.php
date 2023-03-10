<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "disabled" => true,
                "label" => "Mon email",
            ])
            ->add('firstname', TextType::class, [
                "disabled" => true,
                "label" => "Mon prénom"
            ])
            ->add('lastname', TextType::class, [
                "disabled" => true,
                "label" => "Mon nom"
            ])
            ->add('old_password', PasswordType::class, [
                "label" => "Mot de passe",
                "mapped" => false,
                "attr" => [
                    "placeholder" => "Mot de passe actuel"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                "type" => PasswordType::class,
                "mapped" => false,
                "invalid_message" => "Les mots de passe ne correspondent pas",
                "required" => true,
                "first_options" => ["label" => "Votre nouveau Mot de passe"],
                "second_options" => ["label" => "Confirmer nouveau Mot de passe"],
            ])
            ->add("submit", SubmitType::class, [
                "label" => "Mettre à jour"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
