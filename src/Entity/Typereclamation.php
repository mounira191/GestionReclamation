<?php

namespace App\Entity;

use App\Repository\TypereclamationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: TypereclamationRepository::class)]
class Typereclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_reclamation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $priorite = null;

    #[Ignore]
    #[ORM\OneToMany(mappedBy: 'Typereclamation', targetEntity: Reclamation::class)]
    private Collection $reclamations; 

    public function __construct()
    {
        $this->reclamations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypereclamation(): ?string
    {
        return $this->type_reclamation;
    }

    public function setTypereclamation(?string $type_reclamation): self
    {
        $this->type_reclamation = $type_reclamation;

        return $this;
    }

    public function getPriorite(): ?string
    {
        return $this->priorite;
    }

    public function setPriorite(?string $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }
    /**
     * @return Collection<int, Reclamation>
     */
    public function getReclamations(): Collection
    {
        return $this->Reclamations;
    }

    public function addReclamation(Reclamation $reclamation): self
    {
        if (!$this->reclamations->contains($reclamation)) {
            $this->reclamations->add($reclamation);
            $reclamation->setTypereclamation($this);
        }

        return $this;
    }

    public function removeReclamation(Reclamation $reclamation): self
    {
        if ($this->reclamations->removeElement($reclamation)) {
            // set the owning side to null (unless already changed)
            if ($reclamation->getTypereclamation() === $this) {
                $reclamation->setTypereclamation(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this-> type_reclamation;
    }
    
}
