<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 09.07.16
 * Time: 13:33
 */

function ShowImages($path) {
    
    $fimages = glob($path . '/*.{jpg,jpeg,png}', GLOB_BRACE);
    foreach($fimages as $filename)
    {
        ?>
        <img src='<?=$filename?>' style='max-width:250px'/>
        <form action="del_image.php">
            <input type="hidden" name="filename" value="<?=$filename?>" />
            <input type="submit" value="Удалить картинку" />
        </form>
     <?php
    }
}
include_once 'headers.php';


switch ($_SERVER['PHP_AUTH_USER']) {
    case 'admin' :
        echo 'Admin доступ';
        break;
    case 'moderator':
        echo 'moderator доступ';
        ShowImages('img'); 
        break;
    case 'user' :
        echo 'user доступ';
        break;
    default:
        echo 'Not autorize';
}