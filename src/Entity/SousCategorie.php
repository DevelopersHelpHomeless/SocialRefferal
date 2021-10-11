<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SousCategorieRepository;
use App\Service\Generic\Entity\EntityBaseTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 * @Vich\Uploadable()
 */
class SousCategorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     * @Groups({"categorie:read", "ville:read"})
     */
    private $id;

    use EntityBaseTrait;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"categorie:read", "ville:read"})
     */
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="sousCategories")
     * @ORM\JoinColumn(name="categorie_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @Groups({"categorie:read", "ville:read"})
     */
    private $categorie;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Assoc", mappedBy="sousCategories", orphanRemoval=true, cascade={"persist"})
     */
    private $assocs;

    /**
     * @ORM\Column(type="integer", options={"default"="999", "unsigned"=true}, nullable=true)
     *
     * @Groups({"categorie:read", "ville:read"})
     */
    private $ordre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"categorie:read", "ville:read"})
     */
    private $pictoPath;

    /**
     * @Vich\UploadableField(mapping="subCatPicto", fileNameProperty="pictoPath")
     */
    private $pictoFile;


    public function __construct()
    {
        $this->assocs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAssocs(): ArrayCollection
    {
        return $this->assocs;
    }

    public function setAssocs(?Assoc $assocs): self
    {
        $this->assocs = $assocs;

        return $this;
    }

    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return mixed
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * @param mixed $ordre
     */
    public function setOrdre($ordre): void
    {
        $this->ordre = $ordre;
    }

    /**
     * @return mixed
     */
    public function getPictoPath()
    {
        return $this->pictoPath;
    }

    /**
     * @param mixed $pictoPath
     */
    public function setPictoPath($pictoPath): void
    {
        $this->pictoPath = $pictoPath;
    }

    /**
     * @return mixed
     */
    public function getPictoFile()
    {
        return $this->pictoFile;
    }

    /**
     * @param mixed $pictoFile
     */
    public function setPictoFile($pictoFile): void
    {
        $this->pictoFile = $pictoFile;
        if ($pictoFile) {
            $this->refreshUpdatedAt();
        }
    }
}
