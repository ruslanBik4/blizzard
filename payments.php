<?php
/*
 * Напишем запрос по подсчету суммы платежей по каждому году.
 * Поскольку вычисления необходимо проводить в группах по годам,
 * то мы применим оператор GROUP BY. В поле payment_date у нас
 * записаны даты в формате YYYY-MM-DD. Если нам надо получить только год из этой записи,
 * то необходимо применить функцию YEAR, которая работает по принципу:
*/

include_once 'autoload.php';

 $offset = isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0;
 $navigator = new navigatorView($_REQUEST['offset']);
 echo $navigator->drawNavigator();

try {

    $view = new drawTableView( $offset );
} catch (Exception $e) {
    echo $e->getMessage();
}
$view->sql = ( "select  concat(e.firstname, ' ', e.lastname) as 'Emplouyes'
from employees e order by 1" );

  $view->setExclude( ['Product', 'Product_Line']);

  $view->runSQL();


 echo $view->PrintTable(10);

 $view1 = new drawTableView( $offset+1, 'style="display:none"' );

$view1->sql = ( "select  concat(e.firstname, ' ', e.lastname) as 'Emplouyes'
from employees e order by 1" );

 $view1->runSQL();

 echo $view1->PrintTable(10);

