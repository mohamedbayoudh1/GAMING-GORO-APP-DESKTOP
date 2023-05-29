<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nompost = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contenu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbr_like = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Groupe $idGroupe = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNompost(): ?string
    {
        return $this->nompost;
    }

    public function setNompost(string $nompost): self
    {
        $this->nompost = $nompost;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getNbrLike(): ?int
    {
        return $this->nbr_like;
    }

    public function setNbrLike(int $nbr_like): self
    {
        $this->nbr_like = $nbr_like;

        return $this;
    }

    public function getIdGroupe(): ?Groupe
    {
        return $this->idGroupe;
    }

    public function setIdGroupe(?Groupe $idGroupe): self
    {
        $this->idGroupe = $idGroupe;

        return $this;
    }
}
