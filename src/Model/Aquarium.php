<?php
namespace App\Model;

use App\Service\Config;

class Aquarium
{
    private ?int $aquarium_id = null;
    private ?string $aquariumName = null;
    private ?string $ip = null;
    private ?float $aquariumLength = null;
    private ?float $aquariumWidth = null;
    private ?float $aquariumHeight = null;
    private ?float $aquariumVolume = null;
    private ?int $userId = null;

    public function getAquariumId(): ?int
    {
        return $this->aquarium_id;
    }

    public function setAquariumId(?int $aquarium_id): Aquarium
    {
        $this->aquarium_id = $aquarium_id;

        return $this;
    }

    public function getAquariumName(): ?string
    {
        return $this->aquariumName;
    }

    public function setAquariumName(?string $aquariumName): Aquarium
    {
        $this->aquariumName = $aquariumName;

        return $this;
    }

    public function getAquariumLength(): ?float
    {
        return $this->aquariumLength;
    }

    public function setAquariumLength(?float $aquariumLength): Aquarium
    {
        $this->aquariumLength = $aquariumLength;

        return $this;
    }

    public function getAquariumWidth(): ?float
    {
        return $this->aquariumWidth;
    }

    public function setAquariumWidth(?float $aquariumWidth): Aquarium
    {
        $this->aquariumWidth = $aquariumWidth;

        return $this;
    }

    public function getAquariumHeight(): ?float
    {
        return $this->aquariumHeight;
    }

    public function setAquariumHeight(?float $aquariumHeight): Aquarium
    {
        $this->aquariumHeight = $aquariumHeight;

        return $this;
    }

    public function getAquariumVolume(): ?float
    {
        return $this->aquariumVolume;
    }

    public function setAquariumVolume(?float $aquariumVolume): Aquarium
    {
        $this->aquariumVolume = $aquariumVolume;

        return $this;
    }

    public function getIP(): ?string
    {
        return $this->ip;
    }

    public function setIP(?string $ip): Aquarium
    {
        $this->ip = $ip;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): Aquarium
    {
        $this->userId = $userId;

        return $this;
    }

    public static function fromArray($array): Aquarium
    {
        $aquarium = new self();
        $aquarium->fill($array);

        return $aquarium;
    }

    public function fill($array): Aquarium
    {
        if (isset($array['aquarium_id']) && ! $this->getAquariumId()) {
            $this->setAquariumId($array['aquarium_id']);
        }
        if (isset($array['aquarium_name'])) {
            $this->setAquariumName($array['aquarium_name']);
        }
        if (isset($array['aquarium_length'])) {
            $this->setAquariumLength($array['aquarium_length']);
        }
        if (isset($array['aquarium_width'])) {
            $this->setAquariumWidth($array['aquarium_width']);
        }
        if (isset($array['aquarium_height'])) {
            $this->setAquariumHeight($array['aquarium_height']);
        }
        if (isset($array['aquarium_volume'])) {
            $this->setAquariumVolume($array['aquarium_volume']);
        }
        if (isset($array['ip'])) {
            $this->setIP($array['ip']);
        }
        if (isset($array['user_id'])) {
            $this->setUserId($array['user_id']);
        }

        return $this;
    }

    public static function findAquariumsOwnedByUser($userId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM aquarium WHERE user_id = :userId ORDER BY aquarium_name';
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':userId' => $userId,
        ]);

        $aquariums = [];
        $aquariumsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($aquariumsArray as $aquariumArray) {
            $aquariums[] = self::fromArray($aquariumArray);
        }

        return $aquariums;
    }

    public static function find($aquarium_id): ?Aquarium
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM aquarium WHERE aquarium_id = :aquarium_id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquarium_id' => $aquarium_id]);

        $aquariumArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $aquariumArray) {
            return null;
        }
        $aquarium = Aquarium::fromArray($aquariumArray);

        return $aquarium;
    }

    public static function isAquariumNameInDatabase($aquarium_name, $user_id, $aquarium_id=null)
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = '';
        if($aquarium_id == null) {
            $sql = 'SELECT * FROM aquarium WHERE aquarium_name = :aquarium_name AND user_id = :user_id';

        }
        else {
            $sql = 'SELECT * FROM aquarium WHERE aquarium_name = :aquarium_name AND user_id = :user_id AND aquarium_id != :aquarium_id';
        }
        
        $statement = $pdo->prepare($sql);
        
        if($aquarium_id == null) {
            $statement->execute(['aquarium_name' => $aquarium_name, 'user_id' => $user_id]);
        } else {
            $statement->execute(['aquarium_name' => $aquarium_name, 'user_id' => $user_id, 'aquarium_id' => $aquarium_id]);
        }

        if ($statement->rowCount() > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getAquariumId()) {
            $sql = "INSERT INTO aquarium (aquarium_name, aquarium_length, aquarium_width, aquarium_height, aquarium_volume, ip, user_id) VALUES (:aquariumName, :aquariumLength, :aquariumWidth, :aquariumHeight, :aquariumVolume, :ip, :userId)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'aquariumName' => $this->getAquariumName(),
                'aquariumLength' => $this->getAquariumLength(),
                'aquariumWidth' => $this->getAquariumWidth(),
                'aquariumHeight' => $this->getAquariumHeight(),
                'aquariumVolume' => $this->getAquariumVolume(),
                'ip' => $this->getIP(),
                'userId' => $this->getUserId(),
            ]);

            $this->setAquariumId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE aquarium SET aquarium_name = :aquariumName, aquarium_length = :aquariumLength, aquarium_width = :aquariumWidth, aquarium_height = :aquariumHeight, aquarium_volume = :aquariumVolume, ip = :ip, user_id = :userId WHERE aquarium_id = :aquarium_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':aquariumName' => $this->getAquariumName(),
                ':aquariumLength' => $this->getAquariumLength(),
                ':aquariumWidth' => $this->getAquariumWidth(),
                ':aquariumHeight' => $this->getAquariumHeight(),
                ':aquariumVolume' => $this->getAquariumVolume(),
                ':ip' => $this->getIP(),
                ':userId' => $this->getUserId(),
                ':aquarium_id' => $this->getAquariumId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM aquarium WHERE aquarium_id = :aquarium_id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':aquarium_id' => $this->getAquariumId(),
        ]);

        $this->setAquariumId(null);
        $this->setAquariumName(null);
        $this->setAquariumLength(null);
        $this->setAquariumWidth(null);
        $this->setAquariumHeight(null);
        $this->setAquariumVolume(null);
        $this->setIP(null);
        $this->setUserId(null);
    }
}
