<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 13.08.16
 * Time: 10:23
 */
class viewPayments
{
    const TABLE_HEAD = '<table border="1"> <thead>';
    const END_HEAD   = '</thead>';
    CONST TABLE_END  = '</table>';
    const TABLE_ROW = '<tr>';
    const TABLE_CELL= '<td>';
    const END_ROW   = '</tr>';
    const END_CELL  = '</td>';

    private $sql;
    private $conn;

    public function __construct($conn)
    {

         if (!isset($conn)) {
             throw new Exception('Not connection!');
         }

        $this->conn = $conn;
    }

    /**
     * @return mixed
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @param mixed $sql
     */
    public function setSql($sql)
    {
         if(!$sql) {
            throw new Exception('SQL must have value');
        }

        $this->sql = $sql;
    }

    public function PrintTable()
    {
        if ( !( $result = mysqli_query( $this->conn, $this->sql ) ) ) {

            var_dump($result);
            die( 'SQL-query error -  ' . mysqli_error($this->conn) );
        };

        if ( !($row=mysqli_fetch_assoc($result)) ) {
            var_dump($result);
            die( 'Not records from query !');
        }

        echo viewPayments::TABLE_HEAD . viewPayments::TABLE_ROW;

        foreach ($row as $key => $value){
            echo viewPayments::TABLE_CELL . $key . viewPayments::END_CELL;
        }
        echo viewPayments::END_ROW . viewPayments::END_HEAD;

do  {
    echo viewPayments::TABLE_ROW;

     foreach ($row as $value)
          echo viewPayments::TABLE_CELL . $value . viewPayments::END_CELL;

     echo viewPayments::END_ROW . PHP_EOL;

 }  while ($row=mysqli_fetch_assoc($result));


 echo viewPayments::TABLE_END;
    }


}