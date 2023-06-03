<?php
namespace App\Model;

use App\Service\Config;
use App\Exception\NotFoundException;
use App\Model\Aquarium;
use App\Model\Animal;
use App\Model\Activity;
use App\Validator\Validator;
use App\Service\Router;
use App\Service\Templating;

class Animal
{
    private ?int $animalId = null;
    private ?string $animalName = null;
    private ?string $animalGender = null;
    private ?string $animalImage = null;
    private ?string $birthdate = null;
    private ?string $color = null;
    private ?string $speciesName = null;
    private ?int $aquariumId = null;
    
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

    public function getBirthdate(): ?string
    {
        return $this->birthdate;
    }

    public function setBirthdate(?string $birthdate): Animal
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): Animal
    {
        $this->color = $color;

        return $this;
    }

    public function getSpeciesName(): ?string
    {
        return $this->speciesName;
    }

    public function setSpeciesName(?string $speciesName): Animal
    {
        $this->speciesName = $speciesName;

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
        if (isset($array['species_name'])) {
            $this->setSpeciesName($array['species_name']);
        }
        if (isset($array['aquarium_id'])) {
            $this->setAquariumId($array['aquarium_id']);
        }
        if (isset($array['birthdate'])) {
            $this->setBirthdate($array['birthdate']);
        }
        if (isset($array['color'])) {
            $this->setColor($array['color']);
        }

        return $this;
    }

    public static function findAllInAquarium($aquariumId): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM animal WHERE aquarium_id = :aquariumId ORDER BY animal_name';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquariumId' => $aquariumId]);

        $animals = [];
        $animalsArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($animalsArray as $animalArray) {
            $animals[] = self::fromArray($animalArray);
        }

        return $animals;
    }

    public static function findAllOwnedByUser($user_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM animal WHERE aquarium_id IN(SELECT aquarium_id FROM aquarium WHERE user_id = :user_id) ORDER BY animal_name';
        $statement = $pdo->prepare($sql);
        $statement->execute(['user_id' => $user_id]);

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
    public function findAllActivity(){
        $activities = Activity::findAllAssignedToAquarium($this->getAquariumId());
        return $activities;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getAnimalId()) {
            $sql = "INSERT INTO animal (animal_name, animal_gender, animal_image, species_name, aquarium_id, birthdate, color) VALUES (:animalName, :animalGender, :animalImage, :speciesName, :aquariumId, :birthdate, :color)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'animalName' => $this->getAnimalName(),
                'animalGender' => $this->getAnimalGender(),
                'animalImage' => $this->getAnimalImage(),
                'speciesName' => $this->getSpeciesName(),
                'aquariumId' => $this->getAquariumId(),
                'birthdate' => $this->getBirthdate(),
                'color' => $this->getColor(),
            ]);

            $this->setAnimalId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE animal SET  animal_name = :animalName, animal_gender = :animalGender, animal_image = :animalImage, species_name = :speciesName, aquarium_id = :aquariumId, birthdate = :birthdate, color = :color WHERE animal_id = :animalId";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':animalName' => $this->getAnimalName(),
                ':animalGender' => $this->getAnimalGender(),
                ':animalImage' => $this->getAnimalImage(),
                ':speciesName' => $this->getSpeciesName(),
                ':aquariumId' => $this->getAquariumId(),
                ':birthdate' => $this->getBirthdate(),
                ':color' => $this->getColor(),
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
        $this->setSpeciesName(null);
        $this->setAquariumId(null);
        $this->setBirthdate(null);
        $this->setColor(null);
    }
}
