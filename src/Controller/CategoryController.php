<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Category;
use App\Model\CategoryManager;
use App\Model\Product;
use App\Model\ProductManager;
use Framewa\Controller\Controller;


class CategoryController extends Controller
{
    /**
     * @return void
     */
    public function category(): void
    {
        $categoryManager = new CategoryManager();//transform en obk=jet

        $category = $categoryManager->findById((int) $_GET['id']);//appeller une fonction
       
        // $productManager = new ProductManager();
        
        // $count = $productManager->countOfCart($_GET['id']);
        // var_dump($count);
        // var_dump($category);
        // die;
        $this->displayView('views/category.phtml', [
            'title' => $category,
            'count'=>$count
            
            ]); 
    }
    
    public function categories(): void
    {
        $categoryManager = new CategoryManager();
        
        $categories = $categoryManager->fetchAll();
        
        $productManager = new ProductManager();
        $count = $productManager->countOfCart($_GET['id']);
        
        $this->displayView('views/categories.phtml', [
            'categories' => $categories,
            'count'=>$count
            ]); 
    }

}
