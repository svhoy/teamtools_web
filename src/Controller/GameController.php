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
		$spieltag = $request->request->getInt('spieltag');
		$gegnerName = $request->request->get('gegnerName');

		
		$newGame = (new Game()) -> setSpieltag($spieltag)->setGegnerName($gegnerName)->setSpieldatum(new \DateTime());
		
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

	public function update(): Response
	{
		
		
	}

	public function delete(): Response
	{
		
		
	}
}

