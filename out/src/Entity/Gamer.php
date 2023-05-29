<?php

namespace App\Entity;

use App\Repository\GamerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GamerRepository::class)]
class Gamer extends User
{
    
    #[ORM\Column(length: 255)]
    private ?string $tag = null;

    #[ORM\OneToMany(mappedBy: 'id_gamer', targetEntity: HistoriqueAchat::class)]
    private Collection $historiqueAchats;

    #[ORM\OneToMany(mappedBy: 'idGamer', targetEntity: Planning::class)]
    private Collection $plannings;

    #[ORM\OneToMany(mappedBy: 'idGamer', targetEntity: UserCourses::class)]
    private Collection $userCourses;

    #[ORM\OneToMany(mappedBy: 'idGamer', targetEntity: Membre::class)]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: 'idGamer', targetEntity: ReviewJeux::class)]
    private Collection $reviewJeuxes;

    #[ORM\OneToMany(mappedBy: 'idGamer', targetEntity: MembreGroupe::class)]
    private Collection $membreGroupes;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Tournoi::class)]
    private Collection $tournois;

    public function __construct()
    {
        $this->historiqueAchats = new ArrayCollection();
        $this->plannings = new ArrayCollection();
        $this->userCourses = new ArrayCollection();
        $this->membres = new ArrayCollection();
        $this->reviewJeuxes = new ArrayCollection();
        $this->membreGroupes = new ArrayCollection();
        $this->tournois = new ArrayCollection();
    }
    

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, HistoriqueAchat>
     */
    public function getHistoriqueAchats(): Collection
    {
        return $this->historiqueAchats;
    }

    public function addHistoriqueAchat(HistoriqueAchat $historiqueAchat): self
    {
        if (!$this->historiqueAchats->contains($historiqueAchat)) {
            $this->historiqueAchats->add($historiqueAchat);
            $historiqueAchat->setIdGamer($this);
        }

        return $this;
    }

    public function removeHistoriqueAchat(HistoriqueAchat $historiqueAchat): self
    {
        if ($this->historiqueAchats->removeElement($historiqueAchat)) {
            // set the owning side to null (unless already changed)
            if ($historiqueAchat->getIdGamer() === $this) {
                $historiqueAchat->setIdGamer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Planning>
     */
    public function getPlannings(): Collection
    {
        return $this->plannings;
    }

    public function addPlanning(Planning $planning): self
    {
        if (!$this->plannings->contains($planning)) {
            $this->plannings->add($planning);
            $planning->setIdGamer($this);
        }

        return $this;
    }

    public function removePlanning(Planning $planning): self
    {
        if ($this->plannings->removeElement($planning)) {
            // set the owning side to null (unless already changed)
            if ($planning->getIdGamer() === $this) {
                $planning->setIdGamer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCourses>
     */
    public function getUserCourses(): Collection
    {
        return $this->userCourses;
    }

    public function addUserCourse(UserCourses $userCourse): self
    {
        if (!$this->userCourses->contains($userCourse)) {
            $this->userCourses->add($userCourse);
            $userCourse->setIdGamer($this);
        }

        return $this;
    }

    public function removeUserCourse(UserCourses $userCourse): self
    {
        if ($this->userCourses->removeElement($userCourse)) {
            // set the owning side to null (unless already changed)
            if ($userCourse->getIdGamer() === $this) {
                $userCourse->setIdGamer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setIdGamer($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getIdGamer() === $this) {
                $membre->setIdGamer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReviewJeux>
     */
    public function getReviewJeuxes(): Collection
    {
        return $this->reviewJeuxes;
    }

    public function addReviewJeux(ReviewJeux $reviewJeux): self
    {
        if (!$this->reviewJeuxes->contains($reviewJeux)) {
            $this->reviewJeuxes->add($reviewJeux);
            $reviewJeux->setIdGamer($this);
        }

        return $this;
    }

    public function removeReviewJeux(ReviewJeux $reviewJeux): self
    {
        if ($this->reviewJeuxes->removeElement($reviewJeux)) {
            // set the owning side to null (unless already changed)
            if ($reviewJeux->getIdGamer() === $this) {
                $reviewJeux->setIdGamer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MembreGroupe>
     */
    public function getMembreGroupes(): Collection
    {
        return $this->membreGroupes;
    }

    public function addMembreGroupe(MembreGroupe $membreGroupe): self
    {
        if (!$this->membreGroupes->contains($membreGroupe)) {
            $this->membreGroupes->add($membreGroupe);
            $membreGroupe->setIdGamer($this);
        }

        return $this;
    }

    public function removeMembreGroupe(MembreGroupe $membreGroupe): self
    {
        if ($this->membreGroupes->removeElement($membreGroupe)) {
            // set the owning side to null (unless already changed)
            if ($membreGroupe->getIdGamer() === $this) {
                $membreGroupe->setIdGamer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tournoi>
     */
    public function getTournois(): Collection
    {
        return $this->tournois;
    }

    public function addTournoi(Tournoi $tournoi): self
    {
        if (!$this->tournois->contains($tournoi)) {
            $this->tournois->add($tournoi);
            $tournoi->setOwner($this);
        }

        return $this;
    }

    public function removeTournoi(Tournoi $tournoi): self
    {
        if ($this->tournois->removeElement($tournoi)) {
            // set the owning side to null (unless already changed)
            if ($tournoi->getOwner() === $this) {
                $tournoi->setOwner(null);
            }
        }

        return $this;
    }
}
