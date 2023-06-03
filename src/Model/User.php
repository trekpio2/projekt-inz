<?php
namespace App\Model;

use App\Service\Config;

class User
{
    private ?int $userId = null;
    private ?string $username = null;
    private ?string $userPassword = null;
    private ?int $isAdmin = null;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): User
    {
        $this->userId = $userId;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->userPassword;
    }

    public function setUserPassword(?string $userPassword): User
    {
        $this->userPassword = $userPassword;

        return $this;
    }

    public function getIsAdmin(): ?int
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(?int $isAdmin): User
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public static function fromArray($array): User
    {
        $user = new self();
        $user->fill($array);

        return $user;
    }

    public function fill($array): User
    {
        if (isset($array['user_id']) && ! $this->getUserId()) {
            $this->setUserId($array['user_id']);
        }
        if (isset($array['username'])) {
            $this->setUsername($array['username']);
        }
        if (isset($array['user_password'])) {
            $this->setUserPassword($array['user_password']);
        }
        if (isset($array['is_admin'])) {
            $this->setIsAdmin($array['is_admin']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM user';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $users = [];
        $usersArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($usersArray as $userArray) {
            $users[] = self::fromArray($userArray);
        }

        return $users;
    }

    public static function login($username, $userPassword): ?User
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM user WHERE username = :username AND user_password = :user_password ';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            'username' => $username,
            'user_password' => $userPassword,
            ]);

        $userArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $userArray) {
            return null;
        }
        $user = User::fromArray($userArray);

        return $user;
    }
    
    public static function find($userId): ?User
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM user WHERE user_id = :userId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['userId' => $userId]);

        $userArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $userArray) {
            return null;
        }
        $user = User::fromArray($userArray);

        return $user;
    }
//FOR REGISTRATION
    public static function isUsernameInDatabase($userName)
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT user_id FROM user WHERE username = :userName';
        $statement = $pdo->prepare($sql);
        $statement->execute(['userName' => $userName]);

        if ($statement->rowCount() > 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getUserId()) {
            $sql = "INSERT INTO user (username, user_password, is_admin) VALUES (:username, :userPassword, :isAdmin)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'username' => $this->getUsername(),
                'userPassword' => $this->getUserPassword(),
                'isAdmin' => $this->getIsAdmin(),
            ]);

            $this->setUserId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE user SET username = :username, user_password = :userPassword, is_admin = :isAdmin WHERE user_id = :userId";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':username' => $this->getUserId(),
                ':userPassword' => $this->getUserPassword(),
                ':userId' => $this->getUserId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM user WHERE user_id = :userId";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':userId' => $this->getUserId(),
        ]);

        $this->setUserId(null);
        $this->setUsername(null);
        $this->setUserPassword(null);
        $this->setIsAdmin(null);
    }
}
