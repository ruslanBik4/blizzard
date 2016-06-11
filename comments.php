<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 04.06.16
 * Time: 13:27
 */

function GetStringEmploument($emploument)
{

    return $emploument ? 'работает' : 'свободен';
}

function GetRealValue($arrValues, $field)
{
    if ( !isset($arrValues[$field]) )
        return '-';

    switch ($field) {
        case 'emploument':
            return GetStringEmploument($arrValues[$field]);
        case 'salary':
            return (isset($arrValues['symbol']) ? $arrValues['symbol'] : 'UAH '). $arrValues[$field];
        case 'age':
            return $arrValues[$field] . ' лет';
        default:
            return $arrValues[$field];
    }
}
 const USER_RIGHT = 'right of fine live';

 $names = array(
     'George' => array(
                        'age' => 42,
                        'emploument' => true,
                        'salary' => 120,
                        'symbol' => '$',
                        'expirience' => 5,
                        'hobby' => <<<HOBBY
рыбалка
охота
велопутешествия
HOBBY
,
     ),
     'Ivan'   => array( 'age' => 22, 'emploument' => false, 'hobby' => 'пиво семечки'),
     'Marie'  => array( 'age' => 18, 'emploument' => true, 'salary' => 5000, 'symbol' => 'Э'),
     'Ruslan' => array( 'age' => 49, 'emploument' => true, 'salary' => 450),
     'Olena'  => array( 'age' => 17, 'emploument' => true, 'salary' => 12000),
 );

 $titles = array(
     'Name' => 'key',
     'Age'  => 'age',
     'Emploument' => 'emploument',
     'Salary'     => 'salary',
     'Expirience' => 'expirience',
     'Hobby'      => 'hobby',
     'Prof'       => 'prof'
 );

 $ageSum = 0;
 $sumEmpl = true;
?>
<table border="1 solid">
    <thead>
     <tr>
<?php
      foreach ($titles as $key => $title)
        echo "<td>$key</td>";
?>
     </tr>
    </thead>
    <tbody>
<?php

 foreach ( $names as $key => $arrValues )
 {
   echo '<tr>';

     foreach ($titles as $title => $field)
     {
        echo '<td>' . <?=( $title == 'Name' ? $key : GetRealValue($arrValues, $field ) ) . '</td>';
     }

     echo '</tr>';

     $ageSum += $arrValues['age'];
     $sumEmpl = $arrValues['emploument'] || $sumEmpl;

 }

?>
    </tbody>
    <tfoot>
        <tr>
            <td>Summa</td> <td><?=$ageSum?></td><td><?=$sumEmpl?></td>
        </tr>

    </tfoot>
</table>
<div>
    <p>Это  учебный пример вывода из скрипта</p>
    <span><?= $ageSum ?> </span>
</div>
