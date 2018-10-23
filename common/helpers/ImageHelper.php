<?php

namespace common\helpers;

class ImageHelper
{
    public static function crop($resultWidth, $resultHeight, $fileType, $srcFilePath, $destFilePath)
    {
        $result = false;
        $fileAttr = getimagesize($srcFilePath);
        if (!empty($fileAttr)) {
            $width = $fileAttr[0];
            $height = $fileAttr[1];
            $min = min($width, $height);
            if ($min === $width) {
                $ratio = $min / $resultWidth;
            } else {
                $ratio = $min / $resultHeight;
            }
            $newWidth = $width / $ratio;
            $newHeight = $height / $ratio;
            switch ($fileType) {
                case 'image/png':
                    $f = imagecreatefrompng($srcFilePath);
                    break;
                case 'image/jpeg':
                    $f = imagecreatefromjpeg($srcFilePath);
                    break;
            }
            $f = imagescale($f, $newWidth, $newHeight);
            if ($height > $width) {
                $x = 0;
                $y = round($newHeight - $resultHeight);
            } else {
                $x = round(($newWidth - $resultWidth) / 2);
                $y = 0;
            }
            $f = imagecrop($f, ['x' => $x, 'y' => $y, 'width' => $resultWidth, 'height' => $resultHeight]);
            switch ($fileType) {
                case 'image/png':
                    $result = imagepng($f, $destFilePath);
                    break;
                case 'image/jpeg':
                    $result = imagejpeg($f, $destFilePath);
                    break;
            }
        }
        return $result;
    }
}
