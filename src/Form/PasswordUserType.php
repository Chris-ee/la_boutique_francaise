<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('actualPassword', PasswordType::class, [
                'label' => 'Votre mot de passe actuel',
                'attr' => [
                        'placeholder' => 'Mot de passe actuel'
                    ],
                    'mapped' => false
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 4,
                        'max' => 20])
                    ],
                'first_options'  => [
                    'label' => 'Votre nouveau mot de passe', 
                    'attr' => [
                        'placeholder' => 'Choisissez votre mot de passe'
                    ],
                    'hash_property_path' => 'password'
                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmer votre nouveau mot de passe'
                    ]
                ],
                'mapped' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour le mot de passe',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->addEventListener(FormEvents::SUBMIT, function(FormEvent $event){
                // récupérer le form
                $form = $event->getForm();

                // récupérer les infos du user
                $user = $form->getConfig()->getOptions()['data'];

                // récupérer ce qui permet de vérifier l'encodage d'un mdp
                $passwordHasher = $form->getConfig()->getOptions()['passwordHasher'];
                
                // 1. Récupérer le mdp saisi par l'user (ajout) et le comparer au mdp en bdd
                
                // isPasswordValid() permet de comparer un mdp haché et un mdp récupéré (ici du fom)
                $isValid = $passwordHasher->isPasswordValid(
                    $user,
                    $form->get('actualPassword')->getData()
                );
                
                // // 2. Récupérer le mdp en bdd (finalement on le fait dans le 1.)
                // $actualDatabasePassword = $user->getPassword();
                // dd($actualDatabasePassword);

                // 3. Si c'est != envoyer une erreur
                if(!$isValid){
                    $form->get('actualPassword')->addError(new FormError("Votre mot de passe actuel n'est pas conforme. Veuillez vérifier votre saisie."));
                } 
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'passwordHasher' => null
        ]);
    }
}
