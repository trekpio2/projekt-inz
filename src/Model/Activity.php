<?php
namespace App\Model;

use App\Service\Config;

class Activity
{
    private ?int $activity_id = null;
    private ?string $activity_name = null;
    private ?int $lights_level = null;
    private ?float $temperature = null;
    private ?int $feed = null;
    private ?int $filter = null;
    private ?int $pump = null;
    private ?int $is_planned = null;
    private ?string $start_time = null;
    private ?string $start_date = null;
    private ?int $period_nr = null;
    private ?string $period = null;
    private ?string $task_name = null;
    private ?int $aquarium_id = null;

    public function getActivityId(): ?int
    {
        return $this->activity_id;
    }

    public function setActivityId(?int $activity_id): Activity
    {
        $this->activity_id = $activity_id;

        return $this;
    }

    public function getPeriodNr(): ?int
    {
        return $this->period_nr;
    }

    public function setPeriodNr(?int $period_nr): Activity
    {
        $this->period_nr = $period_nr;

        return $this;
    }
    
    public function getPeriod(): ?string
    {
        return $this->period;
    }

    public function setPeriod(?string $period): Activity
    {
        $this->period = $period;

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

    public function getFeed(): ?int
    {
        return $this->feed;
    }

    public function setFeed(?int $feed): Activity
    {
        $this->feed = $feed;

        return $this;
    }

    public function getFilter(): ?int
    {
        return $this->filter;
    }

    public function setFilter(?int $filter): Activity
    {
        $this->filter = $filter;

        return $this;
    }
    
    public function getPump(): ?int
    {
        return $this->pump;
    }

    public function setPump(?int $pump): Activity
    {
        $this->pump = $pump;

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

    public function getStartTime(): ?string
    {
        return $this->start_time;
    }

    public function setStartTime(?string $start_time): Activity
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getStartDate(): ?string
    {
        return $this->start_date;
    }

    public function setStartDate(?string $start_date): Activity
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getTaskName(): ?string
    {
        return $this->task_name;
    }

    public function setTaskName(?string $task_name): Activity
    {
        $this->task_name = $task_name;

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

    public function getExecuteData()
    {
        $activityData = [];
        if(!is_null($this->lights_level))
            $activityData['lightsLevel'] = $this->lights_level;
        if(!is_null($this->temperature))
            $activityData['temperature'] = $this->temperature;
        if(!is_null($this->feed))
            $activityData['feed'] = $this->feed;
        if(!is_null($this->filter))
            $activityData['filter'] = $this->filter;
        if(!is_null($this->pump))
            $activityData['pump'] = $this->pump;
        
        return json_encode($activityData);
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
        if (isset($array['feed'])) {
            $this->setFeed($array['feed']);
        }
        if (isset($array['filter'])) {
            $this->setFilter($array['filter']);
        }
        if (isset($array['pump'])) {
            $this->setPump($array['pump']);
        }
        if (isset($array['is_planned'])) {
            $this->setIsPlanned($array['is_planned']);
        }
        if (isset($array['start_time'])) {
            $this->setStartTime($array['start_time']);
        }
        if (isset($array['start_date'])) {
            $this->setStartDate($array['start_date']);
        }
        if (isset($array['task_name'])) {
            $this->setTaskName($array['task_name']);
        }
        if (isset($array['period_nr'])) {
            $this->setPeriodNr($array['period_nr']);
        }
        if (isset($array['period'])) {
            $this->setPeriod($array['period']);
        }
        if (isset($array['aquarium_id'])) {
            $this->setAquariumId($array['aquarium_id']);
        }

        return $this;
    }

    public static function findAllAssignedToAquarium($aquarium_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM activity WHERE aquarium_id = :aquarium_id ORDER BY activity_name';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquarium_id' => $aquarium_id]);

        $activities = [];
        $activitiesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($activitiesArray as $activityArray) {
            $activities[] = self::fromArray($activityArray);
        }

        return $activities;
    }

    public static function findAllNotPlannedAssignedToAquarium($aquarium_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM activity WHERE aquarium_id = :aquarium_id AND is_planned=0  ORDER BY activity_name';
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquarium_id' => $aquarium_id]);

        $activities = [];
        $activitiesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($activitiesArray as $activityArray) {
            $activities[] = self::fromArray($activityArray);
        }

        return $activities;
    }

    public static function findAllNotPlannedAssignedToUser($user_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM activity WHERE aquarium_id IN(SELECT aquarium_id FROM aquarium WHERE user_id = :user_id) AND is_planned=0 ORDER BY activity_name';
        $statement = $pdo->prepare($sql);
        $statement->execute(['user_id' => $user_id]);

        $activities = [];
        $activitiesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($activitiesArray as $activityArray) {
            $activities[] = self::fromArray($activityArray);
        }

        return $activities;
    }

    public static function findAllPlannedAssignedToAquarium($aquarium_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        //sorting by next time execution date
        $sql = "SELECT * FROM activity WHERE aquarium_id = :aquarium_id AND is_planned=1 ORDER BY
            CASE
                WHEN start_date > CURRENT_DATE THEN start_date
                ELSE
                 CASE period
                    WHEN 'days' THEN start_date + INTERVAL FLOOR(DATEDIFF(CURRENT_DATE, start_date) / period_nr) * period_nr DAY
                    WHEN 'weeks' THEN start_date + INTERVAL FLOOR(DATEDIFF(CURRENT_DATE, start_date) / (period_nr * 7)) * (period_nr * 7) DAY
                    WHEN 'months' THEN DATE_ADD(start_date, INTERVAL FLOOR(DATEDIFF(CURRENT_DATE, start_date) / period_nr) MONTH)
                 END
            END, activity_name";
        $statement = $pdo->prepare($sql);
        $statement->execute(['aquarium_id' => $aquarium_id]);

        $activities = [];
        $activitiesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($activitiesArray as $activityArray) {
            $activities[] = self::fromArray($activityArray);
        }

        return $activities;
    }

    public static function findAllPlannedAssignedToUser($user_id): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        //sorting by next time execution date
        $sql = "SELECT * FROM activity WHERE aquarium_id IN(SELECT aquarium_id FROM aquarium WHERE user_id = :user_id) AND is_planned=1 ORDER BY
            CASE
                WHEN start_date > CURRENT_DATE THEN start_date
                ELSE
                 CASE period
                    WHEN 'days' THEN start_date + INTERVAL FLOOR(DATEDIFF(CURRENT_DATE, start_date) / period_nr) * period_nr DAY
                    WHEN 'weeks' THEN start_date + INTERVAL FLOOR(DATEDIFF(CURRENT_DATE, start_date) / (period_nr * 7)) * (period_nr * 7) DAY
                    WHEN 'months' THEN DATE_ADD(start_date, INTERVAL FLOOR(DATEDIFF(CURRENT_DATE, start_date) / period_nr) MONTH)
                 END
            END, activity_name";
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
            $sql = "INSERT INTO activity (activity_name, lights_level, temperature, feed, filter, pump, is_planned, start_time, start_date, period_nr, period, task_name, aquarium_id) VALUES (:activity_name, :lights_level, :temperature, :feed, :filter, :pump, :is_planned, :start_time, :start_date, :period_nr, :period, :task_name, :aquarium_id)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'activity_name' => $this->getActivityName(),
                'lights_level' => $this->getLightsLevel(),
                'temperature' => $this->getTemperature(),
                'feed' => $this->getFeed(),
                'filter' => $this->getFilter(),
                'pump' => $this->getPump(),
                'is_planned' => $this->getIsPlanned(),
                'start_time' => $this->getStartTime(),
                'start_date' => $this->getStartDate(),
                'task_name' => $this->getTaskName(),
                'period_nr' => $this->getPeriodNr(),
                'period' => $this->getPeriod(),
                'aquarium_id' => $this->getAquariumId(),
            ]);

            $this->setActivityId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE activity SET activity_name = :activity_name, lights_level = :lights_level, temperature = :temperature, feed = :feed, filter = :filter, pump = :pump, is_planned = :is_planned, start_time = :start_time, start_date = :start_date, period_nr = :period_nr, period = :period, task_name = :task_name, aquarium_id = :aquarium_id WHERE activity_id = :activity_id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'activity_name' => $this->getActivityName(),
                'lights_level' => $this->getLightsLevel(),
                'temperature' => $this->getTemperature(),
                'feed' => $this->getFeed(),
                'filter' => $this->getFilter(),
                'pump' => $this->getPump(),
                'is_planned' => $this->getIsPlanned(),
                'start_time' => $this->getStartTime(),
                'start_date' => $this->getStartDate(),
                'period_nr' => $this->getPeriodNr(),
                'period' => $this->getPeriod(),
                'task_name' => $this->getTaskName(),
                'aquarium_id' => $this->getAquariumId(),
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
        $this->setFeed(null);
        $this->setFilter(null);
        $this->setPump(null);
        $this->setIsPlanned(null);
        $this->setStartTime(null);
        $this->setStartDate(null);
        $this->setPeriodNr(null);
        $this->setPeriod(null);
        $this->setTaskName(null);
        $this->setAquariumId(null);
    }
}
