<?php
/*
 * Напишем запрос по подсчету суммы платежей по каждому году.
 * Поскольку вычисления необходимо проводить в группах по годам,
 * то мы применим оператор GROUP BY. В поле payment_date у нас
 * записаны даты в формате YYYY-MM-DD. Если нам надо получить только год из этой записи,
 * то необходимо применить функцию YEAR, которая работает по принципу:
*/

include_once 'autoload.php';

?>

    <input type="button" onclick="div1.style.display='block'; div2.style.display='none';" value = '1'/>
    <input type="button" onclick="div2.style.display='block'; div1.style.display='none';" value = '2'/>
    <a href="payments.php?offset=3"> 3</a>
    <input type="button" onclick="div4.style.display='block';" value = '4'/>
<?php

 echo viewPayments::$countObject;

try {

    $view = new viewPayments( (isset($_REQUEST['offset']) ? $_REQUEST['offset'] : 0) );
} catch (Exception $e) {
    echo $e->getMessage();
}
$view->sql = ( "select  concat(e.firstname, ' ', e.lastname) as 'Emplouyes'
from employees e order by 1" );

  $view->setExclude( ['Product', 'Product_Line']);

  $view->runSQL();

$view1 = clone $view;

 echo '<div id="div1">' .  $view->getHeadTable() . $view->PrintTable(10) . '</div>';



//    $view1->runSQL();

//     $view1->setExclude( ['worker', 'customerName', 'count(orderNumber)',
//     'orderDate', 'avgPrice' ]);

    echo '<div id="div2" style="display:none">' .  $view1->getHeadTable() . $view1->PrintTable(10) . '</div>';
    

 echo $view::$countObject . ', ' . $view1::$countObject ;
