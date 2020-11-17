<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\Model\UserManager;
use App\Model\Product;
use App\Model\ProductManager;
use Framewa\Controller\Controller;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @return void
     */
    public function login(): void
    {
       
        if (isset($_POST['nickname']) && isset($_POST['password'])) {//est ce que la personne a entré le nickname et password
            $manager = new UserManager();
            $user = $manager->findByNickname($_POST['nickname']);
            if ($user && password_verify($_POST['password'], $user->getPassword())) {//est ce qu'il ya un user et mdp qui existe
                $this->auth->login($user->getId());
                
                $productManager = new ProductManager();

                $this->router->redirectToRoute('homepage', ['id' => $user->getId()]);//rediroger vers la homepage
            }
        }
        
        
        
        
        // $count = $productManager->countOfCart($_GET['id']);
         
        $this->displayView('views/login.phtml');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $user = new User();

        $errors = [];

        if (
            isset($_POST['nickname']) && isset($_POST['password1']) && isset($_POST['password2'])
            && $_POST['password1'] === $_POST['password2']
        ) {
            $user->setNickname($_POST['nickname']);
            $passwordHash = password_hash($_POST['password1'], PASSWORD_BCRYPT);
            if (!$passwordHash) {
                throw new \Exception('Could not encode password.');
            }
            $user->setPassword($passwordHash);

            $validationErrors = $user->getValidationErrors();
            if (empty($validationErrors)) {
                $manager = new UserManager();
                $manager->insert($user);
                header('Location: index.php');
            } else {
                $errors = array_merge($errors, $validationErrors);
            }
        }

        $this->displayView('views/register.phtml', [
            'errors' => $errors
        ]);
    }
    
    public function logout(): void
    {
        $this->auth->logout();
        $this->router->redirectToRoute('homepage');
    }
}
