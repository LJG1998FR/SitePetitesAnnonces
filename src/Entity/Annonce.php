<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\SluggerInterface;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $datedecreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $datedemaj = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Image::class)]
    private Collection $image;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?Utilisateur $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'annonces')]
    private ?Coordonnee $coordonnee = null;

    #[ORM\Column]
    protected ?string $slugger = null;

    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->datedecreation = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDatedecreation(): ?\DateTime
    {
        return $this->datedecreation;
    }

    public function setDatedecreation(\DateTime $datedecreation): self
    {
        $this->datedecreation = $datedecreation;

        return $this;
    }

    public function getDatedemaj(): ?\DateTime
    {
        return $this->datedemaj;
    }

    public function setDatedemaj(?\DateTime $datedemaj): self
    {
        $this->datedemaj = $datedemaj;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

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

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setAnnonce($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAnnonce() === $this) {
                $image->setAnnonce(null);
            }
        }

        return $this;
    }

    public function getAuteur(): ?Utilisateur
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCoordonnee(): ?Coordonnee
    {
        return $this->coordonnee;
    }

    public function setCoordonnee(?Coordonnee $coordonnee): self
    {
        $this->coordonnee = $coordonnee;

        return $this;
    }

    public function getSlugger(): ?string
    {
        return $this->slugger;
    }

    public function setSlugger(SluggerInterface $slugger): self
    {
        $this->slugger = $slugger->slug(strtolower($this->getTitre()));

        return $this;
    }
}
