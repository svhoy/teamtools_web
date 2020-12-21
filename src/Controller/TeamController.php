<?php 

namespace App\Controller;

use App\Model\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractController
{
	public function list(): Response
	{
		$dataArray = [
            'success' => true,
            'teams' => $this ->generateTeam()
        ];
		return $this->json($dataArray);
	}

	protected function generateTeam():array {
		$returnArray = [];

		$returnArray[]  = (new Team)
			-> setName("1. Mannschaft")
			-> setSpielklasse("Landesliga");

		$returnArray[]  = (new Team)
			-> setName("2. Mannschaft")
			-> setSpielklasse("Bezirksliga");
		
		$returnArray[]  = (new Team)
			-> setName("1. Mannschaft")
			-> setSpielklasse("Bezirksklasse");

		return $returnArray;
	}
}