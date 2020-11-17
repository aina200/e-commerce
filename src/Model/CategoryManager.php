<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Connection\Database;
use Framewa\Model\Manager;

class CategoryManager extends Manager
{
    public function fetchAll(): array
    {
        $sql = 'SELECT * FROM categories';
        $q = $this->connection->prepare($sql);
        $q->execute();
        $data = $q->fetchAll(\PDO::FETCH_ASSOC);
        $categoryArray = [];
        for ($i = 0, $max = count($data); $i < $max; ++$i) {
            
            $category = new Category();
            $category->setId((int) $data[$i]['id']);
            $category->setTitle((string) $data[$i]['title']);
            
            $categoryArray[] = $category;
        }
        return $categoryArray;
    }
    
    public function findById(int $id): string//recuperer le title
    {
        $sql = 'SELECT `title` FROM `categories` WHERE categories.id = :id';
        $q = $this->connection->prepare($sql);
        
        $q->bindValue(':id', $id, \PDO::PARAM_INT);
        
        $q->execute();
        
        $data = $q->fetch(\PDO::FETCH_ASSOC);
        $category = new Category();
        $category->setTitle($data['title']);

        return $category->getTitle();
    }
}
