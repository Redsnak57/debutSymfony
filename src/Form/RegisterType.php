<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("firstname", TextType::class, [
                "label" => "Votre prénom",
                "constraints" => new Length(null,2,30),
                "attr" => [
                    "placeholder" => "Merci de saisir votre prénom"
                ]
            ])
            ->add("lastname", TextType::class, [
                "label" => "Votre nom",
                "constraints" => new Length(null,3,30),
                "attr" => [
                    "placeholder" => "Merci de saisir votre nom"
                ]
            ])
            ->add('email', EmailType::class, [
                "label" =>  "Votre email",
                "constraints" => new Length(null,5,60),
                "attr" => [
                    "placeholder" => "Merci de saisir votre email"
                ]
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class, 
                "invalid_message" => "Les mots de passe ne correspondent pas",
                "required" => true,
                "first_options" => [ "label" => "Votre Mot de passe"],
                "second_options" => [ "label" => "Confirmer Mot de passe"],
            ])       
            ->add("submit", SubmitType::class, [
                "label" => "S'inscrire",
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
