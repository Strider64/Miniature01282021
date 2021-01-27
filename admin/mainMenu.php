<?php
require_once "../assets/config/config.php";
require_once "../vendor/autoload.php";
use Miniature\CMS;

define('IMAGE_WIDTH', 2048);
define('IMAGE_HEIGHT', 1365);

if (isset($_POST['submit'], $_FILES['image'])) {
    $data = $_POST['cms'];
    $errors= array();
    $exif_data = [];
    $file_name = $_FILES['image']['name'];
    $file_size =$_FILES['image']['size'];
    $file_tmp =$_FILES['image']['tmp_name'];
    $file_type=$_FILES['image']['type'];
    $file_ext=pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);



    if ($file_ext === 'jpeg' || $file_ext === 'jpg') {
        $exif_data = @exif_read_data($file_tmp);
        //echo "<pre>" . print_r($exif_data, 1) . "</pre>";
        //die();
        if (array_key_exists('Make', $exif_data) && array_key_exists('Model', $exif_data)) {
            $data['Model'] = $exif_data['Make'] . ' ' . $exif_data['Model'];
        }

        if (array_key_exists('ExposureTime', $exif_data)) {
            $data['ExposureTime'] = $exif_data['ExposureTime'] . "s";
        }

        if (array_key_exists('ApertureFNumber', $exif_data['COMPUTED'])) {
            $data['Aperture'] = $exif_data['COMPUTED']['ApertureFNumber'];
        }

        if (array_key_exists('ISOSpeedRatings', $exif_data)) {
            $data['ISO'] = "ISO " . $exif_data['ISOSpeedRatings'];
        }

        if (array_key_exists('FocalLengthIn35mmFilm', $exif_data)) {
            $data['FocalLength'] = $exif_data['FocalLengthIn35mmFilm'] . "mm";
        }




    } else {
        $data['Model'] = "Sony Alpha Camera";
        $data['ExposureTime'] = "NA";
        $data['Aperture'] = "NA";
        $data['ISO'] = "NA";
        $data['FocalLength'] = "NA";
    }
    $extensions= array("jpeg","jpg","png");

    if(in_array($file_ext, $extensions, true) === false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }

    if($file_size >= 29360128){
        $errors[]='File size must be less than or equal to 28 MB';
    }


    $data['thumb_path'] = "../assets/thumbnails";
    $data['image_path'] = "../assets/uploads/" . $file_name;


    if(empty($errors) === true){
        move_uploaded_file($file_tmp, "../assets/uploads/" . $file_name);
        /* Save to Database Table CMS */
        $cms = new CMS($data);
        $result = $cms->create();
    }else{
        print_r($errors);
    }
} // Submit

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Post</title>
    <link rel="stylesheet" href="../assets/css/stylesheet.css">
</head>
<body class="site">
<section class="mainArea">
    <header class="headerStyle">
        <img src="../assets/images/img-header-red-tailed-hawk-001.jpg" alt="Red-tailed Hawk">
    </header>
    <nav class="navigation">
        <ul class="topNav">
            <li><a href="mainMenu.php">menu</a></li>
            <li><a href="#">edit</a></li>
            <li><a href="#">delete</a></li>
            <li><a href="logout.php">logout</a> </li>
        </ul>
    </nav>
    <aside class="sidebar">
    </aside>
    <main id="content" class="mainStyle">
        <div class="twoBoxes">
            <div class="box">
                <form class="formGrid" action="mainMenu.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="cms[user_id]" value="3">
                    <input type="hidden" name="cms[author]" value="John Pepp">
                    <input type="hidden" name="action" value="upload">
                    <input class="image-upload" type="file" name="image">
                    <label class="headingLabel" for="heading">Heading</label>
                    <input class="enterHeading" id="heading" type="text" name="cms[heading]" value="" tabindex="1" required autofocus>
                    <label class="textLabel" for="content">Content</label>
                    <textarea class="contentTextarea" id="content" name="cms[content]" tabindex="2"></textarea>
                    <button class="myButton" type="submit" name="submit" value="enter">submit</button>
                </form>
            </div>
            <div class="box dkBlueGray"></div>
        </div>
    </main>
    <div class="contentContainer">

    </div>

    <footer class="footerStyle">
        <p>&copy; <?php echo date("Y") ?> The Miniature Photographer</p>
    </footer>
</section>

</body>
</html>
