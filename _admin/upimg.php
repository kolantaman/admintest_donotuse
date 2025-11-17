<?php
session_start();
//error_reporting(0);
//error_reporting(E_ALL);
//echo "Adminchoice: " . $_GET['adminsection'] . "<br>";
//echo $_SESSION['this_adminarea'];

// Verfübare Admin-Ebenen
require ("plugin/_sections.php");


// Configuration
include ("../_cd/config.php");
include ("_functions.php");



// Wenn Folder übergeben übernehmen, oder zurück zu Admin
if($_GET['folder'] == "")
  {
  header("Location: admin.php");
  }
else
  {
  $gl_folder = $_GET['folder'];
  }

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
  $thumb_path = "../images/dekoration/" . $gl_folder . "/";
  $big_path   = "../images/dekoration/" . $gl_folder . "/big/";

  // Verzeichnis öffnen
  $verz = opendir ($thumb_path);

  while ( $file = readdir ( $verz ) )
    {
    $file_helper =  substr($file, 0, -4) . "_chk";
    $file_value = $$file_helper;
    //echo "Filevalue= " . $_POST[$file_helper] . "<br>";

    //echo $file_helper . " Value= " . $_POST['file_value'] . "<br>";

    if( $_POST[$file_helper] == "1")
      {
      //echo $file_helper . "<br>";
      $del_helper = substr($file, 0, -4) . ".jpg";
      //echo "Del-Helper: " . $del_helper . "<br>";
      unlink($thumb_path . $del_helper);
      unlink($big_path . $del_helper);
      }
    }
//break;
  }


// #####
// --- AUSGABE VORBEREITEN ---
// Array für die Bilder
$gallery_thumbs = array();

// Bildpfad öffnen und auslesen
$thumb_path = "../images/dekoration/" . $gl_folder . "/";
$big_path   = "../images/dekoration/" . $gl_folder . "/big";

//echo "<br>Thumb-Path: " . $thumb_path;
//echo "<br>Full-Path: " . $big_path;

// Verzeichnis öffnen
$verz = opendir ($thumb_path);

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
print "<link rel='stylesheet' type='text/css' href='prettyPhoto.css'>";

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

foreach ( $gallery_thumbs as $value )
  {
  $image_data = getimagesize($thumb_path . "/" . $value);
  $marge      = (150-$image_data[1])/2;

  echo "<div class='outer_box'>
  <div class='img_box'>

  <a href='" . $big_path . "/" . $value . "' rel='prettyPhoto[pp_gal]' title='" . $value . "' class='delimg'>
  <img src='" . $thumb_path . "/" . $value . "' alt='" . $value . "'>
  </a>
  </div>
  <div class='info_box'><input type='checkbox' name='" . substr($value, 0, -4) . "_chk' value='1'>
  &nbsp;l&ouml;schen<br><span>" . substr($value, 0, -4) . "</span></div>
  </div>";
  }

print "</td></tr>";

print "<tr><td align='center' style='background:#ddd;'><br>";
print "<input type='submit' name='submitbutton' value=' absenden... '>";
print "<input type='hidden' name='del_folder' value='" . $gl_folder . "'>";
print "</form>";
print "<br><br></td></tr>";

print"</table><br><br>";
?>

<br>



<?php include "adm_footer.php"; ?>

<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>

<script>
function change(){
    document.getElementById("adminchoice").submit();
}

</script>


<script type="text/javascript" charset="utf-8">
  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto({
    theme: 'dark_rounded', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
    horizontal_padding: 20, /* The padding on each side of the picture */
    social_tools: '',
    });
  });
</script>


</body>
</html>