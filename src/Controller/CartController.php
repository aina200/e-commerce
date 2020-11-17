<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\Cart;
use App\Model\CartManager;
use App\Model\Product;
use App\Model\ProductManager;
use Framewa\Controller\Controller;

class CartController extends Controller
{
    /**
     * @return void
     */
    public function cart(): void
    {
        $cartManager = new CartManager();
       
        $cart = $cartManager->findById((int) $_GET['id']);
        
        $productManager = new ProductManager();
      
        $productsArray = $productManager->joinProductsInCart((int) $cart);
        
        $count = $productManager->countOfCart($_GET['id']);
        
        $this->displayView('views/cart.phtml', [
            'user_id' => $cart,
            'cartProducts' => $productsArray,
            'count'=>$count
            ]); 

    }
    
    public function addProduct(): void
    {
        $cartManager = new CartManager();
     
        $cart_product = $cartManager-> insertProduct($_GET['cart_id'], $_GET['product_id']);
        
        $productManager = new ProductManager();
        
        $products_categories = $productManager->findJoinById((int) $_GET['id']);
        
        $count = $productManager->countOfCart($_GET['id']);
        
        $this->displayView('views/category.phtml', [
            'products_categories' => $products_categories,
            'count'=>$count
            ]); 
    }
    
    public function addProductPageProducts(): void
    {
        $cartManager = new CartManager();
       
        $cart_product = $cartManager-> insertProduct($_GET['cart_id'], $_GET['product_id']);
       
        $productManager = new ProductManager();
        
        $products = $productManager->fetchAll();
        
        $count = $productManager->countOfCart($_GET['id']);
        
        $this->displayView('views/products.phtml', [
            'products' => $products,
            'count'=>$count
            ]); 
    }
    
    public function deleteProduct(): void
    {
        if (true/* Check if right user */)
        {
            $deleteCartManager = new CartManager();
           
            $deleteCartManager->deleteProduct($_GET['products_carts_id']);
            
            $this->router->redirectToRoute('cart', [
                'id' => $_GET['id']
            ]);
        }
    }
}
