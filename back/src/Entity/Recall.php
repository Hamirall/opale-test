<?php

namespace App\Entity;

use App\Repository\RecallRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecallRepository::class)]
class Recall
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["recall:read"])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["recall:read"])]
    private ?string $uri = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(["recall:read"])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["recall:read"])]
    private ?string $extUrl = null;

    #[ORM\Column(length: 50)]
    #[Groups(["recall:read"])]
    private ?string $importId = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["recall:read"])]
    private ?string $imageUri = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(["recall:read"])]
    private ?string $url = null;

    /**
     * @var Collection<int, Tag>
     */
    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: "recalls")]
    #[Groups(["recall:read"])]
    private Collection $tags;

    #[ORM\Column(length: 255)]
    #[Groups(["recall:read"])]
    private ?string $productName = null;

    /**
     * @var Collection<int, Country>
     */
    #[ORM\ManyToMany(targetEntity: Country::class, inversedBy: "recalls")]
    #[Groups(["recall:read"])]
    private Collection $manufacturerCountry;

    #[ORM\ManyToOne]
    private ?Country $country = null;

    #[ORM\ManyToOne]
    private ?Language $language = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->manufacturerCountry = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri(string $uri): static
    {
        $this->uri = $uri;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getExtUrl(): ?string
    {
        return $this->extUrl;
    }

    public function setExtUrl(string $extUrl): static
    {
        $this->extUrl = $extUrl;

        return $this;
    }

    public function getImportId(): ?string
    {
        return $this->importId;
    }

    public function setImportId(?string $importId): static
    {
        $this->importId = $importId;

        return $this;
    }

    public function getImageUri(): ?string
    {
        return $this->imageUri;
    }

    public function setImageUri(?string $imageUri): static
    {
        $this->imageUri = $imageUri;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getManufacturerCountry(): Collection
    {
        return $this->manufacturerCountry;
    }

    public function addManufacturerCountry(Country $manufacturerCountry): static
    {
        if (!$this->manufacturerCountry->contains($manufacturerCountry)) {
            $this->manufacturerCountry->add($manufacturerCountry);
        }

        return $this;
    }

    public function removeManufacturerCountry(
        Country $manufacturerCountry
    ): static {
        $this->manufacturerCountry->removeElement($manufacturerCountry);

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): static
    {
        $this->language = $language;

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
