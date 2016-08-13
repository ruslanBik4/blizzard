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
    private $result;
    private $row = [];
    private $exclude = [];

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

    public function runSQL()
    {
        if (!($this->result = mysqli_query($this->conn, $this->sql))) {
            throw new Exception('SQL-query error - ' . mysqli_error($this->conn));
        };

        if (!($this->row = mysqli_fetch_assoc($this->result))) {
            throw new Exception('Not records from query !');
        }
    }

    public function getHeadTable( )
    {

        $text =  viewPayments::TABLE_HEAD . viewPayments::TABLE_ROW;

        foreach ($this->row as $key => $value){
            if (in_array($key, $this->exclude)) {
                continue;
            }
            $text .= viewPayments::TABLE_CELL . $key . viewPayments::END_CELL;
        }
        $text .=  viewPayments::END_ROW . viewPayments::END_HEAD;

        return $text;

    }

    public function PrintTable($countRows)
    {
        $text = '';
        $count = 0;

        do  {
            $text .= viewPayments::TABLE_ROW;

             foreach ($this->row as $key => $value) {

                 if (in_array($key, $this->exclude)) {
                     continue;
                 }
                 $text .= viewPayments::TABLE_CELL . $value . viewPayments::END_CELL;
             }


            $text .= viewPayments::END_ROW . PHP_EOL;

         }  while ( ($this->row=mysqli_fetch_assoc($this->result))
                    && (++$count < $countRows) );


        $text .= viewPayments::TABLE_END;

        return $text;
    }

    /**
     * @param array $exclude
     */
    public function setExclude(array $exclude)
    {
        $this->exclude = $exclude;
    }

}