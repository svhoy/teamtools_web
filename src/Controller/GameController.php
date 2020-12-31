<?php 

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolation;

class GameController extends AbstractController
{
	public function list(): Response
	{	
		$games = $this->getDoctrine()->getRepository(Game::class)->findAll();

		return $this->json(['Games' => $games]);
	}

	public function create(Request $request, ValidatorInterface $validator): Response
	{

		$newGame = (new Game())->setSpieldatum(new \DateTime());
		$this->setDataToGame($request->request->all(), $newGame);
		
		$errors = $validator->validate($newGame);

		if(count($errors) > 0) {
			$errorMessages = [];
			/** @var  ConstraintViolation $violation */
			foreach ($errors as $violation) {
				$errorMessages[] = $violation->getPropertyPath() . ": " . $violation->getMessage();
			}
			return $this->json(['success' => false, 'errors' => $errorMessages], 400);
		}

		$entityManager = $this->getDoctrine()->getManager();
		$entityManager->persist($newGame);
		$entityManager->flush();

		return $this->json(['success' => true, 'subscribtion' => $newGame], 201);

	}

	public function read(): Response
	{
		
		
	}

	public function update(int $id, Request $request, ValidatorInterface $validator): Response
	{
		$game = $this->getDoctrine()->getRepository(Game::class)->find($id);
		
		if (!$game) {
			return $this->json(['success' => false], 404);
		}

		$this->setDataToGame($request->request->all(), $game);
		
		$errors = $validator->validate($game);

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

		return $this->json(['success' => true, 'game' => $game], 201);

		
	}

	public function delete(): Response
	{
		
		
	}

	protected function setDataToGame(array $requestData, object $game) {
		
		foreach ($requestData as $key => $data) {
			$methodName = 'set'. ucfirst($key);
			if(!empty($data) && method_exists($game, $methodName)){
				$game->{$methodName}($data);
			}
			
		}
	}
}


