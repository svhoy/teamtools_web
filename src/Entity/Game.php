<?php

declare(strict_types=1);

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */

class Game
{   
    /**
     *  @ORM\Id
     *  @ORM\GeneratedValue
     *  @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     *  @ORM\Column(type="integer")
     *  @Assert\NotBlank
     */
     protected int $spieltag;


    /**
     *  @ORM\Column(type="string", length=255)
     *  @Assert\NotBlank
     */
    protected string $gegnerName;

    /**
     *  @ORM\Column(type="datetime")
     *  @Assert\NotBlank
     */
    protected \DateTime $spieldatum;

    /**
     * @ORM\ManyToOne(targetEntity=Team::class, inversedBy="game")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $team; 

    
    public function getId():int
    {
        return $this->id;
    }

    public function getSpieltag(): int
    {
        return $this->spieltag;
    }

    public function setSpieltag($spieltag):self
    {
        $this->spieltag = intval($spieltag);
        return $this;
    }

    public function getGegnerName(): string
    {
        return $this->gegnerName;
    }

    public function setGegnerName($gegnerName):self
    {
        $this->gegnerName = $gegnerName;
        return $this;
    }

    public function getSpieldatum(): \DateTime
    {
        return $this->spieldatum;
    }

    public function setSpieldatum($spieldatum): self
    {
        $this->spieldatum = $spieldatum;
        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): self
    {
        $this->team = $team;

        return $this;
    }


}