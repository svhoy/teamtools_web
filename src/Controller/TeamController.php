<?php 

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamController extends AbstractController
{
	public function list(): Response
	{	
		$teams = $this->getDoctrine()->getRepository(Team::class)->findAll();

		if(!$teams){
			return $this->json(['success' => false], 404);
		}

		$dataArray = [
            'success' => true,
            'teams' => $teams
        ];
		return $this->json($dataArray);
	}

	public function add(Request $request): Response
	{
		$teamName = $request->request->get('name');
		$liga = $request->request->get('liga');

		if(is_string($teamName)&&is_string($liga)) {
			$newTeam = (new Team()) -> setName($teamName)->setSpielklasse($liga);

			$entityManager = $this->getDoctrine()->getManager();
			$entityManager->persist($newTeam);
			$entityManager->flush();

			if($newTeam->getId()){
				return $this->json(['success' => true, 'subscribtion' => $newTeam], 201);
			}
		}

		return $this->json(['success' => false], 400);
	}
}

