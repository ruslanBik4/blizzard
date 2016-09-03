<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 13.08.16
 * Time: 10:23
 */
class drawTableView
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
    private $showDiv;

    public function __construct($offset = 0, $showDiv = '')
    {
        $this->conn = DBConnection::getConnection();
        $this->offset = $offset;
        $this->showDiv = $showDiv;

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
            $this->sql = $this->sql . " LIMIT " . ($this->offset * 10) . ", 100" ;
        }

        $this->result = $this->conn->runSQL($this->sql);
    }

    public function getHeadTable( )
    {

        $text =  drawTableView::TABLE_HEAD . drawTableView::TABLE_ROW;

        $this->row = $this->conn->getRecords($this->result);

        if ($this->row) {

            foreach ($this->row as $key => $value){
                if (in_array($key, $this->exclude)) {
                    continue;
                }
                $text .= drawTableView::TABLE_CELL . $key . drawTableView::END_CELL;
            }
        } else {
            $text .= 'Not record';
        }
        $text .=  drawTableView::END_ROW . drawTableView::END_HEAD;

        return $text;

    }

    public function PrintTable($countRows)
    {
        $text = '<div class="records" id="div' . $this->offset . '"'
            . $this->showDiv . '>' . $this->getHeadTable();
        $text .= $this->drawRecords($countRows);
        $text .= drawTableView::TABLE_END  . '</div>';

        return $text;
    }

    public function drawRecords($countRows)
    {
        $text = '';
        $count = 0;

        while ( ($this->row) && ($count < $countRows) )  {
            $text .= drawTableView::TABLE_ROW;

             foreach ($this->row as $key => $value) {

                 if (in_array($key, $this->exclude)) {
                     continue;
                 }
                 $text .= drawTableView::TABLE_CELL . $value . drawTableView::END_CELL;
             }

            $text .= drawTableView::END_ROW . PHP_EOL;
            $this->row = $this->conn->getRecords($this->result);
            $count++;

         }

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