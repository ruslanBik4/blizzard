<?php
/**
 * Created by PhpStorm.
 * User: rus
 * Date: 09.07.16
 * Time: 12:49
 */
function OutputImage($src) {
    global $fileType;

    switch ($fileType) {

        case IMAGETYPE_JPEG :
            header("Content-type: image/jpg");
            imagejpeg($src);
            break;
        case IMAGETYPE_PNG :
            header("Content-type: image/png");
            imagepng($src);
            break;
        default:
            header("Content-type: image/jpg");
            imagejpeg($src);
    }
}


$fileType = IMAGETYPE_JPEG;

$filename = $_GET['imagename'];

if (file_exists($filename))
    $src   = imagecreatefromjpeg($filename);
else
    $src   = imagecreatefromjpeg('no_photo.jpg');
    
OutputImage($src);
