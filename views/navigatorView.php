<?php

/**
 * Created by PhpStorm.
 * User: rus
 * Date: 03.09.16
 * Time: 12:38
 */
class navigatorView
{

    private $offset;
    private $countPages = 4;

    public function __construct($offset)
    {
        $this->offset = $offset;
    }

    public function drawNavigator()
    {
        $text = '<script>
    function ToggleDiv(numPage)
    {
          filtr = document.querySelectorAll(".records");
           for (i=0; i< filtr.length; i++) {
               if ( filtr.item(i).id == numPage )
                   filtr.item(i).style.display = "block";
               else
                   filtr.item(i).style.display = "none";
           }
    }
</script>
<nav>';
        for($i=0; $i<$this->countPages;$i++) {
            switch ($i)  {
                case $this->offset:
                case $this->offset + 1:
                    $text .= $this->drawButtonShowDiv($i);
                    break;
                default:
                    $text .= $this->drawButtonHref($i);
            }
        }

        return $text . '</nav>';
    }

    private function drawButtonHref($offset)
    {
        $numPage = $offset + 1;

        return "<input type='button' onclick=\" document.location = 'payments.php?offset=$offset' \" value = '$numPage' />";
    }

    private function drawButtonShowDiv($offset)
    {
        $id = "div$offset";
        $numPage = $offset + 1;

        return "<input type='button' onclick=\"ToggleDiv('$id');\" value = '$numPage' />";
    }
}