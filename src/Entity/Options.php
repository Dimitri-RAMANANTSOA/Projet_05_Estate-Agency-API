<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\OptionsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: OptionsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['options:read']],
    denormalizationContext: ['groups' => ['options:write']],
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
#[UniqueEntity('name')]
class Options
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['property:read', 'options:read'])]
    private ?int $id = null;

    #[ORM\Column(name: 'name', length: 255)]
    #[Groups(['property:read', 'options:read', 'options:write'])]
    #[
        NotBlank,
        Length(min: 2, max: 30)
    ]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Property::class, mappedBy: 'options')]
    #[Groups(['options:write', 'options:read'])]
    private Collection $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
            $property->addOption($this);
        }

        return $this;
    }

    public function removeProperty(Property $property): self
    {
        if ($this->properties->removeElement($property)) {
            $property->removeOption($this);
        }

        return $this;
    }
}
