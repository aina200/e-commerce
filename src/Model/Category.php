<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Model;

/**
 * Class Category
 * @package App\Model
 */
class Category extends Model
{
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $title */
    private ?string $title;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
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
     * @param array<string, mixed> $data
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        $category = new Category();

        $category->setId((int) $data['id']);
        $category->setTitle((string) $data['title']);

        return $category;
    }
    
    public function getValidationErrors(): array//obligation de framework
    {
        return [];
    }
}
