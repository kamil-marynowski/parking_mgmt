<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ParkingArea;
use Core\Repository;
use PDO;

final class ParkingAreaRepository extends Repository
{
    private const TABLE = 'parking_areas';

    private PDO $database;

    public function __construct()
    {
        $this->database = $this->connectToDatabase();
    }

    public function findAll(): array
    {
        $query = 'SELECT * FROM ' . self::TABLE;
        $statement = $this->database->prepare($query);
        $statement->execute();

        $statement->setFetchMode(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC

        $data = $statement->fetchAll();

        $collection = [];
        foreach ($data as $modelData) {
            $parkingArea = new ParkingArea();
            $parkingArea->setId($modelData['id']);
            $parkingArea->setName($modelData['name']);
            $parkingArea->setWeekdaysHourlyRate($modelData['weekdays_hourly_rate']);
            $parkingArea->setWeekendHourlyRate($modelData['weekend_hourly_rate']);
            $parkingArea->setDiscountPercentage($modelData['discount_percentage']);

            $collection[] = $parkingArea;
        }

        return $collection;
    }

    public function insert(array $data): void
    {
        $query = 'INSERT INTO ' . self::TABLE . ' (';

        $dataIterator = 0;
        foreach ($data as $key => $value) {
            if ($dataIterator === count($data) - 1) {
                $query .= $key;

                break;
            }

            $query .= $key . ', ';
            $dataIterator++;
        }

        $query .= ') VALUES (';

        $dataIterator = 0;
        foreach ($data as $key => $value) {
            if ($dataIterator === count($data) - 1) {
                $query .= ':' . $key;

                break;
            }

            $query .= ':' . $key . ', ';
            $dataIterator++;
        }

        $query .= ')';

        $stmt = $this->database->prepare($query);
        $stmt->execute($data);


    }

    public function getParkingAreaWithMaxId(): ?ParkingArea
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' ORDER BY id DESC LIMIT 1';

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($row)) {
            return null;
        }

        $parkingArea = new ParkingArea();
        $parkingArea->setId($row['id']);
        $parkingArea->setName($row['name']);
        $parkingArea->setWeekdaysHourlyRate($row['weekdays_hourly_rate']);
        $parkingArea->setWeekendHourlyRate($row['weekend_hourly_rate']);
        $parkingArea->setDiscountPercentage($row['discount_percentage']);

        return $parkingArea;
    }

    public function findById(int $id): ?ParkingArea
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE id = ' . $id;

        $stmt = $this->database->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($row)) {
            return null;
        }

        $parkingArea = new ParkingArea();
        $parkingArea->setId($row['id']);
        $parkingArea->setName($row['name']);
        $parkingArea->setWeekdaysHourlyRate($row['weekdays_hourly_rate']);
        $parkingArea->setWeekendHourlyRate($row['weekend_hourly_rate']);
        $parkingArea->setDiscountPercentage($row['discount_percentage']);

        return $parkingArea;
    }

    public function deleteById(int $id): void
    {
        $query = 'DELETE FROM ' . self::TABLE . ' WHERE id = ' . $id;

        $stmt = $this->database->prepare($query);
        $stmt->execute();
    }

    public function update(int $id, array $data): void
    {
        $sql = 'UPDATE ' . self::TABLE . ' SET ';

        $dataIterator = 0;
        foreach ($data as $key => $value) {
            if ($dataIterator === count($data) - 1) {
                $sql .= $key . '=:' . $key . ' ';
                break;
            }

            $sql .= $key . '=:' . $key . ', ';
            $dataIterator++;
        }

        $sql .= 'WHERE id=:id';

        $data['id'] = $id;
        $stmt= $this->database->prepare($sql);
        $stmt->execute($data);
    }

}