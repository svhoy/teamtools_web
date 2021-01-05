<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 */

class Team 
{   

    /**
     * @ORM\OneToMany(targetEntity=Game::class, mappedBy="team")
     */
    private $game;

    public function __construct() {
        $this->game = new ArrayCollection();
    }

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
            'type' => 'team',
            'id' => $this->getId(),
            'attributes' => [
                'name' => $this->name,
            'spielklasse' => $this->spielklasse,
            ],
            'links' => [
                // TODO 
                'self' =>  '/mannschaft/' . $this->id,
             ]
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

    /**
     * @return Collection|Game[]
     */
    public function getGame(): Collection
    {
        return $this->game;
    }

    public function addGame(Game $game): self
    {
        if (!$this->game->contains($game)) {
            $this->game[] = $game;
            $game->setTeam($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->game->removeElement($game)) {
            // set the owning side to null (unless already changed)
            if ($game->getTeam() === $this) {
                $game->setTeam(null);
            }
        }

        return $this;
    }


}