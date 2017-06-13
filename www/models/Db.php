<?php

namespace Models;
use \PDO;
use Components\App;

class Db
{
    /**
     * @var PDO
     */
    static private $connection;

    /**
     * @return \PDO
     */
    protected function getConnection(): \PDO
    {
        if (null === self::$connection) {
            $dbParams = App::getConfig()->getDbParams();
            self::$connection = new PDO(
                $dbParams['dsn'],
                $dbParams['user'],
                $dbParams['password']
            );
            self::$connection->exec('set names utf8');
        }

        return self::$connection;
    }

    /**
     * Select actors full name on time interval
     * from "x" to "y" years ago since current date
     * and their total fees
     *
     * @param int $from (For example: from 40 years old)
     * @param int $to (For example: to 60 years old)
     * @return array
     */
    public function getActorsFees(int $from, int $to): array
    {
        $sql = <<<SQL
          SELECT
            CONCAT(actors.name, ' ', actors.surname) AS actor_full_name, 
            SUM(films_actors.fee) AS total_fees
          FROM actors
          INNER JOIN films_actors
          ON actors.id = films_actors.actor_id
          WHERE ADDDATE(CURDATE(), INTERVAL -:to YEAR) <= actors.dob 
            AND actors.dob <= ADDDATE(CURDATE(), INTERVAL -:from YEAR)
          GROUP BY actors.id
          ORDER BY total_fees DESC;
SQL;
        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':to', $to, PDO::PARAM_INT);
        $result->bindParam(':from', $from, PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get actors full name who hasn't any person with the same surname in db
     *
     * @return array
     */
    public function getNonNameSakeActors(): array
    {
        $sql = "
          SELECT 
            ANY_VALUE(CONCAT(actors.name, ' ', actors.surname)) 
            AS actor_full_name
          FROM actors
          GROUP BY actors.surname
          HAVING COUNT(actors.surname) = 1
          ORDER BY actor_full_name;";
        $result = $this->getConnection()->prepare($sql);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get : number of films, number of payments, sum of actors fees, average fee
     * on time interval since "x" years ago till current date
     *
     * @param $interval int Years
     * @return array
     */
    public function getStudiosStatistics(int $interval): array
    {
        $sql = '
          SELECT
            studios.name AS studio,
            COUNT(DISTINCT films.id) AS number_of_films,
            COUNT(films_actors.fee) AS number_of_payments,
            SUM(films_actors.fee) AS sum_of_fees,
            ROUND(AVG(films_actors.fee)) AS average_fee
          FROM films
          INNER JOIN studios
          ON films.studio_id = studios.id
          INNER JOIN films_actors
          ON films.id = films_actors.film_id
          WHERE ADDDATE(CURDATE(), INTERVAL -:interval YEAR) <= films.release_date
          GROUP BY studios.id
          ORDER BY average_fee DESC;';
        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':interval', $interval, PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get names of studios in db
     *
     * @return array
     */
    public function getStudiosList(): array
    {
        $sql = 'SELECT studios.name FROM studios';
        $result = $this->getConnection()->prepare($sql);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get list of actors who worked on some studio and
     * number of films they was involved in
     *
     * @param $studio string Studio name
     * @return array
     */
    public function actorsOnStudiosInfo(string $studio): array
    {
        $sql = "
          SELECT
           studios.name AS studio,
           CONCAT(actors.name, ' ', actors.surname) AS actor_full_name,
           COUNT(films.title) AS number_of_films
          FROM studios
          INNER JOIN films
          ON studios.id = films.studio_id
          INNER JOIN films_actors
          ON films.id = films_actors.film_id
          INNER JOIN actors
          ON films_actors.actor_id = actors.id
          WHERE studios.name LIKE :studio
          GROUP BY studios.id, actors.id;";

        $result = $this->getConnection()->prepare($sql);
        $result->bindParam(':studio', $studio, PDO::PARAM_STR);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}