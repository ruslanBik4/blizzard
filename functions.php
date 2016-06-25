<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 25.06.16
 * Time: 10:06
 */

function PHP_EOL() {
    return '<br>';
}
function sampleFunction( $parameter1, $parameter2, $php_eol = ' = ') {


    $result = $parameter1 . ' ' . $php_eol . ' ' . $parameter2 . PHP_EOL();


    return $result;
}

function replaceText($text) {

    $search   = [ '</tr>', '</td>', '<tr>', '<td>', '<br>'];
    $replaces = [ PHP_EOL, ',', '', '', '', ''];

//    if (preg_match_all('/<td>([^<]+?)<\/td>/', $text, $arrMatch))
//        foreach($arrMatch as $key => $value)
//            if (is_array($value))
//                var_dump($value);
//else
//            echo "$key = $value";
//        echo 'Есть таблица с границей<br>';

    if (php_sapi_name() == "cli")
        if ($result = preg_replace( '/<td>(([\s\S]+?)|(<i>[\s\S]+<\/i>)?)<\/td>/', '$1 ', $text))
            return $result;
            else
                return 'Error';

//            str_replace($search, $replaces, $text);
    else
        return $text;
}
function PrintTD($text) {
    if (preg_match('/[bi\d]/', $text))
        $text = "<i>$text</i>";

    return "<td>$text</td>";
}
function printArrayToTable($arrNames, $root = true) {

    $text = $root ? '<table  border="13"><thead><tr>'. PrintTD('Position') : '';
    $data = '';

    if ($root)
        foreach ($arrNames['bas'] as $key => $value)
            $text .= PrintTD($key);

    foreach ($arrNames as $key => $value) {
        if (is_array($value))
            $data .= "<tr>" . PrintTD($key) . printArrayToTable($value, false). "</tr>";
        else
            $data .= PrintTD($value);
    }

   return $root ? "$text</tr></thead><tr>$data</tr></table>" : $data;
}

$value = 1;
$commandLine = true;

$text = sampleFunction( 'First parameter', 'second parameter');
$text .= sampleFunction( '3', '4');

$text .= sampleFunction( 'Gkech', 'Bach', ';');

 $arrNames  = array (
     'producer' => ['Имя' => 'Martin', 'Возраст' => 45, 'Стаж' => 5],
     'bas' => [ 'Имя' => 'Ivan', 'Возраст' => 43, 'Стаж' => 4],
     'lider' => ['Имя' => 'Jon', 'Возраст' => 23, 'Стаж' => 2],
 );

$keys = array_keys($arrNames);

array_multisort($arrNames, $keys);

$text = printArrayToTable($arrNames);

echo replaceText($text);

