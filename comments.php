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

function GetRealValue($arrValues, $field, $color)
{
    if ( !isset($arrValues[$field]) )
        return '<span style="color:red">-</span>';

    switch ($field) {
        case 'emploument':
            $text = GetStringEmploument($arrValues[$field]);
            $param= $arrValues[$field];
            break;
        case 'salary':
            $param =  isset($arrValues['symbol']) ?  $arrValues['symbol'] : 'UAH ';
            $text  =  $param . $arrValues[$field];
            break;
        case 'age':
            $param = $arrValues[$field];
            $text  = $arrValues[$field] . ' лет';
            break;
        default:
            return $arrValues[$field];
    }

    return $color ? '<span style="color:' . $color($param) . '">' . $text . '</span>' : $text;
}

function GetColorEmp($emploument)
{

    return $emploument ? 'green' : 'red';

}

function GetColorAge($age) {

    return $age < 18 ? 'green' : ($age < 40 ? 'blue' : ($age < 60 ? 'black' : 'red'));

}

function GetColor($symbol) {

    return $symbol == '$' ? 'green' : ($symbol == 'Э' ? 'blue' : 'black');
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
     'Ivan'   => array( 'age' => 22, 'emploument' => false, 'hobby' => 'пиво семечки', 'expirience' => 10,),
     'Marie'  => array( 'age' => 18, 'emploument' => true, 'salary' => 5000, 'symbol' => 'Э', 'expirience' => 11,),
     'Ruslan' => array( 'age' => 49, 'emploument' => true, 'salary' => 450, 'expirience' => 15,),
     'Olena'  => array( 'age' => 17, 'emploument' => true, 'salary' => 12000, 'expirience' => 8,'hobby' => 'мальчики',),
     'Didus'  => array( 'age' => 72, 'emploument' => false, 'expirience' => 12, 'hobby' => 'вино и сыр',)
 );

 $titles = array(
     'Name' => array( 'field' => 'key', 'align' => 'left', ),
     'Age'  => array( 'field' => 'age', 'color' => 'GetColorAge' ),
     'Emploument' => array( 'field' => 'emploument', 'color' => 'GetColorEmp', ),
     'Salary'     => array( 'field' => 'salary', 'align' => 'right', 'color' => 'GetColor'),
     'Expirience' => 'expirience',
     'Hobby'      => 'hobby',
     'Prof'       => 'prof'
 );

 $ageSum = 0;
 $sumEmpl = "";
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

     foreach ($titles as $title => $value)
     {
         $color = '';

         if (is_array($value)) {
            $field = $value['field'];
            $align = isset($value['align']) ? $value['align'] : 'center';
            if (isset($value['color']))
                $color = $value['color'];
        }
        else {
            $field = $value;
            $align = 'center';
        }

        echo "<td align='$align'>" . ( $title == 'Name' ? $key : GetRealValue($arrValues, $field, $color ) ) . '</td>';
     }

     echo '</tr>';

     $ageSum += $arrValues['expirience'];
     $sumEmpl = $sumEmpl . $arrValues['hobby'] . " ";
//     foreach ($arrValues['hobby'] as $hobby=> $hobbyValue) {
//         $sumEmpl = $hobbyValue . " ";
//     }
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
    <span><?= $sumEmpl ?> </span> <br>
    <span><?= $ageSum ?> </span>
</div>
