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
}
$view->setSql( "select concat(e.firstname, ' ', e.lastname) as 'worker', customerName, count(orderNumber), (orderDate), avg(priceEach) as 'avgPrice', 
GROUP_CONCAT(productName SEPARATOR ', ') as 'Product',  
GROUP_CONCAT(textDescription SEPARATOR ', ') as 'Product_Line'
from employees e join customers cus on(e.employeeNumber = cus.salesRepEmployeeNumber) join orders OS using(CustomerNumber) 
join orderdetails OD using(orderNumber) join products p using(productCode) join productlines using(productLine)
where MONTH(orderDate) =12
group by worker, customerName
order by 1, orderDate, avgPrice desc" );

  $view->setExclude( ['Product', 'Product_Line']);

  $view->runSQL();

 echo $view->getHeadTable() . $view->PrintTable(10);


    $view1 = new viewPayments($conn);

  $view1->setSql( "select  concat(e.firstname, ' ', e.lastname) as 'Emplouyes',
		CONCAT_WS(', ', cus.country, IFNULL(cus.state, ''), cus.addressLine1, IFNULL(cus.addressLine2,'hide from corruption'), cus.postalCode) as 'AddressCustomers' ,
		CONCAT_WS(' ', cus.contactfirstname, cus.contactlastname ) as 'ClientName', count(*), min(orderDate), max(orderDate)
from employees e join offices o using(officeCode) join customers cus on(e.employeeNumber = cus.salesRepEmployeeNumber) join orders OS using(CustomerNumber)
group by Emplouyes
order by 1, creditLimit desc");
    
    $view1->setExclude([]);
    
    $view1->runSQL();
    
    echo $view1->getHeadTable() . $view1->PrintTable(10);
    


mysqli_close($conn);