<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractController
{
	public function list(): Response
	{
		$dataArray = [
            'success' => true,
            'teams' => [

            ]
        ];
		return $this->json($dataArray);
	}
}