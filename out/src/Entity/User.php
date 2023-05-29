<?php

namespace App\Entity;

use App\Repository\Entity\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"discriminator", type:"string")]
#[ORM\DiscriminatorMap(["Gamer" => Gamer::class, "Coach" => Coach::class])]
class User 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_profile = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column]
    private ?float $point = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CommentaireNews::class)]
    private Collection $commentaireNews;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $about = null;

    #[ORM\OneToMany(mappedBy: 'userid', targetEntity: HistoriquePoint::class)]
    private Collection $historiquePoints;


    #[ORM\OneToMany(mappedBy: 'idJeux', targetEntity: Jeux::class)]
    private Collection $reviewJeuxes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo_couverture = null;

    #[ORM\Column]
    private ?bool $bannir = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_creation = null;


    public function __construct()
    {
        $this->commentaireNews = new ArrayCollection();
        $this->historiquePoints = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPhotoProfil(): ?string
    {
        return $this->photo_profile;
    }

    public function setPhotoProfil(?string $photo_profile): self
    {
        $this->photo_profile = $photo_profile;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getPoint(): ?float
    {
        return $this->point;
    }

    public function setPoint(float $point): self
    {
        $this->point = $point;

        return $this;
    }

    /**
     * @return Collection<int, CommentaireNews>
     */
    public function getCommentaireNews(): Collection
    {
        return $this->commentaireNews;
    }

    public function addCommentaireNews(CommentaireNews $commentaireNews): self
    {
        if (!$this->commentaireNews->contains($commentaireNews)) {
            $this->commentaireNews->add($commentaireNews);
            $commentaireNews->setUser($this);
        }

        return $this;
    }

    public function removeCommentaireNews(CommentaireNews $commentaireNews): self
    {
        if ($this->commentaireNews->removeElement($commentaireNews)) {
            // set the owning side to null (unless already changed)
            if ($commentaireNews->getUser() === $this) {
                $commentaireNews->setUser(null);
            }
        }

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection<int, HistoriquePoint>
     */
    public function getHistoriquePoints(): Collection
    {
        return $this->historiquePoints;
    }

    public function addHistoriquePoint(HistoriquePoint $historiquePoint): self
    {
        if (!$this->historiquePoints->contains($historiquePoint)) {
            $this->historiquePoints->add($historiquePoint);
            $historiquePoint->setUserid($this);
        }

        return $this;
    }

    public function removeHistoriquePoint(HistoriquePoint $historiquePoint): self
    {
        if ($this->historiquePoints->removeElement($historiquePoint)) {
            // set the owning side to null (unless already changed)
            if ($historiquePoint->getUserid() === $this) {
                $historiquePoint->setUserid(null);
            }
        }

        return $this;
    }

    public function getReviewJeuxes(): Collection
    {
        return $this->reviewJeuxes;
    }

    public function setReviewJeuxes(Collection $reviewJeuxes): void
    {
        $this->reviewJeuxes = $reviewJeuxes;
    }
    public function getPhotoCouverture(): ?string
    {
        return $this->photo_couverture;
    }

    public function setPhotoCouverture(?string $photo_couverture): self
    {
        $this->photo_couverture = $photo_couverture;

        return $this;
    }

    public function isBannir(): ?bool
    {
        return $this->bannir;
    }

    public function setBannir(bool $bannir): self
    {
        $this->bannir = $bannir;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTimeInterface $date_creation): self
    {
        $this->date_creation = $date_creation;

        return $this;

    }

}
