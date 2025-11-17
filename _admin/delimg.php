<?php
session_start();
error_reporting(0);
//error_reporting(E_ALL);
//echo "Adminchoice: " . $_GET['adminsection'] . "<br>";
//echo $_SESSION['this_adminarea'];


// Configuration
include ("../_cd/config.php");
include ("_functions.php");

$gl_folder = $_GET['sb'];
$table = "galleryimages";

//echo "<br>Folder: " . $gl_folder;
?>


<!DOCTYPE html>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta charset="utf-8">

<title>Administration</title>
<base target="_self">
<link rel='stylesheet' type='text/css' href='style.css'>

<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
</head>

<body style="background:#f7f7f7;margin:0;padding:0;">



<?php
//echo "Submitbutton: " . $_POST['submitbutton'] . "<br>";

// #####
// Bilder löschen, wenn gewählt
if ($_POST['submitbutton'] != "")
  {
  $gl_folder = $_POST['del_folder'];
  //echo "My Folder: " . $gl_folder . "<br>";

  // Bildpfad öffnen und auslesen
  $small_path = "../images/dekoration/" . $gl_folder . "/";
  $big_path   = "../images/dekoration/" . $gl_folder . "/big/";

  //echo "small path: " . $small_path . "<br>";
  //echo "big path: " . $big_path . "<br>";

  //$thumb_path = "../images/" . $gl_folder . "/thumbnail/";
  // Verzeichnis öffnen
  $verz = opendir ($small_path);

  while ( $file = readdir ( $verz ) )
    {
    //$file_helper =  substr($file, 0, -4) . "_chk";
    $file = urldecode($file);
    //echo "<br>file: " . $file;
    $file_helper =  substr($file, 0, -4) . "_chk";
    //echo "<br>file_helper: " . $file_helper;
    $file_value = $$file_helper;
    //echo "Filevalue= " . $_POST[$file_helper] . "<br>";

    //echo $file_helper . " Value= " . $_POST['file_value'] . "<br>";

    if( $_POST[urlencode($file_helper)] == "1")
      {
      //echo $file_helper . "<br>";
      $del_helper = substr($file, 0, -4) . ".jpg";
      //echo "Del-Helper: " . $del_helper . "<br>";
      unlink($small_path . $del_helper);
      unlink($big_path . $del_helper);

      // delete fom DB
      $conn = mysqli_connect($host,$username,$password,$database);
      // Check connection
      if (mysqli_connect_errno()){
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          die();
      }

      $del_sql = "DELETE FROM $table WHERE category = '" . $gl_folder . "' AND imagename = '" . $file . "'";
//echo "<br>" . $del_sql;
      $result = mysqli_query($conn,$del_sql);
      }
    }
//break;
  }


// #####
// --- AUSGABE VORBEREITEN ---
// Array für die Bilder
$gallery_thumbs = array();

// Bildpfad öffnen und auslesen
$small_path = "../images/dekoration/" . $gl_folder . "";
$big_path   = "../images/dekoration/" . $gl_folder . "/big";

//echo "<br>Thumb-Path: " . $small_path;
//echo "<br>Full-Path: " . $big_path;

// Verzeichnis öffnen
$verz = opendir ($small_path);

while ( $file = readdir ( $verz ) )
  {
  if( strtolower(substr($file, -3)) == "jpg")
    {
    //echo strtolower(substr($file, -3)) . "<br>";
    array_push ( $gallery_thumbs, $file );
    }
  }
sort($gallery_thumbs);

//print_r($gallery_thumbs);


print "<meta NAME='author' CONTENT='&copy;2002 carpe diem! Werbeagentur - www.carpediem.at'>\n";
print "<meta NAME='author' CONTENT='Alle Rechte vorbehalten'>\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n";
print "<html>";
print "<head>";
print "<title>Administration</title>";
print "<link rel='stylesheet' type='text/css' href='style.css'>";

print "</head>";
print "<body>";

// Tabellenbeginn ausgeben
print "<br><br>";
print "<table width='1030' bgcolor='#F7F7FF' border='0' cellspacing='0' cellpadding='2' align='center' class='tableborder'>";

// &Uuml;berschrift
print "<tr><td class='tablehead'>";
print "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td class='tablehead'>";
print "&nbsp;<a href='admin.php' class='tablehead'>Administration</a>&nbsp;-&nbsp;Galerie betrachten/Bilder l&ouml;schen</td>";
print "<td align='right' class='tablehead'>&nbsp;</td></tr></table>";
print "</td></tr>";

print "<tr><td style='background:#ddd;'>&nbsp;</td></tr>";

print "<tr><td style='background:#ddd;'>";

print "<form name='viewgal' method='POST'>";

//echo "Count: " . count($gallery_thumbs);

if(count($gallery_thumbs) > 0)
  {

foreach ( $gallery_thumbs as $value )
  {
  $image_data = getimagesize($thumb_path . "/" . $value);
  $marge      = (150-$image_data[1])/2;

  $encoded_filename = urlencode(substr($value, 0, -4) . "_chk");
  //echo "<br>" . $encoded_filename;

  echo "<div class='outer_box'>
  <div class='img_box'>

  <a href='" . $big_path . "/" . $value . "' title='" . $value . "' class='delimg'>
  <img src='" . $small_path . "/" . $value . "' alt='" . $value . "'>
  </a>
  </div>
  <div class='info_box'><input type='checkbox' name='" . $encoded_filename . "' value='1'>
  &nbsp;l&ouml;schen<br><span>" . substr($value, 0, -4) . "</span></div>
  </div>";
  }

  }
else
  {
  echo "Keine Bilder in dieser Galerie";
  }

print "</td></tr>";

print "<tr><td align='center' style='background:#ddd;'><br>";
print "<input type='submit' name='submitbutton' value=' Ausgew&auml;hlte L&Ouml;SCHEN ... '>";
print "<input type='hidden' name='del_folder' value='" . $gl_folder . "'>";
print "</form>";
print "<br><br></td></tr>";

print"</table><br><br>";
?>

<br>
<center><p><a onClick="self.close();">Wenn fertig, Fenster schlie&szlig;en</a></p></center>


<?php include "adm_footer.php"; ?>



</body>
</html>