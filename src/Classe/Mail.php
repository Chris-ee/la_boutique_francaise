<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    public function send($to_email, $to_name, $subject, $template, $vars = null)
    {
        // récupération du template
        $content = file_get_contents(dirname(__DIR__).'/Mail/'.$template);
        
        // récupérer les variables facultatives
        if($vars){
            foreach($vars as $key => $var){
                $contentMail = str_replace('{'.$key.'}', $var, $content);
            }
        }   
        
        $mj = new Client($_ENV['MJ_APIKEY_PUBLIC'], $_ENV['MJ_APIKEY_PRIVATE'], true, ['version' => 'v3.1']);

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "nuages.modes.02@icloud.com",
                        'Name' => "La boutique Française"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 6563404,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $contentMail
                    ],
                    // 'Variables' => json_decode('{
				    //     "content": $content
				    // }', true)
                ]
            ]
        ];

        // envoi de l'email
        $response = $mj->post(Resources::$Email, ['body' => $body]);

        // lire la réponse
        $response->success() && var_dump($response->getData());
    }
}
