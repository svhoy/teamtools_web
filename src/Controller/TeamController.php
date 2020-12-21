<?php 

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Team;
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
		
		$entityManager = $this->getDoctrine()->getManager();

		$team1  = (new Team)
			-> setName("1. Mannschaft")
			-> setSpielklasse("Landesliga");

		$entityManager->persist($team1);

		$team2  = (new Team)
			-> setName("2. Mannschaft")
			-> setSpielklasse("Bezirksliga");

		$entityManager->persist($team2);
		
		$team3  = (new Team)
			-> setName("1. Mannschaft")
			-> setSpielklasse("Bezirksklasse");

		$entityManager->persist($team3);

		$entityManager->flush();

		return $returnArray;
	}
}