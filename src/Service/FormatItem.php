<?php
namespace App\Service;

class FormatItem
{
    // get trickImage or trickVideos and convert in JS Array
    static public function TabJSFormat($trickItems)
    {
        $TabJS = "";
        foreach ($trickItems as $item) {
            if (!empty($TabJS)) {
                $TabJS .= ', ';
            }
            $TabJS .= "'".$item->getLink()."'";
        }
        $TabJS = '[ ' . $TabJS . ' ]';
        return $TabJS;
    }
}
