<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;

class HomeControllerTest extends WebTestCase
{


    public function testgetToken()
    {
    	$client = HttpClient::create();


    	// Reponse OK
        $response = $client -> request ( 'POST' , 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire', [
            'query' =>[
                    'grant_type' => 'client_credentials',
                    'client_id' => 'PAR_nathantest_52cd52c04ec7bf2c8fef112489a858b4a44613a292dfcb3f3f786159cf1136bf',
                    'client_secret' => '3b527eae2824336eade09260fb77a86d0ccc330e4ac85fbf9dbd0800d55d1f41',
                    'scope' => 'application_PAR_nathantest_52cd52c04ec7bf2c8fef112489a858b4a44613a292dfcb3f3f786159cf1136bf api_offresdemploiv2 o2dsoffre',
                    ],
            ]);

        $this->assertEquals(200, $response->getStatusCode());

        // Reponse fausse
        $response = $client -> request ( 'POST' , 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire');

        $this->assertEquals(400, $response->getStatusCode());
    }
}