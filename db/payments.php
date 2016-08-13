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
$view->setSql( "select e.lastName as 'worker', customerName, count(orderNumber), (orderDate), avg(priceEach) as 'avgPrice', 
GROUP_CONCAT(productName SEPARATOR ', ') as 'Product',  
GROUP_CONCAT(textDescription SEPARATOR ', ') as 'Product_Line'
from employees e join customers cus on(e.employeeNumber = cus.salesRepEmployeeNumber) join orders OS using(CustomerNumber) 
join orderdetails OD using(orderNumber) join products p using(productCode) join productlines using(productLine)
where MONTH(orderDate) =12
group by worker, customerName
order by orderDate, avgPrice desc" );

  $view->runSQL();
  echo $view->PrintTable( ['Product', 'Product_Line']);




 mysqli_close($conn);