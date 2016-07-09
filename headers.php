<?php
function isUser() {

    $psw = array(
        'admin'     => '12345',
        'moderator' => 'qwerty',
        'user'      => '',
    );

    if (
        !isset($_SERVER['PHP_AUTH_USER'])
        || ($psw[ $_SERVER['PHP_AUTH_USER'] ] != $_SERVER['PHP_AUTH_PW'])
    )
        return false;

    if (!isset($_COOKIE['userName']) || ($_COOKIE['userName'] != $_SERVER['PHP_AUTH_USER']) ) {

        setcookie('userName', $_SERVER['PHP_AUTH_USER'], time() + 60);

    }

    $firstLogin = $_COOKIE['notLogin'];

    setcookie('notLogin', 0 );

    return ($firstLogin || isset($_COOKIE['userName']));
}

//header('Cache-Control: max-age=300, public'); // HTTP/1.1
//header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

iF ( !isUser() )
{
    header('WWW-Authenticate: Basic realm="SHOW task"');
    header('HTTP/1.0 401 Unauthorized');
    setcookie('notLogin', 1 );
    exit(-1);
}


header('Content-Type: text/html; charset=utf-8');

echo "Hello, ". $_SERVER['PHP_AUTH_USER'] . '<br> значение в куках = ' . ( $_COOKIE['userName'] ? : 'нет') . '<br>';

foreach($_SERVER as $key => $value)
    echo "$key = $value <br>";
?>

<span>Проверка кодировки - новый текст</span>
