<?php

declare(strict_types=1);

namespace App\Model;

use Framewa\Model\Model;

/**
 * Class User
 * @package App\Model
 */
class User extends Model
{
    /** @var int|null $id */
    private ?int $id;

    /** @var string|null $nickname */
    private ?string $nickname;

    /** @var string|null $password */
    private ?string $password;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        $user = new User();

        $user->setId((int) $data['id']);
        $user->setNickname((string) $data['nickname']);
        $user->setPassword((string) $data['password']);

        return $user;
    }

    /**
     * @return array<int, string>
     */
    public function getValidationErrors(): array
    {
        $err = [];

        if ($this->nickname === '' || $this->nickname === null) {
            $err[] = 'Nickname cannot be empty.';
        } else {
            $nicknameLen = strlen($this->nickname);
            if ($nicknameLen < 1 || $nicknameLen > 63) {
                $err[] = 'Nickname length cannot be less than 1 or greater than 63.';
            }
        }

        if ($this->password === '' || $this->password === null) {
            $err[] = 'Password cannot be empty';
        }

        return $err;
    }
}
