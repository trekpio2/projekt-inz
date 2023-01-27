<?php
namespace App\Model;

use App\Service\Config;

class Plant
{
    private ?int $plantId = null;
    private ?int $plantHeight = null;
    private ?string $plantName = null;
    private ?string $plantImage = null;
    private ?string $color = null;
    private ?string $speciesName = null;
    private ?int $aquariumId = null;
    private ?int $userId = null;

    
    public function getPlantId(): ?int
    {
        return $this->plantId;
    }

    public function setPlantId(?int $plantId): Plant
    {
        $this->plantId = $plantId;

        return $this;
    }

    public function getPlantHeight(): ?int
    {
        return $this->plantHeight;
    }

    public function setPlantHeight(?int $plantHeight): Plant
    {
        $this->plantHeight = $plantHeight;

        return $this;
    }

    public function getPlantName(): ?string
    {
        return $this->plantName;
    }

    public function setPlantName(?string $plantName): Plant
    {
        $this->plantName = $plantName;

        return $this;
    }

    public function getPlantImage(): ?string
    {
        return $this->plantImage;
    }

    public function setPlantImage(?string $plantImage): Plant
    {
        $this->plantImage = $plantImage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Plant
    {
        $this->color = $color;

        return $this;
    }

    public function getSpeciesName(): ?string
    {
        return $this->speciesName;
    }

    public function setSpeciesName(?string $speciesName): Plant
    {
        $this->speciesName = $speciesName;

        return $this;
    }

    public function getAquariumId(): ?int
    {
        return $this->aquariumId;
    }

    public function setAquariumId(?int $aquariumId): Plant
    {
        $this->aquariumId = $aquariumId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): Plant
    {
        $this->userId = $userId;

        return $this;
    }

    public static function fromArray($array): Plant
    {
        $plant = new self();
        $plant->fill($array);

        return $plant;
    }

    public function fill($array): Plant
    {
        if (isset($array['plant_id']) && ! $this->getPlantId()) {
            $this->setPlantId($array['plant_id']);
        }
        if (isset($array['plant_name'])) {
            $this->setPlantName($array['plant_name']);
        }
        if (isset($array['plant_height'])) {
            $this->setPlantHeight($array['plant_height']);
        }
        if (isset($array['plant_image'])) {
            $this->setPlantImage($array['plant_image']);
        }
        if (isset($array['species_name'])) {
            $this->setSpeciesName($array['species_name']);
        }
        if (isset($array['aquarium_id'])) {
            $this->setAquariumId($array['aquarium_id']);
        }
        if (isset($array['user_id'])) {
            $this->setUserId($array['user_id']);
        }
        if (isset($array['color'])) {
            $this->setColor($array['color']);
        }

        return $this;
    }

    public static function findAllInAquarium($aquariumId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM plant WHERE aquarium_id = :aquariumId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquariumId' => $aquariumId]);

        $plants = [];
        $plantsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($plantsArray as $plantArray) {
            $plants[] = self::fromArray($plantArray);
        }

        return $plants;
    }

    public static function findAllOwnedByUser($userId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM plant WHERE user_id = :userId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['userId' => $userId]);

        $plants = [];
        $plantsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($plantsArray as $plantArray) {
            $plants[] = self::fromArray($plantArray);
        }

        return $plants;
    }

    public static function find($plantId): ?Plant
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM plant WHERE plant_id = :plantId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['plantId' => $plantId]);

        $plantArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $plantArray) {
            return null;
        }
        $plant = Plant::fromArray($plantArray);

        return $plant;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getPlantId()) {
            $sql = "INSERT INTO plant (plant_name, plant_height, plant_image, species_name, aquarium_id, user_id, color) VALUES (:plantName, :plantHeight, :plantImage, :speciesName, :aquariumId, :userId, :color)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'plantName' => $this->getPlantName(),
                'plantHeight' => $this->getPlantHeight(),
                'plantImage' => $this->getPlantImage(),
                'speciesName' => $this->getSpeciesName(),
                'aquariumId' => $this->getAquariumId(),
                'userId' => $this->getUserId(),
                'color' => $this->getColor(),
            ]);

            $this->setPlantId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE plant SET  plant_name = :plantName, plant_height = :plantHeight, plant_image = :plantImage, species_name = :speciesName, aquarium_id = :aquariumId, user_id = :userId, color = :color WHERE plant_id = :plantId";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':plantName' => $this->getPlantName(),
                ':plantHeight' => $this->getPlantHeight(),
                ':plantImage' => $this->getPlantImage(),
                ':speciesName' => $this->getSpeciesName(),
                ':aquariumId' => $this->getAquariumId(),
                ':userId' => $this->getUserId(),
                ':color' => $this->getColor(),
                ':plantId' => $this->getPlantId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM plant WHERE plant_id = :plantId";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':plantId' => $this->getPlantId(),
        ]);

        $this->setPlantId(null);
        $this->setPlantName(null);
        $this->setPlantHeight(null);
        $this->setPlantImage(null);
        $this->setSpeciesName(null);
        $this->setAquariumId(null);
        $this->setUserId(null);
        $this->setBirthdate(null);
        $this->setColor(null);
    }
}
