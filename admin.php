<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 09.07.16
 * Time: 13:33
 */

include_once 'headers.php';


switch ($_SERVER['PHP_AUTH_USER']) {
    case 'admin' :
        echo 'Admin доступ';
        break;
    case 'moderator':
        echo 'moderator доступ';
        break;
    case 'user' :
        echo 'user доступ';
        break;
    default:
        echo 'Not autorize';
}