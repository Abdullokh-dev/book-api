<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get', 'post'
    ],
    itemOperations: ['delete', 'get', 'put'],
    denormalizationContext: ['groups' => ['book:write']],
    normalizationContext: ['groups' => ['book:read']]
)]

#[ApiFilter(SearchFilter::class, properties : [
    'id' => 'exact',
    'name' => 'partial',
    'category' => 'exact'
])]

#[ApiFilter(OrderFilter::class, properties: ['id', 'name'])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['book:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['book:read', 'book:write'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['book:read', 'book:write'])]
    private $description;

    #[ORM\Column(type: 'text')]
    #[Groups(['book:read', 'book:write'])]
    private $text;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:read', 'book:write'])]
    private $category;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
