<?php

namespace App\Entity;

use Assert\NotNull;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['property:read']],
    denormalizationContext: ['groups' => ['property:write']],
    paginationItemsPerPage: 10,
    paginationMaximumItemsPerPage: 100,
    paginationClientItemsPerPage: true,
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get',
        'patch',
        'delete'
    ],
)]
#[UniqueEntity('title')]
#[ORM\HasLifecycleCallbacks]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['media_object:read', 'property:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['media_object:read', 'property:read', 'property:write'])]
    #[
        NotBlank,
        Length(min: 5, max: 100)
    ]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Length(min: 10, max: 255)
    ]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Range(min: 20, max: 400)
    ]
    private ?int $surface = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Range(min: 1)
    ]
    private ?int $room = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Range(min: 1)
    ]
    private ?int $bedroom = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Positive
    ]
    private ?int $floor = null;

    #[ORM\Column]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Positive
    ]
    private ?int $price = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Positive
    ]
    private ?int $heat = null;

    #[ORM\Column(length: 255)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Length(min: 2, max: 30)
    ]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Length(min: 5, max: 255)
    ]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Groups(['property:read', 'property:write'])]
    #[
        NotBlank,
        Length(min: 5, max: 255),
        Regex('/^[0-9]{5}/')
    ]
    private ?string $postalcode = null;

    #[ORM\Column]
    #[Groups(['property:read', 'property:write'])]
    private ?bool $sold = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['property:read', 'property:write'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['property:read', 'property:write'])]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Options::class, inversedBy: 'properties')]
    #[Groups(['property:read', 'property:write'])]
    private Collection $options;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: MediaObject::class, cascade: ["persist", "remove"])]
    #[Groups(['property:read', 'property:write'])]
    #[ApiSubresource]
    private Collection $pictures;

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');   
        $this->options = new ArrayCollection();
        $this->pictures = new ArrayCollection();
    }


    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateModifiedDatetime() {
        // update the modified time
        $this->updatedAt = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRoom(): ?int
    {
        return $this->room;
    }

    public function setRoom(int $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getBedroom(): ?int
    {
        return $this->bedroom;
    }

    public function setBedroom(int $bedroom): self
    {
        $this->bedroom = $bedroom;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getHeat(): ?int
    {
        return $this->heat;
    }

    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalcode(): ?string
    {
        return $this->postalcode;
    }

    public function setPostalcode(string $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getcreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setcreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Options>
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Options $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options->add($option);
        }

        return $this;
    }

    public function removeOption(Options $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    /**
     * @return Collection<int, MediaObject>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(MediaObject $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures->add($picture);
            $picture->setProperty($this);
        }

        return $this;
    }

    public function removePicture(MediaObject $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProperty() === $this) {
                $picture->setProperty(null);
            }
        }

        return $this;
    }
}
