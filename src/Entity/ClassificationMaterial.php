<?php

namespace App\Entity;

use App\Repository\ClassificationMaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassificationMaterialRepository::class)]
class ClassificationMaterial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Announce>
     */
    #[ORM\OneToMany(targetEntity: Announce::class, mappedBy: 'classification')]
    private Collection $announces;

    public function __construct()
    {
        $this->announces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Announce>
     */
    public function getAnnounces(): Collection
    {
        return $this->announces;
    }

    public function addAnnounce(Announce $announce): static
    {
        if (!$this->announces->contains($announce)) {
            $this->announces->add($announce);
            $announce->setClassification($this);
        }

        return $this;
    }

    public function removeAnnounce(Announce $announce): static
    {
        if ($this->announces->removeElement($announce)) {
            // set the owning side to null (unless already changed)
            if ($announce->getClassification() === $this) {
                $announce->setClassification(null);
            }
        }

        return $this;
    }
}
