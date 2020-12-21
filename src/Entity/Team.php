<?php

declare(strict_types=1);

namespace App\Entity;

use JsonSerializable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */

class Team implements \JsonSerializable
{   
    /**
     *  @ORM\Id
     *  @ORM\GeneratedValue
     *  @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     *  @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank
     */
    protected string $name;

    /**
     *  @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank
     */
    protected string $spielklasse; 

    
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'spielkalsse' => $this->spielklasse,
        ];
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name):self
    {
        $this->name = $name;
        return $this;
    }

    public function getSpielklasse(): string
    {
        return $this->spielklasse;
    }

    public function setSpielklasse($spielklasse): self
    {
        $this->spielklasse = $spielklasse;
        return $this;
    }


}