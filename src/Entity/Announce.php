<?php

namespace App\Entity;

use App\Repository\AnnounceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnnounceRepository::class)]
class Announce
{
    public function __toString()
    {
        return (string) $this->getId();
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\Column]
    // private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(length: 255)]
    private ?string $geographicalArea = null;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    #[ORM\Column(length: 255, nullable: true)]
    private $description;

    #[ORM\ManyToOne(inversedBy: 'announces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'announce')]
    private Collection $messages;

    /**
     * @var Collection<int, PrivateMessage>
     */
    #[ORM\OneToMany(targetEntity: PrivateMessage::class, mappedBy: 'announce', orphanRemoval: true)]
    private Collection $privateMessages;

    #[ORM\ManyToOne(inversedBy: 'announces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ClassificationMaterial $classification = null;

    #[ORM\ManyToOne(inversedBy: 'announces')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Material $material = null;

    /**
     * @var Collection<int, File>
     */
    #[ORM\OneToMany(targetEntity: File::class, mappedBy: 'announce')]
    private Collection $photo;

    #[ORM\Column (nullable: true)]
    private ?int $number = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'announces')]
    private ?Volume $volume = null;

    #[ORM\Column(length: 255)]
    private ?string $status = 'en attente';

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->messages = new ArrayCollection();
        $this->privateMessages = new ArrayCollection();
        $this->photo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getGeographicalArea(): ?string
    {
        return $this->geographicalArea;
    }

    public function setGeographicalArea(string $geographicalArea): static
    {
        $this->geographicalArea = $geographicalArea;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setAnnounce($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getAnnounce() === $this) {
                $message->setAnnounce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrivateMessage>
     */
    public function getPrivateMessages(): Collection
    {
        return $this->privateMessages;
    }

    public function addPrivateMessage(PrivateMessage $privateMessage): static
    {
        if (!$this->privateMessages->contains($privateMessage)) {
            $this->privateMessages->add($privateMessage);
            $privateMessage->setAnnounce($this);
        }

        return $this;
    }

    public function removePrivateMessage(PrivateMessage $privateMessage): static
    {
        if ($this->privateMessages->removeElement($privateMessage)) {
            // set the owning side to null (unless already changed)
            if ($privateMessage->getAnnounce() === $this) {
                $privateMessage->setAnnounce(null);
            }
        }

        return $this;
    }

    public function getClassification(): ?ClassificationMaterial
    {
        return $this->classification;
    }

    public function setClassification(?ClassificationMaterial $classification): static
    {
        $this->classification = $classification;

        return $this;
    }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): static
    {
        $this->material = $material;

        return $this;
    }

    /**
     * @return Collection<int, File>
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(File $photo): static
    {
        if (!$this->photo->contains($photo)) {
            $this->photo->add($photo);
            $photo->setAnnounce($this);
        }

        return $this;
    }

    public function removePhoto(File $photo): static
    {
        if ($this->photo->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getAnnounce() === $this) {
                $photo->setAnnounce(null);
            }
        }

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getVolume(): ?Volume
    {
        return $this->volume;
    }

    public function setVolume(?Volume $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
