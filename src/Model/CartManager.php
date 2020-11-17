<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Connection\Database;
use Framewa\Model\Manager;

class CartManager extends Manager
{
    public function findById(int $id): int//recuperer le title
    {
        $sql = 'SELECT * FROM `carts` WHERE carts.user_id = :id';
        $q = $this->connection->prepare($sql);
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        $q->execute();
        $data = $q->fetch(\PDO::FETCH_ASSOC);
        $cart = new Cart();
        $cart->setUser_id((int) $data['user_id']);
      
        return $cart->getUser_id();
    }
    
    public function insertProduct(string $cart_id, string $product_id): void
    {
        $sql = 'INSERT INTO `products_carts` (`product_id`, `cart_id`) VALUES (:product_id, :cart_id)';
        $q = $this->connection->prepare($sql);
        $q->bindValue(':product_id', $product_id, \PDO::PARAM_STR);
        $q->bindValue(':cart_id', $cart_id, \PDO::PARAM_STR);

        $q->execute();
    } 
    
    public function deleteProduct(string $products_carts_id): void
    {
       $sql = 'DELETE FROM products_carts WHERE id = :id';
       $q = $this->connection->prepare($sql);
       $q->execute(['id' => $products_carts_id]);
    }
}