<?php
/*
 * Напишем запрос по подсчету суммы платежей по каждому году.
 * Поскольку вычисления необходимо проводить в группах по годам,
 * то мы применим оператор GROUP BY. В поле payment_date у нас
 * записаны даты в формате YYYY-MM-DD. Если нам надо получить только год из этой записи,
 * то необходимо применить функцию YEAR, которая работает по принципу:
*/

 include_once 'secret.php';

 const TABLE_HEAD = '<table border="1"> <thead>';
 const END_HEAD   = '</thead>';
 CONST TABLE_END  = '</table>';
 const TABLE_ROW = '<tr>';
 const TABLE_CELL= '<td>';
 const END_ROW   = '</tr>';
 const END_CELL  = '</td>';


 $conn = mysqli_connect($host, $user, $password, $database);

 $sql  = 'SELECT o.officeCode as office_id, COUNT(w.employeeNumber) as worker_count 
FROM offices o JOIN employees w using(officeCode) GROUP BY 1';

if ( !( $result = mysqli_query( $conn, $sql ) ) ) {

    die( 'SQL-query eorror -  ' . mysqli_error($conn) );
};

if ( !($row=mysqli_fetch_assoc($result)) ) {
    die( 'Not records from query !');
}

echo TABLE_HEAD .TABLE_ROW;

foreach ($row as $key => $value){
    echo TABLE_CELL . $key . END_CELL;
}

echo END_ROW . END_HEAD;

do  {
    echo TABLE_ROW;

     foreach ($row as $value)
          echo TABLE_CELL . $value . END_CELL;

     echo END_ROW . PHP_EOL;

 }  while ($row=mysqli_fetch_assoc($result));


 echo TABLE_END;
 mysqli_close($conn);