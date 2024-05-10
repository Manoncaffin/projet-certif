<?php

namespace App\Entity;

use App\Repository\VolumeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VolumeRepository::class)]
class Volume
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
    #[ORM\OneToMany(targetEntity: Announce::class, mappedBy: 'volume')]
    private Collection $announces;

    public function __construct()
    {
        $this->announces = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getName();
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
            $announce->setVolume($this);
        }

        return $this;
    }

    public function removeAnnounce(Announce $announce): static
    {
        if ($this->announces->removeElement($announce)) {
            // set the owning side to null (unless already changed)
            if ($announce->getVolume() === $this) {
                $announce->setVolume(null);
            }
        }

        return $this;
    }
}
