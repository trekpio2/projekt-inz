<?php
namespace App\Model;

use App\Service\Config;

class Activity
{
    private ?int $activity_id = null;
    private ?string $activity_name = null;
    private ?int $lights_level = null;
    private ?float $temperature = null;
    private ?int $is_planned = null;
    private ?int $aquarium_id = null;
    private ?int $user_id = null;

    public function getActivityId(): ?int
    {
        return $this->activity_id;
    }

    public function setActivityId(?int $activity_id): Activity
    {
        $this->activity_id = $activity_id;

        return $this;
    }

    public function getActivityName(): ?string
    {
        return $this->activity_name;
    }

    public function setActivityName(?string $activity_name): Activity
    {
        $this->activity_name = $activity_name;

        return $this;
    }

    public function getLightsLevel(): ?int
    {
        return $this->lights_level;
    }

    public function setLightsLevel(?int $lights_level): Activity
    {
        $this->lights_level = $lights_level;

        return $this;
    }

    public function getTemperature(): ?float
    {
        return $this->temperature;
    }

    public function setTemperature(?float $temperature): Activity
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getIsPlanned(): ?int
    {
        return $this->is_planned;
    }

    public function setIsPlanned(?int $is_planned): Activity
    {
        $this->is_planned = $is_planned;

        return $this;
    }

    public function getAquariumId(): ?int
    {
        return $this->aquarium_id;
    }

    public function setAquariumId(?int $aquarium_id): Activity
    {
        $this->aquarium_id = $aquarium_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): Activity
    {
        $this->user_id = $user_id;

        return $this;
    }

    public static function fromArray($array): Activity
    {
        $activity = new self();
        $activity->fill($array);

        return $activity;
    }

    public function fill($array): Activity
    {
        if (isset($array['activity_id']) && ! $this->getActivityId()) {
            $this->setActivityId($array['activity_id']);
        }
        if (isset($array['activity_name'])) {
            $this->setActivityName($array['activity_name']);
        }
        if (isset($array['lights_level'])) {
            $this->setLightsLevel($array['lights_level']);
        }
        if (isset($array['temperature'])) {
            $this->setTemperature($array['temperature']);
        }
        if (isset($array['is_planned'])) {
            $this->setTemperature($array['is_planned']);
        }
        if (isset($array['aquarium_id'])) {
            $this->setAquariumId($array['aquarium_id']);
        }
        if (isset($array['user_id'])) {
            $this->setUserId($array['user_id']);
        }

        return $this;
    }

    public static function findAllAssignedToAquarium($aquarium_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM activity WHERE aquarium_id = :aquarium_id ';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquarium_id' => $aquarium_id]);

        $activities = [];
        $activitiesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($activitiesArray as $activityArray) {
            $activities[] = self::fromArray($activityArray);
        }

        return $activities;
    }

    public static function findAllAssignedToUser($user_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM activity WHERE user_id = :user_id ';
        $statement = $pdo->prepare($sql);
        $statement->execute(['user_id' => $user_id]);

        $activities = [];
        $activitiesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($activitiesArray as $activityArray) {
            $activities[] = self::fromArray($activityArray);
        }

        return $activities;
    }

    public static function find($activity_id): ?Activity
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM activity WHERE activity_id = :activity_id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['activity_id' => $activity_id]);

        $activityArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $activityArray) {
            return null;
        }
        $activity = Activity::fromArray($activityArray);

        return $activity;
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        if (! $this->getActivityId()) {
            $sql = "INSERT INTO activity (activity_name, lights_level, temperature, is_planned, aquarium_id, user_id) VALUES (:activity_name, :lights_level, :temperature, :is_planned, :aquarium_id, :user_id)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'activity_name' => $this->getActivityName(),
                'lights_level' => $this->getLightsLevel(),
                'temperature' => $this->getTemperature(),
                'is_planned' => $this->getIsPlanned(),
                'aquarium_id' => $this->getAquariumId(),
                'user_id' => $this->getUserId(),
            ]);

            $this->setActivityId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE activity SET activity_name = :activity_name, lights_level = :lights_level, temperature = :temperature, is_planned = :is_planned, aquarium_id = :aquarium_id, user_id = :user_id WHERE activity_id = :activity_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'activity_name' => $this->getActivityName(),
                'lights_level' => $this->getLightsLevel(),
                'temperature' => $this->getTemperature(),
                'is_planned' => $this->getIsPlanned(),
                'aquarium_id' => $this->getAquariumId(),
                'user_id' => $this->getUserId(),
                ':activity_id' => $this->getActivityId(),
            ]);
        }
    }

    public function delete(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM activity WHERE activity_id = :activity_id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':activity_id' => $this->getActivityId(),
        ]);

        $this->setActivityId(null);
        $this->setActivityName(null);
        $this->setLightsLevel(null);
        $this->setTemperature(null);
        $this->setIsPlanned(null);
        $this->setAquariumId(null);
        $this->setUserId(null);
    }
}
