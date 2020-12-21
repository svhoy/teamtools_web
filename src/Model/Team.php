<?php

declare(strict_types=1);

namespace App\Model;

use JsonSerializable;

class Team implements \JsonSerializable
{
    protected string $name;

    protected string $spielklasse; 

    
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'spielkalsse' => $this->spielklasse,
        ];
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