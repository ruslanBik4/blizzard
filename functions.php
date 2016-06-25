<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 25.06.16
 * Time: 10:06
 */

function sampleFunction( $parameter1, $parameter2, $php_eol = '<br>') {

    global $value;

    $result = $parameter1 . ' ' . $php_eol . ' ' . $parameter2;


    return $result;
}

$value = 1;
$commandLine = isCommand();

$text = sampleFunction( 'First parameter', 'second parameter');
$text .= sampleFunction( '3', '4');

$text .= sampleFunction( 'Gkech', 'Bach', ';');

if ($commandLine)
    $text = str_replace('<br>', PHP_EOL, $text);

 str

echo $text;

