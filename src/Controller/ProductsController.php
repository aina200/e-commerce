<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Product;
use App\Model\ProductManager;
use Framewa\Controller\Controller;

class ProductsController extends Controller
{
    public function product(): void
    {
        $productManager = new ProductManager();//transform en obk=jet

        $product = $productManager->findById((int) $_GET['product_id']);//appeller une fonction

        $count = $productManager->countOfCart($_GET['id']);

        $this->displayView('views/product.phtml', [
            'title' => $product,
            'count'=>$count
            ]);
    }
    
    public function products(): void
    {
        $productManager = new ProductManager();
        
        $products = $productManager->fetchAll();
        
        $count = $productManager->countOfCart($_GET['id']);
        
        $this->displayView('views/products.phtml', [
            'products' => $products,
            'count'=>$count
            ]); 
    }
    
    public function products_categories(): void
    {
        $productManager = new ProductManager();

        $products_categories = $productManager->findJoinById((int) $_GET['category_id']);
        
        $count = $productManager->countOfCart($_GET['id']);

        $this->displayView('views/category.phtml', [
            'products_categories' => $products_categories,
            'count'=>$count
            ]); 
    }
}

