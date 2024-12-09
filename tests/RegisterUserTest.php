<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterUserTest extends WebTestCase
{
    public function testSomething(): void
    {

        // 1. créer un faux client (qui se comporte comme un navigateur) et pointer vers 1 url 
        $client = static::createClient(); 
        //faire pointer le client vers une URL (donc ce sera une requete)
        $client->request('GET', '/inscription');

        // 2. remplir les champs de mon form d'inscription (email, firstname, lastname, password, confirmation du password)

        $client->submitForm('Valider', [
            'register_user[email]' => 'example_du_test@test.fr',
            'register_user[plainPassword][first]' => 123456,
            'register_user[plainPassword][second]' => 123456,
            'register_user[firstName]' => 'Julie',
            'register_user[lastName]' => 'Doe'
        ]);

        //tester la redirection
        $this->assertResponseRedirects('/login');
        // demander au client de se laisser rediriger
        $client->followRedirect();

        //3. récupérer un élément dans le DOM 
        $this->assertSelectorExists('div:contains("Votre compte est correctement créé")');
    }
}
