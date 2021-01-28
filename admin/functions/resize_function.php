<?php


function imageResize($imageSrc, $imageWidth, $imageHeight, $newImageWidth, $newImageHeight): GdImage|bool
{
    $newImageLayer = imagecreatetruecolor($newImageWidth, $newImageHeight);
    imagecopyresampled($newImageLayer, $imageSrc, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $imageWidth, $imageHeight);

    return $newImageLayer;
}

function resize($file_temp, $new_file_name): bool
{
    $sourceProperties = getimagesize($file_temp);
    $newImageWidth =  $sourceProperties[0] * .20;
    $newImageHeight = $sourceProperties[1] * .20;
    $temp = '../' . $new_file_name;

    $imageType = $sourceProperties[2];
    switch ($imageType) {

        case IMAGETYPE_PNG:
            $imageSrc = imagecreatefrompng($file_temp);
            $tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
            imagepng($tmp, $temp);
            break;

        case IMAGETYPE_JPEG:
            $imageSrc = imagecreatefromjpeg($file_temp);

            $tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);

            imagejpeg($tmp, $temp);
            break;

        case IMAGETYPE_GIF:
            $imageSrc = imagecreatefromgif($file_temp);
            $tmp = imageResize($imageSrc, $sourceProperties[0], $sourceProperties[1], $newImageWidth, $newImageHeight);
            imagegif($tmp, $temp);
            break;

        default:
            echo "Invalid Image type.";
            exit;
    }
    return true;
}
