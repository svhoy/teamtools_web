<?php 

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Team;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolation;

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

	public function add(Request $request, ValidatorInterface $validator): Response
	{
		$teamName = $request->request->get('name');
		$liga = $request->request->get('spielklasse');

		
		$newTeam = (new Team()) -> setName($teamName)->setSpielklasse($liga);
		
		$errors = $validator->validate($newTeam);

		if(count($errors) > 0) {
			$errorMessages = [];
			/** @var  ConstraintViolation $violation */
			foreach ($errors as $violation) {
				$errorMessages[] = $violation->getPropertyPath() . ": " . $violation->getMessage();
			}
			return $this->json(['success' => false, 'errors' => $errorMessages], 400);
		}

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($newTeam);
		$entityManager->flush();

		return $this->json(['success' => true, 'team' => $newTeam], 201);
	}

	public function update(int $id, Request $request, ValidatorInterface $validator): Response
	{
		$team = $this->getDoctrine()->getRepository(Team::class)->find($id);
		
		if (!$team) {
			return $this->json(['success' => false], 404);
		}

		$this->setDataToTeam($request->request->all(), $team);
		
		$errors = $validator->validate($team);

		if(count($errors) > 0) {
			$errorMessages = [];
			/** @var  ConstraintViolation $violation */
			foreach ($errors as $violation) {
				$errorMessages[] = $violation->getPropertyPath() . ": " . $violation->getMessage();
			}
			return $this->json(['success' => false, 'errors' => $errorMessages], 400);
		}

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->flush();

		return $this->json(['success' => true, 'team' => $team], 201);

		
	}

	protected function setDataToTeam(array $requestData, object $team) {
		
		foreach ($requestData as $key => $data) {
			$methodName = 'set'. ucfirst($key);
			if(!empty($data) && method_exists($team, $methodName)){
				$team->{$methodName}($data);
			}
			
		}
	}
}

