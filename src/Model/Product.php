<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Model;

/**
 * Class Product
 * @package App\Model
 */
class Product extends Model//extension du model
{
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $title */
    private ?string $title;
    
    /** @var string|null $description */
    private ?string $description;
    
    /** @var string|null $src_img */
    private ?string $src_img;
    
    /** @var int|null $value */
    private ?int $value;
    
    /** @var int|null $stock */
    private ?int $stock;

    /**
     * @return int|null
     */
    public function getId(): ?int//recuperer l'id//retourne null ou int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void    //setId je veux savoir qui c'est (id)//:void ca retourne rien
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }
    
    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    
    /**
     * @return string|null
     */
    public function getSrc_img(): ?string
    {
        return $this->src_img;
    }

    /**
     * @param string|null $src_img
     */
    public function setSrc_img(?string $src_img): void
    {
        $this->src_img = $src_img;
    }
    
    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     */
    public function setValue(?int $value): void
    {
        $this->value = $value;
    }
    
    /**
     * @return int|null
     */
    public function getStock(): ?int
    {
        return $this->stock;
    }

    /**
     * @param int|null $stock
     */
    public function setStock(?int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function createFromArray(array $data): self//!retourne un tableau d'objet (a voir)
    {
        $product = new Product();

        $product->setId((int) $data['id']);
        $product->setTitle((string) $data['title']);
        $product->setDescription((string) $data['description']);
        $product->setSrc_img((string) $data['src_img']);
        $product->setValue((int) $data['value']);
        $product->setStock((int) $data['stock']);

        return $product;
    }
     public function getValidationErrors(): array//obligation de framework
    {
        return [];
    }
    
}
