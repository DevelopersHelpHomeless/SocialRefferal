<?php

namespace App\Entity;

use App\Service\Generic\Entity\EntityBaseTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ville
 *
 * @ORM\Table(name="ville")
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
{
    use EntityBaseTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom", type="string", length=64, nullable=false, unique=true)
     */
    private $nom;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }


}