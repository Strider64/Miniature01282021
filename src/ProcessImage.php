<?php

namespace Miniature;

class ProcessImage {

    protected static $allowedExts = array("jpg", "jpeg", "gif", "png");
    protected static $allowedTypes = array("image/gif", "image/jpeg", "image/png", "image/pjpeg");
    protected $name;  // Image Name:
    public $newName = \NULL;
    protected $type;  // Image Type:
    protected $extension;   // Image Extension:	
    protected $error = \NULL; // Image Error:
    protected $size;  // Image Size:
    protected $tmpDir;
    protected $tmpName;  // Image Temporary Name:
    protected $preExt = \NULL;
    protected $thumb = 'assets/thumbnails/thumb-';
    protected $large = 'assets/large/img-';
    protected $unique = \NULL;
    protected $myDate = \NULL;
    protected $exifData = \NULL;
    protected $orientation = \NULL;
    protected $img = \NULL;
    protected $deg = \NULL;
    public $imgSize = 'exact';
    public $username = \NULL;
    public $file = \NULL;
    public $status = \NULL;

    /*
     * 
     */

    public function __construct($file = \NULL, $username = "Strider", $picture = true) {
        //echo '<pre>' . print_r($file, 1) . "</pre>";
        $this->file = $file;
        $this->username = $username;
        if ($picture) {
            $this->preExt = $this->large;
        } else {
            $this->preExt = $this->thumb;
        }
        //echo $this->preExt . "<br>";
    }

    public function image($file = \NULL, $username = 'Strider', $picture = false) {
        //echo '<pre>' . print_r($file, 1) . "</pre>";
        self::__construct($file, $username, $picture);
    }

    protected function setImageExt() {
        return pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }

    /*
     * Searches the contents of a file for a PHP embed tag
     * The problem with this check is that file_get_contents() reads 
     * the entire file into memory and then searches it (large, slow).
     * Using fopen/fread might have better performance on large files.
     */

    protected function file_contains_php() {
        $contents = file_get_contents($this->file['tmp_name']);
        $position = strpos($contents, '<?php');
        return $position !== false;
    }

    public function processImage() {
        $this->status = false;

        if ($this->status) {
            return $this->status; // Bad Image
        } else {
            $this->extension = $this->setImageExt(); // Set Extension if Image is valid:
            return $this->status; // Good Image
        }
    }

    public function checkFileType() {
        if (!in_array($this->file['type'], self::$allowedTypes)) {
            $this->status = TRUE; // Improper Image Type
        } else {
            $this->status = FALSE;
        }
        return $this->status;
    }

    public function checkFileExt() {
        if (!in_array($this->extension, self::$allowedExts)) {
            $this->status = TRUE; // Improper Image Extension:
        } else {
            $this->status = FALSE;
        }
        return $this->status;
    }

    public function checkFileSize() {
        $this->size = $this->file['size'];
        if ($this->size >30000000) {
            $this->status = TRUE; // Failed image size:
        }
    }

    /*
     * If image passes validation then name the file and move the image to assets/uploads
     */

    protected function uniqueName() {
        $this->myDate = new \DateTime("NOW", new \DateTimeZone("America/Detroit"));
        return $this->username . $this->myDate->format("U") . ".";
    }

    protected function getTMPName() {
        return $this->file['tmp_name'];
    }

    public function checkOrientation() {
        if (isset($this->exifData['Orientation'])) {
            $this->orientation = $this->exifData['Orientation'];
            if ($this->orientation != 1) {
                $this->imgSize = 'portrait';
                return $this->imgSize;
            } else {
                return $this->imgSize;
            }
        } else {
            return $this->imgSize;
        }
    }

    protected function orientation() {

        $this->orientation = $this->exifData['Orientation'];
        if ($this->orientation != 1) {
            $this->img = imagecreatefromjpeg($this->newName);
            $this->deg = 0;
            switch ($this->orientation) {
                case 3:
                    $this->deg = 180;
                    break;
                case 6:
                    $this->deg = 270;
                    break;
                case 8:
                    $this->deg = 90;
                    break;
            }
            if ($this->deg) {
                $this->img = imagerotate($this->img, $this->deg, 0);
            }
            // then rewrite the rotated image back to the disk as $this->newName
            imagejpeg($this->img, $this->newName, 95);
        } // if there is some rotation necessary        
    }

    private function imgOrientation() {
        if (function_exists('exif_read_data')) {
            $this->exifData = exif_read_data($this->newName);
            if ($this->exifData && isset($this->exifData['Orientation'])) {
                $this->orientation();
            } // if have the exif orientation info
        } // if function exists         
    }

    public function saveIMG() {
        $this->unique = $this->uniqueName();
        $this->tmpName = $this->getTMPName();
        $this->newName = strtolower($this->preExt . $this->unique . $this->extension);
        $this->imgOrientation();
        if (!$this->file['error']) {
            move_uploaded_file($this->tmpName, $this->newName);
            return $this->newName;
        }
    }

}
