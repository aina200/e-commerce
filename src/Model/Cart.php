<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Model;

/**
 * Class Cart
 * @package App\Model
 */
 class Cart extends Model
 {
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $user_id */
    private ?int $user_id;
    
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
     * @return int|null
     */
    public function getUser_id(): ?int
    {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     */
    public function setUser_id(?int $user_id): void
    {
        $this->user_id = $user_id;
    }
    

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function createFromArray(array $data): self//!retourne un tableau d'objet (a voir)
    {
        $cart = new Cart();

        $cart->setId((int) $data['id']);
        $cart->setUser_id((int) $data['user_id']);
        return $cart;
    }
     public function getValidationErrors(): array//obligation de framework
    {
        return [];
    }
}
