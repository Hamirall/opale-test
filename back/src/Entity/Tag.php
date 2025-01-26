<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["recall:read"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["recall:read"])]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    #[Groups(["recall:read"])]
    private ?string $value = null;

    /**
     * @var Collection<int, Recall>
     */
    #[ORM\ManyToMany(targetEntity: Recall::class, mappedBy: "tags")]
    private Collection $recalls;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->recalls = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, Recall>
     */
    public function getRecalls(): Collection
    {
        return $this->recalls;
    }

    public function addRecall(Recall $recall): static
    {
        if (!$this->recalls->contains($recall)) {
            $this->recalls->add($recall);
            $recall->addTag($this);
        }

        return $this;
    }

    public function removeRecall(Recall $recall): static
    {
        if ($this->recalls->removeElement($recall)) {
            $recall->removeTag($this);
        }

        return $this;
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
}
