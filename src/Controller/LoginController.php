<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // gérer les erreurs
        $errors = $authenticationUtils->getLastAuthenticationError();

        // dernier username (email) utilisé
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'errors' => $errors,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods:['GET'])]
    public function logout(): never
    {
        // controller can be blank: it will never be called!
        throw new \Exception("Don't forget to activate logout in security.yaml");
    }
}
