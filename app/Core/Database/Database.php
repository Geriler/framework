<?php namespace Core\Database;

use PDO;

class Database
{
    private $pdo;
    private static $instant;

    private function __construct()
    {
        $this->pdo = new PDO(
            (getenv('DB_DRIVER') .
            ':host=' . getenv('DB_HOST') .
            ((!empty(getenv('DB_PORT'))) ? (';port=' . getenv('DB_PORT')) : '') .
            ';dbname=' . getenv('DB_DATABASE')),
            getenv('DB_USER'), getenv('DB_PASSWORD')
        );
        $this->pdo->exec('SET NAMES UTF8');
    }

    public function query(string $sql, array $params = [], string $className = 'stdClass')
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);
        var_dump($sth->errorInfo());
        exit;
        if ($result === false) return null;
        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    public static function getInstant()
    {
        if (self::$instant == null) {
            self::$instant = new self();
        }
        return self::$instant;
    }
}
