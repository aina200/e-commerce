<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Manager;

/**
 * Class UserManager
 * @package App\Model
 */
class UserManager extends Manager
{
    public function insert(User $user): void
    {
        $sql = 'INSERT INTO `users` (`nickname`, `password`) VALUES (:nickname, :password)';
        $q = $this->connection->prepare($sql);

        $q->bindValue(':nickname', $user->getNickname(), \PDO::PARAM_STR);
        $q->bindValue(':password', $user->getPassword(), \PDO::PARAM_STR);

        $q->execute();
        
        $sql = 'SELECT `id` FROM `users` WHERE users.nickname = :nickname';
        $q = $this->connection->prepare($sql);
        $q->bindValue(':nickname', $user->getNickname(), \PDO::PARAM_STR);
        $q->execute();
        
        $userArray = $q->fetch(\PDO::FETCH_ASSOC);
       
        $sql = 'INSERT INTO `carts` (`user_id`) VALUES (:user_id)';
       
        $q = $this->connection->prepare($sql);
        $q->bindValue(':user_id', $userArray['id'], \PDO::PARAM_STR);

        $q->execute();
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        $sql = 'SELECT * FROM `users` WHERE users.id = :id';
        $q = $this->connection->prepare($sql);

        $q->bindValue(':id', $id, \PDO::PARAM_INT);

        $q->execute();

        $userArray = $q->fetch(\PDO::FETCH_ASSOC);
        if (!$userArray || empty($userArray)) {
            return null;
        }

        return User::createFromArray($userArray);
    }

    /**
     * @param string $nickname
     * @return User|null
     */
    public function findByNickname(string $nickname): ?User
    {
        $sql = 'SELECT * FROM `users` WHERE users.nickname = :nickname';
        $q = $this->connection->prepare($sql);

        $q->bindValue(':nickname', $nickname, \PDO::PARAM_STR);

        $q->execute();

        $userArray = $q->fetch(\PDO::FETCH_ASSOC);
        if (!$userArray || empty($userArray)) {
            return null;
        }

        return User::createFromArray($userArray);
    }
    
}
