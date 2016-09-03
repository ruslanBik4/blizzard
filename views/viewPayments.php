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
    private $result;
    private $offset;
    private $row = [];
    private $exclude = [];

    static public $countObject = 0;
    private $conn;

    public function __construct($offset = 0)
    {
        $this->conn = DBConnection::getConnection();
        $this->offset = $offset;

        self::$countObject ++;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        switch ($name) {
//            case 'sql':
//                $this->sql = $value;
//                break;
            default:
                $this->$name = $value;
        }
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
//        $this->setExclude( [] );
        self::$countObject ++;
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
        if ($this->offset) {
            $this->sql = $this->sql . " LIMIT " . (($this->offset-1) * 10) . ", 100" ;
        }

        $this->result = $this->conn->runSQL($this->sql);
    }

    public function getHeadTable( )
    {

        $text =  viewPayments::TABLE_HEAD . viewPayments::TABLE_ROW;

        $this->row = $this->conn->getRecords($this->result);

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

         }  while ( ($this->row=$this->conn->getRecords($this->result))
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