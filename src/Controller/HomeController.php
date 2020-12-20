<?php 

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController 
{
	public function index(): Response
	{
		$response = new Response(); 
		$response -> setContent("<p>Hello World!</p>");
		return $response;
	}
}