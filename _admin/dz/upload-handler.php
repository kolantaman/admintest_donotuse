<?php
  require_once("../_functions.php");
  //echo "<br>subfolder: " . $_GET['subfolder'] . "<br>";
  $subfolder = $_GET['subfolder'];
// Check if the form data was sent
if (!empty($_FILES)) {

  // Store the uploaded image file
  $file = $_FILES['file'];
  $file_name = $file['name'];
  $file_tmp = $file['tmp_name'];

  // Load the original image
  $original_image = imagecreatefromjpeg($file_tmp);

  // Get the original image dimensions
  $original_width = imagesx($original_image);
  $original_height = imagesy($original_image);

  // Calculate the aspect ratio of the original image
  $aspect_ratio = $original_width / $original_height;

  // Calculate the dimensions of the big image
  $big_width = 1200;
  $big_height = $big_width / $aspect_ratio;

  // Create the big image
  $big_image = imagecreatetruecolor($big_width, $big_height);
  imagecopyresampled($big_image, $original_image, 0, 0, 0, 0, $big_width, $big_height, $original_width, $original_height);

  // Save the big image
  $big_image_path = '../../images/dekoration/' . $subfolder . '/big/' . ConvertFilename($file_name);
  imagejpeg($big_image, $big_image_path, 65);

  // Calculate the dimensions of the thumbnail
  $thumb_width = 450;
  $thumb_height = $thumb_width / $aspect_ratio;

  // Create the thumbnail
  $thumb_image = imagecreatetruecolor($thumb_width, $thumb_height);
  imagecopyresampled($thumb_image, $original_image, 0, 0, 0, 0, $thumb_width, $thumb_height, $original_width, $original_height);

  // Save the thumbnail
  $thumb_image_path = '../../images/dekoration/' . $subfolder . '/' . ConvertFilename($file_name);
  imagejpeg($thumb_image, $thumb_image_path, 65);

  // Write DB
  require_once("../../_cd/config.php");
  $table_used = "galleryimages";
  // Datenbank öffnen
  ($GLOBALS["___mysqli_ston"] = mysqli_connect($host,  $username,  $password)) or die(mysqli_error($GLOBALS["___mysqli_ston"])) or die("Can't connect");
  mysqli_select_db($GLOBALS["___mysqli_ston"], $database) or die(mysqli_error($GLOBALS["___mysqli_ston"])) or die("Can't select");

  $sql="INSERT INTO $table_used (category, imagename) VALUES ('" . $subfolder . "', '" . ConvertFilename($file_name) . "')";
echo $sql;
  $result = mysqli_query($GLOBALS["___mysqli_ston"], $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));


  // Free memory
  imagedestroy($original_image);
  imagedestroy($big_image);
  imagedestroy($thumb_image);
}

?>
