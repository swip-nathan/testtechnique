<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient ;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class CallApi
{
    private $params;
    private $httpClient;

    public function __construct(ContainerBagInterface $params, HttpClientInterface $httpClient)
    {

        $this->params = $params;
        $this->httpClient = $httpClient;

    }

    public function getToken()
    {

        $response = $this -> httpClient -> request ( 'POST' , 'https://entreprise.pole-emploi.fr/connexion/oauth2/access_token?realm=%2Fpartenaire', [
            'query' =>[
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->params->get('client_id'),
                    'client_secret' => $this->params->get('client_secret'),
                    'scope' => 'application_'.$this->params->get('client_id').' api_'.$this->params->get('api_name').' o2dsoffre',

                    ],
            ]);

        if(200 !== $response->getStatusCode())
        {
            return $contentType = false;
        }else
        {
            $contentType = $response->toArray();
            return $contentType['access_token'];
        }

    }

    public function getrequest($token,$filters)
    {
        $response = $this -> httpClient ->request('GET', 'https://api.emploi-store.fr/partenaire/offresdemploi/v2/offres/search?'.$filters, [
               'headers' => [
                   'Authorization' => 'Bearer '.$token
                   ],
            ]);
        $contentType = $response->toArray();
        return $contentType;

    }

}