<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\Game;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class GameNormalizer implements ContextAwareNormalizerInterface
{   
    protected RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    /**
     * @param Game $object
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
            "spieltag" => $object->getSpieltag(),
            "gegnerName" => $object->getGegnerName(),
            "spieldatum" => $object->getSpieldatum(),
        ];
        $returnData['links'] = [
            "self" => $this->router->generate('readGame', ['id' => $object->getId()])
        ];
        $this->creatRelationLinks($object, $returnData);



        return $returnData;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Game;
    }

    protected function creatRelationLinks(Game $game, array &$returnData) {
        
        if($game->getTeam()) {
            $returnData['relationships'] = [
                "mannschaft" => [
                    "links" => [
                        'related' => $this->router->generate('readMannschaft',['id' => $game->getTeam()->getId()]),
                    ],
                ],
            ];
        }
        
        
    }
}
