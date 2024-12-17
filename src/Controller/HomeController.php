<?php

namespace App\Controller;

use App\Classe\Mail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // *** code pour envoyer un mail (à placer dans les bons controllers et adapter le contenu) ***
        // $mail = new Mail();
        // $mail->send('chris.esco06@gmail.com','John Doe', 'Bonjour, test de ma clase Mail', "Mon premier <br> email!");

        return $this->render('home/index.html.twig');
    }
}
