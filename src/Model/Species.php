<?php
namespace App\Model;

use App\Service\Config;

class Species
{
    private ?int $speciesId = null;
    private ?string $speciesName = null;

    public function getSpeciesId(): ?int
    {
        return $this->speciesId;
    }

    public function setSpeciesId(?int $speciesId): Species
    {
        $this->speciesId = $speciesId;

        return $this;
    }

    public function getSpeciesName(): ?string
    {
        return $this->speciesName;
    }

    public function setSpeciesName(?string $speciesName): Species
    {
        $this->speciesName = $speciesName;

        return $this;
    }

    public static function fromArray($array): Species
    {
        $species = new self();
        $species->fill($array);

        return $species;
    }

    public function fill($array): Species
    {
        if (isset($array['species_id']) && ! $this->getSpeciesId()) {
            $this->setSpeciesId($array['species_id']);
        }
        if (isset($array['species_name'])) {
            $this->setSpeciesName($array['species_name']);
        }

        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM species';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $allSpecies = [];
        $speciesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($speciesArray as $singleSpeciesArray) {
            $speciesToReturn[] = self::fromArray($speciesArray);
        }

        return $allSpecies;
    }

    public static function find($speciesId): ?Species
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM species WHERE species_id = :speciesId';
        $statement = $pdo->prepare($sql);
        $statement->execute(['speciesId' => $speciesId]);

        $speciesArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $speciesArray) {
            return null;
        }
        $species = Species::fromArray($speciesArray);

        return $species;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getSpeciesId()) {
            $sql = "INSERT INTO species (species_name) VALUES (:speciesName)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'speciesName' => $this->getSpeciesName(),
            ]);

            $this->setSpeciesId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE species SET species_name = :speciesName WHERE species_id = :speciesId";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':speciesName' => $this->getSpeciesName(),
                ':speciesId' => $this->getSpeciesId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM species WHERE species_id = :speciesId";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':speciesId' => $this->getSpeciesId(),
        ]);

        $this->setSpeciesId(null);
        $this->setSpeciesName(null);
    }
}
