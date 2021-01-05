<?php 

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Game;
use App\Serializer\GameNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Serializer\Serializer;

class GameController extends AbstractController
{
	public function list(RouterInterface $router): Response
	{	
		$games = $this->getDoctrine()->getRepository(Game::class)->findAll();

		if(!$games){
			return $this->json(['success' => false], 404);
		}

		$serializer = new Serializer([new GameNormalizer($router)]);
		$gameCollection = [];
		foreach($games as $game){
			$array = $serializer -> normalize($game, null, ['circular_reference_handler' => function($object) {
				return $object->getId();
			}]);
			$gameCollection[] = $array;
		}

		return $this->json($gameCollection);
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

		// Lade (temporär) Team
		$teamId = (int)$request->request->get('team');
		if($teamId){
			$team = $this->getDoctrine()->getRepository(Team::class)->find($teamId);
			if($team){
				$request->request->set('team', $team);
			} else {
				$request->request->remove('team');
			}
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


