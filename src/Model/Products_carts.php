<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Model;

/**
 * Class  Products_carts
 * @package App\Model
 */
 class Products_carts extends Model
 {
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $product_id */
    private ?int $product_id;
    
     /** @var string|null $cart_id */
    private ?int $cart_id;
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
    public function getProduct_id(): ?int
    {
        return $this->product_id;
    }

    /**
     * @param int|null $product_id
     */
    public function setProduct_id(?int $product_id): void
    {
        $this->product_id = $product_id;
    }
    
     /**
     * @return int|null
     */
    public function getCart_id(): ?int
    {
        return $this->cart_id;
    }

    /**
     * @param int|null $cart_id
     */
    public function setCart_id(?int $cart_id): void
    {
        $this->cart_id = $cart_id;
    }
    
    

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function createFromArray(array $data): self//!retourne un tableau d'objet (a voir)
    {
        $product = new Products_carts();

        $product->setId((int) $data['id']);
        $product->setProduct_id((int) $data['product_id']);
        $product->setCart_id((int) $data['cart_id']);
        return $product;
    }
}
