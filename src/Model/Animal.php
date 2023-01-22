<?php
namespace App\Model;

use App\Service\Config;

class Animal
{
    private ?int $animalId = null;
    private ?string $animalName = null;
    private ?string $animalGender = null;
    private ?string $animalImage = null;
    private ?string $dateAdded = null;
    private ?int $speciesId = null;
    private ?int $aquariumId = null;
    private ?int $userId = null;

    
    public function getAnimalId(): ?int
    {
        return $this->animalId;
    }

    public function setAnimalId(?int $animalId): Animal
    {
        $this->animalId = $animalId;

        return $this;
    }

    public function getAnimalName(): ?string
    {
        return $this->getAnimalName;
    }

    public function setAnimalName(?string $animalName): Animal
    {
        $this->getAnimalName = $animalName;

        return $this;
    }

    public function getAnimalGender(): ?string
    {
        return $this->animalGender;
    }

    public function setAnimalGender(?string $animalGender): Animal
    {
        $this->animalGender = $animalGender;

        return $this;
    }

    public function getAnimalImage(): ?string
    {
        return $this->animalImage;
    }

    public function setAnimalImage(?string $animalImage): Animal
    {
        $this->animalImage = $animalImage;

        return $this;
    }

    public function getDateAdded(): ?string
    {
        return $this->dateAdded;
    }

    public function setDateAdded(?string $dateAdded): Animal
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    public function getSpeciesId(): ?int
    {
        return $this->speciesId;
    }

    public function setSpeciesId(?int $speciesId): Animal
    {
        $this->speciesId = $speciesId;

        return $this;
    }

    public function getAquariumId(): ?int
    {
        return $this->aquariumId;
    }

    public function setAquariumId(?int $aquariumId): Animal
    {
        $this->aquariumId = $aquariumId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(?int $userId): Animal
    {
        $this->userId = $userId;

        return $this;
    }

    public static function fromArray($array): Animal
    {
        $animal = new self();
        $animal->fill($array);

        return $animal;
    }

    public function fill($array): Animal
    {
        if (isset($array['animal_id']) && ! $this->getAnimalId()) {
            $this->setAnimalId($array['animal_id']);
        }
        if (isset($array['animal_name'])) {
            $this->setAnimalName($array['animal_name']);
        }
        if (isset($array['animal_gender'])) {
            $this->setAnimalGender($array['animal_gender']);
        }
        if (isset($array['animal_image'])) {
            $this->setAnimalImage($array['animal_image']);
        }
        if (isset($array['species_id'])) {
            $this->setSpeciesId($array['species_id']);
        }
        if (isset($array['aquarium_id'])) {
            $this->setAquariumId($array['aquarium_id']);
        }
        if (isset($array['user_id'])) {
            $this->setUserId($array['user_id']);
        }
        if (isset($array['date_added'])) {
            $this->setDateAdded($array['date_added']);
        }

        return $this;
    }

    public static function findAllInAquarium($aquariumId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM animal WHERE aquarium_id = :aquariumId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquariumId' => $aquariumId]);

        $animals = [];
        $animalsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($animalsArray as $animalArray) {
            $animals[] = self::fromArray($animalArray);
        }

        return $animals;
    }

    public static function findAllOwnedByUser($userId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM animal WHERE user_id = :userId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['userId' => $userId]);

        $animals = [];
        $animalsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($animalsArray as $animalArray) {
            $animals[] = self::fromArray($animalArray);
        }

        return $animals;
    }

    public static function find($animalId): ?Animal
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM animal WHERE animal_id = :animalId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['animalId' => $animalId]);

        $animalArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $animalArray) {
            return null;
        }
        $animal = Animal::fromArray($animalArray);

        return $animal;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getAnimalId()) {
            $sql = "INSERT INTO animal (animal_name, animal_gender, animal_image, species_id, aquarium_id, user_id, date_added) VALUES (:animalName, :animalGender, :animalImage, :speciesId, :aquariumId, :userId, :dateAdded)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'animalName' => $this->getAnimalName(),
                'animalGender' => $this->getAnimalGender(),
                'animalImage' => $this->getAnimalImage(),
                'speciesId' => $this->getSpeciesId(),
                'aquariumId' => $this->getAquariumId(),
                'userId' => $this->getUserId(),
                'dateAdded' => $this->getDateAdded(),
            ]);

            $this->setAnimalId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE animal SET  animal_name = :animalName, animal_gender = :animalGender, animal_image = :animalImage, species_id = :speciesId, aquarium_id = :aquariumId, user_id = :userId, date_added = :dateAdded WHERE animal_id = :animalId";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':animalName' => $this->getAnimalName(),
                ':animalGender' => $this->getAnimalGender(),
                ':animalImage' => $this->getAnimalImage(),
                ':speciesId' => $this->getSpeciesId(),
                ':aquariumId' => $this->getAquariumId(),
                ':userId' => $this->getUserId(),
                ':dateAdded' => $this->getDateAdded(),
                ':animalId' => $this->getAnimalId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM animal WHERE animal_id = :animalId";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':animalId' => $this->getAnimalId(),
        ]);

        $this->setAnimalId(null);
        $this->setAnimalName(null);
        $this->setAnimalGender(null);
        $this->setAnimalImage(null);
        $this->setSpeciesId(null);
        $this->setAquariumId(null);
        $this->setUserId(null);
        $this->setDateAdded(null);
    }
}
