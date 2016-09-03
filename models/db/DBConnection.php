<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 03.09.16
 * Time: 10:47
 */
class DBConnection
{
    static private $object = null;
    private $conn;

    /**
     * @return DBConnection|null
     */
    public static function getConnection()
    {
        if (self::$object == null) {
            self::$object = new DBConnection();
        }

        return self::$object;
    }

    private function __construct()
    {
        $this->conn = mysqli_connect(DBConfig::HOST, DBConfig::USER, DBConfig::PASSWORD, DBConfig::DATABASE);

    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        mysqli_close($this->conn);
    }

    public function runSQL($sql)
    {
        $result = mysqli_query( $this->conn, $sql );
        if (!$result) {
            throw new Exception('SQL-query error - ' . mysqli_error($this->conn));
        }

      return $result;
    }
    public function getRecords($result)
    {
        if (!($row = mysqli_fetch_assoc($result))) {
            throw new Exception('Not records from query !');
        }

        return $row;
    }
}