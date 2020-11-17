<?php

declare(strict_types=1);

namespace App\Controller;

use Framewa\Controller\Controller;
use App\Model\Product;
use App\Model\ProductManager;

/**
 * Class HomepageController
 * @package App\Controller
 */
class HomepageController extends Controller
{
    /**
     * @return void
     */
    public function index(): void
    {
        if($this->auth->getCurrentUser() !== null)
        {
            $productManager = new ProductManager();
            $count = $productManager->countOfCart($_GET['id']);
            $this->displayView('views/homepage.phtml', [
                'count'=>$count]);
        }
        if($this->auth->getCurrentUser() === null)
        {
            $this->displayView('views/homepage.phtml', []);
        }
       
    }
}
