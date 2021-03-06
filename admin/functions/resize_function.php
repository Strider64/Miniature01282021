<?php


function imageResize($imageSrc, $imageWidth, $imageHeight, $newImageWidth, $newImageHeight): GdImage|bool
{
    $newImageLayer = imagecreatetruecolor($newImageWidth, $newImageHeight);
    imagecopyresampled($newImageLayer, $imageSrc, 0, 0, 0, 0, $newImageWidth, $newImageHeight, $imageWidth, $imageHeight);

    return $newImageLayer;
}

function resize($file_temp, $new_file_name, $thumb = false): bool
{
    $sourceProperties = getimagesize($file_temp); // Get image sizes:

    /*
     * Determine if it's a thumbnail or large image then
     * resize the images accordingly.
     */
    $old_width = $sourceProperties[0];
    $old_height = $sourceProperties[1];

    $new_height = null;

    $new_width = 1200;
    $newImageHeight = ($new_width * $old_height) / $old_width;
    $newImageWidth = $new_width;


    $temp = '../' . $new_file_name; // folder is nested one down from root:

    $imageType = $sourceProperties[2];// Determine what type of image (png, jpg or gif):

    /*
     * Use Switch statement to resize the image and save it to the correct folders
     */
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
    return true; // Return true to signal that image was resized:
}
