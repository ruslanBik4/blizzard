<?php
/*
 * Напишем запрос по подсчету суммы платежей по каждому году.
 * Поскольку вычисления необходимо проводить в группах по годам,
 * то мы применим оператор GROUP BY. В поле payment_date у нас
 * записаны даты в формате YYYY-MM-DD. Если нам надо получить только год из этой записи,
 * то необходимо применить функцию YEAR, которая работает по принципу:
*/

include_once 'secret.php';
include_once 'viewPayments.php';

 $conn = mysqli_connect($host, $user, $password, $database);

try {

    $view = new viewPayments($conn);
} catch (Exception $e) {
    echo $e->getMessage();
}  catch (ExceptionDB $e) {
    echo $e->getMessage();
}  catch (ExceptionINternet $e) {
    echo $e->getMessage();
}
$view->setSql( "SELECT customerName , max(o2.orderDate), max(o1.orderDate) as DateEnd, 
 period_diff(date_format(o1.orderDate, '%y%m'), date_format(o2.orderDate,'%y%m' )) as diff
 FROM orders o1 join orders o2 using (customerNumber) join customers using (customerNumber)
WHERE o1.orderDate > o2.orderDate and  
period_diff(date_format(o1.orderDate, '%y%m'), date_format(o2.orderDate,'%y%m' )) > 3
 and not EXISTS (select * FROM orders o3 
 WHERE o3.customerNumber = o1.customerNumber and 
 o3.orderDate > o2.orderDate and o3.orderDate < o1.orderDate )
 group by 1
order by 1" );

  echo $view->PrintTable();




 mysqli_close($conn);