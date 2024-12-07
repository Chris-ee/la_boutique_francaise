<?php

namespace App\Controller;

use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }

    #[Route('/modifier-mdp', name: 'app_account_modify_pwd')]
    public function password(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        // récupérer les données de l'user actuel
        $user = $this->getUser();

        // créa du fomulaire + lier l'user + passer une option (ici UserPasswordHa... cette dépendance permet d'encoder ou vérif des mdp) pour que cela puisse être utiliser côté form
        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]);

        // le form va écouter la requete de Symfony lors de l'affichage de la route
        $form->handleRequest($request);

        // est ce que le form est soumis
        if ($form->isSubmitted() && $form->isValid()){
            // si oui rec en bdd
            $entityManager->flush();
            // envoi du mess flash
            $this->addFlash(
                'success',
                'Votre mot de passe à été changé'
            );
        }


        return $this->render('account/password.html.twig', [
            'modifyPassword' => $form->createView()
        ]);
    }
}
