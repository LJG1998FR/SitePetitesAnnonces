<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 400)]
    private ?string $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Annonce $annonce = null;

    #[ORM\ManyToOne(inversedBy: 'commentaires')]
    private ?Utilisateur $auteur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $datedecreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $datedemaj = null;

    public function __construct()
    {
        $this->datedecreation = new \DateTime;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getAnnonce(): ?Annonce
    {
        return $this->annonce;
    }

    public function setAnnonce(?Annonce $annonce): self
    {
        $this->annonce = $annonce;

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
}
