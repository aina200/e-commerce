<?php

declare(strict_types=1);

namespace App\Model;
use Framewa\Connection\Database;
use Framewa\Model\Manager;

/**
 * Class ProductManager
 * @package App\Model
 */
class ProductManager extends Manager
{
    
    public function fetchAll(): array
    {
        $sql = 'SELECT * FROM products';
        $q = $this->connection->prepare($sql);
        $q->execute();
        $data = $q->fetchAll(\PDO::FETCH_ASSOC);
        $productArray = [];
        for ($i = 0, $max = count($data); $i < $max; ++$i) {
            
            $product = new Product();
            $product->setId((int) $data[$i]['id']);
            $product->setTitle((string) $data[$i]['title']);
            $product->setDescription((string) $data[$i]['description']);
            $product->setSrc_img((string) $data[$i]['src_img']);
            $product->setValue((int) $data[$i]['value']);
            $product->setStock((int) $data[$i]['stock']);
            
            $productArray[] = $product;
        }
        
        return $productArray;
    }
    
    public function findById(int $id): string//recuperer le title
    {
        $sql = 'SELECT `title` FROM `products` WHERE products.id = :id';
        $q = $this->connection->prepare($sql);
        
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $q->execute();
        
        $data = $q->fetch(\PDO::FETCH_ASSOC);
        $product = new Product();
        $product->setTitle($data['title']);
        
        return $product->getTitle();
    }
    
    public function findJoinById(int $id): array
    {
        $sql = 'SELECT * FROM products
        JOIN products_categories ON products_categories.category_id = :id
        WHERE products.id = products_categories.product_id';
        
        $q = $this->connection->prepare($sql);
        
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $q->execute();
        
        $data = $q->fetchAll(\PDO::FETCH_ASSOC);

        $productArray = [];
        for ($i = 0, $max = count($data); $i < $max; ++$i) {
            
            $product = new Product();
           
            $product->setId((int) $data[$i]['id']);
            $product->setTitle((string) $data[$i]['title']);
            $product->setDescription((string) $data[$i]['description']);
            $product->setSrc_img((string) $data[$i]['src_img']);
            $product->setValue((int) $data[$i]['value']);
            $product->setStock((int) $data[$i]['stock']);
            
            $productArray[] = $product;
        }
        return $productArray;
    }
    
    
    public function joinProductsInCart(int $id): array
    {
        $sql = 'SELECT * FROM products
        JOIN products_carts ON products_carts.cart_id = :id
        WHERE products.id = products_carts.product_id';
        
        $q = $this->connection->prepare($sql);
       
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $q->execute();
        
        $data = $q->fetchAll(\PDO::FETCH_ASSOC);

        $productArray = [];
        for ($i = 0, $max = count($data); $i < $max; ++$i) {
            
            $product = new Product();
           
            $product->setId((int) $data[$i]['id']);
            $product->setTitle((string) $data[$i]['title']);
            $product->setDescription((string) $data[$i]['description']);
            $product->setSrc_img((string) $data[$i]['src_img']);
            $product->setValue((int) $data[$i]['value']);
            $product->setStock((int) $data[$i]['stock']);
            
            $productArray[] = $product;
        }
  
        return $productArray;
    }
     public function countOfCart(string $id):int
    {
        $sql = 'SELECT * FROM products
        JOIN products_carts ON products_carts.cart_id = :id
        WHERE products.id = products_carts.product_id';
        
        $q = $this->connection->prepare($sql);
       
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $q->execute();
        
        $data = $q->fetchAll(\PDO::FETCH_ASSOC);
        
        return count($data);
        
    }
}
