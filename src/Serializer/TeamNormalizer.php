<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Team;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TeamNormalizer implements ContextAwareNormalizerInterface
{   
    protected RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @param Team $object
     * @param $format
     * @param $context
     * @return array
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        $returnData = [];
        $returnData['type'] = "team"; 
        $returnData['id'] = $object->getId();
        $returnData['attributes'] = [
            "teamName" => $object->getName(),
            "spielklasse" => $object->getSpielklasse(),
        ];
        $returnData['links'] = [
            "self" => $this->router->generate('readMannschaft', ['id' => $object->getId()])
        ];
        $this->creatRelationLinks($object, $returnData);



        return $returnData;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Team;
    }

    protected function creatRelationLinks(Team $team, array &$returnData) {
        
        if($team->getGame()) {
            $returnData['relationships'] = [
                "games" => [
                    "links" => [
                        'related' => $this->router->generate('games',['id' => $team->getGame()->getId()]),
                    ],
                ],
            ];
        }
        
        
    }
}
