<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CallApi;


class HomeController extends AbstractController{

	private $callapi;

    public function __construct(CallApi $callapi)
    {

        $this->CallApi = $callapi;

    }

	/**
	* @Route("/", name="home")
	* @return Response
	**/

	public function index(): Response
	{
		// si le token est renvoyé, faire appel API
		if ( $this->CallApi->getToken() )
		{
			// token à envoyer à l'API
			$token =  $this->CallApi->getToken();

			// filtres de la requête GET
			$filters='range=0-9&sort=1&commune=33063&distance=0&inclureLimitrophes=false';

			// Appel API
			$offers= $this->CallApi->getrequest($token,$filters);
		}
		else {
			$offers=null;
			$this->addFlash('error', 'Une erreur est survenue !');
		}

		return $this->render('pages/home.html.twig',['offers' => $offers['resultats']]);
	}

}

