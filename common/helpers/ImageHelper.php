<?php

namespace common\helpers;

class ImageHelper
{
    public static function crop($width, $height, $scr, $dest)
    {
        $im = new \imagick($scr);
        $im->cropThumbnailImage((int)$width, (int)$height);  
        return $im->writeImage($dest);
    }
}
