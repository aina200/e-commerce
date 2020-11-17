<?php

/**
 * Add your application routes in this file.
 */

return [
    '/' => [
        'name' => 'homepage',
        'action' => [\App\Controller\HomepageController::class, 'index']
    ],
    '/register' => [
        'name' => 'register',
        'action' => [\App\Controller\UserController::class, 'register']
    ],
    '/login' => [
        'name' => 'login',
        'action' => [\App\Controller\UserController::class, 'login']
    ],
    '/logout' => [
        'name' => 'logout',
        'action' => [\App\Controller\UserController::class, 'logout']
    ],
    '/categories' => [
        'name' => 'categories',
        'action' => [\App\Controller\CategoryController::class, 'categories']
    ],
    '/category' => [
        'name' => 'category',
        'action' => [\App\Controller\CategoryController::class, 'category']
    ],
    '/products' => [
        'name' => 'products',
        'action' => [\App\Controller\ProductsController::class, 'products']
    ],
     '/product' => [
        'name' => 'product',
        'action' => [\App\Controller\ProductsController::class, 'product']
    ],
     '/products_categories' => [
        'name' => 'products_categories',
        'action' => [\App\Controller\ProductsController::class, 'products_categories']
    ],
     '/cart' => [
        'name' => 'cart',
        'action' => [\App\Controller\CartController::class, 'cart']
    ],
     '/addProduct' => [
        'name' => 'addProduct',
        'action' => [\App\Controller\CartController::class, 'addProduct']
    ],
     '/addProductPageProducts' => [
        'name' => 'addProductPageProducts',
        'action' => [\App\Controller\CartController::class, 'addProductPageProducts']
    ],
    '/deleteProduct' => [
        'name' => 'deleteProduct',
        'action' => [\App\Controller\CartController::class, 'deleteProduct']
    ]
];
